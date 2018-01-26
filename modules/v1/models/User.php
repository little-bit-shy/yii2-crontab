<?php

namespace v1\models;

use v1\models\redis\RateLimit;
use Yii;
use yii\filters\RateLimitInterface;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\Link;
use yii\web\Linkable;

/**
 * 以下为测试数据
 * CREATE TABLE `yii2_user` (
 * `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
 * `phone` char(12) DEFAULT NULL COMMENT '手机',
 * `username` varchar(255) DEFAULT NULL COMMENT '用户名',
 * `head` varchar(255) DEFAULT NULL COMMENT '头像',
 * `access_token` varchar(255) DEFAULT NULL COMMENT 'access-token',
 * `auth_key` varchar(32) DEFAULT NULL COMMENT '自动登录key',
 * `password_hash` varchar(255) DEFAULT NULL COMMENT '加密密码',
 * `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
 * `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
 * `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
 * `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
 * `last_login_ip` char(20) DEFAULT NULL COMMENT '最近登录ip',
 * `last_login_at` int(11) DEFAULT NULL COMMENT '最近登陆时间',
 * `oauth2` varchar(255) DEFAULT 'self' COMMENT 'oauth2',
 * `oauth2_id` int(11) DEFAULT NULL COMMENT 'oauth2_id',
 * PRIMARY KEY (`id`),
 * UNIQUE KEY `yii2restful_yii2_user_oauth2_oauth2_id` (`oauth2`,`oauth2_id`) USING BTREE COMMENT 'oauth2唯一索引',
 * UNIQUE KEY `yii2restful_yii2_user_access_token` (`access_token`) USING BTREE COMMENT 'access_token',
 * UNIQUE KEY `yii2restful_yii2_user_phone` (`phone`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='用户表';
 *
 * INSERT INTO `yii2_user` VALUES (1,'1','root','','1','6lgGBSosfvH0c9_nZZP8DY6YiI4ycwDx','$2y$13$Gmkbp4uYHbUivaxE7x3M0.LRzJUiDMKWCWUAKD763S/vbzJeIt8xe',NULL,'1533356676@qq.com',1479371680,1479371680,NULL,NULL,'self',NULL),(2,'2','admin',NULL,'2','pA7DChvN6X22MWjc6W_9TYALKiduyftD','$2y$13$gqyTZRup/.lisGkogBT5benIucbEZ4yweD11JKWjHASA4hl9a7oau',NULL,'3095764452@qq.com',1479371663,1479371680,NULL,NULL,'self',NULL),(9,'','little-bit-shy','https://avatars.githubusercontent.com/u/12792446?v=3','9',NULL,NULL,NULL,NULL,1484897023,1479371680,NULL,NULL,'github',12792446),(10,'15918793994',NULL,NULL,'y0gZlbBXGxOo4K--4_4jDNa_Byw2I-8V',NULL,'$2y$13$MpWF3HZWwe1CrcvpbwDLR.k2bRnr9VyvKCPYGaNjv8..S8Z.rkliS',NULL,NULL,1485158903,1485158903,'127.0.0.1',1485160819,'self',NULL),(12,'15918793991','fUrXC2rT',NULL,'6l4nL9fP7X7EXTw5ecedHjUhH9Kv12iv',NULL,'$2y$13$nLc17UBNeDhaRu5bFnJr8uAh2vyOt1/xYMmIVAuUNeLVmose7MkKm',NULL,NULL,1485160893,1485160893,NULL,NULL,'self',NULL),(13,'15918793992','mK0wLev6',NULL,'inORraxmoIqYOaaDL9qe6MqBZaf-C9Pl',NULL,'$2y$13$HghCFt1JWLsduv5bLQ13w.z/6W3Fzgz70qmgypNEFKlJH9P8b3xOy',NULL,NULL,1485161033,1485161033,NULL,NULL,'self',NULL),(14,'15918793993','BWko4Fiu',NULL,'0SqyoC7enijE3sDlTAVy1jmP8D9Krb2P',NULL,'$2y$13$fAbDXAo6MJ/uGCPeUcdExeQDQvZBYlCsfa23UUkS8lzv3/NufI2Lm',NULL,NULL,1485161050,1485161050,NULL,NULL,'self',NULL);
 *
 * Class User
 * @package v1\models
 */
class User extends ActiveRecord implements Linkable, IdentityInterface, RateLimitInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * 资源类通过实现yii\web\Linkable 接口来支持HATEOAS，
     * 该接口包含方法 yii\web\Linkable::getLinks() 来返回 yii\web\Link 列表，
     * 典型情况下应返回包含代表本资源对象URL的 self 链接
     * @return array
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['user/view', 'id' => $this->id], true),
        ];
    }

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/

    /***************************** 登陆相关 *********************************/

    public static function findIdentity($id)
    {
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::getDb()->cache(function ($db) use ($token) {
            return User::findOne(['access_token' => $token]);
        }, self::$dataTimeOut);
        return $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
    }

    /**
     * 密码验证
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /***************************** 请求频率 *********************************/

    /**
     * getRateLimit(): 返回允许的请求的最大数目及时间，例如，[100, 600] 表示在600秒内最多100次的API调用。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function getRateLimit($request, $action)
    {
        return [RateLimit::$rateLimit, RateLimit::$second];// $rateLimit requests per second
    }

    /**
     * loadAllowance(): 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function loadAllowance($request, $action)
    {
        $id = \Yii::$app->getUser()->getId();//获取当前登录用户id
        $uniqueId = $action->getUniqueId();
        $rateLimit = RateLimit::find()->where([
            'id' => $id,
            'unique_id' => $uniqueId,
        ])->one();//获取当前登录用户Api请求频率相关数据

        if ($rateLimit == null) {
            // 当redis不存在数据时
            return [RateLimit::$rateLimit, time()];
        } else {
            return [$rateLimit->allowance, $rateLimit->allowance_updated_at];
        }
    }

    /**
     * saveAllowance(): 保存允许剩余的请求数和当前的UNIX时间戳。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $id = Yii::$app->getUser()->getId();
        $uniqueId = $action->getUniqueId();

        //更新当前登录用户Api请求频率相关数据
        $rateLimit = new RateLimit();
        $rateLimit->setScenario('saveAllowance');
        $rateLimit->load([$rateLimit->formName() => [
            'id' => $id,
            'unique_id' => $uniqueId,
            'allowance' => $allowance,
            'allowance_updated_at' => $timestamp,
        ]]);
        $rateLimit->save();
    }
}
