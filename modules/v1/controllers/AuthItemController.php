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
use v1\models\form\rbac\AuthItemAddPermissionsForm;
use v1\models\form\rbac\AuthItemAllListsForm;
use v1\models\form\rbac\AuthItemAllListsWithLevelForm;
use v1\models\form\rbac\AuthItemIndexForm;
use v1\models\form\rbac\AuthItemRemovePermissionsForm;
use v1\models\form\rbac\AuthItemUpdatePermissionsForm;
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
            'optional' => [
                'index', 'all-lists', 'project-directory',
                'add-permissions', 'remove-permissions', 'update-permissions',
                'all-lists-with-level'
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
            'index' => ['POST'],
            'all-lists' => ['POST'],
            'project-directory' => ['GET', 'POST'],
            'add-permissions' => ['POST'],
            'remove-permissions' => ['POST'],
            'update-permissions' => ['POST'],
            'all-lists-with-level' => ['POST'],
        ];
    }

    /**
     * 返回列表数据
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        return AuthItemIndexForm::lists(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回所有列表数据
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllLists()
    {
        return AuthItemAllListsForm::allLists(Yii::$app->request->getBodyParams());
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

    /**
     * 添加权限
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddPermissions()
    {
        return AuthItemAddPermissionsForm::addPermissions(Yii::$app->request->getBodyParams());
    }

    /**
     * 删除权限
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionRemovePermissions()
    {
        return AuthItemRemovePermissionsForm::removePermissions(Yii::$app->request->getBodyParams());
    }

    /**添加权限
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionUpdatePermissions()
    {
        return AuthItemUpdatePermissionsForm::updatePermissions(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回所有权限列表数据（数据重构后添加了层次结构）
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithLevel()
    {
        return AuthItemAllListsWithLevelForm::allListsWithLevel(Yii::$app->request->getBodyParams());
    }

}