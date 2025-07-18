<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<div class="topic margin-120">
    <div class="topic__item wow" data-wow-offset="200" style="background-image:url(<?=CFile::GetPAth($arResult['UF_TOP_BLOCK_IMAGE'])?>)">
        <?=$arResult['~UF_TOP_BLOCK']?>
    </div>
</div>
</div>
<div class="create wow" data-wow-offset="200">
    <div class="container">
        <div class="create__row">
            <div class="create__logo"><a href="/"><img src="<?=CFile::GetPath($arResult["UF_LOGO"])?>" alt=""></a></div>
            <div class="title-text"><?=$arResult["UF_LOGO_TITLE"]?></div>
        </div>
        <?if($arResult["UF_UNDER_LOGO_BLOCK_SLIDER"]):?>
            <div class="create__inner">
                <div class="create__list"><?=$arResult["~UF_UNDER_LOGO_BLOCK"]?></div>
                <div class="create__slider" data-app="slider-create">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?foreach ($arResult["UF_UNDER_LOGO_BLOCK_SLIDER"] as $item):?>
                                <div class="swiper-slide">
                                    <div class="create__slider__image"><img src="<?=CFile::GetPath($item)?>" alt=""></div>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                    <div class="create__slider__pager"></div>
                    <button class="create__slider__arrow create__slider__arrow_prev" type="button">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                        </svg>
                    </button>
                    <button class="create__slider__arrow create__slider__arrow_next" type="button">
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#arrow"></use>
                        </svg>
                    </button>
                </div>
            </div>
        <?endif;?>
    </div>
</div>
