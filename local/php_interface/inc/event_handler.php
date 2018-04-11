<?
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', Array("EventHandler", "cancel_production_deactivate"));
AddEventHandler('main', 'OnBeforeEventSend', Array("EventHandler", "set_author_from_feedback_form"));
AddEventHandler('main', 'OnBuildGlobalMenu', Array("EventHandler", "simple_content_editors_admin_menu"));
AddEventHandler('main', 'OnEpilog', Array("EventHandler", "set_additional_page_property"));

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

	function simple_content_editors_admin_menu(&$aGlobalMenu, &$aModuleMenu)
	{

		global $USER;

		if ($USER->IsAdmin()) //if no admin
			return;

		if (!CSite::InGroup([CONTENT_EDITORS_GROUP_ID])) //if content editor
			return;

		//unset menu
		foreach ($aGlobalMenu as $key => &$val)
			if ($key != 'global_menu_content')
				unset($aGlobalMenu[$key]);

		foreach ($aModuleMenu as $key => &$val)
			if ($val['items_id'] != 'menu_iblock_/news')
				unset($aModuleMenu[$key]);

		unset($val);
	}

	function set_additional_page_property()
	{

		if (!CModule::IncludeModule('iblock'))
			return;

		$Res = CIBlockElement::GetList(false,
		                               ['IBLOCK_ID' => METATAGS_IBLOCK_ID,
		                                'ACTIVE'    => 'Y',
		                                'NAME'      => htmlspecialchars($_SERVER['REQUEST_URI'])],
		                               false,
		                               false,
		                               ['PROPERTY_TITLE',
		                                'PROPERTY_DESCRIPTION']);

		if (!$Res->SelectedRowsCount())
			return;

		$Res = $Res->Fetch();

		global $APPLICATION;

		$APPLICATION->SetPageProperty('title', $Res['PROPERTY_TITLE_VALUE']);
		$APPLICATION->SetPageProperty('description', $Res['PROPERTY_DESCRIPTION_VALUE']);
	}
}