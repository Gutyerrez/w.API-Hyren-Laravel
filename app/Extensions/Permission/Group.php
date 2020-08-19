<?php

namespace App\Extensions\Permission;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const MASTER = [
        'display_name' => 'Master',
        'prefix' => '[Master] ',
        'color' => '#FFAA00',
        'priority' => 100,
        'tab_list_order' => 1
    ];

    const MANAGER = [
        'display_name' => 'Manager',
        'prefix' => '[Manager] ',
        'color' => '#AA0000',
        'priority' => 95,
        'tab_list_order' => 2
    ];

    const ADMINISTRATOR = [
        'display_name' => 'Administrator',
        'prefix' => '[Admin] ',
        'color' => '#FF5555',
        'priority' => 90,
        'tab_list_order' => 3
    ];

    const MODERATOR = [
        'display_name' => 'Moderator',
        'prefix' => '[Moderator] ',
        'color' => '#00AA00',
        'priority' => 85,
        'tab_list_order' => 4
    ];

    const HELPER = [
        'display_name' => 'Helper',
        'prefix' => '[Helper] ',
        'color' => '#55FF55',
        'priority' => 80,
        'tab_list_order' => 5
    ];

    const YOUTUBER = [
        'display_name' => 'Youtuber',
        'prefix' => '[YT] ',
        'color' => '#FF5555',
        'priority' => 75,
        'tab_list_order' => 6
    ];

    const MVP = [
        'display_name' => 'MVP',
        'prefix' => '[MVP] ',
        'color' => '#55FFFF',
        'priority' => 70,
        'tab_list_order' => 7
    ];

    const VIP = [
        'display_name' => 'VIP',
        'prefix' => '[VIP] ',
        'color' => '#FFFF55',
        'priority' => 65,
        'tab_list_order' => 8
    ];

    const BUILDER = [
        'display_name' => 'Builder',
        'prefix' => '[Builder] ',
        'color' => '#FF55FF',
        'priority' => 60,
        'tab_list_order' => 9
    ];

    const DEFAULT = [
        'display_name' => 'Member',
        'prefix' => '',
        'color' => '#AAAAAA',
        'priority' => 0,
        'tab_list_order' => 100
    ];
}
