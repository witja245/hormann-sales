<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Рассчитайте стоимость своего проекта самостоятельно с помощью калькулятора. Официальный сайт Hormann.");
$APPLICATION->SetPageProperty("title", "Калькулятор Hormann - рассчитать стоимость проекта");
$APPLICATION->SetTitle("Калькулятор гаражных секционных ворот");
/**
 * @global CMain $APPLICATION
 */

//$APPLICATION->AddChainItem("Продукция");
//$APPLICATION->AddChainItem("Гаражные ворота");
//$APPLICATION->AddChainItem("Калькулятор");
?>
<!--<style>-->
<!--    .is-header {-->
<!--        position: static;-->
<!--        margin-bottom: 48px;-->
<!--    }-->
<!--</style>-->
    <div class="container" style="margin-top: 125px">
        <div class="breadcrumbs">
            <?$APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "main",
                Array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0",
                )
            );?>
        </div>
        <h1 class="h2" style="visibility: visible;">Калькулятор гаражных секционных ворот</h1>
        <? $APPLICATION->IncludeComponent("asteq:calculator", "template1", Array(
	"GATE_TYPE" => "2"
	),
	false
);?>
    </div>
<?php



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");