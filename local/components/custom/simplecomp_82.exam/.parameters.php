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
		"PRODUCTS_LINK_CODE" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("PRODUCTS_LINK_CODE"),
			"TYPE" => "STRING",
			'DEFAULT' => 'COMPANY',
		),
		"PRODUCTS_URL_TEMPLATE" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("PRODUCTS_URL_TEMPLATE"),
			"TYPE" => "STRING",
			'DEFAULT' => '/#SITE_DIR#/products/#SECTION_ID#/#ID#/',
		),
		"CLASS_IBLOCK_ID" => array(
			'PARENT' => 'BASE',
			"NAME" => GetMessage("CLASS_IBLOCK_ID"),
			"TYPE" => "STRING",
			'DEFAULT' => '7',
		),
		'CACHE_TIME' => array('DEFAULT' => '3600000'),
	),
);