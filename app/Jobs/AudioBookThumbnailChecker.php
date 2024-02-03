<?php

namespace App\Jobs;

use App\Models\AudioBook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AudioBookThumbnailChecker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $audioBook;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AudioBook $audioBook)
    {
        $this->audioBook = $audioBook;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->audioBook->thumbnail_source_type == "link"){
            $updateThumbnail = checkThumbnailUrlFileTypeFixer($this->audioBook->thumbnail_source);
            $this->audioBook->update(['thumbnail_source' => $updateThumbnail]);
        } 
    }
}
