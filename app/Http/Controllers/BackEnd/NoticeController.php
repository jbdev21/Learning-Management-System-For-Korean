<?php

namespace App\Http\Controllers\BackEnd;

use DataTables;
use App\Models\Notice;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
  public function index(Builder $builder, Request $request)
    {
        $type = $request->type ?? 'notice';
        $notices = Notice::branched()->whereType($type);
        if (request()->ajax()) {
            return DataTables::of($notices)
            ->addColumn('check', function ($notice) {
                return '<input type="checkbox" name="item_checked[]" value="' . $notice->id . '" >';
            })
            ->addColumn('buttons', function ($notice) {
                $buttons = "";
                $buttons .= '<a  class="btn btn-xs btn-primary" target="_blank" href="'. route('notice.show', $notice->id) . '">Preview</a> ';
                $buttons .= '<a  class="btn btn-xs btn-warning" href="' . route('back-end.notice.edit', $notice->id) . '" ><i class="fa fa-pencil"></i> Edit</a> ';
                $buttons .= '<a  class="delete-item btn-xs btn btn-danger " data-uri="' . route('back-end.notice.destroy', $notice->id) .  '"><i class="fa fa-trash"></i> Delete</a> ';
                return $buttons;
            })
            ->addColumn('created_by', function ($notice) {
               return $notice->user->name;
            })
            ->addColumn('status', function ($notice) {
               return $notice->is_published ? 'Published' : 'Draft';
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
                'searchable' => true,
                'width' => '350px'
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
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
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => 'Created At',
                'orderable' => true, 
                'searchable' => true
            ],
            // [
            //     'data' => 'title',
            //     'name' => 'title',
            //     'title' => 'Title',
            //     'orderable' => true, 
            //     'searchable' => true
            // ],
            [
                'defaultContent' => '',
                'data'           => 'buttons',
                'name'           => 'buttons',
                'title'          => '',
                'footer'         => '',
                'width'          => '180px'
            ],
        ]);

        return view('back-end.notice.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.notice.create');
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

        $grammar = new Notice;
        $grammar->branch_id = $request->branch ?? auth()->user()->branch_id;
        $grammar->title = $request->title;
        $grammar->content = $request->content;
        $grammar->type = $request->type ?? 'notice';
        $grammar->is_published = $request->is_published;
        $grammar->user_id = $request->user()->id;
        $grammar->save();
        return redirect()->route('back-end.notice.index', ['type' => $request->type ?? 'notice']);
 
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
        $notice = Notice::find($id);
        return view('back-end.notice.edit', compact('notice'));
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

        $grammar = Notice::find($id);
        $grammar->branch_id = $request->branch ?? auth()->user()->branch_id;
        $grammar->title = $request->title;
        $grammar->content = $request->content;
        $grammar->is_published = $request->is_published;
        $grammar->user_id = $request->user()->id;
        $grammar->save();

        return redirect()->route('back-end.notice.index', ['type' => $grammar->type]);
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
                    Notice::find($item)->delete();
                }
            }
        }else{
            Notice::find($id)->delete();
        }

        if(!request()->ajax()){
            return back();
        }

    }
}
