<?php

namespace Misc\Utils;

class FormValidator
{

    public static function isNotEmpty(... $objects) {
        foreach ($objects as $object) {
            if (empty($object)) {
                // return [
                //     'status' => 'fail',
                //     'message' => $object()->key . 'is null or empty'
                // ];
                return false;
            }
        }

        // return [
        //     'status' => 'ok'
        // ];
        return true;
    }

}
