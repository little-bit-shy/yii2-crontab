<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2016/11/8
 * Time: 15:42
 * @desc 树状结构
 */

namespace app\components;

class Helper
{
    /**
     * 日期转时间戳
     * @param $date
     * @return int|null
     */
    public static function date2time($date)
    {
        if (empty($date)) {
            return null;
        }
        return strtotime($date);
    }

    /**
     * 日期
     * @param $format
     * @param $time
     * @return false|string
     */
    public static function dateFormat($format, $time)
    {
        return date($format, $time);
    }

    /**
     * 生成订单号
     * @return string
     */
    public static function orderId()
    {
        return date('YmdHis') . rand(100000, 999999);
    }

    /**
     * xml转string
     * @param $data
     * @param string $class_name
     * @param int $options
     * @param string $ns
     * @param bool $is_prefix
     * @return \SimpleXMLElement
     */
    public static function xmlToString($data, $class_name = "SimpleXMLElement", $options = 0, $ns = "", $is_prefix = false)
    {
        return simplexml_load_string($data, $class_name, $options, $ns, $is_prefix);
    }

}
