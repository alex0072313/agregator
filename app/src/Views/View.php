<?php

namespace Src\Views;

class View
{
    private string $templatesDir;

    public function __construct(string $templatesDir)
    {
        $this->templatesDir = $templatesDir;
    }

    /** Выводит на экран шаблон страницы
     * @param string $templateName - название файла шаблона
     * @param array $data - данные для вывода в шаблоне
     * @param int $responseCode - по умолчанию 200, типа все ок
     * @return null
     */
    public function renderHtml(string $templateName, array $data = [], int $responseCode = 200)
    {
        http_response_code($responseCode);
        extract($data);

        ob_start();
        include $this->templatesDir . '/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer; return null;
    }
}
