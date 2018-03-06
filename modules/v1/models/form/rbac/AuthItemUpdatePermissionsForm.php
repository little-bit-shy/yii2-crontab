<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use app\components\AppRoutes;
use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemUpdatePermissionsForm
 * @package v1\models\form\rbac
 */
class AuthItemUpdatePermissionsForm extends Model
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
            [['name', 'description', 'rule_name', 'data'], 'safe', 'on' => 'update-permissions'],
            [['name', 'description', 'rule_name', 'data'], 'string', 'on' => 'update-permissions'],
            [['name'], 'required', 'on' => 'update-permissions'],
            [['name'], 'exist', 'targetClass' => AuthItem::className(), 'on' => 'update-permissions'],
            [['rule_name'], 'validateRuleName', 'skipOnEmpty' => false, 'on' => 'update-permissions'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update-permissions' => [
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
        if (!(class_exists($this->$attribute) && is_subclass_of($this->$attribute, '\yii\rbac\Rule'))) {
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
     * 修改权限
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function updatePermissions($param)
    {
        // 表单模型实例化
        $authItemUpdatePermissionsForm = new AuthItemUpdatePermissionsForm();
        // 场景定义
        $authItemUpdatePermissionsForm->setScenario('update-permissions');
        // 验证数据是否合法
        if ($authItemUpdatePermissionsForm->load([$authItemUpdatePermissionsForm->formName() => $param]) && $authItemUpdatePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemUpdatePermissionsForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['name']);
            $permission->description = $attributes['description'];
            $permission->ruleName = $attributes['rule_name'];
            $permission->data = $attributes['data'];
            if ($auth->update($attributes['name'], $permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data update successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemUpdatePermissionsForm->getFirstError());
        }
    }

}
