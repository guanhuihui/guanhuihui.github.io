<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Liukw at 2015/11/30
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Log;
use Think\Crypt\Driver\Think;
/**
 * 加盟管理
 */
class JoinController extends UserFilterController {
	
	public function _initialize(){
   		 parent::_initialize();
	}

	/*
	 * 网店加盟
	 * http://www.hahajing.com/api/joinshop_new.php
	 */
	public function shop(){
		$this->checkLogin();
		
		$name = I('post.name', '');
		$identity = I('post.idcard', '');		
		$mobile = I('post.mobile', '');
		$phone = I('post.phone', '');
		$shopname = I('post.shopname', '');
		$license = I('post.license', '');
		$owner = I('post.owner', '');		
		$ownermobile = I('post.ownermobile', '');
		$ownerphone = I('post.ownerphone', '');
		$address = I('post.address', '');
		$bank = I('post.bank', '');
		$bankname = I('post.bankname', '');
		$bankbranch = I('post.bankbranch', '');
		$bankaccount = I('post.bankaccount', '');
		$code = I('post.code', 0);
		
		if($this->os == 'android'){
			$pic_card = I('post.pic_card');
			$pic_positive = I('post.pic_positive');
			$pic_bank = I('post.pic_bank');
			$pic_back = I('post.pic_back');
			$pic_license = I('post.pic_license');
		}else{
			$pic_card = $_FILES['pic_card'];
			$pic_positive = $_FILES['pic_positive'];
			$pic_bank = $_FILES['pic_bank'];
			$pic_back = $_FILES['pic_back'];
			$pic_license = $_FILES['pic_license'];
		}
		
		//姓名不能为空
		if(empty($name)) json_error(21201, array('msg'=>C('ERR_CODE.21201')));
		//身份证号不能为空
		if(empty($identity)) json_error(21202, array('msg'=>C('ERR_CODE.21202')));
		//手机不能为空
		if(empty($mobile)) json_error(21203, array('msg'=>C('ERR_CODE.21203')));
		//店铺名称不能为空
		if(empty($shopname)) json_error(21204, array('msg'=>C('ERR_CODE.21204')));
		//店主姓名不能为空
		if(empty($owner)) json_error(21205, array('msg'=>C('ERR_CODE.21205')));
		//店主手机不能为空
		if(empty($ownermobile)) json_error(21206, array('msg'=>C('ERR_CODE.21206')));
		//开户银行不能为空
		if(empty($bank)) json_error(21207, array('msg'=>C('ERR_CODE.21207')));
		//开户人姓名不能为空
		if(empty($bankname)) json_error(21208, array('msg'=>C('ERR_CODE.21208')));
		//开户支行不能为空
		if(empty($bankbranch)) json_error(21209, array('msg'=>C('ERR_CODE.21209')));
		//银行卡帐号不能为空
		if(empty($bankaccount)) json_error(21210, array('msg'=>C('ERR_CODE.21210')));
		//商户编号不能为空
		if(empty($code)) json_error(21240, array('msg'=>C('ERR_CODE.21240')));
		//格式不正确
		if(strlen($code) != 9 || !is_numeric($code)) json_error(21241, array('msg'=>C('ERR_CODE.21241')));
		//请上传证件照与网店的合照
		if(empty($pic_card)) json_error(21211, array('msg'=>C('ERR_CODE.21240')));
		//请上传证件照正面图片
		if(empty($pic_positive)) json_error(21212, array('msg'=>C('ERR_CODE.21212')));
		//请上传证件照背面图片
		if(empty($pic_back)) json_error(21213, array('msg'=>C('ERR_CODE.21213')));
		//请上传银行卡照片
		if(empty($pic_bank)) json_error(21214, array('msg'=>C('ERR_CODE.21214')));
		//请上传营业执照照片
		//if(empty($pic_license)) json_error(21215, array('msg'=>C('ERR_CODE.21215')));
		if($this->os == 'android'){
			//店面本人合照
			$pic_card_url = $pic_card;
			//身份证正面
			$pic_positive_url = $pic_positive;		
			//身份证反面
			$pic_back_url = $pic_back;
			//银行卡
			$pic_bank_url = $pic_bank;
			//营业执照照片
			$pic_license_url = $pic_license;
		}else{
			//店面本人合照
			$pic_card_url = $this->upload($pic_card, './joinshop/');
			//身份证正面
			$pic_positive_url = $this->upload($pic_positive, './joinshop/');		
			//身份证反面
			$pic_back_url = $this->upload($pic_back, './joinshop/');
			//银行卡
			$pic_bank_url = $this->upload($pic_bank, './joinshop/');
			//营业执照照片
			$pic_license_url = $this->upload($pic_license, './joinshop/');
		}
		
		$Join = D('Home/Join');
		
		//查询编码是否存在
		$where['joinshop_code'] = array('eq',$code);
		$re = $Join->JoinShopByCode($where);
		if($re) json_error(21242, array('msg'=>C('ERR_CODE.21242')));
		$data = array();
		$data['joinshop_name'] = $name;
		$data['joinshop_identity'] = $identity;
		$data['joinshop_mobile'] = $mobile;
		$data['joinshop_phone'] = $phone;
		$data['joinshop_shopname'] = $shopname;
		$data['joinshop_license'] = $license;
		$data['joinshop_owner'] = $owner;
		$data['joinshop_ownermobile'] = $ownermobile;
		$data['joinshop_ownerphone'] = $ownerphone;
		$data['joinshop_address'] = $address;
		$data['joinshop_bank'] = $bank;
		$data['joinshop_bankname'] = $bankname;
		$data['joinshop_bankbranch'] = $bankbranch;
		$data['joinshop_bankaccount'] = $bankaccount;		
		$data['joinshop_piccard'] = $pic_card_url;
		$data['joinshop_picpositive'] = $pic_positive_url;
		$data['joinshop_picback'] = $pic_bank_url;
		$data['joinshop_picbank'] = $pic_back_url;
		$data['joinshop_piclicense'] = $pic_license_url;
		$data['joinshop_addtime'] = time();
		
		$result = $Join->addJoinShop($data);
		if($result){
			json_success(array('msg'=>'ok'));
		}else{
			json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
		}
		
	}
	
