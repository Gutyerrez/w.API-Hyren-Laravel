<?php

use App\Extensions\Permission\Group;
use App\Models\Group as GroupModel;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        foreach (Group::getValues() as $group) {
            GroupModel::create($group);
        }
    }
}
