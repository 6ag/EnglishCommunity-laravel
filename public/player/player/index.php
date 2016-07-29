<?php
error_reporting(0);
header('Content-type:text/html;charset=utf-8');
$re=$_SERVER['HTTP_REFERER'];if(!$re)$re='http://bbs.lhkjw.com';
$HPlayer=(preg_match("/(iPhone|Android|iPad|iPod|Window phone)/i",$_SERVER['HTTP_USER_AGENT']))?true:false;
if(!$HPlayer){
	$deng_html='<div id="top1" style="width:100%; height:100%; background-color:#000;"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="100%" height="100%" id="map_sz" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="top.swf" /><param name="quality" value="best" /><param name="scale" value="exactfit" /><param name="bgcolor" value="#ffffff" />	<embed src="top.swf" quality="best" scale="exactfit" bgcolor="#ffffff" width="100%" height="100%" name="map_sz" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" /></object></div>
	<div id="a1" style="display:none;width:100%; height:100%; background-color:#000;"></div>';
	$deng_topjs='function Dengtopstop(){document.getElementById("top1").innerHTML="";';
	$deng_topjs.='document.getElementById("top1").style.display="none";';
	$deng_topjs.='document.getElementById("top1").style.display="none";';
	$deng_topjs.='document.getElementById("a1").style.display="inline";';
	$deng_topjs.='document.getElementById("a1").style.width="100%";';
	$deng_topjs.='document.getElementById("a1").style.height="100%";}';
}else{
	$deng_html='<div id="a1" style="width:100%; height:100%; background-color:#000;"></div>';
}
?><!DOCTYPE html><html><head><meta charset="utf-8"><title>灯哥解析-万能整合</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<style type="text/css">*{margin:0px;padding:0px;}html{height:100%;margin:0;background:#000;}
body{height:100%;margin:0;}</style></head>
<body><?php echo $deng_html;?>
<script type="text/javascript" src="player.js" charset="utf-8"></script>
<script type="text/javascript"><?php
	echo $deng_topjs;
	$baseUrl=(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!='off')?'https://':'http://';
	$fself=$_SERVER["PHP_SELF"];$url=$baseUrl.$_SERVER['HTTP_HOST'].$fself;
	$arr=explode('/',$url);array_pop($arr);array_pop($arr);$api=implode('/', $arr);
	if(file_exists('../index.php')){$api.='/';
	}else if(file_exists('../api/index.php')){$api.='/api/';
	}else{$api.='/api/deng.php';}
	$api.='?ckid=';echo "var app='".$api."',";
	$pid=$_REQUEST["pid"];if(!$pid)$pid='XODAyOTkwNzYw.youku'; echo "pid='".$pid."'";?>;
var flashvars={f:app+pid,s:2,p:1,c:0,my_url:encodeURIComponent('<?php echo $re;?>')}
var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always',wmode:'transparent'};
var video=[app+pid+'&mobile=1->ajax/get/utf-8'];
CKobject.embed('player.swf','a1','ckplayer_a1','100%','100%',false,flashvars,video,params);
</script></body></html>