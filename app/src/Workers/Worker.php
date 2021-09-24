<?php

namespace Src\Workers;

use PhpAmqpLib\Message\AMQPMessage;
use Src\Services\Db;
use Src\Services\Queue;
use Src\Workers\Availables\ImportCatalog;

abstract class Worker
{
    /**
     * @var \mysqli
     */
    protected $db;

    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    protected $queue;

    private const AVAILABLE_WORKERS = [
        'import_catalog' => ImportCatalog::class
    ];

    /**
     * Устанавливаем соединение с базой и очередями
     */
    public function __construct()
    {
        $this->db = Db::getInstance()->getConnection();
        $this->queue = Queue::getInstance()->getConnection();
    }

    /**
     * @param string $worker_name - передаем ключ воркера, котрый доступен в self::AVAILABLE_WORKERS
     */
    public static function work(string $worker_name)
    {
        foreach (self::AVAILABLE_WORKERS as $a_worker_name => $a_worker_class) {
            if($a_worker_name != $worker_name) continue;

            //Нашли по ключу в доступных заданиях, передаем задание в очередь...
            return self::dispatch(new $a_worker_class);
        }
    }

    private static function dispatch(IWorker $worker)
    {
        $channel = $worker->queue->channel();

        $channel->queue_declare('hello', false, true, false, false);

        $msg = new AMQPMessage('Hello World!',
            array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
        );
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";

        $channel->close();
    }
}
