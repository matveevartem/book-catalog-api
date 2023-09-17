<?php

namespace app\modules\v1;

use Yii;
use yii\base\Module as BaseModule;
use yii\base\BootstrapInterface;
use app\modules\v1\commands\UrlController;


class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require __DIR__ . DIRECTORY_SEPARATOR  . 'config' . DIRECTORY_SEPARATOR  . 'settings.php');
    }
}
