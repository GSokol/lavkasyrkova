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
            ['name' => 'Молодые сыры','image' => '8345'],
            ['name' => 'Полутвердые сыры','image' => '8332'],
            ['name' => 'Твердые сыры','image' => '8318'],
            ['name' => 'Сыры с белой плесенью','image' => '8122'],
            ['name' => 'Сыры с голубой плесенью','image' => '8107'],
            ['name' => 'Мясная гастрономия','image' => '8010'],
            ['name' => 'К сыру','image' => '7990'],
            ['name' => 'Подарочные корзины','image' => ''],
            ['name' => 'Сырные тарелки','image' => ''],
            ['name' => 'Молочные продукты','image' => ''],
        ];
        $additionalCategories = [
            ['name' => 'Сыры из козьего молока'],
            ['name' => 'Сыры из коровьего молока'],
            ['name' => 'Сыры из овечьего молока'],
        ];

        $products = [
            ['name'=>'Азиаго','parts'=>1,'image'=>'8088','price'=>2200,'category_id'=>3,'add_category_id'=>1],
            ['name'=>'Азиаго','parts'=>1,'image'=>'8088','price'=>2200,'category_id'=>3,'add_category_id'=>1],
            ['name'=>'Бри','parts'=>1,'image'=>'7974','price'=>2000,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'Брюност','parts'=>1,'image'=>'8155','price'=>250,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Буратта 0,15','parts'=>1,'image'=>'8337','price'=>280,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Вайнкезе','parts'=>1,'image'=>'7935','price'=>360,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'Сент Пьер','parts'=>0,'image'=>'7816','price'=>600,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Валансе','parts'=>1,'image'=>'7854','price'=>0,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Горгонзола Дольче','parts'=>1,'image'=>'8028','price'=>2500,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Горгонзола Пиканте','parts'=>1,'image'=>'8045','price'=>2600,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Грандфортузза 12 мес','parts'=>1,'image'=>'8144','price'=>2000,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'МОТЭ','parts'=>0,'image'=>'7905','price'=>250,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Камамбер с трюфелем','parts'=>0,'image'=>'7952','price'=>330,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'Камамбер','parts'=>1,'image'=>'7926','price'=>1800,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'Камамбер из козьего молока','parts'=>0,'image'=>'7968','price'=>280,'category_id'=>4,'add_category_id'=>2],
            ['name'=>'Каприно Козий','parts'=>1,'image'=>'8253','price'=>2200,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'Сент мор зрелый','parts'=>0,'image'=>'7841','price'=>390,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Качетта с Трюфелем вакуум','parts'=>1,'image'=>'8278','price'=>2200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Кнолле белпер','parts'=>1,'image'=>'7982','price'=>2200,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Кроттен','parts'=>0,'image'=>'7877','price'=>3000,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Козий Твердый 8 мес','parts'=>1,'image'=>'8236','price'=>2200,'category_id'=>3,'add_category_id'=>1],
            ['name'=>'Козий Молодой','parts'=>1,'image'=>'8336','price'=>1500,'category_id'=>1,'add_category_id'=>1],
            ['name'=>'Маасдам','parts'=>1,'image'=>'8150','price'=>1600,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Малахит козий (рокфор) ','parts'=>1,'image'=>'8074','price'=>3500,'category_id'=>5,'add_category_id'=>1],
            ['name'=>'Монтазио с Трюфелем','parts'=>1,'image'=>'8248','price'=>2500,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Горгонзола Кремозо','parts'=>1,'image'=>'7772_1','price'=>2000,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Моцарелла 0,2','parts'=>0,'image'=>'8342_2','price'=>260,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Пате мясо индейки с грибами','parts'=>0,'image'=>'8011','price'=>250,'category_id'=>6],
            ['name'=>'Пате мясо утки','parts'=>0,'image'=>'8017','price'=>250,'category_id'=>6],
            ['name'=>'Пате печень индейки','parts'=>0,'image'=>'8010','price'=>250,'category_id'=>6],
            ['name'=>'Пате из мяса индейки','parts'=>0,'image'=>'8011','price'=>250,'category_id'=>6],
            ['name'=>'Пате печень утки','parts'=>0,'image'=>'8017','price'=>250,'category_id'=>6],
            ['name'=>'Пате печень утки с инжиром','parts'=>0,'image'=>'8017','price'=>250,'category_id'=>6],
            ['name'=>'Пекарино овечий','parts'=>1,'image'=>'8216','price'=>2900,'category_id'=>2,'add_category_id'=>3],
            ['name'=>'Премиола','parts'=>1,'image'=>'8224','price'=>1900,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Раклет','parts'=>1,'image'=>'8272','price'=>1800,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Русский Пармезан Ставрополь','parts'=>1,'image'=>'8159','price'=>1200,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Сент Мор из козьего молока','parts'=>1,'image'=>'7798','price'=>2600,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Скаморца копченая','parts'=>1,'image'=>'8264','price'=>1200,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Скаморца натуральная','parts'=>1,'image'=>'8261','price'=>1200,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Соус к сыру','parts'=>0,'image'=>'7990','price'=>200,'category_id'=>7],
            ['name'=>'Стилтон Дольче','parts'=>1,'image'=>'8062','price'=>2500,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Стилтон Пиканте','parts'=>1,'image'=>'8070','price'=>2500,'category_id'=>5,'add_category_id'=>2],
            ['name'=>'Страчателла','parts'=>1,'image'=>'8343','price'=>600,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Талледжио','parts'=>1,'image'=>'8054','price'=>2000,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Том Де Шевр','parts'=>1,'image'=>'8269','price'=>2000,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'Томми','parts'=>1,'image'=>'8245','price'=>2200,'category_id'=>2,'add_category_id'=>1],
            ['name'=>'Халуми натур, 0,3 кг. ','parts'=>0,'image'=>'8342_1','price'=>330,'category_id'=>1,'add_category_id'=>2],
            ['name'=>'Чеддер 12 мес','parts'=>1,'image'=>'8198','price'=>3000,'category_id'=>3,'add_category_id'=>2],
            ['name'=>'Чеддер 6 мес','parts'=>1,'image'=>'8196','price'=>2200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Шевр крем','parts'=>1,'image'=>'8347','price'=>1700,'category_id'=>1,'add_category_id'=>1],
            ['name'=>'Эмменталер Кенигсбергский','parts'=>1,'image'=>'8181','price'=> 200,'category_id'=>2,'add_category_id'=>2],
            ['name'=>'Минисалями','parts'=>1,'image'=>'8283','price'=> 2000,'category_id'=>6],
            ['name'=>'Миниколбаски Чоризо','parts'=>1,'image'=>'8288','price'=> 2000,'category_id'=>6],
            ['name'=>'Бюш козий в белой плесени в золе','parts'=>0,'image'=>null,'price'=>360,'category_id'=>4,'add_category_id'=>1],
            ['name'=>'Моншери','parts'=>0,'image'=>'7895','price'=>420,'category_id'=>4,'add_category_id'=>1],
        ];

        $prodPath = 'images/products/';
        foreach ($categories as $category) {
            $category['image'] = $category['image'] ? $prodPath.$category['image'].'.jpg' : '';
            Category::create($category);
        }

        foreach ($additionalCategories as $category) {
            AddCategory::create($category);
        }

        foreach ($products as $k => $product) {
            $fields = $product;
            $fields['description'] = 'Попробуйте начать свой день с чашки ароматного кофе и теплого домашнего хлеба со свежим «'.$product['name'].'».';
            $fields['image'] = $product['image'] ? $prodPath.$product['image'].'.jpg' : null;
            $fields['big_image'] = $product['image'] ? $prodPath.$product['image'].'_big.jpg' : null;

            if ($product['parts']) {
                $fields['whole_price'] = 0;
                $fields['part_price'] = $product['price'] ? 0.1 * $product['price'] : 0;

                $fields['action_whole_price'] = 0;
                $fields['action_part_price'] = $product['price'] ? $fields['part_price']/2 : 0;

            } else {
                $fields['whole_price'] = $product['price'];
                $fields['part_price'] = 0;

                $fields['action_whole_price'] = $product['price'] ? $fields['whole_price']/2 : 0;
                $fields['action_part_price'] = 0;
            }

            unset($fields['price']);

            $fields['action'] = $k<5;
            $fields['active'] = true;

            Product::create($fields);
        }
    }
}