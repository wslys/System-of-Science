<?php

namespace App\Common\Services;


class FormTool {

    public static function fieldError($messages, $field) {
        if (!isset($messages)) return null;

        foreach ($messages as $message) {
            if ($message->getField() == $field) {
                return $message->getMessage();
            }
        }

        return null;
    }
}