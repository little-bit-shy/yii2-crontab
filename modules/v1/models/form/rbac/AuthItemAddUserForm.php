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
 * Class AuthItemAddUserForm
 * @package v1\models\form\rbac
 */
class AuthItemAddUserForm extends Model
{
    public $phone;
    public $username;
    public $password;
    public $email;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['phone', 'username', 'password', 'email'], 'safe', 'on' => 'add-user'],
            [['username', 'password'], 'required', 'on' => 'add-user'],
            [['phone', 'username', 'password', 'email'], 'string', 'on' => 'add-user'],
            [['phone', 'username', 'password', 'email'], 'trim', 'on' => 'add-user'],
            [['email'], 'email', 'on' => 'add-user'],
            [['phone'], 'match', 'pattern' => '/^[1][34578][0-9]{9}$/', 'on' => 'add-user'],
            [['phone', 'username', 'email'], 'unique', 'targetClass' => User::className(), 'skipOnEmpty' => false, 'on' => 'add-user'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'add-user' => [
                'phone', 'username', 'password', 'email'
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
            'phone' => Yii::t('app\attribute', 'phone'),
            'username' => Yii::t('app\attribute', 'username'),
            'password' => Yii::t('app\attribute', 'password'),
            'email' => Yii::t('app\attribute', 'email'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 添加用户
     * @param $param
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function addUser($param)
    {
        // 表单模型实例化
        $authItemAddUserForm = new AuthItemAddUserForm();
        // 场景定义
        $authItemAddUserForm->setScenario('add-user');
        // 验证数据是否合法
        if ($authItemAddUserForm->load([$authItemAddUserForm->formName() => $param]) && $authItemAddUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAddUserForm->getAttributes();

            $time = time();
            $user = new User();
            $user->load([$user->formName() => [
                'username' => $attributes['username'],
                'password_hash' => Yii::$app->getSecurity()->generatePasswordHash($attributes['password']),
                'phone' => $attributes['phone'],
                'email' => $attributes['email'],
                'created_at' => $time,
                'updated_at' => $time,
            ]]);
            if ($user->save()) {
                throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAddUserForm->getFirstError());
        }
    }

}
