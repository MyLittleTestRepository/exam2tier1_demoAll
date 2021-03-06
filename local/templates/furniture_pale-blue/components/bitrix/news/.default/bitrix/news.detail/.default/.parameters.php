<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"AJAX_REPORT" => Array(
		'PARENT' => 'BASE',
		"NAME" => GetMessage("AJAX_REPORT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"CANONICAL_ID" => Array(
		"NAME" => GetMessage("CANONICAL_ID"),
		"TYPE" => "STRING",
		"DEFAULT" => "5",
	),
);
?>
