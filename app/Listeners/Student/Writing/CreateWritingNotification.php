<?php

namespace App\Listeners\Student\Writing;

use App\Events\Student\Writing\CreateWriting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateWritingNotification
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
     * @param  CreateWriting  $event
     * @return void
     */
    public function handle(CreateWriting $event)
    {
        //
    }
}
