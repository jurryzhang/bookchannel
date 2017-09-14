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
    <?php if($ischannel != 1): ?><div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
		<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li>
	        		<!-- burn修改，2016-07-26 -->
	        		<a href="<?php echo ($v); ?>">
	        			<i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?>
	        		</a>
	        	</li>
	    	<?php else: ?>    
	        	<li>
	        		<!-- burn修改，2016-07-26 -->
	        		<a href="<?php echo ($v); ?>"><?php echo ($k); ?></a>
	        		<!-- <?php echo ($k); ?> -->
	        	</li><?php endif; endforeach; endif; ?>          
	</ol>
</div><?php endif; ?>



    <style>#search-form > .form-group{margin-left: 10px;}</style>

    <form id="search-form2">
        <input  type="hidden" name="channelid" value="<?php echo ($channelid); ?>">
    </form>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php if($ischannel != 1): ?><div class="pull-right">
                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">
                        <i class="fa fa-reply">
                        </i>
                    </a>
                </div><?php endif; ?>

            <div class="panel panel-default">
                <?php if($_COOKIE['permissions']== 0): ?><div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-list"></i>
                            常用链接
                        </h3>
                    </div><?php endif; ?>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" style="font-size:15px;">
                            <tbody>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>书城首页</span>
                                        <span id="url_A" data-clipboard-target="#url_A">http://wap.kyread.com/Index/index/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_A" data-clipboard-target="#url_A" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>主编强推</span>
                                        <span id="url_B" data-clipboard-target="#url_B">http://wap.kyread.com/Index/getHotCommendBookList/show_id/4/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_B" data-clipboard-target="#url_B" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>免费专区</span>
                                        <span id="url_C" data-clipboard-target="#url_C">http://wap.kyread.com/Index/freeLimitBookList/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_C" data-clipboard-target="#url_C" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>阅读记录</span>
                                        <span id="url_D" data-clipboard-target="#url_D">http://wap.kyread.com/User/getBookCase/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_D" data-clipboard-target="#url_D" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>我要充值</span>
                                        <span id="url_E" data-clipboard-target="#url_E">http://wap.kyread.com/User/buyEgold/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_E" data-clipboard-target="#url_E" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left" style="padding: 20px 100px;">
                                        <span>免费书币</span>
                                        <span id="url_F" data-clipboard-target="#url_F">http://wap.kyread.com/user/sign/cid/<?php echo ($channelid); ?>.html</span>
                                        <i class="fa fa-copy" id="copy_F" data-clipboard-target="#url_F" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
    function copyUrl(copyBtn,copyUrl){
        var clipboard = new Clipboard(copyBtn);
        clipboard.on('success', function (e) {
            layer.tips('复制连接成功',copyUrl, {
                tips: [1, '#3DA742'],
                time: 4000
            });
        });
    }
    copyUrl('#copy_A','#url_A');
    copyUrl('#copy_B','#url_B');
    copyUrl('#copy_C','#url_C');
    copyUrl('#copy_D','#url_D');
    copyUrl('#copy_E','#url_E');
    copyUrl('#copy_F','#url_F');

    $(function(){
        $('.table').setTableColor('#F9F9F9','#F9F9F9');
    });
</script>

</body>
</html>