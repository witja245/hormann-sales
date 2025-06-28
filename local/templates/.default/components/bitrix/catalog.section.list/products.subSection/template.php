<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php if ($arResult['SECTIONS']): ?>
    <div class="topic">
        <div class="topic__row">
            <? foreach ($arResult['SECTIONS'] as $subSection):
                if (!$subSection['PICTURE']['SRC']) continue; ?>
                <div class="topic__col">
                    <div class="topic__item wow" data-wow-offset="200"
                       style="background-image:url(<?= $subSection['PICTURE']['SRC'] ?>)">
                        <a href="<?= $subSection['SECTION_PAGE_URL'] ?>" class="title-text"><?//= $subSection['NAME'] ?><?=$subSection["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]?></a>
                        <div class="subtext"><?= $subSection['DESCRIPTION'] ?></div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
<?php endif; ?>