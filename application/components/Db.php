<?php
class Db
{
    /**
     * @return PDO
     */
    public static function getConnection(){
        $config = include(root . '/application/config/db_config.php');
        extract($config);
        $dsn = sprintf("mysql:dbname=%s;host=%s", $name, $host);
        $pdo = new PDO($dsn, $user_name, $password);
        return $pdo;
    }
}