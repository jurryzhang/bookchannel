<?php if (!defined('THINK_PATH')) exit(); if(empty($chapterlist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    购买时间
                </td>

                <td class="text-center">
                    用户名称
                </td>

                <td class="text-center">
                    购买价格(<?php echo ($egold_name); ?>)
                </td>

                <td class="text-center">
                    购买个数
                </td>

                <td class="text-center">
                    购买渠道
                </td>

                <td class="text-center">
                    渠道类型
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($chapterlist)): $i = 0; $__LIST__ = $chapterlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chapter): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($chapter["buytime"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["name"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["buyprice"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["buynum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["channelname"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["channeltype"]); ?>
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


    // 点击排序
    function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',cur_page);
    }
</script>