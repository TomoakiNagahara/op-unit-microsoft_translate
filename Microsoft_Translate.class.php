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

	/** Fetch from Microsoft translate API.
	 *
	 * @created 2024-01-07
	 * @param   array       $strings
	 * @param   string      $to_lang
	 * @param   string      $from_lang
	 * @return  void|string
	 */
	static function Fetch(array $strings, string $to_lang, string $from_lang=null)
	{
		//	...
		$config = OP()->Config('microsoft_translate');
		$region = $config['region'] ?? null;
		$apikey = $config['Ocp-Apim-Subscription-Key'] ?? null;

		//	Secret API key
		if(!$apikey ){
			self::Errors("Config('Ocp-Apim-Subscription-Key') is empty.");
			return;
		}

		//	Text format
		$txttype = 'html';

		//	Build URL Query
		$query = [];
		$query[] = "api-version=3.0";
		$query[] = "to={$to_lang}";
		$query[] = "textType={$txttype}";
		$query = join('&', $query);

		//	Build request strings.
		$text = [];
		foreach( $strings as $string ){
			$string = addslashes($string);
			$text[] = "{'Text':'{$string}'}";
		}
		$text = join(',', $text);

		//	...
		$json = `curl -X POST "https://api.cognitive.microsofttranslator.com/translate?{$query}" \
		-H "Ocp-Apim-Subscription-Region: {$region}" \
		-H "Ocp-Apim-Subscription-Key: {$apikey}" \
		-H "Content-Type: application/json; charset=UTF-8" \
		-d "[{$text}]"`;

		//	...
		return $json;
	}

	/** Get internal errors.
	 *
	 * @param string $message
	 * @return string
	 */
	static function Errors(?string $message=null)
	{
		//	...
		static $_messages = [];

		//	...
		if( $message ){
			$_messages[] = $message;
			return;
		}

		//	...
		return array_shift($_messages);
	}
}
