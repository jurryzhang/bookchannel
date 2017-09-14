<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" href="/Public/images/qukemalllogo.png" />
<title>网站地图</title>
</head>
<style>
body, ul, ol, li, dl, dt, dd, p, h1, h2, h3, h4, h5, h6, form, fieldset {
    margin: 0;
    padding: 0;
}
#dialog {
    verflow: hidden;
    background: #FFF;
    padding: 5px;
    position: absolute;
    z-index: 100; 
}
#dialog .mcontent {
    clear: both;
    padding: 5px 20px;
    overflow: auto;
}
#dialog dl {
    width: 90px;
    float: left;
    overflow: hidden;
}
#dialog dt {
    font-size: 14px;
    font-weight: bold;
    color: #67027D;
    line-height: 32px;
    padding-left: 2px;
	text-align:center;
}
#dialog dd {
	text-align:center;
    height: 24px;
}

#dialog dd a {
    line-height: 20px;
    padding: 2px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
	color: #0D93BF;
    text-decoration: none;
	font-size:12px;
}
</style>
<body>
<div id="dialog">
 <div class="mcontent">
 	<?php if(is_array($all_menu)): foreach($all_menu as $k=>$vo): ?><dl>	
  		<dt><?php echo ($vo["title"]); ?></dt>
  		<?php if(is_array($vo["submenu"])): foreach($vo["submenu"] as $kk=>$vv): ?><dd><a href="javascript:void(0)" onclick="javascript:window.parent.callUrl('<?php echo ($vv["url"]); ?>');"><?php echo ($vv["title"]); ?></a></dd><?php endforeach; endif; ?>
  	 </dl><?php endforeach; endif; ?> 
 </div>
</div>
</body>
</html>