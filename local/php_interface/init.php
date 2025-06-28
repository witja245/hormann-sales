<?php

require 'define.php';

require 'events.php';

require $_SERVER['DOCUMENT_ROOT'] . '/local/vendor/autoload.php';

if (file_exists(__DIR__ . "/include/helper.php"))
	require_once(__DIR__ . "/include/helper.php");
if (file_exists(__DIR__ . "/include/create-sitemap.php"))
	require_once(__DIR__ . "/include/create-sitemap.php");

function p($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

define('VUEJS_DEBUG', true);
define('DEFAULT_TEMPLATE_MAIN_PATH','/local/templates/mainNew');




function my_onBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES)
{
    global $APPLICATION;

    if ($_REQUEST['g-recaptcha-response']) {
        $httpClient = new \Bitrix\Main\Web\HttpClient;
        $result = $httpClient->post(
            'https://www.google.com/recaptcha/api/siteverify',
            array(
                'secret' => '6Lc5kI8qAAAAAKe7WYwUz2dHP4UM45epmlzCVfZf',
                'response' => $_REQUEST['g-recaptcha-response'],
                'remoteip' => $_SERVER['HTTP_X_REAL_IP']
            )
        );
        $result = json_decode($result, true);
        if ($result['success'] !== true) {
            $APPLICATION->throwException("Вы не прошли проверку");
            return false;
        }
    } else {
        $APPLICATION->ThrowException('Вы не прошли проверку');
        return false;
    }
}

AddEventHandler('form', 'onBeforeResultAdd', 'my_onBeforeResultAdd');