	/**
	 * 经销商加盟
	 * http://www.hahajing.com/api/joindealer_new.php
	 */
	public function dealer(){
		$name = I('post.name', '');
		$sex = I('post.sex', '');
		$birth = I('post.birth', '');
		$education = I('post.education', '');
		$idcardaddress = I('post.idcardaddress', '');
		$idcard = I('post.idcard', '');
		$mobile = I('post.mobile', '');
		$phone = I('post.phone', '');
		$shopname = I('post.shopname', '');
		$shopaddress = I('post.shopaddress', '');
		$contact = I('post.contact', '');
		$fax = I('post.fax', '');
		$shopmail = I('post.shopmail', '');
		$business = I('post.business', '');
		$employee = I('post.employee', '');
		$position = I('post.position', '');
		$sales = I('post.sales', '');
		$capital = I('post.capital', '');
		$address = I('post.address', '');
		$invest = I('post.invest', '');
		$place = I('post.place', '');
		$dimension = I('post.dimension', '');
		$advantage = I('post.advantage', '');
		$reason = I('post.reason', '');
		$experience = I('post.experience', '');
		$network = I('post.network', '');
		$other = I('post.other', '');
		$plan = I('post.plan', '');
		if($this->os == 'android'){
			$pic_license    = I('post.pic_license');
			$pic_positive   = I('post.pic_positive');
			$pic_back       = I('post.pic_back');
		}else{
			$pic_license    = $_FILES['pic_license'];
			$pic_positive   = $_FILES['pic_positive'];
			$pic_back       = $_FILES['pic_back'];
		}
		
		//申请人姓名不能为空
		if(empty($name)) json_error(21216, array('msg'=>C('ERR_CODE.21216')));
		//申请人性别不能为空
		if(empty($sex)) json_error(21217, array('msg'=>C('ERR_CODE.21217')));
		//出生年月不能为空
		if(empty($birth)) json_error(21218, array('msg'=>C('ERR_CODE.21218')));
		//身份证地址不能为空
		if(empty($idcardaddress)) json_error(21219, array('msg'=>C('ERR_CODE.21219')));
		//身份证不能为空
		if(empty($idcard)) json_error(21220, array('msg'=>C('ERR_CODE.21220')));
		//手机不能为空
		if(empty($mobile)) json_error(21221, array('msg'=>C('ERR_CODE.21221')));
		//固定电话不能为空
		if(empty($phone)) json_error(21222, array('msg'=>C('ERR_CODE.21222')));
		//申请公司名称不能为空
		if(empty($shopname)) json_error(21223, array('msg'=>C('ERR_CODE.21223')));
		//申请公司地址不能为空
		if(empty($shopaddress)) json_error(21224, array('msg'=>C('ERR_CODE.21224')));
		//联系电话不能为空
		if(empty($contact)) json_error(21225, array('msg'=>C('ERR_CODE.21225')));
		//邮箱不能为空
		if(empty($shopmail)) json_error(21226, array('msg'=>C('ERR_CODE.21226')));
		//主要经营业务不能为空
		if(empty($business)) json_error(21227, array('msg'=>C('ERR_CODE.21227')));
		//申请人在本公司担任的职务不能为空
		if(empty($position)) json_error(21228, array('msg'=>C('ERR_CODE.21228')));
		//年销售额不能为空
		if(empty($sales)) json_error(21229, array('msg'=>C('ERR_CODE.21229')));
		//注册资金不能为空
		if(empty($capital)) json_error(21230, array('msg'=>C('ERR_CODE.21230')));
		//申请加盟地区不能为空
		if(empty($address)) json_error(21231, array('msg'=>C('ERR_CODE.21231')));
		//计划投入资金不能为空
		if(empty($invest)) json_error(21232, array('msg'=>C('ERR_CODE.21232')));
		//选择哈哈镜产品的理由不能为空
		if(empty($reason)) json_error(21233, array('msg'=>C('ERR_CODE.21233')));
		if($this->os == 'android'){
			//营业执照照片
			$pic_license_url = $pic_license;
			//身份证正面
			$pic_positive_url = $pic_positive;
			//身份证反面
			$pic_back_url = $pic_back;
		}else{
			//营业执照照片
			$pic_license_url = $this->upload($pic_license, './joindealer/');
			//身份证正面
			$pic_positive_url = $this->upload($pic_positive, './joindealer/');
			//身份证反面
			$pic_back_url = $this->upload($pic_back, './joindealer/');
		}

		$Join = D('Home/Join');
		$data = array();
		$data['joindealer_name'] = $name;
		$data['joindealer_sex'] = $sex;
		$data['joindealer_birth'] = $birth;
		$data['joindealer_education'] = $education;
		$data['joindealer_idcardaddress'] = $idcardaddress;
		$data['joindealer_idcard'] = $idcard;
		$data['joindealer_mobile'] = $mobile;
		$data['joindealer_phone'] = $phone;
		$data['joindealer_shopname'] = $shopname;
		$data['joindealer_shopaddress'] = $shopaddress;
		$data['joindealer_contact'] = $contact;
		$data['joindealer_fax'] = $fax;
		$data['joindealer_shopmail'] = $shopmail;
		$data['joindealer_business'] = $business;
		$data['joindealer_employee'] = $employee;
		$data['joindealer_position'] = $position;
		$data['joindealer_sales'] = $sales;
		$data['joindealer_capital'] = $capital;
		$data['joindealer_address'] = $address;
		$data['joindealer_invest'] = $invest;
		$data['joindealer_place'] = $place;
		$data['joindealer_dimension'] = $dimension;
		$data['joindealer_advantage'] = $advantage;
		$data['joindealer_reason'] = $reason;
		$data['joindealer_experience'] = $experience;
		$data['joindealer_network'] = $network;
		$data['joindealer_other'] = $other;
		$data['joindealer_plan'] = $plan;
		$data['joindealer_piclicense'] = $pic_license_url;
		$data['joindealer_picpositive'] = $pic_positive_url;
		$data['joindealer_picback'] = $pic_back_url;
		$data['joindealer_addtime'] = time();
		
		$result = $Join->addJoinDealer($data);
		if($result){
			json_success(array('msg'=>'ok'));
		}else{
			json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
		}		
		
	}
	
