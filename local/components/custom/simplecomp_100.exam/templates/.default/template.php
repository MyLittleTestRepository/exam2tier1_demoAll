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
					<?//уникальный идентификатор, чтобы эрмитаж корректно обрабатывал дубли новостей
                    $id=$news_id+$count++;

					$this->AddEditAction($id, $arResult['NEWS'][$news_id]['ADD_LINK'],
					                     CIBlock::GetArrayByID($arResult['NEWS'][$news_id]["IBLOCK_ID"], "ELEMENT_ADD"));
					$this->AddEditAction($id, $arResult['NEWS'][$news_id]['EDIT_LINK'],
                                         CIBlock::GetArrayByID($arResult['NEWS'][$news_id]["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($id, $arResult['NEWS'][$news_id]['DELETE_LINK'],
                                           CIBlock::GetArrayByID($arResult['NEWS'][$news_id]["IBLOCK_ID"], "ELEMENT_DELETE"),
                                           array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
                    <li id="<?=$this->GetEditAreaId($id);?>">
                        <?=$arResult['NEWS'][$news_id]['DATE_ACTIVE_FROM']?> -
                        <?=$arResult['NEWS'][$news_id]['NAME']?>
                    </li>
				<?endforeach;?>
            </ul>
        </li>
	<?endforeach;?>
</ul>