<?php

namespace v1\models;


use Yii;
use yii\caching\TagDependency;
use yii\db\Exception;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * 数据缓存过期时间
     * @var int
     */
    public static $dataTimeOut = 600;

    /**
     * 获取列表数据缓存依赖标签
     * @param string $identifying
     * @return string
     */
    public static function getListTag($identifying = '')
    {
        $identifying = '\\list\\' . md5($identifying);
        return self::className() . $identifying;
    }

    /**
     * 获取详细数据缓存依赖标签
     * @param string $identifying
     * @return string
     */
    public static function getDetailTag($identifying = '')
    {
        $identifying = '\\detail\\' . md5($identifying);
	return self::className() . $identifying;
    }

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

    /***************************** 触发事件 *********************************/

    /**
     * 数据写操作后触发的事件
     * 缓存依赖清除
     * @param bool $insert
     * @param array $changedAttributes
     * @return bool|void
     */
    public function afterSave($insert, $changedAttributes)
    {
        $afterSave = parent::afterSave($insert, $changedAttributes);
        try {
            // 数据id
            $id = $this->getAttribute('id');
            // 列表数据缓存清除
            TagDependency::invalidate(Yii::$app->getCache(), self::getListTag());
            // 详细数据缓存清除
            TagDependency::invalidate(Yii::$app->getCache(), self::getDetailTag("/id/{$id}"));
        } catch (Exception $e) {
            return false;
        }
        return $afterSave;
    }
}
