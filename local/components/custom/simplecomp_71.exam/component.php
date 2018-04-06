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
foreach ($arParams as &$val)
	if (substr($val, 0, 1) != '~')
	{
		$val = trim($val);
		if (is_numeric($val))
			$val = intval($val);
	};
unset($val);

//check input vars
if (!$arParams['PRODUCTS_IBLOCK_ID'] or !$arParams['PRODUCTS_LINK_CODE'] or !$arParams['CLASS_IBLOCK_ID'])
	return;

/**@var $this CBitrixComponent */
if ($this->startResultCache($USER->GetGroups()))
{

	$Res = CIBlockElement::GetList(false,
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
	                                'ID',
	                                'IBLOCK_SECTION_ID']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	while ($item = $Res->Fetch())
	{
		$item['DETAIL_PAGE_URL'] = str_replace(['#SITE_DIR#', '#SECTION_ID#', '#ID#'],
		                                       [SITE_DIR == '/' ? '' : SITE_DIR,
		                                        $item['IBLOCK_SECTION_ID'],
		                                        $item['ID']],
		                                       $arParams['PRODUCTS_URL_TEMPLATE']);
		$arResult[$arParams['PRODUCTS_LINK_CODE']][$item['PROPERTY_COMPANY_NAME']][] = $item;
	}


	//end
	$arResult['COUNT'] = count($arResult[$arParams['PRODUCTS_LINK_CODE']]);
	$this->setResultCacheKeys('COUNT');

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("COUNT") . $arResult['COUNT']);
