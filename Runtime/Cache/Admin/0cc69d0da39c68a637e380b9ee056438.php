<?php if (!defined('THINK_PATH')) exit(); if(empty($chapterlist)): ?><p class="goods_title">抱歉暂时没有相关结果！</p>
<?php else: ?>
<form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center">
                    章节ID
                </td>

                <td class="text-center">
                    章节名称
                </td>

                <td class="text-center">
                    章节价格(<?php echo ($egold_name); ?>)
                </td>

                <td class="text-center">
                    销售个数
                </td>

                <td class="text-center">
                    章节收益(<?php echo ($egold_name); ?>)
                </td>

                <td class="text-center">
                    操作
                </td>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($chapterlist)): $i = 0; $__LIST__ = $chapterlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$chapter): $mod = ($i % 2 );++$i;?><tr>
                    <td class="text-center">
                        <?php echo ($chapter["chapterid"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["chaptername"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["saleprice"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["salenum"]); ?>
                    </td>

                    <td class="text-center">
                        <?php echo ($chapter["sumegold"]); ?>
                    </td>

                    <td class="text-center">
                        <a href="<?php echo U('Admin/BookSale/chapterSaleList',array('id' => $chapter['chapterid']));?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="查看详情" target="rightContent">
                            <span>详细销售</span>
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


    // 点击排序
    function sort(field)
    {
        $("input[name='orderby1']").val(field);
        var v = $("input[name='orderby2']").val() == 'desc' ? 'asc' : 'desc';
        $("input[name='orderby2']").val(v);

        ajax_get_table('search-form2',cur_page);
    }
</script>