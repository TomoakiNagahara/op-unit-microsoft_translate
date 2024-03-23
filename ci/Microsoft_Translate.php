<?php
/** op-unit-microsoft_translate:/ci/Microsoft_Translate.php
 *
 * @created     2024-03-21
 * @version     1.0
 * @package     op-unit-microsoft_translate
 * @author      Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright   Tomoaki Nagahara All right reserved.
 */

/** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT\CI\CI_Config;

/* @var $ci  */
$ci = OP()->Unit('CI')->Config();

//	Template
$arg1   = 'foo';
$arg2   = 'bar';
$args   = ['ci.phtml',['arg1'=>$arg1, 'arg2'=>$arg2]];
$result = $arg1 . $arg2;
$ci->Set('Template', $result, $args);

/*
//	...
$ms_translate = OP()->Unit('Microsoft_Translate');
$json   = $ms_translate->LanguageList();
$json   = json_encode($json);
file_put_contents('LanguageList.json', $json);
*/

//	...
$method = 'LanguageList';
$args   =  null;
$json   = file_get_contents('LanguageList.json');
$result = json_decode($json, true);
$ci->Set($method, $result, $args);

//	...
$method = 'Fetch';
$args   = [['The "NEW WORLD" is a new world.','The onepiece-framework is insanely great!!'], 'ja', 'en'];
$result = '[{"detectedLanguage":{"language":"en","score":1.0},"translations":[{"text":"「NEW WORLD」は新しい世界です。","to":"ja"}]},{"detectedLanguage":{"language":"en","score":1.0},"translations":[{"text":"ワンピースフレームワークはめちゃくちゃ素晴らしいです!","to":"ja"}]}]';
$ci->Set($method, $result, $args);

//	...
$method = 'Errors';
$args   = '';
$result = '';
$ci->Set($method, $result, $args);

//	...
$method = 'Errors';
$args   = 'This is CI test.';
$result = '';
$ci->Set($method, $result, $args);

//	...
$method = 'Errors';
$args   = '';
$result = 'This is CI test.';
$ci->Set($method, $result, $args);

//	...
$method = '_Cache';
$args   = ['key','value'];
$result =  null;
$ci->Set($method, $result, $args);

//	...
return $ci->Get();
