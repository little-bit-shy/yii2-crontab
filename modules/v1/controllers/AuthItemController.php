<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 权限、角色数据相关控制器
 */

namespace v1\controllers;

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
            'index' => ['POST'],
        ];
    }

    /**
     * 返回列表数据
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        return AuthItemIndexForm::lists(Yii::$app->request->getBodyParams());
    }
}