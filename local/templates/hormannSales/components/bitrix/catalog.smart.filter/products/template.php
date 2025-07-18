<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<form class="catalogue__option">
    <div class="catalogue__option__item">
        <div class="catalogue__option__title">Фильтр</div>
        <? foreach ($arResult['ITEMS'] as $key => $item): ?>
            <? if ($item['DISPLAY_TYPE'] == 'F'): ?>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"><i></i><span><?= $item['NAME'] ?></span>
                    </label>
                </div>
                <? unset($arResult['ITEMS'][$key]) ?>
            <? endif; ?>
        <? endforeach; ?>
    </div>
    <? foreach ($arResult['ITEMS'] as $item): ?>
        <? if ($item['CODE'] != 'COLOR' && $item['CODE'] != 'BASE' && $item['VALUES']): ?>
            <div class="catalogue__option__item">
                <div class="catalogue__option__title">
                    <?= $item['NAME'] ?>
                    <? if ($item['CODE'] == 'TYPE'): ?>
                        <a class="help" href="#modal-type" data-fancybox>?</a>
                    <? endif; ?>
                </div>
                <div class="catalogue__option__select" data-app="select">
                    <select>
                        <option value="1">Любая</option>
                        <? $index = 1; ?>
                        <? foreach ($item['VALUES'] as $key => $option): $index++; ?>
                            <option value="<?= $index ?>"><?= $option['VALUE'] ?></option>
                        <? endforeach; ?>
                    </select>
                </div>
            </div>
        <? elseif ($item['VALUES'] && $item['CODE'] != 'BASE'): ?>
            <div class="catalogue__option__item" data-app="catalogue-more">
                <div class="catalogue__option__title"><?= $item['NAME'] ?></div>
                <? $index = 1 ?>
                <? foreach ($item['VALUES'] as $key => $color): ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"><i></i><span><?= $color['VALUE'] ?></span>
                        </label>
                    </div>
                    <? $index++;
                    unset($item['VALUES'][$key]);
                    if ($index == 6)
                        break; ?>
                <? endforeach; ?>
                <? if ($item['VALUES']): ?>
                    <div class="catalogue__option__more">
                        <button type="button">Еще</button>
                    </div>
                    <? foreach ($item['VALUES'] as $key => $color): ?>
                        <div class="checkbox-drop">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"><i></i><span><?= $color['VALUE'] ?></span>
                                </label>
                            </div>
                        </div>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
        <? endif; ?>
    <? endforeach; ?>
</form>