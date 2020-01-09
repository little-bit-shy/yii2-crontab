<?php

namespace v1\models\task;

use v1\models\ActiveRecord;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * CREATE TABLE `yii2_task` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
 * `command` text NOT NULL COMMENT '需要执行的命令',
 * `name` varchar(255) DEFAULT NULL COMMENT '备注',
 * `rule` varchar(30) DEFAULT NULL COMMENT '规则',
 * `switch` enum('1','2') NOT NULL DEFAULT '1' COMMENT '开关 1/开 2/关',
 * `create_time` datetime DEFAULT NULL COMMENT '数据创建时间',
 * `update_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '数据修改时间',
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
 *
 * Class Task
 * @package v1\models\task
 */
class Task extends ActiveRecord implements Linkable
{
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'command', 'rule', 'switch', 'create_time', 'update_time'], 'safe', 'on' => 'create'],
            [['name', 'command', 'rule', 'switch'], 'safe', 'on' => 'update'],
        ];
    }

    /**
     * 验证场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => ['name', 'command', 'rule', 'create_time', 'update_time', 'switch'],
            'update' => ['name', 'command', 'rule', 'switch'],
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
            Link::REL_SELF => Url::to(['task/view', 'id' => $this->id], true),
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

    /**
     * 获取详细信息
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public static function detail($id)
    {
        $data = ActiveRecord::getDb()->cache(function ($db) use ($id) {
            $query = Task::find()->where(['id' => $id]);
            return $query->one();
        }, Task::$dataTimeOut, new TagDependency(['tags' => [Task::getIdDetailTag($id)]]));

        if (empty($data)) {
            // 数据不存在
            throw new NotFoundHttpException();
        } else {
            return $data;
        }
    }

    /**
     * 获取列表数据
     * @return ActiveDataProvider
     */
    public static function lists($param)
    {
        $activeDataProvider = ActiveRecord::getDb()->cache(function ($db) use ($param) {
            $query = Task::find();

            $query->andFilterWhere(['like', 'name', $param['name'], false]);
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $query->count()
            ]);
            $data = $query->offset($pagination->getOffset())
                ->limit($pagination->getLimit())
                ->all();
            return new ArrayDataProvider([
                'models' => $data,
                'Pagination' => $pagination,
            ]);
        }, Task::$dataTimeOut, new TagDependency(['tags' => [Task::getListTag("")]]));

        return $activeDataProvider;
    }

    /**
     * 删除数据
     * @param $id
     * @throws \Exception
     * @throws \Throwable
     */
    public static function remove($id)
    {
        self::findOne($id)->delete();
    }
}
