<?php

namespace app\tests\functional;

class BookSearchCest
{
    public function getBookById(\ApiTester $I) {
        $expected = '{"id":3,"title":"The Witcher","description":"Отличный фэнтези роман","pages":5000,"author":"Andrzej Sapkowski","language":"EN","genre":"Фэнтези"}';

        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGet('/book/3');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains($expected);
    }

    public function getBookByAuthor(\ApiTester $I) {
        $expected = '[{"id":2,"title":"Анна Снегина","description":"Хорошая поэма","pages":150,"author":"Сергей Есенин","language":"RU","genre":"Роман"}]';

        $I->amHttpAuthenticated('service_user', '123456');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGet('/book', [
          'author' => 2,
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseContains($expected);
    }

}
