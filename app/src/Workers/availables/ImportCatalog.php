<?php

namespace Src\Workers\Availables;

use Src\Services\Parser;
use Src\Workers\IWorker;
use Src\Workers\Worker;

class ImportCatalog extends Worker implements IWorker
{
    public function run()
    {
        //Получаем файл
        $parser = new Parser(config('parser')['url'], config('parser')['temp_file_path']);

        //Получаем данные из файла
        $data = $parser->read();

        //Импорт категорий продуктов
        foreach ($data->shop->categories->category as $row) {
            $id = intval($row['id']);
            $parent = intval($row['parentId']);
            $name = strval($row);

            $query = $this->db->prepare('INSERT INTO product_categories (catalog_id, catalog_parent_id, name) VALUES (?, ?, ?)');
            $query->bind_param('iis', $id, $parent, $name);
            $query->execute();
        }

        //Импорт продуктов
        foreach ($data->shop->offers->offer as $row) {
            // id - идентификатор предложения.
            $catalog_id = intval($row['id']);

            // available - статус товара «в наличии» / «на заказ».
            $available = strval($row['available']) == 'true' ? 1 : 0;

            // url - URL страницы товара на сайте магазина.
            $url = strval($row->url);

            // price - актуальная цена.
            $price = strval($row->price);

            // local_delivery_cost - стоимость доставки.
            $local_delivery_cost = intval($row->local_delivery_cost);

            // categoryId - идентификатор категории товара.
            $catalog_category_id = intval($row->categoryId);

            // name - название товара.
            $name = strval($row->name);

            // picture - изображение.
            $picture = strval($row->picture);

            // delivery - доставка.
            $delivery = strval($row->delivery) == 'true' ? 1 : 0;

            // description - описание.
            $description = strval($row->description);

            $query = $this->db->prepare('INSERT INTO products (
                      catalog_id, 
                      catalog_category_id, 
                      name, 
                      description, 
                      price, 
                      picture, 
                      delivery, 
                      local_delivery_cost, 
                      available, 
                      url
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $query->bind_param(
                'iissisiiis',
                $catalog_id,
                $catalog_category_id,
                $name,
                $description,
                $price,
                $picture,
                $delivery,
                $local_delivery_cost,
                $available,
                $url
            );
            $query->execute();
        }

    }
}
