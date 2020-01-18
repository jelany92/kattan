<?php

namespace common\components;


class ConsoleExecutor
{
    /**
     * Asynchronously executes console command
     *
     * @param $command
     */
    public static function execute($command)
    {
        $executeString = 'php ' . \Yii::$app->params['framework'] . 'yii ' . $command . ' > /dev/null 2>&1 &';
        exec($executeString);
    }
}