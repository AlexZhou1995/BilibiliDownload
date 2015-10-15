<?php
header("Content-Type: text/html;charset=utf-8");
$url = $_GET["url"];
if (strpos($url, "http") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='$after'}</script>";
	exit;
}
elseif (strpos($url, "bilibili") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='http://$after'}</script>";
	exit;
}
exec("python3 ./biliDownLoad.py http://www.bilibili.com/$url", $rurl);

$myfile = fopen("debug.log", "a+");

$ipaddress = '';
if ($_SERVER['HTTP_CLIENT_IP'])
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
else if($_SERVER['HTTP_X_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if($_SERVER['HTTP_X_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
else if($_SERVER['HTTP_FORWARDED_FOR'])
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
else if($_SERVER['HTTP_FORWARDED'])
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
else if($_SERVER['REMOTE_ADDR'])
    $ipaddress = $_SERVER['REMOTE_ADDR'];
else
    $ipaddress = 'UNKNOWN';

fwrite($myfile, $ipaddress."   ".$url."   ".$rurl[0]."\n");
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


