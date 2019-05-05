<?php
/**
 * Created by PhpStorm.
 * User: xuguozi
 * Date: 2018/1/16
 * Time: 10:56
 */

namespace app\models\form;

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