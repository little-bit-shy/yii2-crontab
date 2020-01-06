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
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemDeleteRoleRoleForm
 * @package account\form\rbac
 */
class AuthItemDeleteRoleRoleForm extends Model
{
    public $role;
    public $child_role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['role', 'child_role'], 'safe', 'on' => 'delete-role-role'],
            [['role', 'child_role'], 'required', 'on' => 'delete-role-role'],
            [['role', 'child_role'], 'trim', 'on' => 'delete-role-role'],
            [['role', 'child_role'], 'string', 'on' => 'delete-role-role'],
            [['role'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['role' => 'name'], 'filter' => ['type' => 1], 'on' => 'delete-role-role'],
            [['child_role'], 'exist', 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child_role' => 'name'], 'filter' => ['type' => 1], 'on' => 'delete-role-role'],
            [['role'], 'validateRole', 'when' => function($model){
                return !$model->hasErrors();
            } , 'on' => 'delete-role-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'delete-role-role' => [
                'role',
                'child_role'
            ]
        ];
    }

    /**
     * 验证角色、角色关系是否合法
     * @param $attribute
     * @param $params
     */
    public function validateRole($attribute, $params)
    {
        $auth = Yii::$app->getAuthManager();
        $parent = $auth->getRole($this->role);
        $child = $auth->getRole($this->child_role);

        if ($this->role === $this->child_role) {
            $this->addError($attribute, Yii::t('app/error', 'this data cannot be deleted'));
            return;
        }

        // 是否已存在该数据
        if(!$auth->hasChild($parent, $child)){
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
            return;
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'role' => Yii::t('app\attribute', 'role'),
            'child_role' => Yii::t('app\attribute', 'child_role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 为角色删除角色
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function deleteRoleRole($param)
    {
        // 表单模型实例化
        $authItemDeleteRoleRoleForm = new AuthItemDeleteRoleRoleForm();
        // 场景定义
        $authItemDeleteRoleRoleForm->setScenario('delete-role-role');
        // 验证数据是否合法
        if ($authItemDeleteRoleRoleForm->load([$authItemDeleteRoleRoleForm->formName() => $param]) && $authItemDeleteRoleRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemDeleteRoleRoleForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $parent = $auth->getRole($attributes['role']);
            $child = $auth->getRole($attributes['child_role']);
            if ($auth->removeChild($parent, $child)) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemDeleteRoleRoleForm->getFirstError());
        }
    }

}