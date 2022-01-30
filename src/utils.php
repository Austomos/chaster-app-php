<?php

/**
 * Check if keys exist in array
 * @param array $requiredKeys
 * @param array $arrayToCheck
 * @return bool
 */
function array_keys_exist(array $requiredKeys, array $arrayToCheck): bool
{
    $inputKeys = array_keys($arrayToCheck);
    $missingRequiredKeys = array_diff($requiredKeys, $inputKeys);
    return empty($missingRequiredKeys);
}