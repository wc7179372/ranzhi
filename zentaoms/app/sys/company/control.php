<?php
/**
 * The control file of company module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company 
 * @version     $Id: control.php 2605 2013-12-23 09:12:58Z wwccss $
 * @link        http://www.zentao.net
 */
class company extends control
{
    /**
     * company profile.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->view->title    = $this->config->company->name;
        $this->view->keywords = $this->config->company->name;
        $this->view->company  = $this->config->company;
        $this->view->contact  = $this->company->getContact();

        $this->display();
    }

    /**
     * set company basic info.
     * 
     * @access public
     * @return void
     */
    public function setBasic()
    {
        if(!empty($_POST))
        {
            $_POST[setDate] = helper::now();
            $now = helper::now();
            $company = fixer::input('post')
            ->add('setDate', $now)
            ->stripTags('desc', $this->config->allowedTags->admin)
            ->stripTags('content', $this->config->allowedTags->admin)
            ->get();

            $result = $this->loadModel('setting')->setItems('system.common.company', $company);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title = $this->lang->company->setBasic;
        $this->display();
    }

    /**
     * set contact information.
     * 
     * @access public
     * @return void
     */
    public function setContact()
    {
        if(!empty($_POST))
        {
            if(!empty($_POST['email']))
            {
                if(!validater::checkEmail($_POST['email'])) $this->send(array('result' => 'fail', 'message' => $this->lang->company->error->email)); 
            }

            $contact = array('contact' => helper::jsonEncode($_POST));
            $result  = $this->loadModel('setting')->setItems('system.common.company', $contact);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title   = $this->lang->company->setContact;
        $this->view->contact = json_decode($this->config->company->contact);
        $this->display();
    }
}
