<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends MY_Controller
{    
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
    
    public function _remap($method)
    {
        parent::_remap('child_renmap');
        
        $this->load->helper("goods_helper");
        
        // 비로그인상태
        if( !$this->is_login ) {
            $data['msg'] = "로그인이 필요한 페이지 입니다.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // 일반회원이 아니면 메인으로
        /*if( $this->userinfo['MBR_GUBUN'] !='PU' )
        {
            $data['url'] = "/";
            $this->load->view("alert", $data);
            return;
            exit;
        }*/
                
        $this->{$method}();
    }
    
    public function index(){
        // my page
    }
        
    //--------------------------------------------------------------//
    
    // 휴면계정안내 페이지
    public function dormancy()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('mypage/dormancy', $data);
        $this->load->view('sub_footer');
    }
    
    // 휴면계정안내 이메일 발송
    public function dormancyemail()
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
    
    // 휴면계정 메일발송 페이지
    public function dormancyresult()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('mypage/dormancyresult', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 내정보 페이지
    function myinfo()
    {
        // 일반회원이 아니면 메인으로
        if($this->userinfo['MBR_GUBUN'] != 'PU')
        {
            $data['url'] = "/";
            $data['msg'] = "모바일 중개사마이페이지 준비중입니다.";
            $this->load->view("alert", $data);
            return;
            exit;
        }
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $module = 'CPClient';
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $authtype = "M";
        $popgubun = "N";
        $customize = "";
        $gender = "";
        $reqseq = get_cprequest_no($niceCfg['site']);
        $niceReturnHost =((!isset($_SERVER['HTTPS']) ||$_SERVER['HTTPS'] != "on") ? "http://" : "https://" ).$_SERVER['HTTP_HOST'];
        
        $returnurl = $niceReturnHost."/mypage/changeHpPrc";	// 성공시 이동될 URL
        $errorurl = $niceReturnHost."/mypage/changeHp";		// 실패시 이동될 URL
        
        $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
        "8:SITECODE" . strlen($niceCfg['site']) . ":" . $niceCfg['site'] .
        "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
        "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
        "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
        "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
        "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
        "6:GENDER" . strlen($gender) . ":" . $gender ;
        $data['enc_data'] = get_encode_data($niceCfg['site'], $niceCfg['pw'], $plaindata);
        session_start();
        $sessiondata = array("REQ_SEQ"=>$reqseq);
        $this->session->set_userdata($sessiondata);
        
        // 정보체크
        $sql = "SELECT MBR_CP FROM TB_UB_MEMBER WHERE MBR_IDX='".$this->userinfo['MBR_IDX']."'";
        $qry = $this->db->query($sql);
        $info = $qry->row_array();
        $data['MBR_CP'] = $info['MBR_CP']; 
        
        $this->load->view('sub_header');
        $this->load->view('mypage/myinfo', $data);
        $this->load->view('sub_footer');
    }
    
    // 휴대폰 인증 및 번호 변경
    function changeHp()
    {
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"휴대폰 인증에 실패하였습니다.", "url"=>"/mypage/myinfo") );
        $this->load->view('sub_footer');
        return;
    }
    
    // 휴대폰 인증 및 번호 변경 처리
    function changeHpPrc()
    {
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $enc_data = $_POST['EncodeData'];
                
        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match) || $enc_data == "" || base64_encode(base64_decode($enc_data))!=$enc_data)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요", "url"=>"/mypage/myinfo") );
            $this->load->view('sub_footer');
            return;
        } // 문자열 점검 추가.
        
        $plaindata = get_decode_data($niceCfg['site'], $niceCfg['pw'], $enc_data);
        if($plaindata < 0)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요(".$plaindata.")", "url"=>"/mypage/myinfo") );
            $this->load->view('sub_footer');
            return;
        }
        
        $data = $this->getNiceValue($plaindata);
        if( isset($data['NAME']) ) unset($data['NAME']);
        if( isset($data["UTF8_NAME"]) ) $data["UTF8_NAME"] = urldecode( $data["UTF8_NAME"]);
                
        $sessiondata = $this->session->userdata('REQ_SEQ') ;
        if(strcmp($sessiondata , $data['REQ_SEQ']) != 0)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"올바른 경로로 접근하시기 바랍니다.", "url"=>"/") );
            $this->load->view('sub_footer');
            return;
        }
        
        $qry = $this->db->where("DI",$data['DI'])->where("MBR_IDX",$this->userinfo['MBR_IDX'])->limit("1")->get("TB_HISTORY_NICE");
        if( $qry->num_rows() > 0 )
        {
            $data['MBR_IDX']= $this->userinfo['MBR_IDX'];
            $this->db->trans_begin();
            $this->db->insert("TB_HISTORY_NICE", $data);
            $this->db->set('MBR_CP',$data['MOBILE_NO'])->where('MBR_IDX', $this->userinfo['MBR_IDX'])->update("TB_UB_MEMBER");
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->load->view('sub_header');
                $this->load->view("nice", array("msg"=>"죄송합니다.\n잠시후에 다시 시도해주세요.", "url"=>"/mypage/myinfo") );
                $this->load->view('sub_footer');
                return;
            }
            else
            {
                $this->db->trans_commit();
                $this->load->view('sub_header');
                $this->load->view("nice", array("url"=>"/mypage/myinfo") );
                $this->load->view('sub_footer');
                return;
            }
        }
        else
        {
            $data['MBR_IDX']= $this->userinfo['MBR_IDX'];
            $this->db->trans_begin();
            $this->db->insert("TB_HISTORY_NICE", $data);
            $MBR_CP_FLAG = 'Y';
            $MBR_CP_CERTIFICATED_DATE = date('Y-m-d H:i:s');
            $meminfo = array('MBR_NAME'=>$data['UTF8_NAME'], 'MBR_CP'=>$data['MOBILE_NO'], 'MBR_CP_FLAG'=>$MBR_CP_FLAG, 'MBR_CP_CERTIFICATED_DATE'=>$MBR_CP_CERTIFICATED_DATE, 'MBR_BIRTH'=>$data['BIRTHDATE'], 'MBR_GENDER'=>$data['GENDER']);
            $this->db->where('MBR_IDX', $this->userinfo['MBR_IDX'])->update("TB_UB_MEMBER", $meminfo);
            if($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->load->view('sub_header');
                $this->load->view("nice", array("msg"=>"죄송합니다.\n잠시후에 다시 시도해주세요.", "url"=>"/mypage/myinfo") );
                $this->load->view('sub_footer');
                return;
            }
            else
            {
                $this->db->trans_commit();
                $this->load->view('sub_header');
                $this->load->view("nice", array("url"=>"/mypage/myinfo") );
                $this->load->view('sub_footer');
                return;
            }
        }
    }
    
    // 휴대폰 인증 및 번호 변경 값 체크
    function getNiceValue($str)
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
    
    //--------------------------------------------------------------//
    
    // 집구하기 -> 찜한매물 페이지
    function myzzimsale()
    {
        // 일반회원이 아니면 메인으로
        if($this->userinfo['MBR_GUBUN'] != 'PU')
        {
            $data['url'] = "/";
            $data['msg'] = "모바일 중개사마이페이지 준비중입니다.";
            $this->load->view("alert", $data);
            return;
            exit;
        }
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model("mypage_model");
        $data['favorite'] = $this->mypage_model->getMyFavorite($this->userinfo['MBR_IDX']);
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_zzimsale', $data);
        $this->load->view('sub_footer');
    }
    
    // 집구하기 -> 내계약매물 페이지
    function mycontractsale()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model("mypage_model");
        $data['contract'] = $this->mypage_model->getMyContractGoods($this->userinfo['MBR_IDX']);
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_contractsale', $data);
        $this->load->view('sub_footer');
    }
    
    // 집구하기 -> 내계약매물 평가 페이지
    function mycontractsaleappraise()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_contractsale_appraise', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 집내놓기
    function myhousesale()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        // 일반회원이 아니면 메인으로
        if($this->userinfo['MBR_GUBUN'] != 'PU')
        {
            $data['url'] = "/";
            $data['msg'] = "모바일 중개사마이페이지 준비중입니다.";
            $this->load->view("alert", $data);
            return;
            exit;
        }
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
                
        $this->load->model('mypage_model');
        $data['items'] =  $this->mypage_model->getMySellGoods($this->userinfo['MBR_IDX']) ;
        
        // 룸타입
        $this->load->model("sellhome_model");
        $rows = $this->sellhome_model->getCodeList('ROOM_TYPE');
        foreach ( $rows as $row ){
            $data['ROOM_TYPE'][$row['CODE_DETAIL']]   = $row['CODE_NAME'];
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_housesale', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 매물등록요청 취소
    function myhousesellcancel()
    {
        $idx = $this->input->post('idx');
        $reson_code = $this->input->post("reson", true);
        $etc=trim($this->input->post("etc", true));
        
        if($idx < 1) {
            echo json_encode(array("code"=>"405","msg"=>"필수값이 존재하지 않습니다. 다시 확인해 주세요."));
            return;
        }
        
        $qry = $this->db->get_where("TB_UM_GOODS", array("GOODS_IDX"=>$idx, "REG_MBR_IDX"=>$this->userinfo['MBR_IDX']), 1);
        if( $qry->num_rows() < 1) {
            echo json_encode(array("code"=>"520","msg"=>"요청하신 데이터가 존재하지 않습니다. 다시 확인해 주세요!"));
            return;
        }
        
        $item = $qry->row_array();
        if($item['GOODS_STATUS'] == 'TR' || $item['GOODS_STATUS'] == 'RC') {
            echo json_encode(array("code"=>"521","msg"=>"이미 삭제하신 매물입니다."));
            return;
        }
        else if($item['GOODS_STATUS'] == 'SB') {
            echo json_encode(array("code"=>"501","msg"=>"이미 등록완료된 매물입니다.\n페이지를 새로고침 해주세요"));
            return;
        }
        else if($item['GOODS_STATUS'] != 'BL') {
            echo json_encode(array("code"=>"501","msg"=>"페이지를 새로고침 해주세요"));
            return;
        }
        else if($reson_code == 'ETC' && $etc == '') {
            echo json_encode(array("code"=>"400","msg"=>"기타 사유를 적어주세요"));
            return;
        }
        else
        {
            if($reson_code == 'ETC') $reson = $etc;
            else {
                $this->load->model("goods_model");
                $reson = $this->goods_model->getCodeName( 'GOODS_REG_CANCEL', $reson_code );
            }
            
            $now = new DateTime('now', new DateTimeZone('Asia/Seoul'));
            $this->db->trans_start();
            $this->db->set('GOODS_STATUS',"RC")->set("GOODS_PROCESS_STATUS","PS2")->set("GOODS_STATUS_CHG_DATE",$now->format("Y-m-d"))->
            set("DELETED_DATE",$now->format("Y-m-d"))->where("GOODS_IDX",$idx)->update("TB_UM_GOODS");
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE) {
                echo json_encode(array("code"=>"500","msg"=>"잠시 후에 다시 시도해 주세요!"));
                return;
            }
            else {
                echo json_encode(array("code"=>"200","msg"=>"등록요청취소가 완료 되었습니다."));
                return;
            }
        }
    }
    
    // 집내놓기 삭제
    function myhousedelete()
    {
        $data['idx'] = $this->uri->segment(3);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $sql = "SELECT * FROM TB_CB_CODE WHERE CODE_GBN='GOODS_DEL_REQUEST' AND CODE_DETAIL!='' ORDER BY SORT_ORDER ASC";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) $data['goods_del'] = $qry->result_array();
        else $data['goods_del'] = array();
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_housedelete', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 삭제 처리
    function myhousedeleteproc()
    {
        $idx = (int)$this->input->post("idx");
        $reson_code = $this->input->post("reson", true);
        $etc = trim($this->input->post("etc", true));
        
        if($idx < 1) {
            echo json_encode(array("code"=>"405", "msg"=>"잠시후에 다시 시도해주세요"));
            return;
        }
        
        $qry = $this->db->get_where("TB_UM_GOODS", array("GOODS_IDX"=>$idx, "REG_MBR_IDX"=>$this->userinfo['MBR_IDX']), 1);
        if( $qry->num_rows() < 1 ) {
            echo json_encode(array("code"=>"520", "msg"=>"잠시후에 다시 시도해주세요"));
            return;
        }
        $item = $qry->row_array();
        if( $item['GOODS_STATUS'] == 'CF' ) {
            echo json_encode(array("code"=>"500", "msg"=>"이미 삭제요청중 입니다.\n페이지를 새로고침 해주세요"));
            return;
        }
        else if( $item['GOODS_STATUS'] == 'TR' ) {
            echo json_encode(array("code"=>"521", "msg"=>"이미 삭제하신 매물입니다."));
            return;
        }
        else if( $item['GOODS_STATUS'] != 'SB' ) {
            echo json_encode(array("code"=>"500", "msg"=>"삭제요청이 불가능한 상태입니다\n페이지를 새로고침 해주세요"));
            return;
        }
        else if( $reson_code=='ETC' && $etc=='' ) {
            echo json_encode(array("code"=>"400", "msg"=>"기타 사유를 적어주세요"));
            return;
        }
        else
        {
            $reson = '';
            if($reson_code == 'ETC') $reson = $etc;
            $this->load->model("Goods_model");
            $res= $this->Goods_model->checkInCode( $reson_code, 'GOODS_DEL_REQUEST' );
            if(!$res) {
                echo json_encode(array("code"=>"520", "msg"=>"잠시후에 다시 시도해주세요"));
                return;
            }
            $now = new DateTime('now', new DateTimeZone('Asia/Seoul'));
            $this->db->trans_start();
            $this->db->set('GOODS_STATUS',"TR")->set("GOODS_STATUS_CHG_DATE",$now->format("Y-m-d"))->where("GOODS_IDX",$idx)->update("TB_UM_GOODS");
            $this->db->insert("TB_UM_GOODS_DEL_REQUEST", array("GOODS_IDX"=>$idx, "REQ_OPT_REASON"=>$reson_code, "REQ_ETC_REASON"=>$reson,"REQ_MBR_IDX"=>$this->userinfo['MBR_IDX']));
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE) {
                echo json_encode(array("code"=>"500","msg"=>"잠시 후에 다시 시도해주세요"));
                return;
            }
            else {
                echo json_encode(array("code"=>"200"));
                return;
            }
        }
    }
    
    // 집내놓기 중개사 평가 하기
    function evaluation()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $data['evaltype'] = $this->input->get("evaltype");
        $data['broker_idx'] = (int)($this->input->get("broker_idx"));
        $data['goods_idx'] = (int)($this->input->get("goods_idx"));
        
        /* TODO 검증 */
        $this->load->view('sub_header');
        $this->load->view('mypage/my_broker_evaluate', $data);
        $this->load->view('sub_footer');
    }
    
    // 중개사무소 평가 처리
    function realtoreval()
    {
        $data['GOODS_IDX'] = (int)$this->input->post('goods_idx');
        $data['BROKER_OFFICE_IDX'] = (int)$this->input->post('broker_idx');
        $data['MBR_IDX'] = $this->userinfo['MBR_IDX'];
        $data['MBR_CP'] = $this->userinfo['MBR_CP'];
        $data['EVAL_TYPE'] = $this->input->post('evaltype');
        $data['RATE1'] = (int)$this->input->post('star_input1');
        $data['RATE2'] = (int)$this->input->post('star_input2');
        $data['RATE3'] = (int)$this->input->post('star_input3');
        $data['RATE4'] = (int)$this->input->post('star_input4');
        $data['RATE5_YN'] = $this->input->post('paym') == 'Y' ? 'Y':'N';
        
        $data['TOT_RATE'] = (($data['RATE1'] + $data['RATE2'] + $data['RATE3']+$data['RATE4']) * 0.2) + ( ($data['RATE5_YN']=='N') ? 1:0 );
        
        $data['RATE_REASON'] = htmlspecialchars($this->input->post('etc', true), ENT_QUOTES);
        $cnt = $this->db->query("select ifnull( count(1) , 0 ) cnt from TB_UA_BROKER_EVALUATION where GOODS_IDX=? and MBR_IDX=?", array($data['GOODS_IDX'], $data['MBR_IDX']))->row_array();
        if( $cnt['cnt'] > 0 ) echo json_encode( array("code"=>"420", "msg"=>"이미 평가 하셨습니다.") );
        else if( !in_array($data['RATE5_YN'], array('Y','N')) ) echo json_encode(array("code"=>"500"));
        else {
            $this->db->insert('TB_UA_BROKER_EVALUATION', $data);
            $code = $this->db->affected_rows() > 0 ? "200" : "501";
            echo json_encode(array("code"=>$code));
        }
    }
    
    //--------------------------------------------------------------//
    
    // 수정할 매물 상태
    private function chkGoodsSTatus($goods_idx, $json=false)
    {
        $this->load->model("sellhome_model");
        $goods_info = $this->sellhome_model->goodsInfo($goods_idx);
        
        if( isset($goods_info['MAP_XY']) ) unset($goods_info['MAP_XY']);
        if( $goods_info['AREA2'] <= 0 ) $goods_info['AREA2'] = $goods_info['AREA1'];
        if( $goods_info['AREA1'] <= 0 ) $goods_info['AREA1'] = $goods_info['AREA2'];
        if( $goods_info === false ) {
            if($json) echo json_encode(array("code"=>"404", "msg"=>"매물을 찾을 수 없습니다"));
            else echo $this->load->view("alert", array("msg"=>"매물을 찾을 수 없습니다.","url"=>"/"), true);
            exit;
        }
        
        if( !in_array($goods_info['GOODS_STATUS'], array("BL","SB")) )
        {
            if($json) echo json_encode(array("code"=>"501", "msg"=>"현재 매물은 더 이상 수정 할 수 없습니다"));
            else echo $this->load->view("alert", array("msg"=>"현재 매물은 더 이상 수정 할 수 없습니다.","url"=>"/"), true);
            exit;
        }
        
        if( $goods_info['REG_MBR_IDX'] != $this->userinfo['MBR_IDX'] )
        {
            if($json) echo json_encode(array("code"=>"500", "msg"=>"매물 정보를 수정할 수 없습니다"));
            else echo $this->load->view("alert", array("msg"=>"매물 정보를 수정할 수 없습니다.","url"=>"/"), true);
            exit;
        }
        
        return $goods_info;
    }
    
    // 집내놓기 매물정보 1단계 수정
    function step1_modify()
    {
        $goods_idx = $this->uri->segment(3);
        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model("sellhome_model");
        
        if($goods_info['COMPLEX_IDX'] > 0) {
            $data['COMPLEX_INFO_ARR'] = $this->sellhome_model->getComplexDHinfo( $goods_info['COMPLEX_IDX'], $goods_info['CATEGORY'] );
        }
        
        $data['step_1'] = $goods_info;
        $data['ROOM_TYPE'] = $this->sellhome_model->getCodeList('ROOM_TYPE');
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelListMdf', '', 0);
        $this->input->set_cookie('brokerSelListMdfStart', '', 0);
        
        $this->load->view('sub_header');
        $this->load->view('mypage/step1_modify', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 매물정보 1단계 수정 저장
    function step1_modify_save()
    {
        $goods_info = $this->chkGoodsSTatus((int)$this->input->post("idx"), true);
        $data['PRICE1'] = $data['PRICE2'] = $data['PRICE3'] = 0;
        
        $data['REG_TYPE'] = $this->input->post('REG_TYPE');
        $data['OWNER_CP'] = $this->input->post('OWNER_CP');
        $data['CATEGORY'] = $this->input->post('CATEGORY');
        
        if($data['CATEGORY'] == 'APT' || $data['CATEGORY'] == 'OFT')
        {
            // 아파트, 오피스텔
            $data['LAW_SIDO_CODE'] = $this->input->post('SIDO_CODE');
            $data['LAW_SIGUNGU_CODE'] = $this->input->post('SIGUNGU_CODE');
            $data['LAW_DONG_CODE'] = $this->input->post('DONG_CODE');
            $data['COMPLEX_IDX'] = $this->input->post('COMPLEX_IDX');
            $data['DONG'] = $this->input->post('DONG');
            $data['FLOOR'] = $this->input->post('FLOOR');
            $data['AREA1'] = $this->input->post('AREA1');
            $data['dongNm'] = $this->input->get_post('dongNm');
            $data['AREA_SELECTED'] = $this->input->get_post('AREA_SELECTED');
            
            if ( isset($data['AREA_SELECTED'])) {
                $data['SPACE_IDX'] = $data['AREA_SELECTED'];
                unset( $data['AREA_SELECTED'] );
            }
            if ( isset($data['dongNm']) ) unset( $data['dongNm']);
            
            if($data['CATEGORY'] == 'OFT') {
                $data['ROOM_TYPE'] = $this->input->post('ROOM_TYPE');
            }
        }
        
        if($data['CATEGORY'] == 'ONE')
        {
            // 원룸 주소검색
            $data['LAW_ADDR1'] = $this->input->post('LAW_ADDR1');
            $data['LAW_DONG_CODE'] = $this->input->post('LAW_DONG_CODE');
            $data['LAW_ADDR2'] = $this->input->post('LAW_ADDR2');
            $data['FLOOR'] = $this->input->post('FLOOR');
            $data['ROOM_TYPE'] = $this->input->post('ROOM_TYPE');
        }
        
        // 아파트, 오피스텔, 원룸 공통
        $data['TOTAL_FLOOR'] = $this->input->post('TOTAL_FLOOR');
        $data['AREA2'] = $this->input->post('AREA2');
        $data['LAT'] = $this->input->post('LAT');
        $data['LNG'] = $this->input->post('LNG');
        $data['HO'] = $this->input->post('HO');
        
        $data['SPACE_IDX'] = $this->input->post('AREA_SELECTED');
        
        $data['TRADE_TYPE'] = $this->input->post('TRADE_TYPE');    // 매물유형
        
        // 매매선택
        if($data['TRADE_TYPE'] == '1') {
            $data['PRICE1'] = $this->input->post('PRICE1');            // 매매희망가
        }
        
        // 전세 및 월세 선택
        if($data['TRADE_TYPE'] == '2' || $data['TRADE_TYPE'] == '3') {
            $data['PRICE2'] = $this->input->post('PRICE2');            // 전세 및 월세 보증금 희망가
        }
        
        // 월세선택
        if($data['TRADE_TYPE'] == '3') {
            $data['PRICE3'] = $this->input->post('PRICE3');            // 월세가
        }
        
        if( $this->db->where("GOODS_IDX",$goods_info['GOODS_IDX'])->update("TB_UM_GOODS", $data) ) echo json_encode(array("code"=>"200"));
        else echo json_encode(array("code"=>"502"));
    }
    
    // 집내놓기 매물정보 2단계 수정
    function step2_modify()
    {
        $goods_idx = $this->uri->segment(3);
        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model("sellhome_model");
        if($goods_info['COMPLEX_IDX'] > 0) {
            $data['COMPLEX_INFO_ARR'] = $this->sellhome_model->getComplexDHinfo( $goods_info['COMPLEX_IDX'], $goods_info['CATEGORY'] );
        }
        
        $data['step2'] = $goods_info;
        
        $data['ARR_DIRECTIONS'] = $this->sellhome_model->getCodeList('ARR_DIRECTIONS');
        $data['ARR_GOODS_FEATURES'] = $this->sellhome_model->getCodeList('GOODS_FEATURES',$goods_info['CATEGORY']);
        $data['goods_option'] = $this->sellhome_model->goodsOptionList($goods_info['CATEGORY']);
        $data["goods_option_selected"] = array();
        if( isset($goods_info['OPTIONS']) && $goods_info['OPTIONS'] !='')
        {
            $tmparr = explode(",", $goods_info['OPTIONS']);
            if( count($tmparr) > 0 ) {
                foreach( $tmparr as $idx=>$val ) {
                    $data["goods_option_selected"][]=trim($val);
                }
            }
        }
        
        $data["goods_feature_selected"] = array();
        if( isset($data['step2']['GOODS_FEATURE']) && $data['step2']['GOODS_FEATURE'] !='')
        {
            $tmparr = explode(",", $data['step2']['GOODS_FEATURE']);
            if( count($tmparr)>0 ) {
                foreach( $tmparr as $idx=>$val ) {
                    $data["goods_feature_selected"][]=trim($val);
                }
            }
        }
        
        $this->load->config("dawin");
        $data['expense_item_arr'] = $this->config->item('EXPENSE_ITEM');
        $data["expense_item_selected"] = array();
        if( isset($data['step2']['EXPENSE_ITEM']) && $data['step2']['EXPENSE_ITEM'] !='') {
            $tmparr = explode("|", $data['step2']['EXPENSE_ITEM']);
            if( count($tmparr) > 0 ) {
                foreach( $tmparr as $idx=>$val ) {
                    $data["expense_item_selected"][]=trim($val);
                }
            }
        }
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelListMdf', '', 0);
        $this->input->set_cookie('brokerSelListMdfStart', '', 0);
                
        $this->load->view('sub_header');
        $this->load->view('mypage/step2_modify', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 매물정보 2단계 수정 저장
    function step2_modify_save()
    {
        $goods_info = $this->chkGoodsSTatus( (int)$this->input->post("idx"), true );
        
        if ( $this->input->post('ENTER_TYPE') !='' && !in_array($this->input->post('ENTER_TYPE'), array("1","2","3") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"입주희망일을 선택해주세요" ));
            return;
        }
        else $data['ENTER_TYPE'] = $this->input->post('ENTER_TYPE') ;
        
        if( $this->input->post('ENTER_TYPE')=='3' )
        {
            $chkdate = $this->chkdateformat( $this->input->post('ENTER_DATE') );
            if($chkdate['code'] == false) {
                echo json_encode(array( "code"=>"405", "msg"=>$chkdate['msg'] ));
                return;
            }
            $data['ENTER_DATE'] = $chkdate['data'];
        }
        
        if( $this->input->post('OWNER_LIVE')!='' && !in_array($this->input->post('OWNER_LIVE'), array("1","2","3") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"거주상태를 확인해주세요" ));
            return;
        }
        
        $data['OWNER_LIVE'] = $this->input->post('OWNER_LIVE');
        if( $this->input->post('DIRECTION')!='' && !$this->check_inCode($this->input->post('DIRECTION'),'DIRECTION','A' ) ) {
            echo json_encode(array("code"=>"405", "msg"=>"방향을 확인해주세요"));
            return;
        }
        
        $data['DIRECTION'] = $this->input->post('DIRECTION');
        if( $this->input->post('BALCONY')!='' && !in_array($this->input->post('BALCONY'), array("1","2","0") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"발코니를 확인해주세요" ));
            return;
        }
        
        $data['BALCONY'] = $this->input->post('BALCONY');
        if( $this->input->post('ANIMAL')!='' && !in_array($this->input->post('ANIMAL'), array("1","2") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"반려동물 가능여부를 확인해주세요" ));
            return;
        }
        
        $data['ANIMAL'] = $this->input->post('ANIMAL');
        if( $this->input->post('EXPENSE')!='' && (int)$this->input->post('EXPENSE')!= $this->input->post('EXPENSE') ) {
            echo json_encode(array( "code"=>"405", "msg"=>"관리비를 확인해주세요" ));
            return;
        }
        
        $data['EXPENSE'] = $this->input->post('EXPENSE');
        if( isset($_POST['EXPENSE_ITEM']) && is_array($_POST['EXPENSE_ITEM']) ) {
            $data['EXPENSE_ITEM'] = implode("|", $_POST['EXPENSE_ITEM']);
        }
        else $data['EXPENSE_ITEM']='';
        
        if((int)$this->input->post('ROOM_CNT') > 0) $data['ROOM_CNT'] =(int)$this->input->post('ROOM_CNT');
        if((int)$this->input->post('BATHROOM_CNT') > 0) $data['BATHROOM_CNT'] =(int)$this->input->post('BATHROOM_CNT');
        
        if( $this->input->post('PARKING_FLAG')!='' && !in_array($this->input->post('PARKING_FLAG'), array("Y","N") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"주차가능여부를 확인해주세요" ));
            return;
        }
        
        $data['PARKING_FLAG'] = $this->input->post('PARKING_FLAG');
        if( $this->input->post('HEAT_TYPE')!='' && !in_array($this->input->post('HEAT_TYPE'), array("P","C") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"난방방식을 확인해주세요" ));
            return;
        }
        
        $data['HEAT_TYPE'] = $this->input->post('HEAT_TYPE');
        if( $this->input->post('ELEVATOR_FLAG')!='' && !in_array($this->input->post('ELEVATOR_FLAG'), array("Y","N") ) ) {
            echo json_encode(array( "code"=>"405", "msg"=>"엘리베이터 유무를 확인해주세요" ));
            return;
        }
        
        $data['ELEVATOR_FLAG'] = $this->input->post('ELEVATOR_FLAG');
        if(isset($_POST['OPTIONS']) &&is_array($_POST['OPTIONS']))
        {
            if( !$this->check_inCode($_POST['OPTIONS'],'OPTIONS',$goods_info['CATEGORY'] ) ) {
                echo json_encode(array( "code"=>"405", "msg"=>"옵션을 확인해주세요" ));
                return;
            }
            else {
                $data['OPTIONS'] = implode(",", $_POST['OPTIONS']);
            }
        }
        else $data['OPTIONS']='';
        
        if(isset($_POST['GOODS_FEATURE']) && is_array($_POST['GOODS_FEATURE']))
        {
            if( !$this->check_inCode($_POST['GOODS_FEATURE'],'GOODS_FEATURE', $goods_info["CATEGORY"] ) ) {
                echo json_encode(array( "code"=>"405", "msg"=>"물건특징을 확인해주세요" ));
                return;
            }
            else {
                $data['GOODS_FEATURE'] = implode(",", $_POST['GOODS_FEATURE']);
            }
        }
        else $data['GOODS_FEATURE']='';
        
        if(isset($_POST['GOODS_FEATURE']) && in_array("ETC", $_POST['GOODS_FEATURE']))
        {
            $data['GOODS_FEATURE_ETC'] = trim($this->input->post('GOODS_FEATURE_ETC', true));
            if( $data['GOODS_FEATURE_ETC'] =='' ) {
                echo json_encode(array( "code"=>"405", "msg"=>"기타 물건특징을 입력해주세요" ));
                return;
            }
        }
        else $data['GOODS_FEATURE_ETC'] ='';
                
        $data['OWNER_COMMENT'] = trim($this->input->post('OWNER_COMMENT', true));
        
        if( $this->db->where( "GOODS_IDX", $goods_info['GOODS_IDX'])->update("TB_UM_GOODS", $data) ) echo json_encode(array("code"=>"200"));
        else  echo json_encode(array("code"=>"502"));
    }
    
    // 집내놓기 매물정보 3단계 수정
    function step3_modify()
    {
        $goods_idx = $this->uri->segment(3);
        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
               
        $this->load->model('member_model');
        $data['step3'] = $goods_info;
        $data['inimage_avail'] = 6;
        $data['inimage'] =$data['outimage'] = array();
        
        if( in_array($goods_info['CATEGORY'], array('APT','OFT')) )
        {
            $qry = $this->db->get_where('TB_CB_COMPLEX_IMG', array('COMPLEX_IDX'=>$goods_info['COMPLEX_IDX']));
            if( $qry->num_rows() > 0 ) $data['default_outimage'] = $qry->result_array();
            else $data['default_outimage'] = array();
        }
        else $data['default_outimage'] = array();
        $data['outimage_avail'] = 10 - count($data['default_outimage']);
        
        $imgs = $this->member_model->getGoodsImg($goods_info['GOODS_IDX']);
        foreach( $imgs as $img ) {
            $data[ strtolower($img['FILE_SEPARATE'])."image"][] = $img;
        }
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelListMdf', '', 0);
        $this->input->set_cookie('brokerSelListMdfStart', '', 0);
        
        $this->load->view('sub_header');
        $this->load->view('mypage/step3_modify', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 매물정보 4단계 수정
    function step4_modify()
    {
        $goods_idx = $this->uri->segment(3);        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $data['step4'] = $goods_info;
        
        $this->load->model('goods_model');
        $this->load->model('sellhome_model');
        
        //$data['realtor']['data'] = $this->goods_model->nearEstate($goods_info['LAT'], $goods_info['LNG']);
        
        // 선택된 특정 중개사
        $this->load->helper('cookie');
        if(get_cookie('brokerSelListMdf', true) != '')
        {
            $selbrokers = explode(",", get_cookie('brokerSelListMdf', true));
            $selbrkcnt = count($selbrokers);
            
            if($selbrkcnt > 0) {
                $data['realtor']['data'] = $this->sellhome_model->step4_selBrokerLists(get_cookie('brokerSelListMdf', true));
            }
            else {
                $data['realtor']['data'] = array();
            }
            
            $ct = 0;
            for($i=0; $i<$selbrkcnt; $i++) {
                if($selbrokers[$i] != '') {
                    $broker[] = $selbrokers[$i];
                    $ct++;
                }
                else {
                    $broker[] = null;
                }
            }
            
            $data['selbrokers'] = $broker;
            $data['selbrokercnt'] = $selbrkcnt;
        }
        else
        {
            $sql = "SELECT gb.*, bo.*, bm.MBR_IDX, bm.MBR_NAME, bm.MBR_IMAGE_FULL_PATH FROM TB_UA_GOODS_BROKER as gb, TB_AB_BROKER_OFFICE as bo, TB_UB_MEMBER as bm
                WHERE gb.BROKER_OFFICE_IDX=bo.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX=bm.MBR_IDX AND gb.GOODS_IDX='".$goods_info['GOODS_IDX']."'";
            $qry = $this->db->query($sql);
            $data['brokerInfoCnt'] = $qry->num_rows();
            if($data['brokerInfoCnt'] > 0 && get_cookie('brokerSelListMdfStart', true) != $goods_idx)
            {
                $selBrokerArr = $qry->result_array();
                
                $s = 0;
                foreach($selBrokerArr as $brokerInfo)
                {
                    $brokerRes[] = $brokerInfo['BROKER_OFFICE_IDX'];
                    
                    if($s == 0) {
                        $brokerDiv = $brokerInfo['BROKER_OFFICE_IDX'];
                    }
                    else {
                        $brokerDiv = $brokerDiv.','.$brokerInfo['BROKER_OFFICE_IDX'];
                    }
                    
                    $s++;
                }
                
                $this->load->model('sellhome_model');
                $data['realtor']['data'] = $this->sellhome_model->step4_selBrokerLists($brokerDiv);
                
                $this->input->set_cookie('brokerSelListMdf', $brokerDiv, 0);
                $this->input->set_cookie('brokerSelListMdfStart', $goods_idx, 0);
                
                $data['selbrokers'] = $brokerRes;
                $data['selbrokercnt'] = $data['brokerInfoCnt'];
            }
            else
            {
                $data['realtor']['data'] = array();
                
                $data['selbrokers'] = '';
                $data['selbrokercnt'] = 0;
            }
        }
        
        $data['change_avail'] = $this->goods_model->changeRealtorAvail($goods_info['GOODS_IDX']);
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/step4_modify', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 매물정보 4단계 수정 저장
    function step4_modify_save()
    {
        $goods_info = $this->chkGoodsSTatus((int)$this->input->post("idx"), true);
        $this->load->model('Goods_model');
        $change_avail = $this->Goods_model->changeRealtorAvail($goods_info['GOODS_IDX']);
        if($this->config->item('SERVERSTATE') != 'test' && $change_avail != 'able') {
            echo json_encode(array("code"=>"500", "msg"=>"중개사를 선택후 7일간은 수정이 불가능합니다."));
            return;
        }
        
        if( $this->input->post("AGENCY_OPEN_FLAG") =='Y' )
        {
            if( !is_array($_POST['realtorselected']) || count( $_POST['realtorselected'])<0 ) {
                echo json_encode(array("code"=>"500", "msg"=>"중개사를 선택해주세요"));
                return;
            }
            else {
                foreach($_POST['realtorselected'] as $idx=>$val) {
                    if( (int)$val != $val || (int)$val < 0 ) {
                        echo json_encode(array("code"=>"500", "msg"=>"잠시 후에 다시 시도해주세요"));
                        return;
                    }
                }
            }
        }
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelListMdf', '', 0);
        $this->input->set_cookie('brokerSelListMdfStart', '', 0);
        
        $this->db->trans_start();
        $this->db->where('GOODS_IDX', $goods_info['GOODS_IDX'])->delete("TB_UA_GOODS_BROKER");
        $this->db->set('AGENCY_OPEN_FLAG', $this->input->post("AGENCY_OPEN_FLAG"))->where('GOODS_IDX', $goods_info['GOODS_IDX'])
        ->update('TB_UM_GOODS');
        if( $this->input->post("AGENCY_OPEN_FLAG") =='Y' )
        {
            foreach($_POST['realtorselected'] as $idx=>$val) {
                $this->db->insert('TB_UA_GOODS_BROKER', array("GOODS_IDX"=>$goods_info['GOODS_IDX'], "BROKER_OFFICE_IDX"=>(int)$val));
            }
        }
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE) {
            echo json_encode(array("code"=>"501", "msg"=>"잠시 후에 다시 시도해주세요"));
            return;
        }
        else {
            echo json_encode(array("code"=>"200", "msg"=>""));
            return;
        }
    }
    
    // 집구하기 4단계 수정하기 - 중개사 선택
    function step4_brokers_modify()
    {
        $goods_idx = $this->uri->segment(3);        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $data['step4'] = $goods_info;
        
        $data['CATEGORY'] = $goods_info['CATEGORY'];
        
        $data['lat'] = $goods_info['LAT'];
        $data['lng'] = $goods_info['LNG'];
        
        $this->load->model('goods_model');
        $data['realtorcount'] = $this->goods_model->nearEstate($goods_info['LAT'], $goods_info['LNG']);
        $data['realtor'] = $this->goods_model->nearEstateOver($goods_info['LAT'], $goods_info['LNG']);
        
        $data['change_avail'] = $this->goods_model->changeRealtorAvail($goods_info['GOODS_IDX']);
        
        // 선택된 특정 중개사
        $ct = 0;
        $broker = '';
        $this->load->helper('cookie');
        if(get_cookie('brokerSelListMdf', true) != '')
        {
            $selbrokers = explode(",", get_cookie('brokerSelListMdf', true));
            for($i=0; $i<count($selbrokers); $i++)
            {
                if($i == 0) $com = "";
                else $com = ",";
                if($selbrokers[$i] > 0)
                {
                    $broker .= $com.$selbrokers[$i];
                    $ct++;
                }
                else {
                    $broker .= "";
                }
            }
        }
        
        $data['selbrokers'] = $broker;
        $data['selbrokerscnt'] = $ct;
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/step4_brokers_modify', $data);
        $this->load->view('sub_footer');
    }
    
    // 집구하기 4단계 수정하기 - 중개사무소 선택
    function step4_brokers_modify_list()
    {
        $goods_idx = $this->uri->segment(3);        
        $goods_info = $this->chkGoodsSTatus($goods_idx);
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $data['step4'] = $goods_info;
        
        $data['CATEGORY'] = $goods_info['CATEGORY'];
        
        $data['lat'] = $goods_info['LAT'];
        $data['lng'] = $goods_info['LNG'];
        
        $this->load->model('goods_model');
        $data['realtor']['data'] = $this->goods_model->nearEstate($goods_info['LAT'], $goods_info['LNG']);
        
        $sql = "SELECT gb.*, bo.*, bm.MBR_IDX, bm.MBR_NAME, bm.MBR_IMAGE_FULL_PATH FROM TB_UA_GOODS_BROKER as gb, TB_AB_BROKER_OFFICE as bo, TB_UB_MEMBER as bm 
                WHERE gb.BROKER_OFFICE_IDX=bo.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX=bm.MBR_IDX AND gb.GOODS_IDX='".$goods_info['GOODS_IDX']."'";
        $qry = $this->db->query($sql);
        if($qry->num_rows() > 0) {
            $data['relatorChecked'] = $qry->result_array();
        }
        else $data['relatorChecked'] = array();
        
        $data['change_avail'] = $this->goods_model->changeRealtorAvail($goods_info['GOODS_IDX']);
        
        $data['selbroker'] = $this->input->get_post('selbroker');
        
        $this->load->view('sub_header');
        $this->load->view('mypage/step4_brokers_modify_list', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 4단계 중개사 선택 후 쿠키로 생성
    function step4_brokercookie()
    {
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelListMdf', '', 0);
        $this->input->set_cookie('brokerSelListMdfStart', '', 0);
        
        $setType = $this->uri->segment(3);
        $goods_idx = $this->uri->segment(4);
        
        if($setType == 'p') {
            if($this->input->post('brk_check') == '') $selbrokers = '';
            else $selbrokers = $this->input->post('brk_check');
        }
        else {
            if($this->input->post('brk_check') == '') $selbrokers = '';
            else $selbrokers = json_decode($this->input->post('brk_check'));
        }
        
        $k = 0;
        $broker = null;
        for($i=0; $i<count(array_unique($selbrokers)); $i++)
        {
            $selbrokerinfo = $selbrokers[$i];
            if($k == 0) {
                $broker = $selbrokerinfo;
            }
            else {
                $broker = $broker.','.$selbrokerinfo;
            }
            $k++;
        }
        $this->input->set_cookie('brokerSelListMdf', $broker, 0);
        $this->input->set_cookie('brokerSelListMdfStart', $goods_idx, 0);
        
        if($selbrokers == '') {
            echo json_encode(array("code"=>"FAIL"));
        }
        else {
            echo json_encode(array("code"=>"SUCCESS"));
        }
        return;
    }
    
    //--------------------------------------------------------------//
    
    // 내 1:1 문의
    function myinquiry()
    {
        $memidx = $this->userinfo['MBR_IDX'];
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model('mypage_model');
        $data['inquriylist'] =  $this->mypage_model->myinquirylist($memidx);
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $data['getDevideCookie'] = "0";
        $data['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $data['getDevideCookie'] = "1";
            $data['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_inquiry', $data);
        $this->load->view('sub_footer');
    }
    
    // 내 1:1 문의 답글 리스트
    function myinquiry_reply()
    {
        $idx = $this->input->post('idx');
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->myinquiry_reply($idx);
        foreach($result as $info) {
            $list[] = array("reply_num"=>$info['QNA_IDX'], "qna_idx"=>$info['QNA_ANSWER_IDX'], "contents"=>$info['CONTENTS'], "mbr_idx"=>$info['REG_MBR_IDX'], "reply_date"=>str_replace("-", ".", substr($info['REG_DATE'],0,10)), "broker_office"=>$info['OFFICE_NAME'], "broker_name"=>$info['MBR_NAME'], "broker_photo"=>$info['MBR_PHOTO'], "addr"=>$info['ADDR1']);
        }
        
        echo json_encode($list);
    }
    
    // 내 1:1문의 댓글 쓰기
    function myinquiry_replycomment()
    {
        $INPUTDATA['idx'] = $this->input->post('idx');
        $INPUTDATA['comments'] = $this->input->post('comments');
        $INPUTDATA['memidx'] = $this->userinfo['MBR_IDX'];
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->myinquiry_replycomment_process($INPUTDATA);
        if($result) {
            echo "SUCCESS";
        }
        else {
            echo "FAIL";
        }
    }
    
    //--------------------------------------------------------------//
    
    // 비밀번호 변경
    function passwordchange()
    {
        $PWDINFO['userid'] = $this->userinfo['MBR_ID'];
        $PWDINFO['nowpwd'] = $this->input->get_post('nowpwd');
        $PWDINFO['newpwd'] = $this->input->get_post('newpwd');
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->passwordchangeprocess($PWDINFO);
        
        echo $result;
    }
    
    // 휴대폰번호 변경
    function cellphonechange()
    {
        $DATAINFO['userid'] = $this->userinfo['MBR_ID'];
        $DATAINFO['cellphone'] = $this->input->get_post('cellphone');
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->cellphonechangeprocess($DATAINFO);
        
        echo $result;
    }
        
    //--------------------------------------------------------------//
    
    // 비밀번호 재설정 페이지
    public function setpass()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('mypage/setpass', $data);
        $this->load->view('sub_footer');
    }
    
    // 비밀번호 재설정 완료 페이지
    public function setpassresult()
    {
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('mypage/setpassresult', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 알람
    public function alarm()
    {
        $USERINFO['memberidx'] = $this->userinfo['MBR_IDX'];
        
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model('mypage_model');
        $data['result'] = $this->mypage_model->alarmlist($USERINFO);
        
        $this->load->view('sub_header');
        $this->load->view('mypage/my_alarm', $data);
        $this->load->view('sub_footer');
    }
    
    // 알람 보기
    public function alarmview()
    {
        $DATAINFO['smsidx'] = $this->input->get_post('smsidx');
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->alarmviewresult($DATAINFO);
        
        echo $result;
    }
    
    //--------------------------------------------------------------//
    
    // 회원탈퇴
    function widthdraw()
    {
        $memidx = $this->userinfo['MBR_IDX'];
        
        $this->load->model('mypage_model');
        $result = $this->mypage_model->widthdrawresult($memidx);
        
        echo $result;
    }
}
