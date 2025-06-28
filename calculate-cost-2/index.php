<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Рассчитайте свой проект самостоятельно с помощью удобных сервисов компании Hormann.");
$APPLICATION->SetTitle("Рассчитать проект - умный калькулятор Hormann");
?>
<?php
$page = \Itech\PageService::getInstance()->get();
?>
    <div class="content">
        <div class="container">
            <? $APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"calculate.cost2", 
	array(
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => FORM_ID_CALCULATE_COST_2,
		"LIST_URL" => "",
		"EDIT_URL" => "",
		"SUCCESS_URL" => "/spasibo/index.php",
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "Y",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_FOLDER" => "/",
		"COMPONENT_TEMPLATE" => "calculate.cost2",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
); ?>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>