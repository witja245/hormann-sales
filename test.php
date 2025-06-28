<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Калькулятор гаражных секционных ворот");
/**
 * @global CMain $APPLICATION
 */

Sitemap::createSitemap()
?>
<?php $a = date('d.m.Y H:i:s'); echo $a; ?>
<?php phpinfo(); ?>
<!--<style>-->
<!--    .is-header {-->
<!--        position: static;-->
<!--        margin-bottom: 48px;-->
<!--    }-->
<!--</style>-->
    <div class="container">
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
        <? $APPLICATION->IncludeComponent('asteq:calculator', '', []);?>
    </div>
<?php



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
