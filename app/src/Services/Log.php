<?php

namespace Src\Services;

class Log
{
    public static function save(string $message = null, string $channel = 'error') {
        $db = Db::getInstance()->getConnection();

        $query = $db->prepare('INSERT INTO logs(message, channel) VALUES (?, ?)');
        $query->bind_param('ss', $message, $channel);
        $query->execute();
    }
}
