<?php
/**
 * Created by PhpStorm.
 * User: HIAPAD
 * Date: 2017/5/31
 * Time: 18:00
 */
namespace Admin\Model;
use Think\Model;
use Think\Page;
class AfficheModel extends Model{
    protected $tableName='distribution_affiche';
    protected $_validate=array(
        array('title','require','公告标题不可为空'),
    );
    protected $_auto=array(
        array('addtime',NOW_TIME)
    );
    public function search(){
        /* 分页 */
        $totalRow = $this->count();
        $pageSize=7;
        $page = new Page($totalRow,$pageSize);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['pageShow']= $page->show();

        $data['affList']=$this->order('addtime DESC')->limit($page->firstRow.','.$page->listRows)->select();
        return $data;
    }
}