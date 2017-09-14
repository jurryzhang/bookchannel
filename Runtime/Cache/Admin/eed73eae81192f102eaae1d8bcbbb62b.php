<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title><?php echo ($bookname); ?>-----参考文案</title>
    <link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="Http://cdn.bootcss.com/jquery/1.12.4/jquery.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/Public/js/clipboard.min.js"></script>
    <script src="https://cdn.bootcss.com/layer/3.0.1/layer.min.js"></script>


<link rel="stylesheet" type="text/css" href="http://new.emeixs.com/Public/wxeditor/css/wechat.css" />
<style type="text/css">
        .rich_media_content p{
            word-wrap: break-word;
            font-size: 17px;
            line-height: 40px;
            text-align: left;
        }
    </style>
</head>
<body id="activity-detail" class="zh_CN sougou_body">
<div id="js_article" class="rich_media">
<div class="rich_media_inner">
<div id="page-content">
<div id="img-content" class="rich_media_area_primary">
<h2 style="border-bottom: 1px solid #e7e7eb;padding-bottom: 10px;" class="rich_media_title" id="title">
<?php echo ($titleStr); ?> </h2>    
<div class="rich_media_content " id="content">	
	<img style="width: 100%;margin-bottom: 10px;" src="<?php echo ($picStr); ?>" />
    <?php echo ($bookStr); ?>
    <?php echo ($footer); ?>
</div>
</div>
</div>
</div>


    <!-- <div class="input-group" style="margin-bottom: 150px;margin-top: -30px;">
        <span class="input-group-addon">微信原文链接</span>
        <input id="docurl" readonly="" data-clipboard-target="#docurl"style="background:white" class="form-control" value="<?php echo ($docurl); ?>" onclick="this.select()" type="text">
        <span class="input-group-btn">
         <button type="button" id="copy" data-clipboard-target="#docurl" class="btn btn-default"><i class="fa fa-copy"></i> 复制</button>
         </span>
    </div> -->
<?php if($_COOKIE['uid']> 0): ?><div class="input-group" style="margin-bottom: 100px;margin-top: -30px;">
        <span class="input-group-addon">微信原文链接</span>
        <input id="docurl" readonly="" data-clipboard-target="#docurl" style="background:white" class="form-control" value="<?php echo ($docurl); ?>" onclick="this.select()" type="text">
        <span class="input-group-btn">
         <button type="button" id="copy" data-clipboard-target="#docurl" class="btn btn-default"><i class="fa fa-copy"></i> 复制</button>
         </span>
    </div><?php endif; ?>

<?php if(($_COOKIE['uid']> 0) AND ($_COOKIE['pid']== 0)): ?><input id="firstdocurl" readonly="" data-clipboard-target="#firstdocurl" style="background:white;color:white;border:none;" class="form-control" value="<?php echo ($firstDocUrl); ?>" onclick="this.select()" type="text"><?php endif; ?>



</div>


<button type="button" id="WenanUrl" name="wenanUrl" style="background:#fff;border:0px;color:#fff"><?php echo ($wenanUrl); ?></button>

<div class="input-group" style="width: 180px;box-shadow: rgba(30, 30, 30, 0.027451) 2px 4px 16px;
        border: 1px solid rgb(222, 222, 222);background: #eee;position: fixed;top: 120px;right: 100px;opacity: 0.8;">
    <div style="font-size: 15px;width:180px;height:55px;margin:0px 0px;text-align:center;padding-top: 15px;background: #666;color: #FFFFff">（点击按钮可以复制）</div>
    <button type="button" id="copytitle" data-clipboard-target="#title" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-success"><i class="fa fa-copy"></i> 文案标题</button><br/>
    <button type="button" id="copycontent" data-clipboard-target="#content" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-success"><i class="fa fa-copy"></i> 文案内容</button><br/>
    <?php if($_COOKIE['uid']> 0): ?><button type="button" id="copydocurl" data-clipboard-target="#docurl" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-success"><i class="fa fa-copy"></i> 原文链接</button>        
		<button type="button" id="copyWenanUrl" data-clipboard-target="#WenanUrl" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-warning"><i class="fa fa-copy"></i> 文案链接</button>
		<?php if($_COOKIE['pid']== 0): ?><button type="button" id="copydocurlF" data-clipboard-target="#firstdocurl" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-warning"><i class="fa fa-copy"></i> 首章链接</button><?php endif; ?>	
        <button type="button" id="refresh" style="width: 90%;margin: 8px;font-size: 15px;" class="btn btn-sm btn-warning"><i class="fa fa-refresh"></i> 刷新</button><?php endif; ?>
</div>
<script>
    var clipboard = new Clipboard('#copy');
    clipboard.on('success', function (e) {
		layer.tips('复制连接成功','#docurl', {
				tips: [1, '#3DA742'],
				time: 4000
			});
    });

    var clipboard = new Clipboard('#docurl');
    clipboard.on('success', function (e) {
        layer.tips('复制连接成功','#docurl', {
            tips: [1, '#3DA742'],
            time: 4000
        });
    });

    var clipboard = new Clipboard('#copytitle');
    clipboard.on('success', function (e) {
        layer.alert('复制标题成功!可以直接粘贴使用!');
    });

    var clipboard = new Clipboard('#copycontent');
    clipboard.on('success', function (e) {
        layer.alert('复制文案内容成功!可以直接粘贴使用!');
    });

    var clipboard = new Clipboard('#copydocurl');
    clipboard.on('success', function (e) {
        layer.alert('复制原文链接成功!可以直接粘贴使用!');
    });
	
	var clipboard = new Clipboard('#copyWenanUrl');
    clipboard.on('success', function (e) {
        layer.alert('复制文案链接成功!可以直接粘贴使用!');
    });
    /*首章链接 daisy*/
    var clipboard = new Clipboard('#copyF');
    clipboard.on('success', function (e) {
        layer.tips('复制连接成功','#firstdocurl', {
            tips: [1, '#3DA742'],
            time: 4000
        });
    });
    var clipboard = new Clipboard('#firstdocurl');
    clipboard.on('success', function (e) {
        layer.tips('复制连接成功','#firstdocurl', {
            tips: [1, '#3DA742'],
            time: 4000
        });
    });
    var clipboard = new Clipboard('#copydocurlF');
    clipboard.on('success', function (e) {
        layer.alert('复制链接成功!可以直接粘贴使用!');
    });

	
	/*daidia↓*/
	$('#refresh').click(function(){
        var chapterTplCount=<?php echo ($chapterTplCount); ?>;
        var footerTplCount=<?php echo ($footerTplCount); ?>;
        var id=<?php echo ($id); ?>;
        var num=<?php echo ($num); ?>;
        var titleid=<?php echo ($title['id']); ?>;
        var picid=<?php echo ($pic['id']); ?>;
        var ptid=<?php echo ($ptid); ?>;
        /*chapterTplCount=Math.round(Math.random()*10+chapterTplCount%10);        
        footerTplCount=Math.round(Math.random()*7+1);*/
		chapterTplCount=Math.round(Math.random()*(chapterTplCount-1))+1;
        footerTplCount=Math.round(Math.random()*(footerTplCount-1))+1;
        $(location).attr('href', '/index.php/Doc/mkDoc/id/'+id+'/num/'+num+'/titleid/'+titleid+'/picid/'+picid+'/count/'+chapterTplCount+'/fcount/'+footerTplCount+'/ptid/'+ptid);

    });

</script>

</body>
</html>