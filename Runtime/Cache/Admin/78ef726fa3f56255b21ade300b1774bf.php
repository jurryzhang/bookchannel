<?php if (!defined('THINK_PATH')) exit(); if(empty($payloglist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    <a href="javascript:sort('buytime');">充值时间</a>
                </td>

				 <td class="text-center">
                    用户昵称(ID)
                </td>

                <td class="text-center">
                    <a href="javascript:sort('money');">充值金额(元)</a>
                </td>
				
				<td class="text-center">
                    余额(小说币)
                </td>
                

                <!-- <td class="text-center">
                    <a href="javascript:sort('egold');">充值数量(<?php echo ($egold_name); ?>)</a>
                </td> -->

                <td class="text-center">
                    <a href="javascript:sort('paytype');">充值方式</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('payflag');">充值状态</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('channelid');">充值渠道</a>
                </td>

               <!-- <td class="text-center">
                    <a href="javascript:sort('channeltype');">渠道类型</a>
                </td>-->

                <td class="text-center">
                    操作
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($payloglist)): $i = 0; $__LIST__ = $payloglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paylog): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($paylog["buytime"]); ?>
                    </td>

                    <td class="text-center">
                        <?php if(($_COOKIE['cpid']== 0)OR($_COOKIE['permissions']== 1)): ?><a href="/User/userSearch/userid/<?php echo ($paylog['uid']); ?>"><?php echo ($paylog["nickname"]); ?>(<?php echo ($paylog['uid']); ?>)</a>
                        <?php else: ?>
                            <?php echo ($paylog["nickname"]); ?>(<?php echo ($paylog['uid']); ?>)<?php endif; ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($paylog["money"]); ?>
                    </td>
					
					<td class="text-center">
                        <?php echo ($paylog['balance']); ?>
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
                        <?php echo ($paylog["channelname"]); ?>
                    </td>

                   <!-- <td class="text-center">
                        <?php echo ($paylog["channeltype"]); ?>
                    </td>-->

                    <td class="text-center">
                        <a href="javascript:void(0);" onclick="del('<?php echo ($paylog['payid']); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除记录">
                            <span>删除</span>
                        </a>
						<a href="<?php echo U('Admin/User/channelConsumeListByChannleID',array('uid' => $paylog['buyid'],'channelid'=>$paylog['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                            <span>消费</span>
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
<script>

    // 点击分页触发的事件
    $(".pagination  a").click(function()
    {
        cur_page = $(this).data('p');

        ajax_get_table('search-form2',cur_page);
    });

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