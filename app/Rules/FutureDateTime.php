<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class FutureDateTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Parse the given datetime value
        $dateTime = Carbon::parse($value);

        // Check if the given datetime is greater than or equal to the current datetime
        return $dateTime->greaterThanOrEqualTo(Carbon::today());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a date and time that is not in the past.';
    }
}
