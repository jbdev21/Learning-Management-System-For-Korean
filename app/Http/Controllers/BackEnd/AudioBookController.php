<?php

namespace App\Http\Controllers\BackEnd;

use DB;
use Excel;
use Storage;
use DataTables;
use App\Models\AudioBook;
use App\Exports\BookExport;
use App\Imports\BookImport;
use Illuminate\Http\Request;
use App\Imports\AudioBookImport;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class AudioBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request)
    {
        if($request->q){
            $books = AudioBook::branched()->where('title', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('type_name', 'LIKE',  '%' . $request->q . '%')
                        ->orWhere('ar_level', 'LIKE',  '%' . $request->q . '%')->paginate(30);
        }else{
            $books = AudioBook::branched()->paginate(30);
        }

        return view('back-end.audiobook.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.audiobook.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        
        if($request->hasFile('excelfile')){
            return DB::transaction(function() use($request){   
                try{   
                    $collection = (new FastExcel)->import($request->file('excelfile'));
                    $data = array();
                    $prev = array();
                    foreach($collection as $index => $row){
                        $explodedAudio = explode('/', str_replace('/GW', 'GW', $row['AudioFile']));
                        $source_type = \Str::contains($row['AudioFile'], 'https://www.youtube.com/') ? 'youtube_video' : 'outsource';
                        $firstFolder = $explodedAudio[0] != '' ? $explodedAudio[0] : $explodedAudio[1];
                        $type = str_replace('GWAudio_', '', $firstFolder);
                        $book_type = $type == "Rental" ? 'library' : strtolower($type);
                        $item = [
                            'branch_id'             => $request->user()->branch_id,
                            'book_number'           => $row['Book_Code'], 
                            'title'                 => str_replace('_', ' ', $row['Title']),
                            'type'                  => $book_type,
                            'type_name'             => $row['Series_Name/Stage_Name'],
                            'author'                => '',
                            'ar_level'              => $row['AR_Level'],
                            'source_type'           => $source_type,
                            'source_folder'         => $source_type == 'youtube_video' ? $row['AudioFile'] : $explodedAudio[1],  
                            'thumbnail_source_type' => 'link',
                            'thumbnail_source'      => 'https://gwenglish.synology.me/book_cover_iamge/' . $row['Cover'],
                        ];
                        
                        if(count(array_diff($prev, $item)) != 0 || $index != 0){
                            if($row['Title'] != ""){
                                array_push($data, $item);
                            }
                        }

                        $prev = $item;
                    }

                    foreach(collect($data)->chunk(500) as $chunk){
                        AudioBook::insert($chunk->toArray());
                    }

                    return redirect()->route('back-end.audiobook.index');

                }catch(\Exception $exception){
                    return back()->with('warning', $exception->getMessage());
                }
            });
        }else{

            $this->validate($request, [
                'title' => ['required', 'string'], 
            ]);
            
            $book = new AudioBook;
            $book->book_number = $request->book_number;
            $book->title = $request->title;
            $book->type = $request->type;
            $book->type_name = $request->type_name;
            $book->author = $request->author;
            $book->ar_level = $request->ar_level;
            $book->source_type = $request->source_type;
            $book->source_folder = $request->source_folder;
            $book->branch_id = request()->user()->branch_id;

            $book->save();

             // for the thumbnail
            $book->thumbnail_source_type = $request->thumbnail_source_type ? $request->thumbnail_source_type : 'link';
            if($request->thumbnail_source_type == 'uploaded'){
                if($request->hasFile('thumbnail')){
                    Storage::disk('audio-books-thumbnails')->delete($book->thumbnail_source);
                    $book->thumbnail_source = $request->file('thumbnail')->store('', 'audio-books-thumbnails');
                }
            }else{
                Storage::disk('audio-books-thumbnails')->delete($book->thumbnail_source);
                $book->thumbnail_source = $request->link;
            }

            $book->save();
            return redirect()->route('back-end.audiobook.edit', $book->id);
        }

    }


    function checkThumbnailUrlAndFix($fileUrl){
        $headers = @get_headers($fileUrl);
        if(strpos($headers[0], '404')) {
            $file = explode('.',basename($fileUrl));
            $replace = ctype_upper($file[1]) ? strtolower($file[1]) : strtoupper($file[1]);
            return str_replace($file[1], $replace, $fileUrl);
        }else{
            return $fileUrl;
        }
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function uploadFile(Request $request, $id){
        $audiobook = AudioBook::find($id);
        $file = $request->file('uploadedfile');

        $audioCounts = $audiobook->getAudioFiles()->count();
        if($audioCounts > 0){
            $count = $audioCounts + 1;
        }else{
            $count = 1;
        }

        // naming the audio file
        $name = 'Track ' . $count;
        Storage::disk($audiobook->storage_disk)->putFileAs($audiobook->server_folder, $file, $name . '.' . $file->getClientOriginalExtension());
        $audiobook->touch();

        return back();
    }



    function deleteFile(Request $request, $id){
        $audiobook = AudioBook::find($id);
        Storage::disk($audiobook->storage_disk)->delete($audiobook->server_folder . "/". $request->path);
        if(!$request->ajax()){
            return back();
        }

        $audiobook->touch();

        return response()->json([
            'message' => 'File Deleted'
        ], 200);
    }

    public function export()
    {
        return Excel::download(new BookExport, 'book-list-updated-'.  date('Y-m-d') .'.xlsx');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = AudioBook::find($id);
        // return $book->getAudioFiles();
        // return $book->thumbnail;
        return view('back-end.audiobook.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = AudioBook::find($id);
        $book->book_number = $request->book_number;
        $book->title = $request->title;
        $book->type = $request->type;
        $book->type_name = $request->type_name;
        $book->author = $request->author;
        $book->ar_level = $request->ar_level;
        $book->source_type = $request->source_type;
        $book->source_folder = $request->source_folder;

        
        // for the thumbnail
        $book->thumbnail_source_type = $request->thumbnail_source_type ? $request->thumbnail_source_type : 'link';
        if($request->thumbnail_source_type == 'uploaded'){
            if($request->hasFile('thumbnail')){
                Storage::disk($book->storage_thumbnail_disk)->delete($book->thumbnail_source);
                $book->thumbnail_source = $request->file('thumbnail')->store('', $book->storage_thumbnail_disk);
            }
        }else{
            // Storage::disk($book->storage_thumbnail_disk)->delete($book->thumbnail_source);
            $book->thumbnail_source = $request->link;
        }

        $book->save();

        return back()->with('message', 'Audiobook Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($id == 0){
            if($request->item_checked){
                 foreach($request->item_checked as $item){
                    $book = AudioBook::find($item);
                    $book->delete();
                }
            }
        }else{
            $book = AudioBook::find($id);
            $book->delete();
        }

         if(!request()->ajax()){
            return back();
        }
    }
}
