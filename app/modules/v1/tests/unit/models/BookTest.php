<?php

namespace tests\unit\models;

use app\models\User;
use app\modules\v1\models\Book;

class BookTest extends \Codeception\Test\Unit
{
    public function testFindBook()
    {
        verify($book = Book::findOne(1))->notEmpty();
        verify(Book::findOne(999))->empty();
    }

    public function testGetAuthor()
    {
        verify($book = Book::findOne(1))->notEmpty();
        verify($book->author->name)->equals('Лев Толстой');
    }

    public function testGetLanguage()
    {
        verify($book = Book::findOne(2))->notEmpty();
        verify($book->language->code)->equals('RU');
    }

    public function testGetGenre()
    {
        verify($book = Book::findOne(3))->notEmpty();
        verify($book->genre->name)->equals('Фэнтези');
    }
}
