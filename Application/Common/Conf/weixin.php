<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/05/24
 * Time: 10:03
 * 微信的配置文件
 *
 */

$weixin['appid']= 'wxb36c0f7d7456392f'; //公众账号

$weixin['mch_id']           = '1422332502'; //微信支付分配的商户号

$weixin['opendkey']         = 'a26179afa469d67f324a122b21023ed5';//公众号key

$weixin['paykey']           = 'xindong13503715559mianfeidushu99';//支付key

$weixin['device_info']      = 'WEB';//设备号

$weixin['sign_type']        = 'MD5';

return array('WEIXIN_CONF' => $weixin);

?>
