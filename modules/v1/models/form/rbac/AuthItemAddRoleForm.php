<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAddRoleForm
 * @package v1\models\form\rbac
 */
class AuthItemAddRoleForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'add-role'],
            [['name'], 'required', 'on' => 'add-role'],
            [['name'], 'string', 'on' => 'add-role'],
            [['name'], 'trim', 'on' => 'add-role'],
            [['name'], 'unique', 'targetClass' => AuthItem::className(), 'on' => 'add-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-role' => [
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
            'name' => Yii::t('app\attribute', 'name'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 添加角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addRole($param)
    {
        // 表单模型实例化
        $authItemAddRoleForm = new AuthItemAddRoleForm();
        // 场景定义
        $authItemAddRoleForm->setScenario('add-role');
        // 验证数据是否合法
        if ($authItemAddRoleForm->load([$authItemAddRoleForm->formName() => $param]) && $authItemAddRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddRoleForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['name']);
            if ($auth->add($role)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddRoleForm->getFirstError());
        }
    }

}