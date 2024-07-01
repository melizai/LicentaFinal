<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ZipFile implements Rule
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
        // Check if the file is uploaded and if it has a valid zip MIME type
        return $value->isValid() && $value->getMimeType() === 'application/zip';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid zip file.';
    }
}
