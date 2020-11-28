<?php


namespace App;


use Illuminate\Pagination\LengthAwarePaginator;

class PagedData
{
    public static function forPage(LengthAwarePaginator $page, $formatter)
    {
        return [
            'items' => collect($page->items())->map($formatter),
            'page' => $page->currentPage(),
            'last_page' => $page->lastPage(),
            'total' => $page->total(),
        ];
    }
}
