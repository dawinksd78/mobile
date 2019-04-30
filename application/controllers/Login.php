<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    function index()
    {
        $this->lang->load('code_messages', "english");
        $userinfo = $this->session->userdata('usesrinfo');

        if( isset( $userinfo['MBR_IDX']) ) {
            return $this->json_encode(array('code'=>202, "msg"=>$this->lang->line('code_202'),"action"=>"refresh" ) ) ;
        }

        $user_id = $this->input->post('login_id', true);
        $user_pwd = $this->input->post('login_pwd', true);
        $autologin = $this->input->post('autologin');
        $res = $this->loginprc($user_id ,$user_pwd,($autologin =='Y'?'Y':'N') );
        $this->json_encode($res);return ;
    }
    
    function logincheck()
    {
        $userinfo = $this->session->userdata('usesrinfo');
        if( isset( $userinfo['MBR_IDX']) ) {
            header('Refresh:0;url=/');return;
        }
        
        $autologin = $this->input->cookie('atl');
        if($autologin != '')
        {
            $this->load->library('encryption');$this->encryption->initialize(array('driver' => 'openssl'));
            $logininfo = $this->encryption->decrypt($autologin);
            $logininfo = explode("|@|", $logininfo);
            if(count($logininfo) == 3)
            {
                $res = $this->loginprc($logininfo[0],$logininfo[2], $autologin='Y');
                if($res['code'] != 200) {
                    $this->input->set_cookie('atl','',0 );
                }
            }
            else $this->input->set_cookie('atl','',0 );
        }
        header('Refresh:0;url=/');
    }
    
    private function loginprc($user_id,$user_pwd, $autologin='N')
    {
        $this->load->model("member_model");
        $res = $this->member_model->isMember($user_id, $user_pwd);
        if($res['code'] != 200 ) return array('code'=>$res['code'], "msg"=>$this->lang->line('code_'.$res['code'] ) )  ;
        else
        {
            $this->session->set_userdata( array("usesrinfo"=>$res['data']) );
            if( $autologin =='Y' )
            {
                $this->load->library('encryption');$this->encryption->initialize(array('driver' => 'openssl'));
                $ciphertext = $this->encryption->encrypt($user_id."|@|123123123|@|".$user_pwd);
                //echo $this->encryption->decrypt($ciphertext);
                $this->input->set_cookie('atl',$ciphertext, 86400*90 );
            }
            else {
                $this->input->set_cookie('atl','',0 );
            }
            //$this->session->set_userdata( array("MBR_IDX"=>$res['data']['MBR_IDX'], "MBR_ID"=>$res['data']['MBR_ID'], "MBR_GUBUN"=>$res['data']['MBR_GUBUN'], "MBR_GUBUN_TXT"=>$res['data']['MBR_GUBUN_TXT'] , "MBR_NAME"=>$res['data']['MBR_NAME']) );
            $this->member_model->addLoginHistory($res['data']['MBR_IDX'], true);
            if( $res['data']['MBR_GUBUN'] !='PU') return array("code"=>200, "location"=>"/brokerPage/BrokerInfo");
            return array("code"=>200) ;
        }
    }
    
    function logout()
    {
        session_destroy();
        $this->input->set_cookie('atl','',0 );
        header('Refresh:0;url=/');
    }
    
    function json_encode($data='')
    {
        header('Content-Type: application/json');
        if($data =='')     $data= array("code"=>'501', "msg"=>$this->lang->line('code_501') );
        else if ($data == 'login') $data = array ( 'code'=>'201', 'msg'=>$this->lang->line('code_201') );
        else echo json_encode($data);
    }
}
