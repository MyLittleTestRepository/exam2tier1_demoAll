<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
			'DEFAULT' => '2',
		),
		"NEWS_IBLOCK_ID" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
			'DEFAULT' => '1',
		),
		"NEWS_LINK_CODE" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("NEWS_LINk_CODE"),
			"TYPE" => "STRING",
			'DEFAULT' => 'UF_NEWS_LINK',
		),
		"PAGE_SIZE" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("PAGE_SIZE"),
			"TYPE" => "STRING",
			'DEFAULT' => '1',
		),
		'CACHE_TIME' => array('DEFAULT' => '3600000'),
	),
);