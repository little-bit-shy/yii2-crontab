<?php
/**
 * Created by PhpStorm.
 * User: Xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace v1\models\form;

class Model extends \yii\base\Model
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