<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellhome extends MY_Controller
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
        /*if( !$this->is_login ) {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }*/
        
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
    
    public function index()
    {
        $data['url'] = "/";
        $this->load->view("alert", $data);
        return;
    }
    
    // 동정보
    function getAvailDong() {
        $this->load->model("sellhome_model");
        echo "var availDongLawCode = ".json_encode($this->sellhome_model->getAvailDongCode()).";";
    }
    
    // 방구조 출력
    public function roomStructurePrint()
    {
        $this->load->model("sellhome_model");
        $result = $this->sellhome_model->getCodeList('ROOM_TYPE');
        
        $i = 1;
        $dataPrint = array();
        foreach($result as $row) {
            $dataPrint[] = array('number'=>$i, 'val'=>$row['CODE_DETAIL'], 'name'=>$row['CODE_NAME']);
           	$i++;
        }
        
        echo json_encode($dataPrint);
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 집내놓기 메인
    public function main()
    {
        $data = array();
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
                
        /* TODO 저장중이던 매물 계속 등록 */
        $this->getTmpSaved();
        $tmp = $this->getTmpSaved();
        if($tmp !== false)
        {
            if( isset( $tmp['last_category'] ) && in_array($tmp['last_category'], array("APT","OFT","ONE") ) && $tmp['last_step'] !='' )
            {
                $steptmp = explode("_",  $tmp['last_step']);
                if( isset($tmp[$tmp['last_category']]) )
                {
                    if( is_array($tmp[$tmp['last_category']]) && $tmp[$tmp['last_category']][$tmp['last_step']]['istmp'] =='true' ) {
                        //$data = array("last_category" => $tmp['last_category'] , "last_step" => "step".( $steptmp[1]) );
                        $data['last_category'] = $tmp['last_category'];
                        $data['last_step'] = "step".( $steptmp[1]);
                    }
                    else if ( $tmp[$tmp['last_category']][$tmp['last_step']]['istmp'] =='saved' )
                    {
                        //if( $tmp['last_step'] =="step_3" ) $data = array();
                        //else {
                            //$data = array("last_category"=> $tmp['last_category'] , "last_step" =>"step".( $steptmp[1]+1) );
                        //}
                        $data['last_category'] = $tmp['last_category'];
                        $data['last_step'] = "step".( $steptmp[1]+1);
                    }
                }
            }
        }
        
        // 회원체크
        $data['memType'] = $this->userinfo['MBR_GUBUN'];
        
        $this->load->view('sub_header');
        $this->load->view('sellhome/main', $data);
        $this->load->view('sub_footer');
    }
    
    // 메인 초기화
    public function main_initialize()
    {
        $memidx = $this->userinfo['MBR_IDX'];
        
        $this->load->model("sellhome_model");
        $result = $this->sellhome_model->main_initialization($memidx);
        echo $result;
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 매물 등록 대행 서비스
    function agencyservice()
    {
        $data = array();
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->helper('cookie');
        $data['MOBILE_NO'] = get_cookie('MOBILE_NO');
        $data['UTF8_NAME'] = get_cookie('UTF8_NAME');
        
        $this->load->view('sub_header');
        $this->load->view('sellhome/agency_service', $data);
        $this->load->view('sub_footer');
    }
    
    function agencyServiceCert()
    {
        $module = 'CPClient';
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $authtype = "M";
        $popgubun = "N";
        $customize = "";
        $gender = "";
        $reqseq = get_cprequest_no($niceCfg['site']);
        $niceReturnHost =((!isset($_SERVER['HTTPS']) ||$_SERVER['HTTPS'] != "on") ? "http://" : "https://" ).$_SERVER['HTTP_HOST'];
        
        $returnurl = $niceReturnHost."/sellhome/agencyCertHP";	        // 성공시 이동될 URL
        $errorurl = $niceReturnHost."/sellhome/agencyCertHPFail";		// 실패시 이동될 URL
        
        $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
        "8:SITECODE" . strlen($niceCfg['site']) . ":" . $niceCfg['site'] .
        "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
        "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
        "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
        "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
        "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
        "6:GENDER" . strlen($gender) . ":" . $gender ;
        $enc_data = get_encode_data($niceCfg['site'], $niceCfg['pw'], $plaindata);
        
        //session_start();
        //$sessiondata = array("REQ_SEQ"=>$reqseq);
        //$this->session->set_userdata($sessiondata);
        
        echo json_encode(array("code"=>"100", "res"=>$enc_data));
        return;
    }
    
    // 저장처리
    function agencyserviceSave()
    {
        $this->load->helper('cookie');
        $hpcert['MOBILE_NO'] = get_cookie('MOBILE_NO');
        $hpcert['UTF8_NAME'] = get_cookie('UTF8_NAME');
        if( !isset($hpcert['MOBILE_NO']) ) {
            echo json_encode(array("code"=>"500", "msg"=>"휴대폰인증을 해주세요."));
            return;
        }
        
        $data['REG_NAME'] = trim($this->input->post('REG_NAME', true));
        $data['REG_ADDR1'] = trim($this->input->post('addr', true));
        $data['REG_ADDR2'] = trim($this->input->post('REG_ADDR2', true));
        $data['LAWDONG_CODE'] = trim($this->input->post('LAWDONG', true));
        $data['REG_AGREE'] = $this->input->post('REG_AGREE')!='Y' ?'N':'Y';
        if($data['REG_NAME']=='' || $data['REG_ADDR1']='' || $data['REG_ADDR2']=='' ||  $data['LAWDONG_CODE']=='') {
            echo json_encode(array("code"=>"404", "msg"=>"필수정보를 입력해주세요."));
            return;
        }
        else if($data['REG_AGREE'] != 'Y') {
            echo json_encode(array("code"=>"404", "msg"=>"개인정보수집에 동의해주세요."));
            return;
        }
        else
        {
            $data['REG_MP'] = $hpcert['MOBILE_NO'];
            $data['CERTED_NAME'] = $hpcert['UTF8_NAME'];
            $data['REG_DATE'] = date('Y-m-d H:i:s');
            $data['REG_IP'] = $this->input->ip_address();
            
            $this->input->set_cookie("MOBILE_NO", '', 0);
            $this->input->set_cookie("UTF8_NAME", '', 0);
            
            if($this->db->insert('TB_REG_AGENCY', $data)) {
                echo json_encode(array("code"=>"200"));
            }
            else {
                echo json_encode(array("code"=>"401","msg"=>"잠시 후에 다시 시도해주세요(401)"));
            }
        }
    }
    
    // 폰번호 인증
    function agencyCertHP()
    {
        $this->load->config("nice");
        $niceCfg = $this->config->item('nice');
        
        $enc_data = $_POST['EncodeData'];
        if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match) || $enc_data=="" || base64_encode(base64_decode($enc_data))!=$enc_data)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요", "url"=>"/") );
            $this->load->view('sub_footer');
            return;
        }
        
        $plaindata = get_decode_data($niceCfg['site'], $niceCfg['pw'], $enc_data);
        if($plaindata < 0)
        {
            $this->load->view('sub_header');
            $this->load->view("nice", array("msg"=>"잠시후에 다시 시도해주세요(".$plaindata.")", "url"=>"/"));
            $this->load->view('sub_footer');
            return;
        }
        
        $data = $this->getNiceValue($plaindata);
        if( isset($data['NAME']) ) unset($data['NAME']);
        if( isset($data["UTF8_NAME"]) ) $data["UTF8_NAME"] = urldecode( $data["UTF8_NAME"]);
        
        $this->input->set_cookie("MOBILE_NO", $data['MOBILE_NO'], 0);
        $this->input->set_cookie("UTF8_NAME", $data['UTF8_NAME'], 0);
        
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"휴대폰 인증을 하였습니다.", "url"=>"/sellhome/agencyservice") );
        $this->load->view('sub_footer');
    }
    
    // 휴대폰 인증 실패
    function agencyCertHPFail()
    {
        $this->load->view('sub_header');
        $this->load->view("nice", array("msg"=>"휴대폰 인증에 실패하였습니다.", "url"=>"/sellhome/agencyservice") );
        $this->load->view('sub_footer');
        return;
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
    
    //-----------------------------------------------------------------------------------------------//
    
    // 집내놓기 1단계
    public function step1()
    {
        $data = array();
        
        if( !$this->is_login ) {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
        
        // 앱정보 저장
        $data['PUSHKEY'] = get_cookie('PUSHKEY');
        //$data['UDID'] = get_cookie('UDID');
        $data['DEVICE'] = get_cookie('DEVICE');
        
        $this->load->model("sellhome_model");
                
        $loadCategory = $this->uri->segment(3);
        if(in_array($loadCategory, array('APT','OFT','ONE')))
        {
            $data['seletedCategory'] = $loadCategory;
            $tmp = $this->getTmpSaved();
            if( $tmp !== false ) {
                if(isset ($tmp[$loadCategory]['step_1']) && $tmp[$loadCategory]['step_1'] ) {  $data['step_1'] = $tmp[$loadCategory]['step_1']; }
            }
            
            if( isset($data['step_1']['SIGUNGU_CODE']) ) $data['DONG_CODE_ARR'] = $this->sellhome_model->getDongCode($data['step_1']['SIGUNGU_CODE']);
            
            if( isset($data['step_1']['DONG_CODE']) ) {
                $data['COMPLEX_ARR'] = $this->sellhome_model->getDongComplex( $data['step_1']['DONG_CODE'], $data['step_1']['CATEGORY'] );
            }
            
            if( isset($data['step_1']['COMPLEX_IDX']) && $data['step_1']['COMPLEX_IDX'] > 0 ) {
                $data['COMPLEX_INFO_ARR'] = $this->sellhome_model->getComplexDHinfo( $data['step_1']['COMPLEX_IDX'], $data['step_1']['CATEGORY'] );
            }
        }
        else
        {
            $data['seletedCategory'] = null;
        }
        
        // 매물유형
        $data['ROOM_TYPE'] = $this->sellhome_model->getCodeList('ROOM_TYPE');
                
        $this->load->view('sub_header');
        $this->load->view('sellhome/step1', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 1단계 -> 단지 검색
    public function dangi_search()
    {
        $dong = $this->input->get_post('dong');
        $category = $this->input->get_post('category');
        
        $list = array();
        $sql = "SELECT
                    a.COMPLEX_IDX, a.COMPLEX_NAME, LAT, LNG, a.HIGH_FLOOR, a.LOW_FLOOR, ifnull(a.DONGS, '-|-|-|-') AS DONGS,
                    group_concat(concat(b.SUPPLY_AREA,',', b.EXCLUSIVE_AREA ) SEPARATOR '|' ) AS area
                FROM TB_CB_COMPLEX a JOIN TB_CB_COMPLEX_AREA b ON a.COMPLEX_IDX = b.COMPLEX_IDX AND a.COMPLEX_TYPE = b.COMPLEX_TYPE
                WHERE a.LAW_DONG_CODE = ? and a.COMPLEX_TYPE = ?
                GROUP BY a.TB_CB_COMPLEX_IDX ORDER BY COMPLEX_NAME ASC";
        $qry = $this->db->query( $sql, array($dong, $category) );
        if($qry->num_rows() > 0)
        {
            $result = $qry->result_array();
            foreach($result as $info) {
                $list[] = array("com_idx"=>$info['COMPLEX_IDX'], "com_name"=>$info['COMPLEX_NAME']);
            }
        }
        
        echo json_encode($list);
    }
    
    // 집내놓기 1단계 -> 단지 -> 동검색
    public function dangidong_search()
    {
        $comidx = $this->input->get_post('comidx');
        $category = $this->input->get_post('category');
        
        // 단지내 동 출력
        $sql = "SELECT dongNo, bildName FROM TB_CB_COMPLEX_DONG a JOIN nv_dong_unmatch b ON a.complexNo = b.complexNo AND b.dongOrHo = 'HO' WHERE a.complexNo = ? ORDER BY a.sortNo";
        $qry = $this->db->query($sql, array($comidx));
        if( $qry->num_rows() > 0 ) {
            $result = $qry->result_array();
        }
        else
        {
            $sql = "SELECT dongNo, bildName FROM TB_CB_COMPLEX_DONG2 a WHERE a.complexNo = ? ORDER BY a.sortNo";
            $qry = $this->db->query($sql, array($comidx));
            if( $qry->num_rows() > 0 ) {
                $result = $qry->result_array();
            }
            else {
                $qry = $this->db->select('dongNo, bildName')->where('complexNo', $comidx)->order_by('sortNo')->get('TB_CB_COMPLEX_DONG');
                if( $qry->num_rows() > 0 ) $result = $qry->result_array();
                else $result = array();
            }
        }
        
        echo json_encode($result);
    }
    
    // 집내놓기 1단계 -> 단지 -> 동 -> 층검색
    public function dangidongfloor_search()
    {
        $comidx = $this->input->get_post('comidx');
        $category = $this->input->get_post('category');
        $dong = $this->input->get_post('dong');
        $dongNo = $this->input->get_post('dongNo');
               
        $list = array();
        
        $sql = "SELECT hoFloor, lineNo, hoName, a.supplyArea, b.AREA_NO ano, b.AREA_NAME, b.EXCLUSIVE_AREA, b.SUPPLY_AREA, b.SUPPLY_PYEONG
            FROM TB_CB_COMPLEX_HO a
            LEFT JOIN TB_CB_COMPLEX_AREA b ON a.complexNo = b.COMPLEX_IDX AND a.pyeongNo = b.AREA_NO
            WHERE complexNo = '$comidx' AND dongNo = '$dongNo'
            GROUP BY hoFloor
            ORDER BY hoFloor, cast(lineNo as unsigned), hoName";
        $qry = $this->db->query($sql);
        if($qry->num_rows() > 0)
        {
            $result = $qry->result_array();
            foreach($result as $info)
            {
                $subSql = "SELECT HIGH_FLOOR FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$comidx'";
                $subQry = $this->db->query($subSql);
                $subInfo = $subQry->row_array();
                $list[] = array("floor"=>$info['hoFloor'], "total_floor"=>$subInfo['HIGH_FLOOR'], "supplyArea"=>$info['SUPPLY_AREA']);
            }
        }
        else
        {
            $sql = "SELECT hoFloor, lineNo, hoName, a.supplyArea, b.AREA_NO ano, b.AREA_NAME, b.EXCLUSIVE_AREA, b.SUPPLY_AREA, b.SUPPLY_PYEONG
            FROM TB_CB_COMPLEX_HO2 a
            LEFT JOIN TB_CB_COMPLEX_AREA b ON a.complexNo = b.COMPLEX_IDX AND a.pyeongNo = b.AREA_NO
            WHERE complexNo = '$comidx' AND dongNo = '$dongNo'
            GROUP BY hoFloor
            ORDER BY hoFloor, cast(lineNo as unsigned), hoName";
            $qry = $this->db->query($sql);
            if($qry->num_rows() > 0)
            {
                $result = $qry->result_array();
                foreach($result as $info)
                {
                    $subSql = "SELECT HIGH_FLOOR FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$comidx'";
                    $subQry = $this->db->query($subSql);
                    $subInfo = $subQry->row_array();
                    $list[] = array("floor"=>$info['hoFloor'], "total_floor"=>$subInfo['HIGH_FLOOR'], "supplyArea"=>$info['SUPPLY_AREA']);
                }
            }
        }
        
        echo json_encode($list);
    }
    
    // 집내놓기 1단계 -> 단지 -> 동 -> 층 -> 호검색
    public function dangidongfloorho_search()
    {
        $comidx = $this->input->get_post('comidx');
        $floor = $this->input->get_post('floor');
        $dongNo = $this->input->get_post('dongNo');
        
        $list = array();
        $sql = "SELECT a.hoName, b.SUPPLY_AREA
            FROM TB_CB_COMPLEX_HO a
            LEFT JOIN TB_CB_COMPLEX_AREA b ON a.complexNo = b.COMPLEX_IDX AND a.pyeongNo = b.AREA_NO
            WHERE complexNo = ? AND dongNo = ? AND hoFloor = ?
            ORDER BY hoName";
        $qry = $this->db->query($sql, array($comidx, $dongNo, $floor));
        if($qry->num_rows() > 0)
        {
            $result = $qry->result_array();
            foreach($result as $info) {
                $list[] = array("ho"=>$info['hoName'], "supplyArea"=>$info['SUPPLY_AREA']);
            }
        }
        else
        {
            $sql = "SELECT a.hoName, b.SUPPLY_AREA
            FROM TB_CB_COMPLEX_HO2 a
            LEFT JOIN TB_CB_COMPLEX_AREA b ON a.complexNo = b.COMPLEX_IDX AND a.pyeongNo = b.AREA_NO
            WHERE complexNo = ? AND dongNo = ? AND hoFloor = ?
            ORDER BY hoName";
            $qry = $this->db->query($sql, array($comidx, $dongNo, $floor));
            if($qry->num_rows() > 0)
            {
                $result = $qry->result_array();
                foreach($result as $info) {
                    $list[] = array("ho"=>$info['hoName'], "supplyArea"=>$info['SUPPLY_AREA']);
                }
            }
        }
        
        echo json_encode($list);
    }
    
    // 집내놓기 1단계 -> 단지 -> 동 -> 층 -> 호 -> 면적검색
    public function dangidongfloorhoarea_search()
    {
        $comidx = $this->input->get_post('comidx');
        $category = $this->input->get_post('category');
        
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->getComplexFloorHoAreainfoNew($comidx, $category);
        $list = array();
        foreach($result as $info) {
            $list[] = array("idx"=>$info['idx'], "areaName"=>$info['areaName'], "supplyArea"=>$info['supplyArea'], "exclusiveArea"=>$info['exclusiveArea'], "pyeong"=>$info['pyeong']);
        }
        
        echo json_encode($list);
    }
    
    // 집내놓기 1단계 -> 위치확인
    public function map_position()
    {
        $comidx = $this->input->get_post('comidx');
                
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->map_position_result($comidx);
        $list = array("office_name"=>$result['COMPLEX_NAME'], "lat"=>$result['LAT'], "lng"=>$result['LNG']);
        
        echo json_encode($list);
    }
    
    // 집내놓기 1단계 저장
    function saveStep1()
    {
        $INPUTDATA['REG_TYPE'] = $this->input->get_post('REG_TYPE');
        $INPUTDATA['OWNER_CP'] = $this->input->get_post('OWNER_CP');
        $INPUTDATA['CATEGORY'] = $this->input->get_post('CATEGORY');
        
        if($INPUTDATA['CATEGORY'] == 'APT' || $INPUTDATA['CATEGORY'] == 'OFT')
        {
            // 아파트, 오피스텔
            $INPUTDATA['SIDO_CODE'] = $this->input->get_post('SIDO_CODE');
            $INPUTDATA['SIGUNGU_CODE'] = $this->input->get_post('SIGUNGU_CODE');
            $INPUTDATA['DONG_CODE'] = $this->input->get_post('DONG_CODE');
            $INPUTDATA['COMPLEX_IDX'] = $this->input->get_post('COMPLEX_IDX');
            $INPUTDATA['DONG'] = $this->input->get_post('DONG');
            $INPUTDATA['FLOOR'] = $this->input->get_post('FLOOR');
            $INPUTDATA['AREA1'] = $this->input->get_post('AREA1');
            $INPUTDATA['dongNm'] = $this->input->get_post('dongNm');
            $INPUTDATA['AREA_SELECTED'] = $this->input->get_post('AREA_SELECTED');
            
            if($INPUTDATA['CATEGORY'] == 'OFT') {
                $INPUTDATA['ROOM_TYPE'] = $this->input->get_post('ROOM_TYPE');
            }
        }
        
        if($INPUTDATA['CATEGORY'] == 'ONE')
        {
            // 원룸 주소검색
            $INPUTDATA['LAW_ADDR1'] = $this->input->get_post('LAW_ADDR1');
            $INPUTDATA['LAW_DONG_CODE'] = $this->input->get_post('LAW_DONG_CODE');
            $INPUTDATA['LAW_ADDR2'] = $this->input->get_post('LAW_ADDR2');
            $INPUTDATA['FLOOR'] = $this->input->get_post('FLOOR');
            $INPUTDATA['ROOM_TYPE'] = $this->input->get_post('ROOM_TYPE');
        }
                
        // 아파트, 오피스텔, 원룸 공통
        $INPUTDATA['TOTAL_FLOOR'] = $this->input->get_post('TOTAL_FLOOR');
        $INPUTDATA['AREA2'] = $this->input->get_post('AREA2');
        $INPUTDATA['LAT'] = $this->input->get_post('LAT');
        $INPUTDATA['LNG'] = $this->input->get_post('LNG');
        $INPUTDATA['HO'] = $this->input->get_post('HO');
        
        $INPUTDATA['TRADE_TYPE'] = $this->input->get_post('TRADE_TYPE');    // 매물유형
        
        // 매매선택
        if($INPUTDATA['TRADE_TYPE'] == '1') {
            $INPUTDATA['PRICE1'] = $this->input->get_post('PRICE1');            // 매매희망가
        }
        
        // 전세 및 월세 선택
        if($INPUTDATA['TRADE_TYPE'] == '2' || $INPUTDATA['TRADE_TYPE'] == '3') {
            $INPUTDATA['PRICE2'] = $this->input->get_post('PRICE2');            // 전세 및 월세 보증금 희망가
        }
        
        // 월세선택
        if($INPUTDATA['TRADE_TYPE'] == '3') {
            $INPUTDATA['PRICE3'] = $this->input->get_post('PRICE3');            // 월세가
        }
        
        $INPUTDATA['istmp'] = "saved";
        
        // 저장 및 결과 출력
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->saveStepProcess($INPUTDATA, 'step_1');
        
        echo $result;
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 집내놓기 2단계
    public function step2()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
                
        $loadCategory = $this->uri->segment(3);
        if($loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE'))) {
            $this->load->view("alert", array("url"=>"/sellhome/step1"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        if(!isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved') {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        
        $data['CATEGORY'] = $loadCategory;
        $data['step2'] = ( isset ($tmp[$loadCategory]['step_2']) ? $tmp[$loadCategory]['step_2'] : array() );
        $data['step1'] = ( isset ($tmp[$loadCategory]['step_1']) ? $tmp[$loadCategory]['step_1'] : array() );
        
        $this->load->model('sellhome_model');
        $data['ARR_DIRECTIONS'] = $this->sellhome_model->getCodeList('ARR_DIRECTIONS');
        $data['ARR_GOODS_FEATURES'] = $this->sellhome_model->getCodeList('GOODS_FEATURES',$loadCategory);
        $data['goods_option'] = $this->sellhome_model->goodsOptionList($loadCategory);
        $data["goods_option_selected"] = array();
        if(isset($data['step2']['OPTIONS']) && $data['step2']['OPTIONS'] !='')
        {
            if( is_array($data['step2']['OPTIONS']) ) {
                $data["goods_option_selected"] = $data['step2']['OPTIONS'];
            }
            else {
                $tmparr = explode(",", $data['step2']['OPTIONS']);
                if( count($tmparr)>0 )
                {
                    foreach( $tmparr as $idx=>$val ) {
                        $data["goods_option_selected"][]=trim($val);
                    }
                }
            }
        }
        
        $data["goods_feature_selected"] = array();
        if( isset($data['step2']['GOODS_FEATURE']) && $data['step2']['GOODS_FEATURE'] !='' )
        {
            if( is_array($data['step2']['GOODS_FEATURE']) ) {
                $data["goods_feature_selected"] = $data['step2']['GOODS_FEATURE'];
            }
            else {
                $tmparr = explode(",", $data['step2']['GOODS_FEATURE']);
                if( count($tmparr)>0 )
                {
                    foreach( $tmparr as $idx=>$val ) {
                        $data["goods_feature_selected"][]=trim($val);
                    }
                }
            }
        }
        
        $this->load->config("dawin");
        $data['expense_item_arr'] = $this->config->item('EXPENSE_ITEM');
        $data["expense_item_selected"] = array();
        if( isset($data['step2']['EXPENSE_ITEM']) && $data['step2']['EXPENSE_ITEM'] !='' )
        {
            if( is_array($data['step2']['EXPENSE_ITEM']) ) {
                $data["expense_item_selected"] = $data['step2']['EXPENSE_ITEM'];
            }
            else {
                $tmparr = explode("|", $data['step2']['EXPENSE_ITEM']);
                if(count($tmparr) > 0)
                {
                    foreach( $tmparr as $idx=>$val ) {
                        $data["expense_item_selected"][]=trim($val);
                    }
                }
            }
        }
        
        // 방향
        $data['ARR_DIRECTIONS'] = $this->sellhome_model->getCodeList('ARR_DIRECTIONS');
                
        $this->load->view('sub_header');
        $this->load->view('sellhome/step2', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 2단계 저장
    function saveStep2()
    {
        $this->load->helper('security');
        $data['CATEGORY'] = $this->input->post('CATEGORY');
        if(empty($data['CATEGORY'])) { echo json_encode(array( "code"=>"405", "msg"=>"정보값이 없습니다. #1" )); return; }
        
        //PARKING_FLAG, HEAT_TYPE, ELEVATOR_FLAG
        if( $this->input->post('ENTER_TYPE') !='' && !in_array($this->input->post('ENTER_TYPE'), array("1","2","3") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"입주희망일을 선택해주세요" )); return; }
        else $data['ENTER_TYPE'] = $this->input->post('ENTER_TYPE');
        
        if($this->input->post('ENTER_TYPE') == '3') {
            $chkdate = $this->chkdateformat( $this->input->post('ENTER_DATE') );
            if($chkdate['code'] == false) { echo json_encode(array( "code"=>"405", "msg"=>$chkdate['msg'] )); return; }
            $data['ENTER_DATE'] = $chkdate['data'];
        }
        
        if( $this->input->post('OWNER_LIVE')!='' && !in_array($this->input->post('OWNER_LIVE'), array("1","2","3") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"거주상태를 확인해주세요" )); return; }
        $data['OWNER_LIVE'] = $this->input->post('OWNER_LIVE');
        
        if( $this->input->post('DIRECTION')!='' && !$this->check_inCode($this->input->post('DIRECTION'),'DIRECTION','A' ) ) { echo json_encode(array( "code"=>"405", "msg"=>"방향을 확인해주세요" )); return; }
        $data['DIRECTION'] = $this->input->post('DIRECTION');
        
        if( $this->input->post('BALCONY')!='' && !in_array($this->input->post('BALCONY'), array("1","2","0") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"발코니를 확인해주세요" )); return; }
        $data['BALCONY'] = $this->input->post('BALCONY');
        
        if( $this->input->post('ANIMAL')!='' && !in_array($this->input->post('ANIMAL'), array("1","2") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"반려동물 가능여부를 확인해주세요" )); return; }
        $data['ANIMAL'] = $this->input->post('ANIMAL');
        
        if( $this->input->post('EXPENSE')!='' && (int)$this->input->post('EXPENSE')!= $this->input->post('EXPENSE') ) { echo json_encode(array( "code"=>"405", "msg"=>"관리비를 확인해주세요" )); return; }
        $data['EXPENSE'] = $this->input->post('EXPENSE');
        
        if( isset($_POST['EXPENSE_ITEM']) &&is_array($_POST['EXPENSE_ITEM']) ) {
            $data['EXPENSE_ITEM'] = implode("|", $_POST['EXPENSE_ITEM']);
        }
        else $data['EXPENSE_ITEM']='';
        
        if( (int)$this->input->post('ROOM_CNT') > 0 ) $data['ROOM_CNT'] = (int)$this->input->post('ROOM_CNT');
        if( (int)$this->input->post('BATHROOM_CNT') > 0 ) $data['BATHROOM_CNT'] = (int)$this->input->post('BATHROOM_CNT');
        
        if( $this->input->post('PARKING_FLAG')!='' && !in_array($this->input->post('PARKING_FLAG'), array("Y","N") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"주차가능여부를 확인해주세요" )); return; }
        $data['PARKING_FLAG'] = $this->input->post('PARKING_FLAG');
        
        if( $this->input->post('HEAT_TYPE')!='' && !in_array($this->input->post('HEAT_TYPE'), array("P","C") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"난방방식을 확인해주세요" )); return; }
        $data['HEAT_TYPE'] = $this->input->post('HEAT_TYPE');
        
        if( $this->input->post('ELEVATOR_FLAG')!='' && !in_array($this->input->post('ELEVATOR_FLAG'), array("Y","N") ) ) { echo json_encode(array( "code"=>"405", "msg"=>"엘리베이터 유무를 확인해주세요" )); return; }
        $data['ELEVATOR_FLAG'] = $this->input->post('ELEVATOR_FLAG');
        
        if( isset($_POST['OPTIONS']) &&is_array($_POST['OPTIONS']) )
        {
            if( !$this->check_inCode($_POST['OPTIONS'],'OPTIONS',$data['CATEGORY'] ) ) {
                echo json_encode(array( "code"=>"405", "msg"=>"옵션을 확인해주세요" ));
                return;
            }
            else {
                $data['OPTIONS'] = implode(",", $_POST['OPTIONS']);
            }
        }
        else $data['OPTIONS']='';
        
        if( isset($_POST['GOODS_FEATURE']) && is_array($_POST['GOODS_FEATURE']) )
        {
            if( !$this->check_inCode($_POST['GOODS_FEATURE'],'GOODS_FEATURE',$this->input->post("CATEGORY") ) ) { 
                echo  json_encode(array( "code"=>"405", "msg"=>"물건특징을 확인해주세요" ));
                return;
            }
            else {
                $data['GOODS_FEATURE'] = implode(",", $_POST['GOODS_FEATURE']);
            }
        }
        else $data['GOODS_FEATURE']='';
        
        if( isset($_POST['GOODS_FEATURE']) && in_array("ETC", $_POST['GOODS_FEATURE'] ) )
        {
            $data['GOODS_FEATURE_ETC'] = trim($this->input->post('GOODS_FEATURE_ETC', true));
            if( $data['GOODS_FEATURE_ETC'] =='' ) { 
                echo json_encode(array( "code"=>"405", "msg"=>"기타 물건특징을 입력해주세요" ));
                return;
            }
        }
        else $data['GOODS_FEATURE_ETC'] ='';
        $data['OWNER_COMMENT'] = trim($this->input->post('OWNER_COMMENT', true));
                
        $data['istmp'] = "saved";
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->saveStepProcess($data,'step_2');
        if( $result == 'SUCCESS' ) {
            echo json_encode( array("code"=>"200") );
        }
        else {
            echo json_encode( array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요"));
        }
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 집내놓기 3단계
    function step3()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
        
        $loadCategory = $this->uri->segment(3);
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            $this->load->view("alert", array("url"=>"/sellhome"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        if(!isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved') {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        else if(!isset($tmp[$loadCategory]['step_2']['istmp']) || $tmp[$loadCategory]['step_2']['istmp'] !='saved') {
            $this->load->view("alert", array("msg"=>"매물옵션정보를 입력해주세요.", "url"=>"/sellhome/step2/".$loadCategory));
            return;
        }
        
        $data['CATEGORY'] = $loadCategory;
        $this->load->model('member_model');
        $data['inimage'] = $this->member_model->getSalepicture($this->userinfo['MBR_IDX'], $loadCategory, 'IN');
        $data['outimage'] = $this->member_model->getSalepicture($this->userinfo['MBR_IDX'], $loadCategory, 'OUT');
        $data['inimage_avail'] = 6;
        
        if( in_array($loadCategory, array('APT','OFT')) )
        {
            $complexidx = isset($tmp[$loadCategory]['step_1']['COMPLEX_IDX']) ? $tmp[$loadCategory]['step_1']['COMPLEX_IDX'] : 0;
            if( $complexidx < 0 ) {
                $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
                return;
            }
            else {
                $qry = $this->db->select('IMAGE_FULL_PATH')->get_where('TB_CB_COMPLEX_IMG', array('COMPLEX_IDX'=>$complexidx));
                if( $qry->num_rows() > 0 ) $data['default_outimage'] = $qry->result_array();
                else $data['default_outimage'] = array();
            }
        }
        else $data['default_outimage'] = array();
        $data['outimage_avail'] = 10 - count($data['default_outimage']);
                
        $this->load->view('sub_header');
        $this->load->view('sellhome/step3', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 3단계 저장
    function saveStep3()
    {
        $data['CATEGORY'] = $this->input->post('CATEGORY');
        if( !in_array($data['CATEGORY'], array('APT','OFT','ONE')) ) {
            json_encode( array("code"=>"405"));
            return;
        }
        
        if($data['CATEGORY'] == "ONE")
        {
            $cnt =$this->db->select("count(1) as cnt")->where("MBR_IDX", $this->userinfo['MBR_IDX'])->where("CATEGORY","ONE")->get("TB_TMP_FOR_SALE_IMAGE")->row_array();
            if($cnt['cnt'] < 4) {
                echo json_encode(array("code"=>"500", "msg"=>"방, 부엌, 욕실, 현관 4장은 필수등록사항입니다."));
                return;
            }
        }
        
        $data['istmp'] = "saved";
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->saveStepProcess($data,'step_3');
        if( $result == 'SUCCESS' ) {
            echo json_encode(array("code"=>"200"));
        }
        else {
            echo json_encode(array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요"));
        }
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 집내놓기 4단계
    function step4()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $loadCategory = $this->uri->segment(3);
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            $this->load->view("alert", array("url"=>"/sellhome"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        if( !isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_2']['istmp']) || $tmp[$loadCategory]['step_2']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물옵션정보를 입력해주세요.", "url"=>"/sellhome/step2/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_3']['istmp']) || $tmp[$loadCategory]['step_3']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물사진등록을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }
        
        $data['CATEGORY'] = $loadCategory;
        $data['lat'] = $tmp[$loadCategory]['step_1']['LAT'];
        $data['lng'] = $tmp[$loadCategory]['step_1']['LNG'];
        //$this->load->model('goods_model');
        //$data['realtor']['data'] = $this->goods_model->nearEstate($data['lat'], $data['lng']);
        $data['relatorChecked'] = array();
        
        if( isset( $tmp[$loadCategory]['step_4']['realtorselected'])  && is_array($tmp[$loadCategory]['step_4']['realtorselected']) ) {
            $data['relatorChecked'] = $tmp[$loadCategory]['step_4']['realtorselected'];
        }
        else if( isset( $tmp[$loadCategory]['step_4']['realtorselected'] ) ) {
            $data['relatorChecked'] = explode( "," , $tmp[$loadCategory]['step_4']['realtorselected'] );
        }
        
        if( isset($tmp[$loadCategory]['step_4']) ) $data['step4'] = $tmp[$loadCategory]['step_4'];
        else $data['step4'] = array();
        
        // 선택된 특정 중개사
        $this->load->helper('cookie');
        if(get_cookie('brokerSelList', true) != '')
        {
            $this->load->model('sellhome_model');
            $data['realtor']['data'] = $this->sellhome_model->step4_selBrokerLists(get_cookie('brokerSelList', true));
            
            $selbrokers = explode(",", get_cookie('brokerSelList', true));
            $selbrkcnt = count($selbrokers);
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
            $data['selbrokercnt'] = $ct;
        }
        else
        {
            $data['realtor']['data'] = array();
            
            $data['selbrokers'] = '';
            $data['selbrokercnt'] = 0;
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
        
        $this->load->view('sub_header');
        $this->load->view('sellhome/step4', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 4단계 중개사 선택 후 쿠키로 생성
    function step4_brokercookie()
    {
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
        
        $setType = $this->uri->segment(3);
        
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
        $this->input->set_cookie('brokerSelList', $broker, 0);
                         
        if($selbrokers == '') {
            echo json_encode(array("code"=>"FAIL"));
        }
        else {
            echo json_encode(array("code"=>"SUCCESS"));
        }
        return;
    }
    
    // 집내놓기 4단계 인근 모든 중개사 자동 선택시 쿠키 삭제
    function step4_brokercookie_del()
    {
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
        
        echo "OK";
        return;
    }
    
    // 집내놓기 4단계 저장
    function saveStep4()
    {
        $data['CATEGORY'] = $this->input->post('CATEGORY');
        if( !in_array($data['CATEGORY'], array('APT','OFT','ONE')) ) {
            echo json_encode( array("code"=>"404"));
            return;
        }

        $data['istmp'] = "saved";
        if( $this->input->post('AGENCY_OPEN_FLAG')=='N' ) {
            $data['AGENCY_OPEN_FLAG'] ='N';
            $data['realtorselected'] ='';
        }
        else if ( $this->input->post('AGENCY_OPEN_FLAG')=='Y')
        {
            if( !isset($_POST['realtorselected']) || !is_array($_POST['realtorselected']) || count($_POST['realtorselected']) < 1 ) {
                echo json_encode( array("code"=>"405", "msg"=>"[특정중개사선택]을 하셨습니다.\n먼저 중개사를 추가해주세요"));
                return;
            }
            else
            {
                foreach($_POST['realtorselected'] as $idx=>$val)
                {
                    if( (int)$val <= 0 || $val != (int)$val){
                        echo json_encode( array("code"=>"501", "msg"=>"중개사를 다시 선택해주세요"));
                        return;
                    }
                    $tmp[] = (int)$val;
                }
                
                $data['AGENCY_OPEN_FLAG'] ='Y';
                $data['realtorselected'] = implode(',', $tmp);
            }
        }
        else {
            echo json_encode( array("code"=>"500", "msg"=>"중개사를 다시 선택해주세요"));
            return;
        }
        
        $this->load->helper('cookie');
        $this->input->set_cookie('brokerSelList', '', 0);
        
        $this->load->model('sellhome_model');
        $result = $this->sellhome_model->saveStepProcess($data,'step_4');
        if( $result == 'SUCCESS' ) {
            echo json_encode( array("code"=>"200") );
        }
        else {
            echo json_encode( array("code"=>"500", "msg"=>"잠시후에 다시 시도해주세요") );
        }
    }
    
    // 집구하기 4단계 중개사 선택
    function step4_brokers()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $loadCategory = $this->uri->segment(3);
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            $this->load->view("alert", array("url"=>"/sellhome"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        if( !isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_2']['istmp']) || $tmp[$loadCategory]['step_2']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물옵션정보를 입력해주세요.", "url"=>"/sellhome/step2/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_3']['istmp']) || $tmp[$loadCategory]['step_3']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물사진등록을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }
        
        $data['CATEGORY'] = $loadCategory;
        $data['lat'] = $tmp[$loadCategory]['step_1']['LAT'];
        $data['lng'] = $tmp[$loadCategory]['step_1']['LNG'];
        $this->load->model('goods_model');
        $data['realtorcount']['data'] = $this->goods_model->nearEstate($data['lat'], $data['lng']);
        $data['realtor']['data'] = $this->goods_model->nearEstateOver($data['lat'], $data['lng']);
        
        // 선택된 특정 중개사
        $ct = 0;
        $broker = '';
        $this->load->helper('cookie');
        if(get_cookie('brokerSelList', true) != '')
        {
            $selbrokers = explode(",", get_cookie('brokerSelList', true));
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
        $this->load->view('sellhome/step4_brokers', $data);
        $this->load->view('sub_footer');
    }
    
    // 브로거 목록 출력
    function step4_brokersameposition()
    {
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        
        $this->load->model("sellhome_model");
        $result = $this->sellhome_model->step4_brokerLists($lat, $lng);
        foreach($result as $info) {
            $list[] = array(
                "officeidx"=>$info['BROKER_OFFICE_IDX'],
                "imgpath"=>$info['MBR_IMAGE_FULL_PATH'],
                "point"=>$info['BROKER_POINT'],
                "phone"=>$info['PHONE'],
                "officetitle"=>$info['OFFICE_NAME'],
                "username"=>$info['MBR_NAME']
            );
        }
        
        echo json_encode($list);
    }
    
    // 집구하기 4단계 중개사 정보
    function step4_brokerinfo()
    {
        $brk_idx = $this->input->post('brk_idx');
        
        $sql = "SELECT bo.LAT, bo.LNG FROM TB_AB_BROKER_OFFICE as bo, TB_UB_MEMBER as mb WHERE bo.BROKER_OFFICE_IDX=mb.MBR_IDX AND bo.BROKER_OFFICE_IDX = '$brk_idx' AND mb.MBR_STATUS='NM' AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR') LIMIT 1";
        $qry = $this->db->query($sql);
        if($qry->num_rows() > 0) {
            $list = $qry->row_array();
        }
        else {
            $list = array();
        }
        echo json_encode($list);
    }
    
    // 집구하기 4단계 중개사무소 선택
    function step4_brokers_list()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $loadCategory = $this->uri->segment(3);
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            $this->load->view("alert", array("url"=>"/sellhome"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        if( !isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_2']['istmp']) || $tmp[$loadCategory]['step_2']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물옵션정보를 입력해주세요.", "url"=>"/sellhome/step2/".$loadCategory));
            return;
        }
        else if ( !isset($tmp[$loadCategory]['step_3']['istmp']) || $tmp[$loadCategory]['step_3']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물사진등록을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }
        
        $data['CATEGORY'] = $loadCategory;
        $data['lat'] = $tmp[$loadCategory]['step_1']['LAT'];
        $data['lng'] = $tmp[$loadCategory]['step_1']['LNG'];
        $this->load->model('goods_model');
        $data['realtor']['data'] = $this->goods_model->nearEstate($data['lat'], $data['lng']);
        $data['relatorChecked'] = array();
        
        if( isset( $tmp[$loadCategory]['step_4']['realtorselected'])  && is_array($tmp[$loadCategory]['step_4']['realtorselected']) ) {
            $data['relatorChecked'] = $tmp[$loadCategory]['step_4']['realtorselected'];
        }
        else if( isset( $tmp[$loadCategory]['step_4']['realtorselected'] ) ) {
            $data['relatorChecked'] = explode( "," , $tmp[$loadCategory]['step_4']['realtorselected'] );
        }
        
        if( isset($tmp[$loadCategory]['step_4']) ) $data['step4'] = $tmp[$loadCategory]['step_4'];
        else $data['step4'] = array();
        
        $data['selbroker'] = $this->input->get_post('selbroker');
        
        $this->load->view('sub_header');
        $this->load->view('sellhome/step4_brokers_list', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 4단계 중개사 정보보기
    function step4_agentinfo()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        $brokeridx = $this->uri->segment(3);
        $goods_idx = $this->uri->segment(4);
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->model('sellhome_model');
        $data['profile'] = $this->sellhome_model->getProfile($brokeridx);
        $data['info'] = $this->sellhome_model->brokerOfficeInfo($brokeridx);
        $data['review'] = $this->sellhome_model->brokerOfficeReview($brokeridx);
        $data['belong'] = $this->sellhome_model->getOfficeBelong($brokeridx);
        
        $gqry = $this->db->get_where("TB_UM_GOODS", array("GOODS_IDX"=>$goods_idx, "GOODS_STATUS"=>"SB", "GOODS_PROCESS_STATUS"=>"PS2"));
        if( $gqry->num_rows() > 0 ) {
            $data['qnabtnopen'] = '1';
        }
        else {
            $data['qnabtnopen'] = '0';
        }
        
        // 문의내역확인
        $qry = $this->db->get_where("TB_UA_QNA", array("MBR_IDX"=>$this->userinfo['MBR_IDX'], "GOODS_IDX"=>$goods_idx, "BROKER_OFFICE_IDX"=>$brokeridx, "ANSWER_YN"=>"N"));
        if( $qry->num_rows() > 0 ) {
            $data['qnaCnt'] = '1';
        }
        else {
            $data['qnaCnt'] = '0';
        }
        
        $data['goods_idx'] = $goods_idx;
        
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
        $this->load->view('sellhome/step4_agentinfo', $data);
        $this->load->view('sub_footer');
    }
    
    // 집내놓기 4단계 중개사 문의 등록
    function step4_inquiry()
    {
        if( !$this->is_login ) {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // 데이터 등록
        $INPUTDATA['memidx'] = $this->userinfo['MBR_IDX'];
        $INPUTDATA['officeidx'] = $this->input->post('officeidx');
        $INPUTDATA['contents'] = $this->input->post('contents');
        $INPUTDATA['goods_idx'] = $this->input->post('goods_idx');
        
        $this->load->model("sellhome_model");
        $result = $this->sellhome_model->step4_inquiry_process($INPUTDATA);
        echo $result;
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 마지막 저장 단계
    function saveLast()
    {
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        $loadCategory = $this->uri->segment(3);
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            $this->load->view("alert", array("url"=>"/sellhome"));
            return;
        }
        
        $tmp = $this->getTmpSaved();
        
        if( !isset($tmp[$loadCategory]['step_1']['istmp']) || $tmp[$loadCategory]['step_1']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"개인 및 매물정보 입력을 해주세요.", "url"=>"/sellhome/step1/".$loadCategory));
            return;
        }
        else if( !isset($tmp[$loadCategory]['step_2']['istmp']) || $tmp[$loadCategory]['step_2']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물옵션정보를 입력해주세요.", "url"=>"/sellhome/step2/".$loadCategory));
            return;
        }
        /*else if( !isset($tmp[$loadCategory]['step_3']['istmp']) || $tmp[$loadCategory]['step_3']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물사진등록을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }
        else if( !isset($tmp[$loadCategory]['step_4']['istmp']) || $tmp[$loadCategory]['step_4']['istmp'] !='saved' ) {
            $this->load->view("alert", array("msg"=>"매물사진등록을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }*/
        else if (!isset($tmp[$loadCategory]['step_4']['istmp']) || $tmp[$loadCategory]['step_4']['istmp'] !='saved') {
            $this->load->view("alert", array("msg"=>"중개사 선택을 해주세요.", "url"=>"/sellhome/step3/".$loadCategory));
            return;
        }
        
        //$data = array_merge( $tmp[$loadCategory]['step_1'], $tmp[$loadCategory]['step_2'], $tmp[$loadCategory]['step_3'], $tmp[$loadCategory]['step_4']);
        $data = array_merge( $tmp[$loadCategory]['step_1'], $tmp[$loadCategory]['step_2'], $tmp[$loadCategory]['step_4']);
        unset ($data['istmp']);
        $this->load->model("goods_model");
        
        $data['REG_MBR_IDX'] = $this->userinfo['MBR_IDX'];
        $data['REG_MBR_NAME'] = $this->userinfo['MBR_NAME'];
        $data['REG_CP'] = $this->userinfo['MBR_CP'];
        $data['GOODS_NO'] = $this->goods_model->makeGoodsNo($loadCategory, (isset( $data['DONG_CODE'] ) ? $data['DONG_CODE']: $data['LAW_DONG_CODE']) );
        $data['ADDR_TYPE'] = "2";   // 지번주소사용
        
        if ( isset($data['AREA_SELECTED'])) {
            $data['SPACE_IDX'] = $data['AREA_SELECTED'];
            unset( $data['AREA_SELECTED'] );
        }
        if ( isset($data['dongNm']) ) unset( $data['dongNm']);
        
        $realtorselected = isset($data['realtorselected']) ? $data['realtorselected'] :"";
        if( isset($data['realtorselected']) ) unset($data['realtorselected']);
        /*if( isset($data['TOTAL_FLOOR']) ) {
            $data['TOTAL_FLOOR'] = $data['TOTAL_FLOOR'];
            unset($data['TOTAL_FLOOR']);
        }*/
        
        $floor = round($data['FLOOR'] / $data['TOTAL_FLOOR'] * 100);
        $data['FLOOR_KIND'] = ( $floor <= 20 ? "저" : ( ($floor <= 50 ) ? "중":"고" ) );
        /*
        $qry = $this->db->query( "select CODE_NAME from TB_CB_CODE where CODE_GBN='ARR_DIRECTIONS' and CODE_DETAIL = ? and USE_YN='Y' ", array($data['DIRECTION']) );
        if( isset($data['DIRECTION']) && $data['DIRECTION'] !='' )
        {
            if( $qry->num_rows() > 0 ) {
                $row = $qry->row_array();
                $data['DIRECTION'] = $row['CODE_NAME'];
            }
        }
        */
        
        if( $loadCategory != 'ONE' )
        {
            $sql = "SELECT b.ENTRANCETYPE FROM TB_CB_COMPLEX_AREA b where b.COMPLEX_IDX = ? AND b.COMPLEX_TYPE = ? AND b.SUPPLY_AREA =?  AND b.EXCLUSIVE_AREA = ?";
            $qry = $this->db->query($sql, array($data['COMPLEX_IDX'], $data['CATEGORY'],$data['AREA1'], $data['AREA2'] ) );
            if( $qry->num_rows() > 0 ) {
                $tmp = $qry->row_array();
                $data['FRONT_DOOR_TYPE'] = $tmp['ENTRANCETYPE'];
            }
            
            unset ($data['DONG_CODE']);unset ($data['SIDO_CODE']);unset($data['SIGUNGU_CODE']);
            $data = array_merge($data , $this->goods_model->getComplexAddrInfo($data['COMPLEX_IDX']) );
        }
        else {
            //$data['AREA2'] = $data['AREA2'] * (3.30579);
            if(!isset($data['AREA1']) || $data['AREA1'] < 1 ) $data['AREA1'] = $data['AREA2'];
            $data = array_merge($data , $this->goods_model->getAddrInfobyDONG($data['LAW_DONG_CODE']) );
        }
        
        $this->db->insert('TB_UM_GOODS', $data);
        $goods_idx = $this->db->insert_id();
        if( $goods_idx > 0 ) {
            $realtorArr = $this->goods_model->realtorselectedToArr($goods_idx, $realtorselected);
        }
        $this->goods_model->moveTmpImages($this->userinfo['MBR_IDX'],$goods_idx,$loadCategory);
        
        unset($tmp['']);
        unset($tmp[$loadCategory]);
        $lastCategory = '';
        $lastStep = '';
        $lastregdate ='';
        foreach( $tmp as $idx=>$row )
        {
            if( in_array($idx, array('APT','OFT','ONE') ) )
            {
                if ( isset($row['regdate']) && $row['regdate'] > $lastregdate ) {
                    $lastregdate = $row['regdate'];
                    $lastCategory = $idx;
                }
            }
        }
        
        if( $lastCategory !='' )
        {
            foreach( array('step_4', 'step_3','step_2','step_1') as $step )
            {
                if( isset($tmp[$lastCategory][$step]['istmp'])) {
                    $lastStep = $step;
                    break;
                }
            }
            
            $tmp['last_category'] = $lastCategory;
            $tmp['last_step'] = $lastStep;
            $cont = json_encode($tmp);
            $ins = $this->db->where("MBR_IDX",$this->userinfo['MBR_IDX'])->update("TB_TMP_FOR_SALE", array("CONTENT"=>$cont));
        }
        else {
            $this->db->where("MBR_IDX",$this->userinfo['MBR_IDX'])->delete("TB_TMP_FOR_SALE");
        }
        
        $this->load->view("alert", array("url"=>"/sellhome/complete"));
        return;
    }
    
    // 완료 페이지
    function complete()
    {
        $data = array();
        
        if(!$this->is_login)
        {
            $data['msg'] = "로그인이 필요한 페이지입니다. 로그인해주세요.";
            $data['url'] = "/member/login";
            $this->load->view("alert", $data);
            return;
        }
        
        // footer base var
        $data['BROKER_OFFICE_NAME'] = null;
        $data['LAT'] = null;
        $data['LNG'] = null;
        
        $this->load->view('sub_header');
        $this->load->view('sellhome/complete', $data);
        $this->load->view('sub_footer');
    }
    
    //-----------------------------------------------------------------------------------------------//
    
    // 임시 저장 정보
    function getTmpSaved($category = '')
    {
        $this->load->model("sellhome_model");
        $json = $this->sellhome_model->getTemp($this->userinfo['MBR_IDX']);
        if( isset($json['CONTENT']) ) return json_decode($json['CONTENT'],true);
        else return false;
    }
}
