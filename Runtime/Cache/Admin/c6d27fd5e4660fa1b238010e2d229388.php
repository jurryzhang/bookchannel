<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  	<head>
	    <meta charset="UTF-8"/>
	    <link rel="shortcut icon" href="/Public/images/favicon.ico" />
	    <title>免费读书 | <?php echo ($web_name); ?></title>
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- Bootstrap 3.3.4 -->
	    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	    <!-- FontAwesome 4.3.0 -->
	 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	    <!-- Ionicons 2.0.0 --
	    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
	    <!-- Theme style -->
	    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />	    
	    <!-- iCheck -->
	    <!-- <link href="/Public/plugins/iCheck/flat/green.css" rel="stylesheet" type="text/css" />  -->
		<link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" /> 
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->   
	    <!-- jQuery 2.1.4 -->
	    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	    <script src="/Public/js/common.js"></script>
	    <!-- <script src="/Public/js/upgrade.js"></script> --><!-- 升级文件的js，burn修改，不添加升级接口，2016-08-09， -->
		<script src="/Public/js/layer/layer.js"></script><!--弹窗js 参考文档 http://layer.layui.com/--> 
		<script src="/Public/js/jquery-table-color.js"></script>
		<script src="/Public/js/clipboard.min.js"></script>
		<style type="text/css">
	    	#riframe{min-height:inherit !important}
	    </style>
  	</head>
  	
	<!--<body class="skin-green-light sidebar-mini"   style="<?php if($ischannel) echo 'overflow:hidden;';?> margin:0 auto;display:block">-->

	<?php if($_COOKIE['permissions']== 0): ?><body class="skin-blue-light  sidebar-mini"   style="margin:0 auto;display:block">
	<?php else: ?>
		<body class="skin-blue  sidebar-mini"   style="margin:0 auto;display:block"><?php endif; ?>		
			<div class="wrapper">
  			<header class="main-header">
      		    <!-- Logo -->
				<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Channel/index');?>" class="logo" style="background-color: #222d32;color: #fff;">
        			<!-- mini logo for sidebar mini 50x50 pixels -->
        			<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
        			<!-- logo for regular state and mobile devices -->
        			<img src="/Public/images/newLogo.png" width="150" height="60">
      			</a>
				<?php else: ?>
					<a href="/" class="logo" style="background-color: #222d32;color: #fff;">
						<!-- mini logo for sidebar mini 50x50 pixels -->
						<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
						<!-- logo for regular state and mobile devices -->
						<img src="/Public/images/newLogo.png" width="150" height="60">
					</a><?php endif; ?>

      			<!-- Header Navbar: style can be found in header.less -->
      			<nav class="navbar navbar-static-top" role="navigation" style="background-color: #222d32;color: #fff;">
        			<!-- Sidebar toggle button-->

					<?php if($_COOKIE['permissions']== 1): ?><a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
							<span class="sr-only">Toggle navigation</span>
						</a><?php endif; ?>

					<div class="navbar-custom-menu" style="float: left;margin-top: 15px;">
						<ul class="nav navbar-nav">
					<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Doc/booklist');?>" style=" color: #FFFFff;">
							<i class="fa fa-book"></i>
							<b>小说列表</b>
						</a>

						<ul  class="nav navbar-nav" style="margin-left: 100px;margin-top:-35px; position: absolute;">
							<li class="dropdown user user-menu">
								<a href="#"  id="user_name" data-toggle="dropdown">
									<i class="fa fa-list"></i>
									<b >代理管理</b>
								</a>

								<ul class="dropdown-menu" id="user_option" style="display:none;width: 50px;">
									<li class="user-footer" >
										<div class="full-right">
											<a style="width: 100%;" href="<?php echo U('Channel/channelListCombine');?>"  class="btn btn-default ">代理列表</a>
											<?php $str=$_COOKIE['pid']==0?'

											<a style="width: 100%;" href="/Channel/addSchannel.html" class="btn btn-default ">添加代理</a>':''; echo $str; ?>

										</div>
									</li>
								</ul>
							</li>
						</ul>

						
						<ul  class="nav navbar-nav" style="margin-left: 210px;margin-top:-35px; position: absolute;">
							<li class="dropdown pt pt-menu">
								<a href="#"  id="pt_name" data-toggle="dropdown">
									<i class="fa fa-star"></i>
									<b >渠道管理</b>

								</a>

								<ul class="dropdown-menu" id="pt_option" style="display:none;width: 50px;">
									<li class="pt-footer" >
										<div class="full-right">
											<a style="width: 100%;" href="<?php echo U('Channel/ptList');?>"  class="btn btn-default ">渠道列表</a>
											<a style="width: 100%;" href="<?php echo U('Channel/addPt');?>" class="btn btn-default ">添加渠道</a>


										</div>
									</li>
								</ul>
							</li>
						</ul>
						
						
						<ul  class="nav navbar-nav" style="margin-left: 320px;margin-top:-35px; position: absolute;">
							<li class="dropdown money money-menu">
								<a href="#"  id="money_name" data-toggle="dropdown">
									<i class="fa fa-money"></i>
									<b >财务管理</b>
								</a>

								<ul class="dropdown-menu" id="money_option" style="display:none;width: 50px;">
									<li class="money-footer" >
										<div class="full-right">
											<a style="width: 100%;" href="<?php echo U('Channel/channelBankinfo');?>"  class="btn btn-default ">财务信息</a>
											<a style="width: 100%;" href="/Channel/remainMoney/channelid/<?php echo ($_COOKIE['channelid']); ?>/issum/1.html" class="btn btn-default ">结算单</a>

										</div>
									</li>
								</ul>
							</li>
						</ul><?php endif; ?>
					
					<?php if(($_COOKIE['pid']== 0)AND($_COOKIE['permissions']== 0)): ?><ul  class="nav navbar-nav" style="margin-left: 420px;margin-top:-35px; position: absolute;">
							<li class="dropdown wx wx-menu">
								<a href="#"  id="wx_name" data-toggle="dropdown">
									<i class="fa  fa-wechat"></i>
									<b >公众号配置</b>
								</a>

								<ul class="dropdown-menu" id="wx_option" style="display:none;width: 50px;">
									<li class="wx-footer" >
										<div class="full-right">
											<a style="width: 100%;" href="<?php echo U('Channel/wxSet');?>"  class="btn btn-default ">设置公众号</a>
											<a style="width: 100%;" href="<?php echo U('Channel/wxMenu');?>" class="btn btn-default ">生成菜单</a>
											<a style="width: 100%;" href="<?php echo U('Channel/tplList');?>" class="btn btn-default ">模版消息</a>
											<a style="width: 100%;" href="<?php echo U('Channel/keywordList');?>" class="btn btn-default ">关键词回复</a>

										</div>
									</li>
								</ul>
							</li>
						</ul>
						
						<ul  class="nav navbar-nav" style="margin-left: 530px;margin-top:-35px; position: absolute;">
							<li class="dropdown url url-menu">
								<a href="#"  id="url_name" data-toggle="dropdown">
									<i class="fa  fa-link"></i>
									<b >特殊链接</b>
								</a>

								<ul class="dropdown-menu" id="url_option" style="display:none;width: 50px;">
									<li class="url-footer" >
										<div class="full-right">
											<a style="width: 100%;" href="<?php echo U('BookSale/promotionList');?>"  class="btn btn-default ">促销活动</a>
											<a style="width: 100%;" href="<?php echo U('Channel/commonUrl');?>" class="btn btn-default ">常用链接</a>

										</div>
									</li>
								</ul>
							</li>
						</ul><?php endif; ?>



					</div>

	        		<div class="navbar-custom-menu">
	          			<ul class="nav navbar-nav">
	          				<!-- burn修改，2016-08-10，取消升级功能 -->
	          				<!-- <?php if($upgradeMsg[0] != null): ?><li>
	                  				<a href="javascript:void(0);" id="a_upgrade">
	                      				<i class="glyphicon glyphicon-upload"></i>
	                      				<span  style="color:#FF0;"><?php echo ($upgradeMsg["0"]); ?>&nbsp;</span>
	                  				</a>
	               				</li><?php endif; ?> -->

	           				<li>
								<?php if($_COOKIE['permissions']== 0): ?><!-- <a href="<?php echo U('Channel/index');?>" target="_blank">
									<i class="glyphicon glyphicon-home"></i>
									<span>网站前台</span>
								</a> -->
								<?php else: ?>
									<a href="<?php echo ($web_domain_url); ?>" target="_blank">
										<i class="glyphicon glyphicon-home"></i>
										<span>网站前台</span>
									</a><?php endif; ?>
	           				</li>

							<!-- <?php if($_COOKIE['permissions']== 1): ?><li>
									<a target="_blank" onclick="clean()">
										<i class="glyphicon glyphicon glyphicon-refresh"></i>
										<span>清除缓存</span>
									</a>
								</li><?php endif; ?> -->

							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" id="user_nameZ" data-toggle="dropdown">
									<!--  <img src="/Public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
									<i class="glyphicon glyphicon-user"></i>
									<?php if($_COOKIE['permissions']== 1): ?><span class="hidden-xs">欢迎：<?php echo ($admin_info["name"]); ?></span>
										<?php else: ?>
										<span class="hidden-xs">欢迎：<?php echo (cookie('channelname')); ?></span><?php endif; ?>
								</a>
								<ul class="dropdown-menu" id="user_optionZ" style="display:none;width: 192px">
									<li class="user-footer" >
										<div class="pull-right">
											<?php if($_COOKIE['permissions']== 1): ?><a href="javascript:void(0)" data-url="<?php echo U('Index/map');?>" class="btn btn-default btn-flat model-map">网站地图</a><?php endif; ?>
											<a href="<?php echo U('Admin/logout');?>" class="btn btn-default btn-flat">安全退出</a>
										</div>
									</li>
								</ul>
							</li>

								<!-- Control Sidebar Toggle Button -->
							<!-- <?php if($_COOKIE['permissions']== 1): ?><li>
									<a href="#" data-toggle="control-sidebar">
										<i class="fa fa-street-view"></i>换肤
									</a>
								</li><?php endif; ?> -->

	          			</ul>
	        		</div>
	     		</nav>
				
	     		<script>
	     			$(function()
					{
	     				$('#user_name').mouseover(function()
						{
                        $('#user_option').show();
						});
                        $('#user_name').mouseout(function()
                        {
                            $('#user_option').hide();
                        });
                        $('#user_option').mouseover(function()
                        {
                            $('#user_option').show();
                        });
                        $('#user_option').mouseout(function()
                        {
                            $('#user_option').hide();
                        });
						/************************start**************************/
                        $('#user_nameZ').mouseover(function()
                        {
                            $('#user_optionZ').show();
                        });
                        $('#user_nameZ').mouseout(function()
                        {
                            $('#user_optionZ').hide();
                        });
                        $('#user_optionZ').mouseover(function()
                        {
                            $('#user_optionZ').show();
                        });
                        $('#user_optionZ').mouseout(function()
                        {
                            $('#user_optionZ').hide();
                        });
                        /*************************end************************/



                        $('#wx_name').mouseover(function()
                        {
                            $('#wx_option').show();
                        });

                        $('#wx_name').mouseout(function()
                        {
                            $('#wx_option').hide();
                        });

                        $('#wx_option').mouseover(function()
                        {
                            $('#wx_option').show();
                        });

                        $('#wx_option').mouseout(function()
                        {
                            $('#wx_option').hide();
                        });

						
						 $('#pt_name').mouseover(function()
                        {
                            $('#pt_option').show();
                        });

                        $('#pt_name').mouseout(function()
                        {
                            $('#pt_option').hide();
                        });

                        $('#pt_option').mouseover(function()
                        {
                            $('#pt_option').show();
                        });

                        $('#pt_option').mouseout(function()
                        {
                            $('#pt_option').hide();
                        });
                        $('#money_name').mouseover(function()
                        {
                            $('#money_option').show();
                        });

                        $('#money_name').mouseout(function()
                        {
                            $('#money_option').hide();
                        });

                        $('#money_option').mouseover(function()
                        {
                            $('#money_option').show();
                        });

                        $('#money_option').mouseout(function()
                        {
                            $('#money_option').hide();
                        });
						
						
						//特殊链接菜单
                        $('#url_name').mouseover(function()
                        {
                            $('#url_option').show();
                        });

                        $('#url_name').mouseout(function()
                        {
                            $('#url_option').hide();
                        });

                        $('#url_option').mouseover(function()
                        {
                            $('#url_option').show();
                        });

                        $('#url_option').mouseout(function()
                        {
                            $('#url_option').hide();
                        });




	     			})

					function clean()
					{
						var url = "<?php echo U('Index/clean');?>";

                        $.ajax(
						{
							type    : "GET",
							url     : url,
							success : function(data)
							{
								alert(data);
							},
							error   : function(data)
							{
								alert('error -- data = ' + data.responseText);
							}
						});
                    }
	     		</script>
	  		</header><!DOCTYPE html>
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
	</head>
  	<body style="background-color:#ecf0f5;display:block;overflow:auto;margin:0 auto;">
