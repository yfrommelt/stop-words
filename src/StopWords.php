<?php

namespace Yfrommelt;

class StopWords
{
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
        $delimiters = [' ', '.', '-', '/'];

        $str = mb_convert_case($str, MB_CASE_TITLE, $encoding);

        foreach ($delimiters as $delimiter) {
            $words = explode($delimiter, $str);
            $keeps = [];
            foreach ($words as $word) {
                $lower = mb_strtolower($word, $encoding);
                if (in_array($lower, $stopWords)) {
                    $word = $lower;
                } else {
                    $word = ucfirst($word);
                }
                array_push($keeps, $word);
            }
            $str = join($delimiter, $keeps);
        }

        return $str;
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
        $delimiters = [' ', '.', '-', '/'];

        $str = mb_strtolower($str, $encoding);

        foreach ($delimiters as $delimiter) {
            $words = explode($delimiter, $str);
            $keeps = [];
            foreach ($words as $word) {
                if (!in_array($word, $stopWords)) {
                    array_push($keeps, $word);
                }
            }
            $str = join('-', $keeps);
        }

        return $str;
    }
}