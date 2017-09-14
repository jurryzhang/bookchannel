<?php if (!defined('THINK_PATH')) exit(); if(empty($payloglist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    <!-- <a href="javascript:sort('buytime');">充值时间</a> -->
					充值时间
                </td>

                <td class="text-center">
                    用户名(ID)
                </td>

                <td class="text-center">
                    <!-- <a href="javascript:sort('money');">充值金额(元)</a> -->
					充值金额(元)
                </td>
				
				<td class="text-center">
                    <!-- <a href="javascript:sort('balance');">余额(小说币)</a> -->
					余额(小说币)
                </td>

                <!-- <td class="text-center">
                    <a href="javascript:sort('egold');">充值数量(<?php echo ($egold_name); ?>)</a>
                </td> -->

                <td class="text-center">
                   <!-- <a href="javascript:sort('paytype');">充值方式</a> -->
				   充值方式
                </td>

                <td class="text-center">
                    <!-- <a href="javascript:sort('payflag');">充值状态</a> -->
					充值状态
                </td>
				
				<td class="text-center">
                    <!-- <a href="javascript:sort('payflag');">渠道名称</a> -->
					渠道账户名
                </td>
				
				<?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                    操作
                </td><?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($payloglist)): $i = 0; $__LIST__ = $payloglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paylog): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($paylog["buytime"]); ?>
                    </td>

                    <td class="text-center">
                        <?php if(($_COOKIE['cpid']== 0)OR($_COOKIE['permissions']== 1)): ?><a href="/User/userSearch/userid/<?php echo ($paylog['userid']); ?>"><?php echo ($paylog["nickname"]); ?>(<?php echo ($paylog['userid']); ?>)</a>
                        <?php else: ?>
                            <?php echo ($paylog["nickname"]); ?>(<?php echo ($paylog['userid']); ?>)<?php endif; ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($paylog["money"]); ?>
                    </td>
					
					<td class="text-center">
                        <?php echo ($paylog["balance"]); ?>
                    </td>

                    <!-- <td class="text-center">
                       <?php if($paylog["money"] == 365): ?>VIP年费会员
                            <?php else: ?>
                            <?php echo ($paylog["egold"]); endif; ?>
                    </td> -->

                    <td class="text-center">
                        <?php echo ($paylog["paytype"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($paylog["flag"]); ?>
                    </td>
					
					<td class="text-center">
                        <?php echo ($paylog["channeluname"]); ?>
                    </td>
					
					<?php if($_COOKIE['permissions']== 1): ?><td class="text-center">
                        <a href="javascript:void(0);" onclick="del('<?php echo ($paylog['payid']); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除记录">
                            <span>删除记录</span>
                        </a>
                    </td><?php endif; ?>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</form>
<div class="row">
    <div class="col-sm-3 text-left"></div>
    <div class="col-sm-9 text-right"><?php echo ($page); ?></div>
</div><?php endif; ?>
<script>

    // 点击分页触发的事件
    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');

        ajax_get_table('search-form2',cur_page);
    });
    //点击用户跳转到查询结果
    function skipUser(form,uid){

        $.ajax(
            {
                type    : "POST",
                url     : "/index.php?m=Admin&c=User&a=ajaxUserSearch&userid="+uid,
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

        return false;
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
                url     : "/index.php?m=Admin&c=User&a=delPayLog&id="+id,
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
</script>