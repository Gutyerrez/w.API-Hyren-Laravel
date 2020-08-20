<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
