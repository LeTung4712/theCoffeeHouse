<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Toppings extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Kem Phô Mai Macchiato',
                'price' => 10000,
            ],
            [
                'id' => 2,
                'name' => 'Shot Espresso',
                'price' => 10000,
            ],
            [
                'id' => 3,
                'name' => 'Sốt Caramel',
                'price' => 10000,
            ],
            [
                'id' => 4,
                'name' => 'Thạch Cà Phê',
                'price' => 10000,
            ],
            [
                'id' => 5,
                'name' => 'Trân Châu Trắng',
                'price' => 10000,
            ],
        ];
        Topping::truncate();
        Topping::insert($data);
    }
}
