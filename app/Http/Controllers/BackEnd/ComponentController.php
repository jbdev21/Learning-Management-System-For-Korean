<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
         if(request()->ajax()){
            return Component::whereDoesntHave('parent')->get()->map(function($q){
                return [
                    'id'            => $q->id,
                    'name'          => $q->name,
                    'inputs'        => $q->inputs,
//                    'components'    => $q->children,
                    'components'    => $q->children()->orderBy('order')->get()->map(function($q){
                        return [
                            'id'            => $q->id,
                            'name'          =>  $q->name,
                            'parent_id'     => $q->parent_id,
                            'components'    => $q->children->map(function($q){
                                return [
                                    'id'        => $q->id,
                                    'name'      => $q->name,
                                    'parent_id' => $q->parent_id,
                                    'inputs'    => $q->inputs,
                                    'type'      => $q->type,
                                    'sub_components' => $q->children->map(function($q){
                                                return [
                                                    'id'        => $q->id,
                                                    'name'      => $q->name,
                                                    'parent_id' => $q->parent_id,
                                                    'inputs'    => $q->inputs,
                                                    'type'      => $q->type,
                                                ];
                                        })
                                ];
                            })
                        ];
                    })
                ];
            });
         }

        return view('back-end.component.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'name' => 'required',
        ]);

        $component = new Component;
        $component->name = $request->name;
        $component->parent_id = $request->parent_id;
        $component->inputs = $request->inputs;
        $component->type = $request->type ?? 'ordinary';
        $component->save();

        if(!$request->ajax()){
            return back();
        }else{
            return [
                'id' => $component->id,
                'name' => $component->name,
                'parent_id' => $component->parent_id,
                'type' => $component->type,
                'components' => [],
                'inputs'    => $component->inputs,
                'sub_components' => []
            ];
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
        $component = Component::find($id);
        $component->name = $request->name;
        $component->inputs = $request->inputs;
        $component->type = $request->type;
        $component->save();

        if(!$request->ajax()){
            return back();
        }else{
            return [
                'id' => $component->id,
                'name' => $component->name,
                'parent_id' => $component->parent_id,
                'type' => $component->type,
                'inputs'    => $component->inputs
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $component = Component::find($id);
        $component->children()->delete();
        $component->delete();

        if(request()->ajax()){
            return response()->json(['message' => 'item deleted'], 200);
        }else{
            return back();
        }
    }
}
