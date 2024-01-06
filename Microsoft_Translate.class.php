<?php
/** op-unit-microsoft_translate:/MicrosoftTranslate.class.php
 *
 * @created    2024-01-05
 * @version    1.0
 * @package    op-unit-microsoft_translate
 * @author     Tomoaki Nagahara <tomoaki.nagahara@gmail.com>
 * @copyright  Tomoaki Nagahara All right reserved.
 */

 /** Declare strict
 *
 */
declare(strict_types=1);

/** namespace
 *
 */
namespace OP\UNIT;

/** use
 *
 */
use OP\IF_UNIT;
use OP\OP_CORE;
use OP\OP_CI;

/** Microsoft
 *
 */
class Microsoft_Translate implements IF_UNIT
{
	/** use
	 *
	 */
	use OP_CORE, OP_CI;

	/** Microsoft Translate Language List.
	 *
	 */
	static function LanguageList() : array
	{
		//	...
		$key = __FILE__;
		$key = md5($key);
		$key = substr($key, 0, 10);

		//	...
		if(!$json = apcu_fetch($key) ){
			$json = `curl -sS "https://api.cognitive.microsofttranslator.com/languages?api-version=3.0&scope=translation"`;

			//	...
			apcu_store($key, $json);

			//	...
		//	D('fetched');
		}else{
		//	D('stored');
		}

		//	...
		return json_decode($json, true)['translation'];
	}
}
