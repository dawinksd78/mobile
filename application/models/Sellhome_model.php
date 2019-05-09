<?php
class Sellhome_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    
    // main 초기화
    public function main_initialization($memidx)
    {
        // 이미지 파일 삭제
        $qry = $this->db->query("SELECT * FROM TB_TMP_FOR_SALE_IMAGE WHERE MBR_IDX='$memidx'");
        if($qry->num_rows() > 0)
        {
            $result = $qry->result_array();
            foreach($result as $row)
            {
                $this->load->model("S3_model");
                $res = $this->S3_model->delimage( $row['FILEKEY']);
                if($res['code'] == 200) {
                    $this->db->where('IMG_IDX', $row['IMG_IDX'])->where('MBR_IDX', $memidx)->delete('TB_TMP_FOR_SALE_IMAGE');
                }
            }
        }

        // 매물 정보 삭제
        $result = $this->db->where("MBR_IDX", $memidx)->delete('TB_TMP_FOR_SALE');
        if($result) return "SUCCESS";
        else return "FAIL";
    }
    
    // 다윈 코드값 출력
    public function getCodeList($CODE_GBN, $CODE_TYPE='A')
    {
        $sql = "SELECT * FROM TB_CB_CODE WHERE CODE_GBN = ? AND USE_YN ='Y' AND CODE_TYPE = ? ORDER BY SORT_ORDER";
        $qry = $this->db->query( $sql, array($CODE_GBN, $CODE_TYPE) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    // 정해진 동코드값 체크
    public function getAvailDongCode($chkCode='')
    {
        $sql = "SELECT LAW_DONG_CODE FROM TB_CB_ADDR a WHERE SIGUNGU_CODE IN('41117','41135','41465') AND LAW_DONG_CODE NOT IN('4111710100','4111710500','4111710600','4111710700') AND DONG !=''";
        if($chkCode !='')
        {
            $sql .= " AND LAW_DONG_CODE = ?";
            $qry = $this->db->query($sql, array($chkCode) );
            if( $qry->num_rows() > 0 ) return true;
            else return false;
        } else return $this->db->query($sql)->result_array();
    }
    
    // 동코드 출력
    public function getDongCode($SIGUNGU_CODE)
    {
        $qry = $this->db->query("SELECT LAW_DONG_CODE as DONG_CODE, DONG FROM TB_CB_ADDR a WHERE SIGUNGU_CODE = ?  and USE_YN='Y' AND DONG !=''", array($SIGUNGU_CODE));
        if( $qry->num_rows() > 0 ) {
            return   $qry->result_array();
        }
        else return array();
    }
    
    // 동코드 지역 출력
    function getComplexDHinfo($complex_idx, $complex_type)
    {
        $sql = "SELECT * FROM TB_CB_COMPLEX_DH_AREA a WHERE COMPLEX_IDX = ? and COMPLEX_TYPE = ? ORDER BY floor(a.DONGNM), floor(a.HO)";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type));
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else return false;
    }
    
    // 단지 검색
    public function getDongComplex($DONG_CODE, $COMPLEX_TYPE)
    {
        $sql = "SELECT
                    a.COMPLEX_IDX, a.COMPLEX_NAME, LAT, LNG, a.HIGH_FLOOR, a.LOW_FLOOR, ifnull(a.DONGS, '-|-|-|-') AS DONGS,
                    group_concat(concat(b.SUPPLY_AREA,',', b.EXCLUSIVE_AREA ) SEPARATOR '|' ) AS area
                FROM TB_CB_COMPLEX a JOIN TB_CB_COMPLEX_AREA b ON a.COMPLEX_IDX = b.COMPLEX_IDX AND a.COMPLEX_TYPE = b.COMPLEX_TYPE
                WHERE a.LAW_DONG_CODE = ? and a.COMPLEX_TYPE = ?
                GROUP BY a.TB_CB_COMPLEX_IDX";
        $qry = $this->db->query( $sql, array($DONG_CODE, $COMPLEX_TYPE) );
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 단지내 동검색 및 면적 출력
    function getComplexDonginfo($complex_idx, $complex_type)
    {
        /*
        $sql = "SELECT DONGNM FROM TB_CB_COMPLEX_DH_AREA WHERE COMPLEX_IDX = ? AND COMPLEX_TYPE = ? GROUP BY DONGNM ORDER BY floor(DONGNM)";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type) );
        //$sql = "SELECT dongNo as DONGNM FROM nv_complex_dong WHERE complexNo = ? ORDER BY sortNo";
        //$qry = $this->db->query($sql, array($complex_idx) );
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return false;
        }
        */
        
        // 단지내 동 출력
        $sql = "(SELECT dongNo as complexDongNo, bildName as complexDongName FROM TB_CB_COMPLEX_DONG a JOIN nv_dong_unmatch b ON a.complexNo = b.complexNo AND b.dongOrHo = 'HO' WHERE a.complexNo = ? ORDER BY sortNo)
                UNION (SELECT dongNo as complexDongNo, bildName as complexDongName FROM TB_CB_COMPLEX_DONG2 a WHERE a.complexNo = ? ORDER BY sortNo)";
        $qry = $this->db->query($sql, array($complex_idx, $complex_idx));
        if( $qry->num_rows() > 0 ) $rows = $qry->result_array();
        else {
            $qry = $this->db->select('dongNo as complexDongNo, bildName as complexDongName')->where('complexNo', $complex_idx)->order_by('sortNo')->get('TB_CB_COMPLEX_DONG');
            if( $qry->num_rows() > 0 ) $rows = $qry->result_array();
            else $rows = array();
        }
        
        // 단지내 면적 출력
        $qry = $this->db->select('AREA_NO as idx, AREA_NAME as areaName ,SUPPLY_AREA supplyArea, EXCLUSIVE_AREA exclusiveArea, SUPPLY_PYEONG pyeong')
                    ->where('COMPLEX_IDX',$complex_idx)
                    ->where('COMPLEX_TYPE', $complex_type)
                    ->order_by('SUPPLY_AREA, EXCLUSIVE_AREA')->get('TB_CB_COMPLEX_AREA');
        if($qry->num_rows() > 0) $rows2 = $qry->result_array();
        else $rows2 = array();
        
        return array("rows"=>$rows, "rows2"=>$rows2);
    }
    
    // 단지내 동내 층검색
    function getComplexFloorinfo($complex_idx, $complex_type, $complex_dong)
    {
        $sql = "SELECT flrNo FROM TB_CB_COMPLEX_DH_AREA WHERE COMPLEX_IDX = ? AND COMPLEX_TYPE = ? AND DONGNM = ? GROUP BY flrNo";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type, $complex_dong) );
        if( $qry->num_rows() > 0 )
        {
            //return $qry->result_array();
            $data = $qry->result_array();
            foreach($data as $info)
            {
                $subSql = "SELECT HIGH_FLOOR FROM TB_CB_COMPLEX WHERE COMPLEX_IDX='$complex_idx'";
                $subQry = $this->db->query($subSql);
                $subInfo = $subQry->row_array();
                $list[] = array("flrNo"=>$info['flrNo'], "TOTAL_FLOOR"=>$subInfo['HIGH_FLOOR']);
            }
            return $list;
        }
        else {
            return false;
        }
    }
    
    // 단지내 동내 호검색
    function getComplexFloorHoinfo($complex_idx, $complex_type, $complex_dong, $complex_floor)
    {
        $sql = "SELECT HO, AREA1, AREA2 FROM TB_CB_COMPLEX_DH_AREA WHERE COMPLEX_IDX = ? AND COMPLEX_TYPE = ? AND DONGNM = ? AND flrNo = ? ORDER BY HO ASC";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type, $complex_dong, $complex_floor) );
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return false;
        }
    }
    
    // 단지내 동내 면적검색 (중지)
    function getComplexFloorHoAreainfo($complex_idx, $complex_type, $complex_dong, $complex_floor, $complex_ho)
    {
        $sql = "SELECT HO, AREA1, AREA2 FROM TB_CB_COMPLEX_DH_AREA WHERE COMPLEX_IDX = ? AND COMPLEX_TYPE = ? AND DONGNM = ? AND flrNo = ? AND HO = ? ORDER BY HO ASC";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type, $complex_dong, $complex_floor, $complex_ho) );
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return false;
        }
    }
    // 단지내 동내 면적검색 (사용)
    function getComplexFloorHoAreainfoNew($complex_idx, $complex_type)
    {
        $sql = "SELECT AREA_NO AS idx, AREA_NAME AS areaName ,SUPPLY_AREA supplyArea, EXCLUSIVE_AREA exclusiveArea, SUPPLY_PYEONG pyeong FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX=? AND COMPLEX_TYPE=? ORDER BY SUPPLY_AREA, EXCLUSIVE_AREA";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type) );
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return false;
        }
    }
    
    // 단지 위치 검색
    public function map_position_result($COMPLEX_IDX)
    {
        $sql = "SELECT COMPLEX_NAME, LAT, LNG FROM TB_CB_COMPLEX WHERE COMPLEX_IDX = '$COMPLEX_IDX'";
        $qry = $this->db->query( $sql );
        if($qry->num_rows() > 0) {
            return $qry->row_array();
        }
        else {
            return array();
        }
    }
    
    // 매물 옵션 리스트
    public function goodsOptionList($type) {
        $sql = "SELECT right(CODE_DETAIL,2) AS CODE_DETAIL, CODE_NAME, `COMMENT` FROM  TB_CB_CODE WHERE CODE_GBN='OPTIONs' AND CODE_TYPE = ? AND USE_YN ='Y' ORDER BY SORT_ORDER";
        return $this->db->query($sql, array($type))->result_array();
    }
    
    // 매물정보
    function goodsInfo($goods_idx)
    {
        $sql = "SELECT goods.*, cpx.COMPLEX_NAME FROM TB_UM_GOODS goods LEFT JOIN TB_CB_COMPLEX cpx ON goods.COMPLEX_IDX = cpx.COMPLEX_IDX AND goods.CATEGORY = cpx.COMPLEX_TYPE WHERE goods.GOODS_IDX = ?";
        $qry = $this->db->query($sql, array($goods_idx));
        if( $qry->num_rows() > 0 ) {
            return   $qry->row_array();
        }
        else return false;
    }
    
    //------------------------------------------------------------------------------//
           
    // 집내놓기 1단계 정보 확인
    public function step1Info()
    {
        $qry = $this->db->get_where("TB_TMP_FOR_SALE", array("MBR_IDX"=>$this->userinfo['MBR_IDX']));
        if( $qry->num_rows() > 0 ) {
            return $qry->row_array();
        }
        else {
            return array();
        }
    }
    
    // 집내놓기 4단계 선택된 브로커 목록
    public function step4_selBrokerLists($memidx)
    {
        $sql = "
            SELECT
            	bo.*, mem.*
            FROM TB_AB_BROKER_OFFICE bo
            JOIN TB_UB_MEMBER mem ON bo.BROKER_OFFICE_IDX = mem.MBR_IDX AND mem.MBR_STATUS='NM'
            left JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX = bo_ac.MBR_IDX AND bo_ac.DEL_YN ='Y'
            WHERE bo.BROKER_OFFICE_IDX IN ($memidx) AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')
        ";
        //$qry = $this->db->query($sql, array($memidx));
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 집내놓기 4단계 브로커 목록
    public function step4_brokerLists($lat, $lng)
    {
        $sql = "
            SELECT
            	bo.*, mem.*
            FROM TB_AB_BROKER_OFFICE bo
            JOIN TB_UB_MEMBER mem ON bo.BROKER_OFFICE_IDX = mem.MBR_IDX AND mem.MBR_STATUS='NM'
            left JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX = bo_ac.MBR_IDX AND bo_ac.DEL_YN ='Y'
            WHERE bo.LAT=? AND bo.LNG=? AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')
        ";
        $qry = $this->db->query($sql, array($lat, $lng));
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 집내놓기 4단계 문의하기 처리
    public function step4_inquiry_process($INPUTDATA)
    {
        $memidx = $INPUTDATA['memidx'];
        $officeidx = $INPUTDATA['officeidx'];
        $contents = $INPUTDATA['contents'];
        $goods_idx = $INPUTDATA['goods_idx'];
        
        $data = array('MBR_IDX'=>$memidx, 'BROKER_OFFICE_IDX'=>$officeidx, 'GOODS_IDX'=>$goods_idx, 'QNA_CATEGORY'=>'FQ3', 'CONTENTS'=>$contents);
        $res = $this->db->insert('TB_UA_QNA', $data);
        if($res) return "SUCCESS";
        else return "FAIL";
    }
    
    //------------------------------------------------------------------------------//
    
    // 집내놓기 단계별 저장 처리
    function saveStepProcess($INPUTDATA, $step)
    {        
        if( !isset($data['istmp']) ) $data['istmp'] = "true";
        $data[$INPUTDATA['CATEGORY']][ $step ] = $INPUTDATA;
       
        $qry = $this->db->get_where("TB_TMP_FOR_SALE", array("MBR_IDX"=>$this->userinfo['MBR_IDX']));
        if($qry->num_rows() > 0)
        {
            $jsondata = $qry->row_array();
            $json = json_decode($jsondata['CONTENT'],true);
            if(isset($json[$INPUTDATA['CATEGORY']]))
            {
                foreach($json[$INPUTDATA['CATEGORY']] as $idx => $row) {
                    if($idx == $step) continue;
                    else $data[$INPUTDATA['CATEGORY']][$idx] = $row;
                }
                $data = array_merge( $json, $data);
            }
            else {
                $data = array_merge( $json, $data);
            }
            
            $data['last_category'] = $INPUTDATA['CATEGORY'];
            $data['last_step'] = $step;
            $data[$INPUTDATA['CATEGORY']]["regdate"] = date("YmdHis");
            $cont = json_encode($data);
            $ins = $this->db->where("MBR_IDX",$this->userinfo['MBR_IDX'])->update("TB_TMP_FOR_SALE", array("CONTENT"=>$cont));
        }
        else
        {
            $data['last_category'] = $INPUTDATA['CATEGORY'];
            $data['last_step'] = $step;
            $data[$INPUTDATA['CATEGORY']]["regdate"] = date("YmdHis");
            $cont = json_encode($data);
            $ins = $this->db->insert("TB_TMP_FOR_SALE", array("MBR_IDX"=>$this->userinfo['MBR_IDX'],"CONTENT"=>$cont));
        }
        
        return "SUCCESS";
                
        /*if($ins !== false)
        {
            // 파일업로드
            if( $step < 'step_3') {
                $this->load->model("S3_model");
                $this->S3_model->delSalepicture($this->userinfo['MBR_IDX'], $INPUTDATA['CATEGORY'] );
            }
            
            if($this->db->affected_rows()>0 || $ins == true) return "SUCCESS";
            else return "FAIL";
        }
        else {
            return "FAIL";
        }*/
    }
    
    // 집내놓기 임시 저장값
    public function getTemp($MBR_IDX)
    {
        $qry = $this->db->get_where('TB_TMP_FOR_SALE', array('MBR_IDX'=>(int)$MBR_IDX));
        if( $qry->num_rows() > 0 ) {
            return   $qry->row_array();
        }
        else return array();
    }
    
    // 중개사 정보
    public function brokerOfficeInfo($brokeridx)
    {
        $sql = "SELECT bo.*, mb.* FROM TB_AB_BROKER_OFFICE as bo, TB_UB_MEMBER as mb WHERE bo.BROKER_OFFICE_IDX = '$brokeridx' AND bo.BROKER_OFFICE_IDX=mb.MBR_IDX AND mb.MBR_STATUS='NM' AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')";
        $qry = $this->db->query($sql);
        if($qry->num_rows() > 0) {
            return $qry->row_array();
        }
        else {
            return array();
        }
    }
    
    // 중개사 리뷰
    public function brokerOfficeReview($brokeridx)
    {
        $sql = "SELECT * FROM TB_UA_BROKER_EVALUATION WHERE BROKER_OFFICE_IDX = '$brokeridx' ORDER BY EVALUATION_IDX DESC";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 중개사 프로필
    function getProfile($brokeridx)
    {
        $sql = "
            SELECT
            	bo.*, mem.MBR_NAME, mem.MBR_IMAGE_FULL_PATH , if( bo_ac.ACC_END_DATE > CURDATE() , 'Y', 'N') AS ended
            FROM TB_AB_BROKER_OFFICE bo
            JOIN TB_UB_MEMBER mem ON bo.BROKER_OFFICE_IDX = mem.MBR_IDX AND mem.MBR_STATUS='NM'
            left JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX = bo_ac.MBR_IDX AND bo_ac.DEL_YN ='Y'
            WHERE bo.BROKER_OFFICE_IDX = ? AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')
        ";
        $qry = $this->db->query($sql, array($brokeridx));
        if ($qry->num_rows() > 0) return $qry->row_array();
        else return array();
    }
    
    // 소속공인중개사 및 보조원들
    function getOfficeBelong($brokeridx) {
        $sql = "SELECT a.BR_GUBUN, a.BR_NAME, a.BR_PROFILE_IMG FROM TB_AB_BROKER_BELONG a WHERE a.BROKER_OFFICE_IDX = ? ORDER BY a.BROKER_BELONG_IDX;";
        $qry = $this->db->query($sql, array($brokeridx));
        if($qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
}