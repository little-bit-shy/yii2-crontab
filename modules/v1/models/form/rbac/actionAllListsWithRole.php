<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form\rbac;

use app\components\ArrayHelper;
use v1\models\ActiveRecord;
use v1\models\form\Model;
use v1\models\rbac\AuthItem;
use Yii;
use yii\caching\TagDependency;
use yii\helpers\StringHelper;
use yii\web\HttpException;

/**
 * 表单模型
 * Class actionAllListsWithRole
 * @package v1\models\form\rbac
 */
class ActionAllListsWithRole extends Model
{
    public $name;
    public $user;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe', 'on' => 'all-lists-with-role'],
            [['name'], 'required', 'on' => 'all-lists-with-role'],
            [['name'], 'string', 'on' => 'all-lists-with-role'],
            [['name'], 'trim', 'on' => 'all-lists-with-role'],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'all-lists-with-role' => [
                'name',
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
            'name' => Yii::t('app\attribute', 'name'),
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
    public static function allListsWithRole($param)
    {
        // 表单模型实例化
        $actionAllListsWithRole = new ActionAllListsWithRole();
        // 场景定义
        $actionAllListsWithRole->setScenario('all-lists-with-role');
        // 验证数据是否合法
        if ($actionAllListsWithRole->load([$actionAllListsWithRole->formName() => $param]) && $actionAllListsWithRole->validate()) {
            // 数据合法
            // 过滤后的合法数据
            $attributes = $actionAllListsWithRole->getAttributes();
            $dataProvider = ActiveRecord::getDb()->cache(function ($db) use ($attributes) {
                // 获取数据
                $auth = Yii::$app->getAuthManager();
                $dataProvider = $auth->getPermissionsByRole($attributes['name']);

                // 数据重构（增加层次结构）
                $dataProvider = ArrayHelper::index($dataProvider, 'name', [function () {
                    return "/*";
                }, function ($authItem) {
                    $explode = StringHelper::explode($authItem->name, '/', true, true);
                    $permission = null;
                    if (isset($explode[1])) {
                        $permission = "/{$explode[0]}/*";
                    }
                    return $permission;
                }, function ($authItem) {
                    $explode = StringHelper::explode($authItem->name, '/', true, true);
                    $permission = null;
                    if (isset($explode[2])) {
                        $permission = "/{$explode[0]}/{$explode[1]}/*";
                    }
                    return $permission;
                }]);

                // 结果数据返回
                return $dataProvider;
            }, ActiveRecord::$dataTimeOut, new TagDependency(['tags' => [AuthItem::getListTag("")]]));

            return $dataProvider;
        } else {
            // 数据不合法
            throw new HttpException(422, $actionAllListsWithRole->getFirstError());
        }
    }
}