<?php

namespace app\components;

use Yii;
use yii\validators\Validator;

/**
 * 模糊查询过滤
 * Class LikeValidator
 * @package app\components
 */
class LikeValidator extends Validator
{
    /**
     * 返回允许模糊查询的格式
     * @param \yii\base\Model $model
     * @param string $attribute
     * @return string
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = StringHelper::replace('%', '', $model->$attribute).'%';
    }
}