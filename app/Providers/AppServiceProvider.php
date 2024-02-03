<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Diary;
use App\Models\Comment;
use App\Models\AudioBook;
use App\Models\BookScore;
use App\Models\ComponentScore;
use App\Observers\BookObserver;
use App\Observers\DiaryObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\Collection;
use App\Observers\AudioBookObserver;
use App\Observers\BookScoreObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Observers\ComponentScoreObserver;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\PhpseclibV3\SftpAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
          if (!Collection::hasMacro('paginate')) {
            Collection::macro('paginate',
                function ($perPage = 25, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage),
                        $this->count(),
                        $perPage,
                        $page,
                        $options))->withPath(url()->current());
                });
        }


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $url->forceScheme('https');
        Schema::defaultStringLength(191); /// copy this
        ComponentScore::observe(ComponentScoreObserver::class);
        AudioBook::observe(AudioBookObserver::class);
        BookScore::observe(BookScoreObserver::class);
        Book::observe(BookObserver::class);
        Comment::observe(CommentObserver::class);
        Diary::observe(DiaryObserver::class);

        Storage::extend('sftp', function ($app, $config) {
            return new Filesystem(new SftpAdapter($app, $config));
        });
    }
}
