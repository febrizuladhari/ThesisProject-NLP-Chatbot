<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndonesianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            return;
        }

        // Remove spaces, dashes, and other common separators
        $phone = preg_replace('/[\s\-\(\)]+/', '', $value);

        // Check if it starts with valid Indonesian prefixes
        $validPrefixes = ['08', '62', '+62'];
        $startsWithValid = false;

        foreach ($validPrefixes as $prefix) {
            if (str_starts_with($phone, $prefix)) {
                $startsWithValid = true;
                break;
            }
        }

        if (!$startsWithValid) {
            $fail('Nomor telepon harus diawali dengan 08, 62, atau +62.');
            return;
        }

        // Normalize to 08 format for length checking
        $normalized = $phone;
        if (str_starts_with($phone, '+62')) {
            $normalized = '0' . substr($phone, 3);
        } elseif (str_starts_with($phone, '62')) {
            $normalized = '0' . substr($phone, 2);
        }

        // Check length (11-13 digits for 08 format)
        $length = strlen($normalized);
        if ($length < 11 || $length > 13) {
            $fail('Nomor telepon harus terdiri dari 11-13 digit.');
            return;
        }

        // Check if only contains numbers (after removing prefix)
        if (!preg_match('/^[0-9]+$/', $normalized)) {
            $fail('Nomor telepon hanya boleh berisi angka.');
        }
    }
}
