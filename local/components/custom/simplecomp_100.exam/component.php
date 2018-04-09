<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Loader;

if (!$USER->IsAuthorized())
	return;

if (!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

//clear input vars
foreach ($arParams as $key=>$val)
	if (substr($val, 0, 1) != '~')
	{
		$arParams[$key] = trim($val);
		if (is_numeric($val))
			$arParams[$key] = intval($val);
	};

//check input vars
if (!$arParams['NEWS_IBLOCK_ID'] or !$arParams['NEWS_LINK_CODE'] or !$arParams['UF_CODE'])
	return;

$my_id = $USER->GetID();

/**@var $this CBitrixComponent */
if ($this->startResultCache($my_id))
{

	//get type for this user
	$arFilter = ['ACTIVE'                   => 'Y',
	             '!' . $arParams['UF_CODE'] => false,
	             'ID'                       => $my_id];

	$arSelect = ['SELECT' => [$arParams['UF_CODE']],
	             'FIELDS' => ['ID']];

	$Res = CUser::GetList($dy, $order, $arFilter, $arSelect);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	$my_type = $Res->Fetch()[$arParams['UF_CODE']];


	//get all user for this type
	$arFilter = [$arParams['UF_CODE'] => $my_type];

	array_push($arSelect['FIELDS'], 'LOGIN');
	unset($arSelect['SELECT']);

	$Res = CUser::GetList($dy, $order, $arFilter, $arSelect);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	while ($user = $Res->Fetch())
		$arResult['USERS'][$user['ID']] = $user;


	//get news for this users
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID'                               => $arParams['NEWS_IBLOCK_ID'],
	                                'ACTIVE'                                  => 'Y',
	                                'PROPERTY_' . $arParams['NEWS_LINK_CODE'] => array_keys($arResult['USERS'])],
	                               false,
	                               false,
	                               ['ID',
	                                'NAME',
	                                'DATE_ACTIVE_FROM',
	                                'PROPERTY_' . $arParams['NEWS_LINK_CODE'],
	                                'IBLOCK_ID']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	$arMyNews = [];

	$prop_value = 'PROPERTY_' . $arParams['NEWS_LINK_CODE'] . '_VALUE';
	$prop_id = $prop_value . '_ID';

	while ($news = $Res->Fetch())
	{
		$news_id = $news['ID'];

		if (in_array($news_id, $arMyNews)) //skip my news
			continue;

		if ($news[$prop_value] == $my_id) //find & clear my news
		{
			$arMyNews[] = $news_id;
			unset($arResult['NEWS'][$news_id]);
			continue;
		}

		//hermitage
		$arButtons = CIBlock::GetPanelButtons(
			$news["IBLOCK_ID"],
			$news["ID"],
			0,
			array("SECTION_BUTTONS"=>true, "SESSID"=>false)
		);

		$news["ADD_LINK"] = $arButtons["edit"]["add_element"]["ACTION_URL"];
		$news["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$news["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

		//set link user=news
		$arResult['USERS'][$news[$prop_value]]['NEWS'][] = $news_id;

		unset($news[$prop_value]);
		unset($news[$prop_id]);

		$arResult['NEWS'][$news['ID']] = $news;
	}

	unset($arResult['USERS'][$my_id]); //clear self

	//end
	$arResult['COUNT'] = count($arResult['NEWS']);
	$this->setResultCacheKeys(['COUNT']);

	$this->includeComponentTemplate();
}

if ($APPLICATION->GetShowIncludeAreas())
	$this->AddIncludeAreaIcons([["TITLE"          => GetMessage("NEWS_LIST"),
	                             "URL"            => '/bitrix/admin/'
	                                                 . CIBlock::GetAdminElementListLink($arParams['NEWS_IBLOCK_ID']),
	                             "IN_PARAMS_MENU" => true]]);

$APPLICATION->SetTitle(GetMessage("COUNT") . $arResult['COUNT']);

/*::::::Новости, в которых в авторстве присутствует текущий пользователь, не выводятся у других
авторов:::::
 *
 * тестовая новость 3 из-под админа выводиться не должна, т.к. нарушается условие выше, расхождение с картинкой
 *
 *  */