	/**
	 * 代售点加盟经销商
	 * http://www.hahajing.com/api/joinsale_new.php
	 */
	public function sale(){
		//获取参数
		$name = I('post.name', '');
		$identity = I('post.identity', '');
		$mobile = I('post.mobile', '');
		$phone = I('post.phone', '');
		$shopname = I('post.shopname', '');
		$license = I('post.license', '');
		$owner = I('post.owner', '');
		$ownermobile = I('post.ownermobile', '');
		$ownerphone = I('post.ownerphone', '');
		$address = I('post.address', '');
		
		if($this->os == 'android'){
			$pic_card    = I('post.pic_card');
			$pic_positive   = I('post.pic_positive');
			$pic_back       = I('post.pic_back');
		}else{
			$pic_card    = $_FILES['pic_card'];
			$pic_positive   = $_FILES['pic_positive'];
			$pic_back       = $_FILES['pic_back'];
		}
		
		//检查参数
		//姓名不能为空
		if(empty($name)) json_error(21234, array('msg'=>C('ERR_CODE.21234')));
		//身份证号不能为空
		if(empty($identity)) json_error(21235, array('msg'=>C('ERR_CODE.21235')));
		//手机不能为空
		if(empty($mobile)) json_error(21236, array('msg'=>C('ERR_CODE.21236')));
		//店铺名称不能为空
		if(empty($shopname)) json_error(21237, array('msg'=>C('ERR_CODE.21237')));
		//店主姓名不能为空
		if(empty($owner)) json_error(21238, array('msg'=>C('ERR_CODE.21238')));
		//店主手机不能为空
		if(empty($ownermobile)) json_error(21239, array('msg'=>C('ERR_CODE.21239')));
		
		if($this->os == 'android'){
			//营业执照照片
			$pic_card_url = $pic_card;
			//身份证正面
			$pic_positive_url = $pic_positive;
			//身份证反面
			$pic_back_url = $pic_back;
		}else{
			//营业执照照片
			$pic_card_url = $this->upload($pic_card, './joinsale/');
			//身份证正面
			$pic_positive_url = $this->upload($pic_positive, './joinsale/');
			//身份证反面
			$pic_back_url = $this->upload($pic_back, './joinsale/');
		}
		
		$Join = D('Home/Join');
		$data = array();		
		$data['joinsale_name'] = $name;
		$data['joinsale_identity'] = $identity;
		$data['joinsale_mobile'] = $mobile;
		$data['joinsale_phone'] = $phone;
		$data['joinsale_shopname'] = $shopname;
		$data['joinsale_license'] = $license;
		$data['joinsale_owner'] = $owner;
		$data['joinsale_ownermobile'] = $ownermobile;
		$data['joinsale_ownerphone'] = $ownerphone;
		$data['joinsale_address'] = $address;
		$data['joinsale_piccard'] = $pic_card_url;
		$data['joinsale_picpositive'] = $pic_positive_url;
		$data['joinsale_picback'] = $pic_back_url;
		$data['joinsale_addtime'] = time();
		
		$result = $Join->addJoinSale($data);
		if($result){
			json_success(array('msg'=>'ok'));
		}else{
			json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
		}
	}
	
