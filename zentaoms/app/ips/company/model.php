<?php
/**
 * The model file of company of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     company 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class companyModel extends model
{
    /**
     * get contact information.
     * 
     * @access public
     * @return string
     */
    public function getContact()
    {
        $contact = json_decode($this->config->company->contact);
        foreach($contact as $item => $value)
        {
            if($value)
            {
                if($item == 'qq') 
                {
                    $contact->qq = html::a("tencent://message/?uin={$value}&amp;Site={$this->config->company->name}&amp;Menu=yes", $value);
                }
                else if($item == 'email')
                {
                    $contact->email = html::mailto($value, $value);
                }
                else if($item == 'weibo')
                {
                    $contact->weibo = html::a("http://weibo.com/{$value}", $value, "target='_blank'");
                }
                else if($item == 'wangwang')
                {
                    $contact->wangwang = html::a("http://www.taobao.com/webww/ww.php?ver=3&touid={$value}&siteid=cntaobao&status=2&charset=utf-8", $value, "target='_blank'");
                }
            }
            else
            {
                unset($contact->$item);
            }
        }
        return $contact;
    }
}
