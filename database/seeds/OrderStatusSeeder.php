<?php

use Illuminate\Database\Seeder;
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
            ['code' => OrderStatus::ORDER_STATUS_NEW, 'name' => 'Новый', 'class_name' => 'indigo'],
            ['code' => OrderStatus::ORDER_STATUS_PICKED, 'name' => 'Собраный', 'class_name' => 'primary'],
            ['code' => OrderStatus::ORDER_STATUS_DONE, 'name' => 'Выполнен', 'class_name' => 'success'],
            ['code' => OrderStatus::ORDER_STATUS_CANCELED, 'name' => 'Отменен', 'class_name' => 'danger'],
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
            OrderStatus::updateOrCreate(array_only($row, ['code']), $row)->save();
        }
    }
}
