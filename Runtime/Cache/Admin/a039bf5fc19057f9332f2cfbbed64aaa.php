<?php if (!defined('THINK_PATH')) exit(); if(empty($channelList)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    ID
                </td>

                <td class="text-center">
                    渠道名称
                </td>

                <td class="text-center">
                    充值完成总数
                </td>

                <td class="text-center">
                    充值未完成总数
                </td>

                <td class="text-center">
                    今日充值完成数
                </td>

                <td class="text-center">
                    今日充值未完成数
                </td>
				
				<td class="text-center">
                    今日充值金额
                </td>

                <td class="text-center">
                    引导用户总数
                </td>

                <td class="text-center">
                    关注用户总数
                </td>


                <td class="text-center">
                    今日引导用户数
                </td>

                <td class="text-center">
                    今日关注用户数
                </td>

                <td class="text-center">
                    查看
                </td>

            </tr>
            </thead>
            <tbody>
            <?php if(is_array($channelList)): $i = 0; $__LIST__ = $channelList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($list["channelid"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["channelname"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["paylogsum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["unpaylogsum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["todaypaylogsum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["todayunpaylogsum"]); ?>
                    </td>
					
					<td class="text-center">
                        <?php echo ($list["daysumpay"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["usersum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["followusersum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["todayusersum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($list["todayfollowusersum"]); ?>
                    </td>

                    <td class="text-center">
                        <a href="<?php echo U('Admin/User/channelPayLogListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                            <span>充值记录</span>
                        </a>
                        <a href="<?php echo U('Admin/User/channelUserListByChannleID',array('id' => $list['channelid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                            <span>用户记录</span>
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
</script>