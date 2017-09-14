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
			
			//如果已存在过结算单直接显示成功不添加
            $res=$AskpayModel->where(array('asktime'=>$data['asktime'],'channelid'=>$data['channelid']))->find();
            if($res){
                $this->ajaxReturn(array('result' => 1, 'msg' => '申请成功'));
            }
			
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
            $askpayInfo=$AskpayModel->where(array('asktime'=>$asktime,'channelid'=>$channelid))->find();
            //$channelArr=D('Channnel')->getchannelidArr($channelid);
            $oldpaylog=M('distribution_pay_log')->where(array('channelid'=>$channelid))->find();
            if($askpayInfo){
				
				 //如果已经存在过结算并且状态为2直接显示结算成功
                if($askpayInfo['status']==2){
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                }
                $data['status']=2;
                $res=$AskpayModel->where(array('asktime'=>$asktime,'channelid'=>$channelid))->save($data);
                if($res!==false){
                    /* $paydata['remainmoney']=$oldpaylog['remainmoney']-$askpayInfo['askmoney'];
                    $paydata['paidmoney']=$oldpaylog['paidmoney']+($askpayInfo['askmoney']*$proportion); */
					$paydata['remainmoney']=floatval($oldpaylog['remainmoney'])-floatval($askpayInfo['askmoney']);
                    $paydata['paidmoney']=floatval($oldpaylog['paidmoney'])+floatval($askpayInfo['askmoney']*$proportion);
					
					/* 书写结算日志 */
					/*$str=date("Y-m-d H:i:s",time()).PHP_EOL;
					$str.=$channelid."→旧结算值 ".$oldpaylog['paidmoney']." 加上待结算值 ".$askpayInfo['askmoney']."*".$proportion."=".$paymoney." 等于 ".$paydata['paidmoney'].PHP_EOL;	
                    $str.=$channelid."→旧未结算值 ".$oldpaylog['remainmoney']." 减去待结算值 ".$askmoney." 等于 ".$paydata['remainmoney'].PHP_EOL;
                    $str.="===============================================================================================".PHP_EOL;
                    file_put_contents('./askpay.txt',$str,FILE_APPEND);*/
					
                    M('distribution_pay_log')->where(array('channelid'=>$channelid))->save($paydata);
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
                    $paydata['remainmoney']=$oldpaylog['remainmoney']-$askmoney;
                    $paydata['paidmoney']=$oldpaylog['paidmoney']+($askmoney*$proportion);
					
					/* 书写结算日志 */
					/*$str=date("Y-m-d H:i:s",time()).PHP_EOL;
					$str.=$channelid."→旧结算值 ".$oldpaylog['paidmoney']." 加上待结算值 ".$askmoney."*".$proportion."=".$paymoney." 等于 ".$paydata['paidmoney'].PHP_EOL;	
                    $str.=$channelid."→旧未结算值 ".$oldpaylog['remainmoney']." 减去待结算值 ".$askmoney." 等于 ".$paydata['remainmoney'].PHP_EOL;
                    $str.="===============================================================================================".PHP_EOL;
                    file_put_contents('./askpay.txt',$str,FILE_APPEND);*/
					
					M('distribution_pay_log')->where(array('channelid'=>$channelid))->save($paydata);
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '结算失败'));
                }
            }
        }
    }
}