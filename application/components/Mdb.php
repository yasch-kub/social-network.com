<?php
class Mdb
{
    public static $dbname;
    public static function GetConnection()
    {
        $config = include(root . '/application/config/mongo_db_config.php');
        self::$dbname = $config['dbname'];
        $db = new MongoClient("mongodb://" .$config['dbhost']. ":27017/" .$config['dbname']);
        return $db;
    }
}