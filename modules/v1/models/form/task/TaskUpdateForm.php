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
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskUpdateForm
 * @package v1\models\form
 */
class TaskUpdateForm extends Model
{
    public $id;
    public $name;
    public $command;
    public $rule;
    public $switch;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'name', 'command', 'rule', 'switch'], 'safe', 'on' => 'update'],
            [['id', 'name', 'command', 'rule', 'switch'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'update'],
            [['id'], 'integer', 'on' => 'update'],
            [['name', 'command'], 'trim', 'on' => 'update'],
            [['name', 'command', 'rule'], 'string', 'on' => 'update'],
            [['switch'], 'in', 'range' => [1, 2], 'on' => 'update'],
            [['rule'], 'validateRule', 'on' => 'update'],
            [['id'], 'exist', 'targetClass' => Task::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'update'],
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
            'update' => [
                'id',
                'name',
                'command',
                'rule',
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
            'name' => Yii::t('app\attribute', 'name'),
            'command' => Yii::t('app\attribute', 'command'),
            'rule' => Yii::t('app\attribute', 'rule'),
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