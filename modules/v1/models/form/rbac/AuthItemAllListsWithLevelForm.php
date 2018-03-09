<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use Yii;
use yii\caching\TagDependency;
use yii\web\HttpException;

/**
 * 表单模型
 * Class AuthItemAllListsWithLevelForm
 * @package v1\models\form\rbac
 */
class AuthItemAllListsWithLevelForm extends Model
{
    public $type;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['type'], 'safe', 'on' => 'all-lists-with-level'],
            [['type'], 'default', 'value' => 2, 'on' => 'all-lists-with-level'],
            [['type'], 'in', 'range' => [1, 2], 'on' => 'all-lists-with-level'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-lists-with-level' => [
                'type',
            ]
        ];
    }

    /**
     * 属性标签
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'type' => Yii::t('app\attribute', 'type'),
        ];
    }

    /***************************** 表单操作 *********************************/

    /***************************** 获取数据 *********************************/

    /**
     * 返回所有列表数据（数据重构后添加了层次结构）
     * @param $param
     * @return mixed
     * @throws HttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public static function allListsWithLevel($param)
    {
        // 表单模型实例化
        $authItemAllListsWithLevelForm = new AuthItemAllListsWithLevelForm();
        // 场景定义
        $authItemAllListsWithLevelForm->setScenario('all-lists-with-level');
        // 验证数据是否合法
        if ($authItemAllListsWithLevelForm->load([$authItemAllListsWithLevelForm->formName() => $param]) && $authItemAllListsWithLevelForm->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $authItemAllListsWithLevelForm->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                $query = AuthItem::find();
                // 数据类型过滤
                $query->andFilterWhere([
                    'type' => $attributes['type'],
                ]);
                // 获取数据
                $dataProvider = $query->all();
                // 结果数据返回
                return $dataProvider;
            }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag("")]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $authItemAllListsWithLevelForm->getFirstError());
        }
    }
}