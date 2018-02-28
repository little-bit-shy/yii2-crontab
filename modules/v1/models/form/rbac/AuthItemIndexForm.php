<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use Yii;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemIndexForm
 * @package v1\models\form\rbac
 */
class AuthItemIndexForm extends Model
{
    public $type;
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'safe', 'on' => 'index'],
            [['name'], 'string', 'on' => 'index'],
            [['name'], 'trim', 'on' => 'index'],
            [['type'], 'default', 'value' => 2, 'on' => 'index'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'index'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'index' => [
                'name'
            ]
        ];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app\attribute', 'name'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public static function lists($param)
    {
        // 表单模型实例化
        $authItemIndexForm = new AuthItemIndexForm();
        // 场景定义
        $authItemIndexForm->setScenario('index');
        // 验证数据是否合法
        if ($authItemIndexForm->load([$authItemIndexForm->formName() => $param]) && $authItemIndexForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemIndexForm->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                $query = AuthItem::find();
                // 数据类型过滤
                $query->andFilterWhere([
                    'type' => $attributes['type'],
                ]);
                // 权限、角色名称过滤
                $query->andFilterWhere(['like', 'name', $attributes['name']]);
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

            }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag("")]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemIndexForm->getFirstError());
        }
    }
}