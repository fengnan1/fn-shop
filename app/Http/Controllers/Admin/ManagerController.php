<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use App\Models\Role;
use Illuminate\Http\Request;
use Validator;
use Mail;
use Illuminate\Mail\Message;
use Hash;
class ManagerController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Manager::orderBy('id', 'asc')->withTrashed()->paginate($this->pagesize);

        return view('admin.manager.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('admin.manager.create_edit', ['managers' => (new Manager())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//dd($request->except(['_token']));
        $validator = Validator::make($request->except(['_token']), [
            'username' => ["required", "unique:managers", "regex:/^[a-z-A-Z-0-9_]\w{6,18}$/i"],
            'truename' => ['required'],
            'password_confirmation' => ['required', "regex:/^[a-zA-Z0-9\W_!@#$%^&*`~()-+=]{6,16}$/"],
            'password' => ['required', 'confirmed'],
            //自定义验证规则
            'mobile' => ['required', 'phone'],
            'email' => ['required', 'email'],
        ]);
//        dd($validator->errors()->first());
        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }
        $data = $request->except(['_token', 'password_confirmation']);
        $data['password'] = bcrypt($data['password']);
//        dd($data);
        $result = Manager::create($data);

        Mail::send('mail.adduser', ['data' => $result], function (Message $messages) use ($result) {

            $messages->to($result->email);

            $messages->subject('账号已开通,请激活再使用');

        });
        if ($result) {
            return $this->success_msg('Success', $result);
        } else {
            return $this->error_msg('已经创建或者用户已存在');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manager=Manager::find($id);

        $role=Role::all();
        return view('admin.manager.show',compact('manager','role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd($id);
        $manager = Manager::find($id);
        return view('admin.manager.create_edit', ['managers' => $manager]);
    }

    /**
     * 修改管理员
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        //当前用户
        $managers=Manager::find($id);
        //验证密码是否一致
        $bool=Hash::check($managers->password,$data['password']);
//        auth('admin')->user()->id == $id
        //验证提交的数据
        $validator = Validator::make($data, [
//            'truename' => ['required'],
            'password_confirmation' => ['required', "regex:/^[a-zA-Z0-9\W_!@#$%^&*`~()-+=]{6,16}$/"],
            'password' => ['required', 'confirmed'],
            //自定义验证规则
            'mobile' => ['required', 'phone', "unique:managers"],
            'email' => ['required', 'email'],
        ]);
//        dd($validator->errors()->first());
        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }



        $result = Manager::where('id', $id)->update([
            'email' => $data['email'],
            'truename' => $data['truename'],
            'password' => bcrypt($data['password']),
            'gender' => $data['gender'],
            'mobile'=> $data['mobile']
        ]);
        return $this->success_msg();
    }

    /**
     * 删除管理员
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Manager::find($id)->delete();
//        Manager::find($id)->forceDelete();

        return $this->success_msg();

    }

    /**
     * 恢复管理员
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restores($id)
    {


        Manager::onlyTrashed()->where('id', $id)->restore();

        return $this->success_msg();

    }

    /**
     * 全选删除
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function patch_delete(Request $request)
    {
        $ids = $request->get('ids');
//dd($ids);
        Manager::destroy($ids);

        return $this->success_msg();

    }

    /**
     * 修改管理员状态
     * * @param  int $id
     * @return array
     */

    public function edit_status($id)
    {

        if (auth('admin')->user()->id == $id) {
            return $this->error_msg('无法改变用户自身状态');
        }

        if (is_numeric($id)) {
            $status = Manager::where('id', $id)->select('id', 'status')->first();

            if ($status->status == 1) {
                Manager::where('id', $id)->update(['status' => 2]);
                return $this->success_msg();
            } else {
                Manager::where('id', $id)->update(['status' => 1]);
                return $this->success_msg();
//                return $this->error_msg('已经被禁用');
            }

        } else {
            return $this->error_msg('参数必须是数字');
        }
    }


    public function assign(Request $request,$id)
    {
        dd($id);
        $role_id = $request->get('role_id');

        if (isset($role_id)) {
            Manager::where('id', $id)->update(['role_id' => $role_id]);

            return $this->success_msg();
        } else {
            return $this->error_msg('必须选择一个角色！');
        }

    }
}
