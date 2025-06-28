<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?php if ($arResult['ITEMS']):?>
<div class="edge wow" data-app="edge" data-wow-offset="200">
    <div class="edge__box">
        <div class="edge__content">
            <div class="h2">Преимущества сотрудничества с Hoermann</div>
        </div>
        <div class="edge__slider">
            <div class="edge__number">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?foreach ($arResult['ITEMS'] as $key=>$item):?>
                        <div class="swiper-slide">
                            <div class="subtext"><?=$key+1<10?'0'.($key+1):$key+1?></div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
            <div class="edge__inner">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?foreach ($arResult['ITEMS'] as $item):?>
                            <div class="swiper-slide">
                                <div class="edge__inner__row">
                                    <div class="edge__inner__img"><img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt=""></div>
                                    <div class="edge__inner__content">
                                        <div class="subtext"><?=$item['NAME']?></div>
                                        <div class="text"><?=$item['PREVIEW_TEXT']?></div>
                                    </div>
                                </div>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
