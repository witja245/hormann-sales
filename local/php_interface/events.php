<?php

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('main', 'OnAdminIBlockElementEdit', ['\Itech\Event', 'tabPropHandler']);

$eventManager->addEventHandler("main", "OnBeforeProlog", ['\Itech\Event', 'beforePrologHandler']);

$eventManager->addEventHandler("main", "OnBeforeUserAdd", ['\Itech\Event', 'beforeUserAddHandler']);

$eventManager->addEventHandler("main", "OnBuildGlobalMenu", ['\Itech\Event', 'modifyAdminMenu']);

AddEventHandler("main", "OnBeforeProlog", function(){

    if(defined('ERROR_404') && ERROR_404 != 'Y'){ // && !isset($_SERVER['REAL_FILE_PATH'])

        \Itech\PageService::getInstance()->init();

        //set location

        global $APPLICATION;

        $context = Bitrix\Main\Application::getInstance()->getContext();

        $request = $context->getRequest();

        $value = $request->get("set-city");

        if ($value) {

            \Itech\Geo::setCity($value);

//            $redirectUrl = $APPLICATION->GetCurPageParam("", ['set-city']);
//
//            LocalRedirect($redirectUrl, false,"301 Moved permanently");
        }
    }
});

$eventManager->addEventHandler("main", "onEndBufferContent", "imgOptimization", 100);

$eventManager->addEventHandler("main", "OnEndBufferContent", "checkModified", 100);

function checkModified($content)
{
	$context = \Bitrix\Main\Context::getCurrent();
	$request = $context->getRequest();
	$isAdminSection = $request->isAdminSection();
	if (!$isAdminSection && !$request->isAjaxRequest()) {
		$cleanUri = explode('?', $_SERVER['REQUEST_URI'])[0];
		if (stripos($_SERVER['REQUEST_URI'], '?') !== false) {
			parse_str(explode('?', $_SERVER['REQUEST_URI'])[1], $params);
			foreach ($params as $key => $value) {
				if (!in_array($key, ['PAGE', 'arrFilter'])) {
					unset($params[$key]);
				}
			}
			if (!empty($params)) {
				$cleanUri .= '?' . http_build_query($params);
			}
		}
		$checkContent = $content;
		if (preg_match('/<body([^>]*?)>(.+)<\/body>/sui', $content, $matches)) {
			$checkContent = $matches[2];
		}
		$checkContent = preg_replace('/<meta itemprop="reviewCount" content="(.*?)">/sui', '', $checkContent);
		$checkContent = preg_replace('/"reviewCount":(.*?),/sui', '', $checkContent);
		$checkContent = preg_replace('/\'SERVER_TIME\':\'(.*?)\'/sui', '', $checkContent);
		$checkContent = preg_replace('/<script>new Image\(\)\.src(.*?)<\/script>/sui', '', $checkContent);
		$hash = md5($checkContent);
		$lastModified = time();
		$data = [];
		$found = false;
		$dataFile = $_SERVER['DOCUMENT_ROOT'] . '/upload/last_modified_data';
		if (file_exists($dataFile)) {
			if (!($data = json_decode(file_get_contents($dataFile), true))) {
				$data = [];
			}
			if (isset($data[$cleanUri]) && $data[$cleanUri]['hash'] == $hash) {
				$lastModified = $data[$cleanUri]['lm'];
				$found = true;
			}
		}
		if (!$found) {
			$data[$cleanUri] = [
				'hash' => $hash,
				'lm' => $lastModified
			];
			file_put_contents($dataFile, json_encode($data));
		}
		header('Cache-Control: public');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
		if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $lastModified) {
			header('HTTP/1.1 304 Not Modified');
			exit;
		}
	}
}

function convertToWebp($url)
{
	$return = $url;
	if ($return) {
		$type = explode('.', $return);
		$type = strtolower($type[count($type) - 1]);
		if ($type == 'jpg') {
			$type = 'jpeg';
		}
		$webpFile = explode('.', $return);
		$webpFile = implode('.', array_slice($webpFile, 0, count($webpFile) - 1)) . '.webp';
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . $webpFile)) {
			$return = $webpFile;
		} elseif (in_array($type, ['png', 'jpeg']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $return)) {
			$im = new Imagick();
			$im->pingImage($_SERVER['DOCUMENT_ROOT'] . $return);
			$im->readImage($_SERVER['DOCUMENT_ROOT'] . $return);
			$im->writeImage('webp:' . $_SERVER['DOCUMENT_ROOT'] . $webpFile);
			$return = $webpFile;
		}
	}
	return $return;
}

function imgOptimization(&$content)
{
	$content = preg_replace("/<img /sui", "<img loading='lazy' ", $content);
	if (preg_match_all('/src="\/([^"]*?)\.(png|jpg|jpeg)"/sui', $content, $matches)) {
		$urls = [];
		foreach ($matches[1] as $index => $match) {
			$url = '/' . $match . '.' . $matches[2][$index];
			if (!in_array($url, $urls)) {
				$urls[] = $url;
			}
		}
		foreach ($urls as $url) {
			$content = str_replace($url, convertToWebp($url), $content);
		}
		if (preg_match_all('/\/([^"]*?)\.(png|jpg|jpeg)/sui', $content, $matches)) {
			$urls = [];
			foreach ($matches[1] as $index => $match) {
				$url = '/' . $match . '.' . $matches[2][$index];
				if (!in_array($url, $urls)) {
					$urls[] = $url;
				}
			}
			foreach ($urls as $url) {
				$content = str_replace($url, convertToWebp($url), $content);
			}
		}
	}
}