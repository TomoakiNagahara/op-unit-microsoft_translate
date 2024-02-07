<?php
/** op-unit-microsoft_translate:/config.php
 *
 * @created    2024-01-06
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

//	...
$config = [
	//	Microsoft Translator API v3
	'Ocp-Apim-Subscription-Key' => null,
	'region'   => 'japaneast',
	'cache'    => 'apcu', // false, file, apcu, memcache, database
	'database' => 'sqlite://user_name:password@localhost/database_name/table_name',
];

//	...
return $config;
