<?php
/**
 * Created by PhpStorm.
 * User: Xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form;

use Yii;

/**
 * 表单模型
 * Class UserCopyForm
 * @package v1\models\form
 */

class UserCopyForm extends Model
{
    public $username;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'safe', 'on' => 'create'],
            ['username', 'required', 'on' => 'create', 'message' => '{attribute}' . Yii::t('app\error', 'not null')],
        ];
    }

    /**
     * 场景
     * @return array
     */
    public function scenarios()
    {
        return [
            'create' => [
                'username'
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
            'username' => '用户名称'
        ];
    }
}