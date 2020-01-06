<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: Restfuk风格Api控制器
 */

namespace v1\controllers;

use v1\models\form\task\ExecuteTaskIndexForm;
use v1\models\task\ExecuteTask;
use Yii;
use yii\filters\auth\QueryParamAuth;

/**
 * Class ExecuteTaskController
 * @package v1\controllers
 */
class ExecuteTaskController extends Controller
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
        ];
    }

    /**
     * 返回列表数据
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return ExecuteTaskIndexForm::lists(Yii::$app->request->getBodyParams());
    }


    /**
     * 返回详细数据
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return ExecuteTask::detail($id);
    }
}