	private function upload($file,$subname){
		/*
		$Upload = new \Think\Upload();// 实例化上传类
		$Upload->savePath = $subname; // 设置附件上传目录
		$Upload->maxSize = 8*1024*1024;
		$Upload->exts = array('jpg', 'jpeg', 'png');
		
		if($file){
			//单张上传
			$info = $Upload->uploadOne($file);
			if(!$info) {//上传错误提示错误信息
				//Log::write('图片上传错误->'.$Upload->getError());
				json_error(10405, array('msg'=>$Upload->getError()));
			}else{// 上传成功				
				$url = $info['savepath'].$info['savename'];
				return str_replace('./', '', $url);
			}
		}else{
			//上传文件不存在
			json_error('10404',array('msg'=>C('ERR_CODE.10404')));
		}*/
		//导入上传类
		$upload = new \Think\Upload();
		//设置上传文件大小
		$upload->maxSize = 8*1024*1024;
		//设置上传文件类型
		$upload->exts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$upload->rootPath = './userfiles/';
		// 设置附件上传(子)目录
		$upload->savePath = $subname; 
		
		if($file){
			//单张上传
			$r = $upload->uploadOne($file);
			if(!$r) {//上传错误提示错误信息
				//Log::write('图片上传错误->'.$upload->getError());
				json_error(10405, array('msg'=>$upload->getError()));
			}else{// 上传成功
				$url = $r['savepath'].$r['savename'];
				return str_replace('./', '', $url);
			}
		}else{
			//上传文件不存在
			json_error('10404',array('msg'=>C('ERR_CODE.10404')));
		}
	}
	
