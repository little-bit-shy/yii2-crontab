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

use yii\filters\Cors;
use yii\web\Response;

use v1\models\User;
use yii\data\ActiveDataProvider;

use yii\filters\RateLimiter;
use yii\rest\Controller;
use yii\web\HttpException;

class UserController extends Controller
{
    //(当Controller继承于ActiveController时可使用)
    //public $modelClass = 'v1\models\User';

    /**
     * 有时你可能想通过直接在响应主体内包含分页信息来简化客户端的开发工作。
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //为使用HTTP Basic Auth，可配置authenticator 行为
        //$behaviors['authenticator'] = [
        //   'class' => HttpBasicAuth::className(),
        //];
        //如果你系那个支持以上3个认证方式，可以使用CompositeAuth
        //authMethods 中每个单元应为一个认证方法名或配置数组。
        //findIdentityByAccessToken()方法的实现是系统定义的，
        //例如，一个简单的场景，当每个用户只有一个access token,
        //可存储access token 到user表的access_token列中， 方法可在User类中简单实现
        //在上述认证启用后，对于每个API请求，请求控制器都会在它的beforeAction() 步骤中对用户进行认证。
        //如果认证成功，控制器再执行其他检查(如频率限制，操作权限)，然后再执行操作， 授权用户信息可使用Yii::$app->user->identity获取.
        //如果认证失败，会发送一个HTTP状态码为401的响应，并带有其他相关信息头 (如HTTP 基本认证会有WWW-Authenticate 头信息).
        /*$behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];*/

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

        //开启Cors跨域
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
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

    /**
     * 为"index"操作准备和返回数据provider
     */
    public function actionIndex()
    {
        return User::lists();
    }


    /**
     * 创建控制器类
     * 创建新的操作和Web应用中创建操作类似，
     * 唯一的差别是Web应用中 调用render()方法渲染一个视图作为返回值，
     * 对于RESTful操作 直接返回数据，
     * yii\rest\Controller::serializer 和 yii\web\Response 会处理原始数据到请求格式的转换
     * @param $id
     * @return static
     */
    public function actionView($id)
    {
        return User::detail($id);
    }
}