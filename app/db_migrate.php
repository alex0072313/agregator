<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = \Src\Services\Db::getInstance()->getConnection();

// Создаем таблицу для логов
$sql = "CREATE TABLE IF NOT EXISTS `logs` (
    `message` VARCHAR (255) DEFAULT NULL,
    `channel` VARCHAR (60) DEFAULT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
)";

if ($db->query($sql) === true) {
    echo "\nТаблица для логов успешно создана!";
} else {
    echo "\nОшибка при создании таблицы для логов : " . $db->error;
}
//

// Создаем таблицы для каталога - категории
$sql = "CREATE TABLE IF NOT EXISTS `product_categories` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `catalog_id` INT DEFAULT NULL,
    `catalog_parent_id` INT DEFAULT NULL,
    `name` VARCHAR (255) DEFAULT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);";

if ($db->query($sql) === true) {
    echo "\nТаблица для категорий каталога продуктов успешно создана!";
} else {
    echo "\nОшибка при создании таблицы для категорий каталога продуктов : " . $db->error;
}

// Создаем индексы для таблицы категорий продуктов
$sql = "
CREATE INDEX product_categories_catalog_id ON product_categories (catalog_id);
";

if ($db->query($sql) === true) {
    echo "\nИндексы для таблицы категорий продуктов успешно созданы!";
} else {
    echo "\nОшибка при создании индексов для таблицы категорий продуктов: " . $db->error;
}

// Создаем таблицы для каталога - продукты
$sql = "CREATE TABLE IF NOT EXISTS `products` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `catalog_id` INT DEFAULT NULL,
    `catalog_category_id` INT DEFAULT NULL,
    `name` VARCHAR(255) DEFAULT NULL,
    `url` VARCHAR(255) DEFAULT NULL,
    `description` TEXT DEFAULT NULL,
    `price` INT DEFAULT NULL,
    `picture` VARCHAR (255) DEFAULT NULL,
    `delivery` tinyint DEFAULT NULL,
    `local_delivery_cost` INT DEFAULT NULL,
    `available` TINYINT DEFAULT NULL,
    `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);
";

if ($db->query($sql) === true) {
    echo "\nТаблица для каталога продуктов успешно создана!";
} else {
    echo "\nОшибка при создании таблицы для каталога продуктов : " . $db->error;
}

// Создаем индексы для таблицы продуктов
$sql = "
CREATE INDEX products_catalog_id ON products (catalog_id);
";

if ($db->query($sql) === true) {
    echo "\nИндексы для таблицы продуктов успешно созданы!";
} else {
    echo "\nОшибка при создании индексов для таблицы продуктов: " . $db->error;
}

//
