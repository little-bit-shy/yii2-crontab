<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\rbac;

use v1\models\ActiveRecord;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * CREATE TABLE `yii2_auth_assignment` (
 * `item_name` varchar(64) NOT NULL,
 * `user_id` varchar(64) NOT NULL,
 * `created_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`item_name`,`user_id`),
 * KEY `auth_assignment_user_id_idx` (`user_id`),
 * CONSTRAINT `yii2_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 *
 * Class AuthAssignment
 * @package v1\models\rbac
 */
class AuthAssignment extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id', 'created_at'], 'safe'],
        ];
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
            Link::REL_SELF => Url::to(['auth-assignment/view', 'user_id' => $this->name], true),
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return parent::fields();
    }

    /**
     * 一般extraFields() 主要用于指定哪些值为对象的字段
     * url上加expand参数获取
     * @return array
     */
    public function extraFields()
    {
        return parent::extraFields();
    }

    /***************************** 触发事件 *********************************/

    /***************************** 关联数据 *********************************/

    /***************************** 增删改查 *********************************/
}
