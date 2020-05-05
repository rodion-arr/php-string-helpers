<?php

namespace Test\RodionARR\StringHelpers;

use RodionARR\StringHelpers\StringHelper;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase
{
    private $clientClass;

    public function setUp(): void
    {
        $this->clientClass = new class {
            use StringHelper;

            public function toUpperCaseProxy(string $string)
            {
                return $this->toUpperCase($string);
            }

            public function cleanUpStringProxy(string $string)
            {
                return $this->cleanUpString($string);
            }

            public function addTrailingDotProxy(string $string)
            {
                return $this->addTrailingDot($string);
            }

            public function sanitizeBladeStringProxy(string $string)
            {
                return $this->sanitizeBladeString($string);
            }

            public function translitProxy(string $string)
            {
                return $this->translit($string);
            }
        };
    }

    /**
     * @dataProvider uppercaseDataProvider
     * @param $input
     * @param $expected
     */
    public function test_to_upper_case($input, $expected)
    {
        $this->assertSame($expected, $this->clientClass->toUpperCaseProxy($input));
    }

    public function uppercaseDataProvider()
    {
        return [
            'en'  => ['qwe', 'Qwe'],
            'en-sentence'  => ['qwe qwe ', 'Qwe qwe'],
            'en-correct'  => ['Qwe', 'Qwe'],
            'ru' => ['йцу', 'Йцу'],
            'ru-sentence' => ['йцу йцу', 'Йцу йцу'],
            'ru-correct' => ['Йцу', 'Йцу'],
        ];
    }

    /**
     * @dataProvider cleanUpDataProvider
     * @param $input
     * @param $expected
     */
    public function test_clean_up_string($input, $expected)
    {
        $this->assertSame($expected, $this->clientClass->cleanUpStringProxy($input));
    }

    public function cleanUpDataProvider()
    {
        return [
            ['qwe ..... qwe', 'qwe qwe'],
            ['https://', ''],
            ['https://', ''],
            ["\xc2\xa0".'qweqwe .', 'qweqwe.'],
            ['qweqwe?,', 'qweqwe,'],
            ['10 мар 2019 ', ''],
        ];
    }

    /**
     * @dataProvider trailingDotDataProvider
     * @param $input
     * @param $expected
     */
    public function test_add_trailing_dot($input, $expected)
    {
        $this->assertSame($expected, $this->clientClass->addTrailingDotProxy($input));
    }

    public function trailingDotDataProvider()
    {
        return [
            ['qwe', 'qwe.'],
            ['qwe qwe!', 'qwe qwe!'],
            ['qwe?', 'qwe?'],
            ['qwe.', 'qwe.'],
        ];
    }

    /**
     * @dataProvider sanitizeBladeStringDataProvider
     * @param $input
     * @param $expected
     */
    public function test_sanitize_blade_string($input, $expected)
    {
        $this->assertSame($expected, $this->clientClass->sanitizeBladeStringProxy($input));
    }

    public function sanitizeBladeStringDataProvider()
    {
        return [
            ['qwe', 'qwe'],
            ['\'{(qwe)}\'', 'qwe'],
        ];
    }

    /**
     * @dataProvider translitDataProvider
     * @param $input
     * @param $expected
     */
    public function test_translit($input, $expected)
    {
        $this->assertTrue(function_exists('transliterator_transliterate'));
        $this->assertSame($expected, $this->clientClass->translitProxy($input));
    }

    public function translitDataProvider()
    {
        return [
            ['Кверти 1', 'kverti-1'],
            ["жорА"."\xc2\xa0"."5", 'zora-5'],
        ];
    }
}
