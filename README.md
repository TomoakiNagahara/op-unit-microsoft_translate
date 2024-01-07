Microsoft Translation
===

```php
/* @var  $ms_translate \OP\UNIT\Microsoft_Translate */
$ms_translate = OP()->Unit('Microsoft_Translate');

//  Language list.
D( $ms_translate->LanguageList() );

//  Do the Translate. Source language is auto detect.
echo $ms_translate->Fetch(['Hello new world!!'], 'ja');
```
