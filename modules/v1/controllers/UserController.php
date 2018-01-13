<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: Restfuk风格Api测试控制器
 */

namespace v1\controllers;

/**
 * Yii 提供两个控制器基类来简化创建RESTful 操作的工作: yii\rest\Controller 和 yii\rest\ActiveController，
 * 两个类的差别是后者提供一系列将资源处理成Active Record 的操作。
 * 因此如果使用Active Record 内置的操作会比较方便，
 * 可考虑将控制器类继承yii\rest\ActiveController，
 * 它会让你用最少的代码完成强大的RESTful APIs.
 */
use Yii;
use v1\models\User;
use yii\web\HttpException;

class UserController extends Controller
{
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
     * 授权(当Controller继承于ActiveController时可使用)
     * 通过RESTful APIs显示数据时，
     * 经常需要检查当前用户是否有权限访问和操作所请求的资源，
     * 在yii\rest\ActiveController中，
     * 可覆盖yii\rest\ActiveController::checkAccess() 方法来完成权限检查。
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws HttpException
     */
    /*public function checkAccess($action, $model = null, $params = [])
    {
        switch ($action) {
            case "index":
                //throw new HttpException(403);
                break;
            case "view":
                //throw new HttpException(403);
                break;
        }
    }*/

    /**
     * 返回列表数据
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return User::lists();
    }


    /**
     * 返回详细数据
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return User::detail($id);
    }
}