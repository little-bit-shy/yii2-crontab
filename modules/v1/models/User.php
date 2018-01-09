<?php

namespace v1\models;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class User extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%user}}';
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
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'username' => 'username',
            'head',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email',
            'created_at',
            'updated_at',
            'now_time' => function ($model) {
                return date('Y-m-d H:i:s', time());
            },
        ];
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * @return array
     */
    public function extraFields()
    {
        return [
            'another' => function ($model) {
                return [
                    'another1' => date('Y-m-d H:i:s', time()),
                    'another2' => date('Y-m-d H:i:s', time())
                ];
            }
        ];
    }

    /***************************** 增删改查 *********************************/

    /**
     * 获取列表数据
     * @return ActiveDataProvider
     */
    public static function lists()
    {
        $query = User::find();
        $activeDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ]
        ]);
        return $activeDataProvider;
    }

    /**
     * 获取详细信息
     * @param int $id 数据id
     * @return \yii\db\ActiveQuery
     */
    public static function detail($id)
    {
        $model = User::findOne($id);
        return $model;
    }
}
