<?php

use Bitrix\Main\Mail\Event,
    Bitrix\Main\Application,
    Bitrix\Main\Web\PostDecodeFilter,
    Bitrix\Highloadblock\HighloadBlockTable;

class AsteqCalculatorComponent extends CBitrixComponent
{
    protected $request;

    /**
     * @var Asteq\Calculator $calculator
     */
    protected $calculator;

    public function onPrepareComponentParams($params): array
    {
        $params = parent::onPrepareComponentParams($params);

        $this->request = Application::getInstance()->getContext()->getRequest();

        $this->request->addFilter(new PostDecodeFilter());

        return $params;
    }

    private function createOrderAction(): array
    {
        $data = [];
        $requestParams = $this->request->getPostList()->toArray();

        // удаление служебных параметров
        unset($requestParams['templates'], $requestParams['parameters'], $requestParams['showPrice'], $requestParams['action']);

        $data = $this->prepareOrderEmailInfo($requestParams);


        \Bitrix\Main\Loader::includeModule('form');
        $formName = 'CALCULATOR';

        $arFilter = [
            "SID" => $formName,
            "SID_EXACT_MATCH" => "Y"
        ];

        $is_filtered = false;
        $arForm = \CForm::GetList($by = "s_id", $order = "desc", $arFilter, $is_filtered)->fetch();
        if (!$arForm) {
            return [
                'status' => false,
                'msg' => 'Ошибка'
            ];
        }

        $formId = $arForm["ID"];
        $questions = [];

        $rawResult = [];
        \CForm::GetResultAnswerArray($formId, $rawResult, $tmp, $tmp1);

        foreach ($rawResult as $question) {
            $questions[$question["SID"]] = [
                "code" => $question["SID"],
                "id" => $question["ID"],
                "required" => $question["REQUIRED"] == "Y",
                "type" => $question["FIELD_TYPE"] ?: "text",
                "title" => $question["TITLE"]
            ];
        }

        $preparedData = [];
        foreach ($questions as $code => $question) {
            $userData = $data[$code];

            $preparedData["form_" . $question["type"] . "_" . $question["id"]] = $userData;
        }

        if ($resultId = \CFormResult::Add($formId, $preparedData)) {
            \CFormResult::SetEvent($resultId);
            \CFormResult::Mail($resultId);

            return [
                'status' => true,
                'msg' => $arForm['DESCRIPTION'] ?: 'Ваша заявка отправлена'
            ];
        }

        global $strError;

        return [
            'status' => false,
            'msg' => $strError
        ];
    }

    private function prepareOrderEmailInfo(array $data): array
    {
        return [
            'NAME' => $data['name'],
            'LASTNAME' => $data['lastName'],
            'COMMENT' => $data['comment'],
            'PHONE' => $data['phone'],
            'EMAIL' => $data['email'],
            'CITY' => $data['city'],
            'WIDTH' => $data['width'],
            'HEIGHT' => $data['height'],
            'DRIVE' => $data['drive'] ? $this->calculator->hlDrive::getById($data['drive'])->fetch()['UF_NAME'] : '',
            'FACING' => $data['facings'] ? $this->calculator->hlFacing::getById($data['facings'])->fetch()['UF_NAME'] : '',
            'BASE' => $data['base'] ? $this->calculator->hlBase::getById($data['base'])->fetch()['UF_NAME'] : '',
            'GATETYPE' => $data['gateType'] ? $this->calculator->hlGateType::getById($data['gateType'])->fetch()['UF_NAME'] : '',
            'SURFACE' => $data['surface'] ? $this->calculator->hlSurface::getById($data['surface'])->fetch()['UF_NAME'] : '',
            'GLASS' => $data['glass'] ? $this->calculator->hlGlass::getById($data['glass'])->fetch()['UF_NAME'] : '',
            'COLOR' => $data['color'] ? $this->calculator->hlColor::getById($data['color'])->fetch()['UF_NAME'] : '',
        ];
    }

    /* private function getDrivesAction(): array
    {
        $width = $this->request->get('width');
        $height = $this->request->get('height');

        return [
            'drives' => $this->calculator->getDrives((float)$width, (float)$height)
        ];
    } */

