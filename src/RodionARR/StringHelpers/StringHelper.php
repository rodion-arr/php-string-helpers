<?php

namespace RodionARR\StringHelpers;

/**
 * Trait StringHelper
 * A set of helper function for string operations.
 */
trait StringHelper
{
    private $nbspUnicode = "\xc2\xa0";

    /**
     *
     * @param string $string
     *
     * @return string
     */
    protected function toUpperCase(string $string): string
    {
        $words = explode(' ', $string);
        $first = mb_convert_case($words[0], MB_CASE_TITLE);
        unset($words[0]);

        return trim($first.' '.implode(' ', $words));
    }

    /**
     * Removes incorrect dots, braces, commas, spaces from passed string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function cleanUpString(string $string): string
    {
        $replaceToEmpty = [
            '.....',
            '...',
            '..',
            '«',
            '»',
            '– –',
            '- -',
            '—,',
            '—.',
            '-.',
            '-,',
            '.,',
            '-:,',
            ':,',
            '()',
            ' ! ',
            '[]',
            '✓',
            '✈',
            '. —',
            '. -',
            '""',
            ' 0.',
            ' · ',
            '{{',
            '}}',
            '+',
            '=',
            ' " ',
            ' \' ',
            'www.',
            'www',
            'https://',
            'https:',
            'https',
            'http://',
            'http:',
            'http',
            'http',
            '.com',
            '.com',
            '.net',
            '[pdf]',
            '(pdf)',
            'pdf',
            '[',
            ']',
            '<?php',
            '?>'
        ];
        $replaceSearch = [
            $this->nbspUnicode,
            ' .',
            ' ,',
            '   ',
            '  ',
            ') ',
            '( ',
            ' .',
            ':.',
            ' ?',
            ',.',
            ' : ',
            ',,',
            '..',
            '?,',
            '!,',
            '?.',
            '!.',
        ];
        $replaceTo = [
            ' ',
            '.',
            ',',
            ' ',
            ' ',
            ')',
            '(',
            '.',
            '.',
            '?',
            '.',
            '',
            ',',
            '.',
            ',',
            ',',
            '.',
            '.',
        ];

        for ($i = 0; $i < 3; ++$i) {
            $string = str_replace($replaceToEmpty, '', $string);
            $string = str_replace($replaceSearch, $replaceTo, $string);
        }

        //clear dates
        $string = preg_replace("/[\d]{1,2} (янв|фев|мар|апр|май|июн|июл|авг|сен|окт|ноя|дек) [\d]{4} /", '', $string);

        return trim($string);
    }

    /**
     * Adds last dot to string
     *
     * @param string $string
     * @return string
     */
    protected function addTrailingDot(string $string):string
    {
        $lastCharNoDotNeeded = ['!','?','.',];
        $lastChar = mb_substr($string, -1);
        return  in_array($lastChar, $lastCharNoDotNeeded) ? $string : $string.'.';
    }

    /**
     * Removes brackets from passed string.
     *
     * @param string $string
     *
     * @return string
     */
    protected function sanitizeBladeString(string $string): string
    {
        return str_replace(['(', ')', '{', '}', '\''], '', $string);
    }

    /**
     * Translits string using transliterator_transliterate(), also removes apostrophe from string.
     *
     * @param $word
     *
     * @return mixed
     */
    protected function translit($word)
    {
        $word = str_replace([$this->nbspUnicode, ' '], '-', $word);
        $word = str_replace(
            ['ʹ', '\\', '#', '/', '$', '(', ')', '[', ']', '§', '†', '•', '™', '"', '°', '‡', '±', 'µ', '>', '<', '\'', '"'],
            '',
            $word
        );

        $translit = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $word);
        $translit = str_replace(
            ['---', '--', '...', '>>', '€'],
            '',
            $translit
        );

        return $translit;
    }
}
