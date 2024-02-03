<?php

namespace App\Observers;

use Notification;
use App\Models\BookScore;
use App\Notifications\Student\BookScoreNotification;

class BookScoreObserver
{
    /**
     * Handle the book score "created" event.
     *
     * @param  \App\Models\BookScore  $bookScore
     * @return void
     */
    public function created(BookScore $bookScore)
    {
        Notification::send($bookScore->student, new BookScoreNotification($bookScore));
    }

    /**
     * Handle the book score "updated" event.
     *
     * @param  \App\Models\BookScore  $bookScore
     * @return void
     */
    public function updated(BookScore $bookScore)
    {
        //
    }

    /**
     * Handle the book score "deleted" event.
     *
     * @param  \App\Models\BookScore  $bookScore
     * @return void
     */
    public function deleted(BookScore $bookScore)
    {
        //
    }

    /**
     * Handle the book score "restored" event.
     *
     * @param  \App\Models\BookScore  $bookScore
     * @return void
     */
    public function restored(BookScore $bookScore)
    {
        //
    }

    /**
     * Handle the book score "force deleted" event.
     *
     * @param  \App\Models\BookScore  $bookScore
     * @return void
     */
    public function forceDeleted(BookScore $bookScore)
    {
        //
    }
}
