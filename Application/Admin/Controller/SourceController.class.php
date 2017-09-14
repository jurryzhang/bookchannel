<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/4/20 0020
 * Time: 上午 10:31
 * 文案资源控制器
 */
namespace Admin\Controller;
use Think\AjaxPage;

class SourceController extends BaseController
{
    //图片列表
    public function picList()
    {
        $picModel=D('Pic');
        $data=$picModel->search(15);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();

    }
    //图片添加
    public function picAdd()
    {
		
        $picModel=D('Pic');
        if(IS_POST){			
            //处理上传图片
            $ic = C('IMAGE_CONFIG');
            $upload = new \Think\Upload(array(
                'rootPath' => $ic['rootPath'],
                'maxSize' => $ic['maxSize'],
                'exts' => $ic['exts'],
            ));// 实例化上传类
            $upload->savePath =  'Pic/';
            $info   =   $upload->upload();
            if(!$info){
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "'.$upload->getError().'"}, "id" : "id"}');
            }else{
                $data['channel']=I('channel',0);
                $data['pic']=$info['file']['urlpath'];
                if($picModel->add($data)){
                    $this->success('添加图片成功');
                }else{
                    $this->error($picModel->getError());
                }

            }

        }
        $this->display();
    }
    //图片修改
    public function picEdit()
    {

    }
    //图片删除
    public function picDel()
    {
        $picModel=D('Pic');
        $id=I('id',0);
        if($picModel->delete($id)!==false){
            $this->success('删除图片成功');
        }else{
            $this->error($picModel->getError());
        }

    }
    /**
     *移除下架书籍章节及内容
     */
    public function removeOffShelfBook()
    {
        header('content-type:text/html;charset=utf-8');
        $articleIds=M('article_article')->field('articleid')->select();
        foreach ($articleIds as $k=>$v) {
            $articleidArr[$k]=$v['articleid'];
        }
        $chapterIds=M('obook_ochapter')
            ->field('ochapterid')
            ->where(array('articleid'=>array('NOT IN',$articleidArr)))
            ->select();
        foreach ($chapterIds as $kC=>$vC) {
            $chapteridArr[$kC]=$vC['chapterid'];
        }
        if(!empty($chapteridArr)){
            /*删除章节内容 jieqi_obook_ocontent*/
            $oContent=M('obook_ocontent')
                ->where(array('ochapterid'=>array('IN',$chapteridArr)))
                ->delete();
            if($oContent!==false){
                echo "jieqi_obook_ocontent ".var_dump($oContent)." 下架书籍章节内容已清理<br/>";
            }else{
                echo "jieqi_obook_ocontent ".var_dump($oContent)." 已无章节内容可清理<br/>";
            }
            /*删除章节 jieqi_obook_ochapter*/
            $oChapter=M('obook_ochapter')
                ->where(array('ochapterid'=>array('IN',$chapteridArr)))
                ->delete();
            if($oChapter!==false){
                echo "jieqi_obook_ochapter ".var_dump($oChapter)." 下架书籍章节已清理<br/>";
            }else{
                echo "jieqi_obook_ochapter ".var_dump($oChapter)." 已无章节可清理<br/>";
            }
        }else{
            echo "jieqi_obook_ocontent 已无章节内容可清理<br/>";
            echo "jieqi_obook_ochapter 已无章节可清理<br/>";
        }

        /*删除书籍 jieqi_obook_obook*/
        $obook=M('obook_obook')
            ->where(array('articleid'=>array('NOT IN',$articleidArr)))
            ->delete();
        if($obook!==false){
            echo "jieqi_obook_obook ".var_dump($obook)." 下架书籍已清理<br/>";
        }else{
            echo "jieqi_obook_obook 已无书籍可清理<br/>";
        }

    }
    //内容模板添加
    public function contAdd()
    {
        $contModel=D('Cont');
        if(IS_POST){            
            //处理上传图片
            $ic = C('IMAGE_CONFIG');
            $upload = new \Think\Upload(array(
                'rootPath' => $ic['rootPath'],
                'maxSize' => $ic['maxSize'],
                'exts' => $ic['exts'],
            ));// 实例化上传类
            $upload->savePath =  'Cont/Pic/';
            $info   =   $upload->upload();

            if(!$info){
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "'.$upload->getError().'"}, "id" : "id"}');
            }else{
                $data['channel']=I('channel',0);
                $data['pic']=$info[0]['urlpath'];
                $data['style'] = I('style','');
                $data['status'] = 1;
                
                if($contModel->add($data)){
                    $this->success('添加样式成功');
                }else{
                    $this->error($contModel->getError());
                }

            }

        }
        $this->display();
    }

//正文模板列表
    public function contList()
    {
        $contModel=D('Cont');
        $data=$contModel->search(15);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();
    }

//正文模板删除
    public function contDel()
    {
        $contModel=D('Cont');
        $id=I('id',0);
        if($contModel->delete($id)!==false){
            $this->success('删除模板成功');
        }else{
            $this->error($contModel->getError());
        }

    }

    //引导模板添加
    public function foucsAdd()
    {
        $foucsModel=D('Foucs');
        if(IS_POST){            
            //处理上传图片
            $ic = C('IMAGE_CONFIG');
            $upload = new \Think\Upload(array(
                'rootPath' => $ic['rootPath'],
                'maxSize' => $ic['maxSize'],
                'exts' => $ic['exts'],
            ));// 实例化上传类
            $upload->savePath =  'Foucs/Pic/';
            $info   =   $upload->upload();

            if(!$info){
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "'.$upload->getError().'"}, "id" : "id"}');
            }else{
                $data['channel']=I('channel',0);
                $data['pic']=$info[0]['urlpath'];
                $data['style'] = I('style','');
                $data['status'] = 1;
                
                if($foucsModel->add($data)){
                    $this->success('添加样式成功');
                }else{
                    $this->error($foucsModel->getError());
                }

            }

        }
        $this->display();
    }

    //引导模板列表
    public function foucsList()
    {
        $foucsModel=D('Foucs');
        $data=$foucsModel->search(15);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();
    }

//引导模板删除
    public function foucsDel()
    {
        $foucsModel=D('Foucs');
        $id=I('id',0);
        if($foucsModel->delete($id)!==false){
            $this->success('删除模板成功');
        }else{
            $this->error($foucsModel->getError());
        }

    }

    //标题列表
    public function titleList()
    {

        $titleModel=D('Title');

        $data=$titleModel->search(15);
//        echo '<pre>';
//        var_dump($titleModel);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->assign('channel',$data['channel']);
        $this->display();
    }


    //标题添加
    public function titleAdd()
    {
        $titleModel=D('Title');
        if(IS_POST){
           $channel=I('channel',0);
           foreach (I('title',0) as $v){
               $data['channel']=$channel;
               $data['title']=$v;			   
               if(!$titleModel->add($data)){
                   $this->error($titleModel->getError());
               }

           }
            $this->success('添加标题成功',U('titleList'));
            exit;

        }
        $this->display();
    }
    //标题修改
    public function titleEdit()
    {

    }
    //标题删除
    public function titleDel()
    {

        $picModel=M('distribution_title');
        $id=I('id',0);
        if($picModel->delete($id)!==false){
            $this->success('删除标题成功');
        }else{
            $this->error($picModel->getError());
        }
    }


}