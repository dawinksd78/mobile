<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buyhome extends MY_Controller
{
    function index()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 홈 및 집구하기 메인 검색 변수
        $data['keyword'] = $this->input->get_post('keyword',true);
        $data['saletype'] = $this->input->get_post('sale_type',true);    // 아파트(APT), 오피스텔(OFT), 원룸(ONE)
        
        // 추가 검색 변수
        $data['complex_idx'] = $this->input->get_post('cpxidx',true);
        $data['lat'] = $this->input->get_post('lat',true) == '' ? '37.350086' : $this->input->get_post('lat',true);
        $data['lng'] = $this->input->get_post('lng',true) == '' ? '127.109134' : $this->input->get_post('lng',true);
        
        if( !in_array($data['saletype'], array('APT','OFT','ONE')) ) $data['saletype'] = 'APT';
        if( (int)$data['complex_idx'] < 1 ) $data['complex_idx'] = '-1';
        
        // 매매, 전/월세
        $data['transtype'] = $this->input->get_post('transtype',true);
        
        $this->load->model('sellhome_model');
        $data["ROOM_TYPE"] = $this->sellhome_model->getCodeList('ROOM_TYPE');
        
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
        
        if( (int)$this->userinfo['MBR_IDX'] < 1 ) {
            $data['memidx'] = '-1';
        }
        else {
            $data['memidx'] = (int)$this->userinfo['MBR_IDX'];
        }
        
        $this->load->view('sub_header');
        $this->load->view('buyhome/find', $data);
        $this->load->view('sub_footer');
    }
    
    // 다음 Map API 건물 정보 출력 
    function getdata()
    {
        // 거래유형 (전체:all, 매매:sale, 전월세:previous, 전세:previous_2, 월세:previous_3)
        $condition['transtype'] = $this->input->get_post('transtype');
        if($condition['transtype'] == '') $condition['transtype'] = 'all';
        
        // 면적
        $condition['area'] = $this->input->get_post('area');
        if($condition['area'] == '') $condition['area'] = 'all';
        
        // 금액
        $condition['saleprice'] = $this->input->get_post('saleprice');
        if($condition['saleprice'] == '') $condition['saleprice'] = 'all';
        
        // 전세(보증금)
        $condition['charterprice'] = $this->input->get_post('charterprice');
        if($condition['charterprice'] == '') $condition['charterprice'] = 'all';
        
        // 월세(보증금)
        $condition['monthly_deposit'] = $this->input->get_post('monthly_deposit');
        if($condition['monthly_deposit'] == '') $condition['monthly_deposit'] = 'all';
        
        // 월세
        $condition['monthly'] = $this->input->get_post('monthly');
        if($condition['monthly'] == '') $condition['monthly'] = 'all';
        
        // 방구조
        $condition['ROOM_TYPE'] = isset($_GET['ROOM_TYPE']) ? $_GET['ROOM_TYPE']:'';
        if( is_array($condition['ROOM_TYPE']) && count($condition['ROOM_TYPE'])==1 && $condition['ROOM_TYPE'][0]=='all' ) $condition['ROOM_TYPE'] ='';
        
        // 아파트(APT), 오피스텔(OFT), 원룸(ONE)
        $complex_type = $this->input->get_post('saletype');
        if($complex_type == '') $complex_type = 'APT';
        
        $useridx = $this->is_login==true ? $this->userinfo['MBR_IDX'] : '-1';
        
        $this->load->model('find_model');
        $this->find_model->init(
            $this->input->get_post('swlat'),
            $this->input->get_post('swlng'),
            $this->input->get_post('nelat'),
            $this->input->get_post('nelng'),
            $this->input->get_post('level'),
            $complex_type,
            $this->input->get_post('spaceunit'),
            $condition
        );
        
        // 원룸인 경우
        if($complex_type == 'ONE') {
            $res = $this->find_model->listOneRoom($useridx);
            if($this->input->get_post('level') <= 4) echo json_encode($this->oneroomposition($res));
            else echo json_encode(array('POSITION'=>$res));
        }
        // 아파트, 오피스텔인 경우
        else {
            $position = $this->find_model->list();
            echo json_encode(array('POSITION'=>$position), true, 300);
        }
    }
    
    // 매물 상세 정보 (buyhome에 정보 출력)
    function getDetailInfoView()
    {
        $this->load->model('detail_model');
        $usecache = false;
        $this->load->driver('cache', array('adapter'=>'memcached', 'backup'=>'file', 'key_prefix'=>'dtl_'));
        
        if(
            !$usecache || !$this->cache->memcached->is_supported()
            || !$data = $this->cache->get($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).'_'.$this->input->get('transtype', true))
        )
        {
            $cached = false;
            $data = $this->detail_model->getDetailInfoView($this->input->get('complex_idx', true), $this->input->get('complex_type', true), $this->input->get('transtype', true));
            if(count($data) > 0) {
                $data['image_arr'] = explode(',' , $data['images'] );
                $tmp = explode(',', $data['SUPPLY_AREA']);
                $data['area_arr'] = $this->detail_model->getAreaList($this->input->get('complex_idx', true),$this->input->get('complex_type', true));
            }
            
            if($this->cache->memcached->is_supported()) {
                $this->cache->save($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).'_'.$this->input->get('transtype', true),$data, 1800);
            }
        }
        else {
            $cached = true;
        }
        
        echo json_encode(array("code"=>'200', "data"=>$data, "cached"=>$cached), true, 43200);
    }
    
    // 매물 상세 정보
    function getDetail()
    {
        $this->load->model('detail_model');
        $usecache = false;
        $this->load->driver('cache', array('adapter'=>'memcached', 'backup'=>'file', 'key_prefix'=>'dtl_'));

        if(
            !$usecache || !$this->cache->memcached->is_supported()
            || !$data = $this->cache->get($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).'_'.$this->input->get('transtype', true) ) 
        )
        {
            $cached = false;
            $data = $this->detail_model->getdetail($this->input->get('complex_idx', true), $this->input->get('complex_type', true), $this->input->get('transtype', true));
            
            if(count($data) > 0) {
                $data['image_arr'] = explode(',' , $data['images'] );
                $tmp = explode(',', $data['SUPPLY_AREA']);
                $data['area_arr'] = $this->detail_model->getAreaList($this->input->get('complex_idx', true),$this->input->get('complex_type', true));
            }
            
            if($this->cache->memcached->is_supported()) $this->cache->save($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).'_'.$this->input->get('transtype', true),$data, 1800);
        }
        else $cached = true;
        
        echo json_encode( array("code"=>'200', "data"=>$data, "cached"=>$cached), true, 43200);
    }    
    
    // 필터 출력
    function filter()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->model('sellhome_model');
        $data["ROOM_TYPE"] = $this->sellhome_model->getCodeList('ROOM_TYPE');
        
        $this->load->view('sub_header');
        $this->load->view('buyhome/filter', $data);
        $this->load->view('sub_footer');
    }
    
    // 매물 단지 정보 상세 보기
    function danjidetail()
    {       
        $complex_idx = $this->uri->segment(3);
        $complex_type = $this->uri->segment(4);
        $transtype = $this->uri->segment(5);
        $ygtype = $this->uri->segment(6);
        
        $this->load->model('detail_model');
        $data = $this->detail_model->getDetailInfoView($complex_idx, $complex_type, $transtype);
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        if(count($data) > 0) {
            $data['image_arr'] = explode(',', $data['images']);
            $data['images_arr'] = explode(',', $data['images_arr']);
            $tmp = explode(',', $data['SUPPLY_AREA']);
            $data['area_arr'] = $this->detail_model->getAreaList($complex_idx, $complex_type);
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
        if($ygtype == 'ABYG' || $ygtype == 'OBYG') {
            $this->load->view('buyhome/danjidetail_yg', $data);
        }
        else {
            $this->load->view('buyhome/danjidetail', $data);
        }
        $this->load->view('sub_footer');
    }
    
    // 매물 정보 목록 보기
    function salelist()
    {
        $complex_idx = $this->uri->segment(3);
        $complex_type = $this->uri->segment(4);
        $transtype = $this->uri->segment(5);
                
        // 거래유형 (전체:all, 매매:sale, 전월세:previous, 전세:previous_2, 월세:previous_3)
        if($transtype == '') $condition['transtype'] = 'all';
        else $condition['transtype'] = $transtype;
        
        // 면적
        $condition['area'] = 'all';
        
        // 금액
        $condition['saleprice'] = 'all';
        
        // 전세(보증금)
        $condition['charterprice'] = 'all';
        
        // 월세(보증금)
        $condition['monthly_deposit'] = 'all';
        
        // 월세
        $condition['monthly'] = 'all';
        
        // 방구조
        $condition['ROOM_TYPE'] = isset($_GET['ROOM_TYPE']) ? $_GET['ROOM_TYPE']:'';
        if(is_array($condition['ROOM_TYPE']) && count($condition['ROOM_TYPE'])==1 && $condition['ROOM_TYPE'][0]=='all') $condition['ROOM_TYPE'] ='';
        
        $data = array();
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 회원번호
        $useridx = $this->is_login==true ? $this->userinfo['MBR_IDX'] : '-1';
        $data['useridx'] = $useridx;
        
        // 매물 기본정보
        $sql = "SELECT COMPLEX_NAME, REAL_ESTATE_TYPE FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$complex_idx'";
        $result = $this->db->query($sql)->row_array();
        $data['complex_name'] = $result['COMPLEX_NAME'];
        $data['realEstateType'] = $result['REAL_ESTATE_TYPE'];
        
        // 매물 리스트
        $this->load->model('find_model');
        $data['result'] = $this->find_model->saleComplexList($complex_idx, $complex_type, $condition, $useridx);
        $data['URLRES'] = $complex_idx.'_'.$complex_type.'_'.$transtype;
        
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
        $this->load->view('buyhome/salelist', $data);
        $this->load->view('sub_footer');
    }
    
    // 매물 정보 상세 보기
    function saledetail()
    {
        // 매물 번호
        $goods_idx = $this->uri->segment(3);
        if((int)$goods_idx < 1) {
            return;
        }
                
        $this->load->model('goods_model');
        $this->load->model('detail_model');
        $this->load->model('sellhome_model');
        
        // 아파트 상세 매물 정보
        $res = $this->goods_model->goodsViewinfoAPT($goods_idx, $this->userinfo['MBR_IDX']);
        if(count($res) < 1) {
            exit;
        }
        
        $res['BROKER_OFFICE_NAME'] = '';
        $res['LAT'] = '';
        $res['LNG'] = '';
        
        // 매물 기본 정보 값 출력
        if(isset($res['data']))
        {
            $this->load->library('goodsrate');
            $data = $res['data'];
            $res['goodsrate'] = $this->goodsrate->init($data['PRICE1'], $data['PRICE2'], $data['PRICE3'], $data['CATEGORY'], $data['TRADE_TYPE'], $data['AREA1']);
        }
        
        // 지도 위치 정보
        $estate = array();
        if(isset($res['estate'])) {
            foreach($res['estate'] as $row) {
                $estate[] = array("idx"=>$row['BROKER_OFFICE_IDX'], "lat"=>$row['LAT'], "lng"=>$row['LNG'], "title"=>$row['OFFICE_NAME'], "name"=>$row['MBR_NAME'], "img"=>$row['MBR_IMAGE_FULL_PATH']);
            }
        }
                
        // 건물 정보
        $res['areainfo'] = $this->detail_model->getAreaList($res['data']['COMPLEX_IDX'], $res['data']['CATEGORY']);
        
        // 지도 위치 json
        $res['jsonestate'] = json_encode($estate, JSON_UNESCAPED_UNICODE);
        
        // 다윈 기본 정보값
        $this->load->config('dawin');
        $opttmp = $this->config->item('GOODS_FEATURE');
        
        $res['goods_feature_arr'] = $this->sellhome_model->getCodeList('GOODS_FEATURES', $res['data']['CATEGORY']);
        
        $res['goods_feature_selected'] = ($res['data']['GOODS_FEATURE'] == '') ? array() : explode(",", $res['data']['GOODS_FEATURE']);
        
        $res['goods_option'] = $this->sellhome_model->goodsOptionList($res['data']['CATEGORY']);
        $res['goods_option_selected'] = ($res['data']['OPTIONS'] == '') ? array() : explode(",", $res['data']['OPTIONS']);
        
        if($res['data']['EXPENSE'] == '') $res['data']['EXPENSE'] = ' - ';
        
        if($res['data']['EXPENSE_ITEM'] != '')
        {
            $this->load->config("dawin");
            $expensive_item_arr = $this->config->item('EXPENSE_ITEM');
            
            $EXPENSE_ITEM_arr = array();
            $tmp = explode("|",$data['EXPENSE_ITEM']);
            foreach($tmp as $val) {
                if(isset($expensive_item_arr[trim($val)])) $EXPENSE_ITEM_arr[] = $expensive_item_arr[trim($val)];
            }
            
            if(count($EXPENSE_ITEM_arr) > 0) $res['data']['EXPENSE_ITEM'] = implode(",", $EXPENSE_ITEM_arr);
            else $res['data']['EXPENSE_ITEM'] = '';
        }
        $res['data']['DIRECTIONTEXT'] = $this->goods_model->getCodeName("ARR_DIRECTIONS", $res['data']['DIRECTION']);
        $res['data']['outimg'] = $this->detail_model->getGoodsImg($goods_idx,'OUT');
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        $DEVICE = get_cookie('DEVICE');
        $res['getDevideCookie'] = "0";
        $res['DEVICE'] = NULL;
        if($PUSHKEY != '' && $DEVICE != '') {
            $res['getDevideCookie'] = "1";
            $res['DEVICE'] = $DEVICE;
        }
        
        $this->load->view('sub_header');
        
        if( $res['data']['CATEGORY']=='ONE') $this->load->view('buyhome/saledetail_one', $res);
        else $this->load->view('buyhome/saledetail_apt', $res);
        
        $this->load->view('sub_footer');
    }
    
    // 중개사 위치 정보
    function brokeroffice()
    {
        // 매물 번호
        $complex_idx = $this->uri->segment(3);
        $loadCategory = $this->uri->segment(4);
        if((int)$complex_idx < 1 || $loadCategory == '') {
            return;
        }
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 매물 기본정보
        $sql = "SELECT LAT, LNG FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$complex_idx'";
        $result = $this->db->query($sql)->row_array();
        
        $data = array();
        $data['CATEGORY'] = $loadCategory;
        $data['lat'] = $result['LAT'];
        $data['lng'] = $result['LNG'];
        
        $this->load->model('goods_model');
        $data['realtor']['data'] = $this->goods_model->nearEstate($data['lat'], $data['lng']);
        
        $this->load->view('sub_header');
        $this->load->view('buyhome/brokeroffice', $data);
        $this->load->view('sub_footer');
    }
    
    // 편의 시설 보기
    function comforts()
    {
        // 매물 번호
        $complex_idx = $this->uri->segment(3);
        $loadCategory = $this->uri->segment(4);
        if((int)$complex_idx < 1 || $loadCategory == '') {
            return;
        }
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        // 매물 기본정보
        $sql = "SELECT LAT, LNG FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$complex_idx'";
        $result = $this->db->query($sql)->row_array();
        
        
        $data = array();
        $data['complex_idx'] = $complex_idx;
        $data['saletype'] = $loadCategory;
        $data['lat'] = $result['LAT'];
        $data['lng'] = $result['LNG'];
        
        $this->load->view('sub_header');
        $this->load->view('buyhome/comforts', $data);
        $this->load->view('sub_footer');
    }
    
    // 매물 문의하기
    function saleinquiry()
    {
        $data = array();
        
        $complex_idx = $this->uri->segment(3);
        $loadCategory = $this->uri->segment(4);
        $goods_idx = $this->uri->segment(5);
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        if($loadCategory == 'ONE') {            
            // 매물 기본정보
            $sql = "SELECT LAT, LNG FROM TB_UM_GOODS WHERE GOODS_IDX='$goods_idx'";
        }
        else {
            // 매물 기본정보
            $sql = "SELECT LAT, LNG FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$complex_idx'";
        }
        $result = $this->db->query($sql)->row_array();
        
        $data['complex_idx'] = $complex_idx;
        $data['saletype'] = $loadCategory;
        $data['goods_idx'] = $goods_idx;
        $data['lat'] = $result['LAT'];
        $data['lng'] = $result['LNG'];
        
        $this->load->model('goods_model');
        //$data['realtor']['data'] = $this->goods_model->nearEstate($data['lat'], $data['lng']);
        $data['realtor']['data'] = $this->goods_model->goodsConnectBroker($goods_idx);
        if(count($data['realtor']['data']) < 1) {
            $data['realtor']['data'] = $this->goods_model->goodsNearEstate($goods_idx, $data['lat'], $data['lng']);
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
        $this->load->view('buyhome/saleinquiry', $data);
        $this->load->view('sub_footer');
    }
    
    // 매물 문의 처리하기
    function saleinquiryProc()
    {
        // 비로그인상태
        if( !$this->is_login ) {
            echo "LOGIN";
            return;
        }
        
        $officeidx = $this->input->post('brk_check');
        $goods_idx = $this->input->post('goods_idx');
        $contents = $this->input->post('contents');
        $memidx = $this->userinfo['MBR_IDX'];
        
        $data = array('MBR_IDX'=>$memidx, 'BROKER_OFFICE_IDX'=>$officeidx, 'GOODS_IDX'=>$goods_idx, 'QNA_CATEGORY'=>'FQ3', 'CONTENTS'=>$contents);
        $res = $this->db->insert('TB_UA_QNA', $data);
        if($res) {
            echo "SUCCESS";
        }
        else {
            echo "FAIL";
        }
        return;
    }
    
    function getTradeHistory()
    {
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => 'trh_'));
        if(
            $this->input->get("cache") == 'false' || 
            !$this->cache->memcached->is_supported() || 
            !$data = $this->cache->get($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).$this->input->get('area_no', true).'_'.$this->input->get('transtype', true))
        )
        {
            $cached = false;
            $area_no = $this->input->get('area_no', true);
            $tmp = explode('N', $area_no);
            if( !isset($tmp[1]) && (int)$tmp[1] < 1 ) {
                $this->json_encode( array('code'=>404, 'data'=>array() ) );
                return;
            }
            else $area_no = (int)$tmp[1];
            
            $this->load->model('detail_model');
            $data = $this->detail_model->getTradeHistory($this->input->get('complex_idx', true), $this->input->get('complex_type', true),$area_no ,$this->input->get('transtype', true) );
            if($this->cache->memcached->is_supported()) {
                $this->cache->save($this->input->get('complex_idx', true).'_'.$this->input->get('complex_type', true).$this->input->get('area_no', true).'_'.$this->input->get('transtype', true),$data, 1800 );
            }
        }
        else $cached = true;
        
        if($data === false) {
            $this->json_encode( array('code'=>'404', 'data'=>array() ) );
        }
        else $this->json_encode( array('code'=>'200', 'data'=>$data , "cached"=>$cached) , true, 18000 );
    }
    
    // 실거래정보
    /*function getTradeList()
    {
        $area_no = $this->input->get('area_no', true);
        $tmp = explode('N', $area_no);
        if( !isset($tmp[1]) && (int)$tmp[1] < 1 ) {
            echo json_encode(array('code'=>'404', 'data'=>array()));
            return;
        }
        else $area_no = (int)$tmp[1];
        
        $this->load->model('detail_model');
        $page = (int)($this->input->get('page', true));
        $per_page = 5;
        
        $ret = $this->detail_model->getTradeList($this->input->get('complex_idx', true), $this->input->get('complex_type', true), $area_no, $this->input->get('transtype', true), $page, $per_page);
        echo json_encode(array('code'=>'200', 'data'=>$ret, 'nextpage'=>$page+1, "complex_idx"=>$this->input->get('complex_idx', true), "complex_type"=>$this->input->get('complex_type', true), "area_no"=>'N'.$area_no, "transtype"=>$this->input->get('transtype', true)), true, 43200);
    }*/
    function getTradeList()
    {
        $area_no = $this->input->get('area_no', true);
        $tmp = explode('N', $area_no);
        if( !isset($tmp[1]) && (int)$tmp[1] < 1 ){
            echo json_encode( array('code'=>404, 'data'=>array() ) );
            return;
        }
        else $area_no = (int)$tmp[1];
        
        $this->load->model('detail_model');
        $page = (int)($this->input->get('page', true));
        $per_page = 5;
        
        $ret = $this->detail_model->getTradeList($this->input->get('complex_idx', true), $this->input->get('complex_type', true),$area_no ,$this->input->get('transtype', true), $page,$per_page);
        foreach ($ret as &$row) {
            $row['TRADE_YM'] = substr($row['TRADE_YM'], 0, 4) . '. ' . (int)substr($row['TRADE_YM'], -2 ).'월';
            $row['rangecode']='';
        }
        echo json_encode( array('code'=>200, 'data'=>$ret, 'nextpage'=> $page+1,"complex_idx"=> $this->input->get('complex_idx', true),"complex_type"=>$this->input->get('complex_type', true), "area_no"=>'N'.$area_no,"transtype"=>$this->input->get('transtype', true)  ) , true, 43200 );
    }
    
    // 단지매물
    function getComplexSaleList()
    {
        $condition['transtype'] = $this->input->get('transtype');
        $condition['area'] = $this->input->get('area');
        $condition['saleprice'] = $this->input->get('saleprice');
        $condition['charterprice'] = $this->input->get('charterprice');
        $condition['monthly_deposit'] = $this->input->get('monthly_deposit');
        $condition['monthly'] = $this->input->get('monthly');
        
        $condition['ROOM_TYPE'] = isset($_GET['ROOM_TYPE']) ? $_GET['ROOM_TYPE']:'';
        if(is_array($condition['ROOM_TYPE']) && count($condition['ROOM_TYPE'])==1 && $condition['ROOM_TYPE'][0]=='all') $condition['ROOM_TYPE'] = '';
        
        $useridx = $this->is_login==true ? $this->userinfo['MBR_IDX'] : '-1';
        $this->load->model('find_model');
        $res = $this->find_model->saleComplexList($this->input->get('complex_id',true), $this->input->get('complex_type',true), $condition, $useridx);
        echo json_encode(array('code'=>'200', 'data'=>$res));
    }
    
    // 원룸 위치
    private function oneroomposition($res)
    {
        $ret = array("POSITION"=>array(), "data"=>$res);
        $position = array();
        if( count($res) < 1 ) return $ret;
        foreach($res as &$row) {
            if( $row['GOODS_STATUS'] =='SB' ) {
                $position[] = array('lat'=>$row['lat'], 'lng'=>$row['lng']);
            }
        }
        
        $ret['POSITION'] = $position;
        
        return $ret;
    }
}