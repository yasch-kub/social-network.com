<?php
class Mdb
{
    public static $dbname;
    public static function GetConnection()
    {
        self::$dbname = 'social-network';
        $db = new MongoClient('mongodb://user:d32lVrQg9lhh@ds047335.mongolab.com:47335/social-network');
        return $db;
    }
}