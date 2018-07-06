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
 * Class AuthItemDeleteUserRoleForm
 * @package v1\models\form\rbac
 */
class AuthItemDeleteUserRoleForm extends Model
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
            [['user_id', 'role'], 'safe', 'on' => 'delete-user-role'],
            [['user_id', 'role'], 'required', 'on' => 'delete-user-role'],
            [['role'], 'trim', 'on' => 'delete-user-role'],
            [['user_id'], 'integer', 'on' => 'delete-user-role'],
            [['role'], 'string', 'on' => 'delete-user-role'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'], 'on' => 'delete-user-role'],
            [['role'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role' => 'name'], 'filter' => ['type' => 1], 'on' => 'delete-user-role'],
            [['role'], 'validateNameAndRole', 'on' => 'delete-user-role']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'delete-user-role' => [
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
    public function validateNameAndRole($attribute, $params)
    {
        // 是否已存在该数据
        $authItemChild = AuthAssignment::exists(false, $this->user_id, $this->role);
        if(!$authItemChild){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
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
     * 为用户删除角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function deleteUserRole($param)
    {
        // 表单模型实例化
        $authItemDeleteUserRoleForm = new AuthItemDeleteUserRoleForm();
        // 场景定义
        $authItemDeleteUserRoleForm->setScenario('delete-user-role');
        // 验证数据是否合法
        if ($authItemDeleteUserRoleForm->load([$authItemDeleteUserRoleForm->formName() => $param]) && $authItemDeleteUserRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemDeleteUserRoleForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['role']);
            if ($auth->revoke($role, $attributes['user_id'])) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemDeleteUserRoleForm->getFirstError());
        }
    }

}