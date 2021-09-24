<?php

namespace Src\Controllers;

class HomeController extends Controller
{
    /** Выводит главную страницу
     * @return null
     */
    public function index()
    {
        $test_results = $this->db->query('SELECT * FROM test')->fetch_all(MYSQLI_ASSOC);

        return $this->view->renderHtml('home.php', ['test_results' => $test_results]);
    }
}
