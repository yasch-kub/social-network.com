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
            'password' => sha1(md5($password)),
            'avatar' => ['../avatar.jpg'],
            'wall' => [],
            'photos' => [],
            'followers' => [],
            'information' => []
        ]);


        if ($result['ok'] == 1) {
            mkdir(root . '/application/data/users/' . $collection->count() . '/');
            mkdir(root . '/application/data/users/' . $collection->count() . '/photos/');
        }

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

    public static function getInfo($id){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne(
            [
                '_id' => intval($id)
            ],
            [
                'name' => true,
                'surname' => true,
                'info' => true,
                'avatar' => ['$slice' => -1],
                'photos' => ['$slice' => 4],
                'information' => true
            ]);
        return $result;
    }

    public static function getPosts($id)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne(
            [
                '_id' => intval($id)
            ],
            [
                'wall' => true,
            ]);
        $posts = [];
        foreach ($result['wall'] as $item){
            $author = $collection->findOne(
                [
                    '_id' => intval($item['author'])
                ],
                [
                    'name' => true,
                    'surname' => true,
                    'avatar' => ['$slice' => -1]
                ]);

            $posts[]=[
                'name' => $author['name'],
                'surname' => $author['surname'],
                'avatar' => $author['avatar'],
                'message' => $item['message'],
                'date' => $item['date'],
                'id' => $item['author']
            ];
        }
        return($posts);
    }

    public static function changeAvatar($name){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => self::getUserId()
        ],
        ['$push' => ['avatar' => $name]]);
    }

    public static function getAuthorPostInfoById($id)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne([
            '_id' => intval($id)
             ],
            [
                'name' => true,
                'surname' => true,
                'avatar' => ['$slice' => -1]
        ]);
        return($result);
    }

    public static function addPost($message, $userId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $date = getdate();
        $date = sprintf("%s %s %s in %s:%s" ,$date['mday'], $date['month'], $date['year'], $date['hours'], $date['minutes']);
        $collection->update([
                '_id' => intval($userId)
            ],
            [
            '$push' => ['wall' =>
                [
                    'author' => self::getUserId(),
                    'date' => $date,
                    'message' => $message,
                    'comments' => [],
                    'like' => []
                ]
            ]
        ]);

        $author = self::getAuthorPostInfoById(self::getUserId());
        return([
            'date' => $date,
            'message' => $message,
            'name' => $author['name'],
            'surname' => $author['surname'],
            'id' => self::getUserId(),
            'avatar' => $author['avatar']
        ]);

    }

    public static function getPhotosByNum($id, $num, $direction)
    {
        $nPhoto = 4;
        if ($direction == 'left'){
            if ($num <= 1)
                return false;
            elseif ($num <= 4){
                $nPhoto = $num - 1;
                $num = 0;
            }
        }

        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $result = $collection->findOne([
            '_id' => intval($id)
        ],
        [
            'photos' => ['$slice' => [$num, $nPhoto]],
            "_id" => false,
            "name" => false,
            "surname" => false,
            "email" => false,
            "password" => false,
            "avatar" => false,
            "wall" => false

        ]);
        return $result;
    }

    public static function getAllPhotos($id)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne([
            '_id' => intval($id)
        ],
        [
            'photos' => true
        ]);
        return $result;
    }

    public static function addInformation($info, $value){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => self::getUserId()
            ],
            [
                '$push' => ['information' => [$info => $value]]
            ]);
        return $result;
    }
    public static function addPhotos($photos)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => self::getUserId()
            ],
            [
                '$push' => ['photos' => ['$each' =>  $photos]]
            ]);
    }

    public static function addFolowers($follower_id)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result_one = $collection->update([
                '_id' => self::getUserId()
            ],
            [
                '$push' => ['followers' => intval($follower_id)]
            ]);

        $result_two = $collection->update([
            '_id' => intval($follower_id)
            ],
            ['$push' => ['followers' => self::getUserId()]
            ]);

        if( $result_one['ok'] == 1 and $result_two['ok'] == 1)
            return true;
    }

    public static function getFollowers($id)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $followers_id = $collection->findOne([
            '_id' => intval($id)
        ],[
            '_id' => false,
            'followers' => true
        ]);
        return $followers_id['followers'];
    }

    public static function getFollowersInfo($id)
    {
        $followers_id = self::getFollowers($id);
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->find([
           '_id' => ['$in' => $followers_id]
        ],[
           'name' => true,
           'surname' => true,
           'avatar' => ['$slice' => -1]
        ]);
        return $result;
    }
}