<?php
class UserModel
{
    public static function isLogedIn()
    {
        return isset($_SESSION['login']);
    }

    public static function AddUser($fullName, $email, $password)
    {
        $fullName = explode(' ', $fullName);
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->insert([
            '_id' => $collection->count() + 1,
            'name' => $fullName[0],
            'surname' => $fullName[1],
            'email' => $email,
            'password' => sha1(md5($password))
        ]);

        return $result['ok'] == 1 ? true : false;
    }

    public static function Login($email, $password)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne([
            'email' => $email,
            'password' => sha1(md5($password))
        ]);

        return !empty($result) ? true : false;
    }
}