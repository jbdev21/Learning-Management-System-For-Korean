<?php

namespace App\Http\Controllers\BackEnd;

use DataTables;
use App\Models\Grammar;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;

class GrammarController extends Controller
{
    public function index(Builder $builder)
    {
        $notices = Grammar::query();
        if (request()->ajax()) {
            return DataTables::of($notices)
            ->addColumn('check', function ($notice) {
                return '<input type="checkbox" name="item_checked[]" value="' . $notice->id . '" >';
            })
            ->addColumn('buttons', function ($notice) {
                $buttons = "";
                $buttons = '<div class="dropdown">
                            <a class="dropdown-toggle tex-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-gear"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">';

                $buttons .=  '<li><a href="' . route('back-end.grammar.edit', $notice->id) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
                $buttons .=  '<li><a href="' . route('back-end.grammar.edit', $notice->id) . '" ><i class="fa fa-trash"></i> Delete</a></li>';
                $buttons .= '</ul></div>';
                return $buttons;
            })
            ->addColumn('created_by', function ($notice) {
               return $notice->user->name;
            })
             ->rawColumns(['check', 'buttons', 'created_by'])
            ->make();
        }

        $html = $builder
            ->parameters([
                    'order' => [ [1, 'ASC'] ],
                    'pageLength' => 25,
                ])
            ->columns([
            [
                'data' => 'check',
                'name' => '',
                'title' => '<input type="checkbox" id="checkAll" >',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'width'          => '10px'
            ],
            [
                'data' => 'title',
                'name' => 'title',
                'title' => 'Title',
                'orderable' => true,
                'searchable' => true
            ],
            [
                'data' => 'created_by',
                'name' => 'created_by',
                'title' => 'Created By',
                'orderable' => true,
                'searchable' => true
            ],
            [
                'data' => 'title',
                'name' => 'title',
                'title' => 'Title',
                'orderable' => true,
                'searchable' => true
            ],
            [
                'defaultContent' => '',
                'data'           => 'buttons',
                'name'           => 'buttons',
                'title'          => '',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'footer'         => '',
                'width'          => '15px'
            ],
        ]);
        return view('back-end.grammar.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.grammar.create');
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
            'title' => 'required',
            'content' => 'required'
        ]);

        $grammar = new Grammar;
        $grammar->branch_id = $request->branch ?? auth()->user()->branch_id;
        $grammar->title = $request->title;
        $grammar->content = $request->content;
        $grammar->is_published = $request->is_published;
        $grammar->user_id = $request->user()->id;
        $grammar->save();
        return redirect()->route('back-end.grammar.index');

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
        $grammar = Grammar::find($id);
        return view('back-end.grammar.edit', compact('grammar'));
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
            'title' => 'required',
            'content' => 'required'
        ]);

        $grammar = Grammar::find($id);
        $grammar->branch_id = $request->branch ?? auth()->user()->branch_id;
        $grammar->title = $request->title;
        $grammar->content = $request->content;
        $grammar->is_published = $request->is_published;
        $grammar->user_id = $request->user()->id;
        $grammar->save();

        return redirect()->route('back-end.grammar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grammar = Grammar::find($id);
        $grammar->delete();
        if(!request()->ajax()){
            return back();
        }
    }
}
