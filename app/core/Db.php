<?php

namespace app\core;

use PDO;

class Db
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] .
                ';port=' . $_ENV['DB_PORT'] .
                ';dbname=' . $_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            //отловить ошибки
        } catch (\PDOException $e) {
            View::error_page_with_message($e->getMessage());
        }
    }
}