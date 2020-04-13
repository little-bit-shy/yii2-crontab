<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2016/11/8
 * Time: 15:42
 * @desc 树状结构
 */

namespace app\components;

class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * 确认文件是否存在
     * @param $file
     * @return bool
     */
    public static function fileExists($file)
    {
        return file_exists($file);
    }
}
