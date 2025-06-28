<?php

namespace Asteq;

class CalculatorExport
{
    private const TITLES = [
        "ID" => 'ID',
        "Тип ворот" => 'GATE',
        "Мотив" => 'BASE',
        "Поверхность" => 'SURFACE',
        "Цена" => 'PRICE',
        "Доступность" => 'AVAILABLE',
        "Ширина" => 'WIDTH',
        "Высота" => 'HEIGHT',
    ];

    public static function export(): array
    {
        \Bitrix\Main\Loader::includeModule('highloadblock');
        
        $hl = self::getHl('CalcPrice');

        $iterator = $hl::getList([
            'select' => [
                'ID',
                'GATE' => 'UF_GATE',
                'BASE' => 'UF_BASE',
                'SURFACE' => 'UF_SURFACE',
                'AVAILABLE' => 'UF_AVAILABLE',
                'PRICE' => 'UF_PRICE',
                'WIDTH' => 'UF_WIDTH',
                'HEIGHT' => 'UF_HEIGHT'
            ]
        ])->fetchAll();

        $baseMap = self::getMap(self::getHl('CalcBase'));
        $surfaceMap = self::getMap(self::getHl('CalcSurface'));
        $gateTypeMap = self::getMap(self::getHl('CalcGateType'));

        $rows = [];
        foreach ($iterator as $item) {
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

                if ($title == 'AVAILABLE') {
                    $value = $value ? 'да': 'нет' ;
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