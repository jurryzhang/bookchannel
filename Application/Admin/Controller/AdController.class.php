<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/7/08
 * Time: 下午3:03 *
 * 广告管理
 * ----------------------------------------------------------------------------
 * ============================================================================
 */

namespace Admin\Controller;

use Think\AjaxPage;

class AdController extends BaseController
{
	public function _initialize()
	{
		parent::_initialize();

	}

    /**
     * 广告列表
     */
	public function adList()
	{
        $channelModel=M('distribution_channels');
        $channel=$channelModel->field('adplan')->find(cookie('channelid'));
        $adModel=M('distribution_ad');
        $where=array();
        if(cookie('uid')==1){
            $where['channelid']=0;
        }else{
            $where['channelid']=cookie('channelid');
        }

        /************************************* 翻页 ****************************************/
        $count = $adModel->where($where)->count();
        $page = new \Think\Page($count, 15);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /************************************** 取数据 ******************************************/
        $data['data'] = $adModel->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
       /*echo '<pre>';
        var_dump($data);*/
        $this->assign('page',$data['page']);
        $this->assign('adplan',$channel['adplan']);
        $this->assign('adlist',$data['data']);
		$this->display();
	}

    /**
     * 添加广告
     */
    public function adAdd()
    {
        $adModel=M('distribution_ad');
        if(cookie('uid')==0||cookie('pid'>0)){
            $this->error('您没有权限添加广告');
        }else{
            if(cookie('adpower')==0 &&cookie('uid')>1){
                $this->error('您没有权限添加广告');
            }
        }
        if(IS_POST){
            $_POST['addtime']=time();
            $_POST['display']=1;
            $_POST['starttime']=strtotime( $_POST['starttime']);
            $_POST['endtime']=strtotime( $_POST['endtime']);
            $_POST['channelid']=cookie('channelid')+0;
            if(!file_exists('.'.$_POST['picurl'])){
               $pic= $this->adPicUpload(0);
               $_POST['picurl']=$pic['pic']['urlpath'];
            }
            $res=$adModel->add(I('post.'));
            if($res){
                $this->success('广告添加成功',U('adList'));
                exit;
            }else{
                $this->error('广告添加失败,'.$adModel->getError());
                exit;
            }
        }
        $this->display();
	}

    /**
     * 编辑广告
     */
    public function adEdit()
    {
        $adModel=M('distribution_ad');
        $id=I('id');
        if(cookie('uid')==1){
            $channelid=0;
        }else{
            $channelid=cookie('channelid');
        }

        $ad=$adModel->where(array('channelid'=>$channelid,'id'=>$id))->find();
       //如果不是当前渠道的广告提示无权编辑
        if(!$ad &&cookie('uid')>1){
            $this->error('您没有权限编辑这条广告信息!',U('adlist'));
            exit;
        }

        if(IS_POST){
            $_POST['starttime']=strtotime( $_POST['starttime']);
            $_POST['endtime']=strtotime( $_POST['endtime']);
            $_POST['channelid']=cookie('channelid')+0;
            //先获取广告信息
            $ad=$adModel->where(array('channelid'=>$channelid,'id'=>$id))->find();
            //判断有没有上传
            if(!file_exists('.'.$_POST['picurl'])){
                $pic= $this->adPicUpload(0);
                $_POST['picurl']=$pic['pic']['urlpath'];
            }

            //判断上传图更换删除原有图片
            if( $_POST['picurl']!=$ad['picurl'] &&$_POST['picurl']!=''){
                unlink('.'.$ad['picurl']);
            }

            //如果没有更换图片删除post的图片信息,房子更改空的图片
            if($_POST['picurl']==''){
                unset($_POST['picurl']);
            }

            $res=$adModel->save(I('post.'));
            if($res!==false){
                $this->success('广告修改成功',U('adList'));
                exit;
            }else{
                $this->error('广告修改失败,'.$adModel->getError());
                exit;
            }



        }

        $this->assign('ad',$ad);
        $this->display();
	}

    /**
     * 删除广告
     */
    public function adDel()
    {
        $adModel=M('distribution_ad');
        $id=I('id');
        if(cookie('uid')==1){
            $channelid=0;
        }else{
            $channelid=cookie('channelid');
        }

        $ad=$adModel->where(array('channelid'=>$channelid,'id'=>$id))->find();
        //如果不是当前渠道的广告提示无权编辑
        if(!$ad &&cookie('uid')>1){
            $this->error('您没有权限删除这条广告信息!',U('adlist'));
            exit;
        }

        if($adModel->delete($id)!==false){
            unlink('.'.$ad['picurl']);
			 $adstatsModel=M('distribution_ad_stats');
             $adstatsModel->where(array('adid'=>$id))->delete();
            $this->success('删除广告成功');
        }else{
            $this->error($adModel->getError());
        }
    }

    /**
     * 广告权限设置
     */
    public function adSwitch()
    {
        $channelModel=M('distribution_channels');
        $where['pid']=0;
        /************************************* 翻页 ****************************************/
        $count = $channelModel->where($where)->count();
        $page = new \Think\Page($count, 15);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /************************************** 取数据 ******************************************/
        $data['data'] = $channelModel->field('channelid,channelname,posttime,channeltype,adpower,adplan')->where($where)->order('channelid desc')->limit($page->firstRow.','.$page->listRows)->select();

        $adpath = C('AD_CONFIG');
        include  $adpath;
        $this->assign('sitead',$GLOBALS['sitead']);
        $this->assign('page',$data['page']);
        $this->assign('channellist',$data['data']);
        $this->display();
    }

