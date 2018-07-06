<?php
/**
 * Created by PhpStorm.
 * User: xuguozhi
 * Date: 2017/1/18
 * Time: 14:57
 * Message: Api调用频率相关数据模型（居于Redis实现）
 */

namespace v1\models\redis;

/**
 * Class RateLimit
 * @package v1\models\redis
 */
class RateLimit extends ActiveRecord
{
    //Api在 $second 秒内能请求 $rateLimit 次
    public static $rateLimit = 100;
    public static $second = 1;

    public static function primaryKey()
    {
        return ['id', 'unique_id'];
    }

    /**
     * 一定要确保你有一个id属性定义，如果你不指定自己的主键
     * @return array
     */
    public function attributes()
    {
        return ['id', 'unique_id', 'allowance', 'allowance_updated_at'];
    }

    /**
     * 验证器
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'unique_id', 'allowance', 'allowance_updated_at'], 'safe'],
        ];
    }

    /***************************** 增删改查 *********************************/

    /**
     * 获取当前登录用户Api请求频率相关数据
     * @param $id
     * @param $uniqueId
     * @return array|null|\yii\redis\ActiveRecord
     */
    public static function one($id, $uniqueId)
    {
        return RateLimit::find()->where([
            'id' => $id,
            'unique_id' => $uniqueId,
        ])->one();
    }

    /**
     * 更新当前登录用户Api请求频率相关数据
     * @param $id
     * @param $uniqueId
     * @param $allowance
     * @param $timestamp
     * @throws \yii\base\InvalidConfigException
     */
    public static function saveAllowance($id, $uniqueId, $allowance, $timestamp)
    {
        $rateLimit = new RateLimit();
        $rateLimit->load([$rateLimit->formName() => [
            'id' => $id,
            'unique_id' => $uniqueId,
            'allowance' => $allowance,
            'allowance_updated_at' => $timestamp,
        ]]);
        $rateLimit->save();
    }
}