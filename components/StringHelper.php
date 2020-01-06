<?php
/**
 * Created by PhpStorm.
 * User: hjy
 * Date: 2019/10/25
 * Time: 17:19
 */

namespace app\components;


Class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * implode 封装使用
     * @param string $glue
     * @param array $pieces
     * @return string
     */
    public static function implode($glue = "", array $pieces)
    {
        return implode($glue, $pieces);
    }

    /**
     * 字符串替换
     * @param $search
     * @param $replace
     * @param $subject
     * @param null $count
     * @return mixed
     */
    public static function replace($search, $replace, $subject, &$count = null)
    {
        return str_replace($search, $replace, $subject, $count);
    }

    /**
     * 随机数
     * @param $min
     * @param $max
     * @return int
     */
    public static function rand($min,$max)
    {
        return rand($min,$max);
    }

    /**
     * strpos 封装使用
     * @param $haystack
     * @param $needle
     * @param int $offset
     * @return bool|int
     */
    public static function strpos($haystack ,$needle ,$offset = 0){
        return strpos($haystack, $needle, $offset);
    }

}
