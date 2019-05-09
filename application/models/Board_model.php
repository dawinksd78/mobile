<?php
class Board_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    
    //--------------------------------------------------------------//
    
    // FAQ
    public function faqcategory()
    {
        $sql = "SELECT FAQ_IDX, CATEGORY FROM TB_HU_DW_FAQ WHERE QUESTION !='' AND GUBUN='USER' GROUP BY CATEGORY ORDER BY P_FAQ_IDX";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // FAQ List
    public function faqlistcontents($category)
    {
        $sql = "SELECT * FROM TB_HU_DW_FAQ WHERE CATEGORY='$category' AND QUESTION !='' AND GUBUN='USER'";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    //--------------------------------------------------------------//
    
    // 1:1 문의
    public function inquirycategory()
    {
        $sql = "SELECT * FROM TB_CB_CODE WHERE CODE_GBN='FAQ_QUESTION_GUBUN' AND CODE_TYPE='A' ORDER BY SORT_ORDER";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 1:1 문의 처리
    function inquiryprocessresult($INPUTDATA)
    {
        $memidx = $INPUTDATA['memberidx'];
        $title = $INPUTDATA['title'];
        $inquirycate = $INPUTDATA['inquirycate'];
        $contents = $INPUTDATA['contents'];
        
        // 데이터 등록
        $data = array('QNA_CATEGORY'=>$inquirycate, 'QNA_TITLE'=>$title, 'QNA_CONTENTS'=>$contents, 'MBR_IDX'=>$memidx);
        $res = $this->db->insert('TB_UH_DW_QNA', $data);
        if($res) return true;
        else return false;
    }
    
    //--------------------------------------------------------------//
    
    // 주소지 선택 (시도)
    public function addr_sido_list()
    {
        $sql = "SELECT SIDO_CODE, SIDO FROM TB_CB_ADDR WHERE USE_YN='Y' AND SIGUNGU_CODE='' AND DONG_CODE='' AND RI_CODE='' GROUP BY SIDO_CODE ORDER BY SIDO_CODE ASC";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 주소지 선택 (구군)
    public function addr_gugun_list($DATA)
    {
        $broker = $DATA['broker'];
        $sido = $DATA['sido'];
        
        if($broker != '') {
            $sql = "SELECT SIGUNGU_CODE, SIGUNGU FROM TB_CB_ADDR WHERE BROKER_USE_YN='Y' AND SIDO_CODE='$sido' AND DONG_CODE!='' AND RI_CODE='' GROUP BY SIGUNGU_CODE ORDER BY SIGUNGU ASC";
        }
        else {
            //$sql = "SELECT SIGUNGU_CODE, SIGUNGU FROM TB_CB_ADDR WHERE USE_YN='Y' AND SIDO_CODE='$sido' AND DONG_CODE!='' AND RI_CODE='' GROUP BY SIGUNGU_CODE ORDER BY SIGUNGU_CODE ASC";
            $sql = "SELECT SIGUNGU_CODE, SIGUNGU FROM TB_CB_ADDR WHERE USE_YN='Y' AND SIDO_CODE='$sido' AND DONG_CODE!='' AND RI_CODE='' GROUP BY SIGUNGU_CODE ORDER BY SIGUNGU ASC";
        }
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 주소지 선택 (동)
    public function addr_dong_list($DATA)
    {
        $broker = $DATA['broker'];
        $gugun = $DATA['gugun'];
        
        if($broker != '') {
            $sql = "SELECT DONG_CODE, DONG FROM TB_CB_ADDR WHERE BROKER_USE_YN='Y' AND SIGUNGU_CODE='$gugun' AND DONG_CODE!='' AND RI_CODE='' GROUP BY DONG_CODE ORDER BY DONG ASC";
        }
        else {
            //$sql = "SELECT DONG_CODE, DONG FROM TB_CB_ADDR WHERE USE_YN='Y' AND SIGUNGU_CODE='$gugun' AND DONG_CODE!='' AND RI_CODE='' GROUP BY DONG_CODE ORDER BY DONG_CODE ASC";
            $sql = "SELECT DONG_CODE, DONG FROM TB_CB_ADDR WHERE USE_YN='Y' AND SIGUNGU_CODE='$gugun' AND DONG_CODE!='' AND RI_CODE='' GROUP BY DONG_CODE ORDER BY DONG ASC";
        }
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    //--------------------------------------------------------------//
    
    // 선택한 브로커 출력
    function selectbroker($brokernumber)
    {
        $sql = "SELECT bo.*, mb.MBR_NAME FROM TB_AB_BROKER_OFFICE AS bo, TB_UB_MEMBER AS mb WHERE bo.BROKER_OFFICE_IDX='$brokernumber' AND mb.MBR_IDX=bo.BROKER_OFFICE_IDX AND mb.MBR_STATUS='NM' AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->row_array();
        }
        else {
            return array();
        }
    }
    
    // 브로커 리스트 출력
    function brokerlist($memberidx)
    {        
        $sql = "
            SELECT 
                bo.*, mb.MBR_NAME 
            FROM TB_UA_GOODS_BROKER AS gb 
            JOIN TB_UB_MEMBER AS mb ON mb.MBR_IDX=gb.BROKER_OFFICE_IDX AND mb.MBR_STATUS='NM' 
            LEFT JOIN TB_AB_BROKER_OFFICE AS bo ON gb.BROKER_OFFICE_IDX=bo.BROKER_OFFICE_IDX AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR') 
            LEFT JOIN TB_UM_GOODS AS ug ON gb.GOODS_IDX=ug.GOODS_IDX 
            WHERE bo.OFFICE_STATUS='1' AND ug.REG_MBR_IDX='$memberidx' 
            GROUP BY gb.BROKER_OFFICE_IDX
        ";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 브로커 검색 출력
    function brokersearchlist($SENDDATA)
    {
        $subSql = "SELECT
                        bo.*, mb.MBR_NAME
                   FROM TB_UA_GOODS_BROKER AS gb 
                   JOIN TB_UB_MEMBER AS mb ON mb.MBR_IDX=gb.BROKER_OFFICE_IDX AND mb.MBR_STATUS='NM' 
                   LEFT JOIN TB_AB_BROKER_OFFICE AS bo ON gb.BROKER_OFFICE_IDX=bo.BROKER_OFFICE_IDX AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR') 
                   LEFT JOIN TB_UM_GOODS AS ug ON gb.GOODS_IDX=ug.GOODS_IDX
                   WHERE bo.OFFICE_STATUS='1' AND ug.REG_MBR_IDX='".$SENDDATA['memberidx']."'
                         AND bo.LAW_DONG_CODE='".$SENDDATA['dong']."00' AND bo.OFFICE_NAME LIKE '%".$SENDDATA['broker_search']."%'
                ";
        $subQry = $this->db->query($subSql);
        if( $subQry->num_rows() > 0 ) {
            return $subQry->result_array();
        }
        else {
            return false;
        }
    }
    
    // 브로커 가입시 검색 출력
    function brokerofficejoinsearchresult($SENDDATA)
    {
        $LAW_DONG_CODE = $SENDDATA['dong'].'00';
        $subSql = "SELECT boi.* FROM TB_AB_BROKER_OFFICE_INFO as boi, TB_AB_BROKER_OFFICE as bo WHERE boi.BROKER_OFFICE_CODE=bo.BROKER_OFFICE_CODE AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR') AND boi.LAW_CODE='".$LAW_DONG_CODE."' AND boi.BROKER_OFFICE_NAME LIKE '%".$SENDDATA['broker_search']."%'";
        $subQry = $this->db->query($subSql);
        if( $subQry->num_rows() > 0 ) {
            return $subQry->result_array();
        }
        else {
            return false;
        }
    }
    
    // 저장된 브로커 가입시 검색 출력
    function brokerofficesavesearchresult($brokeridx)
    {
        $subSql = "SELECT boi.* FROM TB_AB_BROKER_OFFICE_INFO as boi, TB_AB_BROKER_OFFICE as bo WHERE boi.BROKER_OFFICE_INFO_IDX='$brokeridx' AND boi.BROKER_OFFICE_CODE=bo.BROKER_OFFICE_CODE AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')";
        $subQry = $this->db->query($subSql);
        if( $subQry->num_rows() > 0 ) {
            return $subQry->result_array();
        }
        else {
            return false;
        }
    }
    
    //--------------------------------------------------------------//
    
    // 중개사 신고처리
    function reportbrokerprocessresult($INPUTDATA)
    {
        $brokerofficeidx = $INPUTDATA['brokerofficeidx'];
        $rept = $INPUTDATA['rept'];
        $reptExplain = $INPUTDATA['reptExplain'];
        $memidx = $INPUTDATA['memberidx'];
        
        // 데이터 등록
        $datetime = date("Y-m-d H:i:s");
        $data = array('MBR_IDX'=>$memidx, 'COMPLAIN_ITEMS'=>$rept, 'COMPLAIN_ITEMS_ETC'=>$reptExplain, 'BROKER_OFFICE_IDX'=>$brokerofficeidx);
        $res = $this->db->insert('TB_UA_BROKER_COMPLAIN', $data);
        if($res) return true;
        else return false;
    }
}