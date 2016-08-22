<?php

namespace App\Http;

class ParseVideo
{
    /**
     * 根据URL解析视频资源
     * @param $url
     * @return array|void
     */
    public function getVideoDownloadList($url)
    {
        $api = 'http://www.shokdown.com/parse.php';
        $data = [
            'cache-control' => 'no-cache',
            'accept-language' => 'zh-CN,zh;q=0.8,en;q=0.6',
            'referer' => 'http://www.shokdown.com/index.php',
            'dnt' => '1', // 要求服务器不要跟着用户记录
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'content-type' => 'application/x-www-form-urlencoded',
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.63 Safari/537.36',
            'upgrade-insecure-requests' => '1',
            'x-devtools-emulate-network-conditions-client-id' => 'D045B439-DA29-4CDF-8A2C-B9DE2769D7DD',
            'origin' => 'http://www.shokdown.com'
        ];

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $api);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HEADER, $data);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, ['url' => $url]);
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return $this->parseHtmlWithParse($result);
    }

    /**
     * 解析html为php数组
     * @param $html
     * @return array
     */
    private function parseHtmlWithParse($html)
    {
        // 匹配结果部分的html
        preg_match('/<br>\[<font color=red>标准<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>(<a.*<\/a>)/', $html, $result);
        if (!count($result)) {
            return [];
        }

        $result = $result[0];
        preg_match_all("/<a.*?href=\"(.*?)\".*?>/", $result, $urls);
        if (count($urls) < 1) {
            return [];
        }

        // 匹配到的所有URL
        $allUrl = $urls[1];

        // 匹配所有清晰度的数量
        preg_match('/<br>\[<font color=red>标准<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>/', $html, $counts);
        // 什么都没有匹配到
        if (!count($counts)) {
            return [];
        }
        $normalCount = $counts[1];
        $normalUrls = array_slice($allUrl, 0, $normalCount);

        preg_match('/<br>\[<font color=red>高清<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>/', $html, $counts);
        // 没有匹配到高清
        if (!count($counts)) {
            return [
                'normal' => [
                    'count' => $normalCount,
                    'data' => $normalUrls,
                ]
            ];
        }
        $highCount = $counts[1];
        $highUrls = array_slice($allUrl, $normalCount, $highCount);

        preg_match('/<br>\[<font color=red>超清<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>/', $html, $counts);
        // 没有匹配到超清
        if (!count($result)) {
            return [
                'normal' => [
                    'count' => $normalCount,
                    'data' => $normalUrls,
                ],
                'high' => [
                    'count' => $highCount,
                    'data' => $highUrls,
                ]
            ];
        }
        $hyperCount = $counts[1];
        $hyperUrls = array_slice($allUrl, $normalCount + $highCount, $hyperCount);

        // 全都解析到了
        return [
            'normal' => [
                'count' => $normalCount,
                'data' => $normalUrls,
            ],
            'high' => [
                'count' => $highCount,
                'data' => $highUrls,
            ],
            'hyper' => [
                'count' => $hyperCount,
                'data' => $hyperUrls,
            ]
        ];

    }

    /**
     * 匹配指定字符串
     * @param $str
     * @param $preg
     * @param int $len
     * @param int $bool
     * @return mixed
     */
    private function preg_substr($str, $preg, $len = 1, $bool = 0)
    {
        if ($bool) {
            preg_match_all($preg, $str, $ar);
        } else {
            preg_match($preg, $str, $ar);
        }
        return $ar[$len];
    }

    /**
     * AES加密
     * @param $key
     * @param $str
     * @return mixed
     */
    private function aes_encode($key, $str)
    {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);
    }

    /**
     * AES解密
     * @param $key
     * @param $str
     * @return mixed
     */
    private function aes_decode($key, $str)
    {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);
    }

    /**
     * 优酷json编码
     * @param $json
     * @return mixed
     */
    private function youkuJsondecode($json)
    {
        return $this->aes_decode("qwer3as2jin4fdsa", base64_decode($json));
    }

    /**
     * 获取EP
     * @param $sk
     * @param int $ctype
     * @return string
     */
    private function getEP($sk, $ctype = 20)
    {
        $pkey = 'b45197d21f17bb8a'; //21
        if ($ctype == 20) {
            $pkey = '9e3633aadde6bfec'; //20
        } else if ($ctype == 30) {
            $pkey = '197d21f1722361ac'; //30
        }
        return urlencode(base64_encode($this->aes_encode($pkey, $sk)));
    }

    /**
     * 发送请求解析视频真实地址
     * @param $get_url
     * @param null $post_send
     * @return mixed
     */
    private function curl($get_url, $post_send = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_url);
        if (isset($post_send)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_send);
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $add_header = array("User-Agent: Youku HD;3.9.4;iPhone OS;7.1.2;iPad4,1");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $add_header);
        $httpdata = curl_exec($ch);
        curl_close($ch);
        return $httpdata;
    }

    /**
     * 外部调用接口 获取优酷m3u8地址
     * @param $url 视频地址如:http://v.youku.com/v_show/id_XOTA5NjIyMTIw.html
     * @param null $vid
     * @return string
     */
    public function getYoukuM3u8($url, $vid = null)
    {
        $toUrl = "";
        if (empty($vid) && strstr($url, "/v_show/id_")) {
            $vid = $this->preg_substr($url, "|/v_show/id_(.*?)\.html|");
            if (strstr($vid, "_")) {
                $tmp = explode("_", $vid, 2);
                $vid = trim($tmp[0]);
            }
        }
        if (strlen($vid) > 3) {
            $ctype = 20;//指定播放ID 20
            $did = md5($ctype.",".$vid);
            $tm = $_SERVER['REQUEST_TIME'];
            $apiurl = "http://i.play.api.3g.youku.com/common/v3/play?audiolang=1&guid=7066707c5bdc38af1621eaf94a6fe779&ouid=3151cdbf1449478fad97c27cd5fa755b2fff49fa&ctype=%s&did=%s&language=guoyu&local_point=0&brand=apple&vdid=924690F1-A141-446B-A5E5-4A5A778BB4F5&local_time=0&os=ios&point=1&os_ver=7.1.2&id=d1d065eafb1411e2a705&deviceid=0f607264fc6318a92b9e13c65db7cd3c&ver=3.9.4&format=1,3,6,7&network=WIFI&btype=iPad4,1&vid=%s&pid=87c959fb273378eb&local_vid=%s";
            $json = $this->curl(sprintf($apiurl, $ctype, $did, $vid, $vid));
            if (isset($json)) {
                $data = json_decode($json);
                if (isset($data->data)) {
                    $aesData = $data->data;
                }
                if (isset($aesData) && strlen($aesData) > 12) {
                    $dejson = $this->youkuJsondecode($aesData);
                    $data = json_decode($dejson);
                }
                $sid_data = $data->sid_data;
                $sid = $sid_data->sid;
                $oip = $sid_data->oip;
                $token = $sid_data->token;
                $ep = $this->getEP(sprintf("%s_%s_%s", $sid, $vid, $token), $ctype);
                $epStr = sprintf("&sid=%s&token=%s&oip=%s&did=%s&ctype=%s&ev=1&ep=%s", $sid, $token, $oip, $did, $ctype, $ep);
            }
            $toUrl = "http://pl.youku.com/playlist/m3u8?ts=$tm&keyframe=1&vid=$vid&type=hd3".$epStr;
        }
        return $toUrl;
    }

}