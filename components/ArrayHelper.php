<?php
/**
 * Created by PhpStorm.
 * User: xuguoliang
 * Date: 2016/11/8
 * Time: 15:42
 * @author xuguoliang <1044748759@qq.com>
 * @desc 数组辅助
 */

namespace app\components;

use yii\helpers\BaseArrayHelper;
use yii\helpers\StringHelper;

class ArrayHelper extends BaseArrayHelper
{
    /**
     * 重建索引
     * @param array $array
     * @param \Closure|null|string $key
     * @param array $groups
     * @return array
     */
    public static function index($array, $key, $groups = [])
    {
        $result = [];
        $groups = (array)$groups;

        foreach ($array as $element) {
            $lastArray = &$result;

            foreach ($groups as $group) {
                $value = static::getValue($element, $group);
                if (!array_key_exists($value, $lastArray)) {
                    $lastArray[$value] = [];
                }
                if (empty($value)) {
                    $lastArray = $lastArray[$value];
                }else{
                    $lastArray = &$lastArray[$value];
                }
            }

            if ($key === null) {
                if (!empty($groups)) {
                    $lastArray[] = $element;
                }
            } else {
                $value = static::getValue($element, $key);
                if ($value !== null) {
                    if (is_float($value)) {
                        $value = StringHelper::floatToString($value);
                    }
                    $lastArray[$value] = $element;
                }
            }
            unset($lastArray);
        }

        return $result;
    }
}
