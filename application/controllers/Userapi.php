<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userapi extends My_Controller
{
    public $userinfo;

    function __construct() {
        parent::__construct();
    }
    
    /*public function _remap($method)
    {
  		$this->userinfo = $this->session->userdata('usesrinfo');
        session_write_close();
        if(!isset($this->userinfo['MBR_IDX']) || (int)$this->userinfo['MBR_IDX'] < 1) {
            echo json_encode('login');
            return;
        }
        $this->{$method}();
    }*/
    
	// 좋아요 추가, 삭제, 리스트
    public function favorite()
    {
        if($this->input->server('REQUEST_METHOD') == 'GET')
        {
            $goods_idx = $this->input->get('saleno', true);
            $on = $this->input->get('on', true);
            
            if((int)$goods_idx < 1) {
                echo json_encode(array("code"=>"405"));
                return;
            }
            
            if($on == 'on') $on = true;
            else if($on == 'off') $on = false;
            else {
                echo json_encode(array("code"=>"405"));
                return;
            }
            
            $this->load->model('member_model');
            $res = $this->member_model->setFavorite($this->userinfo['MBR_IDX'], $goods_idx, $on);
            
            if($res) {
                echo json_encode(array("code"=>"200"));
                return;
            }
            else {
                echo json_encode(array("code"=>"501"));
                return;
            }
        }
        else
        {
            $this->load->model('member_model');
            $res = $this->member_model->getFavlrite($this->userinfo['MBR_IDX']);
            echo json_encode(array("code"=>"200", "data"=>$res));
            return;
        }
    }
    
    //--------------------------------------------------------------//
    
    //추가 20190425 임성택
    //qna list
    function getQna()
    {
        $page = (int)$this->input->get('page');
        $perpage = (int)$this->input->get('perpage');
        if( $perpage < 1) $perpage = 5;
        $data['code'] = 200;
        $this->load->model("Member_model");
        $data['data'] = $this->Member_model->getQnaList($this->userinfo['MBR_IDX'], $page, $perpage);
        if (count($data)> $perpage ) {
            array_pop($data);
            $data['nextpage'] = "on";
        }else $data['nextpage'] = "off";
        $this->json_encode($data);
    }
    
    function getQnaAns()
    {
        $ret['code']=200;
        $ret['idx'] = $data['QNA_IDX'] = (int)$this->input->get("idx");
        $ret['category'] = $data['TB'] = $this->input->get("category", true);
        $data['MBR_IDX'] = $this->userinfo['MBR_IDX'];
        if ($data['TB'] != 'UA') $data['TB'] = 'UH_DW';
        $this->load->model("Member_model");
        $ret['data'] = $this->Member_model->getQnaAns($data);
        $this->json_encode($ret);
    }
    
    function setQuestionMore()
    {
        $cont = trim(htmlspecialchars($this->input->post('question', true),ENT_QUOTES));
        $data['QNA_IDX'] = (int)($this->input->post('idx', true));
        $tb = $this->input->post('tb', true);
        if( !in_array($tb, array('UA', 'UH_DW')) ) return $this->json_encode( array("code"=> 405));
        else if ( $cont =='') return $this->json_encode( array("code"=> 400, "댓글을 적어주세요"));
        else
        {
            $this->load->model("Member_model");
            $auth = $this->Member_model->checkauthQna($this->userinfo['MBR_IDX'], $data['QNA_IDX'], $tb);
            if(!$auth) return $this->json_encode( array("code"=> 501));
            else
            {
                if( $tb =='UA') $data['CONTENTS'] = $cont;
                else $data['QNA_ANSWER'] = $cont;
                $data['REG_MBR_IDX'] = $this->userinfo['MBR_IDX'];
                $res = $this->Member_model->setQnaMore( $data, $tb);
                if ($res == 0) return $this->json_encode( array("code"=> 511));
                else $this->json_encode(array("code"=>200, "CONTENTS"=> $cont));
            }
        }
    }
    //추가완료 20190425 임성택
}