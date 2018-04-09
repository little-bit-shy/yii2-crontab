<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use app\components\AppRoutes;
use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthAssignment;
use v1\models\rbac\AuthItem;
use v1\models\rbac\AuthItemChild;
use v1\models\rbac\AuthRule;
use Yii;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemRemovePermissionsForm
 * @package v1\models\form\rbac
 */
class AuthItemRemovePermissionsForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'remove-permissions'],
            [['name'], 'required', 'on' => 'remove-permissions'],
            [['name'], 'trim', 'on' => 'remove-permissions'],
            [['name'], 'string', 'on' => 'remove-permissions'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'remove-permissions' => [
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
     * 删除权限
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function removePermissions($param)
    {
        // 表单模型实例化
        $authItemRemovePermissionsForm = new AuthItemRemovePermissionsForm();
        // 场景定义
        $authItemRemovePermissionsForm->setScenario('remove-permissions');
        // 验证数据是否合法
        if ($authItemRemovePermissionsForm->load([$authItemRemovePermissionsForm->formName() => $param]) && $authItemRemovePermissionsForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemRemovePermissionsForm->getAttributes();
            // 顺便清除缓存依赖对应的子数据
            // 顺便清除缓存依赖对应的子数据
            (new AuthItem())->tagDependencyInvalidate();
            (new AuthItemChild())->tagDependencyInvalidate();
            (new AuthAssignment())->tagDependencyInvalidate();
            (new AuthRule())->tagDependencyInvalidate();

            $auth = Yii::$app->getAuthManager();
            $permission = $auth->createPermission($attributes['name']);
            if ($auth->remove($permission)) {
                throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemRemovePermissionsForm->getFirstError());
        }
    }

}