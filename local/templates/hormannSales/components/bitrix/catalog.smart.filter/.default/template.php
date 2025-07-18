<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$hideFlag = true;
?>


<div class="catalogue__left">
<form id="bx-filter-form" name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" data-app="filter"
      action="<? echo $arResult["FORM_ACTION"] ?>" method="get"
      class="catalogue__option is-active php-hide">
    <div class="catalogue__option__title catalogue__option__title--top">Фильтр</div>
    <div class="catalogue__option__drop">
        <div class="catalogue__option__item">
            <? foreach ($arResult['ITEMS'] as $key => $arItem):?>
            <?if($arItem['VALUES']&&$key!='BASE') $hideFlag=false?>
                <? if ($arItem['DISPLAY_TYPE'] == 'F'): ?>
                    <div class="checkbox">
                        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   for="<? echo $ar["CONTROL_ID"] ?>">
                                <input class="js-option-item"
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                        onclick="smartFilter.click(this)"
                                /><i></i><span><?= $arItem['NAME'] ?></span>
                            </label>
                        <? endforeach; ?>
                    </div>
                    <? unset($arResult['ITEMS'][$key]) ?>
                <? endif; ?>
            <? endforeach; ?>
        </div>
        <?
        //not prices
        foreach ($arResult["ITEMS"] as $key => $arItem) { ?>
            <? if ($arItem['CODE'] != 'COLOR' && $arItem['CODE'] != 'BASE' && $arItem['VALUES']): ?>
                <div class="catalogue__option__item">
                    <div class="catalogue__option__title">
                        <? if ($arItem['CODE'] == 'GOFR'): ?>
                            Мотив
                        <? else: ?>
                            <?= $arItem['NAME'] ?>
                        <? endif; ?>
<!--                        --><?// if ($arItem['CODE'] == 'TYPE'): ?>
<!--                            <a class="help" href="#modal-type" data-fancybox>?</a>-->
<!--                        --><?// endif; ?>
                        <? if ($arResult['PROMPTS'][$arItem['CODE']]):?>
                            <a class="help" href="#modal-filter-<?=$arItem['CODE']?>" data-fancybox>?</a>
                         <div class="hidden">
                             <div class="modal modal-type" id="modal-filter-<?=$arItem['CODE']?>">
                                 <?if ($arResult['PROMPTS'][$arItem['CODE']]['UF_IMAGE']):?>
                                     <div class=""><img src="<?= $arResult['PROMPTS'][$arItem['CODE']]['UF_IMAGE'] ?>" alt=""></div>
                                 <?endif;?>
                                <?=$arResult['PROMPTS'][$arItem['CODE']]['UF_TEXT']?>
                             </div>
                         </div>
                        <? endif;?>
                        <script type="text/javascript">
                          new top.BX.CHint({
                            parent: top.BX("item_title_hint_<?echo $arItem["ID"]?>"),
                            show_timeout: 10,
                            hide_timeout: 200,
                            dx: 2,
                            preventHide: true,
                            min_width: 250,
                            hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"])?>'
                          });
                        </script>
                    </div>

                    <div class="catalogue__option__select" data-role="bx_filter_block" data-app="select">
                        <?
                        $arCur = current($arItem["VALUES"]);
                        ?>
                        <select class="js-option-item" name="<?= current(array_filter($arItem['VALUES'], function ($a) {
                            return $a['CHECKED'];
                        }))['CONTROL_NAME'] ?: $arItem['CODE'] ?>"
                                onchange="this.setAttribute('name', (this.options[selectedIndex].getAttribute('name'))); smartFilter.click(this.options[selectedIndex])">
                            <option value="All">Все
<!--                                --><?// switch ($arItem['CODE']){
//                                    case 'SIZE':
//                                    case 'GOFR': {
//                                        echo 'Любой';
//                                        break;
//                                    }
//                                    case 'CONTROL':{
//                                        echo 'Любое';
//                                        break;
//                                    }
//                                    default: {
//                                        echo 'Любая';
//                                        break;
//                                    }
//                                }?>
                            </option>
                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                                <option data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                        class="bx-filter-param-label <? echo $ar["DISABLED"] ? 'disabled' : '' ?>"
                                        for="<? echo $ar["CONTROL_ID"] ?>"
                                        type="checkbox"
                                        value="<? echo $ar["HTML_VALUE"] ?>"
                                        name="<? echo $ar["CONTROL_NAME"] ?>"
                                        id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'selected="selected"' : '' ?>
                                        onclick="smartFilter.click(this)">
                                    <?= $ar["VALUE"] ?>
                                </option>
                            <? endforeach; ?>
                        </select>
                    </div>
                </div>
            <? elseif ($arItem['CODE'] == 'COLOR'&&$arItem["VALUES"]): ?>
                <div class="catalogue__option__item" data-app="catalogue-more">
                    <div class="catalogue__option__title"><?= $arItem['NAME'] ?></div>
                    <? $index = 1 ?>
                    <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                        <div class="checkbox">
                            <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                   for="<? echo $ar["CONTROL_ID"] ?>">
                                <input class="js-option-item"
                                       type="checkbox"
                                       value="<? echo $ar["HTML_VALUE"] ?>"
                                       name="<? echo $ar["CONTROL_NAME"] ?>"
                                       id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                       onclick="smartFilter.click(this)"
                                /><i></i><span><?= $ar['VALUE'] ?></span>
                            </label>
                        </div>
                        <? $index++;
                        unset($arItem['VALUES'][$val]);
                        if ($index == 6)
                            break; ?>
                    <? endforeach; ?>
                    <? if ($arItem['VALUES']): ?>
                        <div class="catalogue__option__more">
                            <button type="button">Еще</button>
                        </div>
                        <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                            <div class="checkbox-drop">
                                <div class="checkbox">
                                    <label data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                           for="<? echo $ar["CONTROL_ID"] ?>">
                                        <input class="js-option-item"
                                               type="checkbox"
                                               value="<? echo $ar["HTML_VALUE"] ?>"
                                               name="<? echo $ar["CONTROL_NAME"] ?>"
                                               id="<? echo $ar["CONTROL_ID"] ?>"
                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                               onclick="smartFilter.click(this)"
                                        /><i></i><span><?= $ar['VALUE'] ?></span>
                                    </label>
                                </div>
                            </div>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            <? endif; ?>
            <?
        }
        ?>
        <div class="catalogue__option__result" id="modef_parent" data-ajax="/static/build/ajax/catalogue-result.json">
            <div id="modef" class="catalogue__option__result__text">Выбрано: <span id="modef_num"></span></div>
            <input type="submit" class="catalogue__option__result__link" name="set_filter" id="set_filter_2" value="Подобрать">
<!--            <div class="catalogue__option__result__link">Подобрать</div>-->
        </div>
        <input type="hidden" name="set_filter" value="Y">
        <div class="row">
            <div class="col-xs-12 bx-filter-button-box">
                <div class="bx-filter-block">
                    <div class="bx-filter-parameters-box-container catalogue__option__btns">
                        <input
                                class="btn btn-themes"
                                type="submit"
                                id="set_filter"
                                name="set_filter"
                                value="Применить"
                        />
                        <input
                                class="btn btn-link"
                                type="submit"
                                id="del_filter"
                                name="del_filter"
                                value="Отменить"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
    <?/*<a class="btn catalogue__link" href="/kalkulyator/"><span>Перейти к калькулятору</span></a>*/?>
</div>
<?php if($hideFlag):?>
    <style>
        .php-hide{
            display: none;
        }
    </style>
<?php endif;?>
<script type="text/javascript">
  var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
