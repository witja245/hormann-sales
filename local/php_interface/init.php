<?php
use Bitrix\Main\Diag;
use Psr\Log\logLevel;
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


function tl($logInfo, $file = "main", $maxLogSize = 1048576000)

{
    $logFile = $_SERVER["DOCUMENT_ROOT"] . "/log/" . $file . "_log.txt";
    $logger = new Diag\FileLogger($logFile, $maxLogSize);
    $logger->setLevel(LogLevel::DEBUG);
    $formatter = new Diag\LogFormatter(false);
    $logger->setFormatter($formatter);
    $showArgs = false;
    $trace      = '';
    $traceDepth = 6;
    if ($traceDepth > 0) {
        $trace = Diag\Helper::getBackTrace($traceDepth, ($showArgs ? null : DEBUG_BACKTRACE_IGNORE_ARGS), 2);
    }

    $context = [
        'message' => $logInfo,
        'host' => $_SERVER["SCRIPT_FILENAME"] . " - " . $_SERVER["REMOTE_ADDR"],
        'trace' => $trace,
    ];

    $message = "{host}\n"
        . "Date: {date}\n"
        . "{message}\n"
        . "{delimiter}\n";

    $logger->debug(
        $message,
        $context
    );

    AddMessage2Log($logInfo);

}

require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/autoload.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/general/CAllcorp3Cache.php');

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

