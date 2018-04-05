<?
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', Array("EventHandler", "cancel_production_deactivate"));
AddEventHandler('main', 'OnBeforeEventSend', Array("EventHandler", "set_author_from_feedback_form"));

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

	function set_author_from_feedback_form(&$arFields, &$arTemplate)
	{

		if ($arTemplate['EVENT_NAME'] != 'FEEDBACK_FORM')
			return;

		global $USER;

		$old = $arFields['AUTHOR'];

		if ($USER->IsAuthorized())
			$arFields['AUTHOR'] = 'Пользователь авторизован: '
			                      . $USER->GetID()
			                      . ' ('
			                      . $USER->GetLogin()
			                      . ') '
			                      . $USER->GetFullName()
			                      . ', данные из формы: '
			                      . $arFields['AUTHOR'];
		else
			$arFields['AUTHOR'] = 'Пользователь не авторизован, данные из формы: ' . $arFields['AUTHOR'];

		CEventLog::Log('INFO', 'FEEDBACK_AUTHOR_REPLACE', 'main', $old, $arFields['AUTHOR']);
	}
}