<?php
/**
 * Created by PhpStorm.
 * User: HIAPAD
 * Date: 2017/6/9
 * Time: 16:35
 */
namespace Admin\Model;
use Think\Model;
class AskpaymentModel extends Model{
    protected $tableName='distribution_payment';

    public function changeStatus($channelid){
        $AskpayModel=D('Askpayment');
        $data['status']=2;
        $res=$AskpayModel->where(array('channelid'=>$channelid))->save($data);
        if($res===true){
            return true;
        }else{
            return false;
        }
    }
}