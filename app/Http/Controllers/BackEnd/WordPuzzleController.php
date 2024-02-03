<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\WordPuzzle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WordPuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch = $request->branch_id ?? $request->user()->branch_id;
        $puzzles = WordPuzzle::where('branch_id', $branch)->paginate(15);
        return view('back-end.word-puzzle.index', compact('puzzles'));
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
            'name' => 'required' 
        ]);

        $WordPuzzle = new WordPuzzle;
        $WordPuzzle->branch_id = $request->user()->branch_id;
        $WordPuzzle->name = $request->name;
        $WordPuzzle->status = $request->status;
        $WordPuzzle->save();

        return redirect()->route('back-end.word-puzzle.show', $WordPuzzle->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puzzle = WordPuzzle::find($id);
        return view('back-end.word-puzzle.show', compact('puzzle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $puzzle = WordPuzzle::find($id);
        return view('back-end.word-puzzle.edit', compact('puzzle'));
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
            'name' => 'required' 
        ]);

        $WordPuzzle = WordPuzzle::find($id);
        $WordPuzzle->branch_id = $request->user()->branch_id;
        $WordPuzzle->name = $request->name;
        $WordPuzzle->save();

        return redirect()->route('back-end.word-puzzle.show', $WordPuzzle->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $WordPuzzle = WordPuzzle::find($id);
        $WordPuzzle->delete();

        if(!request()->ajax()){
            return redirect()->route('back-end.word-puzzle.index');     
        }
    }
}
