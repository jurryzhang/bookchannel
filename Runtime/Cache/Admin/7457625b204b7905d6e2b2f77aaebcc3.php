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

<script src="/Public/js/clipboard.min.js"></script>
<div class="wrapper">

        <div class="breadcrumbs" id="breadcrumbs">
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
</div>



    <style>#search-form > .form-group{margin-left: 10px;}</style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
                <div class="pull-right">
                    <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回">
                        <i class="fa fa-reply">
                        </i>
                    </a>
                </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        促销活动列表
                    </h3>
                </div>

                <div class="panel-body">
                    <?php if($_COOKIE['permissions']== 1): ?><div class="navbar navbar-default">
                        <form action="/index.php?s=/BookSale/titleList/" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">


                                <button type="button" onclick="location.href='/index.php?s=/BookSale/promotionAdd.html'" class="btn btn-primary pull-left">
                                    <i class="fa fa-plus"></i>添加促销活动
                                </button>


                        </form>
                    </div><?php endif; ?>
                    <?php if(empty($promotion)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                            ID
                                        </td><?php endif; ?>

                                        <td class="text-center">
                                            活动名称
                                        </td>

                                        <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                            充值金额(元)
                                        </td>

                                        <td class="text-center">
                                            赠送金额(元)
                                        </td>

                                        <td class="text-center">
                                            开始时间
                                        </td>

                                        <td class="text-center">
                                            结束时间
                                        </td>


                                            <td class="text-center">
                                                操作
                                            </td><?php endif; ?>
                                        <?php if($_COOKIE['permissions']== 0): ?><td class="text-center">
                                                活动页面
                                            </td>

                                            <td class="text-center">
                                                活动时间
                                            </td><?php endif; ?>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($promotion)): $i = 0; $__LIST__ = $promotion;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                            <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                                <?php echo ($list["id"]); ?>
                                            </td><?php endif; ?>

                                            <td class="text-center">
                                                <?php echo ($list["title"]); ?>
                                            </td>

                                            <?php if($_COOKIE['permissions']== 0): ?><td class="text-center">
												<?php if($list['endtime'] > time()): ?><span id="saleurl<?php echo ($list["id"]); ?>">http://wap.kyread.com/User/buyEgold/saleid/<?php echo ($list["id"]); ?>/cid/<?php echo (cookie('channelid')); ?>.html</span>  &nbsp;  &nbsp;
                                                    <a id="copycurl" data-clipboard-target="#saleurl<?php echo ($list["id"]); ?>" href="javascript:void(0)" ><i class="fa fa-copy"></i> </a>
													<?php else: ?>
													活动已结束<?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php echo (date('Y/m/d H:i:s',$list["starttime"])); ?> - <?php echo (date('Y/m/d H:i:s',$list["endtime"])); ?>
                                                </td><?php endif; ?>

                                            <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                                <?php echo ($list["paymoney"]); ?>
                                            </td>


                                            <td class="text-center">
                                                <?php echo ($list["givemoney"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["starttime"])); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["endtime"])); ?>
                                            </td>


                                            <td class="text-center">

                                                <?php if($list["issend"] == 0): ?><a href="/index.php?s=/BookSale/promotionEdit/id/<?php echo ($list["id"]); ?>.html"  title="" class="btn btn-success" data-original-title="发送消息">
                                                        <span>编辑</span>
                                                    </a><?php endif; ?>
                                                    <a href="javascript:void (0)" onclick="del(<?php echo ($list["id"]); ?>,this);" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除任务">
                                                        <span>删除</span>
                                                    </a>

                                            </td><?php endif; ?>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-sm-3 text-left"></div>
                            <div class="col-sm-9 text-right"><?php echo ($page); ?></div>
                        </div><?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

    function del(id,obj)
    {
        layer.confirm('确定要删除吗?',
            function(){
                $.ajax(
                    {
                        url     : "/index.php?s=/BookSale/promotionDel/id/"+id,
                        success : function(v)
                        {
                            if(v.status==1){
                                layer.msg(v.info, {icon: 1,time: 1000});
                                $(obj).parent().parent().remove();
                            }else {
                                layer.msg(v.info, {icon: 2,time: 1000});
                            }
                        }
                    });
            }

        );



        return false;
    }


    var clipboard = new Clipboard('#copycurl');
    clipboard.on('success', function (e) {
        layer.alert('复制链接成功!可以直接粘贴使用!');
    });




</script>
</body>
</html>