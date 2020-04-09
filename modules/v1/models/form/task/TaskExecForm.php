<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\task;

use app\commands\task\ExecuteTask;
use v1\models\form\Model;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskExecForm
 * @package v1\models\form
 */
class TaskExecForm extends Model
{
    public $command;
    public $type;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['command', 'type'], 'safe', 'on' => 'exec'],
            [['command', 'type'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'exec'],
            [['command'], 'trim', 'on' => 'exec'],
            [['command'], 'string', 'on' => 'exec'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'exec'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'exec' => [
                'command',
                'type'
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
            'type' => Yii::t('app\attribute', 'type'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 任务入队
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function exec($param)
    {
        $form = new TaskExecForm();
        $form->setScenario('exec');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            $data = $form->getAttributes();
            $start_time = date('Y-m-d H:i:s', time());
            try {
                $id = ExecuteTask::pushTask($start_time, $data['command'], $data['type']);
                return ['id' => $id];
            } catch (\Exception $e) {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
    }
}