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

        $message = [
            'senderId' => UserModel::getUserId(),
            'date' => UserModel::getDateString(),
            'text' => $message,
            'timestamp' => time()
        ];

        $collection->update([
            '_id' => intval($chatId)
        ], [
            '$push' => ['messages' => $message]
        ]);

        return $message;
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

    public static function getMessagesByTimestamp($chatId, $timestamp)
    {
        $messages = self::getChatMessages($chatId);
        $timestamp = intval($timestamp);

        $temp = [];

        for($i = 0; $i < count($messages); $i++) {
            if (intval($messages[$i]['timestamp']) > $timestamp) {
                array_unshift($temp, $messages[$i]);
            }
        }

        return $temp;
    }

    public static function findChatByMembers($firstMem, $secondMem)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');

        $result = $collection->findOne([
            'members' => ['$all' => [intval($firstMem), intval($secondMem)]]
        ], [
            '_id' => true
        ]);

        return $result['_id'] == null ? false : $result['_id'];
    }

    public static function createChat($firstMem, $secondMem)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');

        $chatId = $collection->count() + 1;

        $result = $collection->insert([
            '_id' => $chatId,
            'members' => [intval($firstMem), intval($secondMem)],
            'messages' => []
        ]);

        $collection = $db->selectCollection(Mdb::$dbname, 'user');

        $collection->update([
            '_id' => intval($firstMem)
        ],[
            '$push' => ['chats' => $chatId]
        ]);
        $collection->update([
            '_id' => intval($secondMem)
        ],[
            '$push' => ['chats' => $chatId]
        ]);

        return $chatId;
    }

    public static function isUserInChat($chatId, $userId)
    {
        $db = Mdb::GetConnection();
        $collection = $db->selectCollection(Mdb::$dbname, 'chat');

        $result = $collection->findOne([
            '_id' => intval($chatId),
            'members' => ['$all' => [intval($userId)]]
        ], [
            '_id' => true
        ]);

        return empty($result) ? false : true;

    }
}