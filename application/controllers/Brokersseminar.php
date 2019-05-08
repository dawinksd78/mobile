<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 모바일 설명회
class  Brokersseminar extends MY_Controller
{
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
		$param = $this->input->get('gubun');
	
		$data = array("gubun"=>$param);

		session_start();
		session_destroy();

		$this->load->view("/seminar/broker_seminar_header");
		$this->load->view("/seminar/broker_seminar_intro", $data);
    }

	function mobile()
	{
		$param = $this->input->get('gubun');

		$data = array("gubun"=>$param); 

		$this->load->view("/seminar/broker_seminar_header");
		$this->load->view("/seminar/broker_seminar_mobile", $data);
	}
	
	function pc()
	{
		$this->load->helper('url');

		$gubun = $this->input->get('gubun');

		redirect('http://www.dawin.xyz/brokersseminar/pc?gubun='.$gubun, 'refresh'); 
	}

	function saveresult_mobile()
	{
		$name = $this->input->post('bname');
		$phone= $this->input->post('phone');
		$gubun= $this->input->post('gubun');

		$data = array("name"=>$name,"phone"=>$phone, "gubun"=>$gubun);

		session_start();

		$username = ""; 		
		$userip = ""; 		
		$userphone = ""; 	
		$usergubun = ""; 	
		$device = "MOBILE";

		$remoteaddr = $_SERVER['REMOTE_ADDR']; 

		if(isset($_SESSION['usergubun'])) {
			$usergubun = $_SESSION['usergubun'];
		}

		if(isset($_SESSION['userip'])) {
			$userip = $_SESSION['userip'];
		}

		if(isset($_SESSION['phone'])) {
			$userphone = $_SESSION['phone'];
		}
		
		if(isset($_SESSION['name'])) {
			$username = $_SESSION['name'];
		}

		if($phone == null)
		{
			$data = array("name"=>$username,"phone"=>$userphone, "gubun"=>$usergubun);
		}
		else
		{
			// 동일아이피 + 동일 핸드폰은 가입 및  sms 문자를 발송하지 않도록 함. 
			if($userip != $remoteaddr || $userphone != $phone)
			{
				// 결과저장		
				$this->load->model("brokersseminar_model");
				$this->brokersseminar_model->saveseminar($name,$phone,$gubun,$device);

				// sms 발송 
				$this->sendSms($phone);		
				
				// 세션저장
				$_SESSION["userip"] = $_SERVER['REMOTE_ADDR'];
				$_SESSION["phone"] = $phone;
				$_SESSION["usergubun"] = $gubun;
				$_SESSION["name"] = $name;
			}
		}

		$this->load->view("/seminar/broker_seminar_header");
		$this->load->view("/seminar/broker_seminar_mobile_result",$data);
	}

	protected $CI;
	function sendSms($phone)
	{
		$messagetype = "PV"; //개인별발송
		$title = "다윈중개 참석 예약 확정 안내";
		$message = 
"다윈중개 설명회에 참석을 신청해 주셔서 감사합니다.

설명회 일시 : 19.3.12(화) 오전 11시
설명회 장소 : 판교 워크앤올 코워킹 스페이스 4층 세미나실 (판교역 2번출구)
(성남시 분당구 분당내곡로 117 크래프톤타워 - 구 알파돔타워Ⅳ)

설명회 때 뵙겠습니다.";
		
		$smsdata = array(
				  "member_type"=>"PV"
				  ,"private_info"=>$phone
				  ,"send_manager"=>"A"
				  ,"send_rsv_date"=>""
				  , "title"=>$title
				  ,"link_url"=>""
				  ,"message"=>$message
				  ,"token"=>''
				);
 
		$this->CI =& get_instance();

		$this->CI->load->library('encryption');
		$this->CI->encryption->initialize(array('driver'=>'openssl'));
		$smsdata['token'] = urlencode($this->CI->encryption->encrypt(json_encode(array("createdtime"=>time(), "expire"=>time()+600))));
		
		$url = "http://api.dawin.xyz/sendsms";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $smsdata);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT,5);
		$result = curl_exec($curl);
		curl_close($curl);
		if($result === false) {
            return array("result"=>false, "msg"=>"sending error");
		}
		$res = json_decode($result, true);
		if($res['code'] != '100') {
            return array("result"=>false, "msg"=>"result error", "data"=>$res);
		}
		else return array("result"=>true);
	}
}