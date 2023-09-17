<?php

namespace app\modules\v1\services\booksearch;

use yii\web\BadRequestHttpException;
use app\modules\v1\models\Book;
use app\modules\v1\models\Author;
use app\modules\v1\models\Language;
use app\modules\v1\models\Genre;

class BookSearchDTO
{
    protected ?int $id = null;
    protected ?string $text = null;
    protected array|int|null $authorId = null;
    protected array|int|null $languageId = null;
    protected ?int $genreId = null;
    protected ?string $pages = null;
    protected ?int $limit = null;
    protected ?int $offset = null;

    protected string $tableBook;
    protected string $tableAuthor;
    protected string $tableLanguage;
    protected string $tableGenre;

    protected ?int $pageFrom = null;
    protected ?int $pageTo = null;

    public function __construct(
        ?int $id = null,
        ?string $text = null,
        array|int|null $authorId = null,
        array|int|null $languageId = null,
        ?int $genreId = null,
        ?string $pages = null,
        ?int $limit = null,
        ?int $offset = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->authorId = $authorId;
        $this->languageId = $languageId;
        $this->genreId = $genreId;
        $this->pages = $pages;
        $this->limit = $limit;
        $this->offset = $offset;

        $this->tableBook = Book::tableName();
        $this->tableAuthor = Author::tableName();
        $this->tableLanguage = Language::tableName();
        $this->tableGenre = Genre::tableName();

        $this->fillPages();
    }

    /**
     * Parse pages get param and setss $pageTo, $pageFrom propertios
     */
    protected function fillPages()
    {
        if (!$this->pages) {
            return;
        }
        
        $pages = array_filter(explode(',', $this->pages), 'trim');

        switch (count($pages)) {
            case 1:
                $this->pageFrom = intval($pages[0]);
                break;
            case 2:
                $this->pageFrom = intval($pages[0]);
                $this->pageTo = intval($pages[1]);
                break;
            default:
                throw new BadRequestHttpException("Bad page value");
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getAuthorId(): array|int|null
    {
        return $this->authorId;
    }

    public function getLanguageId(): array|int|null
    {
        return $this->languageId;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }
    public function getGenreId(): ?int
    {
        return $this->genreId;
    }

    public function getPageFrom(): ?int
    {
        return $this->pageFrom;
    }

    public function getPageTo(): ?int
    {
        return $this->pageTo;
    }

    public function getTableBook(): string
    {
        return $this->tableBook;
    }

    public function getTableAuthor(): string
    {
        return $this->tableAuthor;
    }

    public function getTableLanguage(): string
    {
        return $this->tableLanguage;
    }

    public function getTableGenre(): string
    {
        return $this->tableGenre;
    }
}
