<?php

namespace Src\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Класс для работы с очередями, Singleton
 */
class Queue
{
    /**
     * @var mixed|null
     */
    private $configs;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var self
     */
    private static $instance;

    /*
    Получаем объект rabbitmq один раз
    @return Instance
    */
    public static function getInstance() {
        if(!self::$instance) { // Еще не было соединения - создаем одно
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->configs = config('queue');

        try {
            $this->connection = new AMQPStreamConnection($this->configs['host'], $this->configs['port'], $this->configs['user'], $this->configs['password']);
            if(!$this->connection->isConnected()){
                throw new \Exception('Соединение не удалось');
            }
        } catch (\Exception $e) {
            Log::save('Ошибка при подключении к механизму очередей: '.$e->getMessage());
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
