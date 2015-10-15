<?php
header("Content-Type: text/html;charset=utf-8");
$url = $_GET["url"];
if (strpos($url, "www") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='$after'}</script>";
	exit;
}
exec("python3 ./biliDownLoad.py http://www.bilibili.com/$url", $rurl);

$myfile = fopen("debug.log", "a+");

$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];

fwrite($myfile, $user_IP."   ".$url."   ".$rurl."\n");
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


