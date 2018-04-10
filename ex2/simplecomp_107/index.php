<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент_107");
?><?$APPLICATION->IncludeComponent(
	"custom:simplecomp_107.exam",
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PRODUCTS_LINK_CODE" => "COMPANY",
		"PRODUCTS_URL_TEMPLATE" => "/#SITE_DIR#/products/#SECTION_ID#/#ID#/",
		"CLASS_IBLOCK_ID" => "7",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>