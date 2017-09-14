<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/4/20 0020
 * Time: 下午 1:15
 */
namespace Admin\Model;
use Think\Model;
class PicModel extends Model
{
    protected $tableName='distribution_pic';

    public function search($pageSize = 15)
    {
        /**************************************** 搜索 ****************************************/
        $where = array();

        if((I('channel',0)&&I('channel',0)!='')){
            $where['channel']=I('channel');
            $parameter=array('channel'=>I('channel',0));
        }else{
            unset($where['channel']);
            unset($parameter);
        }


        /************************************* 翻页 ****************************************/
        $count = $this->alias('a')->where($where)->count();
        $page = new \Think\Page($count, $pageSize,$parameter);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /************************************** 取数据 ******************************************/
        $data['data'] = $this->field('a.*')
            ->alias('a')
            ->where($where)
            ->group('a.id')
            ->limit($page->firstRow.','.$page->listRows)->select();
        $data['channel']=I('channel',0);
        if($data['channel']==''){
            $data['channel']='全部';
        }
        return $data;
    }

    public function _before_delete($option)
    {
        //删除之前先删除文件
        $id=I('id',0);
        $data=$this->field('pic')->find($id);
        unlink('.'.$data['pic']);

    }

    public function getRandPic($channel)
    {
        if($channel=='男频'||$channel=='女频'){
           $where= "channel='{$channel}' or channel= '通用'";
        }else{
            $where= array('channel'=>'通用');
        }
        $data= $this->field('pic')
                    ->where($where)
                    ->order('rand()')
                    ->limit(1)
                    ->select();
        return $data[0]['pic'];
    }
}