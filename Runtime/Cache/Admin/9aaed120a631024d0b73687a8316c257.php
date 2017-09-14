<?php if (!defined('THINK_PATH')) exit();?>


<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8">
		<link rel="shortcut icon" href="/Public/images/favicon.ico" />
    	<title>免费读书 | <?php echo ($web_name); ?></title>
    	<!-- Tell the browser to be responsive to screen width -->
    	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<!-- Bootstrap 3.3.4 -->
    	<link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    	<!-- FontAwesome 4.3.0 -->
 		<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    	<!-- Ionicons 2.0.0 --
    	<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    	<!-- Theme style -->
    	<link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    	<!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    	<link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    	<!-- iCheck -->
    	<link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    	<!-- jQuery 2.1.4 -->
    	<script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    	<script src="/Public/js/common.js"></script>
    	<script src="/Public/js/myFormValidate.js"></script>    
    	<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    	<script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    	<script src="/Public/js/myAjax.js"></script>
		<script src="/Public/js/jquery-table-color.js"></script>
		<script src="/Public/js/clipboard.min.js"></script>
    	<script type="text/javascript">
    		function delfunc(obj)
    		{
    			layer.confirm('确认删除？', 
				{
    		  		btn: ['确定','取消'] //按钮
    			}, 
    			function()
    			{
    		    	// 确定
   					$.ajax(
					{
   						type : 'post',
   						url : $(obj).attr('data-url'),
   						data : {act:'del',del_id:$(obj).attr('data-id')},
   						dataType : 'json',
   						success : function(data)
   						{
	   						if(data == 1)
	   						{
	   							layer.msg('操作成功', {icon: 1});
	   							$(obj).parent().parent().remove();
	   						}
	   						else
	   						{
	   							layer.msg(data, {icon: 2,time: 2000});
	   						}
	   						layer.closeAll();
						}
   					})
    			}, 
    			function(index)
    			{
    				layer.close(index);
    				return false;// 取消œ
    			});
    		}
    
    		function selectAll(name,obj)
    		{
    			$('input[name*='+name+']').prop('checked', $(obj).checked);
    		}    
    	</script>
<style type="text/css">
	    	#riframe{min-height:inherit !important}
			.alertBox{display:none;width:100%;height:100%;position:relative;top:0;left:0;z-index:1;}
			.alertBox .mark{
				width:100%;height:100%;
				position:fixed;top:0;left:0;
				background:#000;opacity:0.3;
			}
			.alertBox .alert{
				display:none;
				width: 700px;height:498px;
				background:#FFF;
				position:fixed;top:50%;left:50%;
				z-index:9;
			}
			.alertBox .alt-header{
				cursor:move;
				padding:4px 17px;
				height:7%;line-height:20px;
				font-size:17px;
				border-bottom: 1px solid #CCCCCC;
			}
			.alertBox .alt-header .icon{
				float:right;
				cursor:pointer;
				font-style:normal;
			}
			.alertBox .alt-body{
				padding:10px 26px;
			}
			.alertBox .alt-body tr td{
				padding:8px 20px;
			}
			.alertBox .alt-footer{
				text-align: right;
				margin-right: 10px;
				border-top: 1px solid #CCCCCC;
			}
	    </style>		
	</head>
  	<body style="background-color:#ecf0f5;display:block;overflow:auto;margin:0 auto;">


