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
<script src="/Public/js/switch/honeySwitch.js"></script>
<link rel="stylesheet" href="/Public/js/switch/honeySwitch.css">

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
                        广告权限管理
                    </h3>
                </div>

                <div class="panel-body">
                    <?php if($_COOKIE['uid']> 0): ?><div class="navbar navbar-default">
                        <form action="/index.php?s=/Ad/adSwitch/" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">

                                <label class="control-label" style="margin-top: -20px;font-size: 15px">全站广告开关:</label>
                            <?php if($sitead): ?><span class="switch-on" id="sitead" ></span>
                                <?php else: ?>
                                <span class="switch-off"   id="sitead" ></span><?php endif; ?>
                        </form>
                    </div><?php endif; ?>
                    <?php if(empty($channellist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
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
                                           渠道名称
                                        </td>

                                        <td class="text-center">
                                            渠道类型
                                        </td>

                                        <td class="text-center">
                                            添加时间
                                        </td>

                                        <td class="text-center">
                                            广告计划
                                        </td>

                                        <td class="text-center">
                                            广告权限状态
                                        </td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($channellist)): $i = 0; $__LIST__ = $channellist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                            <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                                <?php echo ($list["channelid"]); ?>
                                            </td><?php endif; ?>

                                            <td class="text-center">
                                                <?php echo ($list["channelname"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["channeltype"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["posttime"])); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($list["adplan"] == 0): ?>系统广告
                                                    <?php elseif($list["adplan"] == 1): ?>
                                                    自己公众号引导
                                                    <?php else: ?>
                                                    自定义广告<?php endif; ?>
                                            </td>

                                            <td class="text-center" >
                                                    <?php if($list["adpower"] == 1): ?><span class="switch-on" id="ad<?php echo ($list["channelid"]); ?>" ></span>
                                                        <?php else: ?>
                                                        <span class="switch-off"   id="ad<?php echo ($list["channelid"]); ?>" ></span><?php endif; ?>
                                                <input type="hidden" class="addata" name="channelid" value="<?php echo ($list["channelid"]); ?>" />
                                            </td>

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
                        url     : "/index.php?s=/Ad/adDel/id/"+id,
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


    //全站广告开关
    $(function() {
        switchEvent("#sitead", function () {
            //次处写开的方法
            $.get("/index.php?s=/Ad/siteAd/status/on",function (v) {
                if (v.status == 1) {
                    layer.msg(v.info, {icon: 1, time: 1000});
                } else {
                    layer.msg(v.info, {icon: 2, time: 1000});
                }
            });
        }, function () {
            //此处写关的方法
                $.get("/index.php?s=/Ad/siteAd/status/off",function (v) {
                    if (v.status == 1) {
                        layer.msg(v.info, {icon: 1, time: 1000});
                    } else {
                        layer.msg(v.info, {icon: 2, time: 1000});
                    }
                });
        })
    });

    //给开关绑定事件
   function adswitch(id) {
       switchEvent("#ad"+id, function () {
           //次处写开的方法
           $.get("/index.php?s=/Ad/setAdpower/status/on/id/"+id,function (v) {
               if(v.status==1){
                   layer.msg(v.info, {icon: 1,time: 1000});
               }else {
                   layer.msg(v.info, {icon: 2,time: 1000});
               }
           });
       }, function () {
           //此处写关的方法
           $.get("/index.php?s=/Ad/setAdpower/status/off/id/"+id,function (v) {
               if(v.status==1){
                   layer.msg(v.info, {icon: 1,time: 1000});
               }else {
                   layer.msg(v.info, {icon: 2,time: 1000});
               }
           });
       });
   }

   $(function () {
       $.each($('.addata'),function (k,v) {
           adswitch($(v).val());
       })
   });

</script>
</body>
</html>