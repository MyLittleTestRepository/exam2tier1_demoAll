<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?> :</b></p>
<?if(empty($arResult))
    return?>
<ul>
	<?foreach ($arResult['USERS'] as $uid => $arUser):?>
        <li>
            [<?=$uid?>] - <?=$arUser['LOGIN']?>
            <ul>
				<?foreach ($arUser['NEWS'] as $news_id):?>
                    <li>
                        <?=$arResult['NEWS'][$news_id]['DATE_ACTIVE_FROM']?> -
                        <?=$arResult['NEWS'][$news_id]['NAME']?>
                    </li>
				<?endforeach;?>
            </ul>
        </li>
	<?endforeach;?>
</ul>