<?php

namespace App\Http\Controllers\Api\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Weixin\Weixin;
use Cache;
use DB;
class WechatController extends Controller
{
    const  TOKEN = 'weixin';

    public function ceshi()
    {
//        $time=strtotime('1606287900');
//        $time=date('Y-m-d h:i:s','1606287900');
        $poor = new Weixin();
//         return $time;
        return $token = $poor->token;
    }

    /**
     * 创建自定义菜单
     * @param array $menu
     * @return array|mixed
     */
    public function createMenu()
    {
        $menu = config('arr');
//        dd($menu);
        //数组转为json
        $data = json_encode($menu, JSON_UNESCAPED_UNICODE);#256
//        $token = Cache::store('database')->get('access_tokens', function () {
//            return DB::table('cache')->get();
//        });
//
//        dd($token);
        //创建自定义菜单URl
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . (new Weixin())->token;
        //发起请求
        $json = $this->http_request($url, $data);
        return $json;
    }

    /**
     * 删除自定义菜单
     * @return mixed
     */
    public function delMenu()
    {
        //
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=' . (new Weixin())->token;
        //发起请求
        $json = $this->http_request($url);
        return $json;
    }
    //事件的处理t
    private function eventFun($obj)
    {
        //事件的名称
        $Event = $obj->Event;
        switch ($Event) {
            case 'CLICK':
                //点击事件
                return $this->clickFun($obj);
                break;
            case 'subscribe':
                //点击关注
                $EventKey = $obj->EventKey;
                $EventKey = (string)$EventKey;
                if (empty($EventKey)) {//则为顶级
                    $sql = "insert into wx_user (wx_openid) values(?)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$obj->FromUserName]);
                } else {
                    $id = (int)str_replace('qrscene_', '', $EventKey);
                    $sql = "select * from wx_user where id=$id";
                    $row = $this->pdo->query($sql)->fetch();
//                    var_dump($row);
                    //添加本人的记录到数据库
                    $sql = "insert into wx_user (wx_openid,level_1,level_2,level_3) values(?,?,?,?)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([$obj->FromUserName, $row['wx_openid'], $row['level_1'], $row['level_2']]);

                }
                return $this->createText($obj, "这里有你想要的一切\n感谢您的关注");

                break;
            case 'LOCATION':
                $wx_openid = $obj->FromUserName;
                $Latitude = $obj->Latitude;//经度
                $Longitude = $obj->Longitude;//维度
                //修改表记录
                $sql = "update wx_user set Latitude=?,Longitude=? where wx_openid=?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$Latitude, $Longitude, $wx_openid]);
                break;
        }
    }

    //处理点击事件
    private function clickFun($obj)
    {
        $EventKey = $obj->EventKey;
        switch ($EventKey) {
            case'首页001':
                return $this->createText($obj, '你点击首页按钮');
                break;
            case'客服001':
                return $this->createText($obj, '你点击客服按钮');
                break;
            default:
                return $this->createText($obj, '这个操作我不认识');
        }
    }

    public function index()
    {
        //判断是否是第一次接入
        if (!empty($_GET['echostr'])) {
            echo $this->checkSignature();
        } else {
            echo $this->acceptmsg();
        }
    }

    /**
     * 验签
     * @return bool
     */
    private function checkSignature()
    {
        //得到微信公众号发过来的数据
        $input = $_GET;
        //微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
        $signature = $input["signature"];
        //把echostr放在临时变量中
        $echostr = $input['echostr'];
        //从数组中删除
        unset($input['echostr'], $input["signature"]);
        //将token添加到数组中
        $input['token'] = self::TOKEN;
        //进行字典排序
        $tmpStr = implode($input);
        //进行sha1加密
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return $echostr;
        } else {
            return false;
        }
    }

    /**
     * 接收公众号发送回过来的数据
     */
    private function acceptmsg()
    {
        //获取原生请求数据
        $xml = file_get_contents('php://input');
        //把接收的xml转化成对象来处理
        $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        //写接收日志
        $this->writelog($xml);
        //处理回复消息
        //1,判断消息的类型
        //2，根据不同的消息类型处理不同的消息

        $MsgType = $obj->MsgType;
//        //调用方法
        $fun = $MsgType . 'Fun';
////       var_dump($fun);
        echo $ret = $this->$fun($obj);
//        echo $ret = call_user_func([$this, $fun], $obj);
////        var_dump($ret);
//        //写发送日志
        $this->writelog($ret, 2);

    }

    /**
     * 写日志
     */
    private function writelog(string $xml, int $flag = 1)
    {
        date_default_timezone_set('PRC');
        $flagstr = $flag == 1 ? '请求' : '发送';
        $prevstr = '【' . $flagstr . '】' . date('Y-m-d H:i:s', time()) . "__________\n";
        $log = $prevstr . $xml . "\n_____\n";
        file_put_contents('../storage/logs/wx.xml', $log, FILE_APPEND);
        return true;

    }

    //处理回复文本
    private function textFun($obj)
    {
        //要回复的内容
        $content = $obj->Content;
        if ('音乐' == $content) {
            return $this->musicFun($obj);
        } elseif (strstr($content, '位置-')) {
            //加油站
            #得到关键词
//            $str = str_replace('位置-', $content);
//            $str = trim($str);
            $wx_openid = $obj->FromUserName;
            //查询数据库获取用户的经纬度
            $Latitude = 30.582998;//经度112.311028,31.496382
            $Longitude = 114.373451;//维度114.373451,30.582998

            $url = 'https://restapi.amap.com/v3/place/around?key=5324a49d809b2cc832d444c69554500b&location=' . $Longitude . ',' . $Latitude . '&radius=10000&types=010100&offset=20&page=1&extensions=all';
            $urls = 'https://restapi.amap.com/v3/place/around?key=5324a49d809b2cc832d444c69554500b&location=114.373451,30.582998&keywords=&types=010100&radius=10000&offset=20&page=1&extensions=all';
            $json = $this->http_request($urls);

            $json_arr = json_decode($json, true);
            #判断是否有搜索结果
            if (count($json_arr['pois']) == 0) {
                $content = '该服务不存在';
            } else {
                $content = '/:rose/:rose/:rose/:rose/:rose' . "\n";
                $content .= '名称:' . $json_arr['pois'][0]['name'] . "\n";
                $content .= '地址:' . $json_arr['pois'][0]['address'] . "\n";
                $content .= '与你的距离:' . $json_arr['pois'][0]['distance'] . "米\n";
                $content .= '/:rose/:rose/:rose/:rose/:rose';
            }

            return $this->createText($obj, $content);

        }
        $content = '公众号:' . $content;
        return $this->createText($obj, $content);
    }

    //生成文本消息xml
    private function createText($obj, string $content)
    {
        $str = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $content);
