<?php

class Helper {
	public static function getCanonical() {
		$url = $_SERVER['REQUEST_URI'];
		$url = explode('?', $url);
		$url = $url[0];

		if (strpos($url, '/filter/')) {
			$url = explode('filter', $url);
			$url = $url[0];
		}

		if (!empty($_GET['PAGEN_1'])) {
			$url .= '?PAGEN_1='.$_GET['PAGEN_1'];
		} elseif (!empty($_GET['PAGEN_2'])) {
			$url .= '?PAGEN_2='.$_GET['PAGEN_2'];
		}
		echo '<link rel="canonical" href="'.((!empty($_SERVER['HTTPS'])) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$url.'">' ;
	}
}