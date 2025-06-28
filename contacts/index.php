<?php
define('BLACKCOLOR', true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Контакты производителя гаражных ворот и дверях  Hörmann");
$APPLICATION->SetPageProperty("description", "Контакты компании Hörmann в России.");
$APPLICATION->SetTitle("Контакты");
?>
<?php
$code = $APPLICATION->GetCurPage();
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
            <h1 class="h2 wow" data-wow-offset="200">Hörmann в
                <a class="contacts-city" href="#geo" data-fancybox><?= $city['NAME'] ?></a>
            </h1>
            <div class="official wow" data-wow-offset="200">
                <div class="official__row">
                    <div class="official__col">
                        <a class="official__item js-goto" href="<?= $page->UF_FIRST ?>">
                            <div class="official__item__image">
                                <img src="<?= CFILE::GetPath($page->UF_FIRST_FILE) ?>" alt="">
                            </div>
                            <div class="official__item__content">
                                <div class="title-text">Покупка, установка и сервис</div>
                                <div class="text"><?= $page->UF_FIRST_TEXT ?></div>
                            </div>
                        </a>
                    </div>
                    <div class="official__col">
                        <a class="official__item js-goto" href="<?= $page->UF_SECOND ?>">
                            <div class="official__item__image">
                                <img src="<?= CFILE::GetPath($page->UF_SECOND_FILE) ?>" alt="">
                            </div>
                            <div class="official__item__content">
                                <div class="title-text">Корпоративным клиентам</div>
                                <div class="text"><?= $page->UF_SECOND_TEXT ?></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <? $APPLICATION->IncludeComponent("itech:official-representative", "", [
                'CITY' => $city,
                'IBLOCK_ID' => IBLOCK_ID_OFFICAL_REPRESENTATIVE,
            ]); ?>
            <? $APPLICATION->IncludeComponent("itech:dealers-hoermann", "", [
                'CITY' => $city,
                'IBLOCK_ID' => IBLOCK_ID_DEALERS_HOERMANN,
            ]); ?>
            <div class="hotline wow" data-wow-offset="200">
                <div class="hotline__content">
                    <div class="hotline__item">
                        <div class="hotline__title">Многоканальная горячая линия</div>
                        <div class="hotline__number">
                            <a href="tel:8 800 555 69 87">8 800 555 69 87</a>
                        </div>
                        <div class="hotline__date">Пн–Пт с 10:00 до 18:00</div>
                    </div>
                    <div class="hotline__item">
                        <a class="btn" href="/ask/"><span>Задать вопрос</span></a>
                        <div class="hotline__email">
                            <a href="mailto:info＠hoermann.ru">info＠hoermann.ru</a>
                        </div>
                    </div>
                </div>

                <div class="hotline__image">
                    <img src="<?= CFile::GetPath($page->PREVIEW_PICTURE) ?>" alt="">
                </div>
            </div>
        </div>
        <? $APPLICATION->IncludeComponent("itech:cities-list", "", [
            'CITY' => $city,
            'IBLOCK_ID' => IBLOCK_ID_CIRIES,
        ]); ?>
    </div>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>