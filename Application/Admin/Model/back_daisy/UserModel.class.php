<?php
/**
 * creat by muyi 2017/05/09
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
    protected $tableName='distribution_system_users';

    /**
     * @param $uid
     * @return mixed
     *根据用户ID获取用户名
     */
    public function getNameById($uid)
    {
        $data=$this->field('name')->find($uid);
        return $data['name'];
    }

    /**
     * @param $uid
     * @return int
     * 获取用户总的充值金额
     */
    public function getUserSummoney($uid)
    {
        $where=array(
            'buyid'=>$uid,
            'payflag'=>1
        );
        $paylist=M('distribution_pay_paylog')->field('money')->where($where)->select();
        $sumpay=0;
        foreach ($paylist as $v){
            $sumpay+=$v['money'];
            }
         return $sumpay;
    }


    /**
     * 获取平台引导人数和关注人数
     */
    public function getPtSumUserCount($ptid)
    {
       
        $count['sumuser']=$this->where(array('ptid'=>$ptid))->count();
        $count['sumfollow']=$this->where(array('ptid'=>$ptid,'isfollow'=>1))->count(); 
		

        return$count;
    }
	/*
     * 获取用户余额
     * */
    public function getBalanceByuid($uid){
        $balance=$this->field('egold')->where(array('uid'=>$uid))->find();
        return $balance;
    }
	
	
	 /**
     *根据用户id获取用户名
     */

    public function getUnameByID($uid)
    {
        $data=$this->field('uname,name')->find($uid);
        return $data;
    }

    /**
     * 获取相应公众号级别的所有用户信息
     */

    public function getUserListByfromid($fromid)
    {
        if(empty($fromid)){
            $fromid=cookie('channelid');
        }
        $schannelid=D('Channel')->getSchannelid($fromid);
        $schannelid[]=$fromid;
        $schannelid=implode(',',$schannelid);

        $userlist=$this->where('channelid in ('.$schannelid.')')->select();
        return $userlist;
    }

    /**
     * 获取相应公众号级别的所有关注用户的用户名
     */

    public function getUserUnameListByfromid($fromid)
    {
        if(empty($fromid)){
            $fromid=cookie('channelid');
        }
        $schannelid=D('Channel')->getSchannelid($fromid);
        $schannelid[]=$fromid;
        $schannelid=implode(',',$schannelid);

        $userUnameList=$this->field('uname,name')->where('channelid in ('.$schannelid.') AND isfollow =1')->select();

        return $userUnameList;
    }
	
	/**
     * 今日签到人数
     */
    public function getdaySignCount($channelid='')
    {

        $today=strtotime(date('Y-m-d',time()));
        if(empty($channelid)){
            $signcount=$this->where('signtime >'.$today)->count();
        }else{

            $schannelid=D('Channel')->getSchannelid($channelid);
            $schannelid[]=$channelid;
            $schannelid=implode(',',$schannelid);
            //var_dump('signtime >'.$today.' AND channelid in('.$schannelid.')');exit;
            $signcount=$this->where('signtime >'.$today.' AND channelid in('.$schannelid.')')->count();
        }
        return $signcount;
    }
	
	
}