<div class="wrapper">

    <style>#search-form > .form-group{margin-left: 10px;}</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
		<?php if($ischannel != 1): ?><div class="pull-right">
                    <a href="/index.php?s=/Doc/bookList/" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">
                        <i class="fa fa-reply">
                        </i>
                    </a>
                </div><?php endif; ?>
            <div class="panel panel-default">
                <div class="panel-heading" id="heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        小说详情
                    </h3>
                </div>

                <div class="row">
                    <div class="panel-body">
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="col-sm-4">
                                <img width="55%" src="<?php echo ($book["cover"]); ?>">
                                <h3><?php echo ($book["articlename"]); ?></h3>
                                <span>作者：<?php echo ($book["author"]); ?></span>
                                <br/>
                                <span>字数：<?php echo (round($book['size']/2/10000,1)); ?>万</span>
                                <br/>
                                <span>总价：<?php echo (round($book['size']/2/1000*$book['peregold']-$freechaptersize['sumfreesize']/2/1000*$book['peregold'],0)); ?>金币</span>
                                <br/>
                                <span>简介：</span>
                                <div style="line-height: 1.7em;text-indent:2em"><?php echo ($book["intro"]); ?></div>
                                <br/>
                                <?php if($_COOKIE['permissions']== 1): ?><span style="color: #ff9901">派单指数：</span>
                                    <input type="text" name="orderby" data-url="<?php echo U('Doc/changeOrderby');?>" data-id="<?php echo ($book["articleid"]); ?>" size="4" value="<?php echo ($book["orderby"]); ?>"/>
                                    <p></p>
                                    <span style="color: #ff9901">推荐语句：</span>
                                    <textarea id="recommend" rows="2" cols="40" name="recommend" data-url="<?php echo U('Doc/recommend');?>" data-id="<?php echo ($book["articleid"]); ?>"><?php echo ($book["recommend"]); ?></textarea><?php endif; ?>
                                <a href="javascript:void(0);" id="mklinkS0" onmouseover="tiptipS(0)" onclick="alertBox(0,'<?php echo ($bookInfo[0]["chaptername"]); ?>','<?php echo ($bookInfo[0]["chapterid"]); ?>')" style="margin-right: 200px;">
                                                            <i class="fa fa-link"></i>推送本书首章点此生成链接
                                                        </a>
                            </div>
                            <div class="col-sm-8">
                            <div class="table-responsive"  style="border-left:2px solid #CCC">
                                    <table class="table table-bordered table-hover">
                                        <tbody>
                                        <?php if(is_array($bookInfo)): $k = 0; $__LIST__ = $bookInfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chapter): $mod = ($k % 2 );++$k;?><tr style="">
												<td style="border-right:none;width:25px;">
													<?php echo ($chapter["chapterorder"]); ?>
												</td>
                                                <td class="text-left" style="height: 30px;line-height: 30px;border-right: none;border-left:none;">
                                                    <a href="javascript:void(0);" onclick="chapterContent('<?php echo U('Doc/chapterContent',array('chapterId'=>$chapter['chapterid'],'articleId'=>$chapter['articleid']));?>','<?php echo ($book["articlename"]); ?>',600,800)">
                                                        <?php echo ($chapter["chaptername"]); ?>
                                                    </a>
                                                    <?php if($chapter['isvip'] == 1): ?><span class="badge bg-red" style="font-weight: 400;padding: 2px 5px;">VIP</span>
                                                        <span><i class="fa fa-diamond" style="color:#CC00CC;margin-left: 30px;">&nbsp;<?php echo ($chapter["saleprice"]); ?></i></span>
                                                        <?php else: ?>
                                                        <span class="badge bg-green" style="font-weight: 400;padding: 2px 5px;">免费</span><?php endif; ?>
                                                </td>
												<td style="border-left: none;text-align: right;">
                                                <!--    <?php if($chapter["chapterorder"] <= 5): ?><a href="/Doc/mkLink/id/<?php echo ($chapter['articleid']); ?>/num/<?php echo ($k); ?>.html" id="mklink<?php echo ($k); ?>" onmouseover="tiptip(<?php echo ($k); ?>)" target="_blank" style="margin-right: 20px;">
                                                            <i class="fa fa-link"></i>  生成推广文案
                                                        </a><?php endif; ?>-->
						<!-- <?php if($chapter["chapterorder"] <= 1): ?><a href="javascript:void(0);" id="mklinkS<?php echo ($k); ?>" onmouseover="tiptipS(<?php echo ($k); ?>)" onclick="alertBox(<?php echo ($k); ?>,'<?php echo ($chapter["chaptername"]); ?>','<?php echo ($chapter["chapterid"]); ?>')" style="margin-right: 200px;">
                                                            <i class="fa fa-link"></i>推送本书首章点此生成链接
                                                        </a><?php endif; ?> -->
						<?php if($chapter["chapterorder"] <= 5): ?><a href="/Doc/mkLink/id/<?php echo ($chapter['articleid']); ?>/num/<?php echo ($k); ?>.html" id="mklink<?php echo ($k); ?>" onmouseover="tiptip(<?php echo ($k); ?>)" target="_blank" style="margin-right: 20px;">
                                                            <i class="fa fa-link"></i>  生成推广文案
                                                        </a><?php endif; ?>

                                                </td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-left"></div>
                    <div class="col-sm-8 text-left"><?php echo ($page); ?></div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<div class="alertBox">
    <!--弹框幕布遮罩层-->
    <div class="mark"></div>
    <!--弹出窗口-->
    <form id="frmLink">
        <div class="alert zoomIn">
            <div class="alt-header">生成推广链接<i class="fa fa-close icon"></i></div>
            <div class="alt-body">
                <table>
                    <tr>
                        <td>入口页面</td>
                        <td>小说阅读页</td>
                    </tr>
                    <tr>
                        <td>渠道名称</td>
                        <td>
                            <input type="text" value="" name="ptname" id='ptname' placeholder="请填写渠道名称" class="form-control" style="width: 350px; display: inline-block" />
                            <span id="err_ptname" style="color: #F00;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>渠道成本</td>
                        <td>
                            <input type="text" value="" name="ptcost" id='ptcost' placeholder="请填写渠道成本:数字" class="form-control" style="width: 350px; display: inline-block" />
                            <span id="err_ptcost" style="color: #F00;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>微信渠道可阅读章节数:</td>
                        <td>
                            <input type="text" value="" name="readchaptercount"  id='readchaptercount' class="input-sm" placeholder="请填写10以内的数字"/>
                            <p style="color: #F00;">不填默认为当前渠道可阅读章节数</p>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><img src="<?php echo ($book["cover"]); ?>" width="70px"></td>
                    </tr>
                    <tr>
                        <td>阅读原文章节</td>
                        <td>
                            <input type="text" name="rchapter" readonly="readonly" style="border: none;font-weight: bold" id="chaptername" value=""/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="alt-footer">
                <a href="javascript:void(0);" class="btn btn-primary" id="frmBtn" style="margin-top: 10px">
                    生成链接
                </a>
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo ($_GET['articleId']); ?>"/>
        <input type="hidden" name="rchapterid" value="" id="chapterid"/>
    </form>
