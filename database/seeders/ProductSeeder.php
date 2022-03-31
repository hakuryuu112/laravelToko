<?php

namespace Database\Seeders;

use App\Models\Products;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create('id_ID');

        $categories = ['Pakaian', 'Gadget', 'Digital'];
        $titles = [
            'Pakaian'   => [
                'material'  => ['Kaos', 'Kemeja', 'Celana', 'Jas'],
                'jenis'     => ['Besar', 'Kecil', 'Anak', 'Laki-Laki', 'Perempuan'],
                'warna'     => ['Putih', 'Merah', 'Hijau', 'Biru', 'Kuning', 'Pink', 'Ungu', 'Hitam']
            ],
            'Gadget'    => [
                'material'  => ['HP', 'Table', 'Laptop', 'PC', 'Mini PC'],
                'jenis'     => ['Oppo', 'Samsung', 'Asus', 'Xiaomi', 'Dell', 'Apple', 'Acer', 'Polytron'],
                'warna'     => ['Silver', 'Gold', 'Putih', 'Hitam']
            ],
            'Digital'   => [
                'material'  => ['Pulsa', 'Kuota', 'Perdana'],
                'jenis'     => ['Telkomsel', 'Indosat', 'Smartfren', 'Axis', 'XL', '3'],
                'warna'     => ['200', '150', '100', '75', '50', '20', '10', '5']
            ]
        ];

        for ($i = 0; $i < 100; $i++)
        {
            $category = $fake->randomElement($categories);
            $titleStr = $fake->randomElement($titles[$category]['material']);
            $titleStr .= ' ' . $fake->randomElement($titles[$category]['jenis']);
            $titleStr .= ' ' . $fake->randomElement($titles[$category]['warna']);

            $data[] = [
                'category' => $category,
                'title' => $titleStr,
                'price' => $fake->numberBetween(1, 100) * 1000,
                'description' => $fake->text(),
                'stock' => $fake->numberBetween(1, 200),
                'free_shipping' => $fake->numberBetween(0, 1),
                'rate' => $fake->randomFloat(2, 1, 5)
            ];

            (new Products())->newQuery()->insert($data);
        }
    }
}