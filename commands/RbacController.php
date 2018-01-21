<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/21 0021
 * Time: 下午 14:02
 */
namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Class RbacController
 * rbac 权限管理初始化
 * @package app\commands
 */
class RbacController extends Controller
{
    /**
     * yii rbac/init
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        // 删除所有已有权限相关数据
        $auth->removeAll();

        // 添加 "v1/user-copy/create" 权限
        $permission = $auth->createPermission('v1/user-copy/create');
        $permission->description = 'v1/user-copy/create';
        $auth->add($permission);

        // 添加 "ordinary_user" 角色并赋予 "createPost" 权限
        $role = $auth->createRole('ordinaryUser');
        $auth->add($role);
        $auth->addChild($role, $permission);

        $auth->assign($role, 1);
    }
}