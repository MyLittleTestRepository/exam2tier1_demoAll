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

//пагинация
if ($arParams['PAGE_SIZE'] > 0)
{
	CPageOption::SetOptionString("main", "nav_page_in_session", "N");
	$arNavParams = array("nPageSize"          => $arParams["PAGE_SIZE"],
	                     "bDescPageNumbering" => false,
	                     "bShowAll"           => false);
	$arNavigation = CDBResult::GetNavParams($arNavParams);
	//формируем айди кэша
	$cacheID = array_merge($arNavigation, $arNavParams);
}
else
{
	$arNavParams = false;
	$arNavigation = '';
	$cacheID = '';
}

/**@var $this CBitrixComponent */
if ($this->startResultCache(false, $cacheID))
{

	//правильно было бы запросить классификаторы, а по ним вычислить секции, и собрать элементы с них
	//но в классификаторах нет никакой информации о привязанных к ним секциях, привязка хранится в секциях
	//поэтому сначала соберем классификаторы из секций, а по ним уже будем запрашивать списки элементов

	//запрашиваем все секции с непустым классификатором
	//выдаются все секции, в т.ч. лишние при пагинации
	//просто получаем список классификаторов
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
		//вносим в массив имена секций
		$arResult['SECTIONS'][$sect['ID']]['NAME'] = $sect['NAME'];
		//создаем линки с новостей на секцию
		foreach ($sect[$arParams['NEWS_LINK_CODE']] as $news_id)
			$arResult['NEWS'][$news_id]['SECTIONS_ID'][] = $sect['ID'];
	}

	//получаем айдишники классификаторов
	$arNewsIds = array_keys($arResult['NEWS']);


	//запрашиваем классификаторы
	//с учетом пагинации
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'],
	                                'ACTIVE'    => 'Y',
	                                'ID'        => $arNewsIds],
	                               false,
	                               $arNavParams,
	                               ['ID',
	                                'NAME',
	                                'DATE_ACTIVE_FROM']);

	if (!$Res->SelectedRowsCount())
	{
		$this->abortResultCache();
		return;
	}

	if ($arParams['PAGE_SIZE'] > 0)
	{
		//ограничиваем выдачу
		$Res->NavStart($arParams['PAGE_SIZE']);
		//сохраняем пагинатор
		$arResult["NAV_STRING"] = $Res->GetPageNavStringEx($navComponentObject, GetMessage("NEWS"));
	}

	//собираем из выдачи новости, и привязанные к ним секции
	$arSectIds = [];
	$arNewsIds = [];
	while ($item = $Res->Fetch())
	{
		//вносим в массив новости
		$arResult['NEWS'][$item['ID']]['ITEM'] = $item;

		//собираем айдишники
		$arNewsIds[] = $item['ID'];
		foreach ($arResult['NEWS'][$item['ID']]['SECTIONS_ID'] as $sectId)
			$arSectIds[] = $sectId;
	}
	//избавляемся от дублей
	$arNewsIds = array_unique($arNewsIds);
	$arSectIds = array_unique($arSectIds);

	//пагинация ломает нам массивы, часть из них неполные
	//секций запрошено больше, чем будет выведено,
	//часть секций содержали линки на классификаторы, которые мы не запрашивали из бд из-за ограничения пагинации
	//все это сейчас в массивах, и ломает рендеринг
	//поэтому подчищаем массивы, удаляем лишние секции и пустые новости
	if ($arParams['PAGE_SIZE'] > 0)
	{
		foreach ($arResult['NEWS'] as $id => $val)
			if (!in_array($id, $arNewsIds))
				unset($arResult['NEWS'][$id]);

		foreach ($arResult['SECTIONS'] as $id => $val)
			if (!in_array($id, $arSectIds))
				unset($arResult['SECTIONS'][$id]);
	}


	//запрашиваем список элементов по оставшимся секциям
	$Res = CIBlockElement::GetList(false,
	                               ['IBLOCK_ID'         => $arParams['PRODUCTS_IBLOCK_ID'],
	                                'ACTIVE'            => 'Y',
	                                'IBLOCK_SECTION_ID' => $arSectIds],
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

	//вычисляем количество элементов
	$prod_count = $Res->SelectedRowsCount();

	//заполняем массивы
	while ($item = $Res->Fetch())
		$arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]['ITEMS'][$item['ID']] = $item;


	//end
	$arResult['COUNT'] = $prod_count;
	$this->setResultCacheKeys(['COUNT']);

	$this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("COUNT") . $arResult['COUNT']);

//в задании нет ничего о счетчике новостей, поэтому его не трогаем
//хотя он пострадал - теперь выдает количество элементов для конкретной страницы