<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
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
            <h1 class="h2 margin-32 wow" data-wow-offset="200"><?= $APPLICATION->ShowTitle(false) ?></h1>
            <div class="text width-700 margin-72 wow" data-wow-offset="200"><?=$arParams['PAGE']->PREVIEW_TEXT?></div>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "products",
                Array(
                    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "SECTION_ID" => '',
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    'ADD_SECTIONS_CHAIN' => 'Y',
                    'FILTER_NAME' => '',
                    "SECTION_USER_FIELDS" => []
                ),
                $component
            );
            ?>
            <? $APPLICATION->IncludeComponent("bitrix:form.result.new",
                "ask.spec",
                Array(
                    "SEF_MODE" => "N",
                    "WEB_FORM_ID" => FORM_ID_ASK_SPEC,
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
                    "VARIABLE_ALIASES" => Array('WEB_FORM_ID', 'RESULT_ID')
                )
            ); ?>
        </div>
    </div>