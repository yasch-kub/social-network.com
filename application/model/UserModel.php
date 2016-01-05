<?php
class UserModel
{
    public static function AddUser($fullName, $email, $password)
    {
        $fullName = explode(' ', $fullName);
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->insert([
            'name' => $fullName[0],
            'surname' => $fullName[1],
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return $result['ok'] == 1 ? true : false;
    }
}