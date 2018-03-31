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
 * Class AuthItemAddRoleForm
 * @package v1\models\form\rbac
 */
class AuthItemAddRoleForm extends Model
{
    public $name;
    public $description;
    public $rule_name;
    public $data;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'description', 'rule_name', 'data'], 'safe', 'on' => 'add-role'],
            [['name'], 'required', 'on' => 'add-role'],
            [['name', 'description', 'rule_name', 'data'], 'string', 'on' => 'add-role'],
            [['name'], 'trim', 'on' => 'add-role'],
            [['name'], 'unique', 'targetClass' => AuthItem::className(), 'filter' => ['type' => 2], 'on' => 'add-role'],
            [['rule_name'], 'validateRuleName', 'skipOnEmpty' => false, 'on' => 'add-role'],
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
                'name', 'description', 'rule_name', 'data'
            ]
        ];
    }

    /**
     * 验证rule_name参数是否合法
     * @param $attribute
     * @param $params
     */
    public function validateRuleName($attribute, $params)
    {
        if ($this->$attribute !== null && !(class_exists($this->$attribute) && is_subclass_of($this->$attribute, '\yii\rbac\Rule'))) {
            $this->addError($attribute, Yii::t('app/error', 'rule name error'));
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
            'description' => Yii::t('app\attribute', 'description'),
            'rule_name' => Yii::t('app\attribute', 'rule_name'),
            'data' => Yii::t('app\attribute', 'data'),
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
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($attributes['name']);
            $role->description = $attributes['description'];
            $role->ruleName = $attributes['rule_name'];
            $role->data = $attributes['data'];
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