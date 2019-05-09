<?php
class Agentinfo_model extends CI_Model
{
    public $info, $spaceunit, $condition, $condition_str;
    
    public function __construct() {
        parent::__construct();
    }
    
    function findUseName($name)
    {
        $qry = $this->db->select('a.BROKER_OFFICE_IDX, a.OFFICE_NAME, a.ADDR1 , a.ADDR2 , a.PHONE , b.MBR_NAME')->like('a.OFFICE_NAME', trim($name))
                    ->from('TB_AB_BROKER_OFFICE a')
                    ->join('TB_UB_MEMBER b', 'a.BROKER_OFFICE_IDX = b.MBR_IDX')->get();
        if($qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
    
    function getProfile($broker_office_idx)
    {
        $sql = "
            SELECT
            	bo.*, mem.MBR_NAME, mem.MBR_IMAGE_FULL_PATH , if( bo_ac.ACC_END_DATE > CURDATE() , 'Y', 'N') AS ended
            FROM TB_AB_BROKER_OFFICE bo
            JOIN TB_UB_MEMBER mem ON bo.BROKER_OFFICE_IDX = mem.MBR_IDX
            left JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo.BROKER_OFFICE_IDX = bo_ac.MBR_IDX AND bo_ac.DEL_YN ='Y'
            WHERE bo.BROKER_OFFICE_IDX = ? AND mem.MBR_STATUS='NM' AND bo.OFFICE_STATUS='1' AND bo.APPROVAL_STATUS IN ('PS3', 'CA', 'CN', 'CR')
        ";
        $qry = $this->db->query($sql, array($broker_office_idx));
        if($qry->num_rows() > 0) return $qry->row_array();
        else return array();
    }
    
    function getOfficeBelong($broker_office_idx)
    {
        $sql = "SELECT a.BR_GUBUN, a.BR_NAME, a.BR_PROFILE_IMG FROM TB_AB_BROKER_BELONG a WHERE a.BROKER_OFFICE_IDX = ? ORDER BY a.BROKER_BELONG_IDX;";
        $qry = $this->db->query($sql, array($broker_office_idx));
        if($qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
    
    function getOfficeReview($broker_office_idx, $page=0, $perpage=5)
    {
        $sql = "SELECT *, DATE_FORMAT(RATE_DATE, '%Y.%m.%d') AS datedotformat FROM TB_UA_BROKER_EVALUATION a WHERE a.BROKER_OFFICE_IDX = ? ORDER BY a.RATE_DATE DESC LIMIT ?, ?";
        $qry = $this->db->query($sql, array($broker_office_idx, $page*$perpage, $perpage ));
        if($qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
    
    function getGoodsQnaisOn($broker, $goods_idx, $mbr_idx)
    {
        $sql = "SELECT ifnull(count(QNA_IDX), 0) as cnt FROM TB_UA_QNA a WHERE a.MBR_IDX = ? AND a.GOODS_IDX = ? AND a.BROKER_OFFICE_IDX = ? AND a.QNA_CATEGORY='GD' limit 1";
        $res = $this->db->query($sql, array($mbr_idx, $goods_idx, $broker))->row_array();
        return $res['cnt'];
    }
}
