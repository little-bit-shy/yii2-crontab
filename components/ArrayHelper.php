<?php
/**
 * Created by PhpStorm.
 * User: xuguoliang
 * Date: 2016/11/8
 * Time: 15:42
 * @author xuguoliang <1044748759@qq.com>
 * @desc 树状结构
 */

namespace app\components;

use yii\helpers\StringHelper;

class ArrayHelper
{
    /**
     * 建立树状结构
     */
    public static function menu($array, $key)
    {
        $result = [];
        foreach ($array as $element) {
            $lastArray = &$result;
            $explode = StringHelper::explode($element[$key], '/');
            $kk = '';
            foreach ($explode as $k) {
                if (!empty($k)) {
                    $kk .= "/$k";
                    $lastArray = &$lastArray[$kk];
                }
            }
            $lastArray = $element;
            unset($lastArray);
        }
        return $result;
    }
}
