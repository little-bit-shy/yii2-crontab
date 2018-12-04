<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/3/5
 * Time: 10:18
 */

namespace v1\rules;

use yii\rbac\Rule;
use Yii;

/**
 * 事例
 * 检查 用户ID 是否和通过参数传进来的 user 参数相符
 */
class IsUserRule extends Rule
{
    public $name = 'isUser';

    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {
        return true;
    }
}