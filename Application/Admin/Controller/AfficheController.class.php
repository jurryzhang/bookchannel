<?php
/**
 * Created by PhpStorm.
 * User: HIAPAD
 * Date: 2017/5/31
 * Time: 17:09
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class AfficheController extends Controller{
    protected $tableName='distribution_affiche';
    public function affList(){
        $affiche=D('Affiche');
        //搜索关键字
        $keyword=I('keyword');
        if($keyword){
            $condition['content']=array('LIKE','%'.$keyword.'%');
        }
        $parameter=array('keyword'=>$keyword);
        /* 分页 */
        $totalRow = $affiche->count();
        $pageSize=12;

        $page = new Page($totalRow,$pageSize,$parameter);
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $pageShow= $page->show();

        $affList=$affiche->order('addtime DESC')
            ->where($condition)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        //dump($affList);exit();
        $this->assign('page',$pageShow);
        $this->assign('keyword',$keyword);
        $this->assign('affList',$affList);
        $this->display();
    }
    //添加公告
    public function affAdd(){
        $affiche=D('Affiche');
        if(IS_POST){
            if(!$affiche->create()){
                $this->error($affiche->getError());
            }else{
                $insertId=$affiche->add();
                if($insertId){
                    $this->success('添加成功',U('affList'));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $this->display();
        }

    }
    public function affDel(){
        $affiche=D('Affiche');
        if(IS_AJAX){
            $id=I('get.id',0,'intval');
            $res=$affiche->where(array('id'=>$id))->delete();
            if($res){
                $this->ajaxReturn(array('status'=>1,'msg'=>'删除成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'删除失败'));
            }
        }

    }
    /*public function affDel(){
        $affiche=D('Affiche');
        $id=I('get.id',0,'intval');
        $res=$affiche->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功',U('affList'));
        }else{
            $this->error('删除失败');
        }
    }*/
    /**
     * 修改公告
     */
    public function affModify(){
        $affiche=D('Affiche');
        $id=I('get.id',0,'intval');
        if(IS_POST){
            $res=$affiche->where(array('id'=>$id))->save(I('post.'));
            if($res!==false){
                $this->success('修改成功',U('affList'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $affInfo=$affiche->where(array('id'=>$id))->find();
            $this->assign('affInfo',$affInfo);
            $this->display();
        }
    }
    public function affDetail(){
        $affiche=D('Affiche');
        $detailId=I('id');
        $affInfo=$affiche->find($detailId);
        $this->assign('affInfo',$affInfo);
        $this->display();
    }
}