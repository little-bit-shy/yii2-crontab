<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use app\components\LikeValidator;
use v1\models\form\Model;
use v1\models\User;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemUserListForm
 * @package v1\models\form\rbac
 */
class AuthItemUserListForm extends Model
{
    public $username;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username'], 'safe', 'on' => 'index'],
            [['username'], 'trim', 'on' => 'index'],
            [['username'], 'string', 'on' => 'index'],
            [['username'], LikeValidator::className(), 'skipOnEmpty' => true, 'on' => 'index'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'index' => [
                'username',
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
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 获取列表数据
     * @param $param
     * @return mixed|\yii\data\ArrayDataProvider
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function lists($param)
    {
        $form = new AuthItemUserListForm();
        $form->setScenario('index');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            $attributes = $form->getAttributes();
            return User::lists(true, $attributes);
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
    }
}