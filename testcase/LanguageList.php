<?php
/** op-unit-microsoft_translate:/testcase/LanguageList.php
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
namespace OP\UNIT\Microsoft_Translate;

/** use
 *
 */

/* @var $microsoft_translate \OP\UNIT\Microsoft_Translate */
$microsoft_translate = OP()->Unit('Microsoft_Translate');

//	...
D( $microsoft_translate->LanguageList() );
