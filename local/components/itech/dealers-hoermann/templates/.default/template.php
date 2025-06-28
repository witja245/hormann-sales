<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['ELEMENTS']):?>

<form class="contacts wow" id="111" data-wow-offset="200" action="#" data-app="contacts">
	<div class="title-text wow" data-wow-offset="200"><a name="city">Дилеры Hörmann в городе <?= $arParams['CITY']['NAME'] ?></a></div>
    <div class="form__radio">
        <button class="is-active" type="button">Все</button>
        <? foreach ($arResult['SECTIONS'] as $key => $section): ?>
            <label>
                <input type="radio" name="type" value="type-<?= $section['TYPE'] ?>"><i></i><span><?= $section['NAME'] ?></span>
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
                            <!--<div class="contacts__item__plan">
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
                            </div>-->
                            <div class="contacts__item__image">
                                <? foreach ($item['PROPERTIES']['PHOTO']['VALUE'] as $phone):?>
                                    <a href="<?= CFile::GetPath($phone) ?>" data-fancybox="photo">
                                        <img src="<?= CFile::GetPath($phone) ?>" alt="">
                                    </a>
                                <? endforeach; ?>
                            </div>
                            <div class="contacts__item__adress">
                                <ul>
                                    <? if (!empty($item['PROPERTIES']['PHONE']['VALUE'])): ?>
                                        <li>
                                            <div class="contacts__item__adress__label">Телефон:</div>
                                            <span>
                                                <? foreach ($item['PROPERTIES']['PHONE']['VALUE'] as $phone) {
                                                    echo '<a href="tel:'.$phone.'">'.$phone.'</a>';
                                                    if ($phone != end($item['PROPERTIES']['PHONE']['VALUE'])) {
                                                        echo '<br>';
                                                    }
                                                } ?>
                                            </span>
                                        </li>
                                    <? endif ?>

                                    <? if (!empty($item['PROPERTIES']['DEALERS_EMAIL']['VALUE'])): ?>
                                        <li>
                                            <div class="contacts__item__adress__label">E-mail:</div>
                                            <span>
                                                <? foreach ($item['PROPERTIES']['DEALERS_EMAIL']['VALUE'] as $email) {
                                                    echo '<a href="mailto:'.$email.'">'.$email.'</a>';
                                                    if ($email != end($item['PROPERTIES']['DEALERS_EMAIL']['VALUE'])) {
                                                        echo '<br>';
                                                    }
                                                } ?>
                                            </span>
                                        </li>
                                    <? endif ?>

                                    <? if (!empty($item['PROPERTIES']['DEALERS_WEBSITE']['VALUE'])): ?>
                                        <li>
                                            <div class="contacts__item__adress__label">Сайт:</div>
                                            <span>
                                                <? foreach ($item['PROPERTIES']['DEALERS_WEBSITE']['VALUE'] as $website) {
                                                    echo '<a href="https://'.$website.'" target="_blank">'.$website.'</a>';

                                                    if (is_array($item['PROPERTIES']['DEALERS_EMAIL']['VALUE']))
                                                    {
                                                        if ($website != end($item['PROPERTIES']['DEALERS_EMAIL']['VALUE']))
                                                        {
                                                            echo '<br>';
                                                        }
                                                    }
                                                } ?>
                                            </span>
                                        </li>
                                    <? endif ?>
                                </ul>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <div class="contacts__map" id="map2" data-lat="<?=$arParams['CITY']['LAT']?>" data-lng="<?=$arParams['CITY']['LON']?>" data-zoom="18"
             data-icon="/static/build/images/map-pin.svg"
             data-icon-active="/static/build/images/map-pin-active.svg"></div>
    </div>
</form>
<?php endif;?>