<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: Restfuk风格Api控制器
 */

namespace v1\controllers;

use v1\models\form\task\TaskCreateForm;
use v1\models\form\task\TaskUpdateForm;
use v1\models\task\Task;
use Yii;
use yii\filters\auth\QueryParamAuth;

/**
 * Class TaskController
 * @package v1\controllers
 */
class TaskController extends Controller
{
    /**
     * 定义相关行为
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'optional' => [
            ]
        ];
        return $behaviors;
    }

    /**
     * 访问方法设置
     * @return array
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'POST', 'HEAD'],
            'view' => ['GET', 'POST', 'HEAD'],
            'create' => ['POST'],
        ];
    }

    /**
     * 返回列表数据
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return Task::lists();
    }


    /**
     * 返回详细数据
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return Task::detail($id);
    }

    /**
     * 添加数据
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        return TaskCreateForm::create(Yii::$app->request->getBodyParams());
    }

    /**
     * 修改数据
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionUpdate()
    {
        return TaskUpdateForm::update(Yii::$app->request->getBodyParams());
    }
}