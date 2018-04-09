<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент_58");
?><?$APPLICATION->IncludeComponent(
	"custom:simplecomp_58.exam",
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"NEWS_IBLOCK_ID" => "1",
		"NEWS_LINK_CODE" => "AUTHOR",
		"UF_CODE" => "UF_AUTHOR_TYPE",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600000"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>