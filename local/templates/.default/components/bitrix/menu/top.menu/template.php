<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 */
?>
<nav class="is-header__nav header-nav">
    <ul class="header-nav__list">
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <li class="header-nav__item <?=($item["SELECTED"])? 'active' : ''?>">
                <span class="header-nav__text-span">
                    <a href="<?= $item['LINK'] ?>" class="header-nav__text is-link"><?= $item['TEXT'] ?></a>
                </span>
                <?php if ($item['LOWER_ITEMS']): ?>
                    <div class="header-nav__item__drop">
                        <div class="header-nav__item__drop__row header-nav__item__drop__row--width-25">
                            <?php if ($arResult['RECS']['FOR_BUSINESS']||$arResult['RECS']['FOR_HOME']): ?>
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
                                            <li><span><a href="<?= $lowerItem['LINK'] ?>"><?= $lowerItem['TEXT'] ?></a></span></li>
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