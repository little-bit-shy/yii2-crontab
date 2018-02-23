<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\user;

use v1\models\form\Model;
use v1\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class LoginForm
 * @package v1\models\form
 */
class LoginForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

    public $username;
    public $password;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'safe', 'on' => 'login'],
            [['username', 'password'], 'required', 'on' => 'login', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
            [['username'], 'validateUsername', 'on' => 'login'],
            [['password'], 'validatePassword', 'on' => 'login'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'login' => [
                'username',
                'password',
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
            'username' => Yii::t('app\attribute', 'username'),
            'password' => Yii::t('app\attribute', 'password'),
        ];
    }

    /**
     * 验证用户名是否合法
     * @param $attribute
     * @param $params
     */
    public function validateUsername($attribute, $params)
    {
        $user = self::getUser($this->username);
        if (empty($user)) {
            $this->addError($attribute, Yii::t('app/error', 'the user does not exist'));
        }
    }

    /**
     * 验证用户密码是否合法
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params)
    {
        $user = self::getUser($this->username);
        if (!empty($user) && !$user->validatePassword($this->password)) {
            $this->addError($attribute, Yii::t('app/error', 'user password error'));
        }
    }

    /***************************** 表单操作 *********************************/

    /**
     * 用户登录
     * @param $param
     * @return User
     * @throws HttpException
     */
    public function login($param)
    {
        $loginForm = new LoginForm();
        $loginForm->setScenario('login');
        if ($loginForm->load([$loginForm->formName() => $param]) && $loginForm->validate()) {
            return self::getUser($loginForm->username);
        } else {
            throw new HttpException(422, $loginForm->getFirstError());
        }
    }

    /***************************** 获取数据 *********************************/

    /**
     * 通过用户名称获取用户信息
     * @param $username
     * @return User
     */
    private function getUser($username)
    {
        if (empty(static::$_user)) {
            static::$_user = User::findIdentityByUsername($username);
        }
        return static::$_user;
    }
}