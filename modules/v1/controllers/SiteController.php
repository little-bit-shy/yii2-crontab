<?php

namespace v1\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use yii\rest\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
            'captcha' => [
                'class' => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

}
