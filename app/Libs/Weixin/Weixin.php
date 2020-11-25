<?php

namespace App\Libs\Weixin;
use Cache;
use Log;

class Weixin
{
   public $token = '';

    function __construct()
    {
        $this->wx_access_token();
    }

    /**
     * 微信的access_token
     */
    public function wx_access_token(){
        $access_token = Cache::store('database')->get('access_token');

        if(empty($access_token)){
            $access_token = $this->save_access_token();
        }
        $this->token = $access_token;
    }


    /**
     * 获取并保存access_token1.5小时
     * @return bool
     */
    public function save_access_token(){
        $new_data = array();
        $AppId = config("weixin.wx_appid");
        $AppSecret = config("weixin.wx_appsecret");
        $getUrl = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$AppId.'&secret='.$AppSecret;
        $result = $this->http_request($getUrl);
        $response = json_decode($result,true);
        if(!empty($response)){
            if(!empty($response['access_token'])) {
                Cache::store('database')->put('access_token', $response['access_token'], 90);
                return $response['access_token'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * 发起请求
     * @param string $url 地址
     * @param string $res 请求体
     * @param string $file 上传文件的绝对路径
     * @return mixed
     */
    public function http_request($url, $res = '', $file = '')
    {
        $ch = curl_init();
        //相关设置
        curl_setopt($ch, CURLOPT_URL, $url);
        //请求头不要
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //请求得到的结果 不直接输出而是以字符串的形式返回（必须写）
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置请求的超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //设置浏览器型号
//        curl_setopt($ch, CURLOPT_USERAGENT, 'MSIE001');
        //证书不检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //设置为post请求
        if (!empty($res)){//如果$res不为空则
            //开启post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            //post请求的数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
        }
        //发起请求
        $data = curl_exec($ch);

        //有没有发生异常
        if (curl_errno($ch) > 0) {
            //把错误发送给客户端
            echo curl_error($ch);
        }

        //关闭请求
        curl_close($ch);
        return $data;
    }
}