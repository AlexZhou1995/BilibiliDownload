<?php
header("Content-Type: text/html;charset=utf-8");
$url = $_GET["url"];
if (strpos($url, "http") !== FALSE) {
	$after = ereg_replace('com', 'download', $url);
	echo"<script>{location.href='$after'}</script>";
	exit;
}
  echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-68843797-2', 'auto');ga('send', 'pageview');</script>";
exec("python3 ./biliDownLoad.py http://www.bilibili.com/$url", $rurl);
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


