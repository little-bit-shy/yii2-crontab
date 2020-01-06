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
use v1\models\rbac\AuthItemChild;
use Yii;
use yii\caching\TagDependency;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllRoleWithRoleForm
 * @package account\form\rbac
 */
class AuthItemAllRoleWithRoleForm extends Model
{
    public $role;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['role'], 'safe', 'on' => 'all-role-with-role'],
            [['role'], 'required', 'on' => 'all-role-with-role'],
            [['role'], 'string', 'on' => 'all-role-with-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-role-with-role' => [
                'role',
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
            'role' => Yii::t('app\attribute', 'role'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 返回用户下的所有角色列表数据
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allRoleWithRole($param)
    {
        // 表单模型实例化
        $authItemAllRoleWithRoleForm = new AuthItemAllRoleWithRoleForm();
        // 场景定义
        $authItemAllRoleWithRoleForm->setScenario('all-role-with-role');
        // 验证数据是否合法
        if ($authItemAllRoleWithRoleForm->load([$authItemAllRoleWithRoleForm->formName() => $param]) && $authItemAllRoleWithRoleForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAllRoleWithRoleForm->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                // 获取数据
                $auth = Yii::$app->getAuthManager();
                $dataProvider = $auth->getChildRoles($attributes['role']);

                // 结果数据返回
                return $dataProvider;
            }, AuthItemChild::$dataTimeOut, new TagDependency(['tags' => [AuthItemChild::getListTag("")]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAllRoleWithRoleForm->getFirstError());
        }
    }
}