<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    /** Выводит главную страницу
     * @return null
     */
    public function index()
    {
        return $this->view->renderHtml('home.php');
    }
}
