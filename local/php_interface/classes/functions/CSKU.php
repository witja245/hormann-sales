<?
namespace Aspro\Allcorp3\Functions;

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\IO\File;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Type\Collection;
use Bitrix\Main\Config\Option;
use Bitrix\Iblock;

Loc::loadMessages(__FILE__);

if(!class_exists('CSKU'))
{
	/**
	 * Class for manipulate sku items
	 */
	class CSKU{
		/**
		 * @var string MODULE_ID solution CODE
		 * @var string linkCodeProp Code linked property
		 * @var number selectedItem ID selected item after sort
		 * @var array linkedProp All info linked property
		 * @var array treeProp Tree props by item
		 * @var array props All tree props form params
		 * @var array items All items
		 * @var array currentItem Selected item
		 * @var array config Params
		 */
		const MODULE_ID = \CAllcorp3::moduleID;

		public $props = [];
		public $items = [];
		public $linkedProp = [];
		public $treeProp = [];
		public $currentItem = [];
		public $config = [];
		public $linkCodeProp = '';
		private $selectedItem = 0;

		public function __construct(array $arOptions = [])
		{
			$arDefaultOptions = [
				'ORDER_VIEW' => false,
				'SHOW_ONE_CLICK_BUY' => 'N',
				'DISPLAY_COMPARE' => false,
				'USE_FAST_VIEW_PAGE_DETAIL' => 'NO',
				'LINK_SKU_PROP_CODE' => 'LINK_SKU',
				'SKU_SORT_FIELD' => 'sort',
				'SKU_SORT_ORDER' => 'asc',
				'SKU_SORT_FIELD2' => 'name',
				'SKU_SORT_ORDER2' => 'asc',
				'SKU_PROPERTY_CODE' => ['FILTER_PRICE', 'FORM_ORDER', 'PRICE_CURRENCY'],
				'SKU_TREE_PROPS' => [],
			];
			if ($arOptions['SKU_PROPERTY_CODE']) {
				$arOptions['SKU_PROPERTY_CODE'] = array_merge(
					$arDefaultOptions['SKU_PROPERTY_CODE'], 
					$arOptions['SKU_PROPERTY_CODE']
				);
			}
			$arConfig = array_merge($arDefaultOptions, $arOptions);
			
			$this->linkCodeProp = $arConfig['LINK_SKU_PROP_CODE'];
			$this->config = \array_intersect_key($arConfig, $arDefaultOptions);
		}

		/**
		 * Check visible and value in LINK_SKU property
		 * @param array $arProperties DISPLAY_PROPERTIES
		 * @return boolean
		 */
		private function checkItemLinkProp(array $arProperties = [])
		{
			$bCheck = false;
			if (
				$arProperties && 
				(
					isset($arProperties[$this->linkCodeProp]) && 
					\is_array($arProperties[$this->linkCodeProp]) && 
					$arProperties[$this->linkCodeProp]['VALUE']
				)
			) {
				$bCheck = true;
			}
			return $bCheck;
		}
		
		/**
		 * Set $this->linkedProp from LINK_SKU property
		 * @param array $arProperties DISPLAY_PROPERTIES
		 */
		public function setLinkedPropFromDisplayProps(array $arProperties = [])
		{
			if ($this->checkItemLinkProp($arProperties)) {
				$this->linkedProp = $arProperties[$this->linkCodeProp];
				unset($this->linkedProp['LINK_ELEMENT_VALUE']);
			} else {
				$this->linkedProp = [];
			}
		}
		
		/**
		 * Set $this->linkedProp from custom array
		 * @param array $arFields 
		 */
		public function setLinkedPropFromArray(array $arFields = [])
		{
			$this->linkedProp = $arFields;
		}

		/**
		 * Reset items variables 
		 * 
		 */
		private function resetItems()
		{
			$this->items = [];
			$this->currentItem = [];
			$this->treeProps = [];
			$this->matrix = [];
		}

		/**
		 * Get all items from sku iblock by property LINK_SKU
		 * @param array $arProperties DISPLAY_PROPERTIES
		 * @return array [['SECTION_ID' => ['ITEMS' => []]] | []
		 */
		public function getItemsByProperty()
		{
			$this->resetItems();
			if ($this->linkedProp && $this->linkedProp['VALUE']) {
				$arFilter = [
					'ID' => $this->linkedProp['VALUE'],
					'ACTIVE' => 'Y',
					'IBLOCK_ID' => $this->linkedProp['LINK_IBLOCK_ID']
				];
				$this->getItemsByFilter($arFilter);
				$this->getItemsProps();
				$this->getMatrix();
			}
		}

		/**
		 * Get all items by filter
		 * @param array $arFilter
		 * @return array 
		 */
		public function getItemsByFilter(array $arFilter = [])
		{
			if (!$arFilter['IBLOCK_ID']) {
				return [];
			}

			$iblockID = $arFilter['IBLOCK_ID'];
			$arSelect = ['ID', 'IBLOCK_ID', 'NAME', 'SORT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE'];
			$this->items = \CAllcorp3Cache::CIBlockElement_GetList(
				[
					$this->config['SKU_SORT_FIELD'] => $this->config['SKU_SORT_ORDER'],
					$this->config['SKU_SORT_FIELD2'] => $this->config['SKU_SORT_ORDER2'],
					"CACHE" => [
						"TAG" => \CAllcorp3Cache::GetIBlockCacheTag($iblockID),
						"GROUP" => 'ID',
						"MULTI" => 'N'
					]
				],
				$arFilter,
				false,
				false,
				$arSelect
			);
		}
		
		/**
		 * Get properties by loop items
		 * @return array 
		 */
		public function getItemsProps()
		{
			if ($this->items && $this->config['SKU_PROPERTY_CODE']) {
				$arProps = [];
				\CIBlockElement::GetPropertyValuesArray(
					$arProps,
					$this->linkedProp['LINK_IBLOCK_ID'],
					[
						'ID' => \array_keys($this->items)
					],
					[
						'CODE' => $this->config['SKU_PROPERTY_CODE']
					]
				);
				if ($arProps) {
					foreach ($arProps as $key => $arProp) {
						if ($this->items[$key]) {
							$this->items[$key]['DISPLAY_PROPERTIES'] = $arProp;
						}
					}
				}
			}
		}

		/**
		 * Get tree props value in item
		 * @return array 
		 */
		private function getMatrix()
		{
			if ($this->items) {
				
				$arMatrix = $arRow = [];
				$arPropsCode = array_keys($this->props);

				$arMatrixFields = array_fill_keys($arPropsCode, false);

				foreach ($this->items as $key => $arItem) {
					foreach ($arPropsCode as $codeProp) {
						$arCell = [
							'VALUE' => 0,
							'SORT' => PHP_INT_MAX,
							'NA' => true
						];
						if (isset($arItem['DISPLAY_PROPERTIES'][$codeProp])) {
							$arMatrixFields[$codeProp] = true;
							$arCell['NA'] = false;

							if ('directory' == $this->props[$codeProp]['USER_TYPE'])
							{
								$intValue = $this->props[$codeProp]['XML_MAP'][$arItem['DISPLAY_PROPERTIES'][$codeProp]['VALUE']];
								$arCell['VALUE'] = $intValue;
							}
							elseif ('L' == $this->props[$codeProp]['PROPERTY_TYPE'])
							{
								$arCell['VALUE'] = intval($arItem['DISPLAY_PROPERTIES'][$codeProp]['VALUE_ENUM_ID']);
							}
							elseif ('E' == $this->props[$codeProp]['PROPERTY_TYPE'])
							{
								$arCell['VALUE'] = intval($arItem['DISPLAY_PROPERTIES'][$codeProp]['VALUE']);
							}
							$arCell['SORT'] = $this->props[$codeProp]['VALUES'][$arCell['VALUE']]['SORT'];

						}
						$arRow[$codeProp] = $arCell;
					}
					$arMatrix[$key] = $arRow;

					\CIBlockPriceTools::clearProperties($this->items[$key]['DISPLAY_PROPERTIES'], \array_keys($this->props));
				}

				$this->matrix = [
					'ITEMS' => $arMatrix,
					'FIELDS' => $arMatrixFields
				];

				$this->setFormattedTreeProps();
			}
		}

		/**
		 * Set tree props with value by matrix
		 * @return array 
		 */
		private function setFormattedTreeProps()
		{
			$arPropSKU = $arItem['OFFERS_PROPS_JS'] = $arSortFields = [];
			
			foreach (array_keys($this->props) as $codeProp) {
				$boolExist = $this->matrix['FIELDS'][$codeProp];

				foreach ($this->matrix['ITEMS'] as $keyOffer => $arRow) {
					if ($boolExist) {
						if (!isset($this->items[$keyOffer]['TREE'])) {
							$this->items[$keyOffer]['TREE'] = [];
						}
						$this->items[$keyOffer]['TREE']['PROP_'.$this->props[$codeProp]['ID']] = $this->matrix['ITEMS'][$keyOffer][$codeProp]['VALUE'];
						$this->items[$keyOffer]['SKU_SORT_'.$codeProp] = $this->matrix['ITEMS'][$keyOffer][$codeProp]['SORT'];

						$arSortFields['SKU_SORT_'.$codeProp] = SORT_NUMERIC;

						$arPropSKU[$codeProp][$this->matrix['ITEMS'][$keyOffer][$codeProp]["VALUE"]] = $this->props[$codeProp]["VALUES"][$this->matrix['ITEMS'][$keyOffer][$codeProp]["VALUE"]];
						
					} else {
						unset($this->matrix['ITEMS'][$keyOffer][$codeProp]);
					}
				}
				if ($arPropSKU[$codeProp] && array_column($arPropSKU[$codeProp], 'ID')) {
					Collection::sortByColumn($arPropSKU[$codeProp], array("SORT" => array(SORT_NUMERIC, SORT_ASC), "NAME" => array(SORT_NUMERIC, SORT_ASC))); // sort sku prop values

					$this->treeProps[$codeProp] = array(
						"ID" => $this->props[$codeProp]["ID"],
						"CODE" => $this->props[$codeProp]["CODE"],
						"NAME" => $this->props[$codeProp]["NAME"],
						"SORT" => $this->props[$codeProp]["SORT"],
						"PROPERTY_TYPE" => $this->props[$codeProp]["PROPERTY_TYPE"],
						"USER_TYPE" => $this->props[$codeProp]["USER_TYPE"],
						"LINK_IBLOCK_ID" => $this->props[$codeProp]["LINK_IBLOCK_ID"],
						"SHOW_MODE" => $this->props[$codeProp]["SHOW_MODE"],
						"VALUES" => $arPropSKU[$codeProp]
					);
				}
			}

			$this->setActivePropsValue();
		}

		/**
		 * Set selected item ID
		 * @param number $number ID item 
		 */
		public function setSelectedItem($number)
		{
			if ((int)$number) {
				$this->selectedItem = $number;
			}
		}

		/**
		 * Set active class in props value by selected item
		 * @return array 
		 */
		private function setActivePropsValue()
		{
			$arFilter = [];
			$arCurrentOffer = current($this->items);
			if ($this->selectedItem && $this->items[$this->selectedItem]) {
				$arCurrentOffer = $this->items[$this->selectedItem];
			}
			$this->currentItem = $arCurrentOffer;
			
			foreach ($this->treeProps as $key => $arProp){
				$strName = 'PROP_'.$arProp['ID'];
				$arShowValues = $this->GetRowValues($arFilter, $strName);

				if (in_array($arCurrentOffer['TREE'][$strName], $arShowValues)) {
					$arFilter[$strName] = $arCurrentOffer['TREE'][$strName];
				} else {
					$arFilter[$strName] = $arShowValues[0];
				}

				$this->UpdateRow($arFilter[$strName], $arShowValues, $this->treeProps[$key]);

			}
			/*echo "<pre>";
			print_r($this->treeProps);
			echo "</pre>";*/
		}

		/**
		 * Get visible props value
		 * @param array $arFilter
		 * @param string $index Property code
		 */
		public static function GetCanBuy($arFilter, $arItem)
		{
			$boolSearch = false;
			$boolOneSearch = true;

			foreach ($arItem['OFFERS'] as $arOffer) {
				$boolOneSearch = true;
				foreach ($arFilter as $propName => $filter) {
					if ($filter !== $arOffer['TREE'][$propName]) {
						$boolOneSearch = false;
						break;
					}
				}

				if ($boolOneSearch) {
					$boolSearch = true;
					break;
				}
			}
			return $boolSearch;
		}

		/**
		 * Set active class in props value by selected item
		 * @param array $arFilter
		 * @param string $index Property code
		 * @return array 
		 */
		private function GetRowValues($arFilter, $index)
		{
			$arValues = [];
			$boolSearch = false;
			$boolOneSearch = true;

			if (!$arFilter) {
				if ($this->items) {
					foreach ($this->items as $arOffer) {
						if (!in_array($arOffer['TREE'][$index], $arValues)) {
							$arValues[] = $arOffer['TREE'][$index];
						}
					}
				}
				$boolSearch = true;
			} else {
				if ($this->items) {
					foreach ($this->items as $arOffer) {
						$boolOneSearch = true;
						foreach ($arFilter as $propName => $filter) {
							if ($filter !== $arOffer['TREE'][$propName]) {
								$boolOneSearch = false;
								break;
							}
						}
						if ($boolOneSearch) {
							if (!in_array($arOffer['TREE'][$index], $arValues)) {
								$arValues[] = $arOffer['TREE'][$index];
							}
							$boolSearch = true;
						}
					}
				}
			}
			return ($boolSearch ? $arValues : false);
		}

		/**
		 * Update classes in tree props value
		 * @param array $arFilter
		 * @param string $index Property code
		 * @return array 
		 */
		private function UpdateRow($arFilter, $arShowValues, &$arProp)
		{
			$isCurrent = false;
			$showI = 0;

			if ($arProp['VALUES']){
				foreach ($arProp['VALUES'] as $key => $arValue) {
					$value = $arValue['ID'];
					// $isCurrent = ($value === $arFilter && $value != 0);
					$isCurrent = ($value === $arFilter);

					/*if (in_array($value, $arCanBuyValues)) {
						$arProp['VALUES'][$key]['CLASS'] = ($isCurrent ? 'active' : '');
					} else {
						$arProp['VALUES'][$key]['CLASS'] = ($isCurrent ? 'active missing' : 'missing');
					}*/
					$arProp['VALUES'][$key]['CLASS'] = ($isCurrent ? 'active' : '');
					
					$arProp['VALUES'][$key]['STYLE'] = 'style="display: none"';

					if (in_array($value, $arShowValues)) {
						$arProp['VALUES'][$key]['STYLE'] = '';

						if ($value != 0) {
							++$showI;
						}
					}

					if ($isCurrent) {
						$arProp['VALUE'] = $arProp['VALUES'][$key]['NAME'];
					}
				}
				if (!$showI) {
					$arProp['STYLE'] = 'style="display: none"';
				} else {
					$arProp['STYLE'] = 'style=""';
				}
			}
		}

		/**
		 * Get tree props list by filter
		 * @param array $arFilter
		 * @return array 
		 */
		public function getTreePropsByFilter(array $arFilter = [])
		{
			$propertyIterator = Iblock\PropertyTable::getList([
				'select' => [
					'ID', 'IBLOCK_ID', 'CODE', 'NAME', 'SORT', 'LINK_IBLOCK_ID', 'PROPERTY_TYPE', 'USER_TYPE', 'USER_TYPE_SETTINGS'
				],
				'filter' => [
					array_merge(
						$arFilter,
						[
							'=PROPERTY_TYPE' => [
								Iblock\PropertyTable::TYPE_LIST,
								Iblock\PropertyTable::TYPE_ELEMENT,
								Iblock\PropertyTable::TYPE_STRING
							],
							'=ACTIVE' => 'Y', 
							'=MULTIPLE' => 'N'
						]
					)
				],
				'order' => [
					'SORT' => 'ASC', 'ID' => 'ASC'
				]
			]);
			while ($propInfo = $propertyIterator->fetch()) {
				//todo check Highloadblock
				switch ($propInfo['PROPERTY_TYPE']) {
					case Iblock\PropertyTable::TYPE_ELEMENT:
						$showMode = 'pict';
						break;
					case Iblock\PropertyTable::TYPE_LIST:
						$showMode = 'text';
						break;
				}
				$propInfo['SHOW_MODE'] = $showMode;
				$this->props[$propInfo['CODE']] = $propInfo;
			}
			unset($propInfo);

			if ($this->props) {
				$this->getPropsValue();
			}
		}
		
		/**
		 * Get value in props list
		 * @return array $this->props
		 */
		private function getPropsValue()
		{
			foreach ($this->props as $key => $arProp) {
				$values = [];
				$valuesExist = false;
				switch ($arProp['PROPERTY_TYPE']) {
					case Iblock\PropertyTable::TYPE_LIST:
						$iterator = Iblock\PropertyEnumerationTable::getList(array(
							'select' => array('ID', 'VALUE', 'SORT'),
							'filter' => array('=PROPERTY_ID' => $arProp['ID']),
							'order' => array('SORT' => 'ASC', 'VALUE' => 'ASC')
						));
						while ($row = $iterator->fetch())
						{
							$row['ID'] = (int)$row['ID'];
							$values[$row['ID']] = array(
								'ID' => $row['ID'],
								'NAME' => $row['VALUE'],
								'SORT' => (int)$row['SORT'],
								'PICT' => false
							);
							$valuesExist = true;
						}
						unset($row, $iterator);
						break;
				}
				if (!$valuesExist) {
					continue;
				}
				$arProp['VALUES'] = $values;
				$arProp['VALUES_COUNT'] = count($values);

				$this->props[$arProp['CODE']] = $arProp;
			}
		}
	}
}?>