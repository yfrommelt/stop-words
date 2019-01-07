<?php

class StopWords
{
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

        return file(sprintf('dictionary/%s', $locales[$locale]), FILE_IGNORE_NEW_LINES);
    }
}