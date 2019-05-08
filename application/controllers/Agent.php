<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MY_Controller {
    
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
        $data['url'] = "/agent/joinAgent1";
        $this->load->view("alert", $data);
        return;
    }
    
    //--------------------------------------------------------------//
    
    // 중개사 회원가입 1단계
    public function joinAgent1()
    {        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
            
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent1', $data);
        $this->load->view('sub_footer');
    }
    
    // 중개사 회원가입 2단계
    public function joinAgent2()
    {
        $this->load->helper('cookie');
        $data['cook'] = get_cookie('skdicysw1b5dtrt', true);
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent2', $data);
        $this->load->view('sub_footer');
    }
    
    // 중개사 회원가입 3단계
    public function joinAgent3()
    {
        $joinData['BROKER_OFFICE_NAME'] = '';
        $joinData['LAT'] = '';
        $joinData['LNG'] = '';
        
        // 약관 동의 후 3단계 진입시 동의 및 저장 형태로 변경
        $cook = $this->cook();
        $this->db->where('COOK', $cook)->set('STEP','1')->set('STEP_STATUS','SAVE')->set('AGREE','Y')->update('TB_TMP_REALTOR_JOIN');
        
        $joinData = $this->getJoinData($cook);
        if($joinData['DONG_CODE'] != '') {
            $joinData['DONG_CODE'] = substr($joinData['DONG_CODE'],0,-2);
        }
        
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent3', $joinData);
        $this->load->view('sub_footer');
    }
    
    // 중개사 개설 파일업로드
    public function joinAgentFileUp()
    {
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        // 저장체크
        $joinData = $this->getJoinData($cook);
        
        // 쿠키정보 및 동의 여부 확인
        if( !isset($joinData['COOK']) || $joinData['AGREE'] !='Y' ) {
            echo json_encode(array("code"=>"500", "msg"=>"정상적인 접근이 아닙니다."));
            return;
        }
        
        $loadCategory = $this->uri->segment(3);
        $allowed = array("image/jpeg", "image/gif", "image/png");
        
        if($loadCategory === false || !in_array($loadCategory, array('bizCert','regCert','prfImg'))) {
            echo json_encode(array('code'=>'600', "msg"=>"구분이 잘못됐습니다."));
            return;
        }
        else if($joinData[$loadCategory] > 0) {
            json_encode(array("code"=>"500", "msg"=>"이미지를 삭제 후 올려주세요."));
            return;
        }
        
        // 파일 체크
        if(!isset($_FILES['files']) || $_FILES['files']['error']) {
            echo json_encode(array('code'=>'602', "msg"=>"파일업로드 중 에러가 발생했습니다."));
            return;
        }
        else if( !in_array($_FILES['files']['type'], $allowed) ) {
            echo json_encode(array('code'=>'603', "msg"=>"jpg, gif, png 파일만 업로드가 가능합니다."));
            return;
        }
        /*else if( $_FILES['files']['size']/1024/1024 > 4 ) {
            echo json_encode(array('code'=>'604', "msg"=>"최대 4M까지만 업로드가 가능합니다."));
            return;
        }*/
        
        //------------------
        
        // 이미지 로테이션        
        if(in_array($_FILES['files']['type'], array("image/jpeg", "image/jpg"))) {
            $image = imagecreatefromjpeg($_FILES['files']['tmp_name']);
            $imgType = "jpeg";
        }
        else if(in_array($_FILES['files']['type'], array("image/png"))) {
            $image = imagecreatefrompng($_FILES['files']['tmp_name']);
            $imgType = "png";
        }
        else if(in_array($_FILES['files']['type'], array("image/bmp", "image/wbmp"))) {
            $image = imagecreatefromwbmp($_FILES['files']['tmp_name']);
            $imgType = "wbmp";
        }
        else if(in_array($_FILES['files']['type'], array("image/gif"))) {
            $image = imagecreatefromgif($_FILES['files']['tmp_name']);
            $imgType = "gif";
        }
        
        $exif = exif_read_data($_FILES['files']['tmp_name']);
        if(!empty($exif['Orientation']))
        {
            switch($exif['Orientation'])
            {
                case 8:
                    $image = imagerotate($image,90,0);
                break;
                
                case 3:
                    $image = imagerotate($image,180,0);
                break;
                
                case 6:
                    $image = imagerotate($image,-90,0);
                break;
            }
            
            header('Content-type: image/'.$imgType);
            
            if(in_array($_FILES['files']['type'], array("image/jpeg", "image/jpg"))) {
                imagejpeg($image,$_FILES['files']['tmp_name']);
            }
            else if(in_array($_FILES['files']['type'], array("image/png"))) {
                imagepng($image,$_FILES['files']['tmp_name']);
            }
            else if(in_array($_FILES['files']['type'], array("image/bmp", "image/wbmp"))) {
                imagewbmp($image,$_FILES['files']['tmp_name']);
            }
            else if(in_array($_FILES['files']['type'], array("image/gif"))) {
                imagegif($image,$_FILES['files']['tmp_name']);
            }
            
            imagedestroy($image);
        }
        
        //------------------
        
        // 이미지 width, height 변경 (최대 가로세로 1000px)
        $size = getimagesize($_FILES['files']['tmp_name']);
        $ratio = $size[0]/$size[1]; // width/height
        if( $ratio > 1)
        {
            if($size[0] > 1000) {
                $width = 1000;
                $height = 1000/$ratio;
            }
            else {
                $width = $size[0];
                $height = $size[1];
            }
        }
        else
        {
            if($size[1] > 1000) {
                $width = 1000*$ratio;
                $height = 1000;
            }
            else {
                $width = $size[0];
                $height = $size[1];
            }
        }
        $src = imagecreatefromstring(file_get_contents($_FILES['files']['tmp_name']));
        $dst = imagecreatetruecolor($width,$height);
        imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
        imagedestroy($src);
        
        if(in_array($_FILES['files']['type'], array("image/jpeg", "image/jpg"))) {
            imagejpeg($dst,$_FILES['files']['tmp_name']);
        }
        else if(in_array($_FILES['files']['type'], array("image/png"))) {
            imagepng($dst,$_FILES['files']['tmp_name']);
        }
        else if(in_array($_FILES['files']['type'], array("image/bmp", "image/wbmp"))) {
            imagewbmp($dst,$_FILES['files']['tmp_name']);
        }
        else if(in_array($_FILES['files']['type'], array("image/gif"))) {
            imagegif($dst,$_FILES['files']['tmp_name']);
        }
        
        imagedestroy($dst);
        
        //------------------
        
        $this->load->model("S3_model");
        $res = $this->S3_model->uploadFromTmp( $this->S3_model->makePrefix('realtorDoc'),$_FILES['files']['tmp_name'],$_FILES['files']['type']  );
        
        if( isset($res['code']) && $res['code']==200 ) {
            $this->db->insert('TB_TMP_FOR_JOIN_IMAGE', array("CATEGORY"=>$loadCategory, "FILEKEY"=>$res['key'],"IMG_FULL_PATH"=>$res['url'] ));
            $insid = $this->db->insert_id();
            $this->db->set( $loadCategory, $insid)->where ("COOK",$joinData['COOK'] )->update('TB_TMP_REALTOR_JOIN');
            echo json_encode(array('code'=>'200',"newUuid"=>$insid,"data"=>$res['url']));
        }
        else if( isset($res['code']) && isset($res['msg']) ) {
            echo json_encode( $res );
        }
        else {
            echo json_encode( array('code'=>'0','msg'=>"잠시 후에 다시 시도해주세요.") );
        }
    }
    
    // 중개사 개설 파일업로드 삭제
    public function joinAgentFileDel()
    {
        $uuid = (int)$this->input->post("uuid");
        $imgType = $this->input->post("imgType");
        
        if( $uuid < 1 ) {
            echo json_encode(array('code'=>'404',"msg"=>"파일정보를 찾을 수 없습니다."));
            return;
        }
        else if( !in_array($imgType, array("bizCert", "regCert", 'prfImg')) ) {
            echo json_encode(array('code'=>'405',"msg"=>"파일정보를 찾을 수 없습니다."));
            return;
        }
        
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        $data = $this->getJoinData($cook);
        if( $data[$imgType] != $uuid ) {
            echo json_encode(array('code'=>'500',"msg"=>"파일정보를 찾을 수 없습니다."));
            return;
        }
        
        $qry = $this->db->select ("FILEKEY")->where('IMG_IDX', $data[$imgType])->get('TB_TMP_FOR_JOIN_IMAGE');
        if( $qry->num_rows() < 0 )
        {
            $this->db->set($imgType, "0")->where("COOK", $data['COOK'])->update('TB_TMP_REALTOR_JOIN');
            echo json_encode(array('code'=>'200'));
            return;
        }
        else
        {
            $imginfo = $qry->row_array();
            $this->load->model("S3_model");
            $res = $this->S3_model->delimage($imginfo['FILEKEY']);
            if($res['code'] == 200)
            {
                $this->db->set($imgType, "0")->where("COOK", $data['COOK'])->update('TB_TMP_REALTOR_JOIN');
                $this->db->where("IMG_IDX", $data[$imgType])->delete("TB_TMP_FOR_JOIN_IMAGE");
                echo json_encode(array('code'=>'200'));
                return;
            }
            else
            {
                echo json_encode(array('code'=>'501',"msg"=>"잠시후에 다시 시도해주세요"));
                return;
            }
        }
    }
    
    // 중개사 회원가입 3단계 저장
    public function joinAgent3Save()
    {
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        $joinData = $this->getJoinData($cook);
        
        $DONG_CODE = $this->input->post("dong").'00';
        
        $this->load->helper('security');
        $this->load->library('form_validation');
        $this->form_validation->set_message('xss_clean', '{field} 확인해주세요.');
        $this->form_validation->set_message('required', '{field} 입력해주세요..');
        $config1 = array(
            array('field'=>'sido', 'label'=>'시/도를', 'rules'=>'trim|xss_clean|required', 'errors'=>array('required'=>'시/도를 선택해주세요') ),
            array('field'=>'gugun', 'label'=>'시/도/구를', 'rules'=>'trim|xss_clean|required', 'errors'=>array('required'=>'시/도/구를 선택해주세요')),
            array('field'=>'dong', 'label'=>'읍/면/동을', 'rules'=>'trim|xss_clean|required', 'errors'=>array('required'=>'읍/면/동을 선택해주세요')),
            array('field'=>'brokerofficeidx', 'label'=>'중개사무소를', 'rules'=>'trim|required', 'errors'=>array('required'=>'중개사무소를 선택해주세요')),
            array('field'=>'isCompany', 'label'=>'개인,법인', 'rules'=>'trim|required', 'errors'=>array('required'=>'개인,법인을 선택해주세요')),
            array('field'=>'PHONE', 'label'=>'전화번호를', 'rules'=>'trim|required|numeric|min_length[10]|max_length[12]', 
                  'errors'=>array('required'=>'전화번호를 입력해주세요', "numeric"=>"전화번호는 '-' 없이 숫자만 입력해주세요", "min_length"=>'전화번호를 확인해주세요', "max_length"=>'전화번호를 확인해주세요'))
        );
        $this->form_validation->set_rules($config1);
        if($this->form_validation->run() == FALSE) {
            echo json_encode(array( "code"=>'405', "msg"=>(array_values( $this->form_validation->error_array() )[0])) );
            return;
        }
        else if($joinData['bizCert'] < 1) {
            echo json_encode(array( "code"=>'405', "msg"=>'사업자등록증을 업로드해주세요') );
            return;
        }
        else if($joinData['regCert'] < 1) {
            echo json_encode(array( "code"=>'405', "msg"=>'개설등록증을 업로드해주세요') );
            return;
        }
        
        $saveData = array(
            "SIDO_CODE"=> $this->input->post("sido"),
            "SIGUNGU_CODE"=> $this->input->post("gugun"),
            "DONG_CODE"=> $DONG_CODE,
            "BROKER_OFFICE_INFO_IDX"=> $this->input->post("brokerofficeidx"),
            "isCompany"=> $this->input->post("isCompany"),
            "PHONE"=> $this->input->post("PHONE"),
        );
        
        $saveData['STEP'] = "2";
        $saveData['STEP_STATUS'] ='SAVE';
        $this->db->where('COOK', $joinData['COOK'])->update("TB_TMP_REALTOR_JOIN", $saveData);
        echo json_encode(array("code"=>'200'));
        return;
    }
    
    // 중개사 회원가입 4단계
    public function joinAgent4()
    {
        $joinData['BROKER_OFFICE_NAME'] = '';
        $joinData['LAT'] = '';
        $joinData['LNG'] = '';
        
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        // 실서버만 체크
        if($this->config->item('SERVERSTATE') == 'real') {
            $certName = get_cookie('certName', true);
        }
        
        $joinData = $this->getJoinData($cook);
        
        $joinData['certState'] = "X";
        
        // 실서버만 체크
        /*
        if($this->config->item('SERVERSTATE') == 'real')
        {
            if(get_cookie('certName', true) != '')
            {
                if(get_cookie('certName', true) == $joinData['BROKER_NAME']) {
                    $joinData['certState'] = "Y";
                }
                else {
                    $joinData['certState'] = "N";
                    $joinData['MOBILE_NO'] = "";
                    $this->input->set_cookie('certName', '', 0);
                }
            }
        }
        */
        
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent4', $joinData);
        $this->load->view('sub_footer');
    }
    
    // 중개사 회원가입 4단계 인증 정보
    function joinAgent4CertInfo()
    {
        $module = 'CPClient';
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $authtype = "M";
        $popgubun 	= "N";
        $customize 	= "";
        $gender = "";
        $reqseqagent = get_cprequest_no($niceCfg['site']);
        $niceReturnHost =((!isset($_SERVER['HTTPS']) ||$_SERVER['HTTPS'] != "on") ? "http://" : "https://" ).$_SERVER['HTTP_HOST'];
        
        $returnagenturl = $niceReturnHost."/agent/nice";	// 성공시 이동될 URL
        $erroragenturl = $niceReturnHost."/agent/fail";		// 실패시 이동될 URL
        
        $plaindata = "7:REQ_SEQ" . strlen($reqseqagent) . ":" . $reqseqagent .
        "8:SITECODE" . strlen($niceCfg['site']) . ":" . $niceCfg['site'] .
        "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
        "7:RTN_URL" . strlen($returnagenturl) . ":" . $returnagenturl .
        "7:ERR_URL" . strlen($erroragenturl) . ":" . $erroragenturl .
        "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
        "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
        "6:GENDER" . strlen($gender) . ":" . $gender ;
        $enc_data = get_encode_data($niceCfg['site'], $niceCfg['pw'], $plaindata);
        
        session_start();
        $sessionagentdata = array("REQ_SEQ"=>$reqseqagent);
        $this->session->set_userdata($sessionagentdata);
        
        echo json_encode(array("code"=>"100", "res"=>$enc_data));
        return;
    }
    
    // 중개사 회원가입 4단계 저장
    function joinAgent4Save()
    {
        if( $this->is_login ) {
            echo json_encode( array("code"=>"404", "msg"=>"이미 로그인 중입니다"));
            return;
        }
        
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        $joinData = $this->getJoinData($cook);
        if( $joinData['niceHistoryIdx'] < 1 ) {
            echo json_encode(array("code"=>"501","msg"=>"핸드폰 인증후 진행해주세요"));
            return;
        }
        
        $this->load->model("member_model");
        
        $saveData = array(
            "email"=> $this->input->post("email", true),
            "passwd"=>$this->member_model->makePassword($this->input->post("passwd", true)),
            "career"=>htmlentities($this->input->post("career", true), ENT_QUOTES | ENT_IGNORE, "UTF-8")
        );
              
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array("code"=>"400", "msg"=>"아이디(이메일)를 입력해주세요.","error"=>validation_errors() ));
            return;
        }
        else
        {
            $res = $this->member_model->joininfocheck( $this->input->post('email') );
            if( $res == 'Y' ) {
                echo json_encode( array("code"=>"20", "msg"=>"이미 사용중인 아이디(이메일)입니다."));
                return;
            }
        }
        
        if( $this->input->post("passwd", true) != $this->input->post("passwd_confirm", true) ) {
            echo json_encode( array("code"=> 21, "msg"=>"비밀번호를 확인해주세요"));
            return;
        }
        else {
            $pattern = '/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z]).*$/';
            if(!preg_match($pattern ,$this->input->post("passwd"))) {
                echo json_encode( array("code"=>"23", "msg"=>"비밀번호는 영문,숫자를 포함하여 8~15자로 적어주세요"));
                return;
            }
        }
        
        if( $joinData['prfImg'] < 1 ) {
            echo json_encode( array("code"=>"24", "msg"=>"프로필 사진을 올려주세요"));
            return;
        }
        
        $saveData = array(
            "email"=>$this->input->post("email", true), 
            "passwd"=>$this->member_model->makePassword($this->input->post("passwd", true)), 
            "career"=>htmlentities($this->input->post("career", true), ENT_QUOTES | ENT_IGNORE, "UTF-8")
        );
        
        $saveData['STEP'] = "3";
        $saveData['STEP_STATUS'] ='SAVE';
        
        $this->db->where('COOK', $joinData['COOK'])->update('TB_TMP_REALTOR_JOIN', $saveData);
        if($this->makeBrokerId() == true) echo json_encode( array("code"=>"200") );
        else echo json_encode( array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요") );
    }
    
    // 중개사 회원가입 5단계
    public function joinAgent5()
    {
        $data['phone'] = $this->uri->segment(3);
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 실서버만 체크
        if($this->config->item('SERVERSTATE') == 'real')
        {
            $this->load->helper('cookie');
            $this->input->set_cookie('certName', '', 0);
        }
        
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent5', $data);
        $this->load->view('sub_footer');
    }
    
    // 가입문자발송
    public function joinSMSproc()
    {
        $MOBILE_NO = $this->input->post("phone");
        
        $this->load->library('sendsms', array("private_info"=>$MOBILE_NO));
        $this->sendsms->send("join");
        echo "COMPLETE";
    }
    
    // 중개사 회원가입 완료
    public function joinAgentResult()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->helper('cookie');
        $this->input->set_cookie('skdicysw1b5dtrt', '', 0);
        $this->input->set_cookie('certName', '', 0);
        
        $this->load->view('sub_header');
        $this->load->view('agent/joinAgent6', $data);
        $this->load->view('sub_footer');
    }
    
    function makeBrokerId()
    {
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        
        $this->load->model("member_model");
        $data = $this->getJoinData($cook);
        $res = $this->member_model->makeBrokerId($data);
        $this->member_model->deleteBrokerTemp($data);
        return $res;
    }
    
    //--------------------------------------------------------------//
    
    // 인증
    function nice()
    {        
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $enc_data = $_POST['EncodeData'];
        
        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match) || $enc_data == "" || base64_encode(base64_decode($enc_data))!=$enc_data )
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요", "url"=>"/agent/joinAgent4") );
            $this->load->view('sub_footer');
            return;
        } // 문자열 점검 추가.
        
        $plaindata = get_decode_data($niceCfg['site'], $niceCfg['pw'], $enc_data);
        if($plaindata < 0)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요(".$plaindata.")", "url"=>"/agent/joinAgent4") );
            $this->load->view('sub_footer');
            return;
        }
        $data = $this->getNiceValue($plaindata);
        if( isset($data['NAME']) ) unset($data['NAME']);
        if( isset($data["UTF8_NAME"]) ) $data["UTF8_NAME"] = urldecode( $data["UTF8_NAME"]);
        
        /*
        $sessionagentdata = $this->session->userdata('REQ_SEQ') ;
        if(strcmp($sessionagentdata, $data['REQ_SEQ']) != 0)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"올바른 경로로 접근하시기 바랍니다.", "url"=>"/") );
            $this->load->view('sub_footer');
            return;
        }
        */
        
        // 실서버만 체크
        if($this->config->item('SERVERSTATE') == 'real')
        {
            $this->load->helper('cookie');
            $this->input->set_cookie('certName', $data["UTF8_NAME"], 0);
        }
        
        $cook = $this->cook();
        $data['MBR_IDX'] = 0;
        $this->db->trans_begin();
        $this->db->insert("TB_HISTORY_NICE", $data);
        $this->db->set('niceHistoryIdx', $this->db->insert_id())->where('COOK', $cook)->update('TB_TMP_REALTOR_JOIN');
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요.", "url"=>"/agent/joinAgent4") );
            $this->load->view('sub_footer');
            return;
        }
        else {
            $this->db->trans_commit();
            $this->load->view('sub_header');
            $this->load->view("nice", array("url"=>"/agent/joinAgent4") );
            $this->load->view('sub_footer');
            return;
        }
    }
    
    // 인증 실패
    function fail()
    {
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요.", "url"=>"/agent/joinAgent4") );
        $this->load->view('sub_footer');
        return;
    }
    
    // 쿠키
    function cook()
    {
        $this->load->helper('cookie');
        $cook = get_cookie('skdicysw1b5dtrt', true);
        if(!$cook) {
            $this->load->helper('string');
            $cook = date("dHy").random_string('alnum',20).date("msi");
        }

        $this->input->set_cookie('skdicysw1b5dtrt', $cook, '259200');
        $this->db->query("insert IGNORE into TB_TMP_REALTOR_JOIN (`COOK`) values( ? )", array($cook));
        return $cook;
    }
    
    function getJoinData($cook)
    {
        //$cook = $this->cook();
        $sql = "SELECT
                    tr.*, 
                    b.BROKER_OFFICE_NAME, b.FULL_ADDR, b.LAT, b.LNG, b.BROKER_NAME,
                    biz.IMG_FULL_PATH AS bizFullPath, 
                    reg.IMG_FULL_PATH AS regFullPath, 
                    prf.IMG_FULL_PATH AS prfFullPath, 
                    nc.MOBILE_NO, nc.UTF8_NAME, nc.nice_reg_date as CERTIFICATED_DATE, 
                    nc.BIRTHDATE, nc.GENDER
                FROM TB_TMP_REALTOR_JOIN tr
                LEFT JOIN TB_AB_BROKER_OFFICE_INFO b ON tr.BROKER_OFFICE_INFO_IDX = b.BROKER_OFFICE_INFO_IDX
                LEFT JOIN TB_TMP_FOR_JOIN_IMAGE biz ON tr.bizCert = biz.IMG_IDX
                LEFT JOIN TB_TMP_FOR_JOIN_IMAGE reg ON tr.regCert = reg.IMG_IDX
                LEFT JOIN TB_TMP_FOR_JOIN_IMAGE prf ON tr.prfImg = prf.IMG_IDX
                LEFT JOIN TB_HISTORY_NICE nc ON tr.niceHistoryIdx = nc.idx
                WHERE tr.COOK = ?";
        return $this->db->query ($sql, array("COOK"=>$cook))->row_array();
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
}
