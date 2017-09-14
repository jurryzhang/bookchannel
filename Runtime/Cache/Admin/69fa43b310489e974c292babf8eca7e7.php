<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
	<section class="content">

		<div class="row">
			<div class="tabs-container">
				<ul class="nav nav-tabs" style="border-bottom: none">
					<li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">订单统计</a>
					</li>
					<?php if($_COOKIE['cpid']<= 0): ?><li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">用户统计</a>
					</li><?php endif; ?>
				</ul>
				<div class="tab-content" style="margin-bottom: 20px;background: #ffffff">
					<div id="tab-1" class="tab-pane active">
						<div class="panel-body">

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:136px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-orange" style="width:136px;height:136px;line-height:136px;text-aligh:center;">
											<i class="fa fa-money"></i>
										</span>
										<div class="info-box-content" style="margin-left:136px;">
										<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
									<?php if($_COOKIE['permissions']== 1): ?><a href="<?php echo U('Index/newPayLog');?>">
									<?php else: ?>
										<a href="<?php echo U('Index/newPayLog',array('channelid'=>$_COOKIE['channelid']));?>"><?php endif; ?>		
											<span class="info-box-text">当日充值</span>
											<span class="info-box-number"><?php echo ($dayPayInfo['daypaySum']); ?></span>
											<div style="width: 100%;margin-top:4px;">
												<div style="color:#aaa;font-size:12px;float: left;">
													<p style="color:#666;font-size:15px;line-height: 6px">普通充值</p>
													<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($dayPayInfo['dayCommonPaySum']); ?></p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($dayPayInfo['dayCommonPayCount']); ?>笔</p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($dayPayInfo['dayCommonUnPayCount']); ?>笔</p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($dayPayInfo['dayCommonPayCount']/($dayPayInfo['dayCommonPayCount']+$dayPayInfo['dayCommonUnPayCount'])*100,0)); ?>%</p>
												</div>
												<div style="color:#aaa;font-size:12px;float: left;margin-left: 20px">
													<p style="color:#666;font-size:15px;line-height: 6px">年费充值</p>
													<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($dayPayInfo['dayYearPaySum']); ?></p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($dayPayInfo['dayYearpayCount']); ?>笔</p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($dayPayInfo['dayYearUnPayCount']); ?>笔</p>
													<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($dayPayInfo['dayYearpayCount']/($dayPayInfo['dayYearpayCount']+$dayPayInfo['dayYearUnPayCount'])*100,0)); ?>%</p>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:136px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-green" style="width:136px;height:136px;line-height:124px;text-aligh:center;">
											<i class="fa fa-money"></i>
										</span>
										<div class="info-box-content" style="margin-left:136px;">
										<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">昨日充值</span>
										<span class="info-box-number"><?php echo ($payInfo['yeaterdayPaySum']); ?></span>
										<!--<p style="color:#aaa;font-size:12px;">笔数 <?php echo ($yesterdaypayCount); ?></p>-->
										<div style="width: 100%;margin-top:4px;">
											<div style="color:#aaa;font-size:12px;float: left;">
												<p style="color:#666;font-size:15px;line-height: 6px">普通充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['yeaterdayCommonPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($payInfo['yeaterdayCommonPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($payInfo['yeaterdayCommonUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($payInfo['yeaterdayCommonPayCount']/($payInfo['yeaterdayCommonPayCount']+$payInfo['yeaterdayCommonUnPayCount'])*100,0)); ?>%</p>
											</div>
											<div style="color:#aaa;font-size:12px;float: left;margin-left: 20px">
												<p style="color:#666;font-size:15px;line-height: 6px">年费充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['yesterdayYearPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($payInfo['yesterdayYearPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($payInfo['yesterdayYearUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($payInfo['yesterdayYearPayCount']/($payInfo['yesterdayYearPayCount']+$payInfo['yesterdayYearUnPayCount'])*100,0)); ?>%</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:136px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-teal" style="width:136px;height:136px;line-height:136px;text-aligh:center;">
											<i class="fa fa-money"></i>
										</span>
										<div class="info-box-content" style="margin-left:136px;">
										<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">本月充值(不含当日)</span>
										<span class="info-box-number"><?php echo ($payInfo['monthPaySum']); ?></span>
										<!--<p style="color:#aaa;font-size:12px;">笔&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数 <?php echo ($monthpayCount); ?></p>-->
										<span style="color:#aaa;font-size:12px;float: right;margin-top: -40px">充值人数 <?php echo ($payInfo['monthPayPeopleNum']); ?></span>
										<div style="width: 100%;margin-top:4px;">
											<div style="color:#aaa;font-size:12px; float:left;">
												<p style="color:#666;font-size:15px;line-height: 6px">普通充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['monthCommonPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($payInfo['monthCommonPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($payInfo['monthCommonUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($payInfo['monthCommonPayCount']/($payInfo['monthCommonPayCount']+$payInfo['monthCommonUnPayCount'])*100,0)); ?>%</p>
											</div>
											<div style="color:#aaa;font-size:12px;float: left;margin-left: 20px">
												<p style="color:#666;font-size:15px;line-height: 6px">年费充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['monthYearPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ： <?php echo ($payInfo['monthYearPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ： <?php echo ($payInfo['monthYearUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ： <?php echo (round($payInfo['monthYearPayCount']/($payInfo['monthYearPayCount']+$payInfo['monthYearUnPayCount'])*100,0)); ?>%</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:136px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-blue" style="width:136px;height:136px;line-height:136px;text-aligh:center;">
											<i class="fa fa-money"></i>
										</span>
										<div class="info-box-content" style="margin-left:136px;">
										<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">累计充值(不含当日)</span>
										<span class="info-box-number"><?php echo ($payInfo['sumPay']); ?></span>
										<!--<p style="color:#aaa;font-size:12px;">笔&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数 <?php echo ($sumpayCount); ?></p>-->
										<span style="color:#aaa;font-size:12px;float: right;margin-top: -40px;">充值人数 <?php echo ($payInfo['sumPayPeopleNum']); ?>
										<p>同乐支付 <?php echo ($payInfo['sumTonglePay']); ?></p>
										</span>
										<div style="width: 100%;margin-top: 4px">
											<div style="color:#aaa;font-size:12px;float: left;">
												<p style="color:#666;font-size:15px;line-height: 6px">普通充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['commonPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ：<?php echo ($payInfo['commonPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ：<?php echo ($payInfo['commonUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ：<?php echo (round($payInfo['commonPayCount']/($payInfo['commonPayCount']+$payInfo['commonUnPayCount'])*100,0)); ?>%</p>
											</div>
											<div style="color:#aaa;font-size:12px;float: left;margin-left: 20px">
												<p style="color:#666;font-size:15px;line-height: 6px">年费充值</p>
												<p style="color:#8a6d3b;font-size:15px;line-height: 6px"><?php echo ($payInfo['yearPaySum']); ?></p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">已充值 ：<?php echo ($payInfo['yearPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">未充值 ：<?php echo ($payInfo['yearUnPayCount']); ?>笔</p>
												<p style="color:#aaa;font-size:12px;line-height: 6px">完成率 ：<?php echo (round($payInfo['yearPayCount']/($payInfo['yearPayCount']+$payInfo['yearUnPayCount'])*100,0)); ?>%</p>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<?php if(($_COOKIE['cpid']<= 0)): ?><div id="tab-2" class="tab-pane">
						<div class="panel-body">

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:128px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-green" style="width:128px;height:128px;line-height:128px;text-aligh:center;">
											<i class="fa fa-user-plus"></i>
										</span>
										<div class="info-box-content" style="margin-left:128px;">
									<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">今日新增</span>
										<span class="info-box-number"><?php echo ($dayUserInfo['dayUser']); ?></span>
										<div style="margin-top: 7px;">
											<p>
												<b style="color: #8a6d3b"><?php echo ($dayUserInfo['dayUserSex1']); ?></b>男性，
												<b style="color: #8a6d3b"><?php echo ($dayUserInfo['dayUserSex2']); ?></b>女性，
												<b style="color: #8a6d3b"><?php echo ($dayUserInfo['dayUserSex0']); ?></b>未知
											</p>
											<div style="line-height: 10px;">
												<p>已关注：<b style="color: #8a6d3b"><?php echo ($dayUserInfo['dayUserFocus']); ?> (<?php echo (round($dayUserInfo['dayUserFocus']/$dayUserInfo['dayUser']*100,0)); ?>%)</b></p>
												<p>已付费：<b style="color: #8a6d3b"><?php echo ($dayUserInfo['dayUserPay']); ?> (<?php echo (round($dayUserInfo['dayUserPay']/$dayUserInfo['dayUserFocus']*100,0)); ?>%)</b></p>
											</div>
										</div>
<!--
											<p style="color:#aaa;font-size:12px;">关注率 <?php echo (round($curDayFocus/$curDayReader*100,0)); ?>%</p>
-->
										<p style="color:#aaa;font-size:12px; float:right;margin-top: -20px;">今日签到:<?php echo ($count["daysign"]); ?></p>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:128px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-blue" style="width:128px;height:128px;line-height:128px;text-aligh:center;">
											<i class="fa fa-user"></i>
										</span>
										<div class="info-box-content" style="margin-left:128px;">
									<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">昨日新增</span>
										<span class="info-box-number"><?php echo ($userInfo['yesterdayUser']); ?></span>
										<div style="margin-top: 7px;">
											<p>
												<b style="color: #8a6d3b"><?php echo ($userInfo['yesterdayUserSex1']); ?></b>男性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['yesterdayUserSex2']); ?></b>女性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['yesterdayUserSex0']); ?></b>未知</p>
											<div style="line-height: 10px;">
												<p>已关注：<b style="color: #8a6d3b"><?php echo ($userInfo['yesterdayUserFocus']); ?> (<?php echo (round($userInfo['yesterdayUserFocus']/$userInfo['yesterdayUser']*100,0)); ?>%)</b></p>
												<p>已付费：<b style="color: #8a6d3b"><?php echo ($userInfo['yesterdayUserPay']); ?> (<?php echo (round($userInfo['yesterdayUserPay']/$userInfo['yesterdayUserFocus']*100,0)); ?>%)</b></p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:128px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-orange" style="width:128px;height:128px;line-height:128px;text-aligh:center;">
											<i class="fa fa-user"></i>
										</span>
										<div class="info-box-content" style="margin-left:128px;">
									<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">本月新增(不含当日)</span>
										<span class="info-box-number"><?php echo ($userInfo['monthUser']); ?></span>
										<div style="margin-top: 7px;">
											<p>
												<b style="color: #8a6d3b"><?php echo ($userInfo['monthUserSex1']); ?></b>男性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['monthUserSex2']); ?></b>女性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['monthUserSex0']); ?></b>未知</p>
											<div style="line-height: 10px;">
												<p>已关注：<b style="color: #8a6d3b"><?php echo ($userInfo['monthUserFocus']); ?> (<?php echo (round($userInfo['monthUserFocus']/$userInfo['monthUser']*100,0)); ?>%)</b></p>
												<p>已付费：<b style="color: #8a6d3b"><?php echo ($userInfo['monthUserPay']); ?> (<?php echo (round($userInfo['monthUserPay']/$userInfo['monthUserFocus']*100,0)); ?>%)</b></p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="info-box" style="height:128px">
									<?php if($is_mobile == 0): ?><span class="info-box-icon bg-red" style="width:128px;height:128px;line-height:128px;text-aligh:center;">
											<i class="fa fa-users"></i>
										</span>
										<div class="info-box-content" style="margin-left:128px;">
									<?php else: ?>
										<div class="info-box-content" style="margin-left:0px;"><?php endif; ?>
										<span class="info-box-text">累计用户(不含当日)</span>
										<span class="info-box-number"><?php echo ($userInfo['sumUser']); ?></span>
										<div style="margin-top: 7px;">
											<p>
												<b style="color: #8a6d3b"><?php echo ($userInfo['sumUserSex1']); ?></b>男性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['sumUserSex2']); ?></b>女性，
												<b style="color: #8a6d3b"><?php echo ($userInfo['sumUserSex0']); ?></b>未知</p>
											<div style="line-height: 10px;">
												<p>已关注：<b style="color: #8a6d3b"><?php echo ($userInfo['sumUserFocus']); ?> (<?php echo (round($userInfo['sumUserFocus']/$userInfo['sumUser']*100,0)); ?>%)</b></p>
												<p>已付费：<b style="color: #8a6d3b"><?php echo ($userInfo['sumUserPay']); ?> (<?php echo (round($userInfo['sumUserPay']/$userInfo['sumUserFocus']*100,0)); ?>%)</b></p>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div><?php endif; ?>
				</div>
			</div>
		</div>



<div class="row">

	<!--<div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="fa fa-flag-o"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">渠道数量</span>
                <span class="info-box-number">
                    <?php echo ($count["channel"]); ?>
                </span>
            </div>
        </div>
    </div>-->


</div>

<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-body">
				<div class="box-content">
					<h3 class="text-center">
						<b>『<?php echo date('Y-m-d',$affInfo['addtime']);?>』<?php echo ($affInfo["title"]); ?></b>
					</h3>
					<div style="font-size:18px;width:90%;margin-left: 4%;margin-bottom: 30px;padding: 10px;" class="text-left">
						<?php echo ($affInfo["content"]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-list"></i>
						公告列表
						<a href="<?php echo U('Channel/channelAffiche');?>"  class="pull-right" style="font-size: 14px;color: #3C8DBC" >
							更多公告信息
						</a>
					</h3>
				</div>

				<div class="panel-body">
					<?php if(empty($affList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
						<?php else: ?>
						<form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tbody>
									<?php if(is_array($affList)): $i = 0; $__LIST__ = $affList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="">
											<td class="text-left">
												<a href="javascript:void(0);" onclick="affdetail('<?php echo U('Affiche/affDetail',array('id'=>$list['id']));?>',800,500)">
													<?php echo ($list["title"]); ?>
												</a>
											</td>
											<td class="text-right"><?php echo date('Y-m-d H:i:s',$list['addtime']);?></td>
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
	</div>
</div>




</section>
</div>
<script>
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
</script>
</body>
</html>