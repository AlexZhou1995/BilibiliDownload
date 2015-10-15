<?php
header("Content-Type: text/html;charset=utf-8");
$url = $_GET["url"];
if (strpos($url, "http") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='http://$after'}</script>";
	exit;
}
elseif (strpos($url, "bilibili") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='$after'}</script>";
	exit;
}
exec("python3 ./biliDownLoad.py http://www.bilibili.com/$url", $rurl);

$myfile = fopen("debug.log", "a+");

if($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]){
	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
}
elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]){
	$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
}
elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]){
	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
}
elseif (getenv("HTTP_X_FORWARDED_FOR")){
	$ip = getenv("HTTP_X_FORWARDED_FOR");
}
elseif (getenv("HTTP_CLIENT_IP")){
	$ip = getenv("HTTP_CLIENT_IP");
}
elseif (getenv("REMOTE_ADDR")){
	$ip = getenv("REMOTE_ADDR");
}
else{
	$ip = "Unknown";
}

fwrite($myfile, $ip."   ".$url."   ".$rurl."\n");
fclose($myfile);

if (strpos($rurl[0], "http") !== FALSE) {
	header("Location: $rurl[0]");
	echo"<script>alert('已经开始下载！');history.go(-1);</script>";  
	exit;
} elseif ($rurl[0] == "error") {
	echo "<script>{window.alert('网址不正确！');location.href='/'};</script>";
	exit;
}
	echo "<script>{window.alert('出现异常错误，抱歉！');location.href='/'};</script>";
	exit;
?>


