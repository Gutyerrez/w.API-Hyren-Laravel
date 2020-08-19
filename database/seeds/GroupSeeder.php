<?php

use App\Extensions\Permission\Group;
use App\Models\Group as GroupModel;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run()
    {
        foreach (Group::getValues() as $name => $group) {
            GroupModel::create([
                'name' => $name,
                'display_name' => $group['display_name'],
                'prefix' => $group['prefix'],
                'color' => $group['color'],
                'priority' => $group['priority'],
                'tab_list_order' => $group['tab_list_order']
            ]);
        }
    }
}
