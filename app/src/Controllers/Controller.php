<?php

namespace Src\Controllers;

use Src\Views\View;

abstract class Controller
{
    /**
     * @var $view
     */
    protected $view;

    /**
     * Создаем экземпляр шаблонизатора
     */
    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Views/templates');
    }
}
