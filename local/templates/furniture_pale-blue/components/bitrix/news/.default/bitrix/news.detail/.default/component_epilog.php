<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if ($arResult['CANONICAL_URL'])
	$APPLICATION->SetPageProperty('canonical', '<link rel="canonical" href="' . $arResult['CANONICAL_URL'] . '">');