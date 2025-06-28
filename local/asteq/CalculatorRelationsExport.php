<?php

namespace Asteq;

class CalculatorRelationsExport
{
    private const TITLES = [
        "ID" => 'ID',
        "Тип ворот" => 'GATE',
        "Мотив" => 'BASE',
        "Поверхность" => 'SURFACE',
        "Остекление" => 'GLASS',
        "Отделка" => 'FACING',
        "Цвет" => 'COLOR',
        "Макс. Ширина" => 'MAX_WIDTH',
        "Мин. Ширина" => 'MIN_WIDTH',
        "Макс. Высота" => 'MAX_HEIGHT',
        "Мин. Высота" => 'MIN_HEIGHT',
    ];

    public static function export(): array
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');

        $hl = self::getHl('CalcRelations');

        $iterator = $hl::getList([
            'select' => [
                'ID',
                'GATE' => 'UF_GATETYPE',
                'BASE' => 'UF_BASE',
                'SURFACE' => 'UF_SURFACE',
                'GLASS' => 'UF_GLASS',
                'FACING' => 'UF_FACINGS',
                'MAX_WIDTH' => 'UF_MAX_WIDTH',
                'MIN_WIDTH' => 'UF_MIN_WIDTH',
                'MIN_HEIGHT' => 'UF_MIN_HEIGHT',
                'MAX_HEIGHT' => 'UF_MAX_HEIGHT',
                'UF_DEF_COLOR',
                'UF_REC_COLORS'
            ]
        ])->fetchAll();

        $rowsRaw = [];
        foreach ($iterator as $item) {
            $colors = [];
            $facings = $item['FACING'] ?? [];

            if (empty($item['FACING'])) {
                $colors = array_merge($item['UF_REC_COLORS'], [$item['UF_DEF_COLOR']]);
                $colors = array_unique($colors);
            }

            $rowsRaw[] = [
                'ID' => $item['ID'],
                'GATE' => $item['GATE'],
                'BASE' => $item['BASE'],
                'SURFACE' => $item['SURFACE'],
                'GLASS' => $item['GLASS'],
                'MAX_WIDTH' => $item['MAX_WIDTH'] ?? 0,
                'MIN_WIDTH' => $item['MIN_WIDTH'] ?? 0,
                'MIN_HEIGHT' => $item['MIN_HEIGHT'] ?? 0,
                'MAX_HEIGHT' => $item['MAX_HEIGHT'] ?? 0,
                'COLOR' => $colors,
                'FACING' => $facings
            ];
        }
        unset($item, $iterator);

        $baseMap = self::getMap(self::getHl('CalcBase'));
        $surfaceMap = self::getMap(self::getHl('CalcSurface'));
        $gateTypeMap = self::getMap(self::getHl('CalcGateType'));
        $glassMap = self::getMap(self::getHl('CalcGlass'));
        $colorMap = self::getMap(self::getHl('CalcColor'));
        $facingMap = self::getMap(self::getHl('CalcFacing'));

        $rows = [];
        foreach ($rowsRaw as $item) {
            $row = [];
            foreach (self::TITLES as $title) {
                $value = $item[$title];
                if ($title == 'GATE') {
                    $value = $gateTypeMap[$value];
                }
                if ($title == 'SURFACE') {
                    $value = $surfaceMap[$value];
                }
                if ($title == 'BASE') {
                    $value = $baseMap[$value];
                }
                if ($title == 'GLASS') {
                    $value = $glassMap[$value];
                }
                if ($title == 'COLOR') {
                    $tmp = [];
                    foreach ($value as $colorId) {
                        $tmp[] = $colorMap[$colorId];
                    }
                    $value = implode(';', $tmp);
                    unset($tmp);

                }
                if ($title == 'FACING') {
                    $tmp = [];
                    foreach ($value as $faceId) {
                        $tmp[] = $facingMap[$faceId];
                    }
                    $value = implode(';', $tmp);
                    unset($tmp);
                }

                $row[] = $value;
            }

            $rows[] = $row;
        }


        return [
            'columns' => array_keys(self::TITLES),
            'rows' => $rows
        ];
    }

    private static function getMap(string $hl): array
    {
        $result = [];
        $iterator = $hl::getList(['select' => ['ID', 'UF_NAME']])->fetchAll();
        foreach ($iterator as $item) {
            $result[$item['ID']] = $item['UF_NAME'];
        }

        return $result;
    }

    private static function getHl(string $code): string
    {
        $hlBlock = \Bitrix\Highloadblock\HighloadBlockTable::getList([
            'filter' => ['=NAME' => $code],
            'cache' => ['ttl' => 86400]
        ])->fetch();

        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlock);
        return $entity->getDataClass();
    }
}