<?php

namespace Asteq;

use Bitrix\Main\ORM\Query;
use Bitrix\Main\Entity;

class Calculator
{
    private static $instance;
    private const CACHE_TIME = 3600;

    public $hlDrive;
    public $hlRelations;
    public $hlBase;
    public $hlColor;
    public $hlFacing;
    public $hlGateType;
    public $hlGlass;
    public $hlSurface;
    public $hlPrice;
    public $hlPhotos;
    public $hlDescriptions;

    /**
     * Инициализируются свойства $hl{Name},
     * которые являются классами для работы с HL-блоками
     * Calculator constructor.
     */
    private function __construct()
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');

        foreach ($this->getHlEntities() as $entityClass) {
            $property = str_replace(['\Calc', 'Table'], '', $entityClass);
            $classProperty = "hl$property";
            if (property_exists(self::class, $classProperty)) {
                $this->$classProperty = $entityClass;
            }
        }
    }

    public function __wakeup()
    {
    }

    public function __clone()
    {
    }

    public static function getInstance(): Calculator
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getGateTypes(): ?array
    {
        $typesDb = $this->hlGateType::getList([
            'select' => [
                'ID',
                'UF_NAME',
                'FILE_ID' => 'FILE.ID',
                'SRC',
                'SRC_M'
            ],
            'filter' => [
                'UF_SHOW_CALC' => true
            ],
            'cache' => ['ttl' => 3600, 'cache_joins' => true],
            'runtime' => [
                new Entity\ReferenceField(
                    'FILE',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_IMG', 'ref.ID')->where("this.UF_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE.SUBDIR', 'FILE.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'FILE_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_M_IMG', 'ref.ID')->where("this.UF_M_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE_M.SUBDIR', 'FILE_M.FILE_NAME']
                )
            ]
        ]);

        return $typesDb ? $typesDb->fetchAll() : null;
    }

    public function getSurfaces(): ?array
    {
        return $this->hlSurface::getList(['cache' => ['ttl' => self::CACHE_TIME]]);
    }

    public function getBases(): ?array
    {
        return $this->hlBase::getList(['cache' => ['ttl' => self::CACHE_TIME]]);
    }

    public function getAvailable(array $filter): bool
    {
        $data = $this->hlRelations::getList([
            'filter' => $filter,
            'select' => [
                'ID'
            ],
            'cache' => [
                'ttl' => self::CACHE_TIME
            ],
            'limit' => 1
        ])->fetch();

        return $data['ID'] > 0;
    }

    public function getParams(array $filter): ?array
    {
        $colors = [];
        $defColors = [];
        $recColors = [];
        $bases = [];
        $glasses = [];
        $surfaces = [];
        $facings = [];

        $data = $this->hlRelations::getList([
            'filter' => $filter,
            'select' => [
                'ID',
                'UF_MAX_WIDTH',
                'UF_MIN_WIDTH',
                'UF_MAX_HEIGHT',
                'UF_MIN_HEIGHT',
                'UF_STEP_HEIGHT',
                'UF_STEP_WIDTH',
                'UF_DEF_COLOR',
                'UF_REC_COLORS',
                'UF_AV_COLORS',
                'UF_CHOOSE_COLOR',
                'UF_FACINGS',

                'BASE_NAME' => 'BASE.UF_NAME',
                'BASE_ID' => 'BASE.ID',
                'BASE_I' => 'BASE.UF_IMG',
                'BASE_I_M' => 'BASE.UF_M_IMG',
                'BASE_IMG_SRC',
                'BASE_IMG_SRC_M',

                'SURFACE_NAME' => 'SURFACE.UF_NAME',
                'SURFACE_DESC' => 'SURFACE.UF_DESC',
                'SURFACE_ID' => 'SURFACE.ID',
                'SURFACE_I' => 'SURFACE.UF_IMG',
                'SURFACE_I_M' => 'SURFACE.UF_M_IMG',
                'SURFACE_IMG_SRC',
                'SURFACE_IMG_SRC_M',

                'GLASS_NAME' => 'GLASS.UF_NAME',
                'GLASS_I' => 'GLASS.UF_IMG',
                'GLASS_I_M' => 'GLASS.UF_M_IMG',
                'GLASS_ID' => 'GLASS.ID',
                'GLASS_IMG_SRC',
                'GLASS_IMG_SRC_M'
            ],
            'runtime' => [
                new Entity\ReferenceField(
                    'BASE',
                    $this->hlBase,
                    Query\Join::on('this.UF_BASE', 'ref.ID')->whereNotNull('ref.UF_NAME')
                ),
                new Entity\ReferenceField(
                    'GLASS',
                    $this->hlGlass,
                    Query\Join::on('this.UF_GLASS', 'ref.ID')->whereNotNull('ref.UF_NAME')
                ),
                new Entity\ReferenceField(
                    'SURFACE',
                    $this->hlSurface,
                    Query\Join::on('this.UF_SURFACE', 'ref.ID')->whereNotNull('ref.UF_NAME')
                ),
                new Entity\ReferenceField(
                    'GLASS_IMG',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.GLASS_I', 'ref.ID')
                ),
                new Entity\ExpressionField(
                    'GLASS_IMG_SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['GLASS_IMG.SUBDIR', 'GLASS_IMG.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'GLASS_IMG_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.GLASS_I_M', 'ref.ID')
                ),
                new Entity\ExpressionField('GLASS_IMG_SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['GLASS_IMG_M.SUBDIR', 'GLASS_IMG_M.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'SURFACE_IMG',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.SURFACE_I', 'ref.ID')
                ),
                new Entity\ExpressionField(
                    'SURFACE_IMG_SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['SURFACE_IMG.SUBDIR', 'SURFACE_IMG.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'SURFACE_IMG_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.SURFACE_I_M', 'ref.ID')
                ),
                new Entity\ExpressionField('SURFACE_IMG_SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['SURFACE_IMG_M.SUBDIR', 'SURFACE_IMG_M.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'BASE_IMG',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.BASE_I', 'ref.ID')
                ),
                new Entity\ExpressionField(
                    'BASE_IMG_SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['BASE_IMG.SUBDIR', 'BASE_IMG.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'BASE_IMG_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.BASE_I_M', 'ref.ID')
                ),
                new Entity\ExpressionField('BASE_IMG_SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['BASE_IMG_M.SUBDIR', 'BASE_IMG_M.FILE_NAME']
                ),
            ],
            'cache' => [
                'ttl' => self::CACHE_TIME,
                'cache_joins' => true
            ]
        ])->fetchAll();

        $maxWidth = 0;
        $maxHeight = 0;

        $minWidth = 0;
        $minHeight = 0;


        foreach ($data as $d) {
            if ($d['UF_MAX_WIDTH'] > $maxWidth) {
                $maxWidth = (int)$d['UF_MAX_WIDTH'];
            }

            if ($d['UF_MAX_HEIGHT'] < $maxHeight || $maxHeight == 0) {
                $maxHeight = (int)$d['UF_MAX_HEIGHT'];
            }

            if (((int)$d['UF_MIN_WIDTH'] < $minWidth) || $minWidth === 0) {
                $minWidth = (int)$d['UF_MIN_WIDTH'];
            }

            if (((int)$d['UF_MIN_HEIGHT'] < $minHeight) || $minHeight === 0) {
                $minHeight = (int)$d['UF_MIN_HEIGHT'];
            }

            $surfaces[$d['SURFACE_ID']] = [
                'id' => $d['SURFACE_ID'],
                'name' => $d['SURFACE_NAME'],
                'description' => $d['SURFACE_DESC'],
                'img' => $d['SURFACE_IMG_SRC'],
                'img_mob' => $d['SURFACE_IMG_SRC_M']
            ];

            $bases[$d['BASE_ID']] = [
                'id' => $d['BASE_ID'],
                'name' => $d['BASE_NAME'],
                'img' => $d['BASE_IMG_SRC'],
                'img_mob' => $d['BASE_IMG_SRC_M']
            ];

            $glasses[$d['GLASS_ID']] = [
                'id' => $d['GLASS_ID'],
                'name' => $d['GLASS_NAME'],
                'img' => $d['GLASS_IMG_SRC'],
                'img_mob' => $d['GLASS_IMG_SRC_M']
            ];

            foreach ($d['UF_FACINGS'] as $face) {
                $facings[] = $face;
            }

            /*if (!empty($d['UF_AV_COLORS'])) {
                foreach ($d['UF_AV_COLORS'] as $color) {
                    $colors[] = $color;
                }
                //continue;
            }*/

            foreach ($d['UF_REC_COLORS'] as $color2) {
                $recColors[] = $color2;
            }

            //$defColors[] = $d['UF_DEF_COLOR'];
        }

        $recColors = array_unique($recColors);

        $facings = $this->getFacings($facings);

        return [
            //'def_color' => $this->getColors($defColors),
            'rec_colors' => $this->getColors($recColors),
            'av_colors' => $this->getColors($colors),
            'surface' => array_values($surfaces),
            'base' => array_values($bases),
            'glass' => array_values($glasses),
            'facings' => $facings,
            'maxWidth' => $maxWidth,
            'maxHeight' => $maxHeight,
            'minWidth' => $minWidth === 0 ? 1 : $minWidth,
            'minHeight' => $minHeight === 0 ? 1 : $minHeight,
            'drive' => $this->getDrives(0, 0)
        ];
    }

    public function getDrives(float $width, float $height): array
    {
        $result = [];

        //  переводим мм в кв.м
        $square = ($width * $height) / pow(10, 6);

        $rs = $this->hlDrive::getList([
            'filter' => [
                '>=UF_SQUARE' => $square,
                '>=UF_WIDTH' => $width,
            ],
            'select' => [
                'ID',
                'UF_NAME',
                'UF_PRICE',
                'UF_SQUARE',
                'UF_DESC',
                'UF_WIDTH',
                'FILE_ID' => 'FILE.ID',
                'SRC',
                'SRC_M'
            ],
            'runtime' => [
                new Entity\ReferenceField(
                    'FILE',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_IMG', 'ref.ID')->where("this.UF_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE.SUBDIR', 'FILE.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'FILE_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_M_IMG', 'ref.ID')->where("this.UF_M_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE_M.SUBDIR', 'FILE_M.FILE_NAME']
                )
            ],
            'cache' => ['ttl' => self::CACHE_TIME, 'cache_joins' => true]
        ]);

        while ($el = $rs->fetch()) {
            $price = $el['UF_PRICE'];
            $price = 0; // убрать
            $result[] = [
                'id' => $el['ID'],
                'name' => $el['UF_NAME'],
                'img' => $el['SRC'],
                'img_mob' => $el['SRC_M'],
                'price' => $price,
                'formattedPrice' => $price ? $this->formatPrice($price) : 0,
                'maxWidth' => $el['UF_SQUARE'],
                'description' => $el['UF_DESC']
            ];
        }

        return $result;
    }

    public function getAvailableDrive(int $driveId, float $width, float $height)
    {
        //  переводим мм в кв.м
        $square = ($width * $height) / pow(10, 6);

        $rs = $this->hlDrive::getList([
            'filter' => [
                'ID' => $driveId,
                '>=UF_SQUARE' => $square,
                '>=UF_WIDTH' => $width,
            ],
            'select' => [
                'ID', 'UF_XML_ID'
            ],
            'limit' => 1,
            'cache' => ['ttl' => self::CACHE_TIME, 'cache_joins' => true]
        ])->fetch();

        return $rs['ID'] > 0;
    }

    /**
     * Получение цены и наличия на складе по входным данным
     * @param int $gateTypeId
     * @param int $surfaceId
     * @param int $baseId
     * @param float $width
     * @param float $height
     * @return array
     */
    public function getPrice(int $gateTypeId, int $surfaceId, int $baseId, float $width, float $height): array
    {
        $priceDb = $this->hlPrice::getList([
            'filter' => [
                'UF_GATE' => $gateTypeId,
                'UF_BASE' => $baseId,
                'UF_SURFACE' => $surfaceId,
//                '>=UF_WIDTH' => $width,
//                '>=UF_HEIGHT' => $height
            ],
            'cache' => ['ttl' => self::CACHE_TIME],
            'limit' => 1
        ])->fetch();

        $price = $priceDb['UF_PRICE'];
        if (!$price) {
            $price = 0;
        }

        $price = 0; // убрать когда нужно будет вернуть цены

        return [
            'price' => $price,
            'stock' => $priceDb['UF_AVAILABLE'],
            'formattedPrice' => $this->formatPrice($price)
        ];
    }

    /**
     * Получаем информацию по цветам по массиву ID
     * @param array $colorsIDs
     * @return array
     */
    public function getColors(array $colorsIDs): array
    {
        if (!count($colorsIDs)) {
            return [];
        }

        $colors = [];
        $colorsDb = $this->hlColor::getList([
            'filter' => ['ID' => $colorsIDs],
            'select' => [
                'ID',
                'UF_NAME',
                'CODE' => 'UF_COLOR_CODE',
                'FILE_ID' => 'FILE.ID',
                'SRC',
                'SRC_M'
            ],
            'cache' => ['ttl' => self::CACHE_TIME, 'cache_joins' => true],
            'runtime' => [
                new Entity\ReferenceField(
                    'FILE',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_IMG', 'ref.ID')->where("this.UF_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE.SUBDIR', 'FILE.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'FILE_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_M_IMG', 'ref.ID')->where("this.UF_M_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE_M.SUBDIR', 'FILE_M.FILE_NAME']
                )
            ]
        ])->fetchAll();

        foreach ($colorsDb as $color) {
            $colors[] = [
                'id' => $color['ID'],
                'name' => $color['UF_NAME'],
                'img' => $color['SRC'],
                'img_mob' => $color['SRC_M'],
                'code' => $color['CODE'],
            ];
        }

        return $colors;
    }

    public function getFacings(array $facingsIDs): array
    {
        if (!count($facingsIDs)) {
            return [];
        }

        $facings = [];
        $facingsDb = $this->hlFacing::getList([
            'filter' => ['ID' => $facingsIDs],
            'select' => [
                'ID',
                'UF_NAME',
                'FILE_ID' => 'FILE.ID',
                'SRC',
                'SRC_M'
            ],
            'cache' => ['ttl' => self::CACHE_TIME, 'cache_joins' => true],
            'runtime' => [
                new Entity\ReferenceField(
                    'FILE',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_IMG', 'ref.ID')->where("this.UF_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE.SUBDIR', 'FILE.FILE_NAME']
                ),
                new Entity\ReferenceField(
                    'FILE_M',
                    '\Bitrix\Main\FileTable',
                    Query\Join::on('this.UF_M_IMG', 'ref.ID')->where("this.UF_M_IMG", ">", 0)
                ),
                new Entity\ExpressionField('SRC_M',
                    'CONCAT("/upload/", %s, "/", %s)', ['FILE_M.SUBDIR', 'FILE_M.FILE_NAME']
                )
            ]
        ])->fetchAll();

        foreach ($facingsDb as $face) {
            $facings[] = [
                'id' => $face['ID'],
                'name' => $face['UF_NAME'],
                'img' => $face['SRC'],
                'img_mob' => $face['SRC_M']
            ];
        }

        return $facings;
    }

    public function formatPrice(float $price): string
    {
        return number_format($price, 0, '.', ' ') . ' ₽';
    }

    /**
     * Получение всех HL-блоков, относяшихся к калькулятору
     * @return iterable строка в формате \Calc{NAME}Table
     */
    private function getHlEntities(): iterable
    {
        $hlBlocks = \Bitrix\Highloadblock\HighloadBlockTable::getList([
            'filter' => ['%NAME' => 'Calc'],
            'cache' => ['ttl' => self::CACHE_TIME]
        ]);

        while ($hlBlock = $hlBlocks->fetch()) {
            $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlock);
            if ($entity) {
                yield $entity->getDataClass();
            }
        }
    }


    /**
     * Получение описания параметров калькулятора
     *
     * @return array
     */
    public function getParamsDescriptions(): array
    {
        $descriptions = $this->hlDescriptions::getList([
            'cache' => ['ttl' => 84600],
            'select' => ['UF_CODE', 'UF_DESCRIPTION']
        ]);

        $result = [];
        while ($d = $descriptions->fetch()) {
            $result[$d['UF_CODE']] = trim($d['UF_DESCRIPTION']);
        }

        return $result;
    }

    public function getPhoto(array $filter): ?string
    {
        $preparedFilter = [];
        foreach ($filter as $k => $v) {
            $key = 'UF_' . strtoupper($k);
            if (!$v) {
                $preparedFilter[$key] = false;
            } else {
                $preparedFilter[$key] = $v;
            }
        }

        $photo = $this->hlPhotos::getList([
            'filter' => $preparedFilter,
            'select' => ['UF_IMG']
        ])->fetch();

        if (!$photo['UF_IMG']) {
            return null;
        }

        return \CFile::getPath($photo['UF_IMG']);
    }

    public function getAvailableSizes(int $gateTypeId): array
    {
        $sizes = $this->hlPrice::getList([
            'filter' => ['UF_GATE' => $gateTypeId],
            'select' => ['UF_WIDTH', 'UF_HEIGHT', 'ID'],
            'cache' => [
                'ttl' => 3600
            ]
        ])->fetchAll();

        $result = [];
        foreach ($sizes as $size) {
            $result[] = implode(' x ', [$size['UF_WIDTH'], $size['UF_HEIGHT']]);
        }

        return array_values(array_unique($result));
    }

}