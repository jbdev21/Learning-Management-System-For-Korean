<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($paginate = 5)
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        return view('back-end.notification.index', compact('notifications'));
    }
    

    public function menuList(){
        return auth()->user()->notifications()->orderBy('created_at', 'DESC')->paginate(100)->map(function($q){
            return [
                'id'            => $q->id,
                'title'         => $q->data['title'],
                'title'         => $q->data['title'],
                'message'       => $q->data['message'],
                'link'          => notification_url($q->data['link'], $q->id),
                'avatar'        => $q->data['avatar'],
                'read_at'       => $q->read_at,
                'created_at'    => $q->created_at,
            ];
        });
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
        //
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
        //
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
        $type = $request->type;
        if($type == "delete"){
            auth()->user()->notifications()->whereIn('id', $request->items)->delete();
        }else{
            foreach(auth()->user()->notifications()->whereIn('id', $request->items)->get() as $notif){
                $notif->markAsRead();
            }
        }

        return back();
    }

    public function markAllAsRead(){
        auth()->user()->notifications->markAsRead();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
