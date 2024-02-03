<?php
use Illuminate\Http\Request;

// Route::group(['prefix' => '{code?}'], function(){
    Route::group(['as' => 'back-end.', 'prefix' => 'back-end', 'namespace' => 'BackEnd', 'middleware' => ['auth','backend']], function(){
        Route::get('/', 'StudentController@index')->name('dashboard.index');

        Route::get('book/export', 'BookController@export')->name('book.export');
        Route::resource('book', 'BookController');

        Route::get('audiobook/export', 'AudioBookController@export')->name('audiobook.export');
        Route::post('audiobook/{id}/uploadfile', 'AudioBookController@uploadFile')->name('audiobook.uploadfile');
        Route::delete('audiobook/{id}/deletefile', 'AudioBookController@deleteFile')->name('audiobook.deletefile');
        Route::resource('audiobook', 'AudioBookController');

        Route::resource('library', 'LibraryHistoryController');

        // Writings
        Route::get('/writing/{id}/{student}/print', 'WritingController@print')->name('writing.print');
        Route::get('writing/chart/{id}', 'WritingController@essayChart')->name('writing.essay.chart');
        Route::get('writing', 'WritingController@index')->name('writing.index');
        Route::post('writing', 'WritingController@store')->name('writing.store');
        Route::delete('writing/{id}', 'WritingController@destroy')->name('writing.destroy');
        Route::get('writing/show', 'WritingController@show')->name('writing.show');
        Route::post('writing/score-component', 'WritingController@componentSendScore')->name('writing.component.sendscore');
        Route::post('writing/score-book', 'WritingController@bookSendScore')->name('writing.book.sendscore');

        //Ranking
        Route::resource('student-rank', 'StudentRankController');
        Route::resource('essay-rank', 'EssayRankController');

        // diaries
        Route::resource('diary', 'DiaryController');
        Route::resource('grammar', 'GrammarController');
        Route::resource('recording', 'RecordingController');
        Route::resource('word-puzzle', 'WordPuzzleController');
        // Route::resource('puzzle-word', 'PuzzleWordItemController');

        // Learning Materials
            // Quiz
                Route::post('quiz-question', 'QuizController@questionStore')->name('quiz.question.store');
                Route::delete('quiz-question/{id}', 'QuizController@questionDestroy')->name('quiz.question.destroy');
                Route::get('quiz-question/{id}/edit', 'QuizController@questionEdit')->name('quiz.question.edit');
                Route::put('quiz-question/{id}', 'QuizController@questionUpdate')->name('quiz.question.update');
                Route::resource('quiz', 'QuizController');

        // Profile
        Route::get('profile', 'ProfileController@index')->name('profile.index');
        Route::put('profile', 'ProfileController@update')->name('profile.update');
        Route::get('profile/center', 'ProfileController@center')->name('profile.center.index');
        Route::post('profile/center', 'ProfileController@centerUpdate')->name('profile.center.update');
        Route::get('profile/changepassword', 'ProfileController@changepassword')->name('profile.changepassword');
        Route::post('profilechangepassword', 'ProfileController@updatePassword')->name('profile.changepassword.update');


        Route::resource('grading', 'GradingController');
        Route::resource('subject', 'SubjectController');
        Route::resource('branch', 'BranchController');
        Route::resource('center', 'CenterController')->only(['index', 'update']);
        Route::resource('component', 'ComponentController');

        //Student
            // Create steps
            Route::get('student/create/step/2', 'StudentController@step2')->name('student.create.step2');
            Route::post('student/create/{id}/step/2', 'StudentController@step2Store')->name('student.create.step2.store');

            Route::get('student/create/step/3', 'StudentController@step3')->name('student.create.step3');
            Route::post('student/create/{id}/step/3', 'StudentController@step3Store')->name('student.create.step3.store');


            //Edit Steps
            Route::get('student/edit/{id}/assessment', 'StudentController@editStep2')->name('student.edit.step2');
            Route::put('student/edit/{id}/assessment', 'StudentController@updateStep2')->name('student.edit.step2.update');

            Route::get('student/edit/{id}/english-background', 'StudentController@editStep3')->name('student.edit.step3');
            Route::put('student/edit/{id}/english-background', 'StudentController@updateStep3')->name('student.edit.step3.update');

            Route::get('student/create/step/4', 'StudentController@step4')->name('student.create.step4');

        Route::post('/student/update-chart-data', 'StudentController@updateBookComponentData');
        Route::get('student/export', 'StudentController@downloadExcel')->name('student.export');
        Route::resource('student', 'StudentController');
        Route::resource('examination', 'ExaminationController');

        Route::resource('notice', 'NoticeController');
        Route::resource('banner', 'BannerController')->except(['create']);
        Route::resource('teacher', 'TeacherController');
        Route::post('class-room/adduser', 'ClassRoomController@addUser')->name('class-room.user.add');
        Route::post('class-room/removeuse/{id}', 'ClassRoomController@removeUser')->name('class-room.user.remove');
        Route::resource('class-room', 'ClassRoomController');
        Route::resource('sub-admin', 'SubAdminController');

        //Notificaiton
        Route::post('/notification/menu-list', 'NotificationController@menuList')->name('notification.menu-list');
        Route::post('/notification/create-link', function(){
            return notification_url(request()->link, request()->id);
        });
        Route::get('/notification/markallasread', 'NotificationController@markAllAsRead')->name('notification.mark-all-as-read');
        Route::resource('/notification', 'NotificationController');


        Route::get('search/student', function(Request $request){
            return App\Models\User::where('username', 'LIKE', '%' . $request->searchTerm . '%' )->whereType('student')->whereBranchId($request->user()->branch_id)->get()->map(function($q){
                return [
                    'id' => $q->id,
                    'text' => $q->username . '(' . $q->name .')'
                ];
            });
        })->name('search.student');

        Route::get('search/book', function(Request $request){
            return App\Models\Book::where('title', 'LIKE', '%' . $request->searchTerm . '%' )->whereBranchId($request->user()->branch_id)->get()->map(function($q){
                return [
                    'id' => $q->id,
                    'text' => $q->title
                ];
            });
        })->name('search.book');

    });
// });