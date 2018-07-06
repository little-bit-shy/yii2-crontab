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
use Yii;
use yii\caching\TagDependency;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllListsForm
 * @package v1\models\form\rbac
 */
class AuthItemAllListsForm extends Model
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
            [['type', 'name'], 'safe', 'on' => 'all-lists'],
            [['type'], 'default', 'value' => 2, 'on' => 'all-lists'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'all-lists'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-lists' => [
                'type',
                'name',
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
            'type' => Yii::t('app\attribute', 'type'),
            'name' => Yii::t('app\attribute', 'name'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取所有列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     */
    public static function allLists($param)
    {
        // 表单模型实例化
        $authItemIndexForm = new AuthItemAllListsForm();
        // 场景定义
        $authItemIndexForm->setScenario('all-lists');
        // 验证数据是否合法
        if ($authItemIndexForm->load([$authItemIndexForm->formName() => $param]) && $authItemIndexForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemIndexForm->getAttributes();
            $data = AuthItem::dataProvider(true, $attributes['type'], $attributes['name']);
            $dataProvider = [];
            foreach ($data as $key => $value) {
                $dataProvider[$value['name']] = $value;
            }
            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemIndexForm->getFirstError());
        }
    }
}