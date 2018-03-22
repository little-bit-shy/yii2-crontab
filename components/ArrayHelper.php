<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2016/11/8
 * Time: 15:42
 * @desc 树状结构
 */

namespace app\components;

use yii\helpers\BaseArrayHelper;
use yii\helpers\StringHelper;

class ArrayHelper extends BaseArrayHelper
{
    /**
     * 建立树状结构
     * @param $array
     * @param $key
     * @return array
     */
    public static function menu($array, $key)
    {
        $result = [];
        foreach ($array as $element) {
            $lastArray = &$result;
            $explode = StringHelper::explode($element[$key], '/');
            foreach ($explode as $k => $v) {
                if (empty($v)) {
                    $lastArray = &$lastArray['/*'];
                } else {
                    $vv = '';
                    for ($i = 1; $i <= $k; $i++) {
                        $i < $k ? $vv .= "/{$explode[$i]}" : $vv .= "/{$explode[$i]}/*";
                    }
                    if ($v === '*') continue;
                    $lastArray = &$lastArray['children'][$vv];
                }
            }
            $lastArray = $element;

            unset($lastArray);
        }

        return $result;
    }
}
