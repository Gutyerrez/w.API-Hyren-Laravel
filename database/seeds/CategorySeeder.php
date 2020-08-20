<?php

use App\Extensions\Permission\Group;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Hyren',
                'slug' => '',
                'restrict_write' => Group::MASTER()->key
            ],
            [
                'name' => 'Support',
                'slug' => ''
            ],
            [
                'name' => 'Community',
                'slug' => ''
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
