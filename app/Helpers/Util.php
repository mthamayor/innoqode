<?php
namespace App\Helpers;

class Util
{
    /**
     * Checks if the value contains any characters passed in
     *
     * @param  string  $characters Characters being looked up against
     * @param string $value The word being iterated on
     * @return bool
     */
    public static function containsChar($characters, $value)
    {
        $stringArray = str_split($value);
        $charactersArray = str_split($characters);
        foreach ($stringArray as $char) {
            if (in_array($char, $charactersArray)) {
                return true;
            }
        }
        return false;
    }
}
