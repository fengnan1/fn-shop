<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use Validator;

class ManagerController extends BaseController
{


/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
    public function index()
    {
        $data=Manager::paginate(1000);

//        $this->pagesize
        return view('admin.manager.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


       return view('admin.manager.create_edit',['managers'=>(new Manager())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//dd($request->except(['_token']));
        $validator=Validator::make($request->except(['_token']), [
            'username' => ["required", "unique:managers", "regex:/^[a-z-A-Z-0-9_]\w{6,18}$/i"],
            'truename'=>['required'],
            'password_confirmation' => ['required', "regex:/^[a-zA-Z0-9\W_!@#$%^&*`~()-+=]{6,16}$/"],
            'password' => ['required','confirmed'],
            //自定义验证规则
            'mobile'=>['required','phone'],
            'email'=>['required','email'],
        ]);
//        dd($validator->errors()->first());
        if ($validator->fails()) {
            return $this->error_msg($validator->errors()->first());
        }
        $data=$request->except(['_token','password_confirmation']);
        $data['password']=bcrypt($data['password']);
//        dd($data);
        $result=Manager::create($data);
        if ($result){
            return $this->success_msg('Success', $result);
        }else{
            return $this->error_msg('已经创建或者用户已存在');
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
//        return view('admin.managers.show',['']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd($id);
        $manager=Manager::find($id);
        return view('admin.manager.create_edit',['managers'=>$manager]);
    }

    /**
     * 修改管理员
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
        dd($id);
    }

    /**
     * 删除管理员
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       dd($id);
    }

    /**
     * 修改管理员状态
     * @param Request $request
     * @return array
     */
    public function stop(Request $request){
        $id=$request->only('managers')['managers'];
        if (auth('admin')->user()->id==$id){
            return $this->error_msg('无法更改自身的状态');
        }
        if (is_numeric($id)){

            $status=Manager::where('id',$id)->select('id','status')->first();

           if ($status->status==1){
               Manager::where('id',$id)->update(['status'=>2]);
               return $this->success_msg();
           }else{
//               Manager::where('id',$id)->update(['status'=>1]);
//               return $this->success_msg();
               return $this->error_msg('已经被禁用');
           }
        }else{
        return $this->error_msg('参数必须是数字');
        }




    }

    public function  start(Request $request){
        $id=$request->only('managers')['managers'];
//        if (auth('admin')->user()->id==$id){
//            return $this->error_msg('无法禁用自身');
//        }
        if (is_numeric($id)){

            $status=Manager::where('id',$id)->select('id','status')->first();
//dd($status);
            if ($status->status==2){
                Manager::where('id',$id)->update(['status'=>1]);
                return $this->success_msg();
            }else{
                return $this->error_msg('已经启用了');
            }
        }else{
            return $this->error_msg('参数必须是数字');
        }
    }

}
