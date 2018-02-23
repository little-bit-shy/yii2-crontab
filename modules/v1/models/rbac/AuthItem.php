<?php

namespace v1\models\rbac;

use v1\models\ActiveRecord;
use Yii;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class AuthItem extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            // create
            [['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], 'safe', 'on' => 'create'],
        ];
    }

    /**
     * 验证场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => ['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'],
        ];
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
            Link::REL_SELF => Url::to(['auth-item/view', 'name' => $this->name], true),
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

    /***************************** 触发事件 *********************************/

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/
}
