<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use v1\models\User;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;

/**
 * 表单模型
 * Class AuthItemUserListForm
 * @package v1\models\form\rbac
 */
class AuthItemUserListForm extends Model
{
    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
        ];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取列表数据
     * @param $param
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function lists($param)
    {
        $dataProvider = ActiveRecord::getDb()->cache(function ($db) {
            $query = User::find();
            // 结果数据返回
            $pagination = new Pagination([
                'defaultPageSize' => 20,
                'totalCount' => $query->count()
            ]);
            $data = $query->offset($pagination->getOffset())
                ->limit($pagination->getLimit())
                ->all();
            return new ArrayDataProvider([
                'models' => $data,
                'Pagination' => $pagination,
            ]);
        }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [User::getListTag("")]]));

        return $dataProvider;
    }
}