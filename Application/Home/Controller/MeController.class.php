<?php
namespace Home\Controller;
use Think\Controller;
class MeController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	$this->display();
    }
    public function shop(){
    	$this->display();
    }
    public function install(){
        if(!session_id()){
            session_start();
        }
        $openid=$_SESSION['openid'];
        $this->assign("openid",$openid);
    	$this->display();
    }

    public function app_html_all(){
        if(!session_id()){
            session_start();
        }
        $data=array();
        $data['new_city_id']=$_SESSION["new_city_id"];
        $data['new_city_province']=$_SESSION["new_city_province"];
        $data['assertion']='';
        if ($this->user_data) {
            $data['assertion']=$this->user_data['token'].$this->user_data['user_id'];
        }
        $this->assign("data",$data);
        $this->display();
    }

}