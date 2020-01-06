<?php

namespace app\components;

use Yii;
use yii\helpers\StringHelper;
use yii\validators\Validator;

/**
 * 多值区间过滤
 * Class SetValidator
 * @package app\components
 */
class SetValidator extends Validator
{
    public $range;

    /**
     * 返回一个数组
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = StringHelper::explode($model->$attribute, ',');
        if (!empty($this->range)) {
            foreach ($model->$attribute as $value) {
                if (!ArrayHelper::isIn($value, $this->range)) {
                    $this->addError($model, $attribute, '{attribute}' . Yii::t('app\error', 'data exception'));
                    return;
                }
            }
        }
    }
}