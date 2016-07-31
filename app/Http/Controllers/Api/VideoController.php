<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class VideoController extends BaseController
{
    public function test()
    {
        $url = 'http://v.youku.com/v_show/id_XMTUwNjQ0NDQ4MA==.html';
        $data = $this->parseYouku($url);
        dd($data);
    }
    
    /**
     * 根据URL解析视频资源
     * @param $url
     * @return array|void
     */
    public function parseYouku($url)
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

        return $this->parseHtml($result);
    }

    /**
     * 解析html为php数组
     * @param $html
     * @return array
     */
    function parseHtml($html) {

        // 匹配结果部分的html
        $html.preg_match('/<br>\[<font color=red>标准<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>(<a.*<\/a>)/', $html, $result);
        if (!count($result)) {
            return [];
        }

        $result = $result[0];
        $result.preg_match_all("/<a.*?href=\"(.*?)\".*?>/", $result, $urls);
        if (count($urls) < 1) {
            return [];
        }
        
        // 匹配到的所有URL
        $allUrl = $urls[1];

        // 匹配所有清晰度的数量
        $html.preg_match('/<br>\[<font color=red>标准<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d)<\/font>段视频组成<BR>/', $html, $counts);
        $normalCount = $counts[1];
        $html.preg_match('/<br>\[<font color=red>高清<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d)<\/font>段视频组成<BR>/', $html, $counts);
        $highCount = $counts[1];
        $html.preg_match('/<br>\[<font color=red>超清<\/font>\]&nbsp;此视频由视频网分割为以下<font color=red>(\d*?)<\/font>段视频组成<BR>/', $html, $counts);
        $hyperCount = $counts[1];

        $normalUrls = array_slice($allUrl, 0, $normalCount);
        $highUrls = array_slice($allUrl, $normalCount, $highCount);
        $hyperUrls = array_slice($allUrl, $normalCount + $highCount, $hyperCount);

        // 没有解析到任何URL
        if (!count($normalUrls)) {
            return [];
        }

        // 没有解析到高清
        if (!count($highUrls)) {
            return [
                'normal' => [
                    'count' => $normalCount,
                    'data' => $normalUrls,
                ]
            ];
        }

        // 没有解析到超清
        if (!count($hyperUrls)) {
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
}