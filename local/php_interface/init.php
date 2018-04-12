<?
///const
define('PRODUCTS_IBLOCK_ID', 2);
define('SERVICES_IBLOCK_ID', 3);
define('METATAGS_IBLOCK_ID', 6);
define('NEWS_REPORT_IBLOCK_ID', 8);
define('CONTENT_EDITORS_GROUP_ID', 5);

////////include
$arInc = ['event_handler',
          'agents'];


foreach ($arInc as $file)
{
	$path_inc = dirname(__FILE__) . '/inc/' . $file . '.php';
	if (file_exists($path_inc))
		include_once($path_inc);
}
unset($path_inc);
unset($arInc);

//отладочная функция, пишет в файл /debug_$fname.txt массивы и переменные
function mydebug(&$string, $die = false, $fname = '')
{
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/debug_' . $fname . '.txt',
	                  date('H:i:s') . PHP_EOL . mydump($string));
	if ($die)
		die();
}