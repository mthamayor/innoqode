<?php

namespace App\Rules;

use App\Helpers\Util;
use Illuminate\Contracts\Validation\Rule;

class Username implements Rule
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
        $noSpaces = ($value == trim($value) && strpos($value, ' ') !== false) ? false : true;

        $specialCharacters = '!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~';

        $specialCharactersExclude = '!"#$%&\'()*+,-/:;<=>?@[\]^`{|}~'; // Exclude underscore and period

        $startWithSpecialChars = in_array($value[0], str_split($specialCharacters));

        $endsWithSpecialChars = in_array($value[strlen($value) - 1], str_split($specialCharacters));

        $containsSpecialCharsExclude = Util::containsChar($specialCharactersExclude, $value);

        $moreThanOnePeriod = substr_count($value, '.') > 1 ? true : false;

        
        return (
            $noSpaces
            && !$startWithSpecialChars
            && !$endsWithSpecialChars
            && !$moreThanOnePeriod
            && !$containsSpecialCharsExclude
        ) ? true: false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute should have no spaces, accept ' .
                'only one period, multiple underscores ' .
                'and must not start or end with special characters.';
    }
}
