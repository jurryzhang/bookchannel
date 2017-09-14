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
                        模版消息列表
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="/index.php?s=/Channel/titleList/" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">

                                <!--<div class="form-group">
                                    <select id="channel" name="channel" class="form-control" style="width: 350px; display: inline-block;">
                                        <option value="" <?php if(($channel == '全部')): ?>selected="selected"<?php endif; ?> >全部</option>
                                        <option value="通用" <?php if(($channel == '通用')): ?>selected="selected"<?php endif; ?> >通用</option>
                                        <option value="男频" <?php if(($channel == '男频')): ?>selected="selected"<?php endif; ?> >男频</option>
                                        <option value="女频" <?php if(($channel == '女频')): ?>selected="selected"<?php endif; ?> >女频</option>
                                    </select>
                                </div>
                                <input type="hidden" name="orderby1" value="articleid" />
                                <input type="hidden" name="orderby2" value="desc" />

                                <button type="submit" onclick="this.form.submit()" id="button-filter search-order" class="btn btn-primary">
                                    <i class="fa fa-search"></i> 筛选
                                </button>-->

                                <button type="button" onclick="location.href='/index.php?s=/Channel/tplAdd.html'" class="btn btn-primary pull-left">
                                    <i class="fa fa-plus"></i>添加模版消息
                                </button>

                        </form>
                    </div>
                    <?php if(empty($tpllist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-center">
                                            ID
                                        </td>

                                        <td class="text-center">
                                            任务名称
                                        </td>

                                        <td class="text-center">
                                            模版
                                        </td>

                                        <td class="text-center">
                                            添加时间
                                        </td>

                                        <td class="text-center">
                                            发送时间
                                        </td>

                                        <td class="text-center">
                                            发送人数
                                        </td>

                                        <td class="text-center">
                                            成功人数
                                        </td>

                                            <td class="text-center">
                                                操作
                                            </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($tpllist)): $i = 0; $__LIST__ = $tpllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="text-center">
                                                <?php echo ($list["id"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["title"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["tpltitle"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["addtime"])); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo (date('Y-m-d H:i:s',$list["sendtime"])); ?>
                                                <?php if($list["issend"] == 0): ?><span class="badge bg-red">未发送</span>
                                                    <?php elseif($list["issend"] == -1): ?>
                                                    <span class="badge bg-yellow">发送中</span>
                                                        <?php else: ?>
                                                    <span class="badge bg-green">已发送</span><?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["sendcount"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($list["okcount"]); ?>
                                            </td>



                                            <td class="text-center">

                                                <?php if($list["issend"] == 0): ?><a href="/index.php?s=/Channel/tplEdit/id/<?php echo ($list["id"]); ?>.html"  title="" class="btn btn-success" data-original-title="发送消息">
                                                        <span>编辑</span>
                                                    </a><?php endif; ?>
                                                    <a href="javascript:void (0)" onclick="del(<?php echo ($list["id"]); ?>,this);" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除任务">
                                                        <span>删除</span>
                                                    </a>

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
                        url     : "/index.php?s=/Channel/tplDel/id/"+id,
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






</script>
</body>
</html>