<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\task;

use app\components\LikeValidator;
use app\components\ParseCrontab;
use v1\models\form\Model;
use v1\models\task\Task;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class TaskIndexForm
 * @package v1\models\form
 */
class TaskIndexForm extends Model
{
    public $name;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'index'],
            [['name'], 'trim', 'on' => 'index'],
            [['name'], 'string', 'on' => 'index'],
            [['name'], LikeValidator::className(), 'skipOnEmpty' => true, 'on' => 'index'],
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
                'name',
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
        $form = new TaskIndexForm();
        $form->setScenario('index');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            $attributes = $form->getAttributes();
            return Task::lists($attributes);
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
    }
}