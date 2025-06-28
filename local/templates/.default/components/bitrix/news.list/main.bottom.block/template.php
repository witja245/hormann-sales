<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section class="is-section page-index__more-sect wow" data-wow-offset="200">
    <div class="page-slider page-slider--type-more" data-is="page-slider">
        <div class="wrapper-x-right-dir">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?$chunkItems = array_chunk($arResult['ITEMS'],5);?>
                    <? foreach ($chunkItems as $chunk):?>
                        <?foreach ($chunk as $key => $item):?>
                            <?if($key==0):?>
                                <div class="swiper-slide">
                                    <div class="page-slider__slide page-slider__slide--type1"><a class="item is-link" href="<?=$item['PREVIEW_TEXT']?>" data-img="<?=$item['PREVIEW_PICTURE']['SRC']?>" data-img-fast="1"><span class="page-slider__slide-ttl2"><?=$item['NAME']?></span></a></div>
                                </div>
                            <?elseif ($key==1||$key==2):?>
                                <div class="swiper-slide">
                                    <div class="page-slider__slide page-slider__slide--type2"><a class="item is-link" href="<?=$item['PREVIEW_TEXT']?>" data-img="<?=$item['PREVIEW_PICTURE']['SRC']?>" data-img-fast="1"><span class="page-slider__slide-ttl2"><?=$item['NAME']?></span></a></div>
                                </div>
                            <?else:?>
                            <?if ($key==3):?>
                                <div class="swiper-slide">
                                    <div class="page-slider__slide page-slider__slide--type4">
                                        <?endif;?>
                                        <a class="item is-link" href="<?=$item['PREVIEW_TEXT']?>" style="background-image: url(<?=$item['PREVIEW_PICTURE']['SRC']?>)"><span class="page-slider__slide-ttl2"><?=$item['NAME']?></span></a>
                                        <?if ($key==4||end($item)):?>
                                    </div>
                                </div>
                                <?endif;?>
                            <?endif;?>
                        <?endforeach;?>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <div class="wrapper wrapper--md">
            <div class="swiper-pagination js-pager"></div>
        </div>
    </div>
</section>