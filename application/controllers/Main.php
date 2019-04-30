<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    
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
    public function index()
    {
        // 앱정보 저장
        $this->load->helper('cookie');
        $data['PUSHKEY'] = get_cookie('PUSHKEY');
        //$data['UDID'] = get_cookie('UDID');
        $data['DEVICE'] = get_cookie('DEVICE');
        
        //if($data['PUSHKEY'] == '' && $data['DEVICE'] == '') {
            //$this->load->view("nice", array("url"=>"/main/mobileApp"));
        //}
        //else
        //{
            $useridx = $this->userinfo['MBR_IDX'];
            
            // 알람체크
            if($useridx > 0)
            {
                $sql = "SELECT SMS_SEND_RESULT_IDX FROM TB_CB_SMS_SEND_RESULT WHERE MBR_IDX='$useridx' AND VIEW_DATE IS NULL";
                $qry = $this->db->query($sql);
                $data['alarmCnt'] = $qry->num_rows();
            }
            else $data['alarmCnt'] = 0;
    
            $this->load->view('header', $data);
            $this->load->view('main');
            $this->load->view('footer');
        //}
    }
    
    // 다윈중개 평가하기
    public function appraisal() {
        $this->load->view('appraisal');
    }
    
    // 다윈중개 앱설치 페이지
    public function mobileApp() {
        $this->load->view('mobileApp');
    }    
}
