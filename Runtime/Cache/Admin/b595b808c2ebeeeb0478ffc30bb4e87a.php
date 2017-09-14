<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
  	<head>
	    <meta charset="UTF-8"/>
	    <link rel="shortcut icon" href="/Public/images/favicon.ico" />
	    <title>快阅云 | <?php echo ($web_name); ?></title>
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
	    <link href="/Public/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
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
  	
	<!--<body class="skin-green-light sidebar-mini"   style="<?php if($ischannel) echo 'overflow:hidden;';?> margin:0 auto;display:block">-->

	
		<body class="skin-blue  sidebar-mini"   style="margin:0 auto;display:block">
		
			<div class="wrapper">
  			<header class="main-header">
      		    <!-- Logo -->
				<?php if($_COOKIE['permissions']== 0): ?><a href="<?php echo U('Index/index');?>" class="logo" style="background-color: #222d32;color: #fff;">
        			<!-- mini logo for sidebar mini 50x50 pixels -->
        			<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
        			<!-- logo for regular state and mobile devices -->
        			<!-- <img src="/Public/images/newLogo.png" width="150" height="60"> -->首页
      			</a>
				<?php else: ?>
					<a href="/" class="logo" style="background-color: #222d32;color: #fff;">
						<!-- mini logo for sidebar mini 50x50 pixels -->
						<span class="logo-mini">
        				<i class="glyphicon glyphicon-home"></i>
        			</span>
						<!-- logo for regular state and mobile devices -->
						<!-- <img src="/Public/images/newLogo.png" width="150" height="60"> -->首页
					</a><?php endif; ?>

      			<!-- Header Navbar: style can be found in header.less -->
      			<nav class="navbar navbar-static-top" role="navigation" style="background-color: #222d32;color: #fff;">
        		

						<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
							<span class="sr-only">Toggle navigation</span>
						</a>
					
	        		<div class="navbar-custom-menu">
	          			<ul class="nav navbar-nav">
	          				

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

							

							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" id="user_nameZ" data-toggle="dropdown">
									<!--  <img src="/Public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
									<i class="glyphicon glyphicon-user"></i>
									<?php if($_COOKIE['permissions']== 1): ?><span class="hidden-xs">欢迎：<?php echo ($admin_info["name"]); ?></span>
										<?php else: ?>
										<span class="hidden-xs">欢迎：<?php echo (cookie('uname')); ?></span><?php endif; ?>
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
	     				/*$('#user_name').mouseover(function()
						{
                        $('#user_option').show();
						});
                        $('#user_name').mouseout(function()
                        {
                            $('#user_option').hide();
                        });*/
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

						
                        /*********广告业务**********/

                        $('#ad_name').mouseover(function()
                        {
                            $('#ad_option').show();
                        });

                        $('#ad_name').mouseout(function()
                        {
                            $('#ad_option').hide();
                        });

                        $('#ad_option').mouseover(function()
                        {
                            $('#ad_option').show();
                        });

                        $('#ad_option').mouseout(function()
                        {
                            $('#ad_option').hide();
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
	  		</header>
<aside class="main-sidebar"   style="overflow:auto;margin:0 auto;display:block;background-color: #222d32;" >
	<section class="sidebar">
        <ul class=" sidebar-menu">
        	<?php if(($_COOKIE['permissions']== 0) ): ?><li onclick="makecss(this)" class="menu_list">
	            	<a href="<?php echo U('Channel/channelAffiche');?>" target='rightContent'>
	              		<i class="fa fa-bullhorn"></i>
	              		<span >公告信息</span>
	              		
	            	</a>

        		</li>
        	<?php elseif($_COOKIE['permissions']== 1): ?>
        		<li onclick="makecss(this)" class="menu_list">
	            	<a href="<?php echo U('Affiche/affList');?>" target='rightContent'>
	              		<i class="fa fa-bullhorn"></i>
	              		<span >公告信息</span>
	              		
	            	</a>

        		</li><?php endif; ?>	
        		<li onclick="makecss(this)" class="menu_list">
	            	<a href="<?php echo U('Index/welcome');?>" target='rightContent'>
	              		<i class="fa fa-bar-chart"></i>
	              		<span >数据统计</span>
	              		
	            	</a>

        		</li>
        		<li onclick="makecss(this)" class="menu_list">
					<a href="<?php echo U('Doc/bookList');?>" target='rightContent'>
	              		<i class="fa fa-book"></i>
	              		<span >小说列表</span>
	              		
	            	</a>

        		</li>
				<?php if(($_COOKIE['permissions']== 0) ): ?><li onclick="makecss(this)" class="menu_list">
						<a href="<?php echo U('Channel/ptList');?>" target='rightContent'>
		              		<i class="fa fa-link"></i>
		              		<span >推广链接</span>
		              		
		            	</a>

        		    </li>
        		    <?php if(($_COOKIE['cpid']== 0) ): ?><li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('Channel/channelListCombine',array('id'=>$_COOKIE['channelid'],'issum'=>1));?>" target='rightContent'>
			              		<i class="fa fa-user-plus"></i>
			              		<span >代理管理</span>
			              		
			            	</a>

		        		</li><?php endif; ?>
	        		<li onclick="makecss(this)" class="menu_list">
						 <a href="<?php echo U('User/channelPayLogListByChannleID',array('id'=>$_COOKIE['channelid'],'issum'=>1));?>" target='rightContent'> 
						
		              		<i class="fa fa-file-excel-o"></i>
		              		<span >订单管理</span>
		              		
		            	</a>
	            	</li>
        		    <?php if(($_COOKIE['cpid']== 0)): ?><li onclick="makecss(this)" class="menu_list">
							<a href="<?php echo U('User/userSearch');?>" target='rightContent'>
			              		<i class="fa fa-search"></i>
			              		<span >用户查询</span>
			              		
			            	</a>

	        		    </li><?php endif; ?>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="Channel/remainMoney/channelid/<?php echo (cookie('channelid')); ?>/issum/1.html" target='rightContent'>
		              		<i class="fa fa-money"></i>
		              		<span >我的结算单</span>
		              		
		            	</a>

        		    </li>
        		    
        		    
        		    	 <?php if(($_COOKIE['channelid']== 119)): ?><li onclick="makecss(this)" class="menu_list">
			            	<a href="Channel/getNextRemainMoney/channelid/<?php echo (cookie('channelid')); ?>/issum/1.html" target='rightContent'>
			              		<i class="fa fa-money"></i>
			              		<span >代理结算单</span>
			              		
			            	</a>

	        		    </li><?php endif; ?> 
	        		    <?php if(($_COOKIE['cpid']== 0)): ?><li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('Channel/tplList');?>" target='rightContent'>
			              		<i class="fa fa-comments-o"></i>
			              		<span >模板消息</span>
			              		
			            	</a>

	        		    </li>
	        		    <li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('Channel/keywordList');?>" target='rightContent'>
			              		<i class="fa fa-reply"></i>
			              		<span >关键词回复</span>
			              		
			            	</a>

	        		    </li>
	        		    <li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('BookSale/promotionList');?>" target='rightContent'>
			              		<i class="fa fa-shopping-cart"></i>
			              		<span >促销活动</span>
			              		
			            	</a>

	        		    </li><?php endif; ?>
        		    <li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('Channel/commonUrl');?>" target='rightContent'>
			              		<i class="fa fa-paperclip"></i>
			              		<span >常用链接</span>
			              		
			            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Channel/channelBankinfo');?>" target='rightContent'>
		              		<i class="fa fa-credit-card"></i>
		              		<span >收款信息</span>
		              		
		            	</a>

        		    </li>
        		    <?php if($_COOKIE['cpid']> 0): ?><li onclick="makecss(this)" class="menu_list">
			            	<a href="<?php echo U('Admin/lectures');?>" target='rightContent'>
			              		<i class="fa fa-file-pdf-o"></i>
			              		<span >推广教程</span>
			              		
			            	</a>

	        		    </li><?php endif; ?>
	            	
        		    
        		    <?php if(($_COOKIE['cpid']== 0)): ?><li class="treeview" >
							<a href="javascript:void(0)">
			              		<i class="fa fa-briefcase"></i>
			              		<span >网站配置</span>
			              		<i class="fa fa-angle-left pull-right"></i>
			            	</a>

			            	<ul class="treeview-menu">
			            		
			            			<li onclick="makecss(this)" class="menu_list">
			            				<a href="<?php echo U('Channel/wxSet');?>" target='rightContent'>
				            				<i class="fa fa-wechat"></i>公众号配置
			            				</a>
			            			</li>
			            			<li onclick="makecss(this)" class="menu_list">
						            	<a href="<?php echo U('Channel/wxMenu');?>" target='rightContent'>
						              		<i class="fa fa-navicon"></i>
						              		<span >生成菜单</span>
						              		
						            	</a>

				        		    </li>
			            	</ul>
		        		</li><?php endif; ?>
        		   
        		    
        		    <?php if(($_COOKIE['permissions']== 0)): ?><li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('User/editMyPass');?>" target='rightContent'>
		              		<i class="fa fa-pencil-square-o"></i>
		              		<span >修改密码</span>
		              		
		            	</a>

        		    </li><?php endif; ?>

        		<?php elseif(($_COOKIE['permissions']== 1)): ?>

        			<li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Channel/channelList');?>" target='rightContent'>
		              		<i class="fa fa-sitemap"></i>
		              		<span >渠道列表</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
			            	<a href="Channel/getNextRemainMoney/channelid/<?php echo (cookie('channelid')); ?>/issum/1.html" target='rightContent'>
			              		<i class="fa fa-money"></i>
			              		<span >代理结算单</span>
			              		
			            	</a>

	        		    </li>
        			<!-- <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Channel/channelInfoList');?>" target='rightContent'>
		              		<i class="fa fa-send"></i>
		              		<span >渠道推广信息</span>
		              		
		            	</a>

        		    </li> -->
					<li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('User/channelUserAccessLog');?>" target='rightContent'>
		              		<i class="fa fa-street-view"></i>
		              		<span >渠道用户访问记录</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('BookSale/bookSaleListByChannelID');?>" target='rightContent'>
		              		<i class="fa fa-cny"></i>
		              		<span >渠道销售列表</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('BookSale/bookSaleList');?>" target='rightContent'>
		              		<i class="fa fa-th-list"></i>
		              		<span >书籍销售列表</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('BookSale/promotionList');?>" target='rightContent'>
		              		<i class="fa fa-shopping-cart"></i>
		              		<span >促销活动</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Doc/giftsList');?>" target='rightContent'>
		              		<i class="fa fa-money"></i>
		              		<span >打赏记录</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Doc/urgeList');?>" target='rightContent'>
		              		<i class="fa fa-rss"></i>
		              		<span >催更记录</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Doc/commentList');?>" target='rightContent'>
		              		<i class="fa fa-comment-o"></i>
		              		<span >评论记录</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('User/payLogList');?>" target='rightContent'>
		              		<i class="fa fa-diamond"></i>
		              		<span >充值记录</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('User/userList');?>" target='rightContent'>
		              		<i class="fa fa-users"></i>
		              		<span >用户列表</span>
		              		
		            	</a>

        		    </li>
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('User/userAccessLogList');?>" target='rightContent'>
		              		<i class="fa fa-street-view"></i>
		              		<span >用户访问记录</span>
		              		
		            	</a>

        		    </li>
        		    <li class="treeview" >
        		    	<a href="javascript:void(0)">
		              		<i class="fa fa-folder"></i>
		              		<span >文案模板管理</span>
		              		<i class="fa fa-angle-left pull-right"></i>
	            		</a>
	            		<ul class="treeview-menu">
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/picList');?>" target='rightContent'>
				              		<i class="fa fa-image"></i>
				              		<span >图片列表</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/picAdd');?>" target='rightContent'>
				              		<i class="fa fa-file-image-o"></i>
				              		<span >图片添加</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/titleList');?>" target='rightContent'>
				              		<i class="fa fa-header"></i>
				              		<span >文案标题列表</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/titleAdd');?>" target='rightContent'>
				              		<i class="fa fa-font"></i>
				              		<span >文案标题添加</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/contAdd');?>" target='rightContent'>
				              		<i class="fa fa-text-width"></i>
				              		<span >正文模板添加</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/contList');?>" target='rightContent'>
				              		<i class="fa fa-bold"></i>
				              		<span >正文模板列表</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/foucsList');?>" target='rightContent'>
				              		<i class="fa fa-circle-o"></i>
				              		<span >引导模板列表</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Source/foucsAdd');?>" target='rightContent'>
				              		<i class="fa fa-crop"></i>
				              		<span >引导模板添加</span>
				              		
				            	</a>

		        		    </li>
		        		</ul>    
	        		</li>    
        		    <li onclick="makecss(this)" class="menu_list">
		            	<a href="<?php echo U('Source/removeOffShelfBook');?>" target='rightContent'>
		              		<i class="fa fa-trash-o"></i>
		              		<span >清除下架书籍</span>
		              		
		            	</a>

        		    </li>
        		    <li class="treeview" >
        		    	<a href="javascript:void(0)">
		              		<i class="fa fa-caret-square-o-left"></i>
		              		<span >广告管理</span>
		              		<i class="fa fa-angle-left pull-right"></i>
	            		</a>
	            		<ul class="treeview-menu">
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Ad/adList');?>" target='rightContent'>
				              		<i class="fa fa-list-ul"></i>
				              		<span >广告列表</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Ad/adStats');?>" target='rightContent'>
				              		<i class="fa fa-line-chart"></i>
				              		<span >广告统计</span>
				              		
				            	</a>

		        		    </li>
		        		    <li onclick="makecss(this)" class="menu_list">
				            	<a href="<?php echo U('Ad/adSwitch');?>" target='rightContent'>
				              		<i class="fa fa-toggle-on"></i>
				              		<span >广告权限管理</span>
				              		
				            	</a>

		        		    </li>
		        		</ul>
		        	</li><?php endif; ?>
        		
	      	   
		</ul>
	</section>
</aside>

<div style="-webkit-overflow-scrolling:touch;overflow:auto;">
	<?php if($is_mobile == 1): ?><section class="content-wrapper right-side" id="riframe" style="margin:0px auto;padding:0px;">
	<?php else: ?>
	<section class="content-wrapper right-side" id="riframe" style="margin:0px auto;padding:0px;margin-left:180px;"><?php endif; ?>
		<iframe id='rightContent' name='rightContent' src="<?php echo U('Admin/Index/welcome');?>" width='100%'  height='100%' frameborder="0"></iframe>
	</section>
</div>
			

     		<!-- Control Sidebar -->
     		<!-- <aside class="control-sidebar control-sidebar-dark"> -->
       			<!-- Create the tabs -->
				<!--<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		         	<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-at"></i></a></li>
		         	<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
				</ul>-->
		       
       			<!-- Tab panes -->
       			<!-- <div class="tab-content"> -->
	      			<!-- Home tab content -->
	         		<!-- <div class="tab-pane" id="control-sidebar-home-tab">
	         		</div> --><!-- /.tab-pane -->
	         		<!-- Stats tab content -->
         			<!-- <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div> --><!-- /.tab-pane -->
         			<!-- Settings tab content -->
         			<!-- <div class="tab-pane" id="control-sidebar-settings-tab">
         			</div>
       			</div>
     		</aside>
   			<div class="control-sidebar-bg"></div> -->
		</div>

		<script src="/Public/js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="/Public/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="/Public/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
		<script src="/Public/dist/js/app.js" type="text/javascript"></script>
		<script src="/Public/dist/js/demo.js" type="text/javascript"></script>
 
		<script type="text/javascript">
			$(document).ready(function()
			{
				//$("#riframe").height($(window).height()-100);//浏览器当前窗口可视区域高度
				$("#rightContent").height($(window).height());
				$('.main-sidebar').height($(window).height()-50);
			});

			//var tmpmenu = 1;

			function makecss(obj)
			{
				$(".menu_list").removeClass('active');
				$(obj).addClass('active');
				$('body').removeClass('sidebar-open');
				//tmpmenu = mod_id;
			}

			$('.model-map').click(function()
			{
    			var url = $(this).attr('data-url');
    			
    			layer.open(
    			{
        			type: 2,
        			title: '网站地图',
        			shadeClose: true,
        			shade: 0.8,
        			area: ['70%', '60%'],
        			content: url, 
    			});
			});

			function callUrl(url)
			{
				layer.closeAll('iframe');
				rightContent.location.href = url;
			}
		</script>
	</body>
</html>