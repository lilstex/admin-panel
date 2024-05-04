<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecord = [
            ['id' => 1, 'parent_id' => 0, 'category_name' => 'Watches', 'category_image' => '', 'url' => 'watch', 'desc' => 'This is a watch', 'meta_title' => 'watch', 'meta_desc' => 'This is a watch', 'meta_keywords' => 'watch, wrist','category_discount' => 0, 'status' => 1],
            ['id' => 2, 'parent_id' => 1, 'category_name' => 'Phones', 'category_image' => '', 'url' => 'phone', 'desc' => 'This is a phone', 'meta_title' => 'phone', 'meta_desc' => 'This is a phone', 'meta_keywords' => 'phone, wrist', 'category_discount' => 0, 'status' => 1],
            ['id' => 3, 'parent_id' => 0, 'category_name' => 'Clothes', 'category_image' => '', 'url' => 'clothes', 'desc' => 'This is a clothes','meta_title' => 'clothes', 'meta_desc' => 'This is a clothes', 'meta_keywords' => 'clothes, wears', 'category_discount' => 0, 'status' => 1 ],
            ['id' => 4, 'parent_id' => 1, 'category_name' => 'laptops', 'category_image' => '', 'url' => 'laptops', 'desc' => 'This is a laptops', 'meta_title' => 'laptops', 'meta_desc' => 'This is a laptops', 'meta_keywords' => 'laptops, apple, hp', 'category_discount' => 0, 'status' => 1]
        ];

        Category::insert($categoryRecord);
    }
}
