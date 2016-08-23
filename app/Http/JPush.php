<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/8/21
 * Time: 下午11:46
 */

namespace App\Http;

class JPush
{
    private $app_key = '1d918a27ec1db14f243a79cf';
    private $master_secret = '6be3a5f8d0ea165ab2a69632';
    private $url = "https://api.jpush.cn/v3/push";

    /**
     * 发送远程通知
     * @param $receiver 接收者
     * @param $content 内容
     * @param $parameters 参数
     * @return string
     */
    public function sendRemoteNotification($receiver, $content, $parameters)
    {
        $result = $this->push($receiver, $content, $parameters);
        if ($result) {
            $resultArray = json_decode($result, true);
            if (isset($resultArray['error'])) {
                $errorCode = $resultArray['error']['code'];
                switch ($errorCode) {
                    case 200:
                        $message = '发送成功！';
                        break;
                    case 1000:
                        $message = '失败(系统内部错误)';
                        break;
                    case 1001:
                        $message = '失败(只支持 HTTP Post 方法，不支持 Get 方法)';
                        break;
                    case 1002:
                        $message = '失败(缺少了必须的参数)';
                        break;
                    case 1003:
                        $message = '失败(参数值不合法)';
                        break;
                    case 1004:
                        $message = '失败(验证失败)';
                        break;
                    case 1005:
                        $message = '失败(消息体太大)';
                        break;
                    case 1008:
                        $message = '失败(appkey参数非法)';
                        break;
                    case 1020:
                        $message = '失败(只支持 HTTPS 请求)';
                        break;
                    case 1030:
                        $message = '失败(内部服务超时)';
                        break;
                    default:
                        $message = '失败(返回其他状态，目前不清楚额，请联系开发人员！)';
                        break;
                }
            } else {
                $message = "发送成功！";
            }
        } else {
            $message = '接口调用失败或无响应';
        }

        return $message;
    }

    /**
     * 推送参数配置
     * @param string $receiver 接受者
     * @param string $content 推送内存
     * @param string $parameters 参数
     * @param string $m_time 离线保存时间
     * @return bool|mixed
     */
    private function push($receiver = 'all', $content = '', $parameters = '', $m_time = '86400')
    {
        $base64 = base64_encode("$this->app_key:$this->master_secret");
        $header = ["Authorization:Basic $base64", "Content-Type:application/json"];
        $data['platform'] = 'all';          // 目标用户终端手机的平台类型android,ios
        $data['audience'] = $receiver;      // 目标用户

        $data['notification'] = [
            "alert" => $content,
            "android" => [
                "alert" => $content,
                "title" => "",
                "builder_id" => 1,
                "extras" => $parameters
            ],
            "ios" => [
                "alert" => $content,
                "badge" => "+1",
                "sound" => "default",
                "extras" => $parameters
            ]
        ];

        // 苹果自定义---为了弹出值方便调测
        $data['message'] = [
            "msg_content" => $content,
            "extras" => $parameters
        ];

        // 附加选项
        $data['options'] = [
            "sendno" => time(),
            "time_to_live" => $m_time, // 保存离线时间的秒数默认为一天
            "apns_production" => true, // 指定 APNS 通知发送环境：false开发环境，true生产环境
        ];

        $param = json_encode($data);
        $result = $this->pushCurl($param,$header);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 推送的Curl方法
     * @param string $param 推送参数
     * @param string $header http请求头
     * @return bool|mixed
     */
    private function pushCurl($param = "",$header = "")
    {
        if (empty($param)) {
            return false;
        }

        $postUrl = $this->url;
        $curlPost = $param;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$postUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}