</div>
<script>
    /*
    * 小说章节详情
    * */
    function chapterContent(url,title,w,h){
        var heading=$('#heading').offset();
        layer.open({
            type: 2,
            title: title,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            offset: [ //为了演示，随机坐标
            heading.top/2],
            content: url
        });
        
    }

    /*
    * 派单指数
    * */
    $('input[name=orderby]').blur(function(){
        var orderbyVal=$(this).val();
        var url=$(this).attr('data-url');
        var articleId=$(this).attr('data-id');
        if(orderbyVal!=""){
            $.ajax({
                url:url,
                type:'post',
                data:{orderbyVal:orderbyVal,articleId:articleId},
                success:function(res){
                    if(res){
                        layer.tips('派单指数为'+res.msg,'input[name=orderby]');
                    }
                }
            });
        }
    });
    /*
    * 推荐语
    * */
    $('#recommend').blur(function(){
        var sentence=$(this).val();
        var url=$(this).attr('data-url');
        var articleId=$(this).attr('data-id');
        if(sentence!=''){
            $.ajax({
                url:url,
                type:'post',
                data:{sentence:sentence,articleId:articleId},
                success:function(data){
                    if(data.status==1){
                        layer.tips(data.msg,'#recommend',{
                            tips: [2, '#3DA742'],
                            time: 4000
                        });
                    }else{
                        layer.tips(data.msg,'#recommend');
                    }
                }
            });
        }
    });
	
	/*获取推广链接*/
    function alertBox(num,chaptername,chapterid){
        var docH = $(document).height();//整个文档的高度
        /*$('#mkdocurl'+num).click(function (even) {
            even.preventDefault();*/
            //弹出窗口居中
            var alt_T = $(window).height() / 2 - $('.alert').height() / 4*3;
            var alt_L = $(window).width() / 2 - $('.alert').width() / 2;
            $('#chaptername').val(chaptername);
            $('#chapterid').val(chapterid);
            $('.alertBox').fadeIn().find('.mark').height(docH);
            $('.alert').css({top: alt_T, left: alt_L}).addClass('animated').show();
        /*});*/
    }
    //点击X关闭整个弹框
    $('.alertBox .icon').click(function(){
        $('.alertBox').fadeOut();
    });
    /*ajax提交链接表单*/
    $('#frmBtn').click(function(){
        $.ajax({
            url:'/Doc/getmkLink',
            type:'post',
            data:$('#frmLink').serialize(),
            success:function(data){
                if(data.status==1){
                    $('.alertBox').css('display','none');
                    layer.open({
                        type: 1,
                        title:'推广链接生成成功',
                        btn:['复制链接','关闭'],
                        area: ['700px', '220px'], //宽高
                        content: "<div style='padding: 20px;'><p>请复制下方推广链接，后续您可以在后台菜单的渠道列表中找到它并查看统计数据:</p><input type='text' style='border: none;width: 600px;' value='"+data.url+"' id='docurl' readonly='' data-clipboard-target='#docurl'><i class='fa fa-copy' style='cursor: pointer' id='copy' data-clipboard-target='#docurl'></i><p style='font-weight: bold;color: #C00;margin-top: 15px;'>请务必使用此链接作为文案的原文链接，不要使用微信中点开后手工复制的链接</p></div>",
                        yes:function(){
                            $('#copy').click();
                        },
                        btn2:function(){
                            $('#ptname').val('');
                            $('#ptcost').val('');
                            $('#readchaptercount').val('');
                        },
                        cancel:function(){
                            $('#ptname').val('');
                            $('#ptcost').val('');
                            $('#readchaptercount').val('');
                        }
                    });
                }else{
                    layer.msg(data.url,{icon:5});
                }
            }
        });
    });
    /*鼠标移动到链接提示*/
    function tiptip(num){        
        layer.tips('文案链接到当前章节，原文链接为下一章','#mklink'+num, {
            tips: [1, '#72b372'],
            time: 2000
        });
    }
	/*鼠标移动到链接提示*/
    function tiptipS(num){       
        layer.tips('原文链接为当前章','#mklinkS'+num, {
            tips: [1, '#72b372'],
            time: 2000
        });
    }
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

</script>
</body>
</html>