<?php
namespace Home\Controller;
use Think\Controller;
require_once(VENDOR_PATH."/phpqrcode/lib/full/qrlib.php");
class PhpqrcodeController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    public function create_png(){
    	$order_no=$_REQUEST['order_no'];
	    $errorCorrectionLevel = 'L';
	    $matrixPointSize = 4;
	    $textData = json_encode(array('type_id'=>'2','order_no'=>$order_no));
	    $QRcode=new \QRcode();
	   // echo $QRcode::png($textData, $pngFilename, $errorCorrectionLevel, $matrixPointSize, 2);
	   	ob_clean();//这个一定要加上，清除缓冲区  
	    $QRcode::png($textData, false, $errorCorrectionLevel, $matrixPointSize, 2);   
	    exit();
    }
}
?>