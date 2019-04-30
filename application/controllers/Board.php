<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends MY_Controller
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
    public function index() {
        // pageSetup
    }
    
    //--------------------------------------------------------------//
    
    // FAQ Category
    public function faq()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->model('board_model');
        
        // FAQ 카테고리 출력
        $data['categorylist'] = $this->board_model->faqcategory();
               
        $this->load->view('sub_header');
        $this->load->view('board/faq', $data);
        $this->load->view('sub_footer');
    }
    
    // FAQ List
    public function faqlist()
    {
        $category = $this->input->get_post('category');
        
        $this->load->model('board_model');
        $faqlistcontents = $this->board_model->faqlistcontents($category);
        foreach($faqlistcontents as $info){
            $list[] = array("idx"=>$info['FAQ_IDX'], "question"=>$info['QUESTION'], "answer"=>$info['ANSWER']);
        }
        
        echo json_encode($list);
    }
    
    //--------------------------------------------------------------//
    
    // 1:1문의
    public function inquiry()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->model('board_model');
        
        // FAQ 카테고리 출력
        $data['categorylist'] = $this->board_model->inquirycategory();
        
        $this->load->view('sub_header');
        $this->load->view('board/inquiry', $data);
        $this->load->view('sub_footer');
    }
    
    // 1:1문의 처리
    public function inquiryprocess()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $INPUTDATA['memberidx'] = $this->userinfo['MBR_IDX'];
        $INPUTDATA['inquirycate'] = $this->input->post('inquirycate');
        $INPUTDATA['title'] = $this->input->post('title');
        $INPUTDATA['contents'] = $this->input->post('contents');
        
        $this->load->model('board_model');
        $data['result'] = $this->board_model->inquiryprocessresult($INPUTDATA);
        
        $this->load->view('sub_header');
        $this->load->view('board/inquiryprocessview', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 중개사 신고하기 (메인)
    public function reportbroker()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $data['brokerinfo'] = array();
        
        $this->load->model('board_model');
        
        // 선택한 브로커 출력
        $brokeridx = $this->input->get_post('brokeridx');   // 선택한 브로거 번호
        if($brokeridx != '') {
            $data['brokerinfo'] = $this->board_model->selectbroker($brokeridx);
        }
        
        $this->load->view('sub_header');
        $this->load->view('board/reportbroker', $data);
        $this->load->view('sub_footer');
    }
    
    // 중개사 신고하기 (중개사 선택)
    public function reportbrokerchoice()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $memberidx = $this->userinfo['MBR_IDX'];
        
        $this->load->model('board_model');
        
        // 매물의뢰한 중개사 선택
        $data['brokerlist'] = $this->board_model->brokerlist($memberidx);
        
        $this->load->view('sub_header');
        $this->load->view('board/reportbrokerchoice', $data);
        $this->load->view('sub_footer');
    }
    
    // 중개사 신고하기 처리
    function reportbrokerprocess()
    {
        $data = array();
        
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $INPUTDATA['brokerofficeidx'] = $this->input->post('brokerofficeidx');
        $INPUTDATA['rept'] = $this->input->post('rept');
        $INPUTDATA['reptExplain'] = $this->input->post('reptExplain');
        $INPUTDATA['memberidx'] = $this->userinfo['MBR_IDX'];
        
        $this->load->model('board_model');
        $data['result'] = $this->board_model->reportbrokerprocessresult($INPUTDATA);
        
        $this->load->view('sub_header');
        $this->load->view('board/reportbrokerprocessview', $data);
        $this->load->view('sub_footer');
    }
    
    //--------------------------------------------------------------//
    
    // 주소지 검색 (시도)
    public function search_sido()
    {
        $this->load->model('board_model');
        $result = $this->board_model->addr_sido_list();
        foreach($result as $info){
            $list[] = array("sido_code"=>$info['SIDO_CODE'], "sido"=>$info['SIDO']);
        }
        
        echo json_encode($list);
    }
    
    // 주소지 검색 (구군)
    public function search_gugun()
    {
        $DATA['broker'] = $this->uri->segment(3);
        $DATA['sido'] = $this->input->get_post('sido');
        
        $this->load->model('board_model');
        $result = $this->board_model->addr_gugun_list($DATA);
        foreach($result as $info){
            $list[] = array("gugun_code"=>$info['SIGUNGU_CODE'], "gugun"=>$info['SIGUNGU']);
        }
        
        echo json_encode($list);
    }
    
    // 주소지 검색 (동)
    public function search_dong()
    {
        $DATA['broker'] = $this->uri->segment(3);
        $DATA['gugun'] = $this->input->get_post('gugun');
        
        $this->load->model('board_model');
        $result = $this->board_model->addr_dong_list($DATA);
        foreach($result as $info){
            $list[] = array("dong_code"=>$info['DONG_CODE'], "dong"=>$info['DONG']);
        }
        
        echo json_encode($list);
    }
    
    //--------------------------------------------------------------//
    
    // 중개사 검색
    public function brokerofficesearch()
    {
        $SENDDATA['broker_search'] = urldecode($this->input->get_post('broker_search'));
        $SENDDATA['sido'] = $this->input->get_post('sido');
        $SENDDATA['gugun'] = $this->input->get_post('gugun');
        $SENDDATA['dong'] = $this->input->get_post('dong');
        $SENDDATA['memberidx'] = $this->userinfo['MBR_IDX'];
        
        $this->load->model('board_model');
        
        // 검색된 중개사 선택
        $result = $this->board_model->brokersearchlist($SENDDATA);
        if($result != '')
        {
            foreach($result as $info)
            {
                $list[] = array(
                    "office_idx"=>$info['BROKER_OFFICE_IDX'], 
                    "office_name"=>$info['OFFICE_NAME'], 
                    "office_phone"=>$info['PHONE'], 
                    "office_addr1"=>$info['ADDR1'],
                    "office_username"=>$info['MBR_NAME']
                );
            }
            
            echo json_encode($list);
        }
        else {
            echo false;
        }
    }
    
    //--------------------------------------------------------------//
    
    // 중개사 가입시 정보 검색
    public function brokerofficejoinsearch()
    {
        $SENDDATA['broker_search'] = urldecode($this->input->get_post('broker_search'));
        $SENDDATA['sido'] = $this->input->get_post('sido');
        $SENDDATA['gugun'] = $this->input->get_post('gugun');
        $SENDDATA['dong'] = $this->input->get_post('dong');
        
        $this->load->model('board_model');
        
        // 검색된 중개사 선택
        $result = $this->board_model->brokerofficejoinsearchresult($SENDDATA);
        if($result != '')
        {
            foreach($result as $info){
                $list[] = array("office_idx"=>$info['BROKER_OFFICE_INFO_IDX'], "office_name"=>$info['BROKER_OFFICE_NAME'], "broker_name"=>$info['BROKER_NAME'], "office_addr"=>$info['FULL_ADDR'], "office_lat"=>$info['LAT'], "office_lng"=>$info['LNG']);
            }
            
            echo json_encode($list);
        }
        else {
            echo false;
        }
    }
    
    // 저장된 중개사 정보 출력
    public function brokerofficesavesearch()
    {
        $brokeridx = $this->input->get_post('brokeridx');
        
        $this->load->model('board_model');
        
        // 검색된 중개사 선택
        $result = $this->board_model->brokerofficesavesearchresult($brokeridx);
        if($result != '')
        {
            foreach($result as $info)
            {
                $list[] = array(
                    "office_idx"=>$info['BROKER_OFFICE_INFO_IDX'], 
                    "office_name"=>$info['BROKER_OFFICE_NAME'], 
                    "broker_name"=>$info['BROKER_NAME'], 
                    "office_addr"=>$info['FULL_ADDR'], 
                    "office_lat"=>$info['LAT'], 
                    "office_lng"=>$info['LNG']
                );
            }
            
            echo json_encode($list);
        }
        else {
            echo false;
        }
    }
}