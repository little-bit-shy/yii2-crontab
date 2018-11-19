<?php

namespace v1\models;

use Yii;
use v1\models\form\UserCopyForm;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Link;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

class UserCopy extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%user_copy}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            // create
            [['username'], 'safe', 'on' => 'create'],
        ];
    }

    /**
     * 验证场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => ['username'],
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
            Link::REL_SELF => Url::to(['user-copy/view', 'id' => $this->id], true),
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    public function getUserCopy()
    {
        return $this->hasOne(UserCopy::className(), ['id' => 'id']);
    }

    /***************************** 增删改查 *********************************/

    /**
     * 获取详细信息
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function detail($id)
    {
        $data = ActiveRecord::getDb()->cache(function ($db) use ($id) {
            $query = UserCopy::find()->where(['id' => $id]);
            $query->with(['userCopy' => function (ActiveQuery $query) {
                $query->with('userCopy.userCopy.userCopy');
            }]);
            return $query->one();
        }, UserCopy::$dataTimeOut, new TagDependency(['tags' => [UserCopy::getDetailTag("/id/{$id}")]]));

        if (empty($data)) {
            // 数据不存在
            throw new NotFoundHttpException();
        } else {
            return $data;
        }
    }

    /**
     * 获取列表数据
     * @return ActiveDataProvider
     */
    public static function lists()
    {
        $activeDataProvider = UserCopy::getDb()->cache(function ($db) {
            $query = UserCopy::find();
            $query->with(['userCopy' => function (ActiveQuery $query) {
                $query->with(['userCopy.userCopy.userCopy']);
            }]);
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count()
            ]);
            $data = $query->offset($pagination->getOffset())
                ->limit($pagination->getLimit())
                ->all();
            return new ArrayDataProvider([
                'models' => $data,
                'Pagination' => $pagination,
            ]);
        }, UserCopy::$dataTimeOut, new TagDependency(['tags' => [UserCopy::getListTag("")]]));

        return $activeDataProvider;
    }
}
