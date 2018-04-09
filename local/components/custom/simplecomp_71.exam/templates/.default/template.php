<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?> :</b></p>
<?if(empty($arResult))
    return?>
<ul>
	<?foreach ($arResult[$arParams['PRODUCTS_LINK_CODE']] as $firm_name => $products):?>
        <li>
            <b><?=$firm_name?></b>
            <ul>
				<?foreach ($products as $item):?>
                    <li>
                        <a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a> -
                        <?=$item['PROPERTY_PRICE_VALUE']?> -
                        <?=$item['PROPERTY_MATERIAL_VALUE']?> -
                        <?=$item['PROPERTY_ARTNUMBER_VALUE']?>
                    </li>
				<?endforeach;?>
            </ul>
        </li>
	<?endforeach;?>
</ul>