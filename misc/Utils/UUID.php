<?php

namespace Misc\Utils;

class UUID
{

    public static function fromString($string) {
        return implode('-', [
            substr($string, 0, 8),
            substr($string, 8, 4),
            substr($string, 12, 4),
            substr($string, 16, 4),
            substr($string, 20)
        ]);
    }

}
