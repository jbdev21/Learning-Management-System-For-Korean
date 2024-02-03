<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use Excel;
use Cache;
use DataTables;
use App\Models\Book;
use App\Exports\BookExport;
use App\Imports\BookImport;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->q){
            $books =  Book::where('title', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('book_number', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('type', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('type_name', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('author', 'LIKE', '%' . $request->q . '%')
                        ->orWhere('ar_level', 'LIKE', '%' . $request->q . '%')
                        ->paginate(30);
        }else{
            $books = Book::paginate(30);
        }

        return view('back-end.book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.book.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        if($request->hasFile('excelfile')){
            // $books = Book::whereBranchId($request->user()->branch_id)->get();
            // foreach($books as $book){
            //     $book->delete();
            // }

            Excel::import(new BookImport, $request->file('excelfile'));
            return redirect()->route('back-end.book.index');
        }else{
            $book = new Book;
            $book->book_number = $request->book_number;
            $book->title = $request->title;
            $book->type = $request->type;
            $book->type_name = $request->type_name;
            $book->author = $request->author;
            $book->ar_level = $request->ar_level;
            $book->branch_id = request()->user()->branch_id;

            $book->save();

            return redirect()->route('back-end.book.index');
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
        $book = Book::find($id);
        $thumbnail = $book->image('thumbnail')->first();
        return view('back-end.book.edit', compact('book', 'thumbnail'));
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
        $book = Book::findOrFail($id);
        $book->book_number = $request->book_number;
        $book->title = $request->title;
        $book->type = $request->type;
        $book->type_name = $request->type_name;
        $book->author = $request->author;
        $book->ar_level = $request->ar_level;
        $book->save();

        if($request->link){
            $book->addLinkedImage($request->link, 'thumbnail');
        }

        return redirect()->route('back-end.book.index');
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
                    $book = Book::find($item);
                    $book->delete();
                }
            }
        }else{
            $book = Book::find($id);
            $book->delete();
        }
      
         if(!request()->ajax()){
            return back();
        }
    }
}
