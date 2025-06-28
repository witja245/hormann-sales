<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $APPLICATION;
$APPLICATION->SetTitle("Спасибо");
?>

    <div class="content">
        <div class="container">
            <div class="breadcrumbs">
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "main",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1"
                    )
                ); ?>
            </div>
            <h1 class="h2 wow" data-wow-offset="200">
                Спасибо за вашу заявку
            </h1>
            <div class="text wow animated" data-wow-offset="200" style="visibility: visible;">
                <p>Спасибо, ваша заявка принята, в ближайшее время с вами свяжется наш менеджер!</p>
            </div>


        </div>
    </div>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>