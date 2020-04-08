<?php

$task = require(__DIR__ . '/task.php');
$mailer = require(__DIR__ . '/mailer.php');

return [
    'adminEmail' => $mailer['transport']['username'],
    'task' => $task
];

