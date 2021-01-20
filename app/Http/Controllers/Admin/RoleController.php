<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use function foo\func;
use Illuminate\Http\Request;
use Validator;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     *  * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->get('role_name', '');


        $data = Role::when($params, function ($query) use ($params) {

            $query->where('role_name', 'like', "%{$params}%");
        })->paginate($this->pagesize);


        return view('admin.role.index', compact('data', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {

        return view('admin.role.create_edit', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $validator = Validator::make($data, [
            'role_name' => ["required", "unique:roles"],
        ]);
//        dd($validator->errors()->first());
        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }
//        dd($request->all());
        $result = Role::create($data);
        if ($result) {
            return $this->success_msg();
        } else {
            return $this->error_msg('添加失败');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        dd($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        return view('admin.role.create_edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->except(['_token', '_method']);
        $validator = Validator::make($data, [
            'role_name' => ["required", "unique:roles,role_name,$role->id,id"],
        ]);
//        dd($validator->errors()->first());
        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }
//        dd($request->all());save
        $result = $role->update($data);
        if ($result) {
            return $this->success_msg();
        } else {
            return $this->error_msg('修改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            Role::find($id)->delete();
//        Role::find($id)->forceDelete();//强制删除
        } catch (\Exception $e) {

            return $this->error_msg('修改失败');

        }
        return $this->success_msg();



    }
}
