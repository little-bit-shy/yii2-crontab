<?php
/**
 * session相关配置
 * 不建议redis版本低于 2.6.12
 */

return [
    'class' => \yii\redis\Session::className()
];
