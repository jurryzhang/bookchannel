<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
<!--公共js 代码 --><script src="/Public/js/common.js" charset="utf-8"        type="text/javascript"></script><!--公共js end代码 --><link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" /><script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script><script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script><style>    .fileinput-button {        position: relative;        display: inline-block;        overflow: hidden;    }    .fileinput-button input{        position: absolute;        left: 0px;        top: 0px;        opacity: 0;        -ms-filter: 'alpha(opacity=0.5)';    }</style><div class="wrapper">    <div class="breadcrumbs" id="breadcrumbs">
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
    <section class="content">        <!-- Main content -->        <div class="container-fluid">            <div class="pull-right">                <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                   class="btn btn-default" data-original-title="返回"> <i                        class="fa fa-reply"> </i>                </a>            </div>            <div class="panel panel-default">                <div class="panel-heading">                    <h3 class="panel-title">                        <i class="fa fa-list"> </i>                            微信公众号设置                        <a href="/Channel/wxCourse" target="_blank" style="color:#3c8dbc;margin-left: 10px;cursor: pointer;font-size: 14px;">                            <i class="fa fa-question-circle set1"></i> 教程                        </a>                    </h3>                </div>                <div class="panel-body">                    <!--表单数据-->                    <form method="post" id="addSChannel">                        <!--通用信息-->                        <div class="tab-content">                            <div class="tab-pane active" id="tab_tongyong">                                <h4>公众号信息:</h4>                                <table class="table table-bordered">                                    <tbody>                                        <tr>                                            <td class="text-center">                                                站点名称:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["sitename"]); ?>" name="sitename" id='sitename' placeholder="微信站名称" class="form-control" style="width: 350px; display: inline-block" />                                                <span id="err_goods_name" style="color: #F00; display: inline-block;">                                                </span>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-center">                                                公众号名称：                                            </td>                                            <td>                                                <input type="text" placeholder="公众号名(如:免费读书网)" value="<?php echo ($wxinfo["wxname"]); ?>" name="wxname" style="width: 350px; display: inline-block" id='wxname' class="form-control" />                                                <p style="color: #999;margin-top: 1px;">                                                    将 "微信公众平台->公众号设置->账号详情->名称" 显示信息填入设置                                                </p>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-center">                                                公众号类型:                                            </td>                                            <td>                                                <div class="input-group">                                                    <input type="radio" name="wxtype" value="fuwu" checked="checked" id="wxtype"  > <span style="margin-top: 0px;"> 服务号</span>                                                </div>                                                <span id="err_cat_id" style="color: #F00; display: none;">                                                </span>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-center">                                                微信号:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["wxnum"]); ?>" name="wxnum"  id='wxnum' class="form-control" style="width: 350px; display: inline-block" placeholder="公众号字母加数字(如:mianfeidushuvip)"/>                                                <p style="color: #999;margin-top: 1px;">                                                    将 "微信公众平台->公众号设置->账号详情->微信号" 显示信息填入设置                                                </p>                                            </td>                                        </tr>										<tr>                                            <td class="text-center">                                                客服微信:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["kefu"]); ?>" name="kefu"  id='kefu' class="form-control" style="width: 350px; display: inline-block" placeholder="可选，建议不填"/>                                                <p style="color: #999;margin-top: 1px;">                                                    如果不填, 则由平台客服受理粉丝问题, 建议不填                                                </p>                                            </td>                                        </tr>										                                        <tr>                                            <td class="text-center">                                                引导关注链接URL:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["subscribeurl"]); ?>" name="subscribeurl"  id='subscribeurl' class="form-control" style="width: 350px; display: inline-block" placeholder="引导关注链接地址（选填）"/>                                                <p style="color: #999;">                                                      例如:http://mp.weixin.qq.com/s/zrAybLIOdmH2RRimD-kOSQ                                                </p>                                                <p style="color: #999;margin-top: -10px;">                                                    如果不填，则默认使用公众号的二维码引导关注                                                </p>                                            </td>                                        </tr>                                        <tr>                                            <td class="text-center">                                                AppId:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["appid"]); ?>" name="appid"  id='appid' class="form-control" style="width: 350px; display: inline-block" placeholder="微信公众号基本配置中获得appid"/>                                                <p style="color: #999;margin-top: 1px;">                                                    将 "微信公众平台->基本配置->公众号开发信息->开发者ID" 显示信息填入设置<span style="color: #F00;">                                                    (必填)                                                </span>                                                </p>                                                <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                    <i class="fa fa-question set_appid"></i>                                                </a>                                                <img src="/Public/images/wxset/set_3.png" style="display: none;" class="set_3">                                            </td>                                        </tr>                                        <tr>                                            <td class="text-center">                                                AppSecret:                                            </td>                                            <td>                                                <input type="text" value="<?php echo ($wxinfo["appsecret"]); ?>" name="appsecret"  id='appsecret' class="form-control" style="width: 350px; display: inline-block" placeholder="微信公众号基本配置中获得AppSecret"/>                                                <p style="color: #999;margin-top: 1px;">                                                    将 "微信公众平台->基本配置->公众号开发信息->开发者密码" 显示信息填入设置                                                    <span style="color: #F00;">                                                    (必填)                                                    </span>                                                </p>                                                <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                    <i class="fa fa-question set_appSecret"></i>                                                </a>                                            </td>                                        </tr>                                    <tbody />                                </table>                                <h4>服务器设置--微信后台基本配置:</h4>                                <table class="table table-bordered">                                    <tbody>                                    <tr>                                        <td class="text-center" style="width:23%;">                                            URL(服务器地址):                                        </td>                                        <td>                                            <span> http://wap.kyread.com/wx/index/id/<?php echo ($channelid); ?>.html</span>                                            <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                <i class="fa fa-question set_url"></i>                                            </a>                                            <img src="/Public/images/wxset/set_4.png" style="display: none;" class="set_4">                                            <p style="color: #999;margin-top: 1px;">                                                    将此地址填入 "微信公众平台->基本配置->公众号开发信息->服务器地址"                                             </p>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            Token(令牌):                                        </td>                                        <td>                                            <input type="text" value="<?php echo ($wxinfo["token"]); ?>" name="token"  id='token' readonly="readonly" class="form-control" style="width: 350px; display: inline-block" placeholder="微信公众号服务器配置token"/>                                            <p style="color: #999;margin-top: 1px;">                                                    与 "微信公众平台->基本配置->公众号开发信息->令牌"保持一致                                             </p>                                            <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                <i class="fa fa-question set_token"></i>                                            </a>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            域名校验文件上传:                                        </td>                                        <td>                                            <span class="btn btn-success fileinput-button">                                                  <span>上传文件</span>                                                   <input type="file" id="checkFile" name="checkFile" onchange="upload()">                                              </span>                                            <div id="spic" style=";color:#009933 " >                                                <span style="height:60px;vertical-align: bottom; font-weight: bold; display: none " id="picinfo" >上传成功!</span>                                            </div>                                            <div class="progress progress-xs progress-striped active" id="progress" style="width:250px;display:none">                                                <div class="progress-bar progress-bar-success" id="probar" style="width: 0%"></div>                                            </div>                                            <span class="badge bg-green" style="display: none" id="procount"> 0%</span>                                            <p style="color: #F00;">                                               在 "微信公众平台->公众号设置->功能设置->业务域名"下载验证文件                                                <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                    <i class="fa fa-question set_check"></i>                                                    <img src="/Public/images/wxset/set_5.png" style="display: none;" class="set_5">                                                </a>                                            </p>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            IP白名单:                                        </td>                                        <td>                                            <span><b>47.92.127.55</b></span>                                            <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                <i class="fa fa-question set_IP"></i>                                            </a><br/>                                            <span><b>47.92.84.210</b></span>                                            <br/>                                            <span><b>47.92.81.215</b></span>                                            <br/>                                            <p style="color: #999;margin-top: 1px;">                                                    将这些IP添加到 "微信公众平台->基本配置->公众号开发信息->IP白名单"                                             </p>                                        </td>                                    </tr>                                    <tr>                                        <td class="text-center">                                            微信域名:                                        </td>                                        <td>                                            <span><b>wap.kyread.com</b></span>                                            <a href="javascript:void(0);" style="cursor: pointer;font-size: 16px;">                                                <i class="fa fa-question set_yuming"></i>                                            </a>                                            <img src="/Public/images/wxset/set_2.png" style="display: none;" class="set_2">                                            <p style="color: #999;margin-top: 1px;">                                                    将此域名填入 "微信公众平台->公众号设置->功能设置->网页授权域名" (业务域名、JS接口安全域名、 授权域名一致)                                            </p>                                        </td>                                    </tr>                                    </tbody>                                </table>                                <input type="hidden" name="action" value="<?php echo ($action); ?>">                                <input type="hidden" name="channelid" value="<?php echo ($channelid); ?>">                            </div>                        </div>                        <div class="text-center">                            <button class="btn btn-primary" onclick="saveAction()" title="" data-toggle="tooltip" type="button" data-original-title="保存">                                保存                            </button>                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title=""                               class="btn btn-default" data-original-title="返回"> 取消                            </a>                        </div>                    </form>                    <!--表单数据-->                </div>            </div>        </div>    </section></div><script>    function isPirce(s){        s = $.trim(s);//        var p =/^[1-9](\d+(\.\d{1,2})?)?$/;        var p1=/^([0-9])+$/;        return p1.test(s);    }    function saveAction() {        var channelName      = $('#channelname').val();        var proportion       = $('#cost').val();        $('#err_goods_name').text('');       /*        if (channelName=='') {            if (check_text_isNULL(channelName)) {                $('#err_goods_name').text('渠道名称不能为空!');                layer.alert('渠道名称不能为空');            }        } else  {            if (!isPirce(proportion)) {                layer.alert('成本为数字');            } else {               $('#addSChannel').submit();            }        }*/        $('#addSChannel').submit();    }    /**     * 微信公众号配置     */    function openImg(obj){        layer.open({            type: 1,            skin: 'layui-layer-demo', //样式类名            anim: 2,            shadeClose: true, //开启遮罩关闭            area: ['1000px', '610px'],            content: obj        });    }    $('.set_appid,.set_appSecret,.set_IP').click(function(){        openImg($('.set_3'));    });    $('.set_url,.set_token').click(function(){        openImg($('.set_4'));    });    $('.set_yuming').click(function(){        openImg($('.set_2'));    });    $('.set_check').click(function(){        openImg($('.set_5'));    });    //上传图片    function upload(del){        if(del==1){            $('#uppic').css('display','');        }else {            $('#uppic').css('display','none');        }        var fm = document.getElementById('addSChannel');        //① 收集用户输入的表单域信息[FormData]        var fd = new FormData(fm);//普通表单域 + 上传文件域信息        //② 并把收集的信息提交给服务器端[ajax]        var xhr = new XMLHttpRequest();        xhr.onreadystatechange = function(){            if(xhr.readyState==4){                var str='';                eval('str='+xhr.responseText);                //console.log(str);                if(str.error==1){                    $('#picinfo').css('display','');                    $('#picinfo').css('color','red');                    $('#picinfo').html(str.msg);                }else {                    $('#picinfo').css('display','');                    $('#picinfo').html('上传成功!');                    $('#picinfo').css('color','#009933');                }            }        }        xhr.upload.onprogress = function(evt){            //该事件每间隔100ms左右就执行一次，            //并可以通过事件对象感知附件信息            //附件已经上传大小            var lod = evt.loaded;            //附件总大小            var tal = evt.total;            //上传百分比            if(del==1){                $('#progress').css('display','none');                $('#procount').css('display','none');            }else {                $('#progress').css('display','inline-block');                $('#procount').css('display','inline-block');            }            var per = Math.floor((lod/tal)*100) + "%";            //设置进度条            $('#procount').html(per);            $('#probar').css('width',per);        }        xhr.open('post','/channel/wxCheckUpload/');        xhr.send(fd);    }</script></body></html>