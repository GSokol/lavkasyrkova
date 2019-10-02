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
            ['name'=>'АЗИАГО','description'=>'','parts'=>1,'price'=>2200,'category_id'=>3,'add_category_id'=>1],
            ['name'=>'Буратта','description'=>'','parts'=>0,'price'=>280,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'ВАЙНКЕЗЕ','description'=>'','parts'=>0,'price'=>360,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'ГОРГОНЗОЛА КРЕМОЗО','description'=>'','parts'=>1,'price'=>20,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Камамбер козий СМ','description'=>'','parts'=>0,'price'=>280,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Камамбер с трюфелем','description'=>'','parts'=>0,'price'=>330,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'КАМАМБЕР СМ','description'=>'','parts'=>0,'price'=>360,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'КАПРИНО 1-2','description'=>'','parts'=>1,'price'=>2200,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'Качетта с трюфелем','description'=>'','parts'=>1,'price'=>2200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Кнолле белпер Губернский','description'=>'','parts'=>1,'price'=>2200,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Кнолле белпер Соболев','description'=>'','parts'=>0,'price'=>200,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'КРОТТЕН','description'=>'','parts'=>1,'price'=>3000,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Козий твердый','description'=>'','parts'=>1,'price'=>2500,'category_id'=>3,'add_category_id'=>1],
            ['name'=>'КОЗИЙ МОЛОДОЙ','description'=>'','parts'=>1,'price'=>1500,'category_id'=>1,'add_category_id'=>1],
            ['name'=>' МААСДАМ','description'=>'','parts'=>1,'price'=>1600,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'МАЛАХИТ','description'=>'','parts'=>1,'price'=>3500,'category_id'=>5,'add_category_id'=>1],
            ['name'=>'монтазио с трюфелем','description'=>'','parts'=>1,'price'=>2500,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'МОНФЛЕР 0,13','description'=>'','parts'=>0,'price'=>380,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'МОЦАРЕЛЛА 0,2','description'=>'','parts'=>0,'price'=>260,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'ПЕКАРИНО 1-2','description'=>'','parts'=>1,'price'=>2900,'category_id'=>2,'add_category_id'=>3],
            ['name'=>'Песто класс','description'=>'','parts'=>0,'price'=>250,'category_id'=>7],
            ['name'=>'ПРЕМИОЛА','description'=>'','parts'=>1,'price'=>1900,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'РАКЛЕТ','description'=>'','parts'=>1,'price'=>1800,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Русский пармезан','description'=>'','parts'=>1,'price'=>1200,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'СЕНТМОР','description'=>'','parts'=>0,'price'=>390,'category_id'=>4],
            ['name'=>'Скаморца копченая','description'=>'','parts'=>1,'price'=>1200,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Скаморца натуральная','description'=>'','parts'=>1,'price'=>1200,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Соус к сыру','description'=>'','parts'=>0,'price'=>200,'category_id'=>7],
            ['name'=>'Стилтон дольче','description'=>'','parts'=>1,'price'=>2500,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Стилтон пиканте','description'=>'','parts'=>1,'price'=>2500,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Страчателла','description'=>'','parts'=>1,'price'=>600,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'ТАЛЛЕДЖИО','description'=>'','parts'=>1,'price'=>2000,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Том де шевр','description'=>'','parts'=>1,'price'=>2000,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'ТОММИ','description'=>'','parts'=>1,'price'=>2200,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'Халуми','description'=>'','parts'=>0,'price'=>330,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Чеддер 12М','description'=>'','parts'=>1,'price'=>3000,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Чеддер 6М','description'=>'','parts'=>1,'price'=>2200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'ШЕВР КРЕМ','description'=>'','parts'=>1,'price'=>1700,'category_id'=>1],
            ['name'=>'ЭМЕНТАЛЕР кенигсбергский','description'=>'','parts'=>1,'price'=>2200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'ЯНТАРНЫЙ','description'=>'','parts'=>1,'price'=>1800,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Пате мясо утки','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Пате печень утки','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Пате печень утки с инжиром','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Пате мясо индейки','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Пате мясо индейки с грибами','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Пате печень индейки','description'=>'','parts'=>0,'price'=>300,'category_id'=>6],
            ['name'=>'Минисалями','description'=>'','parts'=>1,'price'=>2000,'category_id'=>6],
            ['name'=>'Миниколбаски Чоризо','description'=>'','parts'=>1,'price'=>2000,'category_id'=>6],
            ['name'=>'Салями Милано','description'=>'','parts'=>1,'price'=>1800,'category_id'=>6],
            ['name'=>'Балык Пратта','description'=>'','parts'=>1,'price'=>2000,'category_id'=>6],
            ['name'=>'Шейка Коппа','description'=>'','parts'=>1,'price'=>2300,'category_id'=>6],
            ['name'=>'Суджук','description'=>'','parts'=>1,'price'=>2500,'category_id'=>6]
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

            if ($product['parts']) {
                $fields['whole_price'] = 0;
                $fields['part_price'] = 0.1 * $product['price'];

                $fields['action_whole_price'] = 0;
                $fields['action_part_price'] = $fields['part_price']/2;

            } else {
                $fields['whole_price'] = $product['price'];
                $fields['part_price'] = 0;

                $fields['action_whole_price'] = $fields['whole_price']/2;
                $fields['action_part_price'] = 0;
            }

            unset($fields['price']);

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