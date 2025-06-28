<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ELEMENTS']):?>
<div class="container">
    <h2 class="wow" data-wow-offset="200">Контакты в<a class="contacts-city" href="#modal-contacts" data-fancybox><?= $arParams['CITY']['NAME'] ?></a></h2>
    <form class="contacts wow" data-wow-offset="200" action="#" data-app="contacts">
        <div class="form__radio">
            <button class="is-active" type="button">Все</button>
            <? foreach ($arResult['SECTIONS'] as $section): ?>
                <label>
                    <input type="checkbox" value="type-<?= $section['TYPE'] ?>"><i></i><span><?= $section['NAME'] ?></span>
                </label>
            <? endforeach; ?>
        </div>
        <div class="contacts__box">
            <div class="contacts__list">
                <div class="contacts__list__scroll">
                    <div class="contacts__list__content">
                        <?php foreach ($arResult['ELEMENTS'] as $item):
                        $dataTypes = '';
                        foreach ($item['SECTIONS'] as $section) {
                            $dataTypes .= '&quot;type-' . $arResult['SECTIONS'][$section['ID']]['TYPE'] . '&quot;';
                            if ($section != end($item['SECTIONS'])) {
                                $dataTypes .= ',';
                            }
                        }
                        $coordinates = explode(',', $item['PROPERTIES']['MAP']['VALUE']); ?>
                        <div class="contacts__item" data-lat="<?= $coordinates[0] ?>" data-lng="<?= $coordinates[1] ?>"
                             data-types="[<?=$dataTypes?>]">
                            <div class="contacts__item__name"><?= $item['FIELDS']['~NAME'] ?></div>
                            <div class="contacts__item__type">
                                <? foreach ($item['SECTIONS'] as $section):?>
                                    <span><?= $section['NAME'] ?></span>
                                <? endforeach; ?>
                            </div>
                            <div class="contacts__item__adress">
                                <ul>
                                    <li class="contacts__item__adress__margin-li">
                                        <div class="contacts__item__adress__label">Телефон:</div>
                                        <span>
                                            <? foreach ($item['PROPERTIES']['PHONE']['VALUE'] as $phone):?>
                                                <a href="tel:<?=\Itech\Helper::trimPhone($phone)?>"><?=$phone?></a>
                                                <?if($phone!==end($item['PROPERTIES']['PHONE'])) echo "<br>"?>
                                            <? endforeach; ?>
                                        </span>
                                    </li>
                                    <li>
                                        <div class="contacts__item__adress__label">Email:</div><a href="mailto:<?=$item['PROPERTIES']['EMAIL']['VALUE']?>"><?=$item['PROPERTIES']['EMAIL']['VALUE']?></a>
                                    </li>
                                    <li>
                                        <div class="contacts__item__adress__label">Сайт:</div><a href="//<?=$item['PROPERTIES']['SITE']['VALUE']?>"><?=$item['PROPERTIES']['SITE']['VALUE']?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="contacts__map" id="map" data-lat="<?=$arParams['CITY']['LAT']?>" data-lng="<?=$arParams['CITY']['LON']?>" data-zoom="18" data-icon="/static/build/images/map-pin.svg" data-icon-active="/static/build/images/map-pin-active.svg"></div>
        </div>
    </form>
</div>
<?php endif;?>