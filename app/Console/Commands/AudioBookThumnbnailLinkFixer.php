<?php

namespace App\Console\Commands;

use App\Jobs\AudioBookThumbnailChecker;
use App\Models\AudioBook;
use Illuminate\Console\Command;

class AudioBookThumnbnailLinkFixer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fix-audiobook-link-thumbnail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the file extension error from excel uploaded thumbnail links';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $audioBooks = AudioBook::where('thumbnail_source_type', 'link')
                    ->where('source_type', 'outsource')
                    ->get();
        
        foreach($audioBooks as $audioBook){
            AudioBookThumbnailChecker::dispatch($audioBook);
        }
    }
}
