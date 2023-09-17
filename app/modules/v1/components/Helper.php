<?php

namespace app\modules\v1\components;

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class Helper
{
    /**
     * Convert multiselect get param to array
     * 
     * @param array|string|int|null $param
     * @return array|string|int|null
     */
    public static function parseMultiSelect(array|string|int|null $param): array|string|int|null
    {
        if (is_array($param) || is_int($param) || $param === null) {
            return $param;
        }

        if (is_string($param)) {
            $res = StringHelper::explode($param);
            switch (count($res)) {
                case 0:
                    return null;
                case 1:
                    return $res[0];
                default:
                    return $res;
            }
        }

        return null;
    }
}