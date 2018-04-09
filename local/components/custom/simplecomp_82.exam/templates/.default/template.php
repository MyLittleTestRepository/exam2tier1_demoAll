<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?> :</b></p>
<?if(empty($arResult))
    return?>
<?$this->SetViewTarget('price')?>
<div style="color:red; margin: 34px 15px 35px 15px">
    <p><?= GetMessage("MAX") ?><?=$arResult['MAX']?></p>
    <p><?= GetMessage("MIN") ?><?=$arResult['MIN']?></p>
</div>
<?$this->EndViewTarget()?>
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
                        <?=$item['PROPERTY_ARTNUMBER_VALUE']?> (<?=$item['DETAIL_PAGE_URL']?>)
                    </li>
				<?endforeach;?>
            </ul>
        </li>
	<?endforeach;?>
</ul>