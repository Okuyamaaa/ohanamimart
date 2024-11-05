<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category1 = Category::firstOrCreate([
            'name' => '手芸',
        ]);
        $category2 = Category::firstOrCreate([
            'name' => 'アクセサリー',
        ]);
        $category3 = Category::firstOrCreate([
            'name' => '財布',
        ]);
        $category4 = Category::firstOrCreate([
            'name' => 'バッグ',
        ]);
        $category5 = Category::firstOrCreate([
            'name' => '置物',
        ]);
        $category6 = Category::firstOrCreate([
            'name' => '巾着',
        ]);
    }
}
