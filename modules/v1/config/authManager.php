<?php
if (YII_ENV_PROD) {
    return [
        'class' => \yii\rbac\DbManager::className(),
        'defaultRoles' => ['ordinaryUser'],
    ];
} else if (YII_ENV_TEST) {
    return [
        'class' => \yii\rbac\DbManager::className(),
        'defaultRoles' => ['ordinaryUser'],
    ];
} else if (YII_ENV_DEV) {
    return [
        'class' => \yii\rbac\DbManager::className(),
        'defaultRoles' => ['ordinaryUser'],
    ];
}