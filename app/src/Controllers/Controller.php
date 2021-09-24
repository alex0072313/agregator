<?php

namespace Src\Controllers;

use Src\Services\Db;
use Src\Views\View;

abstract class Controller
{
    /**
     * @var $view
     */
    protected $view;

    /**
     * @var \mysqli connection
     */
    protected $db;

    /**
     * Создаем экземпляр шаблонизатора
     */
    public function __construct()
    {
        $this->view = new View(config('views')['template_dir']);
        $this->db = Db::getInstance()->getConnection();
    }
}
