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
 * Class AuthItemAddRolePermissionsForm
 * @package v1\models\form\rbac
 */
class AuthItemAddRolePermissionsForm extends Model
{
    public $name;
    public $role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'role'], 'safe', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'required', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'trim', 'on' => 'add-role-permissions'],
            [['name', 'role'], 'string', 'on' => 'add-role-permissions'],
            [['name'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['name' => 'name'], 'filter' => ['type' => 2], 'on' => 'add-role-permissions'],
            [['role'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role' => 'name'], 'filter' => ['type' => 1], 'on' => 'add-role-permissions'],
            [['name'], 'validateNameAndRole', 'on' => 'add-role-permissions']
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-role-permissions' => [
                'name',
                'role'
            ]
        ];
    }

    /**
     * 验证权限、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateNameAndRole($attribute, $params)
    {
        // 是否已存在该数据
        $authItemChild = AuthItemChild::exists(false, $this->role, $this->name);
        if($authItemChild){
            $this->addError($attribute, Yii::t('app/error', 'the data exist'));
        }

        // 验证权限、角色关系是否合法
        $auth = Yii::$app->getAuthManager();
        $role = $auth->createRole($this->role);
        $permission = $auth->createPermission($this->name);
        if (!$auth->canAddChild($role, $permission)) {
            $this->addError($attribute, Yii::t('app/error', 'role or name error'));
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app\attribute', 'name'),
            'role' => Yii::t('app\attribute', 'role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为角色添加权限
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addRolePermissions($param)
    {
        // 表单模型实例化
        $authItemAddRolePermissionsForm = new AuthItemAddRolePermissionsForm();
        // 场景定义
        $authItemAddRolePermissionsForm->setScenario('add-role-permissions');
        // 验证数据是否合法
        if ($authItemAddRolePermissionsForm->load([$authItemAddRolePermissionsForm->formName() => $param]) && $authItemAddRolePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddRolePermissionsForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createRole($attributes['name']);
            $role = $auth->createRole($attributes['role']);
            if ($auth->addChild($role, $permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddRolePermissionsForm->getFirstError());
        }
    }

}