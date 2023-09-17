<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class LanguageController extends ActiveController
{
    public $modelClass = 'app\modules\v1\models\Language';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete']);

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'delete' => ['DELETE'],
        ];
    }

    public function actionDelete()
    {
        throw new \yii\web\MethodNotAllowedHttpException('Can\'t remove language');
    }
}
