<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Ознакомьтесь с картой сайта. Официальный сайт Hormann - крупнейшего в Европе производителя гаражных ворот, дверей и приводов.");
$APPLICATION->SetPageProperty("title", "Карта сайта - официальный сайт Hormann"); ?>
<?php
$page = \Itech\PageService::getInstance()->get();
?>
    <div class="content">
        <div class="container">
            <h1 class="h2"><?= $page->NAME ?></h1>
            <?php
            $APPLICATION->IncludeComponent("bitrix:main.map", "site.map", Array(
                    "LEVEL" => "6",
                    "COL_NUM" => "1",
                    "SHOW_DESCRIPTION" => "Y",
                    "SET_TITLE" => "Y",
                    "CACHE_TIME" => "36000000"
                )
            );
            ?>
        </div>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>