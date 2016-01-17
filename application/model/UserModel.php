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
            'information' => [],
            'chats' => []
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
            $comments = $item['comments'];
            for($i = 0; $i < count($comments); $i++) {
                $author = self::getAuthorPostInfoById($comments[$i]['authorId']);
                $comments[$i]['name'] = $author['name'];
                $comments[$i]['surname'] = $author['surname'];
                $comments[$i]['avatar'] = $author['avatar'];
            }

            $author = self::getAuthorPostInfoById($item['authorId']);

            $posts[]=[
                'id' => $item['id'],
                'name' => $author['name'],
                'surname' => $author['surname'],
                'avatar' => $author['avatar'],
                'message' => $item['message'],
                'date' => $item['date'],
                'authorId' => $item['authorId'],
                'comments' => $comments,
                'likeNumber' => count($item['like']),
                'isLiked' => in_array(self::getUserId(), $item['like'])
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

        $date = self::getDateString();

        $result = $collection->findOne(['_id' => intval($userId)], ['wall' => true, '_id' => false]);
        $postCount = count($result['wall']);

        $collection->update([
                '_id' => intval($userId)
            ],
            [
            '$push' => ['wall' =>
                [
                    'id' => $postCount + 1,
                    'authorId' => self::getUserId(),
                    'date' => $date,
                    'message' => $message,
                    'comments' => [],
                    'like' => []
                ]
            ]
        ]);

        $author = self::getAuthorPostInfoById(self::getUserId());
        return([
            'id' => $postCount + 1,
            'comments' => [],
            'date' => $date,
            'message' => $message,
            'name' => $author['name'],
            'surname' => $author['surname'],
            'authorId' => self::getUserId(),
            'avatar' => $author['avatar']
        ]);

    }

    public static function getPhotosByNum($id, $num, $direction)
    {
        $nPhoto = 4;
        if ($direction == 'left'){
            $num -= 5;
            if ($num <= 1) {
                $nPhoto = $num + 4;
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

    public static function addPostComment($userId, $postId, $comment)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $result = $collection->findOne(['_id' => intval($userId)], ['wall' => true]);

        $comment = ['message' => $comment, 'authorId' => self::getUserId(), 'date' => self::getDateString()];

        for ($i = 0; $i < count($result['wall']); $i++)
            if ($result['wall'][$i]['id'] == $postId) {
                $result['wall'][$i]['comments'][] = $comment;
                $collection->update(['_id' => intval($userId)], ['$set' => ['wall' => $result['wall']]], ['upsert' => true]);
                $author = self::getAuthorPostInfoById(self::getUserId());
                $comment['name'] = $author['name'];
                $comment['surname'] = $author['surname'];
                $comment['avatar'] = $author['avatar'];
                return $comment;
            }
    }

    public static function getChats()
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $result = $collection->findOne([
            '_id' => intval(UserModel::getUserId())
        ], [
            'chats' => true,
            '_id' => false
        ]);

        return $result['chats'];
    }

    public function getDateString()
    {
        $date = getdate();
        $date = sprintf("%s %s %s in %s:%s" ,$date['mday'], $date['month'], $date['year'], $date['hours'], $date['minutes']);

        return $date;
    }

    public static function addPostLike($userId, $postId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $result = $collection->findOne([
            '_id' => intval($userId)
        ],[
            'wall' => true
        ]);

        $nLikes = 0;

        for($i = 0; $i < count($result['wall']); $i++) {
            if ($result['wall'][$i]['id'] == $postId)
            {
                if (in_array(UserModel::getUserId(), $result['wall'][$i]['like']))
                    return false;
                else {
                    $result['wall'][$i]['like'][] = UserModel::getUserId();
                    $nLikes = count($result['wall'][$i]['like']);

                    $collection->update([
                        '_id' => intval($userId)
                    ],[
                        '$set' => ['wall' => $result['wall']]
                    ]);
                }
            }
        }

        return $nLikes;
    }

    public static function findUser($name, $surname, $type = 1)
    {
        $query  = [];
        switch($type) {
            case 1: {
//                $query = [
//                    'name' => $name,
//                    'surname' => $surname
//                ];
                $query = [
                    'name' => ['$regex' => $name, '$options' => 'i'],
                    'surname' => ['$regex' => $surname, '$options' => 'i']
                ];
                break;
            }
        }

        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $users = $collection->find($query, [
            'name' => true,
            'surname' => true,
            'avatar' => ['$slice' => -1],
        ]);

        $result = [];

        foreach($users as $item) {
            $result[] = $item;
        }

        return $result;
    }
}