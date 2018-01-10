<?php

namespace v1\models;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class UserCopy extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%user_copy}}';
    }

    /**
     * 资源类通过实现yii\web\Linkable 接口来支持HATEOAS，
     * 该接口包含方法 yii\web\Linkable::getLinks() 来返回 yii\web\Link 列表，
     * 典型情况下应返回包含代表本资源对象URL的 self 链接
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user_copy/view', 'id' => $this->id], true),
        ];
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
        return parent::extraFields();
    }

    /***************************** 关联数据 *********************************/

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    public function getUserCopy()
    {
        return $this->hasOne(UserCopy::className(), ['id' => 'id']);
    }

    /***************************** 增删改查 *********************************/
}
