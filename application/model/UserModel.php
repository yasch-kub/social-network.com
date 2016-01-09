<?php
class UserModel
{
    public static function isLogedIn()
    {
        return isset($_SESSION['id']);
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


        if ($result['ok'] == 1)
            mkdir(root . '/application/data/users/' . $collection->count() . '/');

        return $result['ok'] == 1 ? true : false;
    }

    public static function Login($email, $password)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne(
        [
            'email' => $email,
            'password' => sha1(md5($password))
        ],
        [
            '_id' => true
        ]);

        return !empty($result) ? $result['_id'] : false;
    }

    public static function getUserId(){
        return $_SESSION['id'];
    }

    public static function getInfo(){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne(
            [
                '_id' => self::getUserId()
            ],
            [
                'name' => true,
                'surname' => true,
                'info' => true,
                'avatar' => ['$slice' => -1]
            ]);

        return $result;
    }

    public static function changeAvatar($name){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => self::getUserId()
        ],
        ['$push' => ['avatar' => $name]]);
    }
}