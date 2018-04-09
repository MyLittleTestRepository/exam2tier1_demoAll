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
if (!$arParams['PRODUCTS_IBLOCK_ID'] or !$arParams['NEWS_IBLOCK_ID'] or !$arParams['NEWS_LINK_CODE'])
	return;

/**@var $this CBitrixComponent */
if ($this->startResultCache())
{

	//get sections
	$Res = CIBlockSection::GetList(false,
	                               ['IBLOCK_ID'                       => $arParams['PRODUCTS_IBLOCK_ID'],
	                                '!' . $arParams['NEWS_LINK_CODE'] => false,
	                                'ACTIVE'                          => 'Y'],
	                               false,
	                               [$arParams['NEWS_LINK_CODE'], 'NAME', 'ID'],
	                               false);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	while ($sect = $Res->Fetch())
	{
		$arResult['SECTIONS'][$sect['ID']]['NAME'] = $sect['NAME'];
		foreach ($sect['UF_NEWS_LINK'] as $news_id)
			$arResult['NEWS'][$news_id]['SECTIONS_ID'][] = $sect['ID'];
	}


	//get products
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID'         => $arParams['PRODUCTS_IBLOCK_ID'],
	                                'ACTIVE'            => 'Y',
	                                'IBLOCK_SECTION_ID' => array_keys($arResult['SECTIONS']),],
	                               false,
	                               false,
	                               ['ID',
	                                'IBLOCK_SECTION_ID',
	                                'NAME',
	                                'PROPERTY_PRICE',
	                                'PROPERTY_MATERIAL',
	                                'PROPERTY_ARTNUMBER']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	$prod_count = $Res->SelectedRowsCount();

	while ($item = $Res->Fetch())
		$arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']] = $item;


	//get news
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
	                                'ACTIVE'    => 'Y',
	                                'ID'        => array_keys($arResult['NEWS'])],
	                               false,
	                               false,
	                               ['ID',
	                                'NAME',
	                                'DATE_ACTIVE_FROM']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	while ($item = $Res->Fetch())
		$arResult['NEWS'][$item['ID']]['ITEM'] = $item;


	//end
	$arResult['COUNT'] = $prod_count;
	$this->setResultCacheKeys(['COUNT']);

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("COUNT") . $arResult['COUNT']);
