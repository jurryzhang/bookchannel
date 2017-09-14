<?php if (!defined('THINK_PATH')) exit(); if(empty($loglist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
    <?php else: ?>
    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td class="text-center">
                        <a href="javascript:sort('uid');">用户ID</a>
                    </td>

                    <!--<td class="text-center">
                        <a href="javascript:sort('uname');">用户名</a>
                    </td>-->

                    <td class="text-center">
                        用户昵称
                    </td>
					
					<td class="text-center">
                        注册时间
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('accesstime');">最近登录时间</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('ip');">最近登录ip</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('channelid');">渠道名称</a>
                    </td>

                    <td class="text-center">
                        <a href="javascript:sort('channelname');">渠道类型</a>
                    </td>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($loglist)): $i = 0; $__LIST__ = $loglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($i % 2 );++$i;?><tr>
                        <td class="text-center">
                            <?php echo ($log["uid"]); ?>
                        </td>

                        <!--<td class="text-center">
                            <?php echo ($log["uname"]); ?>
                        </td>-->

                        <td class="text-center">
                            <?php echo ($log["name"]); ?>
                        </td>
						
						 <td class="text-center">
                            <?php echo (date("Y-m-d H:i",$log["regdate"])); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($log["lastlogin"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($log["ip"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($log["channelname"]); ?>
                        </td>

                        <td class="text-center">
                            <?php echo ($log["channeltype"]); ?>
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
                url     : "/index.php?m=Admin&c=User&a=delUser&id="+id,
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