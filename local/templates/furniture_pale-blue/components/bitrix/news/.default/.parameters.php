<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
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