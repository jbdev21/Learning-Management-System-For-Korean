<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\LibraryHistory;
use App\Http\Controllers\Controller;

class LibraryHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->branch  ?? auth()->user()->branch_id;
        $list = LibraryHistory::whereHas('user', function($q) use($branch){
                    $q->where('branch_id', $branch);
            });

        if($request->search){
            $list->whereHas('user', function($q) use($request){
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            })->orWhereHas('book', function($q) use ($request){
                $q->where('title', 'LIKE', '%' . $request->search . '%');
            });
        }

        if($request->status){
            if($request->status == "returned"){
                $list->whereNotNull('date_returned')->orderBy('date_returned', 'DESC');
            }else{
                $list->whereNull('date_returned')->orderBy('date_borrowed', 'DESC');
            }
        }

        $histories = $list->paginate(25);

        return view('back-end.library.index', compact('histories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required',
            'user_id' => 'required',
            'date_borrowed' => 'required',
        ]);

        $history = new LibraryHistory;
        $history->book_id = $request->book_id;
        $history->user_id = $request->user_id;
        $history->date_borrowed = $request->date_borrowed;
        $history->save();

        $book = Book::find($request->book_id);
        $book->is_available = 0;
        $book->save();

        return back();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $library = LibraryHistory::find($id);
        return view('back-end.library.edit', compact('library'));
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
        $this->validate($request, [
            'date_borrowed' => 'required',
        ]);

        $history = LibraryHistory::find($id);
        $history->date_borrowed = $request->date_borrowed;
        $history->date_returned = $request->date_returned;
        $history->save();

        if($request->date_returned){
            $book = Book::find($history->book_id);
            $book->is_available = 1;
            $book->save();
        }

        return redirect()->route('back-end.library.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $library = LibraryHistory::find($id);
        $library->delete();
        if(!request()->ajax()){
            return back();
        }
    }
}
