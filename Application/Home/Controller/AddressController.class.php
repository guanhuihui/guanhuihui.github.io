<?php
namespace Home\Controller;
use Think\Controller;
class AddressController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	if (!empty($this->user_data)) {
            //添加搜索记录
            $type=$_REQUEST['type'];
    		$address_get_data=self::address_get_list($this->user_data['user_id'],$this->user_data['token']);
            $city_list_dat=self::city_list();//获取城市列表

            foreach ($address_get_data as $key => $one) {
                $cityid=$one['cityid'];
                foreach ($city_list_dat as $k => $value) {
                    foreach ($value as $ks => $o) {
                        if ($cityid == $o['city_id']) {
                           $address_get_data[$key]['city_baiducode']=$o['city_baiducode'];
                        }
                    }

                }
            }
            //用户当前位置所有商户，去除代售点
            $user_current=$_SESSION['user_current'];
            // $x=$_SESSION['user_x'];
            // $y=$_SESSION['user_y'];
            $x=$_REQUEST['x'];
            $y=$_REQUEST['y'];
            if (empty($x) || empty($y)) {
               $x=$user_current['x'];
                $y=$user_current['y'];
            }
            $shop_near_list=self::new_shop_near_list($x,$y);
            $shop_near_list=my_sort($shop_near_list,'distance');
            //去除代售点
            $shop_list=array();
            foreach ($shop_near_list as $key => $one) {
                if ($one['shop_isvip'] != '3') {
                    $one['distance']=getkm($one['distance']);
                    $shop_list[]=$one;
                }
            }
            
            if (!is_array($shop_list)) {
                $shop_list=array();
            }

            $baidu_code=$user_current['city_id'];
            if (!empty($_REQUEST['baidu_code'])) {
                $baidu_code=$_REQUEST['baidu_code'];
            }
            //城市名称传值
            $city_name="";
            foreach ($city_list_dat as $key => $one) {
                foreach ($one as $k => $value) {
                    if ($value['city_baiducode'] == $baidu_code) {
                        $city_name=$value['city_name'];
                        $city_id=$value['city_id'];
                    }
                }
                
            }

            $district=$user_current['district'];
            if (!empty($_REQUEST['district'])) {
                $district=$_REQUEST['district'];
            }

            if ($type == 'add') {
                $data=array();
                $data['address_name']=$district;
                $data['lng']=$x;
                $data['lat']=$y;
                $data['city_id']=$city_id;
                A('Since')->address_search_add($data,$this->user_data['user_id'],$this->user_data['token']);
            }

