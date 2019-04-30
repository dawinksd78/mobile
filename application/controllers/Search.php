<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller
{
    function __construct() {
        parent::__construct();
    }
    
    // 주소 기반 검색
    function index()
    {
        $saletype = $this->input->get_post('saletype', true);
        $keywords = $this->input->get_post('keywords', true);
        $keywords = preg_replace('/\s+/', ' ', trim($keywords)) ;
        if( mb_strlen($keywords, "UTF-8") < 2 ) return false;
        if( !in_array( $saletype , array('APT','OFT','ONE')) )  $saletype = 'APT';
        $keywordArr = explode(" ", $keywords);

        $this->load->model('search_model');
        $res = $this->search_model->init($keywordArr, $saletype);
        if($res === false) echo json_encode( array('code'=>'404', 'data'=>array() ) );
        else {
            echo json_encode( array('code'=>'200', 'data'=>$res ), true );
        }
    }
    
    // 중개사 찾기
    function broker()
    {
        $this->load->model("agentinfo_model");
        $res = $this->agentinfo_model->findUseName(trim($this->input->get('name', true)) );
        echo json_encode( array('code'=>'200', 'data'=>$res ), true, 300 );
    }
}
