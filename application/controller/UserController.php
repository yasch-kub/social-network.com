<?php
class UserController
{
    public static function ActionView()
    {
        if (UserModel::isLogedIn())
            header('Location: /' . $_SESSION['id']);
        else
            header('Location: ' . '/login');
    }

    public static function ActionLogin()
    {
        $view = 'templates/login.php';
        $links = ['authorization.css'];
        $scripts = ['authorization.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionRegistration()
    {
        $view = 'templates/registration.php';
        $links = ['authorization.css'];
        $scripts = ['authorization.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionAddUser()
    {
        $result = UserModel::AddUser($_POST['reg_fullname'], $_POST['reg_email'], $_POST['reg_password']);
        exit($result);
    }

    public static function ActionSignIn()
    {
        $result = UserModel::Login($_POST['lg_username'], $_POST['lg_password']);
        if ($result) {
            $_SESSION['id'] = $result;
            exit(json_encode(true));
        } else
            exit(json_encode(false));
    }

    public static function ActionProfile($id)
    {
        $menuClass = [0 => 'active', 1 => '', 2 => '', 3 => '', 4 => ''];
        $userStyle = UserModel::getUserStyle();
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/main.php';
        $links = ['userProfile.css', 'webcam.css'];
        $scripts = ['dragAndDropDownload.js', 'addPost.js', 'slider.js', 'addInform.js', 'MediaAPI.js', 'follow.js'];
        $user = UserModel::getInfo($id);
        $posts = UserModel::getPosts($id);

        include_once(view . '/templates/template.php');
    }

    public static function ActionChangeAvatar()
    {
        $path = '/application/data/users/' . UserModel::getUserId() . '/';
        $images = self::fileUpload($path);
        UserModel::changeAvatar($images[0]);
        $images[0] = $path . $images[0];
        exit(json_encode($images));
    }

    public static function ActionAddPhotos()
    {
        $path = '/application/data/users/' . UserModel::getUserId() . '/photos/';
        $images = self::fileUpload($path);
        UserModel::addPhotos($images);
        for ($i = 0; $i < count($images); $i++) {
            $images[$i] = $path . $images[$i];
        }
        exit(json_encode($images));
    }

    public static function ActionAddPost($userId)
    {
        $id = $userId;
        $post = UserModel::addPost(self::clear($_POST['message']), $userId);
        include_once(view . 'templates/post.php');
    }

    public static function ActionGetSlidePhoto()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        exit(json_encode(UserModel::getPhotosByNum($data['id'], $data['num'], $data['direction'])));
    }

    public static function ActionGallery($id)
    {
        $userStyle = UserModel::getUserStyle();
        $menuClass = [0 => '', 1 => '', 2 => '', 3 => 'active', 4 => ''];
        $user = UserModel::getInfo($id);
        $photos = UserModel::getAllPhotos($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/gallery.php';
        $links = ['gallery.css', 'userProfile.css', 'webcam.css'];
        $scripts = ['gallery.js', 'dragAndDropDownload.js', 'MediaAPI.js', 'follow.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionFriends($id)
    {
        $userStyle = UserModel::getUserStyle();
        $menuClass = [0 => '', 1 => 'active', 2 => '', 3 => '', 4 => ''];
        $user = UserModel::getInfo($id);
        $photos = UserModel::getAllPhotos($id);
        $followers = UserModel::getFollowersInfo($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/friends.php';
        $links = ['userProfile.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionAddInfo(){
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        exit(json_encode(UserModel::addInformation($data['info'], $data['value'])));
    }

    public static function ActionAddComment($userId, $postId)
    {
        $comment = self::clear($_POST['comment']);
        $comment = UserModel::addPostComment($userId, $postId, $comment);

        include_once view . 'templates/comment.php';
    }

    public static function clear($value)
    {
        return htmlspecialchars(strip_tags(trim($value)));
    }

    public static function fileUpload($path)
    {
        $images = [];
        foreach ($_FILES['files']['name'] as $index => $name)
            if ($_FILES['files']['error'][$index] == UPLOAD_ERR_OK
                and move_uploaded_file($_FILES['files']['tmp_name'][$index], root . $path . $name)
            ) {
                $images[] = $name;
            }

        return $images;
    }

    public static function actionFollow()
    {
        $follower_id = file_get_contents('php://input');
        if (UserModel::addFolowers($follower_id))
            exit ('ok');
        else
            exit('fail');
    }

    public function actionMessages()
    {
        $userStyle = UserModel::getUserStyle();
        $menuClass = [0 => '', 1 => '', 2 => 'active', 3 => '', 4 => ''];
        $id = UserModel::getUserId();
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/message.php';
        $links = ['userProfile.css', 'messages.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js'];
        $user = UserModel::getInfo($id);
        $chatsIds = UserModel::getChats();

        for($i = 0; $i < count($chatsIds); $i++) {
            $memberId = current(array_diff(ChatModel::getChatMembers($chatsIds[$i]), [UserModel::getUserId()]));
            $member = UserModel::getAuthorPostInfoById($memberId);

            $user['chats'][$i]['id'] = $chatsIds[$i];
            $user['chats'][$i]['memberId'] = $memberId;
            $user['chats'][$i]['memberName'] = $member['name'] . ' ' . $member['surname'];
            $user['chats'][$i]['avatar'] = $member['avatar'][0];

            $message = ChatModel::getLastChatMessage($chatsIds[$i]);
            $message = $message['text'];
            $user['chats'][$i]['lastMessage'] = $message;
        }

       // var_dump($user);

        include_once(view . '/templates/template.php');
    }

    public static function actionDialog($chatId)
    {
        $menuClass = [0 => '', 1 => '', 2 => 'active', 3 => '', 4 => ''];
        $userStyle = UserModel::getUserStyle();
        $id = UserModel::getUserId();
        $user = UserModel::getInfo($id);
        $messages = ChatModel::getChatMessages($chatId);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/dialog.php';
        $links = ['userProfile.css', 'dialog.css'];
        $scripts = ['dragAndDropDownload.js', 'follow.js', 'messager.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionSaveWebCamImage()
    {
        $img = file_get_contents('php://input');
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $dir = root . '/application/data/users/' . UserModel::getUserId() . '/';
        $nFiles = count(scandir($dir)) - 2;
        $name = 'image_' . $nFiles . '.png';
        $file = $dir . $name;
        file_put_contents($file, $data);

        UserModel::changeAvatar($name);
        $path = '/application/data/users/' .UserModel::getUserId(). '/';
        exit(json_encode($path . $name));
    }

    public static function ActionAddMessage($chatId)
    {
        $message = self::clear($_POST['message']);
        ChatModel::AddMessage($chatId, $message);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function ActionDellInfo()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        if(UserModel::dellInfo($data))
            exit('ok');
        else
            exit('failed');
    }

    public static function ActionChangeInfo()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        if(UserModel::changeInfo($data))
            exit('ok');

        exit('failed');

    }

    public static function ActionDellPhotos()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        unlink(root . '/application/data/users/'. UserModel::getUserId() .'/photos/'.$data);
        if(UserModel::delletePhoto($data))
            exit('ok');

        exit('failed');
    }

    public static function ActionAccountSetting(){
        $menuClass = [0 => '', 1 => '', 2 => '', 3 => '', 4 => 'active'];
        $id = UserModel::getUserId();
        $userStyle = UserModel::getUserStyle();
        $user = UserModel::getInfo($id);
        $view = 'templates/userProfile.php';
        $profile_content = 'templates/accountSetting.php';
        $links = ['userProfile.css'];
        $scripts = ['dragAndDropDownload.js', 'accountsetting.js'];
        include_once(view . '/templates/template.php');
    }

    public static function ActionChangeUserStyle()
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        if(UserModel::setUserStyle($data))
            exit('ok');

        exit('failed');
    }

    public static function ActionRevertStyle()
    {
        if(UserModel::revertStyle())
            exit('ok');
        exit('failed');
    }
}