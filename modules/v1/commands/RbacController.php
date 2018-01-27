<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/21 0021
 * Time: 下午 14:02
 */
namespace v1\commands;

use app\components\AppRoutes;
use v1\commands\rules\OrdinaryUserRule;
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
     * 初始化的权限
     * @var array
     */
    private static $roles = [
        // 普通用户
        'ordinaryUser' => [
            // 拥有的权限
            'permissions' => [
                '/v1/*',
                '/v1/site/*',
                '/v1/site/captcha',
                '/v1/user-copy/*',
                '/v1/user-copy/create',
                '/v1/user-copy/index',
                '/v1/user-copy/view',
            ]
        ]
    ];

    /**
     * yii rbac/init
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        // 删除所有已有权限相关数据
        $auth->removeAll();

        // 获取项目所有权限
        $appRoutes = new AppRoutes();
        $appRoutes = $appRoutes->getAppRoutes(self::$mod);
        foreach ($appRoutes as $key => $value) {
            $permission = $auth->createPermission($value);
            $permission->description = $value;
            $auth->add($permission);
        }

        // 添加所有角色
        $roles = static::$roles;
        foreach ($roles as $key => $value) {
            $name = $key;
            $role = $auth->createRole($name);
            $auth->add($role);
            // 赋予角色权限
            $permissions = $value['permissions'];
            foreach ($permissions as $k => $v) {
                $permission = $auth->getPermission($v);
                $auth->addChild($role, $permission);
            }
        }

        // 将普通角色赋给 id等于1的用户
        // $auth->assign($ordinaryUser, 1);
        $this->stdout(Yii::t('app\success', 'permission initialization is complete') . "\n", Console::BG_GREEN);
    }
}