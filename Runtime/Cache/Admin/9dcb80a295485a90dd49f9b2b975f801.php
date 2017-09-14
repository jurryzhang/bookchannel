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
                        广告列表
                    </h3>
                </div>

                <div class="panel-body">
                    <?php if($_COOKIE['uid']> 0): ?><div class="navbar navbar-default">
                        <form action="/index.php?s=/Ad/titleList/" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
                                <button type="button" onclick="location.href='/index.php?s=/Ad/adAdd.html'" class="btn btn-primary pull-left">
                                    <i class="fa fa-plus"></i>添加广告
                                </button>
                            <?php if(($_COOKIE['pid']== 0)AND($_COOKIE['permissions']== 0)){ ?>
                            <div class="form-group" style="margin-right: 50px;float: right">
                                <strong>本站广告计划:</strong>
                                <select id="adplan" name="adplan" class="form-control" style="width: 150px; display: inline-block;" onchange="setAdplan()">
                                    <option value="0"  <?php if(($adplan == '0')): ?>selected="selected"<?php endif; ?> >系统广告</option>
                                    <option value="1" <?php if(($adplan == '1')): ?>selected="selected"<?php endif; ?> >本站公众号</option>
                                    <option value="2" <?php if(($adplan == '2')): ?>selected="selected"<?php endif; ?> >自定义广告</option>
                                    <option value="3" <?php if(($adplan == '3')): ?>selected="selected"<?php endif; ?> >关闭广告</option>
                                </select>
                            </div>
                            <?php } ?>
                        </form>
                    </div><?php endif; ?>
                    <?php if(empty($adlist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
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
                                            广告标题
                                        </td>

                                        <td class="text-center">
                                            广告展现时间
                                        </td>

                                        <td class="text-center">
                                            添加时间
                                        </td>

                                        <td class="text-center">
                                            广告类型
                                        </td>
                                        <td class="text-center">
                                           状态
                                        </td>
                                        <td class="text-center">
                                            操作
                                        </td>
                                        <td class="text-center">
                                            默认
                                        </td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($adlist)): $i = 0; $__LIST__ = $adlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr onmouseover="isdefaultO(<?php echo ($list["id"]); ?>)" onmouseleave="isdefaultL(<?php echo ($list["id"]); ?>)">
                                            <?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                                                <?php echo ($list["id"]); ?>
                                            </td><?php endif; ?>

                                            <td class="text-center">
                                                <?php echo ($list["title"]); ?>
                                            </td>


                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["starttime"])); ?> ----- <?php echo (date('Y-m-d H:i:s',$list["endtime"])); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["addtime"])); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($list["adtype"] == 1): ?>微信关注卡
                                                    <?php elseif($list["adtype"] == 2): ?>
                                                    图文广告
                                                    <?php elseif($list["adtype"] == 3): ?>
                                                    图片广告
                                                    <?php else: ?>
                                                    其他<?php endif; ?>

                                            </td>
                                            <td class="text-center">
                                                <?php if($list["display"] == 1): ?><a href="javascript:void(0)" onclick="setDisplay(this,<?php echo ($list["id"]); ?>)" data-display="<?php echo ($list["display"]); ?>" class="btn btn-success btn-xs"" >
                                                    <span>已启用</span>
                                                    </a>
                                                    <?php else: ?>
                                                    <a href="javascript:void(0)" onclick="setDisplay(this,<?php echo ($list["id"]); ?>)"  data-display="<?php echo ($list["display"]); ?>" class="btn btn-danger btn-xs"" >
                                                    <span>已屏蔽</span>
                                                    </a><?php endif; ?>
                                            </td>


                                            <td class="text-center">
                                                    <a href="/index.php?s=/Ad/adEdit/id/<?php echo ($list["id"]); ?>.html"  title="" class="btn btn-success" data-original-title="发送消息">
                                                        <span>编辑</span>
                                                    </a>
                                                    <a href="javascript:void (0)" onclick="del(<?php echo ($list["id"]); ?>,this);" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除任务">
                                                        <span>删除</span>
                                                    </a>
                                            </td>

                                            <td  class="text-center">

                                                <?php if($list["isdefault"] == 1): ?><span style="border-radius: 3px; padding: 2px 5px;font-size: 8px;border: 1px solid #f30;color:#f30;background: #ffd6cc;">默认广告</span>
                                                 <?php else: ?>
                                                    <a href="/index.php?s=/Ad/setDefault/id/<?php echo ($list["id"]); ?>/cid/<?php echo ($list["channelid"]); ?>.html"  id="isdefault<?php echo ($list["id"]); ?>" class="btn btn-warning btn-xs " style="display: none" >
                                                        <span>设为默认</span>
                                                    </a><?php endif; ?>

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





    function setAdplan()
    {
       var plan= $('#adplan option:selected').val();
        layer.confirm('确定要更改广告计划吗?',
            function(){
                $.ajax(
                    {
                        url     : "/index.php?s=/Ad/setAdplan/plan/"+plan,
                        success : function(v)
                        {
                            if(v.status==1){
                                layer.msg(v.info, {icon: 1,time: 1000});
                            }else {
                                layer.msg(v.info, {icon: 2,time: 1000});
                            }
                        }
                    });
            }

        );
        return false;
    }

    function setDisplay(obj,id)
    {
        var display= $(obj).attr('data-display')*1;
        console.log(display);
        if(display){
            layer.confirm('确定要把当前广告屏蔽吗?',
                function(){
                    ajaxSetDisplay(!display,id,obj);
                }

            );
        }else{
            layer.confirm('确定要更改这条广告状态为显示状态?',
                function(){
                    ajaxSetDisplay(!display,id,obj);
                }

            );
        }

    }
function ajaxSetDisplay(display,id,obj) {
        if(display){
            display=1;
        }else {
            display=0;
        }
    $.ajax(
        {
            url     : "/index.php?s=/Ad/setDisplay/id/"+id+"/display/"+display,
            success : function(v)
            {
                if(v.status==1){
                    layer.msg(v.info, {icon: 1,time: 1000});
                    if(display){
                       $(obj).attr('data-display','1');
                       $(obj).removeClass('btn-danger');
                       $(obj).addClass('btn-success');
                       $(obj).html('<span>已启用</span>');
                    }else {
                        $(obj).attr('data-display','0');
                        $(obj).removeClass('btn-success');
                        $(obj).addClass('btn-danger');
                        $(obj).html('<span>已屏蔽</span>');

                    }

                }else {
                    layer.msg(v.info, {icon: 2,time: 1000});
                }
            }
        });
}

function isdefaultO(id) {
    $('#isdefault'+id).css('display','');
}

function isdefaultL(id) {
    $('#isdefault'+id).css('display','none');
}

</script>
</body>
</html>