<?php if (!defined('THINK_PATH')) exit(); if(empty($buyinfolist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    <a href="javascript:sort('buytime');">购买时间</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('obookname');">小说名</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('chaptername');">章节名</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('buyprice');">购买价格(<?php echo ($egold_name); ?>)</a>
                </td>

                <td class="text-center">
                    <a href="javascript:sort('buynum');">购买数量</a>
                </td>

                <td class="text-center">
                    渠道名称
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($buyinfolist)): $i = 0; $__LIST__ = $buyinfolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$buyinfo): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($buyinfo["buytime"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($buyinfo["obookname"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($buyinfo["chaptername"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($buyinfo["buyprice"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($buyinfo["buynum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($buyinfo["channelname"]); ?>
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

    // 点击排序
    function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',cur_page);
    }
</script>