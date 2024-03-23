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
	 * @return array
	 */
	static function LanguageList() : array
	{
		//	...
		$key = __FILE__.__LINE__;
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
	static function Fetch(array $strings, string $to_lang, string $from_lang='') : string
	{
		//	Cache
		$cache_key = json_encode($strings) . ", $to_lang, $from_lang";
		$cache_key = md5($cache_key);
		$cache_key = substr($cache_key, 0, 10);
		if( $json  = apcu_fetch($cache_key) ){
			D('Hit apcu!');
			return $json;
		}

		//	...
		$config = OP()->Config('microsoft_translate');
		$region = $config['region'] ?? null;
		$apikey = $config['Ocp-Apim-Subscription-Key'] ?? null;

		//	Secret API key
		if(!$apikey ){
			self::Errors("Config('Ocp-Apim-Subscription-Key') is empty.");
			return [];
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

		//	Fetch translation strings.
		$json = `curl --silent -X POST "https://api.cognitive.microsofttranslator.com/translate?{$query}" \
		-H "Ocp-Apim-Subscription-Region: {$region}" \
		-H "Ocp-Apim-Subscription-Key: {$apikey}" \
		-H "Content-Type: application/json; charset=UTF-8" \
		-d "[{$text}]"`;

		//	Save to cache.
		if( $json ){
			apcu_store($cache_key, $json);
		}

		//	Return result json.
		return $json ?? '';
	}

	/** Get internal errors.
	 *
	 * <pre>
	 * //  Set
	 * self::Errors('Error message.');
	 *
	 * //  Get
	 * $error_message = self::Errors();
	 * </pre>
	 *
	 * @param string $message
	 * @return string
	 */
	static function Errors(?string $message=null) : string
	{
		//	...
		static $_messages = [];

		//	...
		if( $message ){
			$_messages[] = $message;
			return '';
		}

		//	...
		return array_shift($_messages) ?? '';
	}

	/** Cache
	 *
	 * @param  string $cache_key
	 * @param  string $cache_value
	 * @return string
	 */
	static function _Cache(string $cache_key, string $cache_value=null) : ?string
	{
		//	...
		if(!$cache_type = OP()->Config('microsoft_translate')['cache'] ?? null ){
			return null;
		}

		//	...
		if(!OP()->Unit()->isInstalled('Cache') ){
			return null;
		}

		//	...
		return OP()->Unit('Cache')->{$cache_type}($cache_key, $cache_value);
	}
}