    /**
     *ajax设置渠道广告权限
     */
    public function setAdpower($switch='')
    {
        $channelModel=M('distribution_channels');
        $id=I('id');
        $status=I('status');
        if(!empty($switch)){
            $status=$switch;
        }
        $data['adpower']=$status=='on'?1:0;
        $res=$channelModel->where('channelid = '.$id)->save($data);
        if($res!==false){
            $this->success('广告权限设置成功!',U('adSwitch'));
        }else{
            $this->error('设置失败!'.$channelModel->getError(),U('adSwitch'));
        }
    }


    /**
     * 广告统计
     */

    public function adStats()
    {

        $adModel=M('distribution_ad');
        $where=array();
        if(cookie('uid')==1){
            $where['channelid']=0;
        }else{
            $where['channelid']=cookie('channelid');
        }

        /************************************* 翻页 ****************************************/
        $count = $adModel->where($where)->count();
        $page = new \Think\Page($count, 15);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /************************************** 取数据 ******************************************/
        $data['data'] = $adModel->where($where)->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
        /*echo '<pre>';
         var_dump($data);*/
        $this->assign('page',$data['page']);
        $this->assign('adlist',$data['data']);
        $this->display();

    }


    /**
     * @param bool $isajax默认是ajax
     * @return array|bool|string 如果是奔控制器调用返回数组复杂json
     * 广告图片上传
     */
    public function adPicUpload($isajax=true)
    {
        $adModel=M('distribution_ad');
        $picpath='.'.I('picurl');
        if($picpath!==''){
            //如果都不是第一次上传删除之前上传的图片
                unlink($picpath);
        }
        //如果是删除动作
        if(!isset($_GET['del'])){
            $ic = C('IMAGE_CONFIG');
            $upload = new \Think\Upload(array(
                'rootPath' => $ic['rootPath'],
                'maxSize' => $ic['maxSize'],
                'exts' => $ic['exts'],
            ));// 实例化上传类
            $upload->savePath =  'Ad/';
            $info   =   $upload->upload();
            if($info){
                if($isajax){
                    $this->ajaxReturn($info);
                }else{
                    return $info;
                }
            }else{
                if($isajax){
                    $this->ajaxReturn(array('error'=>'1','msg'=>$upload->getError()));
                }else{
                    return $upload->getError();
                }
            }
        }else{
            //如果用户离开页面没有设置其他参数删除这张图片
            unlink($picpath);
        }

    }

    /**
     * 全站广告开关设置
     */
    public function siteAd()
    {
        $status=I('status');
        $adpath = C('AD_CONFIG');
        include  $adpath;
        $str='';
        if($status=='on'){
            $str = '<?php ' . PHP_EOL;
            $str .= '$GLOBALS[\'sitead\']= true;';
        }else{
            $str = '<?php ' . PHP_EOL;
            $str .= '$GLOBALS[\'sitead\']= false;';
        }

        if(isset($GLOBALS['sitead'])){
            $putres=file_put_contents($adpath,$str);
            if($putres!=false){
                    $this->success('全站广告设置成功');exit;
                }else{
                    $this->error('写入配置文件失败');exit;
                }

            } else {
            $this->error('广告配置文件未获取到!');exit;
        }


    }

    /**
     * 设置广告计划
     */
    public function setAdplan()
    {
        $channelModel=M('distribution_channels');
        $data['adplan']=I('plan');
        $res=$channelModel->where('channelid = '.cookie('channelid'))->save($data);
        if($res!==false){
            $this->success('设置广告计划成功!');
        }else{
            $this->error('设置失败'.$channelModel->getError());
        }
    }


    /**
     * 设置广告显示与屏蔽
     */

    public function setDisplay()
    {
        $data['id']=I('id');
        $data['display']=I('display')+0;
        $adModel=M('distribution_ad');
        $res=$adModel->save($data);
        if($res!==false){
            $this->success('设置成功');
        }else{
            $this->error('设置失败'.$adModel->getError());
        }


    }

    /**
     * 设置默认广告
     */

    public function setDefault()
    {
        $id=I('id');
        $channelid=I('cid');
        //先全部取消默认
        $adModel=M('distribution_ad');
        $data['isdefault']=0;
        $adModel->where('channelid = '.$channelid)->save($data);
        $data['isdefault']=1;
        $res=$adModel->where('id = '.$id)->save($data);
        if($res!==false){
          header('location:'.U('adList'));
        }else{
            $this->error('设置失败'.$adModel->getError(),U('adList'),0);
        }
    }

    /**
     * 根据广告id显示广告展示详情
     */
    public function adDetailById()
    {
        $adstatsModel=M('distribution_ad_stats');
        $adid=I('id');
        $where=array(
            'adid'=>$adid,
        );

        /************************************* 翻页 ****************************************/
        $count = $adstatsModel->where($where)->count();
        $page = new \Think\Page($count, 15);
        // 配置翻页的样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '尾页');
        $data['page'] = $page->show();
        $data['count']=$page->totalRows;

        /************************************** 取数据 ******************************************/
        $data['data'] = $adstatsModel->field('a.*,b.channelname,c.title')
                                ->alias('a')
                                ->join('LEFT JOIN __DISTRIBUTION_CHANNELS__ b ON a.channelid=b.channelid
                                        LEFT JOIN __DISTRIBUTION_AD__ c ON a.adid=c.id')
                                ->where($where)
                                ->limit($page->firstRow.','.$page->listRows)
                                ->order('id desc')->select();

        $this->assign('page',$data['page']);
        $this->assign('statsList',$data['data']);
        $this->display();
    }



}