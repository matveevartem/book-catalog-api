<?php

namespace app\modules\v1\commands; 
 
use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use app\modules\v1\models\Book;
 
/**
 * @package app\modules\v1\components\command
 */
class  BookController extends Controller
{
    const PRINT_PERIOD = 24 * 3600; // за сколько последних часов выводить данные

    public function actionList()
    {
        $period = static::PRINT_PERIOD * 3600;

        $books = Book::find()->asArray()->all();

        foreach ($books as $idx => $book) {
            print_r($book);
        }
    }
}