<?php

namespace App\Extensions\Permission;

use BenSampo\Enum\Enum;

final class Group extends Enum
{
    const MASTER = [
        'display_name' => 'Master',
        'color' => '#FFAA00',
        'priority' => 11
    ];

    const MANAGER = [
        'display_name' => 'Manager',
        'color' => '#AA0000',
        'priority' => 10
    ];

    const ADMINISTRATOR = [
        'display_name' => 'Admin',
        'color' => '#FF5555',
        'priority' => 9
    ];

    const MODERATOR = [
        'display_name' => 'Moderator',
        'color' => '#00AA00',
        'priority' => 8
    ];

    const HELPER = [
        'display_name' => 'Helper',
        'color' => '#55FF55',
        'priority' => 7
    ];

    const YOUTUBER = [
        'display_name' => 'Youtuber',
        'color' => '#FF5555',
        'priority' => 6
    ];

    const MVP = [
        'display_name' => 'MVP',
        'color' => '#55FFFF',
        'priority' => 5
    ];

    const VIP_PLUS = [
        'display_name' => 'VIP+',
        'color' => '#FFFF55',
        'priority' => 4
    ];

    const VIP = [
        'display_name' => 'VIP',
        'color' => '#FFFF55',
        'priority' => 3
    ];

    const BUILDER = [
        'display_name' => 'Builder',
        'color' => '#FF55FF',
        'priority' => 2
    ];

    const DEFAULT = [
        'display_name' => 'Member',
        'color' => '#AAAAAA',
        'priority' => 1
    ];
}
