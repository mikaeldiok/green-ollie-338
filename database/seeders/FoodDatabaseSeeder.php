<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nasiBakarList = [
            [
                'name' => 'Nasi Bakar Ayam',
                'description' => 'Nasi bakar dengan isian ayam yang gurih dan lezat.',
                'price' => 25000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi%20bakar%20ayam.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ikan Teri',
                'description' => 'Nasi bakar dengan isian ikan teri yang pedas dan menggugah selera.',
                'price' => 20000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi bakar teri.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Suwir Pedas',
                'description' => 'Nasi bakar dengan ayam suwir pedas yang nikmat.',
                'price' => 28000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/Nasi Bakar Ayam Suwir Pedas.jpg',
            ],
            [
                'name' => 'Nasi Bakar Tuna',
                'description' => 'Nasi bakar dengan isian tuna segar dan lezat.',
                'price' => 30000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ikan tuna.jpg',
            ],
            [
                'name' => 'Nasi Bakar Cumi',
                'description' => 'Nasi bakar dengan isian cumi yang gurih dan kenyal.',
                'price' => 32000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar cumi.jpg',
            ],
            [
                'name' => 'Nasi Bakar Udang',
                'description' => 'Nasi bakar dengan isian udang yang lezat dan segar.',
                'price' => 35000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar udang.jpg',
            ],
            [
                'name' => 'Nasi Bakar Jambal Roti',
                'description' => 'Nasi bakar dengan isian ikan jambal roti yang asin dan gurih.',
                'price' => 23000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi bakar jambal roti.jpeg',
            ],
            [
                'name' => 'Nasi Bakar Sapi',
                'description' => 'Nasi bakar dengan isian daging sapi yang lezat dan empuk.',
                'price' => 40000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar sapi.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Kemangi',
                'description' => 'Nasi bakar dengan isian ayam dan aroma kemangi yang segar.',
                'price' => 27000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ayam kemawangi.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ikan Asin',
                'description' => 'Nasi bakar dengan isian ikan asin yang gurih dan lezat.',
                'price' => 22000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ikan asin.jpg',
            ],
            [
                'name' => 'Nasi Bakar Telur Asin',
                'description' => 'Nasi bakar dengan isian telur asin yang kaya rasa.',
                'price' => 25000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar telur asin.jpeg',
            ],
            [
                'name' => 'Nasi Bakar Daging Rendang',
                'description' => 'Nasi bakar dengan isian daging rendang yang kaya rempah.',
                'price' => 45000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi bakar rendang.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Betutu',
                'description' => 'Nasi bakar dengan isian ayam betutu yang kaya rasa.',
                'price' => 30000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ayam betutu.jpg',
            ],
            [
                'name' => 'Nasi Bakar Jamur',
                'description' => 'Nasi bakar dengan isian jamur yang gurih dan lezat.',
                'price' => 20000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar jamur.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ikan Tongkol',
                'description' => 'Nasi bakar dengan isian ikan tongkol yang pedas dan gurih.',
                'price' => 28000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ikan tongkol.jpg',
            ],
            [
                'name' => 'Nasi Bakar Pedas',
                'description' => 'Nasi bakar dengan isian yang super pedas dan menggugah selera.',
                'price' => 22000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar pedas.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Rica-Rica',
                'description' => 'Nasi bakar dengan isian ayam rica-rica yang pedas dan lezat.',
                'price' => 32000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ayam rica.jpg',
            ],
            [
                'name' => 'Nasi Bakar Bebek',
                'description' => 'Nasi bakar dengan isian daging bebek yang lezat dan gurih.',
                'price' => 40000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar bebek.jpeg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Serundeng',
                'description' => 'Nasi bakar dengan isian ayam serundeng yang gurih dan lezat.',
                'price' => 27000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ayam serundeng.jpg',
            ],
            [
                'name' => 'Nasi Bakar Sambal Matah',
                'description' => 'Nasi bakar dengan isian sambal matah yang segar dan pedas.',
                'price' => 25000,
                'on_slider' => true,
                'image' => env('APP_URL') . '/img/foods/nasi bakar sambal matah.jpg',
            ],
            [
                'name' => 'Nasi Bakar Belut',
                'description' => 'Nasi bakar dengan isian belut yang gurih dan lezat.',
                'price' => 30000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar belut.jpg',
            ],
            [
                'name' => 'Nasi Bakar Tempe',
                'description' => 'Nasi bakar dengan isian tempe yang sehat dan nikmat.',
                'price' => 20000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar tempe.jpg',
            ],
            [
                'name' => 'Nasi Bakar Tongkol Kemangi',
                'description' => 'Nasi bakar dengan isian tongkol dan aroma kemangi yang menggugah selera.',
                'price' => 27000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar tongkol kemangi.jpg',
            ],
            [
                'name' => 'Nasi Bakar Ayam Panggang',
                'description' => 'Nasi bakar dengan isian ayam panggang yang lezat dan juicy.',
                'price' => 28000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar ayam panggang.jpg',
            ],
            [
                'name' => 'Nasi Bakar Gurih Udang',
                'description' => 'Nasi bakar dengan isian udang yang gurih dan kaya rasa.',
                'price' => 32000,
                'on_slider' => false,
                'image' => env('APP_URL') . '/img/foods/nasi bakar gurih udang.jpg',
            ],
        ];

        // Insert the data into the foods table
        foreach ($nasiBakarList as $nasiBakar) {
            Food::firstOrCreate(['name' => $nasiBakar['name']],$nasiBakar);
        }
    }
}
