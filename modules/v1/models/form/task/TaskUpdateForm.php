<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\task;

use v1\models\form\Model;
use v1\models\task\Task;
use Yii;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskUpdateForm
 * @package v1\models\form
 */
class TaskUpdateForm extends Model
{
    public $id;
    public $command;
    public $type;
    public $year;
    public $month;
    public $day;
    public $hour;
    public $minute;
    public $second;
    public $switch;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'command', 'type', 'year', 'month', 'day', 'hour', 'minute', 'second', 'switch'], 'safe', 'on' => 'update'],
            [['id', 'command', 'year', 'month', 'day', 'hour', 'minute', 'second', 'type', 'switch'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'update'],
            [['id'], 'integer', 'on' => 'update'],
            [['command'], 'trim', 'on' => 'update'],
            [['command'], 'string', 'on' => 'update'],
            [['type', 'switch'], 'in', 'range' => [1, 2], 'on' => 'update'],
            [['year'], 'integer', 'min' => 0, 'max' => 9999, 'on' => 'update'],
            [['month'], 'integer', 'min' => 0, 'max' => 12, 'on' => 'update'],
            [['day'], 'integer', 'min' => 0, 'max' => 31, 'on' => 'update'],
            [['hour'], 'integer', 'min' => 0, 'max' => 24, 'on' => 'update'],
            [['minute'], 'integer', 'min' => 0, 'max' => 59, 'on' => 'update'],
            [['second'], 'integer', 'min' => 0, 'max' => 59, 'on' => 'update'],
            [['id'], 'exist', 'targetClass' => Task::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'update'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'update' => [
                'id',
                'command',
                'type',
                'year',
                'month',
                'day',
                'hour',
                'minute',
                'second',
                'switch'
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
            'id' => Yii::t('app\attribute', 'id'),
            'command' => Yii::t('app\attribute', 'command'),
            'type' => Yii::t('app\attribute', 'type'),
            'year' => Yii::t('app\attribute', 'year'),
            'month' => Yii::t('app\attribute', 'month'),
            'day' => Yii::t('app\attribute', 'day'),
            'hour' => Yii::t('app\attribute', 'hour'),
            'minute' => Yii::t('app\attribute', 'minute'),
            'second' => Yii::t('app\attribute', 'second'),
            'switch' => Yii::t('app\attribute', 'switch'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 修改数据
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function update($param)
    {
        $form = new TaskUpdateForm();
        $form->setScenario('update');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            $data = $form->getAttributes();
            try {
                $model = Task::findOne($data['id']);
                $model->setScenario('update');
                $model->load([$model->formName() => $data]);
                $model->save();
            } catch (\yii\db\Exception $e) {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
        throw new HttpException(200, Yii::t('app/success', 'data update successfully'));
    }
}