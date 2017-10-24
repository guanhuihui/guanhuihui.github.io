<?php
/*
        //Vendor('sample.jssdk');
        require_once('./sample/jssdk.php');
        $url=$_REQUEST['url'];
        //import('jssdk', VENDOR_PATH.'sample', '.php');
        $jssdk = new \JSSDK("wx8a1f2a28536ba701", "06c2eb4fcecedf080fb4e6e8b23608ef",$url);
        $signPackage = $jssdk->GetSignPackage();
        echo json_encode(array('result'=>'ok','data'=>$signPackage));
*/
$appid = 'wx8a1f2a28536ba701';
$secret = '06c2eb4fcecedf080fb4e6e8b23608ef';

$access_token_path = './sample/jssdk.php';
$jsapi_ticket_path = './sample/jssdk.php';
$nonceStr = 'Wm3WZYTPz0wzccnW';
$timestamp = time();


if (!is_file($access_token_path) || filemtime($access_token_path) < time()-7200) {
	$json=json_decode( file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}"),true);
	$access_token = $json['access_token'];
	file_put_contents($access_token_path,$access_token);
}else{
	$access_token = file_get_contents($access_token_path);
}
if (!is_file($jsapi_ticket_path) || filemtime($jsapi_ticket_path) < time()-7200) {
	$json=json_decode( file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi"),true);
	$jsapi_ticket = $json['ticket'];
	file_put_contents($jsapi_ticket_path,$jsapi_ticket);
}else{
	$jsapi_ticket = file_get_contents($jsapi_ticket_path);
}

$signature = sha1("jsapi_ticket={$jsapi_ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$_SERVER['HTTP_REFERER']}");
echo json_encode(array('result'=>'ok','data'=>array('appId'=>'wx8a1f2a28536ba701','nonceStr'=>$nonceStr,'signature'=>$signature,'timestamp'=>$timestamp)));