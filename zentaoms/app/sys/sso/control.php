<?php
class sso extends control
{
    public function check()
    {
        $token  = $this->get->token;
        $auth   = $this->get->auth;
        $userIP = $this->get->userIP;
        $sso    = $this->sso->getByToken($token); 
        $entry  = $this->loadModel('entry')->getById($sso->entry);
        if($this->sso->checkIP($entry->code))
        {
            if($auth == md5($entry->code . $token . $entry->key))
            {
                session_destroy();
                session_id($sso->sid);
                session_start();
                if($this->session->user->ip == $userIP)
                {
                    $user = $this->loadModel('user')->getByAccount($this->session->user->account);
                    $response['status'] = 'success';
                    $response['data']   = json_encode($user);
                    die(json_encode($response));
                }
            }
        }

        $response['status'] = 'fail';
        $response['data']   = 'check failed.';
        die(json_encode($response));
    }

    /**
     * Auth user.
     * 
     * @param  string $entry 
     * @access public
     * @return void
     */
    public function auth($code, $account = '', $authcode = '')
    {
        if($this->post->account)  $account  = $this->post->account;
        if($this->post->authcode) $authcode = $this->post->authcode;

        $user = $this->sso->identify($code, $account, $authcode);
        if($user)
        {
            $response['status'] = 'success';
            $response['data']   = json_encode($user);
            die(json_encode($response));
        }

        $response['status'] = 'fail';
        $response['data']   = 'auth failed.';
        die(json_encode($response));
    }
}