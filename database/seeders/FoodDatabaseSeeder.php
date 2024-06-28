<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Menu\Models\Food;

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
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ikan Teri',
                'description' => 'Nasi bakar dengan isian ikan teri yang pedas dan menggugah selera.',
                'price' => 20000,
                'on_slider' => true,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ayam Suwir Pedas',
                'description' => 'Nasi bakar dengan ayam suwir pedas yang nikmat.',
                'price' => 28000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Tuna',
                'description' => 'Nasi bakar dengan isian tuna segar dan lezat.',
                'price' => 30000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Cumi',
                'description' => 'Nasi bakar dengan isian cumi yang gurih dan kenyal.',
                'price' => 32000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Udang',
                'description' => 'Nasi bakar dengan isian udang yang lezat dan segar.',
                'price' => 35000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Jambal Roti',
                'description' => 'Nasi bakar dengan isian ikan jambal roti yang asin dan gurih.',
                'price' => 23000,
                'on_slider' => true,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Sapi',
                'description' => 'Nasi bakar dengan isian daging sapi yang lezat dan empuk.',
                'price' => 40000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ayam Kemangi',
                'description' => 'Nasi bakar dengan isian ayam dan aroma kemangi yang segar.',
                'price' => 27000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ikan Asin',
                'description' => 'Nasi bakar dengan isian ikan asin yang gurih dan lezat.',
                'price' => 22000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Telur Asin',
                'description' => 'Nasi bakar dengan isian telur asin yang kaya rasa.',
                'price' => 25000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Daging Rendang',
                'description' => 'Nasi bakar dengan isian daging rendang yang kaya rempah.',
                'price' => 45000,
                'on_slider' => true,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ayam Betutu',
                'description' => 'Nasi bakar dengan isian ayam betutu yang kaya rasa.',
                'price' => 30000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Jamur',
                'description' => 'Nasi bakar dengan isian jamur yang gurih dan lezat.',
                'price' => 20000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ikan Tongkol',
                'description' => 'Nasi bakar dengan isian ikan tongkol yang pedas dan gurih.',
                'price' => 28000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Pedas',
                'description' => 'Nasi bakar dengan isian yang super pedas dan menggugah selera.',
                'price' => 22000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ayam Rica-Rica',
                'description' => 'Nasi bakar dengan isian ayam rica-rica yang pedas dan lezat.',
                'price' => 32000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Bebek',
                'description' => 'Nasi bakar dengan isian daging bebek yang lezat dan gurih.',
                'price' => 40000,
                'on_slider' => false,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Ayam Serundeng',
                'description' => 'Nasi bakar dengan isian ayam serundeng yang gurih dan lezat.',
                'price' => 27000,
                'on_slider' => true,
                'image' => null,
            ],
            [
                'name' => 'Nasi Bakar Sambal Matah',
                'description' => 'Nasi bakar dengan isian sambal matah yang segar dan pedas.',
                'price' => 25000,
                'on_slider' => true,
                'image' => null,
            ],
        ];

        // Insert the data into the foods table
        foreach ($nasiBakarList as $nasiBakar) {
            Food::create($nasiBakar);
        }
    }
}
