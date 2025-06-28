<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<form class="modal modal-geo" id="geo" action="" data-app="geo">
    <div class="h2">Выбранный филиал:
        <span><?= $arParams['CITY']['NAME'] ?></span>
    </div>
    <div class="modal__select" data-search="1" data-geo="/ajax/city_ajax.php">
        <select id="js-geo-select" name="set-city">
            <option value="Москва">Москва</option>
        </select>
    </div>

    <? if (!empty($arResult['BRANCHES'])): ?>
        <div class="modal__branches">
            <div class="title-text">
                Города с официальным представительством
            </div>

            <?php
            $branches = [];
            foreach ($arResult['BRANCHES'] as $branchItem)
            {
                $branches[] = '<a href="?set-city=' . $branchItem['FIELDS']['NAME'] . '">' . $branchItem['FIELDS']['NAME'] . '</a>';
            }
            ?>

            <?= implode(', ', $branches); ?>
        </div>
    <? endif ?>

    <!--    <button type="submit">-->
    <!--        Временно-->
    <!--    </button>-->
    <div class="title-text">Филиалы Hoermann в России</div>
    <? unset($arResult['ITEMS']['MAIN']) ?>
    <div class="modal__citys">
        <? foreach ($arResult['ITEMS'] as $letter => $chunk): ?>
            <div class="modal_cities_col">
                <div class="modal_cities_title">
                    <?= $letter ?>
                </div>
                <ul>
                    <? foreach ($chunk as $item): ?>
                        <li>
                            <a href="?set-city=<?= $item['FIELDS']['NAME'] ?>">
                                <?= $item['FIELDS']['NAME'] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        <? endforeach; ?>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Обновление города при клике на ссылку в модальном окне
        let modalLinks = document.querySelectorAll('.modal__citys li a, .modal__branches a');

        if (modalLinks !== null) {
            modalLinks.forEach(function (item) {
                item.addEventListener('click', function () {
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                });
            });
        }

        $('#js-geo-select').on('select2:select', (e) => {
            let city = $($(e.target)[0][1])[0].innerText
            $.ajax({
                type: 'post',
                url: '/ajax/set_city.php',
                data: {
                    city: city
                },
                success: function (result) {
                    document.querySelector('.is-header__location-div span').textContent = city
                    $.fancybox.close();

                    location.reload();
                },
            });
            //window.location.href = '<?//=$APPLICATION->GetCurDir()?>//' + '?set-city=' + $($(e.target)[0][1])[0].innerText;
        });
    })
</script>