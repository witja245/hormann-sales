<?php


namespace Itech;


/**
 * Class References
 * Класс для работы со справочниками, реализованными на highloadbblock
 */
class References
{

    /**
     * @var int идентификатор highload-блока
     */
    private $id;
    /**
     * @var string имя класса для highload-блока
     */
    private $hl;

    /**
     * Получаем объект для работы с highload-блоком по id
     * @param int $id - ID highload-блока
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function __construct(int $id)
    {
        if (\CModule::IncludeModule('highloadblock')) {
            $this->id = $id;
            $arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById($id)->fetch();
            $obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
            $this->hl = $obEntity->getDataClass();
        } else {
            exit('Модуль "highloadblock" не установлен!');
        }
    }

    /**
     * Получение списка значений из highload-блока
     * @param array $params - параметры для выборки (необязательный)
     * @param int $limit - количество записей для выборки
     * @return array результирующий массив значений из highload-блока
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function get_list(array $params = [], int $limit = 50): array
    {
        if (!\CModule::IncludeModule('highloadblock')) {
            exit('Модуль "highloadblock" не установлен!');
        }
        $result = array();
        $par = array(
            'select' => array('ID', 'UF_NAME'),
            'order' => array('ID' => 'ASC'),
            'limit' => $limit,
        );
        if (!empty($params)) {
             $par = array_merge($par, $params);
        }
        $rsData = $this->hl::getList($par);
        while ($arItem = $rsData->Fetch()) {
            $result[] = $arItem;
        }

        return $result;
    }
}