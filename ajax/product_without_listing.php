<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!CModule::IncludeModule("iblock"))
    return;

$res = CIBlockElement::GetByID($_REQUEST["id"]);
$props = [];
$fields = [];
if ($ar_res = $res->GetNextElement()) {
    $props = $ar_res->GetProperties();
    $fields = $ar_res->GetFields();
}
?>
<div class="modal modal-sked" id="sked">
    <div class="h2"><?= $fields['NAME'] ?></div>
    <div class="modal__row">
        <div class="modal__left">
            <? if ($props['SLIDER']['VALUE']): ?>
                <div class="modal__slider" data-app="slider-sked">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <? foreach ($props['SLIDER']['VALUE'] as $item): ?>
                                <div class="swiper-slide">
                                    <div class="modal__slider__img"><img src="<?= CFile::GetPath($item) ?>" alt=""/>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                    <div class="modal__slider__pager"></div>
                    <button class="modal__slider__arrow modal__slider__arrow_prev" type="button">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                        </svg>
                    </button>
                    <button class="modal__slider__arrow modal__slider__arrow_next" type="button">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                        </svg>
                    </button>
                </div>
            <? endif; ?>
            <? if ($props['APPLICATIONS']['VALUE']): ?>
                <div class="subtext">Сферы применения:</div>
                <div class="modal__list">
                    <ul>
                        <? foreach ($props['APPLICATIONS']['VALUE'] as $item): ?>
                            <li><?= $item ?></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        </div>
        <div class="modal__right">
            <div class="text"><?=$fields['PREVIEW_TEXT'] ?></div>
            <? if ($props['FEATURES']['VALUE']): ?>
                <div class="subtext">Ключевые особенности</div>
                <div class="modal__items">
                    <? foreach ($props['APPLICATIONS']['VALUE'] as $item): ?>
                        <div class="modal__item">
                            <div class="modal__item__icon">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#accept"></use>
                                </svg>
                            </div>
                            <div class="modal__item__text"><?= $item ?></div>
                        </div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>