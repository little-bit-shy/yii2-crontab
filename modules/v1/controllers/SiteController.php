<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 用户登录相关操作控制器
 */

namespace v1\controllers;

use v1\models\form\user\LoginForm;
use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\auth\QueryParamAuth;

class SiteController extends Controller
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
            'optional' => ['captcha', 'login']
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
            'captcha' => ['GET', 'POST'],
            'login' => ['POST'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $loginForm = new  LoginForm();
        return $loginForm->login(Yii::$app->request->getBodyParams());
    }
}
