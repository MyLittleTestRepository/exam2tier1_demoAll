<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент_82");
?><?$APPLICATION->IncludeComponent(
	"custom:simplecomp_82.exam",
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PRODUCTS_LINK_CODE" => "COMPANY",
		"PRODUCTS_URL_TEMPLATE" => "/catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"CLASS_IBLOCK_ID" => "7",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>