    private function recalculateActionOld(): array
    {
        $color = $this->request->get('color');
        $gateType = $this->request->get('gateType');
        $calculatePrice = $this->request->get('showPrice');
        $surfaceId = $this->request->get('surface');
        $baseId = $this->request->get('base');
        $drive = $this->request->get('drive');

        $allParams = $this->calculator->getParams(['UF_GATETYPE' => $gateType]);

        $filter = [
            'surface' => $surfaceId,
            'base' => $baseId,
            'facings' => $this->request->get('face'),
            'def_colors' => $color,
            'rec_colors' => $color,
            'glass' => $this->request->get('glass'),
        ];

        foreach ($filter as $key => $fVal) {
            if (!is_array($allParams[$key]) || !$fVal) {
                continue;
            }

            $tmpFilter = [];
            $tmpFilter['UF_GATETYPE'] = $gateType;
            $tmpFilter['UF_' . strtoupper($key)] = $fVal;

            $needKeys = [];

            foreach ($filter as $copyKey => $copyValue) {
                if ($copyKey == $key) {
                    continue;
                }
                $needKeys[] = $copyKey;
            }

            foreach ($needKeys as $needKey) {
                foreach ($allParams[$needKey] as &$param) {
                    $tmpFilter['UF_' . strtoupper($needKey)] = $param['id'];
                    $param['available'] = $this->calculator->getAvailable($tmpFilter);
                }

                unset($tmpFilter['UF_' . strtoupper($needKey)]);
            }
        }

        $width = $this->request->get('width');
        $height = $this->request->get('height');
        if ($width && $height) {
            foreach ($allParams['drive'] as &$drive) {
                $drive['available'] = $this->calculator->getAvailableDrive($drive['id'], $width, $height);
            }
        }
        if ($calculatePrice) {
            $allParams['total'] = $this->calculator->getPrice($gateType, $surfaceId, $baseId, $width, $height);

            // если выбран привод, то прибавляем его стоимость к итоговой
            if ($drive) {
                $selectedDrive = null;
                foreach ($allParams['drive'] as $d) {
                    if ($d['id'] == $drive) {
                        $selectedDrive = $d;
                        break;
                    }
                }

                if ($selectedDrive) {
                    $allParams['total']['price'] += $selectedDrive['price'];
                    $allParams['total']['formattedPrice'] = $this->calculator->formatPrice($allParams['total']['price']);
                }
            }
        }

        return $allParams;
    }

