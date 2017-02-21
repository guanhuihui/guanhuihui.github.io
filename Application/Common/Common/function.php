<?php
function Posts($curlPost, $url,$uid='',$Token='') {
        $http_header=array('Accept-Encoding:000','Client-Version:1.0.5','Lang:zn','Os:weixin','Tok:000','Uid:'.$uid,'Token:'.$Token);
        //设置结束
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_HTTPHEADER,$http_header);
        curl_setopt ( $curl, CURLOPT_HEADER, false );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $curl, CURLOPT_NOBODY, true );
        curl_setopt ( $curl, CURLOPT_POST, true );
        //curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
        curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curlPost );
        $return_str = curl_exec ( $curl );
        curl_close ( $curl );
        $result = json_decode($return_str,true);
         return $result;
}


    function Up_Posts($curlPost, $url) {
        //设置结束
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_HEADER, false );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $curl, CURLOPT_NOBODY, true );
        curl_setopt ( $curl, CURLOPT_POST, true );
        //curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
        curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curlPost );
        $return_str = curl_exec ( $curl );
        curl_close ( $curl );
        $result = json_decode($return_str,true);
        return $result;
}
function date_Transformation($date){
    $is_existence=strpos($date,'-');
    if ($is_existence) {
        $strtime=strtotime($date);
        $str_date=date('Y年m月d日',$strtime);
        $str=$str_date;
        return $str;
    }else{
        return $date;
    }
}

//将对象转为数组
function ob2ar($obj) {
    if(is_object($obj)) {
        $obj = (array)$obj;
        $obj = ob2ar($obj);
    } elseif(is_array($obj)) {
        foreach($obj as $key => $value) {
            $obj[$key] = ob2ar($value);
        }
    }
    return $obj;
}
//将时间格式化成13位时间戳
function date_formats($date){
    return strtotime($date).'000';
}
//将数组转化为字符串
function url_arr($arr){
    $str='';
    foreach($arr as $k=>$r){
     $str.="{$k}={$r}&";
    }
    return substr_replace($str, '', -1);
}


/**
 * 数据排序、删除杂项及空值
 */
function para_filter_sort($para){
    $para_filter = array();
    ksort($para);

    foreach($para as $key=>$val){
        //将key全部小写
        $key = strtolower($key);
        if($key === "sign" || $key === "action" || $key === "_request" || $val === "" || is_null($val) ){
            continue;
        }else{
            if(is_bool($val)){
                $para_filter[$key] = (int)$val;
            }else{
                $para_filter[$key] = is_array($val) ? para_filter_sort($val) : $val;
            }
        }
    }

    return $para_filter;
}

/**
 * 生成拼接串
 * @param unknown $para
 * @return string
 */
function create_link_string($para){
    $arg = '';
    foreach($para as $key=>$val){
        if(is_array($val)){
            $arg .= $key.'=('.(is_array($val) ? create_link_string($val) : $val).')&';
        }else{
            $arg .= $key.'='.$val.'&';
        }
    }

    if(count($arg)>0){
        //去掉最后一个&字符
        $arg = substr($arg, 0, count($arg)-2);
    }

    return $arg;
}

/**
 * 生成校验字符串
 * @param string $data
 * @return string
 */
function create_sign($data = false){
    if($data){
        // 按照key对数组进行排
        $data = para_filter_sort($data);
        // 生成拼接串
        $prestr = create_link_string($data);

        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()){
            $arg = stripslashes($arg);
        }
        //echo '$prestr = '.$prestr;
        //Log::write('prestr--------------------------------->'.$prestr);//获取客户端传入的参数
        if(empty($prestr)){
            return '';
        }else{
            $prestr .=C('HHJ_API_KEY');
            return md5($prestr);
        }
    }else{
        return '';
    }

}
/** 
    * @desc 根据两点间的经纬度计算距离
    * @param float $lat 纬度值
    * @param float $lng 经度值
    */
    function getDistance($lat1,$lng1,$lat2,$lng2){
        $earthRadius = 6367000;
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;
        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance);
    }

    function getkm($m){
        if ($m < 1000) {
            return $m.'m';
        }else{
            $km=$m / 1000;
            return round($km,1).'km';
        }
    }

    //二维数组排序
    function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
        return $arrays;
    }

    /**
     * 验证码检查，验证完后销毁验证码增加安全性 ,<br>返回true验证码正确，false验证码错误
     * @return boolean <br>true：验证码正确，false：验证码错误
     */
    function sp_check_verify_code(){
        $verify = new \Think\Verify();
        return $verify->check($_REQUEST['verify'], "");
    }


?>