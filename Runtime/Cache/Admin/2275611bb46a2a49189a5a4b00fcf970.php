<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
	    <meta charset="UTF-8">
	    <link rel="shortcut icon" href="/Public/images/favicon.ico" />
	    <title>快阅云|<?php echo ($web_name); ?></title>
	    <!-- Tell the browser to be responsive to screen width -->
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <!-- Bootstrap 3.3.4 -->
	    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	    <!-- Theme style -->
	    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	    <!-- iCheck -->
	    <link href="/Public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	    <style>#img_verify{width: 120px;margin: 0 auto; text-align: center;display: block;}</style>
	    <script>    
		    function detectBrowser()
		    {
			    var browser = navigator.appName
			    
			    if(navigator.userAgent.indexOf("MSIE") > 0)
			    { 
				    var b_version    = navigator.appVersion
					var version      = b_version.split(";");
					var trim_Version = version[1].replace(/[ ]/g,"");
				    
					if ((browser == "Netscape" || browser == "Microsoft Internet Explorer"))
				    {
				    	if(trim_Version == 'MSIE8.0' || trim_Version == 'MSIE7.0' || trim_Version == 'MSIE6.0'){
				    		alert('请使用IE9.0版本以上进行访问');
				    		return;
				    	}
				    }
			    }
		   }
		    
		   detectBrowser();
	   </script>
	</head>
  	
  	<body class="login-page">
		<div class="login-box">
      		<div class="login-logo" style="color: #FFFFff;">
				<!--<b>免费读书 | <?php echo ($web_name); ?></b>-->
				<b>快阅云小说分销平台</b>
      		</div>
      
      		<div class="login-box-body">
        		<p class="login-box-msg">用户登录</p>
        		<!-- burn添加 form标签 2016-07-20 -->
        		<form action="<?php echo U('Admin/Admin/login');?>"  method="post">
	          		<div class="form-group has-feedback">
	            		<input type="text" name="username" id="username" class="form-control" placeholder="账号" />
	            		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	          		</div>

	          		<div class="form-group has-feedback">
	            		<input type="password" name="password" class="form-control" id="password" placeholder="密码" />
	            		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	          		</div>
	          
	          		<!--<div class="form-group has-feedback">
	          			<opinioncontrol realtime="true" opinion_name="verify_code" default="true">
	                		<div class="row" style="padding-right: 65px;">
	                    		<div class="col-xs-8">
	                        		<input style="width: 135px" id="verify_code" type="text" name="verify" class="form-control" placeholder="验证码"/>
	                    		</div>
	                    
	                    		<div class="col-xs-4">
	                     			<img id="img_verify" width="120" height="40"  style="cursor:pointer;" src="<?php echo U('Admin/Admin/vertify');?>"  onclick="fleshVerify(this)" />
	                    		</div>
	                		</div>
						</opinioncontrol>
					</div>-->
	          		
	          		<div class="form-group">
	          	 		<input name="dosubmit" value="立即登录" id="login_btnLogin" class="btn btn-primary btn-block btn-flat" type="submit">
	          		</div>

					<!--
					<a href="<?php echo U('Admin/Admin/register');?>">注册</a>
					&nbsp;&nbsp;&nbsp;
					<a href="<?php echo U('Admin/Admin/forgetPassWord');?>">忘记密码？</a>-->
	      		</div>
	      	</form>

	    	<!-- <div class="margin text-center">
	        	<div class="copyright">
	            	2016-2025 &copy;
					<a target="_blank" href="<?php echo ($web_domain_url); ?>">免费读书</a> | 渠道 v1.0.0
					<br/>
	        	</div>
	    	</div> -->
    	</div><!-- /.login-box -->
    	<!-- jQuery 2.1.4 -->
    	<script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    	<!-- Bootstrap 3.3.2 JS -->
    	<script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    	<!-- iCheck -->
    	<script src="/Public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		<script src="/Public/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
		
    	<script>
			$(function () 
			{
	        	$('input').iCheck(
				{
	          		checkboxClass : 'icheckbox_square-blue',
	          		radioClass    : 'iradio_square-blue',
	          		increaseArea  : '20%' // optional
	        	});
	      	});
			
	      	function fleshVerify()
	      	{
	          	//重载验证码
//                $('#img_verify').attr('src',".<?php echo U('Admin/Admin/vertify');?>&r="  + Math.floor(Math.random() * 100));

                $('#img_verify').attr('src',"<?php echo U('Admin/Admin/vertify');?>");

	      	}
	      
			jQuery.fn.center = function () 
	      	{
				this.css("position", "absolute");
	          	this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
	         	 $(window).scrollTop()) - 30 + "px");
	          	this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
	          	$(window).scrollLeft()) + "px");
	          	return this;
	      	}
		
	      	function checkLogin()
	      	{
	          	var username = $.trim($('#username').val());
	          	var password = $.trim($('#password').val());
	          	//var vertify  = $.trim($('input[name="vertify"]').val());
	          	var vertify  = $.trim($("#verify_code").val());
	          	
	          	if( username == '' || password =='')
	          	{
					showErrorMsg('用户名或密码不能为空',{icon: 2});
	        	  	return;
	          	}
	          
	          	if(vertify =='')
	          	{
	           		showErrorMsg('验证码不能为空',{icon: 2});
	        	  	return;
	          	}
	          
	          	if(vertify.length != 4)
	          	{
	           		showErrorMsg('验证码错误',{icon: 2});
	           	  	fleshVerify();
	        	  	return;
	          	}
	          
	          	$.ajax(
	          	{

					type     : 'post',
					url      : './index.php?m=Admin&c=Admin&a=doLogin&t='+Math.random(),
					data     : {
							   		username : username,
							      	password : password,
							      	vertify  : vertify
						  	   },
					dataType : 'json',
					success  :function(res)
					{
						if(res.status == 1)
						{
							this.location.href = './index.php?m=Admin&c=Admin&a=index';
						}
						else
						{
							showErrorMsg(res.msg,{icon: 2});
							fleshVerify();
						}
					},
				    error : function(XMLHttpRequest, textStatus, errorThrown)
					{
						showErrorMsg('网络失败，请刷新页面后重试',{icon: 2});
						fleshVerify();
					}
	          	})
			}
	      	
	      	function showErrorMsg(name,msg)
		    {
	      		layer.alert(name,msg);
		    }
		</script>
	</body>
</html>