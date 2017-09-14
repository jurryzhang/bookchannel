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

<!--公共js 代码 -->
<script src="/Public/js/common.js" charset="utf-8"
        type="text/javascript"></script>
<!--公共js end代码 -->
<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<div class="wrapper">
    
    <section class="content">
        <div class="container-fluid">
           
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i>
                        公告信息
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
                            <div style="text-align: right;float: right; display: inline-table;margin-right: 20px;">
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input type="text" name="keyword" value="<?php echo ($keyword); ?>" placeholder="请输入关键字" id="input-order-id" class="form-control">
                                    </div>
                                </div>
                                <button type="submit" onclick="this.form.submit()" id="button-filter search-order" class="btn btn-primary">
                                    <i class="fa fa-search"></i>搜索
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php if(empty($affList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
                        <?php else: ?>
                        <form method="post" enctype="multipart/form-data" target="_blank" id="form-pic">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        
										<td class="text-center">
                                            
                                        </td>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($affList)): $i = 0; $__LIST__ = $affList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr style="">
										
                                            <td class="text-left" style="padding-left:3em;height:40px;line-height: 40px;font-size:16px;">
                                            <?php echo date('Y-m-d',$list['addtime']);?>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                <a href="javascript:void(0);" onclick="affdetail('<?php echo U('Affiche/affDetail',array('id'=>$list['id']));?>',800,500)">
                                                    <?php echo ($list["title"]); ?>
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
</div>

<script>

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


    function saveAction() {
        var pname      = $('#pname').val();
        var tel       = $('#tel').val();
        var bank = $('#bank').val();
        var bankname = $('#bankname').val();
        var banknum = $('#banknum').val();
        var status=1;



        if (check_text_isNULL(pname)) {
            $('#err_panme').text('联系人不能为空');
            status=0;
        }

        if (check_text_isNULL(tel)) {
            $('#err_tel').text('联系电话不能为空');
            status=0;
        }else{

        }


        if (check_text_isNULL(bank)) {
            $('#err_bank').text('开户行不能为空');
            status=0;
        }

        if (check_text_isNULL(bankname)) {
            $('#err_bankname').text('银行账户名不能为空');
            status=0;
        }

        if (check_text_isNULL(banknum)) {
            $('#err_banknum').text('银行帐号不能为空');
            status=0;
        }

        if(status==1){
            layer.confirm('如果您是<strong style="color:red;">渠道用户</strong>,为了安全起见,<br/> <strong style="color:red;">银行卡信息只能填写一次,</strong>如需修改<br/>请找渠道管理员修改,确定保存?',function(index) {
                $.ajax({
                    type: 'POST',
                    url: '/index.php?s=/Channel/channelBankinfo',
                    data: $("#bankinfo").serialize(),
                    success: function (data) {
                        if (data.status == 1) {
                            layer.msg(data.info, {icon: 1, time: 1500}, function () {
                                parent.rightContent.location.reload();
                            });
                        } else {
                            layer.msg(data.info, {icon: 5, time: 3000});
                        }
                    }
                });
            });


        }



    }
</script>
</body>
</html>