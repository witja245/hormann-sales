<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php $this->setFrameMode(true); ?>

<?php if ($arResult) : ?>

    <ul class="menu">
        <?php foreach ($arResult as $item) : ?>
            <?php if (!empty($item['CHILD'])): ?>
                <li>
                    <a href="<?php if($item['PARAMS']['SHOW_LINKS'] != 'N'): echo $item['LINK']; else: echo 'javascript:void(0);'; endif;?>"><?= $item['TEXT'] ?></a>
                    <?php if (!empty($item['CHILD']['0']['CHILD'])): ?>
                        <div class="menu_mobile-links">
                            <?php foreach ($item['CHILD'] as $childsMobile): ?>
                                <div class="menu_mobile-link"><?= $childsMobile['TEXT'] ?></div>
                            <?php endforeach; ?>

                        </div>
                    <?php endif; ?>

                    <div class="dropdown <?php if (empty($item['CHILD']['0']['CHILD'])): echo 'dropdown_one'; endif; ?>">
                        <div class="dropdown_back">
                            <img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/back_arrow.svg"
                                                        alt=""> Назад
                        </div>
                        <?php foreach ($item['CHILD'] as $childs): ?>
                            <?php if (!empty($childs['CHILD'])): ?>
                                <div class="dropdown_item">
                                    <a href="<?= $childs['LINK'] ?>" class="dropdown_title"><?= $childs['TEXT'] ?></a>
                                    <?php foreach ($childs['CHILD'] as $subChild): ?>

                                        <?php if (!empty($subChild['CHILD'])): ?>
                                            <div class="dropdown_subtitle">
                                               <a href="<?= $subChild['LINK'] ?>"><?= $subChild['TEXT'] ?></a>
                                                <img src="<?= DEFAULT_TEMPLATE_MAIN_PATH ?>/img/menu_arrow.svg" alt="">
                                                <ul class="dropdown_menu">
                                                    <?php foreach ($subChild['CHILD'] as $subSubChild): ?>
                                                        <li>
                                                            <a href="<?= $subSubChild['LINK'] ?>"><?= $subSubChild['TEXT'] ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php else: ?>
                                            <ul class="dropdown_menu">
                                                <li><a href=" <?= $subChild['LINK'] ?>"> <?= $subChild['TEXT'] ?></a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>


                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <a href="<?= $childs['LINK'] ?>" class="dropdown_title"><?= $childs['TEXT'] ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </li>
            <?php else: ?>

                <li><a href="<?php if($item['PARAMS']['SHOW_LINKS'] != 'N'): echo $item['LINK']; endif;?>"><?= $item['TEXT'] ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>


<?php endif; ?>