<?php

namespace Src\Services;

class Parser
{
    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $temp_path;

    private bool $download_file_status;

    /**
     * @param string $url - ссылка на файл с каталогом
     * @param string $temp_path - локальный путь, куда будет сохранен файл для чтения
     */
    public function __construct(string $url, string $temp_path)
    {
        $this->url = $url;
        $this->temp_path = $temp_path;

        $this->downloadFile();
    }

    /** Скачиваем файл на сервер для дальнейшего чтения
     * @return bool - успешно загрузился или нет
     */
    private function downloadFile() : bool
    {
        try {
            $ch = curl_init($this->url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);

            $content = curl_exec($ch);

            curl_close($ch);

            if(!$this->download_file_status = (bool)file_put_contents($this->temp_path, $content)){
                throw new \Exception('Не удалось скачать и сохранить файл');
            }

        } catch (\Exception $e) {
            Log::save('Ошибка при попытке скачивании файла каталога на сервер: '.$e->getMessage());
        }

        return $this->download_file_status;
    }

    /**
     * Возвращаем содержимое файла каталога для чтения
     * @return bool|\SimpleXMLElement
     */
    public function read() : ?\SimpleXMLElement
    {
        try {
            if (is_file($this->temp_path)) return simplexml_load_file($this->temp_path);
        } catch (\Exception $e) {
            Log::save('Ошибка при попытке чтения файла каталога на сервере: '.$e->getMessage());
        }

        return false;
    }

    /**
     * Удаляем скачаный файл каталога после чтения
     */
    public function __destruct()
    {
        if(is_file($this->temp_path)) unlink($this->temp_path);
    }

}
