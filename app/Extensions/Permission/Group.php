<?php

namespace App\Extensions\Permission;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const MASTER = [
        'name' => 'MASTER',
        'display_name' => 'Master',
        'prefix' => '[Master] ',
        'color' => '#FFAA00',
        'priority' => 100,
        'tab_list_order' => 1
    ];

    const MANAGER = [
        'name' => 'MANAGER',
        'display_name' => 'Manager',
        'prefix' => '[Manager] ',
        'color' => '#AA0000',
        'priority' => 95,
        'tab_list_order' => 2
    ];

    const ADMINISTRATOR = [
        'name' => 'ADMINISTRATOR',
        'display_name' => 'Administrator',
        'prefix' => '[Admin] ',
        'color' => '#FF5555',
        'priority' => 90,
        'tab_list_order' => 3
    ];

    const MODERATOR = [
        'name' => 'MODERATOR',
        'display_name' => 'Moderator',
        'prefix' => '[Moderator] ',
        'color' => '#00AA00',
        'priority' => 85,
        'tab_list_order' => 4
    ];

    const HELPER = [
        'name' => 'HELPER',
        'display_name' => 'Helper',
        'prefix' => '[Helper] ',
        'color' => '#55FF55',
        'priority' => 80,
        'tab_list_order' => 5
    ];

    const YOUTUBER = [
        'name' => 'YOUTUBER',
        'display_name' => 'Youtuber',
        'prefix' => '[YT] ',
        'color' => '#FF5555',
        'priority' => 75,
        'tab_list_order' => 6
    ];

    const BUILDER = [
        'name' => 'BUILDER',
        'display_name' => 'Builder',
        'prefix' => '[Builder] ',
        'color' => '#FF55FF',
        'priority' => 60,
        'tab_list_order' => 9
    ];

    const ULTIMATE = [
        'name' => 'ULTIMATE',
        'display_name' => 'Ultimate',
        'prefix' => '[Ultimate] ',
        'color' => '#55FFFF',
        'priority' => 70,
        'tab_list_order' => 7
    ];

    const PREMIUM = [
        'name' => 'PREMIUM',
        'display_name' => 'Premium',
        'prefix' => '[Premium] ',
        'color' => '#FFFF55',
        'priority' => 65,
        'tab_list_order' => 8
    ];

    const DEFAULT = [
        'name' => 'DEFAULT',
        'display_name' => 'Default',
        'prefix' => '',
        'color' => '#AAAAAA',
        'priority' => 0,
        'tab_list_order' => 100
    ];

}
