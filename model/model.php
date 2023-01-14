<?php
abstract class Model {
    private static function get_db() {
        $dsn = 'mysql:host=localhost;dbname=web4shop;charset=utf8';
        $username = 'root';
        $password = '';
        try {
            $database = new PDO($dsn, $username);
            //$db = new PDO($dsn, $username, $password);
            return $database;
        } catch (PDOException $e) {
            $error_message = "Database Error: ";
            $error_message .= $e->getMessage();
            include 'view/error.php';
            exit();
        }
    }

    static protected function execute($query) {
        $sth = self::get_db()->prepare($query);
        $sth->execute();
        return $sth;
    }

    static protected function fetchAll($query) {
        $sth = self::get_db()->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    static protected function insert_get_id($query) {
        $db = self::get_db();
        $db->exec($query);
        return $db->lastInsertId();
    }
}