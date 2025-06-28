<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Политика конфиденциальности Hormann");
$APPLICATION->SetPageProperty("description", "Политика конфиденциальности на официальном сайте Hormann.");
$APPLICATION->SetTitle("Политика конфиденциальности");
?>
<?php
$page = \Itech\PageService::getInstance()->get();
?>
    <div class="content">
        <div class="container">
            <div class="breadcrumbs">
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                ); ?>
            </div>
            <div class="width-700">
                <h1 class="h2 wow" data-wow-offset="200">Политика конфиденциальности</h1>
                <?=$page->PREVIEW_TEXT?>
            </div>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>