<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"AJAX_REPORT" => Array(
		'PARENT' => 'BASE',
		"NAME" => GetMessage("AJAX_REPORT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"SET_SPECIALDATE" => Array(
		"NAME" => GetMessage("SET_SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"CANONICAL_ID" => Array(
		"NAME" => GetMessage("CANONICAL_ID"),
		"TYPE" => "STRING",
		"DEFAULT" => "5",
	),
);