<!--公共js 代码 --><script src="/Public/js/common.js" charset="utf-8"        type="text/javascript"></script><!--公共js end代码 --><link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" /><script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script><script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script><div class="wrapper">    <div class="breadcrumbs" id="breadcrumbs">
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
    <section class="content">        <!-- Main content -->        <div class="container-fluid">            <div class="pull-right">                <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                   class="btn btn-default" data-original-title="返回"> <i                        class="fa fa-reply"> </i>                </a>            </div>            <div class="panel panel-default">                <div class="panel-heading">                    <h3 class="panel-title">                        <i class="fa fa-list"> </i>                            添加推广渠道                    </h3>                </div>                <div class="panel-body">                    <!--表单数据-->                    <form method="post" id="addSChannel">                        <!--通用信息-->                        <div class="tab-content">                            <div class="tab-pane active" id="tab_tongyong">                                <table class="table table-bordered">                                    <tbody>                                    <tr>                                        <td class="text-center">                                            渠道名称:                                        </td>                                        <td>                                            <input type="text" value="" name="ptname" id='ptname' placeholder="请填写渠道名称" class="form-control" style="width: 350px; display: inline-block" />                                            <span id="err_ptname" style="color: #F00;">                                                </span>                                        </td>                                    </tr>                                    <!-- <tr>                                        <td class="text-center">                                            渠道号码:                                        </td>                                        <td>                                            <input type="text" value="" name="ptnum" id='ptnum' placeholder="请填写渠道号,如mianfeidushu" class="form-control" style="width: 350px; display: inline-block" />                                        </td>                                    </tr> -->                                        <tr>                                            <td class="text-center">                                                渠道成本:                                            </td>                                            <td>                                                <input type="text" value="" name="ptcost" id='ptcost' placeholder="请填写渠道成本:数字" class="form-control" style="width: 350px; display: inline-block" />                                                <span id="err_ptcost" style="color: #F00;">                                                </span>                                            </td>                                        </tr>                                    <tr>                                        <td class="text-center">                                            渠道简介：                                        </td>                                        <td>                                            <textarea rows="6" cols="52" name="ptdesc" id='ptdesc' placeholder="填写渠道简介或者渠道备注信息" id='proportion' class="input-sm"></textarea>                                        </td>                                    </tr>                                        <tr>                                            <td class="text-center">                                                微信渠道可阅读章节数:                                            </td>                                            <td>                                                <input type="text" value="" name="readchaptercount"  id='readchaptercount' class="input-sm" placeholder="请填写10以内的数字"/>                                                <span style="color: #F00;">                                                    不填默认为当前渠道可阅读章节数                                                </span>                                            </td>                                        </tr>                                    <tbody />                                </table>                            </div>                        </div>                        <div class="text-center">                            <button class="btn btn-primary" onclick="saveAction()" title="" data-toggle="tooltip" type="button" data-original-title="保存">                                保存                            </button>                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                               class="btn btn-default" data-original-title="返回"> 取消                            </a>                        </div>                    </form>                    <!--表单数据-->                </div>            </div>        </div>    </section></div><script>    function isPirce(s){        s = $.trim(s);        var p1=/^[0-9](\.\d{1,2})?$/;        return p1.test(s);    }    function saveAction() {        var ptName      = $('#ptname').val();        var ptcost      = $('#ptcost').val();        var proportion      = $('#proportion').val();            if (check_text_isNULL(ptName)) {                $('#err_ptname').text('平台名称不能为空!');            } else  {                if(isNaN(ptcost)){                    $('#err_ptcost').text('成本为数字!');                }else{                     $('#addSChannel').submit();                }        }    }</script></body></html>