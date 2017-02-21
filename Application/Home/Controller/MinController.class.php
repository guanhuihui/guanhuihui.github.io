<?php
namespace Home\Controller;
use Think\Controller;
class MinController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	import('index', VENDOR_PATH.'minify', '.php');
        exit();
    }
}