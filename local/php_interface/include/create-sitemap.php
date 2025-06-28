<?php
//if (!isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT'] == '') {
//	$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../../');
//}
//require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

class Sitemap {
	public static function createSitemap() {
		$index = 'https://hormann-sales.ru';
		$arrMap = [];

		$arrStaticPages = [
			'/private/',
			'/business/',
			'/business/service/',
			'/products/',
			'/share/',
			'/kalkulator/',
			'/contacts/',
			'/about/',
			'/portfolio/',
			'/architect/',
			'/architect/architect-program/',
			'/for-dealers/',
			'/media/',
			'/media/magazine/',
			'/media/video/',
			'/media/documents/',
			'/news/',
			'/advice/',
		];

		$lastmodCurrDate= date('c', time() - \CTimeZone::getOffset());
		$changefreqDefault = 'daily';
		$priorityMain = '1';
		$prioritySection = '0.9';
		$priorityElement = '0.8';

		$arrHost = [
			'loc' => $index,
			'lastmod' => $lastmodCurrDate,
			'changefreq' => $changefreqDefault,
			'priority' => $priorityMain,
		];
		$arrMap[] = $arrHost;

		foreach ($arrStaticPages as $key => $staticPage) {
			$arrMap[] = [
				'loc' => $index.$staticPage,
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $prioritySection,
			];
		}
		/* products */
		$productsSection = CIBlockSection::GetList(
			["SORT" => "ASC"],
			[
				"IBLOCK_ID" => 33,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y"
			]
		);
		while ($productSection = $productsSection->GetNext()) {
			$arrMap[] = [
				'loc' => $index.$productSection['SECTION_PAGE_URL'],
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $prioritySection,
			];

			$productElements = CIBlockElement::GetList(
				["SORT" => "ASC"],
				[
					"IBLOCK_ID" => 33,
					"IBLOCK_SECTION_ID" => $productSection["ID"],
					"GLOBAL_ACTIVE" => "Y",
					"ACTIVE" => "Y"
				],
				false,
				false,
				[
					"ID",
					"NAME",
					"DETAIL_PAGE_URL"
				]
			);
			while ($productElement = $productElements->GetNext()) {
				$arrMap[] = [
					'loc' => $index.$productElement['DETAIL_PAGE_URL'],
					'lastmod' => $lastmodCurrDate,
					'changefreq' => $changefreqDefault,
					'priority' => $priorityElement,
				];
			}
		}
		/* /products */

		/* share */
		$shareElements = CIBlockElement::GetList(
			["SORT" => "ASC"],
			[
				"IBLOCK_ID" => 6,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"DETAIL_PAGE_URL"
			]
		);
		while ($shareElement = $shareElements->GetNext()) {
			$arrMap[] = [
				'loc' => $index.$shareElement['DETAIL_PAGE_URL'],
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $priorityElement,
			];
		}
		/* /share */

		/* portfolio */
		$portfolioElements = CIBlockElement::GetList(
			["SORT" => "ASC"],
			[
				"IBLOCK_ID" => 19,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"DETAIL_PAGE_URL"
			]
		);
		while ($portfolioElement = $portfolioElements->GetNext()) {
			$arrMap[] = [
				'loc' => $index.$portfolioElement['DETAIL_PAGE_URL'],
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $priorityElement,
			];
		}
		/* /portfolio */

		/* news */
		$newsElements = CIBlockElement::GetList(
			["SORT" => "ASC"],
			[
				"IBLOCK_ID" => 13,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"DETAIL_PAGE_URL"
			]
		);
		while ($newsElement = $newsElements->GetNext()) {
			$arrMap[] = [
				'loc' => $index.$newsElement['DETAIL_PAGE_URL'],
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $priorityElement,
			];
		}
		/* /news */

		/* advice */
		$adviceElements = CIBlockElement::GetList(
			["SORT" => "ASC"],
			[
				"IBLOCK_ID" => 5,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"DETAIL_PAGE_URL"
			]
		);
		while ($adviceElement = $adviceElements->GetNext()) {
			$arrMap[] = [
				'loc' => $index.$adviceElement['DETAIL_PAGE_URL'],
				'lastmod' => $lastmodCurrDate,
				'changefreq' => $changefreqDefault,
				'priority' => $priorityElement,
			];
		}
		/* /advice */

		$dom = new DOMDocument('1.0', 'UTF-8');
		$urlset = $dom->createElement('urlset');
		$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		foreach ($arrMap as $item) {
			$url = $dom->createElement('url');

			$loc = $dom->createElement('loc');
			$text = $dom->createTextNode($item['loc']);
			$loc->appendChild($text);
			$url->appendChild($loc);

			$lastmod = $dom->createElement('lastmod');
			$text = $dom->createTextNode($item['lastmod']);
			$lastmod->appendChild($text);
			$url->appendChild($lastmod);

			$changefreq = $dom->createElement('changefreq');
			$text = $dom->createTextNode($item['changefreq']);
			$changefreq->appendChild($text);
			$url->appendChild($changefreq);

			$priority = $dom->createElement('priority');
			$text = $dom->createTextNode($item['priority']);
			$priority->appendChild($text);
			$url->appendChild($priority);

			$urlset->appendChild($url);
		}

		$dom->appendChild($urlset);

// Сохранение в файл.
		$dom->save('./sitemap-auto.xml');

		return "Sitemap::createSitemap();";
	}
}