<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2019/4/30
 * Time: 20:11
 */

namespace app\models;

class DynamicModel extends \yii\base\DynamicModel
{
    /**
     * rewrite
     * @param null $attribute
     * @return mixed|string
     */
    public function getFirstError($attribute = null)
    {
        if ($attribute === null) {
            $firstErrors = $this->getFirstErrors();
            return reset($firstErrors);
        }
        return parent::getFirstError($attribute);
    }
}