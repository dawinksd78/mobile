<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sendfile extends MY_Controller
{
    function __construct() {
        parent::__construct();
    }
    
    public function _remap($method)
    {
        parent::_remap('child_renmap');
        if( !$this->is_login ) {
            echo json_encode(array("error"=>"로그인후 사용해주세요"));
            return;
        }
        else if( $this->userinfo['MBR_GUBUN'] !='PU') {
            echo json_encode(array("error"=>"일반사용자가 아닙니다."));
            return;
        }
        $this->{$method}();
    }
    
    function index() {
        // 파일 전송
    }
    
    function up()
    {
        $loadCategory = $this->uri->segment(3);
        $inout = $this->uri->segment(4);
        $allowed = array("image/jpeg", "image/gif", "image/png");
        
        if( $loadCategory === false || !in_array($loadCategory, array('APT','OFT','ONE')) ) {
            echo json_encode(array('code'=>'600', "msg"=>"구분이 잘못됐습니다."));
            return;
        }
        
        if( $inout === false || !in_array($inout, array('in','out')) ) {
            echo json_encode(array('code'=>'t01', "msg"=>"구분이 잘못됐습니다."));
            return;
        }
        
        if( $_FILES['files']['error'] ) {
            echo json_encode(array('code'=>'602', "msg"=>"파일업로드 중 에러가 발생했습니다."));
            return;
        }
        else if(!in_array($_FILES['files']['type'], $allowed)) {
            echo json_encode(array('code'=>'603', "msg"=>"jpg, gif, png 파일만 업로드가 가능합니다."));
            return;
        }
        else if( $_FILES['files']['size']/1024/1024 > 4 ) {
            echo json_encode(array('code'=>'604', "msg"=>"최대 4M까지만 업로드가 가능합니다."));
            return;
        }
        
        $this->load->model("S3_model");
        $res = $this->S3_model->uploadFromTmp( $this->S3_model->makePrefix('sale'),$_FILES['files']['tmp_name'],$_FILES['files']['type']  );
        
        if(isset($res['code']) && $res['code']==200) {
            $this->db->insert('TB_TMP_FOR_SALE_IMAGE', array("MBR_IDX"=>$this->userinfo['MBR_IDX'], "CATEGORY"=>$loadCategory, "INOUT"=>$inout, "FILEKEY"=>$res['key'],"IMG_FULL_PATH"=>$res['url'] ));
            $insid = $this->db->insert_id();
            echo json_encode(array('code'=>'200',"newUuid"=>$insid,"data"=>$res['url']));
        }
        else if( isset($res['code']) && isset($res['msg'])) {
            echo json_encode( $res );
        }
        else {
            echo json_encode( array('code'=>'0','msg'=>"잠시 후에 다시 시도해주세요.") );
        }
    }
    
    function del()
    {
        $uuid = (int)($this->input->post('uuid', true));
        $qry = $this->db->query("select FILEKEY from TB_TMP_FOR_SALE_IMAGE where IMG_IDX= ? and MBR_IDX = ?", array($uuid,$this->userinfo['MBR_IDX'] ) );
        if($qry->num_rows() < 1) {
            echo json_encode(array('code'=>'1', "msg"=>"파일정보를 찾을 수 없습니다."));return;
        }
        else
        {
            $row = $qry->row_array();
            $this->load->model("S3_model");
            $res = $this->S3_model->delimage( $row['FILEKEY']);
            if( $res['code']==200 ) {
                $qry=$this->db->where('IMG_IDX', $uuid)->where ('MBR_IDX',$this->userinfo['MBR_IDX'])->delete('TB_TMP_FOR_SALE_IMAGE');
                if( $qry ) echo json_encode(array('code'=>'200'));
                else echo json_encode(array('code'=>'500', "msg"=>"잠시 후에 다시 시도해 주세요"));
            }
            else echo json_encode($res);
        }
    }
    
    // 상품이미지 수정
    function chkGoodsSTatus( $goods_idx )
    {
        $this->load->model("sellhome_model");
        $goods_info = $this->sellhome_model->goodsInfo($goods_idx );
        
        if( $goods_info === false ) {
            echo json_encode(array("code"=>"404", "msg"=>"매물을 찾을 수 없습니다") );
            exit;
        }
        
        if( !in_array($goods_info['GOODS_STATUS'], array("BL","SB")) ) {
            echo json_encode(array("code"=>"501", "msg"=>"매물 정보를 수정할 수 없습니다") );
            exit;
        }
        
        if( $goods_info['REG_MBR_IDX'] != $this->userinfo['MBR_IDX'] ) {
            echo json_encode(array("code"=>"500", "msg"=>"매물 정보를 수정할 수 없습니다") );
            exit;
        }
        
        return $goods_info;
    }
    
    // 수정단계에서 이미지 삭제
    function delGoodImg()
    {
        $imgidx = $this->input->post("uuid");
        $qry = $this->db->get_where('TB_UM_GOODS_IMG', array("GOODS_IMG_IDX"=>(int)$imgidx));
        if($qry->num_rows() < 1) {
            echo json_encode(array('code'=>'404', "msg"=>"이미지 정보를 찾을 수 없습니다."));
            return;
        }
        
        $imginfo = $qry->row_array();
        $goods_info = $this->chkGoodsSTatus($imginfo['GOODS_IDX']);
        $this->load->model("S3_model");
        $res = $this->S3_model->delimage($imginfo['FILE_NAME']);
        if( $res['code']==200 ) {
            $qry = $this->db->where('GOODS_IMG_IDX', $imginfo['GOODS_IMG_IDX'])->delete('TB_UM_GOODS_IMG');
            if($qry)
            {
                // 메인 이미지 처리
                $this->load->model("goods_model");
                $this->goods_model->makeGoodsDefaultImg($imginfo['GOODS_IDX']);
                
                echo json_encode(array('code'=>'200'));
            }
            else {
                echo json_encode(array('code'=>'500', "msg"=>"잠시 후에 다시 시도해 주세요"));
            }
        }
        else {
            echo json_encode( $res ) ;
        }
        
        return;
    }
    
    function goodsImgUp()
    {
        $inout = $this->uri->segment(3);
        $idx = $this->uri->segment(4);
        $goods_info = $this->chkGoodsSTatus($idx);
        $allowed = array("image/jpeg", "image/gif", "image/png");
        if( $inout === false || !in_array($inout, array('in','out')) ) {
            echo json_encode(array('code'=>'501', "msg"=>"구분이 잘못됐습니다."));
            return;
        }
        
        if($_FILES['files']['error']) {
            echo json_encode(array('code'=>'602', "msg"=>"파일업로드 중 에러가 발생했습니다."));
            return;
        }
        else if(!in_array($_FILES['files']['type'], $allowed)) {
            echo json_encode(array('code'=>'603', "msg"=>"jpg, gif, png 파일만 업로드가 가능합니다."));
            return;
        }
        else if( $_FILES['files']['size']/1024/1024 > 4 ) {
            echo json_encode(array('code'=>'604', "msg"=>"최대 4M까지만 업로드가 가능합니다."));
            return;
        }
        
        $this->load->model("S3_model");
        $res = $this->S3_model->uploadFromTmp( $this->S3_model->makePrefix('sale'),$_FILES['files']['tmp_name'],$_FILES['files']['type']  );
        if( isset($res['code']) && $res['code']==200 )
        {
            $url = parse_url($res['url']);
            $tmp['GOODS_IDX'] = $goods_info['GOODS_IDX'];
            $tmp['SERVER_PATH']= $url['scheme']."://".$url['host'];
            $tmp['FULL_PATH'] = $url['path'];
            $tmp['FILE_NAME'] = $res['key'];
            $tmp['FILE_SEPARATE'] = strtoupper($inout);
            $tmp['FILE_CATEGORY'] = $goods_info['CATEGORY'];
            $tmp['DISPLAY_FLAG'] ='Y';
            $nextorder = $this->db->select( "IFNULL(max(`SORT_ORDER`) + 1, 1) as next_num")->get_where("TB_UM_GOODS_IMG", array("GOODS_IDX"=>$goods_info['GOODS_IDX'],"FILE_SEPARATE"=> strtoupper($inout) ) )->row_array();
            $tmp['SORT_ORDER'] = $nextorder['next_num'];
            $this->db->insert("TB_UM_GOODS_IMG", $tmp);
            $insid = $this->db->insert_id();
            
            // 메인 이미지 처리
            $this->load->model("goods_model");
            $this->goods_model->makeGoodsDefaultImg($idx);
            
            echo json_encode(array('code'=>'200',"newUuid"=>$insid,"data"=>$res['url']));
        }
        else if( isset($res['code']) && isset($res['msg'])) {
            echo json_encode( $res );
        }
        else {
            echo json_encode(array('code'=>'0','msg'=>"잠시 후에 다시 시도해주세요.") );
        }
        
        return;
    }
}
