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
use v1\models\form\rbac\AuthItemAddRoleForm;
use v1\models\form\rbac\AuthItemAddRolePermissionsForm;
use v1\models\form\rbac\AuthItemAddUserRoleForm;
use v1\models\form\rbac\AuthItemAllListsWithRoleForm;
use v1\models\form\rbac\AuthItemAddPermissionsForm;
use v1\models\form\rbac\AuthItemAllListsForm;
use v1\models\form\rbac\AuthItemAllListsWithLevelForm;
use v1\models\form\rbac\AuthItemAllRoleWithUserForm;
use v1\models\form\rbac\AuthItemDeleteRolePermissionsForm;
use v1\models\form\rbac\AuthItemDeleteUserRoleForm;
use v1\models\form\rbac\AuthItemIndexForm;
use v1\models\form\rbac\AuthItemRemovePermissionsForm;
use v1\models\form\rbac\AuthItemUpdatePermissionsForm;
use v1\models\form\rbac\AuthItemUserListForm;
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
            'optional' => ['add-user-role']
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
            'project-directory' => ['POST'],
            'add-permissions' => ['POST'],
            'remove-permissions' => ['POST'],
            'update-permissions' => ['POST'],
            'all-lists-with-level' => ['POST'],
            'all-lists-with-role' => ['POST'],
            'add-role' => ['POST'],
            'add-role-permissions' => ['POST'],
            'delete-role-permissions' => ['POST'],
            'user-lists' => ['POST'],
            'add-user-role' => ['POST'],
            'delete-user-role' => ['POST'],
            'all-role-with-user' => ['POST'],
        ];
    }

    /**
     * 返回列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        return AuthItemIndexForm::lists(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回所有列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllLists()
    {
        return AuthItemAllListsForm::allLists(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回项目目录列表数据
     * @return array
     */
    public function actionProjectDirectory()
    {
        return (new AppRoutes())->getAppRoutes();
    }

    /**
     * 添加权限
     * @throws \Exception
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

    /**
     * 修改权限
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
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithLevel()
    {
        return AuthItemAllListsWithLevelForm::allListsWithLevel(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回角色下的所有权限列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllListsWithRole()
    {
        return AuthItemAllListsWithRoleForm::allListsWithRole(Yii::$app->request->getBodyParams());
    }

    /**
     * 添加角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddRole()
    {
        return AuthItemAddRoleForm::addRole(Yii::$app->request->getBodyParams());
    }

    /**
     * 为角色添加的权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddRolePermissions()
    {
        return AuthItemAddRolePermissionsForm::addRolePermissions(Yii::$app->request->getBodyParams());
    }

    /**
     * 为角色删除权限
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     *
     */
    public function actionDeleteRolePermissions()
    {
        return AuthItemDeleteRolePermissionsForm::deleteRolePermissions(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回用户列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUserLists()
    {
        return AuthItemUserListForm::lists(Yii::$app->request->getBodyParams());
    }

    /**
     * 为用户分配角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAddUserRole()
    {
        return AuthItemAddUserRoleForm::addUserRole(Yii::$app->request->getBodyParams());
    }

    /**
     * 删除为用户分配的角色
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionDeleteUserRole()
    {
        return AuthItemDeleteUserRoleForm::deleteUserRole(Yii::$app->request->getBodyParams());
    }

    /**
     * 返回用户下的所有角色列表数据
     * @return mixed
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionAllRoleWithUser()
    {
        return AuthItemAllRoleWithUserForm::allRoleWithUser(Yii::$app->request->getBodyParams());
    }
}