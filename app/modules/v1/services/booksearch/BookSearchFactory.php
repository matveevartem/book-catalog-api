<?php

namespace app\modules\v1\services\booksearch;

use yii\base\Request;
use app\modules\v1\services\booksearch\BookSearchDTO;
use app\modules\v1\components\Helper;

class BookSearchFactory
{
    /**
     * Creates BookSearchDTO object
     * 
     * @param Request $request
     * @return BookSearchDTO
     */
    public function fromPost(Request $request): BookSearchDTO
    {
        return new BookSearchDTO(
            $request->get('id'),
            $request->get('text'),
            Helper::parseMultiSelect($request->get('author')),
            Helper::parseMultiSelect($request->get('language')),
            $request->get('genre'),
            $request->get('pages'),
            $request->get('limit'),
            $request->get('offset')
        );
    }
}
