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
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        订单明细
                    </h3>
                </div>
                </if>
                <div class="panel-body">
                    <?php if(empty($data)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <td class="text-center">
                                            编号
                                        </td>
                                        <td class="text-center">
                                            订单类型
                                        </td>
                                        <td class="text-center">
                                            用户
                                        </td>
                                        <td class="text-center">
                                            充值金额
                                        </td>
                                        <td class="text-center">
                                            账户名(登录用)
                                        </td>
                                        <td class="text-center">
                                            充值时间
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="text-center">
                                                <?php echo ($val["payid"]); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($val["paytype"]); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($val["name"]); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($val['money']); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo ($val['uname']); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo date('Y-m-d H:s:i',$val['buytime']);?>
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
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(document).ready(function()
    {
        // ajax 加载商品列表
        ajax_get_table('search-form2',1);

        ajax_get_paylog('search-form2',1);

        ajax_get_userinfo('search-form2',1);
    });

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page,ischannel)
    {
        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "./index.php?m=Admin&c=Channel&a=ajaxChannelList&p="+page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return").html('');

                    $("#ajax_return").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }

    // 删除操作
    function del(id)
    {
        if(!confirm('确定要删除吗?'))
        {
            return false;
        }

        $.ajax(
            {
                url     : "/index.php?m=Admin&c=Channel&a=delChannel&id="+id,
                success : function(v)
                {
                    var v =  eval('('+v+')');

                    if(v.hasOwnProperty('status') && (v.status == 1))
                    {
                        ajax_get_table('search-form2',cur_page);
                    }
                    else
                    {
                        layer.msg(v.msg, {icon: 2,time: 1000}); //alert(v.msg);
                    }
                }
            });

        return false;
    }

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_paylog(form,page)
    {
        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "./index.php?m=Admin&c=Channel&a=ajaxChannelInfoList&p="+page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return_paylog").html('');

                    $("#ajax_return_paylog").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_buyinfo(form,page)
    {
        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "./index.php?m=Admin&c=BookSale&a=ajaxBookSaleListByChannelID&p="+page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return_buyinfo").html('');

                    $("#ajax_return_buyinfo").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_useraccessslog(form,page)
    {
        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "./index.php?m=Admin&c=User&a=ajaxChannelUserAccessLog&p="+page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return_useraccessslog").html('');

                    $("#ajax_return_useraccessslog").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_userinfo(form,page)
    {
        cur_page = page; //当前页面 保存为全局变量

        $.ajax(
            {
                type    : "POST",
                url     : "./index.php?m=Admin&c=User&a=ajaxChannelUserList&p="+page,
                data    : $('#' + form).serialize(),// 你的formid
                success : function(data)
                {
                    $("#ajax_return_userinfo").html('');

                    $("#ajax_return_userinfo").append(data);
                },
                error   : function(data)
                {
                    alert('error -- data = ' + data.responseText);
                }
            });
    }


    function batSettlement(){
        layer.confirm('一键结算前建议先导出记录保存？<br/>确定要一键结算吗',function(index){
            $.ajax({
                type: 'GET',
                url: '/index.php?s=/Channel/batSettlement',
                success: function(data){
                    if(data.status==1){
                        layer.msg(data.info,{icon:1,time:1500},function () {
                            parent.rightContent.location.reload();
                        });
                    }else {
                        layer.msg(data.info,{icon:5,time:3000});
                    }
                },
            });
        });
    }

    //公告信息详情
    function affdetail(url,w,h){
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            content: url
        });
    }
    function payment(){
        $('')
    }
</script>
</body>
</html>