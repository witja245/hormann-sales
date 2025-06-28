<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ELEMENTS']):?>
<form class="contacts wow" id="222" data-wow-offset="200" action="#" data-app="contacts">
    <div class="title-text wow" data-wow-offset="200"><a name="russia">Официальное представительство ООО «Хёрманн Руссия»
		в <?= $arParams['CITY']['NAME'] ?></a>
    </div>
    <div class="form__radio">
        <button class="is-active" type="button">Все</button>
        <? /*$index = 0;
        foreach ($arResult['SECTIONS'] as $section): $index++; ?>
            <label>
                <input type="checkbox" value="type-<?= $index ?>"><i></i><span><?= $section['NAME'] ?></span>
            </label>
        <? endforeach; */?>
        <? foreach ($arResult['SECTIONS'] as $key => $section): ?>
            <label>
                <input type="radio" name="type_2" value="type-<?= $section['TYPE'] ?>"><i></i><span><?= $section['NAME'] ?></span>
            </label>
        <? endforeach; ?>
    </div>
    <div class="contacts__box">
        <div class="contacts__list">
            <div class="contacts__list__scroll">
                <div class="contacts__list__content">
                    <? /*
                    $index = 0;
                    foreach ($arResult['SECTIONS'] as $section):
                        $index++;
                        foreach ($section['ITEMS'] as $item):
*/
                        foreach ($arResult['ELEMENTS'] as $item):
                            $dataTypes = '';
                            foreach ($item['SECTIONS'] as $section) {
                                $dataTypes .= '&quot;type-' . $arResult['SECTIONS'][$section['ID']]['TYPE'] . '&quot;';
                                if ($section != end($item['SECTIONS'])) {
                                    $dataTypes .= ',';
                                }
                            }

                            $coordinates = explode(',', $item['PROPERTIES']['MAP']['VALUE']);
                            ?>
                            <div class="contacts__item" data-lat="<?= $coordinates[0] ?>"
                                 data-lng="<?= $coordinates[1] ?>"
                                 data-types="[<?=$dataTypes?>]">
                                 <?/*
                                 data-types="[&quot;type-<?= $index ?>&quot;]">*/?>
                                <div class="contacts__item__name"><?= $item['FIELDS']['~NAME'] ?></div>
                                <div class="contacts__item__type">
                                    <? foreach ($item['SECTIONS'] as $section):?>
                                        <span><?= $section['NAME'] ?></span>
                                    <? endforeach; ?>
                                </div>
                                <div class="contacts__item__plan">
                                    <a href="#">
                                        <svg>
                                            <use xlink:href="/static/build/images/sprites.svg#pin2"></use>
                                        </svg>
                                        <span>1975 км от вас</span>
                                    </a>
                                    <a href="#">
                                        <svg>
                                            <use xlink:href="/static/build/images/sprites.svg#plan"></use>
                                        </svg>
                                        <span>Схема проезда</span>
                                    </a>
                                </div>

                                <? if ($item['PROPERTIES']['PHONE']['VALUE'] || $item['PROPERTIES']['EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress contacts__item__adress_margin">
                                        <ul>
                                            <? if ($item['PROPERTIES']['PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['ARCHITECT_PHONE']['VALUE'] || $item['PROPERTIES']['ARCHITECT_EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress">
                                        <div class="contacts__item__adress__title">Архитекторам</div>
                                        <ul>
                                            <? if ($item['PROPERTIES']['ARCHITECT_PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['ARCHITECT_PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['ARCHITECT_PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['ARCHITECT_EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['ARCHITECT_EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['ARCHITECT_EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['DEALER_PHONE']['VALUE'] || $item['PROPERTIES']['DEALER_EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress">
                                        <div class="contacts__item__adress__title">Дилерский отдел</div>
                                        <ul>
                                            <? if ($item['PROPERTIES']['DEALER_PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['DEALER_PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['DEALER_PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['DEALER_EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['DEALER_EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['DEALER_EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['TECHNO_PHONE']['VALUE'] || $item['PROPERTIES']['TECHNO_EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress">
                                        <div class="contacts__item__adress__title">Технический отдел</div>
                                        <ul>
                                            <? if ($item['PROPERTIES']['TECHNO_PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['TECHNO_PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['TECHNO_PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['TECHNO_EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['TECHNO_EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['TECHNO_EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['ENTITY_PHONE']['VALUE'] || $item['PROPERTIES']['ENTITY_EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress">
                                        <div class="contacts__item__adress__title">Отдел по работе с юр.лицами</div>
                                        <ul>
                                            <? if ($item['PROPERTIES']['ENTITY_PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['ENTITY_PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['ENTITY_PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['ENTITY_EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['ENTITY_EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['ENTITY_EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['PRODUCT_PHONE']['VALUE'] || $item['PROPERTIES']['PRODUCT_EMAIL']['VALUE']): ?>
                                    <div class="contacts__item__adress">
                                        <div class="contacts__item__adress__title">Консультация по продукции</div>
                                        <ul>
                                            <? if ($item['PROPERTIES']['PRODUCT_PHONE']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Телефон:</div>
                                                    <a href="tel:<?=preg_replace("/[^,.0-9]/", '', $item['PROPERTIES']['PRODUCT_PHONE']['VALUE']);?>">
                                                        <?= $item['PROPERTIES']['PRODUCT_PHONE']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                            <? if ($item['PROPERTIES']['PRODUCT_EMAIL']['VALUE']): ?>
                                                <li>
                                                    <div class="contacts__item__adress__label">Email:</div>
                                                    <a href="mailto:<?= $item['PROPERTIES']['PRODUCT_EMAIL']['VALUE'] ?>">
                                                        <?= $item['PROPERTIES']['PRODUCT_EMAIL']['VALUE'] ?>
                                                    </a>
                                                </li>
                                            <? endif; ?>
                                        </ul>
                                    </div>
                                <? endif; ?>

                            </div>
                        <? endforeach;
//                    endforeach; ?>
                </div>
            </div>
        </div>
        <div class="contacts__map" id="map" data-lat="<?=$arParams['CITY']['LAT']?>" data-lng="<?=$arParams['CITY']['LON']?>" data-zoom="18"
             data-icon="/static/build/images/map-pin.svg" data-icon-active="/static/build/images/map-pin-active.svg">
        </div>
    </div>
</form>
<? endif; ?>