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

class UserController extends Controller
{
    /**
     * authenticator验证场景
     * 需要开启authenticator验证的action
     * @return array
     */
    public function authenticatorActions()
    {
        return ['index', 'view'];
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