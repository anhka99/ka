<?php
error_reporting(0);
//后台入口
header("Cache-Control:no-stroe,no-cache,must-revalidate,post-check=0,pre-check=0");
session_save_path('./temp/session/');
session_set_cookie_params(24 * 3600*30);
if($_COOKIE['PHPSESSID']===''){
	setcookie("PHPSESSID", "", time() - 3600);
	exit('<meta charset="utf-8" />浏览器异常，请刷新！');
}
session_start();
$_SESSION['go_admin']=1;
setcookie('adminurl','./'.basename(__FILE__),time()+(3600*24*30),'/');
if($_SESSION['admin']['id']){
	header('Location: ./index.php?admin-index-index-t-'.time());
}else{
	header('Location: ./index.php?admin-login-index-t-'.time());
}