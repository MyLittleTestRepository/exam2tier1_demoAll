<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<select name="site" onChange="location.href=this.value">
<?
foreach ($arResult["SITES"] as $key => $arSite):
?>
	<option value="<?if(is_array($arSite['DOMAINS']) && strlen($arSite['DOMAINS'][0]) > 0 || strlen
                                                                                             ($arSite['DOMAINS']) >
                                                                                             0):?>http://<?endif?><?=
    (is_array($arSite["DOMAINS"]) ? $arSite["DOMAINS"][0] : $arSite["DOMAINS"])?><?=$arSite["DIR"]?>" <?if ($arSite["CURRENT"] == "Y"):?>SELECTED="1"<?endif;?>><?=$arSite["LANG"]?></option>
<?
endforeach;
?>
</select>