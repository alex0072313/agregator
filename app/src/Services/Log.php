<?php

namespace Src\Services;

abstract class Log
{
    /**
     * Запись логов в базу
     * @param string|null $message
     * @param string $channel
     */
    public static function save(string $message = null, string $channel = 'error') {
        $db = Db::getInstance()->getConnection();

        $query = $db->prepare('INSERT INTO logs(message, channel) VALUES (?, ?)');
        $query->bind_param('ss', $message, $channel);
        $query->execute();
    }
}
