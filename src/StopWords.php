<?php

namespace Yfrommelt;

class StopWords
{
    const PREG_SPLIT_PATTERN = '/([\s\.\-\'\"\/])/';
    /**
     * @param string $locale
     * @return array
     * @throws \Exception
     */
    public static function get($locale = 'en')
    {
        $locales = [
            'da' => 'danish.stop',
            'nl' => 'dutch.stop',
            'en' => 'english.stop',
            'fi' => 'finnish.stop',
            'fr' => 'french.stop',
            'de' => 'german.stop',
            'hu' => 'hungarian.stop',
            'it' => 'italian.stop',
            'no' => 'norwegian.stop',
            'pt' => 'portuguese.stop',
            'ru' => 'russian.stop',
            'es' => 'spanish.stop',
            'sv' => 'swedish.stop',
            'tr' => 'turkish.stop',
        ];

        if (!isset($locales[$locale])) {
            throw new \Exception(sprintf('unsupported "%s" locale', $locale));
        }

        return file(
            sprintf('%s/dictionary/%s', __DIR__, $locales[$locale]),
            FILE_IGNORE_NEW_LINES
        );
    }

    /**
     * @param string $locale
     * @param string $str
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public static function toTitleCase($locale, $str, $encoding = 'UTF-8')
    {
        $stopWords = self::get($locale);

        $str = mb_strtolower($str, $encoding);
        $words = preg_split(self::PREG_SPLIT_PATTERN, $str, -1, PREG_SPLIT_DELIM_CAPTURE);
        $keeps = [];
        foreach ($words as $word) {
            if (!in_array($word, $stopWords)) {
                $word = self::mb_ucfirst($word);
            }
            array_push($keeps, $word);
        }

        return implode('', $keeps);
    }

    /**
     * @param string $locale
     * @param string $str
     * @param string $encoding
     * @return string
     * @throws \Exception
     */
    public static function toSlug($locale, $str, $encoding = 'UTF-8')
    {
        $stopWords = self::get($locale);

        $str = mb_strtolower($str, $encoding);
        $words = preg_split(self::PREG_SPLIT_PATTERN, $str);
        $keeps = [];
        foreach ($words as $word) {
            if (!in_array($word, $stopWords)) {
                array_push($keeps, $word);
            }
        }
        return implode('-', $keeps);
    }

    /**
     * @param string $str
     * @param string $encoding
     * @return string
     */
    public static function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($str, $encoding);
        $firstChar = mb_substr($str, 0, 1, $encoding);
        $then = mb_substr($str, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
}