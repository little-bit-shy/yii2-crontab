<?php

namespace app\models;


use app\components\ArrayHelper;
use app\components\StringHelper;
use app\controllers\behaviors\Serializer;
use yii\db\Expression;

class ActiveQuery extends \yii\db\ActiveQuery
{
    public $some;

    /**
     * 添加依据expand确认是否调用with
     * @return $this
     */
    public function with()
    {
        $with = func_get_args();

        if (isset($with[1]) && $with[1] == true) {
            $mandatory = true;
        }

        if (isset($with[0]) && is_array($with[0])) {
            // the parameter is given as an array
            $with = $with[0];
        }

        // 强制获取
        if (!isset($mandatory)) {
            // expand参数确认
            if (!Serializer::getExpand($with)) {
                return $this;
            }
        }

        if (empty($this->with)) {
            $this->with = $with;
        } elseif (!empty($with)) {
            foreach ($with as $name => $value) {
                if (is_int($name)) {
                    // repeating relation is fine as normalizeRelations() handle it well
                    $this->with[] = $value;
                } else {
                    $this->with[$name] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * 添加some业务
     * @param array $rows
     * @return array
     */
    public function populate($rows)
    {
        $models = parent::populate($rows);
        if (!empty($this->some)) {
            $this->findSome($this->some, $models);
        }
        return $models;
    }

    /**
     * some参数绑定
     * @return $this
     */
    public function some()
    {
        $some = func_get_args();

        if (isset($some[1]) && $some[1] == true) {
            $mandatory = true;
        }

        if (isset($some[0]) && is_array($some[0])) {
            // the parameter is given as an array
            $some = $some[0];
        }

        // 强制获取
        if (!isset($mandatory)) {
            // expand参数确认
            if (!Serializer::getExpand($some)) {
                return $this;
            }
        }

        if (empty($this->some)) {
            $this->some = $some;
        } elseif (!empty($some)) {
            foreach ($some as $name => $value) {
                if (is_int($name)) {
                    // repeating relation is fine as normalizeRelations() handle it well
                    $this->some[] = $value;
                } else {
                    $this->some[$name] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * some实际业务
     * @param $some
     * @param $models
     */
    public function findSome($some, &$models)
    {
        foreach ($some as $name => $value) {
            switch (ArrayHelper::count($value)) {
                case 3:
                    list($query, $link, $callback) = $value;
                    break;
                case 2:
                    list($query, $link) = $value;
            }
            $query = $query::find();
            if (!empty($callback)) {
                call_user_func($callback, $query);
            }
            // 数据绑定
            if ($query instanceof self) {
                // 关联数据
                $linkLeft = [];
                $linkRight = [];
                /** @var array $linkRightExplode 记录分隔符 */
                $linkRightExplode = [];
                foreach ($link as $left => $right) {
                    $linkLeft[] = $left;
                    $rightExplode = StringHelper::explode($right, '|');
                    if (ArrayHelper::count($rightExplode) == 2) {
                        list($k, $v) = $rightExplode;
                        $linkRight[] = $k;
                        $linkRightExplode[$k] = $v;
                    } else {
                        $linkRight[] = $right;
                    }
                }
                // 计算in参数
                $tmp = [];
                foreach ($linkRight as $key => $column) {
                    $tmp[$column] = [];
                    foreach ($models as $model) {
                        $linkExplode = ',';
                        if (isset($linkRightExplode[$column])) {
                            $linkExplode = $linkRightExplode[$column];
                        }
                        $value = StringHelper::explode($model->$column, $linkExplode);
                        foreach ($value as $val) {
                            $tmp[$column][] = $val;
                        }
                    }
                }
                $values = ArrayHelper::Many2One($tmp, true);

                foreach ($values as &$value) {
                    $valueNew = [];
                    foreach ($linkLeft as $key => $column) {
                        $valueNew[$column] = $value[$key];
                    }
                    $value = $valueNew;
                }

                $query->where(['IN', $linkLeft, ArrayHelper::unique($values)]);
                $all = $query->all();
                $buildKeys = [];
                foreach ($all as $one) {
                    $key = '';
                    foreach ($link as $left => $right) {
                        $key = $one[$left] . '_' . $key;
                    }
                    $buildKeys[$key] = $one;
                }

                // 数据关联处理
                /** @var ActiveRecord $model */
                foreach ($models as &$model) {
                    // 计算关系数据
                    $tmp = [];
                    foreach ($linkRight as $key => $column) {
                        $linkExplode = ',';
                        if (isset($linkRightExplode[$column])) {
                            $linkExplode = $linkRightExplode[$column];
                        }
                        $tmp[$column] = [];
                        $value = StringHelper::explode($model->$column, $linkExplode);
                        foreach ($value as $val) {
                            $tmp[$column][] = $val;
                        }
                    }
                    $keys = ArrayHelper::Many2One($tmp);

                    $buildKey = [];
                    foreach ($keys as $key) {
                        $keyNew = '';
                        foreach ($key as $val) {
                            $keyNew = $val . '_' . $keyNew;
                        }
                        if (isset($buildKeys[$keyNew])) {
                            $buildKey[] = $buildKeys[$keyNew];
                        }
                    }
                    // 借用relation，只作绑定不作认证
                    $model->populateRelation($name, $buildKey);
                }
            }
        }
    }

    /**
     * 添加排他锁
     * @return mixed
     */
    public function forUpdate()
    {
        $activeRecord = $this->modelClass;
        return $activeRecord::findBySql($this->createCommand()->getRawSql() . (new Expression(' FOR UPDATE')));
    }

    /**
     * 重写返回数字
     * @param string $q
     * @param null $db
     * @return int
     */
    public function count($q = '*', $db = null)
    {
        return (int)parent::count($q, $db);
    }
}
