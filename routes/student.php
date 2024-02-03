<?php
    Route::group(['as' => 'student.', 'namespace' => 'Student', 'prefix' => 'my-dashboard', 'middleware' => ['auth', 'student']], function(){
        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        //Profile
        Route::get('profile','ProfileController@index')->name('profile.index');
        Route::put('profile','ProfileController@update')->name('profile.update');
        Route::get('profile/changepassword','ProfileController@changePassword')->name('profile.changepassword');
        Route::post('profile/changepassword','ProfileController@changePasswordPost')->name('profile.changepassword.store');

        // Essay
        Route::post('/quiz/{code}/stop', 'QuizController@stop')->name('quiz.stop');
        Route::get('/quiz/{code}/result', 'QuizController@result')->name('quiz.result');
        Route::get('/quiz/{code}/question', 'QuizController@question')->name('quiz.question');
        Route::post('/quiz/question/answer', 'QuizController@answerQuestion')->name('quiz.question.answer');
        Route::resource('/quiz', 'QuizController');
        Route::get('/essay/{id}/print', 'EssayController@print')->name('essay.print');
        Route::get('/essay/chart', 'EssayController@chart')->name('essay.chart');
        Route::resource('/essay', 'EssayController');
        Route::resource('/writing', 'WritingController');

       
        
        Route::get('diary/list-api', 'DiaryController@listApi')->name('diary.list.api');
        Route::post('diary/getdiary', 'DiaryController@diaryGet')->name('diary.getdiary.api');
        Route::resource('diary', 'DiaryController');
        
        // Route::get('recording/comments', 'RecordingController@commentList');
        //Recordings
        Route::post('recording', 'RecordingController@sendComment');
        Route::resource('recording', 'RecordingController');

        //
        Route::get('library', 'Student/LibraryController@index')->name('student.library.index');


         //Notificaiton
        Route::post('/notification/menu-list', 'NotificationController@menuList')->name('notification.menu-list');
        Route::post('/notification/create-link', function(){
            return notification_url(request()->link, request()->id);
        });
        Route::resource('/notification', 'NotificationController');
    });

    Route::group(['as' => 'student.', 'namespace' => 'Student', 'prefix' => 'my-dashboard', 'middleware' => ['auth']], function(){
        // Puzzle
            Route::get('puzzle', 'PuzzleController@index')->name('puzzle.index');
            Route::get('puzzle/{category}/{item}', 'PuzzleController@show')->name('puzzle.show');
    });