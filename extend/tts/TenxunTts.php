<?php
namespace tts;

class TenxunTts
{
    /**
     * 获取签名鉴权
     * reqArr 请求原始数据
     * method 请求方式 POST
     * domain 请求域名
     * path 请求路径
     * secretKey 用户秘钥
     * output str 鉴权签名signature
     */
    public function createSign($reqArr, $method, $domain, $path, $secretKey) {
        $signStr = "";
        $signStr .= $method;
        $signStr .= $domain;
        $signStr .= $path;
        $signStr .= "?";
        ksort($reqArr, SORT_STRING);
        foreach ($reqArr as $key => $val) {
            if (is_float($val)){
                $signStr .= $key . "=" . sprintf("%g",$val) . "&";
            }else{
                $signStr .= $key . "=" . $val . "&";
            }
        }
        $signStr = substr($signStr, 0, -1);
        $signStr = base64_encode(hash_hmac('SHA1', $signStr, $secretKey, true));

        return $signStr;
    }

    /**
     * http post请求
     * url 请求链接地址
     * data 请求数据
     * rsp_str  回包数据
     * http_code 请求状态码
     * method 请求方式，默认POST
     * timeout 超时时间
     * cookies cookie
     * header http请求头
     * output int 请求结果
     */
    public function http_curl_exec($url, $data, & $rsp_str, & $http_code, $method = 'POST', $timeout = 10, $cookies = array (), $headers = array ()) {
        $ch = curl_init();
        if (!curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1)) {
            echo 'http_curl_ex set returntransfer failed';
            return -1;
        }

        if (count($headers) > 0) {
            //Log::debug('http_curl_ex set headers');
            if (!curl_setopt($ch, CURLOPT_HTTPHEADER, $headers)) {
                echo 'http_curl_ex set httpheader failed';
                return -1;
            }
        }

        if ($method != 'GET') {
            $data = is_array($data) ? json_encode($data) : $data;
            //Log::debug('data (non GET method) : '.$data);
            if (!curl_setopt($ch, CURLOPT_POSTFIELDS, $data)) {
                echo 'http_curl_ex set postfields failed';
                return -1;
            }
        } else {
            $data = is_array($data) ? http_build_query($data) : $data;
            if (strpos($url, '?') === false) {
                $url .= '?';
            } else {
                $url .= '&';
            }
            $url .= $data;
        }
        echo "Req data :" . json_encode($data);
        if (!empty ($cookies)) {
            $cookie_str = '';
            foreach ($cookies as $key => $val) {
                $cookie_str .= "$key=$val; ";
            }

            if (!curl_setopt($ch, CURLOPT_COOKIE, trim($cookie_str))) {
                echo 'http_curl_ex set cookie failed';
                return -1;
            }
        }

        if (!curl_setopt($ch, CURLOPT_URL, $url)) {
            echo 'http_curl_ex set url failed';
            return -1;
        }

        if (!curl_setopt($ch, CURLOPT_TIMEOUT, $timeout)) {
            echo 'http_curl_ex set timeout failed';
            return -1;
        }

        if (!curl_setopt($ch, CURLOPT_HEADER, 0)) {
            echo 'http_curl_ex set header failed';
            return -1;
        }

        $rsp_str = curl_exec($ch);
        if ($rsp_str === false) {
            curl_close($ch);
            return -2;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return 0;
    }

    /**
     * 请求获取语音
     * output str 音频pcm格式
     */
    public function getVoice($Text,$VoiceType,$Speed) 
    {
        $reqArr = array ();
        $reqArr['Action'] = 'TextToStreamAudio';
        $reqArr['AppId'] = 1308095626;
        $reqArr['Codec'] = 'pcm';
        $reqArr['Expired'] = 3600 + time(); //表示为离线识别
        $reqArr['ModelType'] = 1;
        $reqArr['PrimaryLanguage'] = 1;
        $reqArr['ProjectId'] = 0;
        $reqArr['SecretId'] = 'AKIDISQ9PSIuJVWMxKcgW7VhkW8j8JH7rSqz';
        $reqArr['SessionId'] = $this->guid();
        $reqArr['Speed'] = (int) $Speed;
        $reqArr['Text'] = $Text;
        $reqArr['Timestamp'] = time();
        $reqArr['VoiceType'] = (int) $VoiceType;
        $reqArr['EmotionIntensity'] = 200;
        $serverUrl = "https://tts.cloud.tencent.com/stream";

        $autho = $this->createSign($reqArr, "POST", "tts.cloud.tencent.com", "/stream", '51rVxDqP7V4TjmdIj0oR3hGlAPTp27Se');
        /*echo "datalen :" . $datalen;*/

        $header = array (
            'Authorization: ' . $autho,
            'Content-Type: ' . 'application/json',
        );

        $rsp_str = "";
        $http_code = -1;
        $ret = $this->http_curl_exec($serverUrl, $reqArr, $rsp_str, $http_code, 'POST', 15, array (), $header);
        if ($ret != 0) {
            echo "http_curl_exec failed \n";
            return false;
        }
        /*echo "Response String: \n" . $rsp_str . "\n";*/

        return $rsp_str;
    }

    /**
     * 获取guid
     * output str uuid
     */
    public function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            $charid = strtoupper(md5(uniqid(mt_rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = 
                    substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12);
            return $uuid;
        }
    }
}