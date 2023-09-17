<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class AuthorController extends ActiveController
{
    public $modelClass = 'app\modules\v1\models\Author';

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

    /**
     * {@inheritdoc}
     */
    public function actionDelete()
    {
        throw new \yii\web\MethodNotAllowedHttpException('Can\'t remove language');
    }
}
