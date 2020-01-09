<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\task;

use app\components\LikeValidator;
use v1\models\form\Model;
use v1\models\task\ExecuteTask;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskIndexForm
 * @package v1\models\form
 */
class ExecuteTaskIndexForm extends Model
{
    public $command;
    public $status;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['command', 'status'], 'safe', 'on' => 'index'],
            [['command'], 'trim', 'on' => 'index'],
            [['command'], 'string', 'on' => 'index'],
            [['command'], LikeValidator::className(), 'skipOnEmpty' => true, 'on' => 'index'],
            [['status'], 'in', 'range' => [1, 2, 3, 4], 'on' => 'index'],
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
                'command',
                'status',
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
            'command' => Yii::t('app\attribute', 'command'),
            'status' => Yii::t('app\attribute', 'status'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 数据列表
     * @param $param
     * @return \yii\data\ActiveDataProvider
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function lists($param)
    {
        $form = new ExecuteTaskIndexForm();
        $form->setScenario('index');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            $attributes = $form->getAttributes();
            return ExecuteTask::lists($attributes);
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
    }
}