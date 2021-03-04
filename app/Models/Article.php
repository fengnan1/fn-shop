<?php

namespace App\Models;

class Article extends Base
{

    //可以赋值的字段
    protected $fillable = ['title', 'digest', 'author', 'source', 'url', 'content'];

    //时间字段自动完成
    public $timestamps = true;

    //软删除标识字段
    protected $dates=['deleted_at'];

    //    默认给数据库字段赋值
    protected $attributes = [
        'url' => '/uploads/article/1.jpg',
        'content'=>'违反完整性约束：1048列“内容”不能为空（SQL：插入“文章”（“ URL”，“标题”，“摘要”，“作者”，“源”，“内容”， `updated_at`，`created_at`）值（/upload/article/1.jpg，我爱你，坎坎坷坷，随意吧，好的，，2021-02-23 23:47:52，2021-02-23 23:47:52））'
    ];

    protected $appends=['action'];
//
    public function  getActionAttribute()
    {

        return $this->showBtn('admin.articles.show').'&nbsp;'. $this->editBtn('admin.articles.edit').'&nbsp;'.$this->delBtn('admin.articles.destroy');
    }
}
