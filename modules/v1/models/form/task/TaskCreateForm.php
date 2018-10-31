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
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskCreateForm
 * @package v1\models\form
 */
class TaskCreateForm extends Model
{
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
            [['command', 'type', 'year', 'month', 'day', 'hour', 'minute', 'second', 'switch'], 'safe', 'on' => 'create'],
            [['command', 'year', 'month', 'day', 'hour', 'minute', 'second'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'create'],
            [['command'], 'trim', 'on' => 'create'],
            [['command'], 'string', 'on' => 'create'],
            [['type', 'switch'], 'default', 'value' => 1, 'on' => 'create'],
            [['type', 'switch'], 'in', 'range' => [1, 2], 'on' => 'create'],
            [['year'], 'integer', 'min' => 0, 'max' => 9999, 'on' => 'create'],
            [['month'], 'integer', 'min' => 0, 'max' => 12, 'on' => 'create'],
            [['day'], 'integer', 'min' => 0, 'max' => 31, 'on' => 'create'],
            [['hour'], 'integer', 'min' => 0, 'max' => 24, 'on' => 'create'],
            [['minute'], 'integer', 'min' => 0, 'max' => 59, 'on' => 'create'],
            [['second'], 'integer', 'min' => 0, 'max' => 59, 'on' => 'create'],
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
     * 添加数据
     * @param $param
     * @throws HttpException
     * @throws \yii\base\InvalidConfigException
     */
    public static function create($param)
    {
        $form = new TaskCreateForm();
        $form->setScenario('create');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            try {
                $date = date('Y-m-d H:i:s');
                $model = new Task();
                $model->setScenario('create');
                $model->load([$model->formName() => ArrayHelper::merge($form->getAttributes(), [
                    'create_time' => $date,
                    'update_time' => $date
                ])]);
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