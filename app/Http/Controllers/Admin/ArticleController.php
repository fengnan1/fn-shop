<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //排序
            $column = $request->get('order')[0]['column'];
            $dir = $request->get('order')[0]['dir'];
            //排序字段
            $orderField = $request->get('columns')[$column]['data'];
////            var_dump($orderField);
            //开始时间
            $datemin = $request->get('datemin');
            //结束时间
            $datemax = $request->get('datemax');
            //搜索关键字
            $search = $request->get('title');
//            dd($search);

            //创建一个查询构造器
            $query = Article::where('id', '!=', 0);
//
            if (!empty($datemin) && !empty($datemax)) {
                $datemin = date('Y-m-d H:i:s', strtotime($datemin . '00:00:00'));
                $datemax = date('Y-m-d H:i:s', strtotime($datemax . '23:59:59'));
//
                $query->whereBetween('created_at', [$datemin, $datemax])->get();
            }
//
//            //搜索关键词
            if (!empty($search)) {

                $query->where('title', 'like', "%{$search}%");
                //记录总数
                $totla =   $query->count();

            }else{
                $totla =   $query->count();
            }
            //开始位置
            $start = $request->get('start', 0);
            //获取记录数
            $length = min(100, $request->get('length', 10));
            //获取数据
            $data = $query->orderBy($orderField,$dir)->offset($start)->limit($length)->get();



            $result = [
                'draw' => $request->get('draw'),//客户端调用服务器次数标识
                'recordsTotal' => $totla,//获取数据记录总条数
                'recordsFiltered' => $totla,//数据过滤后的总数量
                'data' => $data,//获得的具体数据

            ];
//            dd($result);
            return $result;

        }
        $article = Article::get();

        return view('admin.article.index', ['article' => $article]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Article $article)
    {
//        $article=Article::get();
//        dd($article);
        return view('admin.article.create_edit',compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['_token']);
       $result=Article::create($data);
       return $this->success_msg();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
