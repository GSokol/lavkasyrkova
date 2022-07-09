<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Office;
use App\Tasting;

class OfficesTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['address' => 'Самовывоз. м.Киевская, Дорогомиловский рынок, место: 201-202', 'latitude' => 55.742632, 'longitude' => 37.554221],
            ['address' => 'Самовывоз. м.Спортивная, Усачёвский рынок, ул.Усачёва, д.26', 'latitude' => 55.727374, 'longitude' => 37.567698],

            ['address' => 'Московская обл., г.Химки, ул.Ленинградская, вл.39 стр.6', 'latitude' => 55.908384, 'longitude' => 37.414742],
            ['address' => 'г.Москва, ул Покровка д 40 стр. 2А, офис «ТМК»', 'latitude' => 55.761543, 'longitude' => 37.653523],
            ['address' => 'г.Москва. Романов переулок д 4 стр. 2, офисный центр «Романов Двор», столовая', 'latitude' => 55.754568, 'longitude' => 37.609577],
            ['address' => 'г.Москва, ул.Кржижановского д 16 корп 3. офис компании, столовая', 'latitude' => 55.680001, 'longitude' => 37.568821],
            ['address' => 'г.Москва, ул.Маши Порываевой д 14, столовая', 'latitude' => 55.774340, 'longitude' => 37.648151],
            ['address' => 'г.Москва, ул.Гашека д 7. Кафетера', 'latitude' => 55.769383, 'longitude' => 37.590865],
            ['address' => 'г.Москва, ул.Беловежская д 4. офис компании, столовая', 'latitude' => 55.712528, 'longitude' => 37.389122],
            ['address' => 'г.Москва, Большой Кисловский пер д 11, офис компании. столовая', 'latitude' => 55.755257, 'longitude' => 37.605822],
            ['address' => 'г.Москва, ул.Дубининская 31А, офис компании. столовая', 'latitude' => 55.724976, 'longitude' => 37.637713],
            ['address' => 'г.Москва. ул.Спартаковская д 12, офис компании, столовая', 'latitude' => 55.772046, 'longitude' => 37.675127],
            ['address' => 'г.Москва. ул. Тимура Фрунзе д 11 стр 2, БЦ «МАМОНТОВ», Кафетера', 'latitude' => 55.733705, 'longitude' => 37.589482],
            ['address' => 'г.Москва. Проспект Вернадского д 101. корп 3, офис кампании. столовая', 'latitude' => 55.665502, 'longitude' => 37.486562],
            ['address' => 'г.Москва, ул.Тестовская д 10, Северная башня, Кафетера', 'latitude' => 55.751796, 'longitude' => 37.532637],
            ['address' => 'г.Москва, Ленинградское шоссе д 39А, стр 1, БЦ «Олимпия парк», Кафетера', 'latitude' => 55.837823, 'longitude' => 37.480660],
            ['address' => 'г.Москва, ул.Варшавское шоссе д 37. офис компании, столовая', 'latitude' => 55.688649, 'longitude' => 37.623411],
            ['address' => 'г.Москва, ул.Цветной бульвар д 2. БЦ «Легенды Цветного», Кафетера', 'latitude' => 55.768025, 'longitude' => 37.623483],
            ['address' => 'Московская обл, Одинцовский район, д.Сколково, ул. Новая д 100, офис компании, столовая', 'latitude' => 55.692754, 'longitude' => 37.384558],
            ['address' => 'г.Москва, ул.Сергея Макеева д 13. БЦ «МАРР ПЛАЗА», Кафетера', 'latitude' => 55.763356, 'longitude' => 37.551259]
        ];

        foreach ($data as $item) {
            Office::create($item);
        }

        $data = [
            ['time' => strtotime('02.10.2019'), 'active' => 1, 'office_id' => 1],

            ['time' => strtotime('03.10.2019'), 'active' => 1, 'office_id' => 2],
            ['time' => strtotime('04.10.2019'), 'active' => 1, 'office_id' => 2],

            ['time' => strtotime('07.10.2019'), 'active' => 1, 'office_id' => 3],
            ['time' => strtotime('08.10.2019'), 'active' => 1, 'office_id' => 4],
            ['time' => strtotime('09.10.2019'), 'active' => 1, 'office_id' => 5],

            ['time' => strtotime('10.10.2019'), 'active' => 1, 'office_id' => 6],
            ['time' => strtotime('11.10.2019'), 'active' => 1, 'office_id' => 6],
            ['time' => strtotime('12.10.2019'), 'active' => 1, 'office_id' => 6],
            ['time' => strtotime('13.10.2019'), 'active' => 1, 'office_id' => 6],
            ['time' => strtotime('14.10.2019'), 'active' => 1, 'office_id' => 6],

            ['time' => strtotime('15.10.2019'), 'active' => 1, 'office_id' => 7],
            ['time' => strtotime('16.10.2019'), 'active' => 1, 'office_id' => 8],

            ['time' => strtotime('17.10.2019'), 'active' => 1, 'office_id' => 9],
            ['time' => strtotime('18.10.2019'), 'active' => 1, 'office_id' => 9],
            ['time' => strtotime('19.10.2019'), 'active' => 1, 'office_id' => 9],
            ['time' => strtotime('20.10.2019'), 'active' => 1, 'office_id' => 9],
            ['time' => strtotime('21.10.2019'), 'active' => 1, 'office_id' => 9],

            ['time' => strtotime('22.10.2019'), 'active' => 1, 'office_id' => 10],

            ['time' => strtotime('23.10.2019'), 'active' => 1, 'office_id' => 11],
            ['time' => strtotime('24.10.2019'), 'active' => 1, 'office_id' => 11],
            ['time' => strtotime('25.10.2019'), 'active' => 1, 'office_id' => 11],
            ['time' => strtotime('26.10.2019'), 'active' => 1, 'office_id' => 11],
            ['time' => strtotime('27.10.2019'), 'active' => 1, 'office_id' => 11],
            ['time' => strtotime('28.10.2019'), 'active' => 1, 'office_id' => 11],

            ['time' => strtotime('29.10.2019'), 'active' => 1, 'office_id' => 12],
            ['time' => strtotime('30.10.2019'), 'active' => 1, 'office_id' => 13],
            ['time' => strtotime('31.10.2019'), 'active' => 1, 'office_id' => 14],

            ['time' => strtotime('01.11.2019'), 'active' => 1, 'office_id' => 15],
            ['time' => strtotime('02.11.2019'), 'active' => 1, 'office_id' => 15],
            ['time' => strtotime('03.11.2019'), 'active' => 1, 'office_id' => 15],
            ['time' => strtotime('04.11.2019'), 'active' => 1, 'office_id' => 15],

            ['time' => strtotime('05.11.2019'), 'active' => 1, 'office_id' => 16],
            ['time' => strtotime('06.11.2019'), 'active' => 1, 'office_id' => 17],
            ['time' => strtotime('07.11.2019'), 'active' => 1, 'office_id' => 18],
        ];

        foreach ($data as $item) {
            Tasting::create($item);
        }
    }
}
