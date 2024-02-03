<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::branched()->get();
        return view('back-end.banner.index', compact('banners'));
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
        $this->validate($request,[
            'banner' => 'required',
            'show_start' => 'required|date',
            'show_end' => 'nullable|date',
            'link' => 'nullable|url',
        ]);

        $banner = new Banner;
        $banner->branch_id  = $request->user()->branch_id;
        $banner->show_start = $request->show_start;
        $banner->show_end   = $request->show_end;
        $banner->link       = $request->link;
        $banner->is_show    = $request->is_show ? 1 : 0;
        $banner->save();

        if($request->hasFile('banner')){
            $photo = $banner->setFolder(public_path('/uploads/banners'))->upload($request->file('banner'), 'banner');
            $photo->folder(public_path('/uploads/banners'))->imageResize($photo->path, 940, 750);
        }

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
        $banner = Banner::find($id);
        return view('back-end.banner.edit', compact('banner'));
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
          $this->validate($request,[
            // 'banner' => 'required',
            'show_start' => 'required|date',
            'show_end' => 'nullable|date',
            'link' => 'nullable|url',
        ]);

        $banner = Banner::find($id);
        $banner->show_start = $request->show_start;
        $banner->show_end   = $request->show_end;
        $banner->link       = $request->link;
        $banner->is_show    = $request->is_show ? 1 : 0;
        $banner->save();

        if($request->hasFile('banner')){
            $banner->setFolder(public_path('/uploads/banners'))->clearImage('banner');
            $photo = $banner->setFolder(public_path('/uploads/banners'))->upload($request->file('banner'), 'banner');
            $photo->folder(public_path('/uploads/banners'))->imageResize($photo->path, 940, 750);
        }

        return redirect()->route('back-end.banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->setFolder(public_path('/uploads/banners'))->clearImage('banner');
        $banner->delete();
        return back();
    }
}
