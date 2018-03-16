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
     * 建立层次结构
     */
    public static function menu($array, $key)
    {
        $result = [];
        foreach ($array as $element) {
            $lastArray = &$result;
            $explode = StringHelper::explode($element[$key], '/');
            if ($explode[1] === '*') {
                continue;
            }
            $parent = '/' . $explode[1] . '/*';
            if ($element[$key] === $parent) {
                $data = self::submenu($array, $element, $key, $parent);
                $lastArray[] = $data;
            }
            unset($lastArray);
        }
        return $result;
    }

    /**
     * 获取子菜单
     */
    public static function submenu($array, $element, $key, $parent)
    {
        $lastResult = $element;
        // 初步分配子数据
        $explode = StringHelper::explode($parent, '/');
        foreach ($array as $key => $value) {
            $implode = implode($explode, '\/');
            if (preg_match("/^{$implode}/", $value['name'])) {
                if ($parent !== $value['name']) {
                    $result = &$lastResult['children'][];
                    $result = $value;
                }
            }
            unset($result);
        }

        // 处理子菜单数据
        foreach ($lastResult['children'] as $key => $value) {
            // 判断是否有需要处理的子菜单数据
            $subExplode = StringHelper::explode($value['name'], '/');
            $end = end($subExplode);
            if ($end !== '*') {
                if (count($subExplode) !== count($explode)) {
                    unset($lastResult['children'][$key]);
                }
            } else {
//                $recursion = &$lastResult['children'][$key];
//                $recursion = &$recursion['children'][];
                self::submenu($array, $value, $key, $value['name']);
            }
        }

        return $lastResult;
    }
}
