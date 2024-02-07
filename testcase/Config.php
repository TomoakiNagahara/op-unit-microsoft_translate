<?php
/** op-unit-microsoft_translate:/testcase/Config.php
 *
 * @created    2024-01-07
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
namespace OP\UNIT\Microsoft_Translate;

/** use
 *
 */

$config = OP()->Config('microsoft_translate');
$config['Ocp-Apim-Subscription-Key'] = 'hidden';

//	...
D( $config );
