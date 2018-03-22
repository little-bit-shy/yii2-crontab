<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form;

use v1\models\UserCopy;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class UserCopyForm
 * @package v1\models\form
 */
class UserCopyForm extends Model
{
    public $username;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'safe', 'on' => 'create'],
            ['username', 'required', 'on' => 'create', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => [
                'username'
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
            'username' => Yii::t('app\attribute', 'username')
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 添加数据
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function create($param)
    {
        $form = new UserCopyForm();
        $form->setScenario('create');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            try {
                $model = new UserCopy();
                $model->setScenario('create');
                $model->load([$model->formName() => $form->getAttributes()]);
                $model->save();
            } catch (\yii\db\Exception $e) {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
        throw new HttpException(200, Yii::t('app/success', 'data added successfully'));
    }
}