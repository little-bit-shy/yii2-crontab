<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 权限、角色数据相关控制器
 */

namespace v1\controllers;

use app\components\AppRoutes;
use v1\models\form\rbac\AuthItemIndexForm;
use Yii;
use yii\filters\auth\QueryParamAuth;

class AuthItemController extends Controller
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
            'optional' => ['all-lists', 'project-directory']
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
            'all-lists' => ['POST'],
            'project-directory' => ['GET', 'POST'],
        ];
    }

    /**
     * 返回所有列表数据
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllLists()
    {
        return AuthItemIndexForm::allLists(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回项目目录列表数据
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionProjectDirectory()
    {
        return (new AppRoutes())->getAppRoutes();
    }
}