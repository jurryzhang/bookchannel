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
        
		<!--财务信息-->
        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"> </i>
                        <span style="color: #9e9e9e"><?php echo ($channelinfo['uname']); ?> 财务信息</span>
                    </h3>
                </div>

                <div class="panel-body">
                    <!--通用信息-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_tongyong">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td style="color: #9e9e9e">
                                        渠道名称:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        联系人：
                                    </td>
                                    <td style="color: #9e9e9e">
                                        联系电话:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        开户行:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        银行账户名:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        银行卡号:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        支行信息:
                                    </td>
                                    <td style="color: #9e9e9e">
                                        联系地址:
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['uname']!=''?$bankInfo['uname']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['pname']!=''?$bankInfo['pname']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['tel']!=''?$bankInfo['tel']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['bank']!=''?$bankInfo['bank']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['bankname']!=''?$bankInfo['bankname']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['banknum']!=''?$bankInfo['banknum']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['bankaddr']!=''?$bankInfo['bankaddr']:'未添加'); ?>
                                    </td>
                                    <td style="color: #9e9e9e">
                                        <?php echo ($bankInfo['addr']!=''?$bankInfo['addr']:'未添加'); ?>
                                    </td>
                                </tr>
                                <tbody />
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
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
                            <span style="color: #9e9e9e"><?php echo ($channelinfo['uname']); ?></span> 结算单
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
                                            日期
                                        </td>
                                        <td class="text-center">
                                            总笔数
                                        </td>
                                        <td class="text-center">
                                            充值金额
                                        </td>
                                        <td class="text-center">
                                            账单金额
                                        </td>
                                        <td class="text-center">
                                            分成比例
                                        </td>
                                        <td class="text-center">
                                            状态
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><tr>
                                            <td class="text-center">
                                                <?php echo date('Y-m-d',$val['buytime']);?>
                                            </td>

                                            <td class="text-center">
                                                <a href="/index.php?s=/Channel/paymentInfo/time/<?php echo date('Y-m-d',$val['buytime']);?>/channelid/<?php echo ($channelid); ?>.html">
                                                    <?php echo ($val["count"]); ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($val["summoney"]); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($val['summoney'] * $channelinfo['proportion']); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php echo ($channelinfo['proportion']); ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($issum == 1): if($val['status'] == 1): ?><a href="javascript:void(0);"
                                                           data-time="<?php echo date('Y-m-d',$val['buytime']);?>" data-id="<?php echo ($channelid); ?>" data-askmoney="<?php echo ($val["summoney"]); ?>"
                                                           data-pro="<?php echo ($channelinfo['proportion']); ?>" data-paymoney="<?php echo ($val['summoney'] * $channelinfo['proportion']); ?>"
                                                           class="badge bg-yellow askpayment" style="padding: 5px 10px">
                                                            结算中
                                                        </a>
                                                        <?php elseif($val['status'] == 2): ?>
                                                        <a href="javascript:void(0);"
                                                           data-time="<?php echo date('Y-m-d',$val['buytime']);?>" data-id="<?php echo ($channelid); ?>" data-askmoney="<?php echo ($val["summoney"]); ?>"
                                                           data-pro="<?php echo ($channelinfo['proportion']); ?>" data-paymoney="<?php echo ($val['summoney'] * $channelinfo['proportion']); ?>"
                                                           class="badge bg-green askpayment" style="padding: 5px 10px">
                                                            已结算
                                                        </a>
                                                        <?php else: ?>
                                                        <a href="javascript:void(0);"
                                                           data-time="<?php echo date('Y-m-d',$val['buytime']);?>" data-id="<?php echo ($channelid); ?>" data-askmoney="<?php echo ($val["summoney"]); ?>"
                                                           data-pro="<?php echo ($channelinfo['proportion']); ?>" data-paymoney="<?php echo ($val['summoney'] * $channelinfo['proportion']); ?>"
                                                           class="badge bg-red askpayment" style="padding: 5px 10px">
                                                            申请结算
                                                        </a><?php endif; ?>
                                                <?php elseif($_COOKIE['channelid']== $channelid): ?>													
													<a href="/index.php?s=/Channel/paymentInfo/time/<?php echo date('Y-m-d',$val['buytime']);?>/channelid/<?php echo ($channelid); ?>.html"
														   class="badge bg-green" style="padding: 5px 10px">
														   充值明细
													</a>
												<?php else: ?>
													<?php if($val['status'] == 1): ?><a href="javascript:void(0);"
														   data-time="<?php echo date('Y-m-d',$val['buytime']);?>" data-id="<?php echo ($channelid); ?>" data-askmoney="<?php echo ($val["summoney"]); ?>"
														   data-pro="<?php echo ($channelinfo['proportion']); ?>" data-paymoney="<?php echo ($val['summoney'] * $channelinfo['proportion']); ?>"
														   class="badge bg-yellow dealAskpay" style="padding: 5px 10px">
															用户申请结算
														</a>
														<?php elseif($val['status'] == 2): ?>
														<a href="/index.php?s=/Channel/paymentInfo/time/<?php echo date('Y-m-d',$val['buytime']);?>/channelid/<?php echo ($channelid); ?>.html"
														   class="badge bg-green" style="padding: 5px 10px">
															结算成功
														</a>
														<?php else: ?>
														<a href="javascript:void(0);"
														   data-time="<?php echo date('Y-m-d',$val['buytime']);?>" data-id="<?php echo ($channelid); ?>" data-askmoney="<?php echo ($val["summoney"]); ?>"
														   data-pro="<?php echo ($channelinfo['proportion']); ?>" data-paymoney="<?php echo ($val['summoney'] * $channelinfo['proportion']); ?>"
														   class="badge bg-red dealAskpay" style="padding: 5px 10px">
															未结算
														</a><?php endif; endif; ?>

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
   
   

    //结算申请
    $(function(){
        $('.askpayment').click(function(){
            var _this=$(this);
            var asktime=_this.attr('data-time');
            var channleid=_this.attr('data-id');
            var askmoney=_this.attr('data-askmoney');
            var paymoney=_this.attr('data-paymoney');
            var proportion=_this.attr('data-pro');
            if(_this.hasClass('bg-yellow')){
                layer.msg('已提交申请,请勿重复操作',{icon:5});
                history.go(0);
                return false;
            }
            if(_this.hasClass('bg-green')){
                layer.msg('已结算成功',{icon:7});
                history.go(0);
                return false;
            }
            $.ajax(
                {
                    type    : "POST",
                    url     : "/index.php?m=Admin&c=Askpayment&a=index",
                    data    : {asktime:asktime,channelid:channleid,askmoney:askmoney,paymoney:paymoney,proportion:proportion},
                    success : function(data)
                    {
                        if(data.result==1){
                        
                            layer.msg(data.msg,{icon:6});
                            _this.removeClass('bg-red').addClass('bg-yellow').html('结算中');
                            history.go(0);
                        }else{
                            layer.msg(data.msg,{icon:5});
                            history.go(0);
                        }

                    },
                    error   : function(data)
                    {
                        layer.msg(data.msg,{icon:5});
                        history.go(0);
                    }
                });
        });
        //处理结算申请
        /*$('.dealAskpay').click(function(){
            var _this=$(this);
            var asktime=_this.attr('data-time');
            var channleid=_this.attr('data-id');
            var askmoney=_this.attr('data-askmoney');
            var paymoney=_this.attr('data-paymoney');
            var proportion=_this.attr('data-pro');
            if(_this.hasClass('bg-green')){
                layer.msg('已结算',{icon:7});
                return false;
            }
            $.ajax(
                {
                    type    : "POST",
                    url     : "/index.php?m=Admin&c=Askpayment&a=dealAskpay",
                    data    : {asktime:asktime,channelid:channleid,askmoney:askmoney,paymoney:paymoney,proportion:proportion},
                    success : function(data)
                    {
                        if(data.result==1){
                            layer.msg(data.msg,{icon:6});
                            _this.removeClass('bg-red').addClass('bg-green').html('结算成功');
                        }else{
                            layer.msg(data.msg,{icon:5});
                        }

                    },
                    error   : function(data)
                    {
                        layer.msg(data.msg,{icon:5});
                    }
                });
        });*/
		/*处理结算申请*/
		$('.dealAskpay').click(function(){
            var _this=$(this);
            if(time<1){
                dealAsk(_this);
            }
        });		
    })
	
	var time=0;
    function dealAsk(_this){
        var asktime=_this.attr('data-time');
        var channleid=_this.attr('data-id');
        var askmoney=_this.attr('data-askmoney');
        var paymoney=_this.attr('data-paymoney');
        var proportion=_this.attr('data-pro');
        if(_this.hasClass('bg-green')){
            layer.msg('已结算',{icon:7});
            history.go(0);
            return false;
        }
        if(time<1) {
            $.ajax(
                {
                    type: "POST",
                    url: "/index.php?m=Admin&c=Askpayment&a=dealAskpay",
                    data: {
                        asktime: asktime,
                        channelid: channleid,
                        askmoney: askmoney,
                        paymoney: paymoney,
                        proportion: proportion
                    },
                    success: function (data) {
                        time++;
                        if (data.result == 1) {
                            layer.msg(data.msg, {icon: 6});
                            _this.removeClass('bg-red').addClass('bg-green').html('结算成功');
                            history.go(0);
                        } else {
                            layer.msg(data.msg, {icon: 5});
                            history.go(0);
                        }

                    }
                });
            time++;
        }
    }

</script>
</body>
</html>