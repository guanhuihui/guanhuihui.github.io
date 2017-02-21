<?php
namespace Home\Controller;
use Think\Controller;
class SampleController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
        Vendor('sample.jssdk');
        $url=$_REQUEST['url'];
        //import('jssdk', VENDOR_PATH.'sample', '.php');
        $jssdk = new \JSSDK("wx78a74ae276f5adb5", "c747e99c6d0688dec43b8c522e3a0c1b",$url);
        $signPackage = $jssdk->GetSignPackage();
        echo json_encode(array('result'=>'ok','data'=>$signPackage));
    }

}