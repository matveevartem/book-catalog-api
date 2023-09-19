<?php

namespace app\modules\v1\services\booksearch;

use yii\db\Query;
use yii\db\Expression;
use app\modules\v1\services\booksearch\BookSearchDTO;

class BookSearchService
{
    protected BookSearchDTO $searchData;
    protected Query $query;
    protected ?string $text;

    public function __construct(BookSearchDTO $searchData)
    {
        $this->searchData = $searchData;
        $this->query = new Query();
        $this->text = $this->searchData->getText() ? $this->prapareText($this->searchData->getText()) : null;
    }

    protected function prapareText(string $text): string
    {
        $text = array_filter(explode(' ', mb_strtolower($text)), 'trim');
        if (count($text) < 2) {
            $text = implode('', $text) . ':*';
        } else {
            $text = implode(' & ', $text) . ':*';
        }

        return $text;
    }

    /**
     * @return void
     */
    protected function buildSelect()
    {
        $select = [
            "{{%{$this->searchData->getTableBook()}}}.id",
            "{{%{$this->searchData->getTableBook()}}}.title",
            "{{%{$this->searchData->getTableBook()}}}.description",
            "{{%{$this->searchData->getTableBook()}}}.pages",
            "{{%{$this->searchData->getTableAuthor()}}}.name as author",
            "{{%{$this->searchData->getTableLanguage()}}}.code as language",
            "{{%{$this->searchData->getTableGenre()}}}.name as genre",
        ];

        if ($this->searchData->getText()) {
            $select[] = new Expression("ts_rank(to_tsvector({{%{$this->searchData->getTableBook()}}}.title),to_tsquery(:q)) as tr");
            $select[] = new Expression("ts_rank(to_tsvector({{%{$this->searchData->getTableBook()}}}.description),to_tsquery(:q)) as dr");
        }

        $this->query = $this->query->select($select);
    }

    /**
     * @return void
     */
    protected function buildFrom()
    {
        $this->query = $this->query->from("{{%{$this->searchData->getTableBook()}}}");
    }

    /**
     * @return void
     */
    protected function buildJoin()
    {
        $this->query = $this->query
            ->leftJoin("{{%{$this->searchData->getTableAuthor()}}}",
                "{{%{$this->searchData->getTableBook()}}}.author_id={{%{$this->searchData->getTableAuthor()}}}.id")
            ->leftJoin("{{%{$this->searchData->getTableLanguage()}}}",
                "{{%{$this->searchData->getTableBook()}}}.language_id={{%{$this->searchData->getTableLanguage()}}}.id")
            ->leftJoin("{{%{$this->searchData->getTableGenre()}}}",
                "{{%{$this->searchData->getTableBook()}}}.genre_id={{%{$this->searchData->getTableGenre()}}}.id");
    }

    /**
     * @return void
     */
    protected function buildWhere()
    {
        if ($this->searchData->getId()) {
            $this->query = $this->query->andWhere(["{{%{$this->searchData->getTableBook()}}}.id" => $this->searchData->getId()]);
        }

        if ($this->text) {
            $this->query = $this->query->andWhere([
                'OR',
                new Expression("{{%{$this->searchData->getTableBook()}}}.title @@ to_tsquery(:q)", [':q' => $this->text]),
                new Expression("{{%{$this->searchData->getTableBook()}}}.description @@ to_tsquery(:q)", [':q' => $this->text])
            ]);
        }

        if ($this->searchData->getAuthorId()) {
            $this->query = $this->query->andWhere(["{{%{$this->searchData->getTableBook()}}}.author_id" => $this->searchData->getAuthorId()]);
        }

        if ($this->searchData->getLanguageId()) {
            $this->query = $this->query->andWhere(["{{%{$this->searchData->getTableBook()}}}.language_id" => $this->searchData->getLanguageId()]);
        }

        if ($this->searchData->getGenreId()) {
            $this->query = $this->query->andWhere(["{{%{$this->searchData->getTableBook()}}}.genre_id" => $this->searchData->getGenreId()]);
        }

        if ($this->searchData->getPageFrom() && $this->searchData->getPageTo()) {
            $this->query = $this->query->andWhere([
                "BETWEEN",
                "{{%{$this->searchData->getTableBook()}}}.pages",
                $this->searchData->getPageFrom(),
                $this->searchData->getPageTo(),
            ]);
        } elseif ($this->searchData->getPageFrom()) {
            $this->query = $this->query->andWhere([
                ">=",
                "{{%{$this->searchData->getTableBook()}}}.pages",
                $this->searchData->getPageFrom(),
            ]);
        }
    }

    protected function buildOrderBy()
    {
        $order = [];

        if ($this->text) {
            $order['tr'] = SORT_DESC;
            $order['dr'] = SORT_DESC;
        }

        $order['id'] = SORT_ASC;


        $this->query = $this->query->orderBy($order);
    }

    protected function buildLimit()
    {
        if ($this->searchData->getLimit()) {
            $this->query = $this->query->limit($this->searchData->getLimit());
        }

        if ($this->searchData->getOffset()) {
            $this->query = $this->query->offset($this->searchData->getOffset());
        }
    }

    protected function buildQuery()
    {
        $this->buildSelect();
        $this->buildFrom();
        $this->buildJoin();
        $this->buildWhere();
        $this->buildOrderBy();
        $this->buildLimit();
    }

    public function getSql()
    {
        $this->buildQuery();
        
        return $this->query->createCommand()->rawSql;
    }

    public function findBook(): array
    {
        $this->buildQuery();

        return array_map(function ($el) {
                if (key_exists('tr', $el)) {
                    unset($el['tr']);
                }
                if (key_exists('dr', $el)) {
                    unset($el['dr']);
                }
                return $el;
            }, $this->query->all());
    }
}
