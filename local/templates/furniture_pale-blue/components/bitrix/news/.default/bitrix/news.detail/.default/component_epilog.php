<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if ($arResult['CANONICAL_URL'])
	$APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL_URL']);