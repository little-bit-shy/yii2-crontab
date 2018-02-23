<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/17
 * Time: 14:29
 * Message: 控制器基类
 */

namespace v1\controllers;

use v1\models\ActiveRecord;
use v1\models\rbac\AuthItem;
use Yii;
use yii\base\InlineAction;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

/**
 * Yii 提供两个控制器基类来简化创建RESTful 操作的工作: yii\rest\Controller 和 yii\rest\ActiveController，
 * 两个类的差别是后者提供一系列将资源处理成Active Record 的操作。
 * 因此如果使用Active Record 内置的操作会比较方便，
 * 可考虑将控制器类继承yii\rest\ActiveController，
 * 它会让你用最少的代码完成强大的RESTful APIs.
 *
 * Class Controller
 * @package v1\controllers
 */
class Controller extends \yii\rest\Controller
{
    /**
     * 有时你可能想通过直接在响应主体内包含分页信息来简化客户端的开发工作。
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge([
            //开启Cors跨域
            'corsFilter' => [
                'class' => Cors::className(),
            ]
        ], parent::behaviors());

        //为使用HTTP Basic Auth，可配置authenticator 行为
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'optional' => []
        ];

        //如果你系那个支持以上3个认证方式，可以使用CompositeAuth
        //authMethods 中每个单元应为一个认证方法名或配置数组。
        //findIdentityByAccessToken()方法的实现是系统定义的，
        //例如，一个简单的场景，当每个用户只有一个access token,
        //可存储access token 到user表的access_token列中， 方法可在User类中简单实现
        //在上述认证启用后，对于每个API请求，请求控制器都会在它的beforeAction() 步骤中对用户进行认证。
        //如果认证成功，控制器再执行其他检查(如频率限制，操作权限)，然后再执行操作， 授权用户信息可使用Yii::$app->user->identity获取.
        //如果认证失败，会发送一个HTTP状态码为401的响应，并带有其他相关信息头 (如HTTP 基本认证会有WWW-Authenticate 头信息).
        //$behaviors['authenticator'] = [
        //    'class' => CompositeAuth::className(),
        //    'authMethods' => [
        //        HttpBasicAuth::className(),
        //        HttpBearerAuth::className(),
        //        QueryParamAuth::className(),
        //    ],
        //];

        //前提是开启了用户验证
        //一旦 identity 实现所需的接口，
        // Yii 会自动使用 yii\filters\RateLimiter为 yii\rest\Controller 配置一个行为过滤器来执行速率限制检查。
        //当速率限制被激活，默认情况下每个响应将包含以下 HTTP 头发送目前的速率限制信息：
        //X-Rate-Limit-Limit: 同一个时间段所允许的请求的最大数目;
        //X-Rate-Limit-Remaining: 在当前时间段内剩余的请求的数量;
        //X-Rate-Limit-Reset: 为了得到最大请求数所等待的秒数。
        //你可以禁用这些头信息通过配置 yii\filters\RateLimiter::enableRateLimitHeaders 为 false, 就像在上面的代码示例所示。
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];

        //rbac权限验证
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'matchCallback' => function ($rule, InlineAction $action) {
                        // 游客登录不验证权限
                        if (Yii::$app->getUser()->getIsGuest()) {
                            return true;
                        }
                        // 权限验证
                        $uniqueId = '/' . $action->getUniqueId();
                        $can = ActiveRecord::getDb()->cache(function ($db) use ($uniqueId) {
                            return Yii::$app->getUser()->can($uniqueId);
                        }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag()]]));
                        return $can;
                    }
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * 自定义操作
     * yii\rest\ActiveController 默认提供一下操作:
     * yii\rest\IndexAction: 按页列出资源;
     * yii\rest\ViewAction: 返回指定资源的详情;
     * yii\rest\CreateAction: 创建新的资源;
     * yii\rest\UpdateAction: 更新一个存在的资源;
     * yii\rest\DeleteAction: 删除指定的资源;
     * yii\rest\OptionsAction: 返回支持的HTTP方法.
     * 所有这些操作通过yii\rest\ActiveController::actions() 方法申明，可覆盖actions()方法配置或禁用这些操作
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }
}
