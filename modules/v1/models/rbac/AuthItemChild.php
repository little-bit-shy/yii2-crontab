<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\rbac;

use v1\models\ActiveRecord;
use yii\caching\TagDependency;
use Yii;
use yii\db\Exception;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * CREATE TABLE `yii2_auth_item_child` (
 * `parent` varchar(64) NOT NULL,
 * `child` varchar(64) NOT NULL,
 * PRIMARY KEY (`parent`,`child`),
 * KEY `child` (`child`),
 * CONSTRAINT `yii2_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
 * CONSTRAINT `yii2_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yii2_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 *
 * Class AuthItemChild
 * @package v1\models\rbac
 */
class AuthItemChild extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%auth_item_child}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'safe'],
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
            Link::REL_SELF => Url::to(['auth-item-child/view', 'name' => $this->name], true),
        ];
    }

    /**
     * 缓存依赖清除
     * @return bool
     */
    public function tagDependencyInvalidate()
    {
        try {
            // 数据
            $parent = $this->getAttribute('parent');
            // 详细数据缓存清除
            TagDependency::invalidate(Yii::$app->getCache(), [self::getDetailTag("/parent/{$parent}")]);
        } catch (Exception $e) {
            return false;
        }
        return parent::tagDependencyInvalidate();
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

    /**
     * 判断是否已存在该数据
     * @param bool $cache
     * @param $parent
     * @param $child
     * @return bool|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function exists($cache = false, $parent, $child)
    {
        switch ($cache) {
            case true: // 使用缓存
                return ActiveRecord::getDb()->cache(function ($db) use ($parent, $child) {
                    return self::getExists($parent, $child);
                }, AuthAssignment::$dataTimeOut, new TagDependency(['tags' => [AuthAssignment::getListTag("")]]));
                break;
            case false: // 不使用缓存
                return self::getExists($parent, $child);
                break;
        }
    }

    /**
     * 判断是否已存在该数据
     * @param $parent
     * @param $child
     * @return bool
     */
    private static function getExists($parent, $child)
    {
        return AuthItemChild::find()->where([
            'parent' => $parent,
            'child' => $child,
        ])->exists();
    }
}
