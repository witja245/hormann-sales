<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Задайте вопрос компании Hormann"); ?>
<?php
$page = \Itech\PageService::getInstance()->get();
?>
<? $APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"ask.question", 
	array(
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => FORM_ID_ASK_QUESTION,
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_FOLDER" => "/",
		"COMPONENT_TEMPLATE" => "ask.question",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
); ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>