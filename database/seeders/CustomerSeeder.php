<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Seeder;
use Faker\Factory as DataPalsu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataPalsu = DataPalsu::create('id_ID');
        $data = [];

        for ($i = 0;  $i < 100; $i++)
        {
            $gender = $dataPalsu->randomElement(['male', 'female']);
            $data[] = [
                'email'         => $dataPalsu->email(),
                'first_name'    => $dataPalsu->firstName($gender),
                'last_name'     => $dataPalsu->lastName(),
                'city'          => $dataPalsu->city(),
                'address'       => $dataPalsu->address(),
                'password'      => Hash::make('1234567')
            ];
        }
        (new Customers())->newQuery()->insert($data);
    }
}