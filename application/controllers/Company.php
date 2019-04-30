<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
    
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
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('dawininfo/info', $data);
        $this->load->view('sub_footer');
    }
    
    // 회사소개
    public function companyintro()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('dawininfo/companyintro_view', $data);
        $this->load->view('sub_footer');
    }
    
    // 이용약관
    public function terms()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('dawininfo/terms', $data);
        $this->load->view('sub_footer');
    }
    
    // 개인정보처리방침
    public function privacy()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('dawininfo/privacy', $data);
        $this->load->view('sub_footer');
    }
    
    // 다윈중개 중개보수요율표
    public function bkpee()
    {
        $data['BROKER_OFFICE_NAME'] = '';
        $data['LAT'] = '';
        $data['LNG'] = '';
        
        $this->load->view('sub_header');
        $this->load->view('dawininfo/bkpee', $data);
        $this->load->view('sub_footer');
    }
}
