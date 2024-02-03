<?php
use Illuminate\Http\Request;

Route::post('/upload', function(Request $request){
        $file = $request->file('file')->store('editor-uploads', 'uploads');
         return [
            'location' => '/uploads/' . $file
            ];
//    if($request->hasFile($request->file)){
//        return [
//            'location' => '/uploads/' . $file
//            ];
//    }
});

Route::get('comment-templates', function(){
    return config('comment_templates');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




