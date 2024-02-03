<?php

namespace App\Listeners\Student\Writing;

use App\Events\Student\Writing\UpdateWriting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateWritingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateWriting  $event
     * @return void
     */
    public function handle(UpdateWriting $event)
    {
        //
    }
}
