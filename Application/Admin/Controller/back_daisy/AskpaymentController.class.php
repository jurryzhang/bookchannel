<?php
/**
 * Created by PhpStorm.
 * User: HIAPAD
 * Date: 2017/6/9
 * Time: 16:21
 */
namespace Admin\Controller;
use Think\Controller;
class AskpaymentController extends Controller{
    public function index(){
        $AskpayModel=D('Askpayment');
        if(IS_AJAX) {
            $data['asktime'] = I('asktime');
            $data['channelid'] = I('channelid');
            $data['askmoney'] = I('askmoney');
            $data['proportion'] = I('proportion');
            $data['paymoney'] = I('paymoney');
            $data['addtime'] = time();
            $insertid = $AskpayModel->add($data);
            if ($insertid) {
                $data['status']=1;
                $AskpayModel->where(array('askid'=>$insertid))->save($data);
                $this->ajaxReturn(array('result' => 1, 'msg' => '申请成功'));
            } else {
                $this->ajaxReturn(array('result' => 0, 'msg' => '申请失败'));
            }
        }
    }
    public function dealAskpay(){
        $AskpayModel=D('Askpayment');
        if(IS_AJAX){
            $asktime=I('asktime');
            $channelid=I('channelid');
            $askmoney=I('askmoney');
            $paymoney=I('paymoney');
            $proportion = I('proportion');
            $askpayList=$AskpayModel->where(array('asktime'=>$asktime,'channelid'=>$channelid))->find();
            if($askpayList){
                $data['status']=2;
                $res=$AskpayModel->where(array('asktime'=>$asktime,'channelid'=>$channelid))->save($data);
                if($res!==false){
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '结算失败'));
                }
            }else{
                $datalist[]=array(
                    'status'=>2,
                    'asktime'=>$asktime,
                    'askmoney'=>$askmoney,
                    'paymoney'=>$paymoney,
                    'channelid'=>$channelid,
                    'proportion'=>$proportion,
                    'addtime'=>time()
                );
                $insertid = $AskpayModel->addAll($datalist);
                if ($insertid) {
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '结算失败'));
                }
            }
        }
    }
}