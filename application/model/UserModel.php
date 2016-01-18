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
            'chats' => [],
            'configstyle' => [],
            'lng' => 'eng'
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

    public static function dellInfo($data)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => UserModel::getUserId()
        ],[
            '$pull' => ['information' => [$data['info'] => $data['val']]]
        ]);

        if($result['ok'] == 1)
            return true;
    }

    public static function changeInfo($data)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => UserModel::getUserId()
        ],[
            '$pull' => ['information' => [$data['info'] => $data['prevValue']]]
        ]);

        if($result['ok'] == 1)
        {
            $result = $collection->update([
                '_id' => UserModel::getUserId()
            ],[
                '$push' => ['information' => [$data['info'] => $data['val']]]
            ]);
        }
        else
            return false;

        if($result['ok'] == 1)
            return true;
    }

    public static function delletePhoto($photoName)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => UserModel::getUserId()
        ],[
            '$pull' => ['photos' => $photoName]
        ]);

        return $result['ok'] == 1 ? true : false;
    }

    public static function getUserStyle()
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne([
            '_id' => UserModel::getUserId()
        ],[
            'configstyle' => true
        ]);


        foreach ($result['configstyle'] as $item){
            foreach ($item as $key => $value)
                $style[$key] = $value;
        }
        return $style;
    }

    public static function setUserStyle($style){
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne([
            '_id' => self::getUserId()
        ],
        [
                'configstyle' => true,
                '_id' => false
        ]);

        foreach ($result['configstyle'] as $item) {
            foreach ($item as $key => $value) {
                if (isset($style[$key]))
                    $config[$key] = $style[$key];
                else
                    $config[$key] = $value;
            }
        }

        foreach($style as $key => $value){
            if (!isset($config[$key]))
                $config[$key] = $value;
        }

        foreach ($config as $key => $value) {
            $userStyle[] = [$key => $value];
        }

        $res = $collection->update([
            '_id' => self::getUserId()
        ],
            [
                '$set' =>['configstyle' => $userStyle]
            ]);

        return $res['ok'] == 1 ? true : false;
    }

    public static function revertStyle()
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update([
            '_id' => self::getUserId()
            ],
            [
                '$set' =>['configstyle' => []]
            ]);

        return $result['ok'] == 1 ? true : false;

    }

    public static function getLangArray()
    {
        $lng = self::getLanguage();

        if ($lng == 'eng') {
            return [
                //login//
                'login' => 'Login',
                'email' => 'Email',
                'password' => 'Password',
                'remember' => 'remember',
                'newuser' => 'New user?',
                'createaccount' => 'Create new account',
                //registration//
                'regname' => 'Full name',
                'confirmpass' => 'Confirm password',
                'agree' => 'i agree with terms',
                'haveaccount' => 'Already have an account?',
                'loghere' => 'Login here',
                //menu//
                'home' => 'Home',
                'friends' => 'Friends',
                'messages' => 'Messages',
                'photos' => 'Photos',
                'setting' => 'Account Settings',
                'exit' => 'Exit',
                //page//
                'message' => 'Message',
                'follow' => 'Follow',
                'information' => 'Information',
                'avatardrop' => 'Drop file here',
                'name' => 'Name:',
                'lastname' => 'Lastname:',
                'wall' => 'Wall',
                'leftpost' => 'Left your post here...',
                'post' => 'Post',
                'comment' => 'Comment...',
                'send' => 'Send',
                'gallery' => 'Gallery',
                'drop' => 'Drop photos here to download',
                'bg' => 'background color:',
                'usercolor' => 'user menu color:',
                'userhover' => 'user menu hover color:',
                'useractive' => 'user menu active color:',
                'change' => 'Change',
                'dialogmess' => 'Message...',
                'changeavatar' => 'Change avatar',
                'snapshot' => 'Snapshot',
                'save' => 'Save',
                'settplaceholder' => 'Please enter color (example #fff)',
                'possible' => 'Possible friend',
                'findfriends' => 'Find friends...',
                'val' => 'Value',
                'rules' => 'How to use our network',
                'rules1' => 'Don`t stick your nose in other people`s business!',
                'notfound' => 'User was not found...'
            ];
        }
        elseif ($lng == 'ukr') {
            return [
                //login//
                'login' => 'Вхід',
                'email' => 'Електронна адреса',
                'password' => 'Пароль',
                'remember' => 'запам`ятати',
                'newuser' => 'Новий користувач?',
                'createaccount' => 'Створити новий акаунт',
                //registration//
                'regname' => 'Повне ім`я',
                'confirmpass' => 'Підтвердити пароль',
                'agree' => 'я погоджуюся з правилами',
                'haveaccount' => 'Вже маєш акаунт?',
                'loghere' => 'Перейти на вхід',
                //menu//
                'home' => 'Головна',
                'friends' => 'Друзі',
                'messages' => 'Повідомлення',
                'photos' => 'Фотографії',
                'setting' => 'Налаштування',
                'exit' => 'Вихід',
                //page//
                'message' => 'Повідомлення',
                'follow' => 'Підписатися',
                'information' => 'Інформація',
                'avatardrop' => 'Перетягніть файл сюди',
                'name' => 'І`мя:',
                'lastname' => 'Прізвище:',
                'wall' => 'Стіна',
                'leftpost' => 'Залишіть свій пост тут',
                'post' => 'Відправити',
                'comment' => 'Коментар...',
                'send' => 'Відправити',
                'gallery' => 'Галерея',
                'drop' => 'Перетягніть фото для завантаження',
                'bg' => 'Колір фону',
                'usercolor' => 'Колір меню:',
                'userhover' => 'Колір меню при наведенні:',
                'useractive' => 'Колір меню при кліку:',
                'change' => 'Застосувати',
                'dialogmess' => 'Повідомлення...',
                'changeavatar' => 'Змінити аватар',
                'snapshot' => 'Сфотографувати',
                'save' => 'Зберегти',
                'settplaceholder' => 'Введіть колір (приклад #fff)',
                'possible' => 'Рекомендовані',
                'findfriends' => 'Знайти друзів...',
                'val' => 'Значення',
                'rules' => 'Правила використання нашої мережі',
                'rules1' => 'Не лізь не в своє діло!',
                'notfound' => 'Користувач не знайдений...'
            ];
        }
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

    public static function getLanguage()
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->findOne(
            [
                '_id' => self::getUserId()
            ],
            [
                'lng' => true
            ]);
        return $result['lng'];
    }

    public static function setLanguage($lng)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'user');
        $result = $collection->update(
            [
                '_id' => self::getUserId()
            ],
            [
                '$set' => ['lng' => $lng]
            ]);
    }
}