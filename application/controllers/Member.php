<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
    
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index(){
        // member Info
    }
    
    //--------------------------------------------------------------//
    
    // 아이디 찾기 1단계
    public function findid1()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('member/findid1', $data);
        $this->load->view('sub_footer');
    }
    
    // 아이디 찾기
    function findid1Cert()
    {
        $hp = "0".(int)trim(str_replace("-","",$this->input->post('hp', true)));
        if($this->findidByHP($hp) === false) {
            echo json_encode(array("code"=>"404", "msg"=>"회원정보를 찾을 수 없습니다."));
        }
        else
        {
            $date = new DateTime("now", new DateTimeZone('Asia/Seoul') );
            
            //session_start();
            $findid = $this->session->set_userdata("findid");
            if( is_array( $findid ) && isset( $findid['date']) ) {
                if( $findid['date'] > $date->sub( new DateInterval('PT30M'))->format('Y-m-d H:i:s') ) {
                    $cnt = $findid['cnt'] +1;
                }
            }$cnt=1;
            if( $cnt > 3) {
                echo json_encode(array("code"=>"404", "msg"=>"찾기 횟수를 초과했습니다.\n30분 후에 다시 시도해주세요"));
            }
            
            $this->load->helper('string');
            $code = random_string('nozero', 6);
            
            $this->load->library('encryption');
            $this->encryption->initialize(array('driver'=>'openssl'));
            $token = urlencode($this->encryption->encrypt(json_encode(array("createdtime"=>time(), "expire"=>time()+600))));
            
            $data = array("member_type"=>"PV", "private_info"=>$hp, "send_manager"=>"S", "send_rsv_date"=>"", "title"=>"아이디찾기",
                "link_url"=>"", "message"=>"[다윈 본인확인] 인증번호 [".$code."]를 입력해주세요", "token"=>$token);
            $url = "http://api.dawin.xyz/sendsms";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            
            if($result === false) {
                echo json_encode(array("code"=>"500", "msg"=>"죄송합니다. 잠시 후에 다시 시도해 주세요"));
                return false;
            }
            $res = json_decode($result, true);
            if($res['code'] != '100') {
                echo json_encode(array("code"=>"500", "msg"=>"죄송합니다.\n인증번호 발송이 지연되고 있습니다.\n 잠시 후에 다시 시도해 주세요", "data"=>$res['code']) );
                return false;
            }
            
            $finddata = array("findCode"=>$code, "findHP"=>$hp, "findCNT"=>$cnt, "date"=>$date->format('Y-m-d H:i:s'));
            $this->session->set_userdata(array("findId"=>$finddata));
            echo json_encode(array("code"=>"200"));
        }
    }
            
    // 아이디 찾기 2단계
    public function findid2()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('member/findid2', $data);
        $this->load->view('sub_footer');
    }
    
    function findIDChk()
    {
        $certno = (int)$this->input->post("certno");
        //session_start();
        $finddata = $this->session->userdata('findId');
        if( !isset($finddata['findCode']) || $certno != $finddata['findCode'] ) {
            echo json_encode(array("code"=>"501", "msg"=>"인증번호를 확인해주세요"));
            return;
        }
        else {
            $MBR_ID = $this->findidByHP($finddata['findHP']);
            echo json_encode(array("code"=>"200", "data"=>$MBR_ID));
            $this->session->sess_destroy();
        }
    }
    
    // 아이디 찾기 3단계
    public function findid3()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        if($this->uri->segment(3) == '') {
            $data['RESULT'] = "FAIL";
        }
        else {
            $data['RESULT'] = "SUCCESS";
        }
        
        $data['userid'] = urldecode($this->uri->segment(3));
        
        $this->load->view('sub_header');
        $this->load->view('member/findid3', $data);
        $this->load->view('sub_footer');
    }
    
    private function findidByHP($hp)
    {
        $qry = $this->db->select('MBR_ID')->where("MBR_CP", $hp)->where("MBR_STATUS","NM")->limit("1")->get('TB_UB_MEMBER');
        if($qry->num_rows() < 1) {
            return false;
        }
        else {
            $row = $qry->row_array();
            return $row['MBR_ID'];
        }
    }
    
    //--------------------------------------------------------------//
    
    // 비밀번호 찾기 1단계
    public function findpass1()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('member/findpass1', $data);
        $this->load->view('sub_footer');
    }
    
    // 비밀번호 찾기 1단계 (이메일 발송)
    public function findpassemail()
    {
        $MAILDATA['email'] = $this->input->get_post('email');
        $MAILDATA['sendType'] = $this->input->get_post('sendType');
        
        $this->load->model('member_model');
        
        // 발송처리 결과
        if($this->member_model->sendemailprocess($MAILDATA) == 'COMPLETE') {
            echo "SUCCESS";
        }
        else {
            echo "FAIL";
        }
    }
    
    // 비밀번호 찾기 2단계 (완료)
    public function findpass2()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('member/findpass2', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 회원가입 1단계
    public function join1()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 정보값 삭제
        $this->load->helper('cookie');
        delete_cookie('joinInfo');
        delete_cookie('nullCPIDX');
        delete_cookie('certIDX');
        
        $this->load->view('sub_header');
        $this->load->view('member/join1', $data);
        $this->load->view('sub_footer');
    }
    
    // 회원가입 2단계
    public function join2()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->helper('cookie');
        if(get_cookie('joinInfo') != '')
        {
            $getCookies = explode('|', get_cookie('joinInfo'));
            
            $data['certIDX'] = get_cookie('certIDX');
            $data['username'] = $getCookies[0];
            $data['idemail'] = $getCookies[1];
            $data['password'] = $getCookies[2];
            $data['idcertconfirm'] = $getCookies[3];
        }
        else
        {
            $data['certIDX'] = null;
            $data['username'] = null;
            $data['idemail'] = null;
            $data['password'] = null;
            $data['idcertconfirm'] = null;
        }
        
        $this->load->view('sub_header');
        $this->load->view('member/join2', $data);
        $this->load->view('sub_footer');
    }
    
    // 회원가입 2단계 (중복확인체크)
    public function joincheck()
    {
        $user_id = $this->input->get_post('user_id');
        
        $this->load->model('member_model');
        
        if($this->member_model->joininfocheck($user_id) == 'Y') {
            echo "Y";
        }
        else {
            echo "N";
        }
    }
    
    // 회원가입 2단계 (가입완료처리)
    public function joinprocess()
    {
        $JOINDATA['user_name'] = $this->input->post('user_name');
        $JOINDATA['user_id'] = $this->input->post('user_id');
        $JOINDATA['password'] = $this->input->post('password');
        
        $this->load->model('member_model');
        
        // 가입처리 결과
        if($this->member_model->joinprocess($JOINDATA) == 'COMPLETE') {
            echo "Y";
        }
        else {
            echo "N";
        }
    }
    
    // 회원가입 3단계
    public function join3()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 정보값 삭제
        $this->load->helper('cookie');
        delete_cookie("joinInfo");
        delete_cookie("certIDX");
        
        $data['user_name'] = urldecode($this->input->get_post('user_name'));
        
        $this->load->view('sub_header');
        $this->load->view('member/join3', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 로그인 페이지
    public function login()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->helper('cookie');
        $data['URL'] = null;
        if($this->uri->segment(3) != '') {
            $dataURL = explode("_",$this->uri->segment(3));
            if($dataURL[0] == 'PG') {
                $data['URL'] = "/".$dataURL[1]."/".$dataURL[2]."/".$dataURL[3]."/".$dataURL[4]."/".$dataURL[5];
            }
            else if($dataURL[0] == 'buyhome') {
                $data['URL'] = "/buyhome";
            }
            else {
                $data['URL'] = "/".$dataURL[0]."/".$dataURL[1];
            }
        }
        $this->load->view('sub_header');
        $this->load->view('member/login', $data);
        $this->load->view('sub_footer');
    }
    
    // 로그인 처리 페이지
    function loginprocess()
    {
        $USERINFO['user_id'] = $this->input->post('user_id');
        $USERINFO['password'] = $this->input->post('password');
        $USERINFO['autologin'] = $this->input->post('autologin');

        $this->load->model('member_model');
        $result = $this->member_model->userloginprocess($USERINFO);
        
        echo $result;
    }
    
    // 로그아웃 처리
    function logout()
    {
        session_destroy();
        $this->input->set_cookie('atl','',0 );
        $this->input->set_cookie('joinInfo','',0 );
        $this->input->set_cookie('certIDX','',0 );
        header('Refresh:0;url=/');
    }
    
    //--------------------------------------------------------------//
    
    // 인증해제시 재인증
    public function logincert()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $module = 'CPClient';
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $authtype = "M";
        $popgubun = "N";
        $customize = "";
        $gender = "";
        $reqseq = get_cprequest_no($niceCfg['site']);
        $niceReturnHost =((!isset($_SERVER['HTTPS']) ||$_SERVER['HTTPS'] != "on") ? "http://" : "https://" ).$_SERVER['HTTP_HOST'];
        
        $returnurl = $niceReturnHost."/member/loginCertHP";	        // 성공시 이동될 URL
        $errorurl = $niceReturnHost."/member/loginCertHPFail";		// 실패시 이동될 URL
        
        $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
        "8:SITECODE" . strlen($niceCfg['site']) . ":" . $niceCfg['site'] .
        "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
        "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
        "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
        "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
        "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
        "6:GENDER" . strlen($gender) . ":" . $gender ;
        $data['enc_data'] = get_encode_data($niceCfg['site'], $niceCfg['pw'], $plaindata);
        
        //session_start();
        $sessiondata = array("REQ_SEQ"=>$reqseq);
        $this->session->set_userdata($sessiondata);
                
        $this->load->view('sub_header');
        $this->load->view('member/logincert', $data);
        $this->load->view('sub_footer');
    }
    
    // 로그인 재인증 폰번호체크
    function loginCertHP()
    {
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $enc_data = $_POST['EncodeData'];
        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match) || $enc_data=="" || base64_encode(base64_decode($enc_data))!=$enc_data) {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요", "url"=>"/") );
            $this->load->view('sub_footer');
            return;
        }
        
        $plaindata = get_decode_data($niceCfg['site'], $niceCfg['pw'], $enc_data);
        if($plaindata < 0) {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요(".$plaindata.")", "url"=>"/"));
            $this->load->view('sub_footer');
            return;
        }
        
        $data = $this->getNiceValue($plaindata);
        if( isset($data['NAME']) ) unset($data['NAME']);
        if( isset($data["UTF8_NAME"]) ) $data["UTF8_NAME"] = urldecode( $data["UTF8_NAME"]);
        
        $this->load->helper('cookie');
        $nullCPIDX = get_cookie('nullCPIDX');
        
        $sql = "select * from TB_UB_MEMBER where MBR_IDX = $nullCPIDX";
        $qry = $this->db->query($sql);
        if($qry->num_rows() < 0) {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"아이디를 찾을 수 없습니다.", "url"=>"/member/login") );
            $this->load->view('sub_footer');
            return;
            exit;
        }
        $row = $qry->row_array();
        if($row['MBR_NAME'] != $data["UTF8_NAME"]) {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"동일 명의 휴대폰이 아닙니다.", "url"=>"/member/login") );
            $this->load->view('sub_footer');
            return;
            exit;
        }
        
        $this->db->set("MBR_CP", $data['MOBILE_NO'])->where("MBR_IDX", $nullCPIDX)->update("TB_UB_MEMBER");
        $this->db->insert("TB_HISTORY_NICE", $data);
        
        delete_cookie('nullCPIDX');
        
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"휴대폰 인증을 하였습니다. 로그인해주세요", "url"=>"/member/login") );
        $this->load->view('sub_footer');
    }
    
    // 휴대폰 인증 및 번호 변경
    function loginCertHPFail() {
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"휴대폰 인증에 실패하였습니다.", "url"=>"/") );
        $this->load->view('sub_footer');
        return;
    }
    
    //--------------------------------------------------------------//
    
    // 폰번호 재인증
    public function phonecert()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('member/phonecert', $data);
        $this->load->view('sub_footer');
    }
        
    // 휴대전화 인증
    public function cellphoneCertNum()
    {
        $username       = $this->input->post('user_name');	    // 이름
        $idemail        = $this->input->post('user_id');		// 이메일
        $password       = $this->input->post('password');	    // 비밀번호
        $idcertconfirm  = $this->input->post('idcertconfirm');  // 아이디확인
        
        $this->load->helper('cookie');
        
        $module = 'CPClient';
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        $niceReturnHost = ((!isset($_SERVER['HTTPS']) ||$_SERVER['HTTPS'] != "on") ? "http://" : "https://" ).$_SERVER['HTTP_HOST'];
        
        $authtype = "";
        $popgubun = "Y";
        $customize = "";
        $gender = "";
        $reqseq = get_cprequest_no($niceCfg['site']);
        $returnurl = $niceReturnHost."/member/nice";// 성공시 이동될 URL
        $errorurl = $niceReturnHost."/member/fail";	// 실패시 이동될 URL
        
        $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
                    "8:SITECODE" . strlen($niceCfg['site']) . ":" . $niceCfg['site'] .
                    "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
                    "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
                    "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
                    "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
                    "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
                    "6:GENDER" . strlen($gender) . ":" . $gender;
        $enc_data = get_encode_data($niceCfg['site'], $niceCfg['pw'], $plaindata);
        if( $enc_data < 0 )
        {
            // 정보값 삭제
            delete_cookie('joinInfo');
            delete_cookie('certIDX');
            
            echo json_encode(array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요(".$enc_data.")"));
        }
        else
        {
            //session_start();
            $sessiondata = array("REQ_SEQ"=>$reqseq);
            $this->session->set_userdata($sessiondata);
            
            if($this->session->userdata('REQ_SEQ') != '')
            {
                // 인증시 정보값 임시 저장
                $joinInfo = $username.'|'.$idemail.'|'.$password.'|'.$idcertconfirm;            
                $this->input->set_cookie('joinInfo', $joinInfo, 0);
                
                echo json_encode(array("code"=>"200", "data"=>$enc_data));
            }
            else
            {
                // 정보값 삭제
                delete_cookie('joinInfo');
                delete_cookie('certIDX');
                
                echo json_encode(array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요(".$enc_data.")"));
            }
        }
    }
    
    function getNiceValue( $str )
    {
        $ret = array();
        $tmp = explode(":", $str);
        for($i=1; $i <= count($tmp)-1; $i+=2)
        {
            $matched = preg_match_all('/(\d+)/', $tmp[$i], $matches);
            if($matched)
            {
                $len = $matches[1][count($matches[1]) - 1];
                $idx = str_replace($len, "", $tmp[$i] );
                $val = substr($tmp[$i+1], 0, $len);
                $ret[$idx] = $val;
            }
        }
        
        return $ret;
    }
    
    // 본인인증
    function nice()
    {
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $this->load->helper('cookie');

        $enc_data = $_POST['EncodeData'];
        
        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match) || $enc_data == "" || base64_encode(base64_decode($enc_data))!=$enc_data )
        {
            // 정보값 삭제
            delete_cookie('joinInfo');
            delete_cookie('certIDX');
            
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요", "url"=>"/member/join2") );
            $this->load->view('sub_footer');
            return;
        } // 문자열 점검 추가.
        
        $plaindata = get_decode_data($niceCfg['site'], $niceCfg['pw'], $enc_data);
        if ($plaindata < 0 )
        {
            // 정보값 삭제
            delete_cookie('joinInfo');
            delete_cookie('certIDX');
            
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해 주세요. (".$plaindata.")", "url"=>"/member/join2") );
            $this->load->view('sub_footer');
            return;
        }
        $data = $this->getNiceValue($plaindata);
        if( isset($data['NAME']) ) unset($data['NAME']);
        if( isset($data["UTF8_NAME"]) ) $data["UTF8_NAME"] = urldecode( $data["UTF8_NAME"]);
        
        /*$sessiondata = $this->session->userdata('REQ_SEQ');
        if( strcmp($sessiondata, $data['REQ_SEQ']) != 0 )
        {
            // 정보값 삭제
            delete_cookie('joinInfo');
            delete_cookie('certIDX');
            
            $this->load->view("nice", array("msg"=>"올바른 경로로 접근하시기 바랍니다.", "url"=>"/") );
            return;
        }*/
        
        // 인증 성공값 등록
        $this->db->insert("TB_HISTORY_NICE", $data);
        $certIDX = $this->db->insert_id();
        
        // 인증등록 번호 cookie 생성
        $this->input->set_cookie('certIDX', $certIDX, 0);
        
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"인증이 완료 되었습니다. 가입진행하시기 바랍니다.", "url"=>"/member/join2") );
        $this->load->view('sub_footer');
    }
    
    // 휴대전화 본인인증 실패
    function fail()
    {
        // 정보값 삭제
        $this->load->helper('cookie');
        delete_cookie('joinInfo');
        delete_cookie('nullCPIDX');
        delete_cookie('certIDX');
        
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"본인인증에 실패하였습니다.", "url"=>"/member/join2") );
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 비밀번호 재설정 페이지
    public function setpasswd1()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $token = $this->input->get('token');
        $data = array('chage'=>false, 'token'=>$token, 'msg'=>"해당 데이터를 찾을 수 없습니다.");
        if($token == '') {
            $data['token'] = '';
        }
        else
        {
            $this->load->library('encryption');
            $this->encryption->initialize(array('driver'=>'openssl'));
            $check = json_decode($this->encryption->decrypt(($token)));
            if(!isset($check->email) || !isset($check->createdtime) || !isset($check->expire)) {
                $data['token'] ='';
            }
            else if($check->expire < time() - 8600) {
                $data['token'] ='';
                $data['msg'] = "인증시간(30분)이 만료되었습니다.<br>비밀 번호 찾기를 다시 시도해주세요";
            }
            else {
                $this->session->set_flashdata('pw_token', $token);
                $this->session->set_flashdata('pw_email', $check->email);
                $this->session->set_flashdata('findtype', $check->findtype);
                
                $data['msg'] = '';
                $data['chage'] = true;
            }
        }
        
        $this->load->view('sub_header');
        $this->load->view('member/setpasswd1', $data);
        $this->load->view('sub_footer');
    }
    
    // 비밀번호 재설정 처리 페이지
    public function setpasswdChange()
    {        
        $email = $this->session->flashdata('pw_email');
        $findtype = $this->session->flashdata('findtype');
        
        $pwd = $this->input->post("change_pw");
        
        if($email == "") {
            echo json_encode(array('code'=>'401'));
        }
        else if($this->input->post("change_pw") == '') {
            echo json_encode(array('code'=>'401') );
        }
        else if($pwd != $this->input->post("change_pw_re")) {
            echo json_encode(array('code'=>'402'));
        }
        else
        {
            $this->load->model("member_model");
            $res = $this->member_model->updatePassword($email, $pwd, $findtype);
            
            if($res) echo json_encode(array('code'=>'200'));
            else echo json_encode(array('code'=>'501'));
        }
    }
    
    // 비밀번호 재설정 완료 페이지
    public function setpasswd2()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $type = $this->uri->segment(3);
        if($type != 'COM') {
            $data['RESULT'] = "FAIL";
        }
        else {
            $data['RESULT'] = "SUCCESS";
        }
        
        $this->load->view('sub_header');
        $this->load->view('member/setpasswd2', $data);
        $this->load->view('sub_footer');
    }
}