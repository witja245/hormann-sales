<?php
define('BLACKCOLOR',true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Выходные данные на официальном сайте Hormann.");
$APPLICATION->SetTitle("Выходные данные Hormann"); ?>
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
            <h1 class="h2 wow" data-wow-offset="200">Выходные данные</h1>
            <div class="width-700">
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_OUTPUT?></div>
                <div class="title-text wow" data-wow-offset="200">Ответственность</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_RESPON?></div>
                <div class="title-text wow" data-wow-offset="200">Защита информации</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_GUARD?></div>
                <div class="title-text wow" data-wow-offset="200">Авторские права</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_AVTOR?></div>
                <div class="title-text wow" data-wow-offset="200">Юридическая сила положения об исключении ответственности
                </div>
                <div class="text margin-120 wow" data-wow-offset="200"><?=$page->UF_LEGAL?></div>
                <h2 class="wow" data-wow-offset="200">Заявление о конфиденциальности</h2>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_CONF?></div>
                <div class="title-text wow" data-wow-offset="200">Сбор персональных данных</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_PERS?></div>
                <div class="title-text wow" data-wow-offset="200">Использование Cookies</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_COOKIE?></div>
                <div class="title-text wow" data-wow-offset="200">Использование персональных данных</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_USE_PERS?></div>
                <div class="title-text wow" data-wow-offset="200">Защита</div>
                <div class="text margin-72 wow" data-wow-offset="200"><?=$page->UF_PROT?></div>
                <div class="title-text wow" data-wow-offset="200">Изменения «Заявления о конфиденциальности»</div>
                <div class="text wow" data-wow-offset="200"><?=$page->UF_CHANGE_CONF?></div>
            </div>
        </div>
    </div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>