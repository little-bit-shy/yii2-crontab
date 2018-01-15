<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 重写QueryParamAuth验证器
 */

namespace v1\common\rewrite\yii2\filters\auth;

use Yii;
use yii\filters\auth\AuthMethod;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;

/**
 * access-token 验证
 */
class QueryParamAuth extends AuthMethod
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'access-token';

    /**
     * authenticator验证场景
     * 需要开启authenticator验证的action
     * @var array
     */
    public $authenticatorActions = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $response = $this->response ?: Yii::$app->getResponse();

        // 判断当前场景是否需要参与验证
        if (!ArrayHelper::isIn($action->id, $this->authenticatorActions)) {
            return true;
        }

        try {
            $identity = $this->authenticate(
                $this->user ?: Yii::$app->getUser(),
                $this->request ?: Yii::$app->getRequest(),
                $response
            );
        } catch (UnauthorizedHttpException $e) {
            if ($this->isOptional($action)) {
                return true;
            }

            throw $e;
        }

        if ($identity !== null || $this->isOptional($action)) {
            return true;
        }

        $this->challenge($response);
        $this->handleFailure($response);

        return false;
    }

    /**
     * @inheritdoc
     */
    public
    function authenticate($user, $request, $response)
    {
        $accessToken = $request->get($this->tokenParam);
        if (is_string($accessToken)) {
            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
}
