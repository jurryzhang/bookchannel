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
    <div class="breadcrumbs" id="breadcrumbs">
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
                        用户查询
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="navbar navbar-default">
                        <form action="" id="search-form2" class="navbar-form form-inline" method="post" onsubmit="return false">
                            <div class="form-group">
                                <label class="control-label" for="input-order-id">关键词</label>
                                <div class="input-group">
                                    <input type="text" name="userid" value="" placeholder="用户ID" id="input-order-id" class="form-control">
                                    <input type="hidden" name="uid"  value="<?php echo ($uid); ?>">
                                </div>
                            </div>

                            <!--edit by dai-->
                            <div class="form-group">
                                <select class="form-control table-right" name="isfollow">
                                    <option value="-1">--请选择--</option>
                                    <option value="1">已关注</option>
                                    <option value="0">未关注</option>
                                </select>
                            </div>
                            <!--end dai-->

                            <!-- <input type="hidden" name="orderby1" value="uid" />
                            <input type="hidden" name="orderby2" value="desc" /> -->

                            <button type="submit" onclick="ajax_get_table('search-form2',1,0)" id="button-filter search-order" class="btn btn-primary">
                                <i class="fa fa-search"></i> 筛选
                            </button>

                        </form>
                    </div>

                    <div id="ajax_return"></div>
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
        uid = $("input[name=uid]").val();
        if(uid.length!=0){
        // ajax 加载商品列表
        //alert(uid)
            ajax_get_table('search-form2',1,uid);
        }
    });

    // ajax 抓取页面 form 为表单id  page 为当前第几页
    function ajax_get_table(form,page,uid)
    {
        cur_page = page;
        
        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=User&a=ajaxUserSearch&userid="+uid+"&page="+page,
                data    : $('#' + form).serialize(),// 你的formid

                success : function(data)
                {
                    //alert(data);
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

    // 点击排序
  /*  function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',cur_page);
    }*/
</script>
</body>
</html>