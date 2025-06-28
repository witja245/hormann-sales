<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/**
 * @var array $arResult
 * @var array $arParams
 * @global CMain $APPLICATION
 * @var string $templateName
 * @var string $componentPath
 */

$uniqueId = md5($this->randString());
$uniqueId = $this->GetEditAreaId($uniqueId);
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'calculator');
$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'calculator');
$action = $componentPath . '/ajax.php';
?>

<style>
    .calculator__wrapper .selected {
        position:relative;
    }
    .calculator__wrapper .selected:before {

        content:'';
        filter: invert(15%) sepia(92%) saturate(1974%) hue-rotate(200deg) brightness(92%) contrast(101%);
        z-index: 3;
        position:absolute;
        width:20px;
        height:20px;
        right: 0;
		background-image: url(https://www.svgrepo.com/show/166018/check-mark.svg);
    	background-size: 100%;
    }
    .as-accordion__item_disabled .as-accordion__item-title {
        color: #262626;
    }
    .disabled {
        background-color: gray;
    }
    .gate-size-select__popup {
        background-color: #f2f3f8;
        height: 178px;
        overflow-y: scroll;
        position: absolute;
        z-index: 3;
        right: 0;
        top: 87px;
        user-select: none;
    }
    @media screen and (min-width: 525px) and (max-width: 596px) {
        .gate-size-select__popup {
            right: unset;
            left: 74px;
            top: 94px;
        }
    }
    @media screen and (min-width: 345px) and (max-width: 524px) {
        .gate-size-select__popup {
            right: 0;
            left: unset;
            top: 145px;
        }
    }
    @media screen and (max-width: 344px) {
        .gate-size-select__popup {
            right: unset;
            left: 74px;
            top: 155px;
        }
    }
    .gate-size-select__popup_item {
        padding: 10px 20px;
    }
    .gate-size-select__popup_item:hover {
        padding: 10px 20px;
        background-color: #003a7d;
        color: #fff;
    }
    .fixed_block_position-desktop {
        max-height: 1200px;
    }
    @media screen and (max-width: 768px) {
        .fixed_block_position-desktop {
            display: none;
        }
        .fixed_block_position-mobile {
            display: block;
        }
    }
    @media screen and (min-width: 769px) {
        .fixed_block_position-mobile {
            display: none;
        }
    }
    .fixed_block_position-mobile-mask {
        display: none;
        position: relative;
    }
    .mobile-mask-overlay {
        background-color: #FFFFFF;
        position: absolute;
        width: 100%;
        height: 100%
    }
</style>
<div data-entity="calculator" class="content content_homepage">
    <main class="page-index calculator" style="display: flex">

        <?php include $_SERVER['DOCUMENT_ROOT'].'/local/components/asteq/calculator/templates/.default/form.php'; ?>

        <div class="calculator__wrapper" id="calculator-container">
            <div class="calculator__result fixed_block_position-mobile" style="position: relative">
                <div class="calculator__result-img fixed_block" data-margin-top="85" style="z-index: 111">
                    <img :src="mainImg"/>
                </div>
                <div class="fixed_block_position-mobile-mask">
                    <div class="mobile-mask-overlay">
                    </div>
                    <img :src="mainImg"/>
                </div>
            </div>
            <div class="calculator__items">
                <div class="as-accordion__item-title accordion__row d-f-sb">Серия ворот</div>
                <div class="calculator__result-item">

                    <div class="d-f f-w" style="margin-bottom: 10px">
                        <label v-for="gateType in gateTypes" :key="gateType.ID" :class="{'selected': selected.gateType == gateType.ID}"  style="margin-right: 20px">
                            <span class="calculator__result-item-img" v-if="gateType.SRC">
                                <img :src="gateType.SRC" alt="" class="calculator__result-item-img">
                            </span>
                            <div class="calculator__result-item-name">{{ gateType.UF_NAME }}</div>
                            <input type="radio" v-model="selected.gateType" name="gate-type" :value="gateType.ID">
                        </label>
                    </div>
                </div>
                <Accordion>

                    <div class="accordion__row d-f-sb">
                        <Accordionitem :title="parts[0].value" @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="size" :is-visible="selectedPart == 'size'"
                                        :clickable="isPartClickable('size')"
                                        :is-disabled="!selected.width || !selected.height">
                            <Sizes
                                    @set-size="setSize"
                                    :width="selected.width"
                                    :height="selected.height"
                                    :max-width="maxWidth"
                                    :min-width="minWidth"
                                    :max-height="maxHeight"
                                    :min-height="minHeight"
                                    :width-error="validation.firstError('selected.width')"
                                    :height-error="validation.firstError('selected.height')"
                                    :key="selected.gateType"
                                    :available-sizes="sizes"
                            ></Sizes>

                            <p style="color: red;" v-if="parts[0].showError">
                                {{ parts[0].errorMessage }}
                            </p>

                        </Accordionitem>

                        <div class="accordion__row-result">
                            {{ parts[0].selected }}
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('surface')">
                        <Accordionitem :title="parts[1].value" @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="surface" :is-visible="selectedPart == 'surface'"
                                       :clickable="isPartClickable('surface')"
                                       :is-disabled="!selected.surface">
                            <Surfaceas
                                    :key="selected.gateType"
                                    :surface-data="surface"
                                    @recalculate="userSelected"
                            ></Surfaceas>

                            <p style="color: red;" v-if="parts[1].showError">
                                {{ parts[1].errorMessage }}
                            </p>

                        </Accordionitem>
                        <div class="accordion__row-result">
                            <span v-if="!error">{{ parts[1].selected }}</span>
                            <span  style="color: red;">{{ error2 }}</span>
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('base')">
                        <Accordionitem :title=parts[2].value @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="base" :is-visible="selectedPart == 'base'"
                                       :clickable="isPartClickable('base')"
                                       :is-disabled="!selected.base">
                            <Baseas
                                    :base-data="base"
                                    :key="selected.gateType"
                                    @recalculate="userSelected"
                            ></Baseas>
                            <p style="color: red;" v-if="parts[2].showError">
                                {{ parts[2].errorMessage }}
                            </p>
                        </Accordionitem>
                        <div class="accordion__row-result">
                            <span v-if="!error">{{ parts[2].selected }}</span>
                            <span  style="color: red;">{{ error }}</span>
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('rec_colors')">
                        <Accordionitem :title=parts[3].value @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="color" :is-visible="selectedPart == 'color'"
                                       :clickable="isPartClickable('color')"
                                       :is-disabled="!selected.color">
                            <Coloras
                                    :color-data="rec_colors"
                                    :key="selected.gateType"
                                    @recalculate="userSelected"
                            ></Coloras>

                            <p style="color: red;" v-if="parts[3].showError">
                                {{ parts[3].errorMessage }}
                            </p>

                        </Accordionitem>
                        <div class="accordion__row-result">
                            {{ parts[3].selected }}
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('drive')">
                        <Accordionitem :title=parts[4].value @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="drive" :is-visible="selectedPart == 'drive'"
                                       :clickable="isPartClickable('drive')" :showNext="!isFinal">
                            <Driveas
                                    :drive-data="drive"
                                    :key="selected.gateType"
                                    @recalculate="userSelected"
                            ></Driveas>
                        </Accordionitem>
                        <div class="accordion__row-result">
                            {{ parts[4].selected }}
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('facings')">
                        <Accordionitem :title=parts[5].value @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="facing" :is-visible="selectedPart == 'facing'"
                                       :clickable="isPartClickable('facing')">
                            <Faceas
                                    :face-data="facings"
                                    :key="selected.gateType"
                                    @recalculate="userSelected"
                            ></Faceas>
                            <p style="color: red;" v-if="parts[5].showError">
                                {{ parts[5].errorMessage }}
                            </p>
                        </Accordionitem>
                        <div class="accordion__row-result">
                            {{ parts[5].selected }}
                        </div>
                    </div>

                    <div class="accordion__row d-f-sb" v-if="isPartAvailable('glass')">
                        <Accordionitem :title=parts[6].value @select-part="onPartSelect" @go-next="onGoNext"
                                       internal-name="glass" :is-visible="selectedPart == 'glass'"
                                       :clickable="isPartClickable('glass')" :showNext="!isFinal">
                            <Glassas
                                    :glass-data="glass"
                                    :key="selected.gateType"
                                    @recalculate="userSelected"
                            ></Glassas>
                            <p style="color: red;" v-if="parts[6].showError">
                                {{ parts[6].errorMessage }}
                            </p>
                        </Accordionitem>
                        <div class="accordion__row-result">
                            {{ parts[6].selected }}
                        </div>
                    </div>
                </Accordion>
            </div>

            <div v-if="total && isEnd" class="calculator__item-total d-f-sb a-i-c f-w j-c-sb">
                <div class="d-f-sb a-i-c">
                    <a href="#modal-order" @click="test()" data-fancybox class="button button--md button--primary">
                        <span class="button__text">Оставить заявку</span>
                    </a>
                    <?php /* <button class="print-button">
                        <span class="print-icon"></span>
                    </button> */ ?>
                </div>
<!--                <div v-if="total.price > 0" class="calculator__item-total-price">{{total.formattedPrice}}</div>-->
                <div  class="calculator__item-total-price">
					<img src="/static/src/images/calculator/question.svg" alt=""
                         title="Уточняйте цену у менеджера">
                </div>
                <div v-if="total.stock > 0" class="calculator__item-total-price">
					<img src="/static/src/images/calculator/question.svg" alt="" title="Доступен на складе">
                </div>
            </div>

        </div>

        <div class="calculator__result fixed_block_position-desktop" data-sticky-container>
            <div class="calculator__result-img fixed_block" data-margin-top="130">
                <img :src="mainImg"/>
            </div>
        </div>

</div>


<script>
    var params = {
        gateTypes: <?=\Bitrix\Main\Web\Json::encode($arResult['gates']) ?>,
        descriptions: <?=\Bitrix\Main\Web\Json::encode($arResult['descriptions']) ?>,
        type: '<?=$arResult['type'] ?>',
        sTemplate: '<?=$signedTemplate?>',
        sParams: '<?=$signedParams ?>',
        action: '<?=$action ?>',
        city: '<?=$arResult['city'] ?>'
    };
    var calculator = new BX.Asteq.Calculator({
        el: document.querySelector('[data-entity="calculator"]'),
        params: params
    });
</script>
