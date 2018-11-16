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
 * Class TaskDeleteForm
 * @package v1\models\form
 */
class TaskDeleteForm extends Model
{
    public $id;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['id'], 'safe', 'on' => 'delete'],
            [['id'], 'required', 'message' => '{attribute}' . Yii::t('app\error', 'not null'), 'on' => 'delete'],
            [['id'], 'integer', 'on' => 'delete'],
            [['id'], 'exist', 'targetClass' => Task::className(), 'targetAttribute' => ['id' => 'id'], 'on' => 'delete'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'delete' => [
                'id',
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
        ];
    }

    /***************************** 表单操作 *********************************/

    /**
     * 删除数据
     * @param $param
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function delete($param)
    {
        $form = new TaskDeleteForm();
        $form->setScenario('delete');
        if ($form->load([$form->formName() => $param]) && $form->validate()) {
            try {
                $data = $form->getAttributes();
                Task::remove($data['id']);
            } catch (\yii\db\Exception $e) {
                throw new HttpException(500, Yii::t('app/error', 'server internal error'));
            }
        } else {
            throw new HttpException(422, $form->getFirstError());
        }
        throw new HttpException(200, Yii::t('app/success', 'data delete successfully'));
    }
}