<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::insert([
            [
                'category_id' => 1,
                'name' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial dengan ayam dan telur',
                'price' => 20000,
                'stock' => 10,
                'image_path' => 'images/menus/nasi_goreng.jpg',
                'status' => 'ready',
            ],
            [
                'category_id' => 1,
                'name' => 'Mie Goreng',
                'description' => 'Mie goreng dengan sayuran dan telur',
                'price' => 18000,
                'stock' => 15,
                'image_path' => 'images/menus/mie_goreng.jpg',
                'status' => 'ready',
            ],
            [
                'category_id' => 2,
                'name' => 'Es Teh',
                'description' => 'Minuman teh manis dengan es',
                'price' => 5000,
                'stock' => 20,
                'image_path' => 'images/menus/es_teh.jpg',
                'status' => 'ready',
            ],
        ]);
    }
}
