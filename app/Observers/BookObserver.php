<?php

namespace App\Observers;

use Auth;
use Cache;
use App\Models\Book;

class BookObserver
{
    /**
     * Handle the book "created" event.
     *
     * @param  \App\odel=Models\Book  $book
     * @return void
     */
    public function created(Book $book)
    {
        $key = "books." . $book->id . ".*";
        Cache::forget($key);
    }

    /**
     * Handle the book "updated" event.
     *
     * @param  \App\odel=Models\Book  $book
     * @return void
     */
    public function updated(Book $book)
    {
        $key = "books." . Auth::user()->id . ".*";
        Cache::forget($key);
    }

    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\odel=Models\Book  $book
     * @return void
     */
    public function deleted(Book $book)
    {
        $key = "books." . Auth::user()->id . ".*";
        Cache::forget($key);
    }

    /**
     * Handle the book "restored" event.
     *
     * @param  \App\odel=Models\Book  $book
     * @return void
     */
    public function restored(Book $book)
    {
        $key = "books." . Auth::user()->id . ".*";
        Cache::forget($key);
    }

    /**
     * Handle the book "force deleted" event.
     *
     * @param  \App\odel=Models\Book  $book
     * @return void
     */
    public function forceDeleted(Book $book)
    {
        $key = "books." . Auth::user()->id . ".*";
        Cache::forget($key);
    }
}
