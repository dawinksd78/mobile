<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $userinfo;
    public $is_login;
    public $autologin;

    function __construct() {
        parent::__construct();
    }

    public function _remap($method)
    {
        $this->userinfo = $this->session->userdata('userinfo');
        $this->segment_page = $this->uri->segment(1);
        session_write_close();
        
        if( isset( $this->userinfo['MBR_IDX']) ) {
            $this->is_login = true;
        }
        else
        {
            $autologin = $this->input->cookie('atl');
            if($autologin != '' )
            {
                $this->load->library('encryption');$this->encryption->initialize(array('driver' => 'openssl'));
                $logininfo = $this->encryption->decrypt($autologin);
                $logininfo = explode("|@|", $logininfo);
                if( count($logininfo) == 4 ) {
                    header('Refresh:0;url=/login/logincheck');
                    return;
                }
            }
            
            $this->is_login = false;
        }
        
        if($method != 'child_renmap') $this->{$method}();
  	}
  	
  	function chkdateformat($date)
  	{
  	    $tz_object = new DateTimeZone('Asia/Seoul');
  	    $datetime = new DateTime();
  	    $dt = DateTime::createFromFormat("Y-m-d", $date);
  	    if( $dt !== false && !array_sum($dt->getLastErrors()) )
  	    {
  	        if( $datetime->format('Y-m-d') > $dt->format('Y-m-d') ){
  	            return array("code"=>false, "msg"=>"오늘 이후의 날자를 선택해주세요");
  	        }
  	        else return array("code"=>true, "data"=>$dt->format('Y-m-d') );
  	    }
  	    else return array("code"=>false, "msg"=>"날자형식(0000-00-00)에 맞게 입력해주세요");
  	}
  	
  	function check_inCode( $code, $CODE_GBN, $CODE_TYPE='A')
  	{
  	    $this->load->model("Goods_model");
  	    if( is_array($code) )
  	    {
  	        foreach( $code as $idx=>$val ) {
  	            if( !$this->Goods_model->checkInCode($val, $CODE_GBN, $CODE_TYPE) ) return false;
  	        }
  	        
  	        return true;
  	    }
  	    
  	    return $this->Goods_model->checkInCode($code, $CODE_GBN, $CODE_TYPE);
  	}
  	
    function json_encode($data='', $cache=false, $cachetime=604800)
    {
        $this->lang->load('code_messages', "english");
        if($cache) {
            $seconds_to_cache = $cachetime;
            $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
            header('Cache-Control: max-age='.$seconds_to_cache.', must-revalidate');
            header("Expires: $ts");
            header("Pragma: cache");
        }
        else {
            header('Content-Type: application/json');
        }
      
        if($data =='')     $data= array("code"=>"501", "msg"=>$this->lang->line('code_501') );
        else if ($data == 'login') $data = array ( 'code'=>"201", 'msg'=>$this->lang->line('code_201') );
        else if ( isset($data['code']) && $data['code'] != "200" && (!isset($data['msg']) || $data['msg'] == '') ) $data['msg'] = $this->lang->line('code_'.$data['code']);
        echo json_encode($data);
    }
}
