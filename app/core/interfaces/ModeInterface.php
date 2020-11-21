<?php

namespace app\core\interfaces;

interface ModelInterface
{
    public function __construct();

    public function get();

    public function query(string $sql, array $data);

    public function first();

    public function select(array $columns);

    public function all();

    public function where(string $column, string $operator, string $value);

    public function logicalWhere(string $logical_operator, string $column, string $operator, string $value);

    public function betweenWhere(string $column, int $min, int $max, string $logical_operator);

    public function orderBy(array $columns);

    public function take(int $number, bool $withOffset);

    public function find(...$id);
    
    public function insert(array $data);

    public function update(array $data, array $ids);

    public function delete(array $ids);
}