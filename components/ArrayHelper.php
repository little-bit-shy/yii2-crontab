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

    /**
     * 删除数组中的空值
     * @param $array
     * @return array
     */
    public static function removeNull($array)
    {
        return array_filter($array);
    }

    /**
     * 获取交集
     * @param $array1
     * @param $array2
     * @return array
     */
    public static function intersect($array1, $array2)
    {
        return array_intersect($array1, $array2);
    }

    /**
     * 去除重复的值
     * @param $array
     * @param null $sort_flags
     * @return array
     */
    public static function unique($array, $sort_flags = null)
    {
        return array_unique($array, $sort_flags);
    }

    /**
     * array_map 封装使用
     * @param $callback
     * @param array $arr1
     * @param array|null
     * @return array
     */
    public static function mapForeach($callback, array $arr1)
    {
        return array_map($callback, $arr1);
    }

    /**
     * count 封装使用
     * @param $array
     * @return int
     */
    public static function count($array)
    {
        return count($array);
    }

    /**
     * is_array 封装使用
     * @param $var
     * @return bool
     */
    public static function isArray($var)
    {
        return is_array($var);
    }

    /**
     * 重置数组下标
     * @param $var
     * @return array
     */
    public static function referValues($var)
    {
        return array_values($var);
    }

    /**
     * 多个一维数组合并成一个（组合所有可能）一维数组
     * @param $list
     * @param $unique
     * @return array
     */
    public static function Many2One($list, $unique = false)
    {
        $res = [];
        foreach ($list as $k => $val) {
            // 保存上一个的值
            if (empty($res)) {
                foreach ($val as $k => $v) {
                    $res[$k] = [$v];
                }
            } else {
                // 临时数组保存结合的结果
                $list = [];
                foreach ($res as $k => $v) {
                    foreach ($val as $key => $value) {
                        $list[$k . '_' . $key] = self::merge($v, [$value]);
                    }
                }
                $res = $list;
            }
        }
        $res = self::referValues($res);
        if ($unique) {
            $res = self::unique($res);
        }
        return $res;
    }
}
