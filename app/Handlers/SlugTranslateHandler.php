<?php
// +----------------------------------------------------------------------
// | Version: V1
// +----------------------------------------------------------------------

/**
 * @Name 百度翻译类
 * @Description
 * @Auther LoCarlu
 * @Date 2022/3/28 14:41
 */

namespace App\Handlers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Overtrue\Pinyin\Pinyin;


class SlugTranslateHandler
{
    // API 地址
    private $api;
    // appid
    private $appid;
    // key
    private $key;
    // from
    private $from;
    // to
    private $to;

    public function __construct()
    {
        // 配置信息
        $this->api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $this->appid = config('services.baidu_translate.appid');
        $this->key = config('services.baidu_translate.key');
        $this->from = 'zh';
        $this->to = 'en';
    }

    public function translate($text)
    {
        // 如果没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($this->appid) || empty($this->key)) {
            return $this->pinyin($text);
        }

        return $this->baiDuPinYin($text);
    }

    public function pinyin($text)
    {
        return Str::slug(app(Pinyin::class)->permalink($text));
    }

    public function baiDuPinYin($text)
    {
        // 实例化 HTTP 客户端
        $http = new Client;

        $salt = time();

        // 根据文档，生成 sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($this->appid. $text . $salt . $this->key);

        // 构建请求参数
        $query = http_build_query([
            "q"     => $text,
            "from"  => $this->from,
            "to"    => $this->to,
            "appid" => $this->appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // 发送 HTTP Get 请求
        $response = $http->get($this->api.$query);

        $result = json_decode($response->getBody(), true);

        // 尝试获取获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return Str::slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyin($text);
        }
    }
}
