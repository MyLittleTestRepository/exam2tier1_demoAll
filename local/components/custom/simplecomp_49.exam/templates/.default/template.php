<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?> :</b></p>
<?if(empty($arResult))
    return?>
<ul>
<?foreach ($arResult['NEWS'] as &$news):?>
    <li>
        <b><?=$news['ITEM']['NAME']?></b> - <?=$news['ITEM']['DATE_ACTIVE_FROM']?> - (
        <?$sect_names=[]?>
        <?foreach ($news['SECTIONS_ID'] as $sect_id):?>
            <?$sect_names[]=$arResult['SECTIONS'][$sect_id]['NAME']?>
        <?endforeach;?>
        <?=implode(', ', $sect_names)?>
        )
        <ul>
            <?foreach ($news['SECTIONS_ID'] as $sect_id):?>
                <?foreach ($arResult['SECTIONS'][$sect_id]['ITEMS'] as $item):?>
                <li>
                    <?=$item['NAME']?> -
	                <?=$item['PROPERTY_PRICE_VALUE']?> -
	                <?=$item['PROPERTY_MATERIAL_VALUE']?> -
	                <?=$item['PROPERTY_ARTNUMBER_VALUE']?>
                </li>
                <?endforeach;?>
            <?endforeach;?>
        </ul>
    </li>
<?endforeach;?>
</ul>