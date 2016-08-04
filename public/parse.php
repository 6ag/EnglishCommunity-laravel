<?php
function curl($get_url, $post_send = null) {
        //  set_time_limit(1);
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

/* 匹配指定字符串 */
function preg_substr($str, $preg, $len = 1, $bool = 0) {
        if ($bool) preg_match_all($preg, $str, $ar); else preg_match($preg, $str, $ar);
        return $ar[$len];
}

function aes_encode($key, $str){
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);
}

function aes_decode($key, $str){
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv);
}

function yk_jsondecode($json) {
        return aes_decode("qwer3as2jin4fdsa", base64_decode($json));
}

function getEP($sk, $ctype = 20) {
        $pkey = 'b45197d21f17bb8a'; //21
        if ($ctype == 20) $pkey = '9e3633aadde6bfec'; //20
        else if ($ctype == 30) $pkey = '197d21f1722361ac'; //30
        return urlencode(base64_encode(aes_encode($pkey, $sk)));
}

//土豆真实播放地址解析
function get_tudou_urllist($link) {
        $urllist = "";
        if (strstr($link, "http://") != false) {
                $html = curl($link);
                $vid = trim(preg_substr($html, "|vcode: '(.*?)'|"));
                if (strlen($vid) > 3) {
                        $urllist = get_youku_urllist(null, $vid);
                } else {
                        $iid = intval(trim(preg_substr($html, "|iid: ([0-9]+)\r\n|")));
                        if ($iid > 1) {
                                $urllist = sprintf("http://vr.tudou.com/v2proxy/v2.m3u8?debug=1&it=%s&st=%d&pw=", $iid, 3);
                        }
                }
        }
        return $urllist;
}

/* 解析优酷真实播放地址 */
function get_youku_urllist($link, $vid = null) {
        $toUrl = "";
        $urllist = array();
        if (empty($vid) && strstr($link, "/v_show/id_")) {
                $vid = preg_substr($link, "|/v_show/id_(.*?)\.html|");
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
                $json = curl(sprintf($apiurl, $ctype, $did, $vid, $vid));
                if (isset($json)) {
                        $data = json_decode($json);
                        if (isset($data->data)) {
                                $aesData = $data->data;
                        }
                        if (isset($aesData) && strlen($aesData) > 12) {
                                $dejson = yk_jsondecode($aesData);
                                $data = json_decode($dejson);
                        }
                        $sid_data = $data->sid_data;
                        $sid = $sid_data->sid;
                        $oip = $sid_data->oip;
                        $token = $sid_data->token;
                        $ep = getEP(sprintf("%s_%s_%s", $sid, $vid, $token), $ctype);
                        $epStr = sprintf("&sid=%s&token=%s&oip=%s&did=%s&ctype=%s&ev=1&ep=%s", $sid, $token, $oip, $did, $ctype, $ep);
                }
                $toUrl = "http://pl.youku.com/playlist/m3u8?ts=$tm&keyframe=1&vid=$vid&type=hd3".$epStr;
        }
        return $toUrl;
}

if (!empty($_REQUEST['url']))  {
        $toUrl = "";
        $link = $_REQUEST['url'];
        // 输出数组列表
        if (strstr($link, "tudou.com")) {
                $toUrl = get_tudou_urllist($link);
        } else {
                $toUrl = get_youku_urllist($link);
        }
        Header("Location:$toUrl");
}
?>