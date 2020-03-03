<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\task;

use app\components\ParseCrontab;
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
    public $name;
    public $command;
    public $rule;
    public $switch;
    public $type;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'command', 'rule', 'switch', 'type'], 'safe', 'on' => 'create'],
            [['name', 'command', 'rule'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'create'],
            [['name', 'command'], 'trim', 'on' => 'create'],
            [['name', 'command'], 'string', 'on' => 'create'],
            [['switch'], 'default', 'value' => 1, 'on' => 'create'],
            [['switch'], 'in', 'range' => [1, 2], 'on' => 'create'],
            [['type'], 'default', 'value' => 1, 'on' => 'create'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'create'],
            [['rule'], 'string', 'on' => 'create'],
            [['rule'], 'validateRule', 'on' => 'create'],
        ];
    }

    /**
     * 验证规则是否合法
     * @param $attribute
     * @param $params
     */
    public function validateRule($attribute, $params)
    {
        if (ParseCrontab::parse($this->$attribute) === false) {
            $this->addError($attribute, Yii::t('app/error', 'rule error'));
        };
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => [
                'name',
                'command',
                'rule',
                'switch',
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
            'name' => Yii::t('app\attribute', 'name'),
            'command' => Yii::t('app\attribute', 'command'),
            'type' => Yii::t('app\attribute', 'type'),
            'rule' => Yii::t('app\attribute', 'rule'),
            'switch' => Yii::t('app\attribute', 'switch'),
            'type' => Yii::t('app\attribute', 'type'),
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