    private function recalculateAction(): array
    {
        $color = $this->request->get('color');
        $gateType = $this->request->get('gateType');
        $calculatePrice = $this->request->get('showPrice');
        $surfaceId = $this->request->get('surface');
        $baseId = $this->request->get('base');
        $drive = $this->request->get('drive');

        $allParams = $this->calculator->getParams(['UF_GATETYPE' => $gateType]);

        $filter = [
            'base' => $baseId,
            'surface' => $surfaceId,
            'facings' => $this->request->get('face'),
            'glass' => $this->request->get('glass'),
            'rec_colors' => $color,
        ];

        foreach ($filter as $key => $fVal) {
            if (!is_array($allParams[$key]) || !$fVal) {
                continue;
            }

            $tmpFilter = [];
            $tmpFilter['UF_GATETYPE'] = $gateType;
            $tmpFilter['UF_' . strtoupper($key)] = $fVal;

            $needKeys = [];

            foreach ($filter as $copyKey => $copyValue) {
                //if (!is_array($allParams[$copyKey]) || !$copyValue) continue;
                if ($copyKey == $key) {
                    continue;
                }

                $needKeys[] = $copyKey;
            }

            foreach ($needKeys as $needKey) {
                foreach ($allParams[$needKey] as &$param) {
                    $tmpFilter['UF_' . strtoupper($needKey)] = $param['id'];
                    $param['available'] = $this->calculator->getAvailable($tmpFilter);
                }

                unset($tmpFilter['UF_' . strtoupper($needKey)]);
            }
        }

        $width = $this->request->get('width');
        $height = $this->request->get('height');

        if ($width && $height) {
            foreach ($allParams['drive'] as &$dr) {
                $dr['available'] = $this->calculator->getAvailableDrive($dr['id'], $width, $height);
            }
        }
        //unset($drive);

        if (($allParams['maxHeight'] !== 0 && $allParams['maxHeight'] < $height) || ($allParams['maxWidth'] !== 0 && $allParams['maxWidth'] < $height)) {
            $allParams['drive'] = [];
        }

        if ($calculatePrice) {
            $allParams['total'] = $this->calculator->getPrice($gateType, $surfaceId, $baseId, $width, $height);

            // если выбран привод, то прибавляем его стоимость к итоговой
            if ($drive) {
                $selectedDrive = null;
                foreach ($allParams['drive'] as $d) {
                    if ($d['id'] == $drive) {
                        $selectedDrive = $d;
                        break;
                    }
                }

                if ($selectedDrive) {
                    $allParams['total']['price'] += $selectedDrive['price'];
                    $allParams['total']['formattedPrice'] = $this->calculator->formatPrice($allParams['total']['price']);
                }
            }
        }

        $photoFilter = $filter;
        $photoFilter['color'] = $photoFilter['rec_colors'];
        $photoFilter['gatetype'] = $gateType;
        unset($photoFilter['rec_colors']/*, $photoFilter['glass']*/);

        $allParams['photo'] = $this->calculator->getPhoto($photoFilter);
        $allParams['sizes'] = $this->calculator->getAvailableSizes($gateType);

        $filter = [
            'base' => $baseId,
            'surface' => $surfaceId,
            'facings' => $this->request->get('face'),
            'glass' => $this->request->get('glass'),
            'rec_colors' => $color,
        ];

        if ($filter['base'] && $filter['surface'] ) {
            $relsIterator = $this->calculator->hlRelations::getList([
                'filter' => [
                    'UF_BASE' => $filter['base'],
                    'UF_SURFACE' => $filter['surface'],
                    'UF_GATETYPE' => $gateType
                ]
            ]);

            $colors = [];
            while ($rel = $relsIterator->fetch()) {
                if ($rel['UF_REC_COLORS']) {
                    foreach ($rel['UF_REC_COLORS'] as $colorId) {
                        $colors[] = $colorId;
                    }
                }
            }
            unset($relsIterator, $rel);

            if (!empty($colors)) {
                foreach ($allParams['rec_colors'] as &$col) {
                    if (!in_array($col['id'], $colors)) {
                        $col['available'] = false;
                    }
                }
            }

        }

        if ($filter['base'] && $filter['surface'] && $filter['rec_colors']) {
            $relsIterator = $this->calculator->hlRelations::getList([
                'filter' => [
                    'UF_BASE' => $filter['base'],
                    'UF_SURFACE' => $filter['surface'],
                    'UF_REC_COLORS' => $filter['rec_colors']
                ]
            ]);

            $facingsIds = [];
            while ($rel = $relsIterator->fetch()) {
                if ($rel['UF_FACINGS']) {
                    foreach ($rel['UF_FACINGS'] as $faceId) {
                        $facingsIds[] = $faceId;
                    }
                }
            }
            unset($relsIterator, $rel);

            if (!empty($facingsIds)) {
                foreach ($allParams['facings'] as &$facing) {
                    if (!in_array($facing['id'], $facingsIds)) {
                        $facing['available'] = false;
                    }
                }
            } else {
                foreach ($allParams['facings'] as &$facing) {
                    $facing['available'] = false;
                }

                $photoFilter = $filter;

                $photoFilter['color'] = $photoFilter['rec_colors'];
                $photoFilter['gatetype'] = $gateType;
                unset($photoFilter['rec_colors'], $photoFilter['facings']);

                $allParams['photo'] = $this->calculator->getPhoto($photoFilter);
                $allParams['sizes'] = $this->calculator->getAvailableSizes($gateType);
            }

            if ($filter['facings']) {
                $relsIterator = $this->calculator->hlRelations::getList([
                    'filter' => [
                        'UF_BASE' => $filter['base'],
                        'UF_SURFACE' => $filter['surface'],
                        'UF_REC_COLORS' => $filter['rec_colors'],
                        'UF_FACINGS' => $filter['facings']
                    ]
                ]);

                $glassIds = [];
                while ($rel = $relsIterator->fetch()) {
                    if ($rel['UF_GLASS']) {
                        $glassIds[] = $rel['UF_GLASS'];
                    }
                }

                if (!empty($glassIds)) {
                    foreach ($allParams['glass'] as &$glass) {
                        if (!in_array($glass['id'], $glassIds)) {
                            $glass['available'] = false;
                        }
                    }
                } else {
                    foreach ($allParams['glass'] as &$glass) {
                        $glass['available'] = false;
                    }

                    if (!$allParams['photo']) {
                        $photoFilter = $filter;

                        $photoFilter['color'] = $photoFilter['rec_colors'];
                        $photoFilter['gatetype'] = $gateType;
                        unset($photoFilter['rec_colors'], $photoFilter['glass']);

                        $allParams['photo'] = $this->calculator->getPhoto($photoFilter);
                        $allParams['sizes'] = $this->calculator->getAvailableSizes($gateType);
                    }
                }
            } else {
                    $relsIterator = $this->calculator->hlRelations::getList([
                        'filter' => [
                            'UF_BASE' => $filter['base'],
                            'UF_SURFACE' => $filter['surface'],
                            'UF_REC_COLORS' => $filter['rec_colors'],
                            //'UF_FACINGS' => $filter['facings']
                        ]
                    ]);

                    $glassIds = [];
                    while ($rel = $relsIterator->fetch()) {
                        if ($rel['UF_GLASS']) {
                            $glassIds[] = $rel['UF_GLASS'];
                        }
                    }

                    if (!empty($glassIds)) {
                        foreach ($allParams['glass'] as &$glass) {
                            if (!in_array($glass['id'], $glassIds)) {
                                $glass['available'] = false;
                            }
                        }
                    } else {
                        foreach ($allParams['glass'] as &$glass) {
                            $glass['available'] = false;
                        }

                        if (!$allParams['photo']) {
                            $photoFilter = $filter;

                            $photoFilter['color'] = $photoFilter['rec_colors'];
                            $photoFilter['gatetype'] = $gateType;
                            unset($photoFilter['rec_colors'], $photoFilter['glass']);

                            $allParams['photo'] = $this->calculator->getPhoto($photoFilter);
                            $allParams['sizes'] = $this->calculator->getAvailableSizes($gateType);
                        }
                    }

            }
        }

        return $allParams;
    }

