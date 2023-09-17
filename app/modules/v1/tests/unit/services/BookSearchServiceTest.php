<?php

namespace app\tests\unit\services;

use Yii;
use app\modules\v1\services\booksearch\BookSearchFactory;
use app\modules\v1\services\booksearch\BookSearchService;
use \Codeception\Verify\Verifiers\VerifyArray;

class BookSearchServiceTest extends \Codeception\Test\Unit
{
    public function testFindBookOne()
    {
        $expected = [
            'id' => 1,
            'title' => 'Война и мир',
            'description' => 'Страшный сон школьников',
            'pages' => 1000,
            'author' => 'Лев Толстой',
            'language' => 'RU',
            'genre' => 'Роман',
        ];


        $_GET = [
            'text' => 'Война',
            'author' => 1,
            'language' => 1,
            'genre' => 1,
            'pages' => '100,2000',
            'limit' => 1,
            'offset' => 0,
        ];

        $searchDTO = (new BookSearchFactory())->fromPost(Yii::$app->request);
        $searchService = new BookSearchService($searchDTO);

        (new VerifyArray($searchService->findBook()))->containsEquals($expected);
    }

    public function testFindBookAll()
    {
        $expected = [
            [
                'id' => 1,
                'title' => 'Война и мир',
                'description' => 'Страшный сон школьников',
                'pages' => 1000,
                'author' => 'Лев Толстой',
                'language' => 'RU',
                'genre' => 'Роман',
            ],
            [
                'id' => 2,
                'title' => 'Анна Снегина',
                'description' => 'Хорошая поэма',
                'pages' => 150,
                'author' => 'Сергей Есенин',
                'language' => 'RU',
                'genre' => 'Роман',
            ],
            [
                'id' => 3,
                'title' => 'The Witcher',
                'description' => 'Отличный фэнтези роман',
                'pages' => 5000,
                'author' => 'Andrzej Sapkowski',
                'language' => 'EN',
                'genre' => 'Фэнтези',
            ],
        ];

        $searchDTO = (new BookSearchFactory())->fromPost(Yii::$app->request);
        $searchService = new BookSearchService($searchDTO);

        verify(json_encode($searchService->findBook()))->equals(json_encode($expected));
    }

    public function testGetSql()
    {
        $expected = 'SELECT "book"."id", "book"."title", "book"."description", "book"."pages", "author"."name" AS "author", "language"."code" AS "language", "genre"."name" AS "genre", ts_rank(to_tsvector("book".title),to_tsquery(\'война:*\')) as tr, ts_rank(to_tsvector("book".description),to_tsquery(\'война:*\')) as dr FROM "book" LEFT JOIN "author" ON "book".author_id="author".id LEFT JOIN "language" ON "book".language_id="language".id LEFT JOIN "genre" ON "book".genre_id="genre".id WHERE (("book".title @@ to_tsquery(\'война:*\')) OR ("book".description @@ to_tsquery(\'война:*\'))) AND ("book"."author_id"=1) AND ("book"."language_id"=1) AND ("book"."genre_id"=1) AND ("book"."pages" BETWEEN 100 AND 2000) ORDER BY "tr" DESC, "dr" DESC, "id" LIMIT 1 OFFSET 1';

        $_GET = [
            'text' => 'Война',
            'author' => 1,
            'language' => 1,
            'genre' => 1,
            'pages' => '100,2000',
            'limit' => 1,
            'offset' => 1,
        ];

        $searchDTO = (new BookSearchFactory())->fromPost(Yii::$app->request);
        $finder = new BookSearchService($searchDTO);

        verify($finder->getSql())->equals($expected);
    }
}
