<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<div class="card wow" data-wow-offset="200">
    <div class="card__image">
        <img src="<?= $arResult["PREVIEW_PICTURE"]['SRC'] ?>" alt="">
    </div>
    <div class="card__content">
        <h1 class="h2"><?= $arResult['NAME'] ?></h1>
        <div class="card__text"><?= $arResult['PREVIEW_TEXT'] ?></div>
        <? if ($arResult['OFFERS_PROPS']['GOFR']): ?>
            <div class="card__item">
                <div class="card__label">Гофр<a class="help" href="#help-gofr" data-fancybox>?</a></div>
                <div class="card__item__row">
                    <? $index = 1 ?>
                    <? foreach ($arResult['OFFERS_PROPS']['GOFR'] as $item): $index++ ?>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                       name="corrugation" <?= $index == 1 ? 'checked' : '' ?>><i></i><span><?= $item ?></span>
                            </label>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>

        <? if ($arResult['OFFERS_PROPS']['SURFACE']): ?>
            <div class="card__item">
                <div class="card__label">Поверхность<a class="help" href="#help-gofr" data-fancybox>?</a></div>
                <div class="card__item__row">
                    <? $index = 0 ?>
                    <? foreach ($arResult['OFFERS_PROPS']['SURFACE'] as $item): $index++ ?>
                        <div class="radio">
                            <label>
                                <input type="radio"
                                       name="surface" <?= $index == 1 ? 'checked' : '' ?>><i></i><span><?= $item ?></span>
                            </label>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>

        <? if ($arResult['OFFERS_PROPS']['COLOR']): ?>
            <div class="card__item">
                <div class="card__label">Цвет: <span>Ночной дуб</span></div>
                <div class="color">
                    <? $index = 0 ?>
                    <? foreach ($arResult['OFFERS_PROPS']['COLOR'] as $item): $index++ ?>
                        <label class="color-<?= $index ?>">
                            <input type="radio" name="color" <?= $index == 1 ? 'checked' : '' ?>><i></i>
                        </label>
                    <? endforeach; ?>
                    <a class="card__item__plus" href="#"></a>
                </div>
            </div>
        <? endif; ?>

        <? if ($arResult['OFFERS_PROPS']['GLAZING']): ?>
            <div class="card__item">
                <div class="card__label">Остекление: <span>Мотив S2</span><a class="help" href="#help-glazing"
                                                                             data-fancybox>?</a></div>
                <div class="card__glazing">
                    <? $index = 0 ?>
                    <? foreach ($arResult['OFFERS_PROPS']['GLAZING'] as $item): $index++ ?>
                        <? if ($item['PICTURE']): ?>
                            <label <?= $item['PICTURE']['WIDTH'] > 44 ? 'class="width-88"' : '' ?>>
                                <input type="radio" name="glazing">
                                <img src="<?= $item['PICTURE']['SRC'] ?>" alt="">
                            </label>
                        <? else: ?>
                            <label>
                                <input type="radio" name="glazing"><i></i>
                            </label>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>
        <? if ($arResult['OFFERS_PROPS']['PRICE']): ?>
            <div class="card__price">
                По запросу
<!--                от <span>--><?php //= $arResult['OFFERS_PROPS']['PRICE'] ?><!--</span> ₽-->
            </div>
        <? endif; ?>
        <div class="card__buy">
<!--            <a class="btn" href="#order-gate" data-fancybox>-->
<!--                <span>Заказать</span>-->
<!--            </a>-->
            <script data-b24-form="click/25/xkz4uv" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://hormann-crm.ru/upload/crm/form/loader_25_xkz4uv.js');</script>
            <a class="btn" href="#"><span>Заказать</span></a>

            <div class="card__link">
                <a href="/contacts/">
                    <svg>
                        <use xlink:href="/static/build/images/sprites.svg#pin"></use>
                    </svg>
                    <span>Где купить</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="feature wow" data-wow-offset="200">
    <div class="feature__content">
        <div class="title-text">Характеристики</div>
        <div class="feature__info">
            <ul>
                <? if ($arResult['PROPERTIES']['MATERIAL']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Материал</div>
                        <span><?= $arResult['PROPERTIES']['MATERIAL']['VALUE'] ?></span>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['CONSTRUCTION']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Конструкция</div>
                        <span><?= $arResult['PROPERTIES']['CONSTRUCTION']['VALUE'] ?></span>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['PANEL']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Толщина панели</div>
                        <span><?= $arResult['PROPERTIES']['PANEL']['VALUE'] ?></span>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['SOUND']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Звукоизоляция</div>
                        <div class="feature__info__img">
                            <? for ($i = 0; $i < $arResult['PROPERTIES']['SOUND']['VALUE']; $i++): ?>
                                <img src="/static/build/images/temp/25.jpg" alt="">
                            <? endfor; ?>
                        </div>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['ISOLATION']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Теплоизоляция</div>
                        <div class="feature__info__img">
                            <? for ($i = 0; $i < $arResult['PROPERTIES']['ISOLATION']['VALUE']; $i++): ?>
                                <img src="/static/build/images/temp/26.jpg" alt="">
                            <? endfor; ?>
                        </div>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['ENERGY']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Энергосбережение</div>
                        <div class="feature__info__img">
                            <? for ($i = 0; $i < $arResult['PROPERTIES']['ENERGY']['VALUE']; $i++): ?>
                                <img src="/static/build/images/temp/27.jpg" alt="">
                            <? endfor; ?>
                        </div>
                    </li>
                <? endif; ?>
                <? if ($arResult['PROPERTIES']['SIZE']['VALUE']): ?>
                    <li>
                        <div class="feature__info__label">Max размеры:</div>
                        <span><?= $arResult['PROPERTIES']['SIZE']['VALUE'] ?></span>
                    </li>
                <? endif; ?>
            </ul>
        </div>
    </div>
    <div class="feature__image">
        <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="">
        <?= $arResult['DETAIL_TEXT'] ?>
    </div>
</div>

