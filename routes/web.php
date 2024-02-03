<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Auth::routes();
Broadcast::routes();

Route::get('fix-question', function(){
    $questions = App\Models\Question::all();
    $collect = collect();
    foreach($questions as $question){
        if(is_array($question->options)){

            foreach($question->options as $index => $option){
                $optionArray[$index + 1] = $option;
            }

            $collect->add($optionArray);
            $question->update(['options' => $optionArray]);
        }
    }
    return $collect;
});

Route::get('/cache-clear', function(){
    Artisan::call('cache:clear');
});

// Route::get("mysql-dump", function(){
//     try {
//         $ds = DIRECTORY_SEPARATOR;
//         $host = env('DB_HOST');
//         $username = env('DB_USERNAME');
//         $password = env('DB_PASSWORD');
//         $database = env('DB_DATABASE');

//         $ts = time();

//         $path = database_path() . $ds . 'backups' . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;
//         $file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';
//         $command = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $path . $file);

//         if (!is_dir($path)) {
//             mkdir($path, 0755, true);
//         }

//         exec($command);
//         return "Success!. Please check on $path";
//     }catch (Exception $e){
//         return $e->getMessage();
//     }

// });


Route::get('/', 'HomeController@index')->name('homepage');
Route::get('/notice', 'HomeController@noticeIndex')->name('notice.index');
Route::get('/notice/{id}', 'HomeController@noticeShow')->name('notice.show');
Route::get('library', 'Student\LibraryController@index')->name('library.index');
Route::get('audiobook', 'Student\AudioBookController@index')->name('audiobook.index')->middleware('auth');
Route::get('audiobook/{id}', 'Student\AudioBookController@show')->name('audiobook.show')->middleware('auth');


// June 30, 2020 - Update Task by Niel - Route About page Index
Route::get('/about', 'HomeController@aboutIndex')->name('about.index');
// July 1, 2020 - Update for image to view in template About page.
Route::get('/about/photo_2', 'HomeController@aboutTemplate2')->name('about.template2');
Route::get('/about/photo_3', 'HomeController@aboutTemplate3')->name('about.template3');
Route::get('library', 'Student\LibraryController@index')->name('library.index');
Route::get('essay-rank','EssayRankingController@index')->name('site.essay-rank');
Route::get('student-rank','StudentRankingController@index')->name('site.student-rank');

Route::group(['prefix' => 'api'], function(){
    Route::resource('comment', 'Api\CommentController');
    Route::resource('component-comment', 'Api\ComponentCommentController');
});

/*
 * Student Route
 * */
include("student.php");


/*
 * BackEnd Route
 * */
include("back-end.php");

Route::get('get-inputs', function(){
    return collect(\Storage::disk('inputs')->files(''))->map(function($q){
        return \Str::title(str_replace('.blade.php', '', str_replace('-',' ', $q)));
    });
});

Route::delete('delete-writing/{id}', 'DeleteWriting')->name('delete.writing');

Route::post('notification-link', function(){
    return notification_url($request->link, $request->id);
});

Route::get('download', function(){
    return response()->download(public_path('downloadables/' . request()->f));
})->name('download');

Route::get('/policy', function () {
    return view('site.misc.policy');
});

Route::get('/personal-information', function () {
    return view('site.misc.personal_info');
});
