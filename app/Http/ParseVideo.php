<?php

namespace App\Http;

class ParseVideo
{
    /**
     * 根据URL解析视频资源
     * @param $url
     * @return array|void
     */
    public static function parseYouku1($url)
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

        return self::parseHtmlWithParse1($result);
    }

    /**
     * 解析html为php数组
     * @param $html
     * @return array
     */
    private static function parseHtmlWithParse1($html) {

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
     * 根据URL解析视频资源
     * @param $url
     */
    public static function parseYouku2($url) {
        $api = 'http://www.avziliao.com/vip/index.php';
        $data = [
            'cache-control' => 'no-cache',
            'accept-language' => 'zh-CN,zh;q=0.8,en;q=0.6',
            'dnt' => '1', // 要求服务器不要跟着用户记录
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'content-type' => 'application/x-www-form-urlencoded',
            'user-agent' => 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.63 Safari/537.36',
            'upgrade-insecure-requests' => '1',
        ];

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $api . '?url=' . $url . '&type=youku');
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HEADER, $data);
        curl_setopt ($curlHandle, CURLOPT_REFERER, "http://english.6ag.cn/");
        $result = curl_exec($curlHandle);
        curl_close($curlHandle);

        return self::parseHtmlWithParse2($result);
    }

    /**
     * 解析为网页播放器
     * @param $html
     */
    private static function parseHtmlWithParse2($html) {
        $html = preg_replace('/api.php/', 'http://www.avziliao.com/vip/api.php', $html);
        echo $html;
    }
    
    public static function parseYouku3($url) {

    }
}