//        var_dump($str);
        return $str;
    }

    //处理回复图片
    private function imageFun($obj)
    {
        //要回复的内容
        $MediaId = $obj->MediaId;
        return $this->createImage($obj, $MediaId);
    }

    //生成图片消息
    private function createImage($obj, string $MediaId)
    {
        $str = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image><MediaId><![CDATA[%s]]></MediaId></Image>
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $MediaId);
        return $str;
    }

    //处理回复音乐
    private function musicFun($obj)
    {
        //要回复的内容
        $MediaId = 'mnJVSFJ5bGhB58H_3Hc62MjCrblGwAigw5nDuEY2vRokuAM5DBWBZAMenrP8Wq6g';
        $url = 'https://www.xiami.com/song/1770201852';
        return $this->createMusic($obj, $url, $MediaId);
    }

    //生成音乐回复消息
    private function createMusic($obj, $url, string $MediaId)
    {
        $str = '<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[music]]></MsgType>
  <Music>
    <Title><![CDATA[夜空中最亮的心]]></Title>
    <Description><![CDATA[一首非常好听的歌]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
  </Music>
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $url, $url, $MediaId);
        return $str;
    }

    //处理回复语音
    private function voiceFun($obj)
    {
        //要回复的内容
//        $MediaId = $obj->MediaId;
//        return $this->createVoice($obj, $MediaId);
        return $this->createVoice($obj, $obj->Recognition);
    }

    //生成语音回复消息
    private function createVoice($obj, string $content)
    {
        $str = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $content);
//        var_dump($str);
        return $str;
    }

    //生成地理位置信息
    private function createLocation($obj, $Location_X, $Location_Y)
    {
        $str = '<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[location]]></MsgType>
  <Location_X>%s</Location_X>
  <Location_Y>%s</Location_Y>
  <Label><![CDATA[位置信息]]></Label>
  
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $Location_X, $Location_Y);
        return $str;
    }

    //处理回复地理位置
    private function locationFun($obj)
    {
        //要回复的内容
        $Location_X = $obj->Location_X;
        $Location_Y = $obj->Location_Y;
        return $this->createLocation($obj, $Location_X, $Location_Y);
    }

    //生成链接消息aa
    private function createLink($obj, $title, $Description, $url)
    {
        $str = '<xml>
  <ToUserName><![CDATA[%s]]></ToUserName>
  <FromUserName><![CDATA[%s]]></FromUserName>
  <CreateTime>%s</CreateTime>
  <MsgType><![CDATA[link]]></MsgType>
  <Title><![CDATA[%s]]></Title>
  <Description><![CDATA[%s]]></Description>
  <Url><![CDATA[%s]]></Url>
  
</xml>';
        $str = sprintf($str, $obj->FromUserName, $obj->ToUserName, time(), $title, $Description, $url);
        return $str;
    }

    //处理回复链接消息
    private function linkFun($obj)
    {
        //要回复的内容
        $title = $obj->Title;
        $Description = $obj->Description;
        $url = $obj->Url;
        return $this->createLink($obj, $title, $Description, $url);
    }

    /**
     * 发起请求
     * @param string $url 地址
     * @param string $res 请求体
     * @param string $file 上传文件的绝对路径
     * @return mixed
     */
    private function http_request($url, $res = '', $file = '')
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
        curl_setopt($ch, CURLOPT_USERAGENT, 'MSIE001');
        //证书不检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //设置为post请求
        if (!empty($res)) {//如果$res不为空则
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
