<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use Validator;

class NodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->get('node_name', '');


        $data = Node::when($params, function ($query) use ($params) {

            $query->where('node_name', 'like', "%{$params}%");
        })->paginate($this->pagesize);


        return view('admin.node.index', compact('data', 'params'));


    }

    /**
     * Show the form for creating a new resource.
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function create(Node $node)
    {
        $parents=Node::get();
        return view('admin.node.create_edit',compact('node','parents'));
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
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function edit(Node $node)
    {
        $parents=Node::get();

       return view('admin.node.create_edit',compact('node','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Node $node)
    {
        $data=$request->except(['_token','_method']);

        $validator = Validator::make($data, [
            'node_name' => ["required", "unique:nodes,node_name,$node->id,id"],
//            'icon' => ["regex:/^[$]|^[a-zA-Z0-9\W_!@#$%^&*`~()-+=]{6,16}$/"],
            'pid' => ["required",'integer'],
            'is_menu' => ["required",'integer'],
        ]);


        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }


        $result=$node->update($data);
        if($result){
            return   $this->success_msg();
        }else{
            return  $this->error_msg('更新失败');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Node  $node
     * @return \Illuminate\Http\Response
     */
    public function destroy(Node $node)
    {
        $result=$node->delete();
//        Node::onlyTrashed()->where('id',1)->restore();
        $node->onlyTrashed()->restore();
//        Node::find($id)->forceDelete();

        return $this->success_msg();
    }
}
