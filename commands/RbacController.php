<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/21 0021
 * Time: 下午 14:02
 */
namespace app\commands;

use app\components\AppRoutes;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class RbacController
 * rbac 权限管理初始化
 * @package app\commands
 */
class RbacController extends Controller
{
    // 权限初始化需要遍历的模块
    private static $mod = 'v1';

    /**
     * yii rbac/init
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        // 删除所有已有权限相关数据
        $auth->removeAll();

        // 添加 "ordinary_user" 角色，普通用户
        $ordinaryUser = $auth->createRole('ordinaryUser');
        $auth->add($ordinaryUser);

        // 获取项目所有 actions
        $appRoutes = new AppRoutes();
        $appRoutes = $appRoutes->getAppRoutes(self::$mod);
        foreach ($appRoutes as $key => $value) {
            // 添加权限
            $permission = $auth->createPermission($value);
            $permission->description = $value;
            $auth->add($permission);
            // 将权限赋给 "ordinary_user" 角色
            $auth->addChild($ordinaryUser, $permission);
        }

        // 将普通角色赋给 id等于1的用户
        // $auth->assign($ordinaryUser, 1);
        $this->stdout(Yii::t('app\success', 'permission initialization is complete') ."\n", Console::BG_GREEN);
    }
}