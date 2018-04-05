<?
///const
define('PRODUCTS_IBLOCK_ID', 2);
define('CONTENT_EDITORS_GROUP_ID', 5);

////////include
$arInc = ['event_handler'];


foreach ($arInc as $file)
{
	$path_inc = dirname(__FILE__) . '/inc/' . $file . '.php';
	if (file_exists($path_inc))
		include_once($path_inc);
}
unset($path_inc);
unset($arInc);

function mydebug(&$string, $die = false)
{
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/debug.txt', date('H:i:s').PHP_EOL.mydump($string));
	if ($die)
		die();
}