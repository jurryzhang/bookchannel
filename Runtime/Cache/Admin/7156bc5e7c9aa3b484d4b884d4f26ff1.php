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
    <?php if($_COOKIE['pid']== 0): ?><div class="btn-group" style="margin-left: 30px;margin-top: 20px;">
    <a style="" href="/Channel/addSchannel.html" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>添加代理</a></div>
    <?php else: endif; ?>
    <section class="content">
        <!--主渠道信息-->
        <div class="container-fluid">
        
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        渠道汇总
                    </h3>
                </div>

                <div class="panel-body">
                    <?php if(empty($channelSelf)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" style="margin-bottom:-10px;">
                                    <thead>
                                    <tr>
                                         <!-- <td class="text-center">
                                            ID
                                        </td>-->
                                        <td class="text-center">
                                            创建时间
                                        </td>
                                        <td class="text-center">
                                            账号名(登录用)
                                        </td>
                                        <?php if(($_COOKIE['permissions']== 0)): else: ?>
                                        <td class="text-center">
                                            代理名称
                                        </td><?php endif; ?>
                                        <td class="text-center">
                                            佣金比例
                                        </td>
                                        <!-- <td class="text-right">
                                            今日充值金额
                                        </td>
                                        <td class="text-center">
                                            今日新增用户
                                        </td>

                                        <td class="text-right">
                                            今日新增关注
                                        </td>

                                        <td class="text-center">
                                            新增用户
                                        </td>

                                        <td class="text-right">
                                            新增关注
                                        </td> -->

                                        <!-- <td class="text-center">
                                            成本
                                        </td> -->

                                        <td class="text-right">
                                            总充值金额
                                        </td>

                                        <td class="text-center">
                                            操作
                                        </td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($channelSelf)): $i = 0; $__LIST__ = $channelSelf;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                            <!-- <td class="text-center">
                                                <?php echo ($list["channelid"]); ?>
                                            </td>-->
                                            <td class="text-center">
                                                <?php echo (date("Y-md H:i:s",$list["posttime"])); ?>
                                            </td>
                                            <td class="text-center">
                                                
                                                <?php echo ($list["uname"]); ?>
                                                
                                            </td>
                                            <?php if(($_COOKIE['permissions']== 0)): else: ?>
                                            <td class="text-center">
                                                <a href="<?php echo U('Admin/channel/ptList',array('id' => $list['channelid']));?>">
                                                    <span  style="font-size:14px;"><?php echo ($list["channelname"]); ?></span>
                                                </a>
                                            </td><?php endif; ?>
                                             <td class="text-center">
                                                <span  style="font-size:14px;"><?php echo ($list["proportion"]); ?></span>
                                            </td>


                                            <!-- <td class="text-right">
                                                <span  style="font-size:14px;"><?php echo ($list["todaypaylogsum"]); ?></span>
                                                <p style="color:#aaa;font-size:12px;margin-top:4px;"><?php echo ($list["todaypaylogcount"]); ?>笔</p>
                                            </td>

                                            <td class="text-center">
                                                <span  style="font-size:14px;"><?php echo ($list["todayusersum"]); ?></span>
                                            </td>

                                            <td class="text-right">
                                                <span  style="font-size:14px;"><?php echo ($list["todayfollowusersum"]); ?></span>
                                                <p style="color:#aaa;font-size:12px;margin-top:4px;">关注率 <?php echo (round($list['todayfollowusersum']/$list['todayusersum']*100,0)); ?>%</p>
                                            </td>

                                            <td class="text-center">
                                                <span  style="font-size:14px;"><?php echo ($list["usersum"]); ?></span>
                                            </td>

                                            <td class="text-right" style="font-size:16px;">
                                                <span  style="font-size:14px;"><?php echo ($list["followusersum"]); ?></span>
                                                <p style="color:#aaa;font-size:12px;margin-top:4px;">关注率 <?php echo (round($list['followusersum']/$list['usersum']*100,0)); ?>%</p>
                                            </td> -->

                                            <!-- <td class="text-center">
                                                <span  style="font-size:14px;"><?php echo ($list["cost"]); ?></span>
                                            </td> -->

                                            <td class="text-right">
                                                <!-- <?php echo (round($list['paidmoney']/$list['proportion']+$list['remainmoney'],2)); ?> -->
                                                <span  style="font-size:14px;"><?php echo ($list["paylogsum"]); ?></span>
                                                <p style="color:#aaa;font-size:12px;margin-top:4px;"> <?php echo ($list["paylogcount"]); ?>笔</p>
                                            </td>

                                            <td class="text-center">
											<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Admin/Channel/editSChannel',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="编辑信息" target="rightContent">
                                                    <span>编辑</span>
                                                </a>

                                                <a href="<?php echo U('Channel/remainMoney',array('channelid'=>$list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-success" data-original-title="结算统计" target="rightContent">
                                                    <span>结算</span>
                                                </a><?php endif; ?>
                                                <a href="<?php echo U('Admin/User/channelPayLogListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                                    <span>订单</span>
                                                </a>
                                                <!-- <a href="<?php echo U('Admin/User/channelUserListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                                                    <span>用户</span>
                                                </a> -->
												
												<a href="<?php echo U('Admin/Channel/dataStatisticsByChannelid',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
													<span>数据统计</span>
												</a>

												<a href="<?php echo U('Admin/channel/ptList',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="查看详情" target="rightContent">
													<span>推广链接</span>
												</a>

                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="channelid" value="<?php echo ($channelid); ?>"/>
                        </form>
                        <div class="row">
                            <div class="col-sm-3 text-left"></div>
                            <div class="col-sm-9 text-right"><?php echo ($page); ?></div>
                        </div><?php endif; ?>
                </div>
            </div>
        </div>

        <!--渠道列表-->
        <div class="container-fluid">
            <?php if($_COOKIE['pid']== 0): ?><div class="panel panel-default">
                    <div class="panel-heading"  style="padding: 5px 15px">
                        <strong class="panel-title">
                            <i class="fa fa-list"></i>
                            代理列表
                        </strong>

                        <form action="" id="search-form2" class="navbar-form form-inline" style="display: inline-block;margin-left:50px;height: 40px;margin-top: 0px; margin-bottom:0px;padding: 0px; " method="post" onsubmit="return false">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="keyword" value="" placeholder="账户名/渠道名" id="input-order-id" class="form-control">
                                </div>
                            </div>
                            <button type="submit" onclick="ajax_get_table('search-form2',1,0)" id="button-filter search-order" class="btn btn-primary">
                                <i class="fa fa-search"></i> 筛选
                            </button>
                            <input type="hidden" name="channelid" value="<?php echo ($channelid); ?>"/>
                            <!-- <input type="hidden" name="orderby1" value='posttime'>
                            <input type="hidden" name="orderby2" value='desc'> -->
                        </form>
                    </div>

                    <div class="panel-body">
                        <div id="ajax_return_channel"></div>
                    </div>
                </div><?php endif; ?>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
   function getCookie(c_name)
    {
        if (document.cookie.length>0)
        {
            c_start=document.cookie.indexOf(c_name + "=")
            if (c_start!=-1)
            {
                c_start=c_start + c_name.length+1
                c_end=document.cookie.indexOf(";",c_start)
                if (c_end==-1) c_end=document.cookie.length
                return unescape(document.cookie.substring(c_start,c_end))
            }
        }
        return "";
    }

    function setCookie(c_name,value,expiredays)
    {
        var exdate=new Date()
        exdate.setDate(exdate.getDate()+expiredays)
        document.cookie=c_name+ "=" +escape(value)+
            ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
    }

    $(document).ready(function()
    {
        // ajax 加载商品列表
         var page=1;
        var cookiepage=getCookie('pg');
        if(cookiepage>1){
            page =cookiepage;
        }
        ajax_get_table('search-form2',page);
        //ajax_get_table('form-order',1);

        
    });

    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');
        setCookie('pg',cur_page,1);
        ajax_get_table('search-form2',cur_page);
    });

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page,ischannel)
    {
        cur_page = page; //当前页面 保存为全局变量
        dd = $('#' + form).serialize();
        //alert(dd)
        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=Channel&a=ajaxChannelListCombine&p="+page,
                data    : $('#' + form).serialize(),// 你的formid

                success : function(data)
                {
                    $("#ajax_return_channel").html('');

                    $("#ajax_return_channel").append(data);
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
  // 点击排序
    function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',1);
    }

 

 
</script>
</body>
</html>