    private function initAction(): array
    {
        $gateType = $this->request->get('gateType');

        $allParams = $this->calculator->getParams(['UF_GATETYPE' => $gateType]);
        foreach ($allParams as $paramName => &$paramArray) {
            foreach ($paramArray as &$param) {
                $param['available'] = true;
            }
        }
        $allParams['sizes'] = $this->calculator->getAvailableSizes($gateType);
        $allParams['photo'] = $this->calculator->getPhoto(['gatetype' => $gateType]);
        return $allParams;
    }

    function executeComponent()
    {
        global $APPLICATION;

        $this->calculator = \Asteq\Calculator::getInstance();

        $action = $this->request->get('action');
        if (!empty($action)) {
            $APPLICATION->restartBuffer();

            $data = [
                'msg' => 'Неизвестный запрос'
            ];

            $methodName = $action . 'Action';
            if (method_exists($this, $methodName)) {
                $data = $this->$methodName();
            }

            echo \Bitrix\Main\Web\Json::encode($data);
            die();
        }

        $gateType = $this->request->get('type') ?? $this->arParams['GATE_TYPE'];
        $gateTypes = $this->calculator->getGateTypes();

        $city = \Itech\Geo::getCity();
        $this->arResult['city'] = $city['NAME'];
        $this->arResult['type'] = $gateType;
        $this->arResult['gates'] = $gateTypes;
        $this->arResult['descriptions'] = $this->calculator->getParamsDescriptions();

        $this->includeComponentTemplate();
    }
}