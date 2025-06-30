<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 */

?>

<ul class="menu">
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <?php if ($item['PARENT']): ?>
            <?php foreach ($item['PARENT'] as $parent): ?>
                <?php if ($parent['CHILDREN']): ?>

                <?php else: ?>
                    <li><a href="#">О компании</a>
                        <div class="dropdown dropdown_one">
                            <div class="dropdown_back"><img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/back_arrow.svg" alt=""> Назад
                            </div>
                            <a href="" class="dropdown_title">Сервис</a>
                            <a href="" class="dropdown_title">Портфолио</a>
                            <a href="" class="dropdown_title">Медиа</a>
                            <a href="" class="dropdown_title">Новости</a>
                            <a href="" class="dropdown_title">Советы</a>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>


        <?php else: ?>
            <li><a href="<?= $item['LINK'] ?>"><?= $item['TEXT'] ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
    <li><a href="#">Продукция</a>
        <div class="dropdown">
            <div class="dropdown_back"><img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/back_arrow.svg" alt=""> Назад
            </div>
            <div class="menu_mobile-links">
                <div class="menu_mobile-link">Ворота</div>
                <div class="menu_mobile-link">Автоматика для ворот</div>
                <div class="menu_mobile-link">Перегрузочное оборудование</div>
                <div class="menu_mobile-link">Двери</div>
            </div>
            <div class="dropdown_item">
                <a href="#" class="dropdown_title">Ворота</a>
                <div class="dropdown_subtitle">
                    Гаражные ворота <img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/menu_arrow.svg" alt="">
                    <ul class="dropdown_menu">
                        <li><a href="">Секционные ворота RenoMatic</a></li>
                        <li><a href="">Секционные ворота LPU 42</a></li>
                        <li><a href="">Секционные ворота LPU 67 Thermo</a></li>
                    </ul>
                </div>

                <div class="dropdown_subtitle">
                    Промышленные ворота <img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/menu_arrow.svg" alt="">
                    <ul class="dropdown_menu">
                        <li><a href="">Подъемные секционные ворота</a></li>
                        <li><a href="">Рулонные ворота</a></li>
                        <li><a href="">Скоростные ворота</a></li>
                        <li><a href="">Складчатые ворота</a></li>
                    </ul>
                </div>

            </div>
            <div class="dropdown_item">
                <a href="#" class="dropdown_title">Автоматика для ворот</a>
                <ul class="dropdown_menu">
                    <li><a href="">Автоматика для откатных ворот</a></li>
                    <li><a href="">Автоматика для распашных ворот</a></li>
                    <li><a href="">Автоматика для секционных ворот</a></li>
                    <li><a href="">Автоматика для промышленных ворот</a></li>
                    <li><a href="">Пульты для ворот</a></li>
                    <li><a href="">Устройства безопасности для ворот</a></li>
                    <li><a href="">Запчасти и комплектующие для ворот</a></li>
                </ul>
            </div>
            <div class="dropdown_item">
                <a href="#" class="dropdown_title">Перегрузочное оборудование</a>
                <ul class="dropdown_menu">
                    <li><a href="">Доклевеллеры (уравнительные платформы, перегрузочные
                            мосты)</a></li>
                    <li><a href="">Докшелтеры (герметизаторы проема)</a></li>
                    <li><a href="">Тамбур шлюзы</a></li>
                    <li><a href="">Дополнительное оборудование для склада</a></li>
                </ul>
            </div>
            <div class="dropdown_item">
                <a href="#" class="dropdown_title">Двери</a>
                <ul class="dropdown_menu">
                    <li><a href="">Входные двери</a></li>
                    <li><a href="">Межкомнатные двери</a></li>
                    <li><a href="">Технические двери</a></li>
                </ul>
            </div>
        </div>
    </li>




</ul>


<nav class="is-header__nav header-nav">
    <ul class="header-nav__list">
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <li class="header-nav__item <?= ($item["SELECTED"]) ? 'active' : '' ?>">
                <span class="header-nav__text-span">
                    <a href="<?= $item['LINK'] ?>" class="header-nav__text is-link"><?= $item['TEXT'] ?></a>
                </span>
                <?php if ($item['LOWER_ITEMS']): ?>
                    <div class="header-nav__item__drop">
                        <div class="header-nav__item__drop__row header-nav__item__drop__row--width-25">
                            <?php if ($arResult['RECS']['FOR_BUSINESS'] || $arResult['RECS']['FOR_HOME']): ?>
                                <div class="header-nav__item__drop__col">
                                    <div class="header-nav__item__drop__item">
                                        <ul>
                                            <li><span>Рекомендуем</span></li>
                                            <?php foreach ($arResult['RECS'][$item['PARAMS']['LOWER']] as $rec): ?>
                                                <li><a href="<?= $rec['LINK'] ?>"><?= $rec['TEXT'] ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php foreach ($item['LOWER_ITEMS'] as $lowerItem): ?>
                                <div class="header-nav__item__drop__col">
                                    <div class="header-nav__item__drop__item">
                                        <ul>
                                            <li><span><a href="<?= $lowerItem['LINK'] ?>"><?= $lowerItem['TEXT'] ?></a></span>
                                            </li>
                                            <?php foreach ($lowerItem[$item['PARAMS']['LOWER']] as $liItem): ?>
                                                <li><a href="<?= $liItem['LINK'] ?>"><?= $liItem['TEXT'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <?php if ($arResult['IMAGES'][$item['PARAMS']['LOWER']]['SRC']): ?>
                            <div class="header-nav__item__drop__banner">
                                <div class="header-nav__item__drop__banner__image"
                                     style="background-image:url(<?= $arResult['IMAGES'][$item['PARAMS']['LOWER']]['SRC'] ?>)">
                                </div>
                                <?php if ($arResult['IMAGES'][$item['PARAMS']['LOWER']]['TEXT']): ?>
                                    <div class="header-nav__item__drop__banner__text">Скоро в продаже</div>
                                    <div class="header-nav__item__drop__banner__title"><?= $arResult['IMAGES'][$item['PARAMS']['LOWER']]['TEXT'] ?></div>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>