<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use app\components\ArrayHelper;
use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthAssignment;
use v1\models\rbac\AuthItem;
use v1\models\rbac\AuthItemChild;
use v1\models\User;
use Yii;
use yii\caching\TagDependency;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllRoleWithUserForm
 * @package v1\models\form\rbac
 */
class AuthItemAllRoleWithUserForm extends Model
{
    public $user_id;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'safe', 'on' => 'all-role-with-user'],
            [['user_id'], 'required', 'on' => 'all-role-with-user'],
            [['user_id'], 'integer', 'on' => 'all-role-with-user'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'], 'on' => 'all-role-with-user'],

        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-role-with-user' => [
                'user_id',
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
            'user_id' => Yii::t('app\attribute', 'user_id'),
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
    public static function allRoleWithUser($param)
    {
        // 表单模型实例化
        $authItemAllRoleWithUserForm = new AuthItemAllRoleWithUserForm();
        // 场景定义
        $authItemAllRoleWithUserForm->setScenario('all-role-with-user');
        // 验证数据是否合法
        if ($authItemAllRoleWithUserForm->load([$authItemAllRoleWithUserForm->formName() => $param]) && $authItemAllRoleWithUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAllRoleWithUserForm->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                // 获取数据
                $auth = Yii::$app->getAuthManager();
                $dataProvider = $auth->getAssignments($attributes['user_id']);

                // 结果数据返回
                return $dataProvider;
            }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthAssignment::getListTag("")]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAllRoleWithUserForm->getFirstError());
        }
    }
}