<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\form\Model;
use v1\models\rbac\AuthAssignment;
use v1\models\rbac\AuthItem;
use v1\models\rbac\AuthItemChild;
use v1\models\rbac\AuthRule;
use v1\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAddUserRoleForm
 * @package v1\models\form\rbac
 */
class AuthItemAddUserRoleForm extends Model
{
    public $user_id;
    public $role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'role'], 'safe', 'on' => 'add-user-role'],
            [['user_id', 'role'], 'required', 'on' => 'add-user-role'],
            [['role'], 'trim', 'on' => 'add-user-role'],
            [['user_id'], 'integer', 'on' => 'add-user-role'],
            [['role'], 'string', 'on' => 'add-user-role'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'], 'on' => 'add-user-role'],
            [['role'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role' => 'name'], 'filter' => ['type' => 1], 'on' => 'add-user-role'],
            [['user_id'], 'validateUserIdAndRole', 'on' => 'add-user-role']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-user-role' => [
                'user_id',
                'role'
            ]
        ];
    }

    /**
     * 验证用户、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateUserIdAndRole($attribute, $params)
    {
        // 是否已存在该数据
        $authAssignment = AuthAssignment::exists(false, $this->user_id, $this->role);
        if ($authAssignment) {
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app\attribute', 'user_id'),
            'role' => Yii::t('app\attribute', 'role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为用户分配角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addUserRole($param)
    {
        // 表单模型实例化
        $authItemAddUserRoleForm = new AuthItemAddUserRoleForm();
        // 场景定义
        $authItemAddUserRoleForm->setScenario('add-user-role');
        // 验证数据是否合法
        if ($authItemAddUserRoleForm->load([$authItemAddUserRoleForm->formName() => $param]) && $authItemAddUserRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddUserRoleForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['role']);
            if ($auth->assign($role, $attributes['user_id'])) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddUserRoleForm->getFirstError());
        }
    }

}