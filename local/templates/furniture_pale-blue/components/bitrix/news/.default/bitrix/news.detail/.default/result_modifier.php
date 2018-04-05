<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if ($arParams["CANONICAL_ID"] and CModule::IncludeModule('iblock'))
{
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID'     => $arParams["CANONICAL_ID"],
	                                'PROPERTY_NEWS' => $arResult['ID']],
	                               false,
	                               false,
	                               ['NAME']);
	$arResult['CANONICAL_URL'] = $Res->Fetch()['NAME'];
	$this->__component->setResultCacheKeys('CANONICAL_URL');
}