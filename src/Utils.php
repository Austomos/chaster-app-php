<?php

namespace ChasterApp;

class Utils
{
    /**
     * @param array $keys Mandatory. The keys to check.
     * @param array $array Mandatory. The array to check.
     *
     * @return bool True if all keys are present in the array.
     *
     * @link https://stackoverflow.com/a/13169599/18811398
     * @link https://www.php.net/manual/en/function.array-key-exists.php
     */
    public static function arrayKeysExist(array $keys, array $array): bool
    {
        return count($keys) > 0 && !array_diff_key(array_flip($keys), $array);
    }
}
