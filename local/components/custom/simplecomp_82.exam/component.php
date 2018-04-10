<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

if (!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

//clear input vars
foreach ($arParams as $key => $val)
	if (substr($val, 0, 1) != '~')
	{
		$arParams[$key] = trim($val);
		if (is_numeric($val))
			$arParams[$key] = intval($val);
	};

//check input vars
if (!$arParams['PRODUCTS_IBLOCK_ID'] or !$arParams['PRODUCTS_LINK_CODE'] or !$arParams['CLASS_IBLOCK_ID'])
	return;

/**@var $this CBitrixComponent */
if ($this->startResultCache(false, $USER->GetGroups()))
{

	$Res = CIBlockElement::GetList(['name', 'sort'],
	                               ['CHECK_PERMISSIONS'                                       => 'Y',
	                                'IBLOCK_ID'                                               => $arParams['PRODUCTS_IBLOCK_ID'],
	                                'ACTIVE'                                                  => 'Y',
	                                'PROPERTY_' . $arParams['PRODUCTS_LINK_CODE'] . '.ACTIVE' => 'Y',],
	                               false,
	                               false,
	                               ['NAME',
	                                'PROPERTY_PRICE',
	                                'PROPERTY_MATERIAL',
	                                'PROPERTY_ARTNUMBER',
	                                'PROPERTY_' . $arParams['PRODUCTS_LINK_CODE'] . '.NAME',
	                                'DETAIL_PAGE_URL']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	$Res->SetUrlTemplates($arParams['PRODUCTS_URL_TEMPLATE']);

	$arResult['MAX'] = null;
	$arResult['MIN'] = null;

	while ($item = $Res->GetNext())
	{

		if (is_null($arResult['MIN']))
			$arResult['MIN'] = $item['PROPERTY_PRICE_VALUE'];

		$arResult['MAX'] = max($arResult['MAX'], $item['PROPERTY_PRICE_VALUE']);
		$arResult['MIN'] = min($arResult['MIN'], $item['PROPERTY_PRICE_VALUE']);

		$arResult[$arParams['PRODUCTS_LINK_CODE']][$item['PROPERTY_' . $arParams['PRODUCTS_LINK_CODE'] . '_NAME']][]
			= $item;
	}


	//end
	$arResult['COUNT'] = count($arResult[$arParams['PRODUCTS_LINK_CODE']]);
	$this->setResultCacheKeys(['COUNT', 'MAX', 'MIN']);

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("COUNT") . $arResult['COUNT']);