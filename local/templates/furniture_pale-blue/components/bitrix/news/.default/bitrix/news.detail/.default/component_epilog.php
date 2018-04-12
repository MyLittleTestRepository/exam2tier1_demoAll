<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if ($arResult['CANONICAL_URL'])
	$APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL_URL']);

//ex2-104
if (isset($_GET['report']) and empty($_GET['report']) and CModule::IncludeModule('iblock')) //срабатываем однажды
{
	if ($USER->IsAuthorized())
		$user = '[' . $USER->GetID() . '] ' . $USER->GetLogin() . ' (' . $USER->GetFullName() . ')';
	else
		$user = GetMessage("NO_AUTH");

	$arFields = [];
	$arFields['NAME'] = 'report';
	$arFields['DATE_ACTIVE_FROM'] = ConvertTimeStamp(false, "FULL");
	$arFields['IBLOCK_ID'] = NEWS_REPORT_IBLOCK_ID;
	$arFields['PROPERTY_VALUES'] = ['NEWS' => $arParams['ELEMENT_ID'],
	                                'USER' => $user];
	$element = new CIBlockElement();
	$id = $element->Add($arFields);

	if ($arParams['AJAX_REPORT'] == 'Y')
	{
		$APPLICATION->RestartBuffer();
		echo $id;
		die();
	}
	else
		LocalRedirect($APPLICATION->GetCurPageParam("report=" . $id, ['report'])); //посылаем ответ в гет-режиме
}

//передаем параметры в js браузера
?>
<script type="text/javascript">
    const AJAX_MODE =<?=json_encode($arParams['AJAX_REPORT'])?>; //пробрасываем режим работы
    const PAGE_URL =<?=json_encode($APPLICATION->GetCurPage())?>; //адрес странички
    const REPORT_ID =<?=json_encode($_GET['report'])?>; //и айди запроса для гет-режима
</script>
