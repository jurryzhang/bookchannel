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
            //$insertid = $AskpayModel->add($data);
            //判断是否是新的一天,才执行
            //var_dump($data);
            //$fpid = M('distribution_channels')->field('pid')->where(array('channelid'=>$data['channelid']))->find();
            $where=array('asktime'=>$data['asktime'],'channelid'=>$data['channelid']);
            if(time()>1504281600&&cookie('pid')==0){
                $where=array('asktime'=>$data['asktime'],'channelid'=>$data['channelid'],'isall'=>1);               
            }
            $res=$AskpayModel->where($where)->find();
            if($res){
                //echo 1111;exit;
                $res['status']=1;
                $AskpayModel->save($res);
                $this->ajaxReturn(array('result' => 1, 'msg' => '申请成功'));
            }else{
                $data['status'] =1;
                $insertid = $AskpayModel->add($data);
                //var_dump($askpayInfo);
                //echo M()->getLastSql();exit;
                //var_dump($insertid);exit;
                if ($insertid) {

                    $data['status']=1;
                    $AskpayModel->where(array('askid'=>$insertid))->save($data);
                    $this->ajaxReturn(array("result" => 1, "msg" => "申请成功"));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '申请失败'));
                }
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

            $where=array('asktime'=>$asktime,'channelid'=>$channelid);
            if(time()>1504281600&&cookie('uid')==1){
                $where=array('asktime'=>$asktime,'channelid'=>$channelid,'isall'=>1);               
            }
            $askpayInfo=$AskpayModel->where($where)->find();
            //$channelArr=D('Channnel')->getchannelidArr($channelid);
            $oldpaylog=M('distribution_pay_log')->where(array('channelid'=>$channelid))->find();

            if($askpayInfo){
                
                if($askpayInfo['status']==2){
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                }
                $askpayInfo['status']=2;
                $res=$AskpayModel->save($askpayInfo);
                if($res!==false){
                    /* $paydata['remainmoney']=$oldpaylog['remainmoney']-$askpayInfo['askmoney'];
                    $paydata['paidmoney']=$oldpaylog['paidmoney']+($askpayInfo['askmoney']*$proportion); */
					$paydata['remainmoney']=floatval($oldpaylog['remainmoney'])-floatval($askpayInfo['askmoney']);
                    $paydata['paidmoney']=floatval($oldpaylog['paidmoney'])+floatval($askpayInfo['askmoney']*$proportion);
					
					/* 书写结算日志 */
					$str=$channelid."→旧结算值 ".$oldpaylog['paidmoney']." 加上待结算值 ".$askpayInfo['askmoney']."*".$proportion."=".$paymoney." 等于 ".$paydata['paidmoney'].PHP_EOL;	
                    $str.=$channelid."→旧未结算值 ".$oldpaylog['remainmoney']." 减去待结算值 ".$askmoney." 等于 ".$paydata['remainmoney'].PHP_EOL;
                    $str.="===============================================================================================".PHP_EOL;
                    file_put_contents('./askpay.txt',$str,FILE_APPEND);
					
                    M('distribution_pay_log')->where(array('channelid'=>$channelid))->save($paydata);
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '结算失败'));
                }
            }else{
                if(cookie('uid')==1){
                    $isall=1;
                }else{
                    $isall=0;
                }
                $datalist=array(
                    'status'=>2,
                    'asktime'=>$asktime,
                    'askmoney'=>$askmoney,
                    'paymoney'=>$paymoney,
                    'channelid'=>$channelid,
                    'proportion'=>$proportion,
                    'addtime'=>time(),
                    'paydate'=>strtotime("$asktime"),
                    'isall'=>$isall,
                    
                );
                $insertid = $AskpayModel->add($datalist);
                if ($insertid) {
                    $paydata['remainmoney']=$oldpaylog['remainmoney']-$askmoney;
                    $paydata['paidmoney']=$oldpaylog['paidmoney']+($askmoney*$proportion);
					
					/* 书写结算日志 */
					$str=$channelid."→旧结算值 ".$oldpaylog['paidmoney']." 加上待结算值 ".$askmoney."*".$proportion."=".$paymoney." 等于 ".$paydata['paidmoney'].PHP_EOL;	
                    $str.=$channelid."→旧未结算值 ".$oldpaylog['remainmoney']." 减去待结算值 ".$askmoney." 等于 ".$paydata['remainmoney'].PHP_EOL;
                    $str.="===============================================================================================".PHP_EOL;
                    file_put_contents('./askpay.txt',$str);
					
					M('distribution_pay_log')->where(array('channelid'=>$channelid))->save($paydata);
                    $this->ajaxReturn(array('result' => 1, 'msg' => '结算成功'));
                } else {
                    $this->ajaxReturn(array('result' => 0, 'msg' => '结算失败'));
                }
            }
        }
    }
}