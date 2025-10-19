<?php

namespace App\Helpers;

class ValidationHelper
{
    /**
     * Format validation errors untuk ditampilkan di alert
     */
    public static function formatErrors($errors)
    {
        $formatted = [];

        foreach ($errors->all() as $error) {
            $formatted[] = $error;
        }

        return $formatted;
    }

    /**
     * Get error messages by field
     */
    public static function getFieldErrors($errors, $field)
    {
        return $errors->get($field);
    }

    /**
     * Check if has errors
     */
    public static function hasErrors($errors)
    {
        return $errors->any();
    }
}
