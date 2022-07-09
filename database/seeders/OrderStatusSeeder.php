<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            ['code' => OrderStatus::ORDER_STATUS_NEW, 'name' => 'Новый', 'class_name' => 'default'],
            ['code' => OrderStatus::ORDER_STATUS_PICKED, 'name' => 'Собраный', 'class_name' => 'primary'],
            ['code' => OrderStatus::ORDER_STATUS_DONE, 'name' => 'Выполнен', 'class_name' => 'success'],
            ['code' => OrderStatus::ORDER_STATUS_CANCELED, 'name' => 'Отменен', 'class_name' => 'danger'],
            ['code' => OrderStatus::ORDER_STATUS_PAID, 'name' => 'Оплачен', 'class_name' => 'success'],
            ['code' => OrderStatus::ORDER_STATUS_NOT_PAID, 'name' => 'Неоплачен', 'class_name' => 'danger'],
        ];

        // Старые статусы:
        // 1 => новый
        // 2 => завершен

        // Новые статусы
        // 1 => Новый
        // 2 => Собраный
        // 3 => Выполнен
        // 4 => Отменен

        foreach ($rows as $row) {
            OrderStatus::updateOrCreate(Arr::only($row, ['code']), $row)->save();
        }
    }
}
