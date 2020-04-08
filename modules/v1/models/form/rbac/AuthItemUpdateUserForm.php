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
 * Class AuthItemUpdateUserForm
 * @package v1\models\form\rbac
 */
class AuthItemUpdateUserForm extends Model
{
    /** @var User $_user 保存用户数据容器，避免多次查询 */
    private static $_user = null;

    public $id;
    public $phone;
    public $warning;
    public $email;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'phone', 'warning', 'email'], 'safe', 'on' => 'update-user'],
            [['id'], 'integer', 'on' => 'update-user'],
            [['phone', 'warning', 'email'], 'trim', 'on' => 'update-user'],
            [['warning'], 'in', 'range' => [1, 2], 'on' => 'update-user'],
            [['phone', 'email'], 'filter', 'filter' => function ($value) {
                return $value ?: null;
            }, 'on' => 'update-user'],
            [['warning'], 'required', 'on' => 'update-user'],
            [['phone', 'warning', 'email'], 'string', 'on' => 'update-user'],
            [['email'], 'email', 'on' => 'update-user'],
            [['phone'], 'match', 'pattern' => '/^[1][34578][0-9]{9}$/', 'on' => 'update-user'],
            [['id'], 'validateId', 'on' => 'update-user'],
            [['phone'], 'unique', 'targetClass' => User::className(), 'when' => function () {
                $user = $this->getUser($this->id);
                return $this->phone != $user->phone;
            } , 'on' => 'update-user'],
            [['email'], 'unique', 'targetClass' => User::className(), 'when' => function () {
                $user = $this->getUser($this->id);
                return $this->email != $user->email;
            } , 'on' => 'update-user'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update-user' => [
                'id', 'phone', 'warning', 'email'
            ]
        ];
    }

    /**
     * 验证Id是否合法
     * @param $attribute
     * @param $params
     */
    public function validateId($attribute, $params)
    {
        // 是否已存在该数据
        $user = $this->getUser($this->id);
        if (!$user) {
            $this->addError($attribute, Yii::t('app/error', 'the data not exist'));
        }
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app\attribute', 'id'),
            'phone' => Yii::t('app\attribute', 'phone'),
            'warning' => Yii::t('app\attribute', 'password'),
            'email' => Yii::t('app\attribute', 'email'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 修改用户
     * @param $param
     * @throws HttpException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function updateUser($param)
    {
        // 表单模型实例化
        $authItemUpdateUserForm = new AuthItemUpdateUserForm();
        // 场景定义
        $authItemUpdateUserForm->setScenario('update-user');
        // 验证数据是否合法
        if ($authItemUpdateUserForm->load([$authItemUpdateUserForm->formName() => $param]) && $authItemUpdateUserForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemUpdateUserForm->getAttributes();
            // 添加用户
            if (User::updateUser($attributes['id'], $attributes['warning'], $attributes['phone'], $attributes['email'])) {
                throw new HttpException(200, Yii::t('app/success', 'data update successfully'));
            } else {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemUpdateUserForm->getFirstError());
        }
    }
    /***************************** 获取数据 *********************************/

    /**
     * 通过用户Id获取用户信息
     * @param $id
     * @param bool $ignoreExistingData 无视容器已有的数据
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    private function getUser($id, $ignoreExistingData = false)
    {
        if (empty(static::$_user) || $ignoreExistingData === true) {
            static::$_user = User::findIdentityById($id);
        }
        return static::$_user;
    }
}