	/**
	 * 是否开启加盟配置
	 * 0 为关闭   1为开启
	 */
	public function config(){
		$config = array();
		$config['joindealer'] = 0;   //经销商加盟
		$config['joinsale'] = 0;     //代售点加盟
		$config['joinshop'] = 0;     //网店加盟
		
		json_success($config);
	}
	
	/**
	 * 网店加盟图片单独上传
	 */
	public function shop_pic(){
		
		$pic_card = $_FILES['pic_card'];
		$pic_positive = $_FILES['pic_positive'];
		$pic_bank = $_FILES['pic_bank'];
		$pic_back = $_FILES['pic_back'];
		$pic_license = $_FILES['pic_license'];
		
		//请上传证件照与网店的合照
		if(empty($pic_card)) json_error(21211, array('msg'=>C('ERR_CODE.21211')));
		//请上传证件照正面图片
		if(empty($pic_positive)) json_error(21212, array('msg'=>C('ERR_CODE.21212')));
		//请上传证件照背面图片
		if(empty($pic_back)) json_error(21213, array('msg'=>C('ERR_CODE.21213')));
		//请上传银行卡照片
		if(empty($pic_bank)) json_error(21214, array('msg'=>C('ERR_CODE.21214')));
		//请上传营业执照照片
		//if(empty($pic_license)) json_error(21215, array('msg'=>C('ERR_CODE.21215')));
		
		//店面本人合照
		$pic_card_url = $this->upload($pic_card, './joinshop/');
		//身份证正面
		$pic_positive_url = $this->upload($pic_positive, './joinshop/');
		//身份证反面
		$pic_back_url = $this->upload($pic_back, './joinshop/');
		//银行卡
		$pic_bank_url = $this->upload($pic_bank, './joinshop/');
		//营业执照照片
		$pic_license_url = $this->upload($pic_license, './joinshop/');
		
		json_success(array('pic_card_url'=>$pic_card_url,'pic_positive_url'=>$pic_positive_url,'pic_back_url'=>$pic_back_url,'pic_bank_url'=>$pic_bank_url,'pic_license_url'=>$pic_license_url));
	}
	
	/**
	 * 安卓经销商加盟申请单独上传照片
	 */
	public function dealer_pic(){
		$pic_license    = $_FILES['pic_license'];
		$pic_positive   = $_FILES['pic_positive'];
		$pic_back       = $_FILES['pic_back'];
		
		//营业执照照片
		$pic_license_url = $this->upload($pic_license, './joindealer/');
		//身份证正面
		$pic_positive_url = $this->upload($pic_positive, './joindealer/');
		//身份证反面
		$pic_back_url = $this->upload($pic_back, './joindealer/');
		
		json_success(array('pic_license_url'=>$pic_license_url,'pic_positive_url'=>$pic_positive_url,'pic_back_url'=>$pic_back_url));
	}
	
	/**
	 * 安卓代售点加盟申请单独上传照片
	 */
	public function sale_pic(){
		$pic_card    = $_FILES['pic_card'];
		$pic_positive   = $_FILES['pic_positive'];
		$pic_back       = $_FILES['pic_back'];
		
		//营业执照照片
		$pic_card_url = $this->upload($pic_card, './joinsale/');
		//身份证正面
		$pic_positive_url = $this->upload($pic_positive, './joinsale/');
		//身份证反面
		$pic_back_url = $this->upload($pic_back, './joinsale/');
		
		json_success(array('pic_card_url'=>$pic_card_url,'pic_positive_url'=>$pic_positive_url,'pic_back_url'=>$pic_back_url));
	}
}