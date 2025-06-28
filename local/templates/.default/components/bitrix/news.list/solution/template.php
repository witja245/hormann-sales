<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->AddChainItem($arResult["SECTION"]["NAME"]);
?>


<h1 class="h2 wow" data-wow-offset="200"><?= $arResult["SECTION"]["NAME"] ?></h1>

<div class="text width-605 margin-72 wow" data-wow-offset="200"><?= $arResult["SECTION"]["DESCRIPTION"] ?></div>
<div class="parking wow" data-wow-offset="200">


    <? foreach ($arResult["ITEMS"]["TOP"] as $item): ?>
        <div class="parking__item">
            <div class="parking__item__image"><img src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>" alt=""></div>
            <div class="parking__item__content">
                <div class="title-text"><?= $item["NAME"] ?></div>
                <div class="parking__item__list">
                    <ul>
                        <?= $item["PREVIEW_TEXT"] ?>
                    </ul>
                </div>
            </div>
        </div>
    <? endforeach; ?>

</div>

<div class="text width-800 margin-32 wow" data-wow-offset="200"><?= $arResult["SECTION"]["~UF_TEXT"] ?></div>

<div class="width-895">

    <? foreach ($arResult["ITEMS"]["TEXT"] as $item): ?>
        <h2 class="wow" data-wow-offset="200"><?= $item["NAME"] ?></h2>
        <div class="text margin-32 wow" data-wow-offset="200"><?= $item["PREVIEW_TEXT"] ?></div>
        <div class="text padding-left-100 margin-72 wow" data-wow-offset="200"><?= $item["DETAIL_TEXT"] ?></div>
    <? endforeach; ?>
</div>



<div class="tie wow" data-wow-offset="200">
    <div class="tie__row">
        <div class="tie__col"><a class="tie__item" href="#">
                <div class="title-text">Пригласите инженера</div>
                <div class="text">Мы проведем замеры вашего объекта и подготовим рекомендаций по установке и подбору оборудования</div></a></div>
        <div class="tie__col"><a class="tie__item" href="tel:8 800 555 69 87">
                <div class="title-text">8 800 555 69 87</div>
                <div class="text">Позвоните на горячую линию Hörmann, чтобы задать вопрос или получить консультацию</div></a></div>
        <div class="tie__col"><a class="tie__item" href="#">
                <div class="title-text">Сервис</div>
                <div class="text">Обратитесь в сервисный отдел Hörmann для обслуживания и ремонта оборудования.</div></a></div>
    </div>
</div>
