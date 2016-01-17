<?php

class ChatModel
{
    public static function getChatMessages($chatId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');

        $messages = $collection->findOne([
            '_id' => intval($chatId)
        ], [
            'messages' => true
        ]);

        for($i = 0; $i < count($messages['messages']); $i++) {
            $author = UserModel::getAuthorPostInfoById($messages['messages'][$i]['senderId']);
            $messages['messages'][$i]['senderName'] = $author['name'] . ' ' . $author['surname'];
            $messages['messages'][$i]['avatar'] = $author['avatar'];
        }
        return $messages['messages'];
    }

    public static function addMessage($chatId, $message)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');

        $collection->update([
            '_id' => intval($chatId)
        ], [
            '$push' => ['messages' => ['text' => $message, 'senderId' => UserModel::getUserId(), 'date' => UserModel::getDateString(), 'timestamp' => 1]]
        ]);
    }

    public static function getChatMembers($chatId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');
        $result = $collection->findOne([
            '_id' => intval($chatId)
        ], [
            'members' => true
        ]);

        return $result['members'];
    }

    public static function getLastChatMessage($chatId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');
        $result = $collection->findOne([
            '_id' => intval($chatId)
        ], [
            'messages' => ['$slice' => -1],
            '_id' => false,
            'members' => false
        ]);


        return $result['messages'][0];
    }
}