            $this->assign("district",$district);
            $this->assign("shop_near_list",$shop_list);
            //结束
            $this->assign("hiden",$_REQUEST['hiden']);
            $this->assign("city_name",$city_name);
    		$this->assign("address_get_data",$address_get_data);
            $this->assign("x",$x);
            $this->assign("y",$y);
    	}else{
            //用户当前位置所有商户，去除代售点
            $user_current=$_SESSION['user_current'];
            $x=$_REQUEST['x'];
            $y=$_REQUEST['y'];
            if (empty($x) || empty($y)) {
               $x=$user_current['x'];
                $y=$user_current['y'];
            }
            
            $shop_near_list=self::new_shop_near_list($x,$y);
            $shop_near_list=my_sort($shop_near_list,'distance');
            //去除代售点
            $shop_list=array();
            foreach ($shop_near_list as $key => $one) {
                if ($one['shop_isvip'] != '3') {
                    $one['distance']=getkm($one['distance']);
                    $shop_list[]=$one;
                }
            }
            
            if (!is_array($shop_list)) {
                $shop_list=array();
            }

            $baidu_code=$user_current['city_id'];
            if (!empty($_REQUEST['baidu_code'])) {
                $baidu_code=$_REQUEST['baidu_code'];
            }
            //城市名称传值
            $city_name="";
            foreach ($city_list_dat as $key => $one) {
                foreach ($one as $k => $value) {
                    if ($value['city_baiducode'] == $baidu_code) {
                        $city_name=$value['city_name'];
                    }
                }
                
            }

            $district=$user_current['district'];
            if (!empty($_REQUEST['district'])) {
                $district=$_REQUEST['district'];
            }
            $this->assign("district",$district);
            $this->assign("shop_near_list",$shop_list);
            //结束
            $this->assign("hiden",$_REQUEST['hiden']);
            $this->assign("city_name",$city_name);
            $this->assign("address_get_data",$address_get_data);
            $this->assign("x",$x);
            $this->assign("y",$y);

        }
        $this->assign("user_current",$user_current);
    	$this->display();
    }
        //获取最近的店铺列表 
    public function new_shop_near_list($lng,$lat,$num='100',$city_id=''){
        $url=API_URL.'/rest_2/shop/near_list';
        $post_data = array();
        $post_data['lng']=$lng;//经度
        $post_data['lat']=$lat;//纬度
        $post_data['num']=$num;//返回条目
        $post_data['city_id']=$city_id;//城市ID
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                $data=$arr['data'];
                
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //ajax请求用户收货地址
    public function ajax_get_address(){
        if (!empty($this->user_data)) {
            $address_get_data=self::address_get_list($this->user_data['user_id'],$this->user_data['token']);

            echo json_encode(array('result'=>'ok','data'=>json_encode($address_get_data)));
        }else{
            echo json_encode(array('result'=>'error','data'=>'用户尚未登录'));
        }
    }

    //获取默认收货地址
    public function address_default(){
        if (!empty($this->user_data)) {
            $address_default_data=self::address_get_default($this->user_data['user_id'],$this->user_data['token']);
            echo json_encode($address_default_data);
        }else{
            echo json_encode(array('result'=>'error','data'=>'用户尚未登录'));
        }

    }

    //return 默认收货地址
    public function return_address_default(){
        if (!empty($this->user_data)) {
            $address_default_data=self::address_get_default($this->user_data['user_id'],$this->user_data['token']);
            return $address_default_data;
        }else{
            return false;
        }

    }

    //点击收货地址跳转/index/index
    public function setsession_data(){
        $address_id=$_REQUEST['address_id'];
    	$user_x=$_REQUEST['x'];
        $user_y=$_REQUEST['y'];
        $district=$_REQUEST['district'];
        $city_id=$_REQUEST['city_id'];
        $cityCode=$_REQUEST['cityCode'];
        if (!empty($cityCode)) {
            $city_id=A('Index')->public_change_code($cityCode);
        }
        
        //\Think\Log::record($user_x.'|||'.$user_y);
        if (!empty($user_x) && !empty($user_y)) {
            if(!session_id()){
                session_start();
            }
            $_SESSION["user_x"]=$user_x;
            $_SESSION["user_y"]=$user_y;
            $_SESSION["district"]=$district;
            $_SESSION["city_id"]=$city_id;
            $_SESSION["city_province"]=A('Index')->public_get_city_info($city_id);
            //设置默认收货地址
            self::address_set_default($address_id,$this->user_data['user_id'],$this->user_data['token']);
            header("Location:".U("index/index"));
        }
    }

    //ajax获取是否已经登录
    public function is_ajax_login(){
        A('Index')->check_userdata();
    	if (!empty($this->user_data)) {
    		echo json_encode(array('result'=>'ok','msg'=>""));
    	}else{
    		echo json_encode(array('result'=>'error','msg'=>"请重新登录"));
    	}
    }
    //新建收货地址
    public function add(){
        $this->checkxy();
        $this->checklogin();
        $city_list_dat=self::city_list();//获取城市列表
        $this->assign("city_list_dat",$city_list_dat);
        if (IS_POST) {
            $name=$_POST['name'];//用户名称
            $district=$_POST['district'];//用户区域地址信息
            $address=$_POST['address'];//用户地址 
            $mobile=$_POST['mobile'];//用户手机号
            $city_baiducode=$_POST['city_baiducode'];//百度城市code
            $lng=$_POST['lngs'];//经度
            $lat=$_POST['lats'];//纬度
            $city_id=A('Index')->public_change_code($city_baiducode);
            $data=array();
            $data['name']=$name;
            $data['district']=$district;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['city_id']=$city_id;
            $data['lng']=$lng;
            $data['lat']=$lat;
            $rester=self::address_add($data,$this->user_data['user_id'],$this->user_data['token']);
            if ($rester) {
                header("Location:".U("Address/index"));
            }else{
                header("Location:".U("Address/add"));
            }
        }
    	$this->display();
    }

    //更改收货地址
    public function edit(){
        $this->checkxy();
        $this->checklogin();
    	$address_id=$_REQUEST['address_id'];
    	if (IS_POST) {
    		$data=array();
            $name=$_POST['name'];//用户名称
            $district=$_POST['district'];//用户区域地址信息
            $address=$_POST['address'];//用户地址 
            $mobile=$_POST['mobile'];//用户手机号
            $city_baiducode=$_POST['city_baiducode'];//百度城市code
            $lng=$_POST['lngs'];//经度
            $lat=$_POST['lats'];//纬度
            $address_id=$_POST['address_id'];//id
            $city_id=A('Index')->public_change_code($city_baiducode);
            $data=array();
            $data['address_id']=$address_id;
            $data['name']=$name;
            $data['district']=$district;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['city_id']=$city_id;
            $data['lng']=$lng;
            $data['lat']=$lat;
            $rester=self::address_edit($data,$this->user_data['user_id'],$this->user_data['token']);
            //根据城市id获取百度城市id

            if ($rester) {
                header("Location:".U("Address/index"));
            }
    	}
        $city_list_dat=self::city_list();//获取城市列表
        $this->assign("city_list_dat",$city_list_dat);
    	$this->assign("address_id",$address_id);
    	$this->display();
    }


    //定位当前地址
    public function location(){
        $this->display();
    }

    //新建收货地址定位当前地址
    public function new_location(){
        $this->display();
    }

    //手写收货地址，调取百度查询地址
    public function custom(){
        $this->display();
    }
    //删除收货地址
    public function del(){
    	$address_id=$_POST['id'];
		$rester=self::address_del($address_id,$this->user_data['user_id'],$this->user_data['token']);
		if (!empty($rester)) {
    		echo json_encode(array('result'=>'ok','msg'=>""));
    	}else{
    		echo json_encode(array('result'=>'error','msg'=>"删除失败"));
    	}
    }


    //获取城市列表
    public function city_list(){
        $city_data=self::public_city_list();
        //根据字母排序
        $asc_data=array();
        foreach ($city_data['city_list'] as $key => $one) {
            $asc_data[$one['city_alpha']][]=$one;
        }
        ksort($asc_data);
        return $asc_data;
    }
    //接口城市列表
    public function public_city_list(){
        $url=API_URL.'/rest_2/public/city_list';
        $post_data = array();
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

   
    public function address_get_list($uid,$token){
        $url=API_URL.'/rest_2/address/get_list';
        $post_data = array();
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //根据收货地址id获取详细信息
    public function address_detail($address_id,$uid,$token){
    	$url=API_URL.'/rest_2/address/detail';
        $post_data = array();
        $post_data['address_id']=$address_id ;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //删除
    public function address_del($address_id,$uid,$token){
    	$url=API_URL.'/rest_2/address/del';
        $post_data = array();
        $post_data['address_id']=$address_id ;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //添加地址
    public function address_add($data,$uid,$token){
        $url=API_URL.'/rest_2/address/add';
        $post_data = array();
        $post_data=$data;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取默认收货地址
    public function address_get_default($uid,$token){
        $url=API_URL.'/rest_2/address/get_default';
        $post_data = array();
        $post_data['address_id']=$address_id ;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //更新用户地址 
    public function address_edit($data,$uid,$token){
        $url=API_URL.'/rest_2/address/edit';
        $post_data = array();
        $post_data=$data;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //设置默认收货地址
    public function address_set_default($address_id,$uid,$token){
        $url=API_URL.'/rest_2/address/set_default';
        $post_data = array();
        $post_data['address_id']=$address_id ;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}