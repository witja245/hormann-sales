<?php

namespace Itech;

class ManagedCache
{
    private function __construct()
    {
    }

    public static function cache(string $cacheKey, int $ttl, callable $dataFunction)
    {
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        if ($cache->initCache($ttl, $cacheKey)) {
            $result = $cache->getVars();
            return $result['data'];
        }
        $cache->startDataCache();
        $result = $dataFunction();

        $cache->endDataCache([
            'data' => $result
        ]);
        return $result;
    }
}