<?php // phpcs:ignore

namespace Tests\ChasterApp;

use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../src/Utils/functions.php';

class UtilsTest extends TestCase
{
    /**
     * @dataProvider providerTestArrayKeysExistReturnTrue
     * @param array $keys
     * @param array $array
     * @return void
     */
    public function testArrayKeysExistReturnTrue(array $keys, array $array): void
    {
        $this->assertTrue(array_keys_exist($keys, $array));
    }

    #[ArrayShape([
        '1 key is into 3 keys array' => "array",
        '2 keys are into 3 keys array' => "array",
        '3 keys are into 3 keys array' => "array"
    ])] public function providerTestArrayKeysExistReturnTrue(): array
    {
        return [
            '1 key is into 3 keys array' => [
                'keys' => ['key_2'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '2 keys are into 3 keys array' => [
                'keys' => ['key_1', 'key_2'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '3 keys are into 3 keys array' => [
                'keys' => ['key_1', 'key_2', 'key_3'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ]
        ];
    }

    /**
     * @dataProvider providerTestArrayKeysExistReturnFalse
     * @param array $keys
     * @param array $array
     * @return void
     */
    public function testArrayKeysExistReturnFalse(array $keys, array $array): void
    {
        $this->assertFalse(array_keys_exist($keys, $array));
    }

    #[ArrayShape([
        'empty key array with 3 keys array' => "array",
        '1 not existing key with 3 keys array' => "array",
        '2 not existing keys with 3 keys array' => "array",
        '3 not existing keys with 3 keys array' => "array",
        '3 keys to check (2 valid keys + 1 not existing key) with 3 keys array' => "array",
        '4 keys to check (3 valid keys + 1 not existing key) with 3 keys array' => "array"
    ])] public function providerTestArrayKeysExistReturnFalse(): array
    {
        return [
            'empty key array with 3 keys array' => [
                'keys' => [],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '1 not existing key with 3 keys array' => [
                'keys' => ['key_4'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '2 not existing keys with 3 keys array' => [
                'keys' => ['key_4', 'key_5'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '3 not existing keys with 3 keys array' => [
                'keys' => ['key_4', 'key_5', 'key_6'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '3 keys to check (2 valid keys + 1 not existing key) with 3 keys array' => [
                'keys' => ['key_1', 'key_2', 'key_4'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],
            '4 keys to check (3 valid keys + 1 not existing key) with 3 keys array' => [
                'keys' => ['key_1', 'key_2', 'key_3', 'key_4'],
                'array' => [
                    'key_1' => 'value_1',
                    'key_2' => 'value_2',
                    'key_3' => 'value_3',
                ],
            ],

        ];
    }
}
