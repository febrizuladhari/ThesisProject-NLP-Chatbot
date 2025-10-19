<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class MinimumAge implements ValidationRule
{
    protected $minimumAge;

    public function __construct($minimumAge = 12)
    {
        $this->minimumAge = $minimumAge;
    }

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

        try {
            $birthDate = Carbon::parse($value);
            $today = Carbon::today();

            // Check if birth date is in the future
            if ($birthDate->greaterThan($today)) {
                $fail("Tanggal lahir tidak boleh lebih dari hari ini.");
                return;
            }

            // Calculate age
            $age = $birthDate->diffInYears($today);

            if ($age < $this->minimumAge) {
                $fail("Usia minimal harus {$this->minimumAge} tahun.");
            }
        } catch (\Exception $e) {
            $fail("Format tanggal lahir tidak valid.");
        }
    }
}
