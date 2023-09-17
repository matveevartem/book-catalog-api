<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\services\booksearch\BookSearchFactory;
use app\modules\v1\services\booksearch\BookSearchService;
use yii\web\NotFoundHttpException;

class BookController extends ActiveController
{    
    public $modelClass = 'app\modules\v1\models\Book';

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['view']);
        unset($actions['index']);

        return $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function actionIndex()
    {
        $searchDTO = (new BookSearchFactory())->fromPost($this->request);

        $finder = new BookSearchService($searchDTO);

        $book = $finder->findBook();

        return $this->asJson($book);
    }

    /**
     * {@inheritdoc}
     */
    public function actionView(int $id)
    {
        $searchDTO = (new BookSearchFactory())->fromPost($this->request);

        $finder = new BookSearchService($searchDTO);

        $book = $finder->findBook();

        if (!key_exists(0, $book)) {
            throw new NotFoundHttpException('Object not found: ' . $id);
        } else {
            $book = $book[0];
        }

        return $this->asJson($book);
    }
}
