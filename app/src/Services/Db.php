<?php

namespace Src\Services;

/**
 * Класс для работы с базой, Singleton
 */
class Db
{
    /**
     * @var mixed|null
     */
    private $configs;

    /**
     * @var \mysqli
     */
    private $connection;

    /**
     * @var self
     */
    private static $instance;

    /*
    Получаем объект базы данных один раз
    @return Instance
    */
    public static function getInstance() {
        if(!self::$instance) { // Еще не было соединения - создаем одно
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->configs = config('db');

        $this->connection = new \mysqli($this->configs['host'], $this->configs['username'], $this->configs['password'], $this->configs['database']);

        // Если есть ошибка при подключении
        if($connect_error = $this->connection->connect_error) {
            error_log("Ошибка при подключении: " . $connect_error, E_USER_ERROR);
        }
    }

    public function __destruct() {
        if($this->connection) $this->connection->close();
    }

    // Предотвращаем дубликаты соединений
    private function __clone() { }

    // Получаем соединение
    public function getConnection() {
        return $this->connection;
    }
}
