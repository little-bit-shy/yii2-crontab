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
use v1\models\UserCopy;
use Yii;
use yii\filters\auth\QueryParamAuth;

class UserCopyController extends Controller
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
            'optional' => ['index']
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
            'create' => ['POST'],
        ];
    }

    /**
     * 返回列表数据
     * @return \yii\data\ActiveDataProvider
     */
    public function actionIndex()
    {
        return UserCopy::lists();
    }


    /**
     * 返回详细数据
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        return UserCopy::detail($id);
    }

    /**
     * 添加数据
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionCreate()
    {
        UserCopy::create(Yii::$app->request->getBodyParams());
        return self::success(Yii::t('app/success', 'data added successfully'));
    }
}