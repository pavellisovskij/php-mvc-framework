<?php

namespace app\core;

use app\core\interfaces\ModelInterface;

class Model //implements ModelInterface
{
    const FETCH_ALL_METHOD    = 'fetchAll';
    const FETCH_METHOD        = 'fetch';

    private   $get_method   = 'fetchAll';
    protected $db;
    protected $table_name;
    protected $stmt;
    protected $primaryKey   = 'id';
    protected $preparedData = [];
    protected $sql;

    public function __construct()
    {
        $db = new Db();
        $this->db = $db->db;
//        $this->table_name = explode('\\', __CLASS__);
//        $this->table_name = $this->table_name[2];
    }

    public function insert(array $data)
    {
        $preparedArray = $this->prepareArray($data);

        try {
            $this->sql = "INSERT INTO $this->table_name (" . $preparedArray['columns'] . ") VALUES (" . $preparedArray['values'] . ")";
            $stmt = $this->db->prepare($this->sql);

            if ($stmt->execute($this->preparedData) === false) throw new \PDOException($stmt->errorInfo()[2]);
        } catch (\PDOException $e) {
            View::error_page_with_message($e->getMessage());
        }

        return $this->db->lastInsertId();
    }

    public function delete(array $ids) {
        $idsString = implode(', ', $ids);
        $this->sql = "DELETE FROM $this->table_name WHERE $this->primaryKey IN ($idsString)";

        try {
            $stmt = $this->db->prepare($this->sql);

            if ($stmt->execute($this->preparedData) === false) throw new \PDOException($stmt->errorInfo());
        } catch (\PDOException $e) {
            View::error_page_with_message($e->getMessage());
        }

        return $stmt->rowCount();
    }

    public function update(array $data, array $ids = null) {
        $this->sql = "UPDATE $this->table_name SET ";
        $counter = 1;
        $total   = count($data);

        foreach ($data as $column => $value) {
            $this->sql .= $column . '=' . $this->prepareData($value);

            if ($counter !== $total) $this->sql .= ", ";
            $counter++;
        }

        if ($ids !== null) {
            $ids = implode(', ', $ids);
            $this->sql .= " WHERE $this->primaryKey IN ($ids)";
        }

        try {
            $stmt = $this->db->prepare($this->sql);

            if ($stmt->execute($this->preparedData) === false) throw new \PDOException($stmt->errorInfo());
        } catch (\PDOException $e) {
            View::error_page_with_message($e->getMessage());
        }

        return $stmt->rowCount();
    }

//    public static function __callStatic($method, $parameters)
//    {
//        return (new static)->$method(...$parameters);
//    }

    public function query(string $sql, string $fetch_method, array $data = null)
    {
        $this->sql = $sql;
        $this->get_method = $fetch_method;
        if ($data !== null) $this->preparedData = $data;

        return $this->get();
    }

    public function count()
    {
        $this->sql = "SELECT COUNT(*) FROM $this->table_name";
        $this->get_method = $this::FETCH_METHOD;

        return $this->get()['COUNT(*)'];
    }

    public function all()
    {
        $this->sql = "SELECT * FROM $this->table_name";

        return $this;
    }

    public function select(array $columns)
    {
        $columns = implode(', ', $columns);
        $this->sql = "SELECT $columns FROM $this->table_name";

        return $this;
    }

    public function where(string $column, string $operator, string $value)
    {
        $this->issetSql();
        $this->sql .= " WHERE $column $operator " . $this->prepareData($value);

        return $this;
    }

    public function logicalWhere(string $logical_operator, string $column, string $operator, string $value)
    {
        $this->addLogicalOperator($logical_operator);
        $this->sql .= " $column $operator " . $this->prepareData($value);

        return $this;
    }

    public function betweenWhere(string $column, int $min, int $max, string $logical_operator = null)
    {
        if ($logical_operator != null) $this->addLogicalOperator($logical_operator);

        $this->sql .= " $column BETWEEN " . $this->prepareData($min) . " AND " . $this->prepareData($max);

        return $this;
    }

    public function orderBy(array $columns)
    {
        $this->sql .= " ORDER BY ";
        $orderBy = [];

        foreach ($columns as $column) {
            $column[1] = strtoupper($column[1]);

            try {
                if (
                    $this->issetSql() &&
                    in_array($column[1], ['ASC', 'DESC']) === true
                ) $orderBy[] = implode(' ', $column);
                else throw new \Exception('Ошибочный оператор сортировки');
            } catch (\Exception $e) {
                View::error_page_with_message($e->getMessage());
            }
        }

        $orderBy   = implode(', ', $orderBy);
        $this->sql .= $orderBy;

        return $this;
    }

    public function take(int $number, int $offset = null)
    {
        $this->issetSql();
        $this->get_method = $this::FETCH_ALL_METHOD;

        if ($offset !== null) $this->sql .= " LIMIT $number OFFSET $offset";
        else $this->sql .= " LIMIT $number";

        return $this;
    }

    public function first()
    {
        $this->issetSql();
        $this->sql .= " ORDER BY $this->primaryKey ASC LIMIT 1";
        $this->get_method = $this::FETCH_METHOD;

        return $this;
    }

    public function find(...$id)
    {
        $ids        = func_get_args();
        $ids_number = count($ids);
        $ids        = implode(', ', $ids);

        $this->sql  = "SELECT * FROM $this->table_name WHERE $this->primaryKey IN ($ids)";

        if ($ids_number === 1) $this->get_method = $this::FETCH_METHOD;

        return $this;
    }

    public function get()
    {
        if ($this->issetSql()) {
            $this->stmt = $this->db->prepare($this->sql);

            if (!empty($this->preparedData)) $result = $this->stmt->execute($this->preparedData);
            else $result = $this->stmt->execute();

            try {
                if ($result === true) {
                    $method = $this->get_method;

                    return $this->stmt->$method();
                }
                else throw new \PDOException($this->stmt->errorInfo());
            } catch (\PDOException $e) {
                View::error_page_with_message($e->getMessage());
            }
        }
    }

    private function addLogicalOperator(string $logical_operator)
    {
        try {
            $logical_operator = strtoupper($logical_operator);

            if (
                $this->issetSql() &&
                in_array($logical_operator, ['AND', 'OR', 'NOT', 'XOR']) === true
            ) {
                $this->sql .= " $logical_operator";
            } else {
                throw new \Exception('Введен неверный логический оператор');
            }
        } catch (\Exception $e) {
            View::error_page_with_message($e->getMessage());
        }
    }

    private function issetSql()
    {
        try {
            if ($this->sql === '') {
                throw new \Exception('Нарушен порядок построения запроса');
            } else {
                return true;
            }
        } catch (\Exception $e) {
            View::error_page_with_message($e->getMessage());
        }
    }

    private function prepareData($value) {
        $key = ":value" . count($this->preparedData);
        $this->preparedData[$key] = $value;

        return $key;
    }

    private function prepareArray(array $arr) {
        $columns = "";
        $values  = "";
        $counter = 1;
        $total   = count($arr);

        foreach ($arr as $column => $value) {
            if ($counter !== $total) {
                $columns .= "$column, ";
                $values  .= $this->prepareData($value) . ", ";
            }
            else {
                $columns .= $column;
                $values  .= $this->prepareData($value);
            }
            $counter++;
        }

        return [
            'columns' => $columns,
            'values'  => $values
        ];
    }
}