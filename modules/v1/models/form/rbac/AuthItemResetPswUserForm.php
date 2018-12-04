<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\form\Model;
use v1\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemResetPswUserForm
 * @package v1\models\form\rbac
 */
class AuthItemResetPswUserForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

    public $password_old;
    public $password_new;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['password_old', 'password_new'], 'safe', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'required', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'string', 'on' => 'reset-psw'],
            [['password_old', 'password_new'], 'trim', 'on' => 'reset-psw'],
            [['password_new'], 'filter', 'filter' => function ($value) {
                return Yii::$app->getSecurity()->generatePasswordHash($value);
            }, 'on' => 'reset-psw'],
            [['password_old'], 'validatePasswordOld', 'on' => 'reset-psw'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'reset-psw' => [
                'password_old', 'password_new'
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
            'password_old' => Yii::t('app\attribute', 'password_old'),
            'password_new' => Yii::t('app\attribute', 'password_new'),
        ];
    }

    /**
     * 验证用户密码是否合法
     * @param $attribute
     * @param $params
     * @throws \Exception
     * @throws \Throwable
     */
    public function validatePasswordOld($attribute, $params)
    {
        $user = self::getUser(Yii::$app->getUser()->getId());
        if (empty($user)) {
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
        }
        if (!$user->validatePassword($this->password_old)) {
            $this->addError($attribute, Yii::t('app/error', 'user old password error'));
        }
    }

    /***************************** 表单操作 *********************************/

    /**
     * 重置用户密码
     * @param $param
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function resetPswUser($param)
    {
        // 表单模型实例化
        $authItemResetPswUserForm = new AuthItemResetPswUserForm();
        // 场景定义
        $authItemResetPswUserForm->setScenario('reset-psw');
        // 验证数据是否合法
        if ($authItemResetPswUserForm->load([$authItemResetPswUserForm->formName() => $param]) && $authItemResetPswUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemResetPswUserForm->getAttributes();
            // 添加用户
            if (User::ResetPsw($attributes['username'], $attributes['password_new'])) {
                throw new HttpException(200, Yii::t('app/success', 'password reset successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemResetPswUserForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

    /**
     * 通过用户名称获取用户信息
     * @param $username
     * @param bool $ignoreExistingData 无视容器已有的数据
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    private function getUser($username, $ignoreExistingData = false)
    {
        if (empty(static::$_user) || $ignoreExistingData === true) {
            static::$_user = User::findIdentityByUsername($username);
        }
        return static::$_user;
    }
}
