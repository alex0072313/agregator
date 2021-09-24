<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = \Src\Services\Db::getInstance()->getConnection();

// Создаем таблицу для логов
$sql = "CREATE TABLE IF NOT EXISTS logs (
    message VARCHAR(255) DEFAULT NULL,
    channel VARCHAR(60) DEFAULT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($db->query($sql) === true) {
    echo "Таблица для логов успешно создана!";
} else {
    echo "Ошибка при создании таблицы для логов : " . $db->error;
}
//

$db->close();
