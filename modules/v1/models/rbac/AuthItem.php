<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\rbac;

use v1\models\ActiveRecord;
use Yii;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * CREATE TABLE `yii2_auth_item` (
 * `name` varchar(64) NOT NULL,
 * `type` smallint(6) NOT NULL,
 * `description` text,
 * `rule_name` varchar(64) DEFAULT NULL,
 * `data` blob,
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`name`),
 * KEY `rule_name` (`rule_name`),
 * KEY `type` (`type`),
 * CONSTRAINT `yii2_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yii2_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 *
 * Class AuthItem
 * @package v1\models\rbac
 */
class AuthItem extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'type', 'description', 'rule_name', 'data', 'created_at', 'updated_at'], 'safe'],
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
            Link::REL_SELF => Url::to(['auth-item/view', 'name' => $this->name], true),
        ];
    }

    /**
     * 明确列出每个字段，适用于你希望数据表或模型属性
     * url上加fields参数获取
     * @return array
     */
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'data' => function ($model) {
                $data = unserialize($model->data);
                return empty($data) ? null : $data;
            },
            'created_at' => function ($model) {
                return date("Y-m-d H:i:s", $model->created_at);
            },
            'updated_at' => function ($model) {
                return date("Y-m-d H:i:s", $model->updated_at);
            },
        ]);
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
     * 获取列表数据（全部）
     * @param bool $cache
     * @param $type
     * @param $name
     * @return array|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function dataProvider($cache = false, $type, $name)
    {
        switch ($cache) {
            case true: // 使用缓存
                return ActiveRecord::getDb()->cache(function ($db) use ($type, $name) {
                    return self::getDataProvider($type, $name);
                }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag("")]]));
                break;
            case false: // 不使用缓存
                return self::getDataProvider($type, $name);
                break;
        }
    }

    /**
     * 获取列表数据（全部）
     * @param $type
     * @param $name
     * @return array
     */
    private static function getDataProvider($type, $name)
    {
        $query = AuthItem::find();
        // 数据类型过滤
        $query->andFilterWhere(['type' => $type]);
        // 权限、角色名称过滤
        $query->andFilterWhere(['like', 'name', $name]);
        // 结果数据返回
        return $query->all();
    }

    /**
     * 获取列表数据（分页）
     * @param bool $cache
     * @param $type
     * @param $name
     * @return mixed|ArrayDataProvider
     * @throws \Exception
     * @throws \Throwable
     */
    public static function arrayDataProvider($cache = false, $type, $name)
    {
        switch ($cache) {
            case true: // 使用缓存
                return ActiveRecord::getDb()->cache(function ($db) use ($type, $name) {
                    return self::getArrayDataProvider($type, $name);
                }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag("")]]));
                break;
            case false: // 不使用缓存
                return self::getArrayDataProvider($type, $name);
                break;
        }
    }

    /**
     * 获取列表数据（分页）
     * @param $type
     * @param $name
     * @return ArrayDataProvider
     */
    private static function getArrayDataProvider($type, $name)
    {
        $query = AuthItem::find();
        // 数据类型过滤
        $query->andFilterWhere(['type' => $type]);
        // 权限、角色名称过滤
        $query->andFilterWhere(['like', 'name', $name]);
        // 结果数据返回
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count()
        ]);
        $data = $query->offset($pagination->getOffset())
            ->limit($pagination->getLimit())
            ->all();
        return new ArrayDataProvider([
            'models' => $data,
            'Pagination' => $pagination,
        ]);
    }
}
