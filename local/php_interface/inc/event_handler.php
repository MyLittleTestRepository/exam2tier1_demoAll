<?
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', Array("EventHandler", "cancel_production_deactivate"));


class EventHandler
{

	function cancel_production_deactivate(&$arFields)
	{

		if ($arFields['IBLOCK_ID'] != PRODUCTS_IBLOCK_ID) //if products
			return;

		if ($arFields['ACTIVE'] != 'N') //if deactivate
			return;

		if (!CModule::IncludeModule('iblock'))
			return;

		$item = CIBlockElement::GetByID($arFields['ID'])->Fetch();

		if ($item['ACTIVE'] != 'Y') //if active
			return;

		if ($item['SHOW_COUNTER'] <= 2) //if popular
			return;

		$GLOBALS['APPLICATION']->ThrowException('Товар невозможно деактивировать, у него '
		                                        . $item['SHOW_COUNTER']
		                                        . ' просмотров');
		return false;
	}
}