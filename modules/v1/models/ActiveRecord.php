<?php

namespace v1\models;


class ActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return parent::fields();
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * url上加expand参数获取
     * @return array
     */
    public function extraFields()
    {
        $fields = array_keys($this->getRelatedRecords());
        foreach ($fields as $value) {
            // 获取所有子关联级相关数据
            $fields[$value] = function (self $model) use ($value) {
                /** @var ActiveRecord $activeRecord */
                $activeRecord = $model->$value;
                if (empty($activeRecord)) {
                    return null;
                } else {
                    $field = array_keys($activeRecord->getRelatedRecords());
                    return $activeRecord->toArray([], $field, true);
                }
            };
        }
        return $fields;
    }
}
