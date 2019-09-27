<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\AddCategory;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Молодые сыры',
            'Полутвердые сыры',
            'Твердые сыры',
            'Сыры с белой плесенью',
            'Сыры с голубой плесенью',
            'Мясная гастрономия',
            'К сыру',
            'Подарочные корзины',
            'Сырные тарелки',
            'Молочные продукты'
        ];
        $additionalCategories = [
            'Сыры из козьего молока',
            'Сыры из коровьего молока',
            'Сыры из овечьего молока'
        ];

        $products = [
            ['name'=>'Азиаго', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>1],
            ['name'=>'Альпийский', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Алферьевский Козий', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>1],
            ['name'=>'Брюност', 'description'=>'', 'parts'=>0, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Брюност по-рижски', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Бюш Козий в белой плесени/зола', 'description'=>'', 'parts'=>1, 'category_id'=>1, 'add_category_id'=>1],
            ['name'=>'Вайнкезе', 'description'=>'', 'parts'=>1, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Валансе козий', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>1],
            ['name'=>'Гауда подарочная', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Грандфортезза 12 мес', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Камамбер', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>2],
            ['name'=>'Камамбер Блэк', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>2],
            ['name'=>'Камамбер из козьего молока', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>1],
            ['name'=>'Каприно Козий', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>1],
            ['name'=>'Качетта натур', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Качеств с Трюфелем вакуум', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Кнолле белпер Соболев', 'description'=>'', 'parts'=>0, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Кнолле белпер', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Козий твёрдый 8 мес', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>1],
            ['name'=>'Кроттен', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>1],
            ['name'=>'Ливнекас', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>1],
            ['name'=>'Маасдам', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Малахит козий (рокфор)', 'description'=>'', 'parts'=>1, 'category_id'=>5, 'add_category_id'=>1],
            ['name'=>'Масло премиум 82,5%', 'description'=>'', 'parts'=>0, 'category_id'=>10],
            ['name'=>'Масло домашнее','parts'=>1, 'category_id'=>10],
            ['name'=>'Монтазио с Трюфелем', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Горгонзола кремозо', 'description'=>'', 'parts'=>1, 'category_id'=>5, 'add_category_id'=>2],
            ['name'=>'Пармезан русский ставрополь', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Паттэ из мяса индейки', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Паттэ из мяса индейки с грибами', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Паттэ из печени индейки', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Паттэ из мяса утки', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Паттэ из печени утки', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Паттэ из печени утки с инжиром', 'description'=>'', 'parts'=>0, 'category_id'=>6],
            ['name'=>'Пеккарино овечий', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>3],
            ['name'=>'Премиола', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Сент мор из козьего молока', 'description'=>'', 'parts'=>1, 'category_id'=>4, 'add_category_id'=>1],
            ['name'=>'Скамррца натур', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Соус фрукт в ассортименте', 'description'=>'', 'parts'=>0, 'category_id'=>7],
            ['name'=>'Стилтон дольче', 'description'=>'', 'parts'=>1, 'category_id'=>5, 'add_category_id'=>2],
            ['name'=>'Стилтон пиканте', 'description'=>'', 'parts'=>1, 'category_id'=>5, 'add_category_id'=>2],
            ['name'=>'Талоеджио', 'description'=>'', 'parts'=>1, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Раклет', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Том де шевр', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>1],
            ['name'=>'Фетта', 'description'=>'', 'parts'=>0, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Халуми натур', 'description'=>'', 'parts'=>0, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Халлуми с мятой', 'description'=>'', 'parts'=>0, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Чедлер 6 м6с', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Чеддер 12 мес', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Шевр козий крем', 'description'=>'', 'parts'=>1, 'category_id'=>1, 'add_category_id'=>1],
            ['name'=>'Эмменталер кенигсбергский', 'description'=>'', 'parts'=>1, 'category_id'=>2, 'add_category_id'=>2],
            ['name'=>'Янтарный', 'description'=>'', 'parts'=>1, 'category_id'=>3, 'add_category_id'=>2],
            ['name'=>'Моцарелла 0,2', 'description'=>'', 'parts'=>0, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Буратта 0,15', 'description'=>'', 'parts'=>0, 'category_id'=>1, 'add_category_id'=>2],
            ['name'=>'Салями милано', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Брезаола', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Балык Платта', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Конина', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Мини-салями', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Мини-чоризо', 'description'=>'', 'parts'=>1, 'category_id'=>6],
            ['name'=>'Маринованые сливы', 'description'=>'', 'parts'=>0, 'category_id'=>7],
            ['name'=>'Мармелад', 'description'=>'', 'parts'=>0, 'category_id'=>7]
        ];

        $prodPath = 'images/products/product';
        $prodCount = 1;
        foreach ($categories as $category) {
            Category::create(['name' => $category,'image' => $prodPath.$prodCount.'.jpg']);
            $prodCount = $this->incrementCounter($prodCount);
        }

        $prodCount = 1;
        foreach ($additionalCategories as $category) {
            AddCategory::create(['name' => $category,'image' => $prodPath.$prodCount.'.jpg']);
            $prodCount = $this->incrementCounter($prodCount);
        }

        $prodCount = 1;
        foreach ($products as $k => $product) {
            $fields = $product;
            $fields['description'] = 'Попробуйте начать свой день с чашки ароматного кофе и теплого домашнего хлеба со свежим «'.$product['name'].'».';
            $fields['image'] = $prodPath.$prodCount.'.jpg';
            $fields['big_image'] = $prodPath.$prodCount.'_big.jpg';
            $fields['whole_price'] = 1000*($k+1);
            $fields['part_price'] = 100;
            $fields['action_whole_price'] = rand(500,2000);
            $fields['action_part_price'] = 50;
            $fields['action'] = $k<5;
            $fields['active'] = true;

            Product::create($fields);
            $prodCount = $this->incrementCounter($prodCount);
        }
    }

    private function incrementCounter($prodCount)
    {
        if ($prodCount == 10) $prodCount = 1;
        else $prodCount++;
        return $prodCount;
    }
}