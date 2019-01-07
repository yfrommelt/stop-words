# stop-words

## Installation
```bash
composer require yfrommelt/stop-words
```

## Usage 
```php
use Yfrommelt\StopWords;

// Get au list of stop words
StopWords::get('fr')

// Transform a string to title case
$str = "Marie A Un Petit Agneau Et Elle L'Aime BEAUCOUP.";
$str = StopWords::toTitleCase('fr', $str);
echo $str; // Marie A un Petit Agneau et elle l'Aime Beaucoup.

// Transform a string to slug
$str = "Marie A Un Petit Agneau Et Elle L'Aime BEAUCOUP.";
$str = StopWords::toSlug('fr', $str);
echo $str; // marie-a-petit-agneau-aime-beaucoup
```
