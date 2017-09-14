<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
<!--公共js 代码 --><script src="/Public/js/common.js" charset="utf-8"        type="text/javascript"></script><!--公共js end代码 --><link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" /><script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script><script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script><div class="wrapper">        <section class="content">        <!-- Main content -->        <div class="container-fluid">                        <div class="panel panel-default">                <div class="panel-heading">                    <h3 class="panel-title">                        <i class="fa fa-list"> </i>                        <?php if($action == 'add'): ?>增加渠道财务信息                        <?php else: ?>                            编辑渠道财务信息<?php endif; ?>                    </h3>                </div>                <div class="panel-body">				<?php if($_COOKIE['permissions']== 0): ?><div class="navbar navbar-default">                        <label style="color: red;margin-top: 10px;font-size: 18px;" class="control-label" for="input-order-id">注意:渠道用户为了安全起见,银行卡信息只能填写一次,如需修改请找渠道管理员修改! 管理员QQ:2110610023</label>                     </div><?php endif; ?>                    <!--表单数据-->                    <form method="post" id="bankinfo" action="" >                        <!--通用信息-->                        <input type="hidden" name="cid" value="<?php echo ($cid); ?>">                        <div class="tab-content">                            <div class="tab-pane active" id="tab_tongyong">                                <table class="table table-bordered">                                    <tbody>                                        <tr>                                            <td class="text-right" style="width: 160px;">                                                账户名(登录用):                                            </td>                                            <td>                                                <?php echo ($channel["uname"]); ?>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-right">                                                <em style="color: red">*(必填)</em>  联系人：                                            </td>                                            <td>                                                <input type="text" placeholder="请填写联系人" value="<?php echo ($channel["pname"]); ?>" name="pname"  id='pname' class="input-sm" />                                                <span id="err_panme"                                                      style="color: #F00; ">                                                </span>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-right">                                                <em style="color: red">*(必填)</em>  联系电话:                                            </td>                                            <td>                                                                                                   <input type="text" name="tel" value="<?php echo ($channel["tel"]); ?>" placeholder="固定电话或手机"  id="tel" class="input-sm" >                                                                                               <span id="err_tel" style="color: #F00; ">                                                </span>                                            </td>                                        </tr>                                        <?php if($action != 'add'): ?><tr>                                            <td class="text-right">                                                <em style="color: red">*(必填)</em>   开户行:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($channel["bank"]); ?>"  <?php if((($_COOKIE['permissions']== 0)AND($_COOKIE['cpid']> 0))OR($_COOKIE['uid']== $userinfo['uid'])): ?>readonly="readonly"<?php endif; ?> name="bank"  id='bank' style="width: 270px; display: inline-block"  class="form-control"   placeholder="银行名称或支付宝"/>                                                <span id="err_bank" style="color: #F00;">                                                    </span>                                            </td>                                        </tr>                                            <tr>                                                <td class="text-right">                                                    <em style="color: red">*(必填)</em>  银行账户名:                                                </td>                                                <td>                                                    <input type="text" name="bankname" id="bankname"  <?php if((($_COOKIE['permissions']== 0)AND($_COOKIE['cpid']> 0))OR($_COOKIE['uid']== $userinfo['uid'])): ?>readonly="readonly"<?php endif; ?> value="<?php echo ($channel["bankname"]); ?>"  placeholder="银行的账户名或者支付宝真实姓名" class="form-control" style="width: 270px; display: inline-block" >                                                    <span id="err_bankname" style="color: #F00; ">                                                    </span>                                                </td>                                            </tr>                                            <tr>                                                <td class="text-right">                                                    <em style="color: red">*(必填)</em>  银行卡号:                                                </td>                                                <td>                                                    <input type="text" id="banknum" name="banknum" <?php if((($_COOKIE['permissions']== 0)AND($_COOKIE['cpid']> 0))OR($_COOKIE['uid']== $userinfo['uid'])): ?>readonly="readonly"<?php endif; ?>  value="<?php echo ($channel["banknum"]); ?>"   placeholder="请填写银行卡号或者支付宝帐号" class="form-control" style="width: 270px; display: inline-block" >                                                    <span id="err_banknum" style="color: #F00; ">                                                    </span>                                                </td>                                            </tr>                                            <?php else: ?>                                            <tr>                                                <td class="text-right">                                                    <em style="color: red">*(必填)</em>   开户行:                                                </td>                                                <td>                                                   <input type="text" value=""  style="width:270px; display: inline-block" name="bank"  id='bank' class="form-control"   placeholder="银行名称或支付宝"/>                                                    <span id="err_bank" style="color: #F00; ">                                                    </span>                                                 </td>                                            </tr>                                            <tr>                                                <td class="text-right">                                                    <em style="color: red">*(必填)</em>  银行账户名:                                                </td>                                                <td>                                                    <input type="text" id="bankname" placeholder="银行的账户名或者支付宝真实姓名" class="form-control" style="width: 270px; display: inline-block" name="bankname" >                                                    <span id="err_bankname" style="color: #F00; ">                                                    </span>                                                </td>                                            </tr>                                            <tr>                                                <td class="text-right">                                                    <em style="color: red">*(必填)</em>  银行卡号:                                                </td>                                                <td>                                                    <input type="text" id="banknum" placeholder="请填写银行卡号或者支付宝帐号" class="form-control" style="width: 270px; display: inline-block" name="banknum" >                                                    <span id="err_banknum" style="color: #F00; ">                                                    </span>                                                </td>                                            </tr><?php endif; ?>                                            <tr>                                                <td class="text-right">                                                   支行信息:                                                </td>                                                <td>                                                    <input type="text" name="bankaddr" value="<?php echo ($channel["bankaddr"]); ?>" placeholder="请填写支行信息方便转账,如果是支付宝可以不填" class="form-control" style="width: 270px; display: inline-block"  >                                                </td>                                            </tr>                                            <tr>                                                <td class="text-right">                                                    联系地址:                                                </td>                                                <td>                                                    <input type="text" name="addr" value="<?php echo ($channel["addr"]); ?>"  placeholder="请填写您最新的联系地址方" class="form-control" style="width: 270px; display: inline-block"  >                                                </td>                                            </tr>                                    <tbody />                                </table>                            </div>                        </div>                        <div class="text-center">                            <input type="hidden" name="infoid" value="<?php echo ($channel["infoid"]); ?>">                            <input type="hidden" name="uid" value="<?php echo ($channel["userid"]); ?>">                            <input type="hidden" name="action" value="<?php echo ($action); ?>">                            <button class="btn btn-primary" onclick="saveAction()" title="" data-toggle="tooltip" type="button" data-original-title="保存">                                <?php if($action == 'add'): ?>提交                                 <?php else: ?>                                    保存<?php endif; ?>                            </button>                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                               class="btn btn-default" data-original-title="返回"> 取消                            </a>                        </div>                    </form>                    <!--表单数据-->                </div>            </div>        </div>    </section></div><script>    function saveAction() {        var pname      = $('#pname').val();        var tel       = $('#tel').val();        var bank = $('#bank').val();        var bankname = $('#bankname').val();        var banknum = $('#banknum').val();        var status=1;        if (check_text_isNULL(pname)) {            $('#err_panme').text('联系人不能为空');            status=0;        }        if (check_text_isNULL(tel)) {            $('#err_tel').text('联系电话不能为空');            status=0;        }else{        }        if (check_text_isNULL(bank)) {            $('#err_bank').text('开户行不能为空');            status=0;        }        if (check_text_isNULL(bankname)) {            $('#err_bankname').text('银行账户名不能为空');            status=0;        }        if (check_text_isNULL(banknum)) {            $('#err_banknum').text('银行帐号不能为空');            status=0;        }        if(status==1){            layer.confirm('如果您是<strong style="color:red;">渠道用户</strong>,为了安全起见,<br/> <strong style="color:red;">银行卡信息只能填写一次,</strong>如需修改<br/>请找渠道管理员修改,确定保存?',function(index) {                $.ajax({                    type: 'POST',                    url: '/index.php?s=/Channel/channelBankinfo',                    data: $("#bankinfo").serialize(),                    success: function (data) {                        if (data.status == 1) {                            layer.msg(data.info, {icon: 1, time: 1500}, function () {                                location.reload();                            });                        } else {                            layer.msg(data.info, {icon: 5, time: 3000});                        }                    }                });            });        }    }</script></body></html>