<?php
define('SEARCH_SORT_TYPE', 'STREET');//STREET - 동에따른 건물순
define('USECACHE', false);

class Search_model extends CI_Model
{
    public $keys,$complex_type,$keylist,$res, $cached;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function init($keywords, $saletype='APT')
    {
        if(count($keywords) < 1) return false;
        
        $this->keys = $keywords;
        $this->complex_type = $saletype;
        $this->keylist = $this->mixkey();
        $this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => 'sk_'));
        
        if( !USECACHE || !$res = $this->cache->get($saletype.'|'.$this->keylist[4]) )
        {
            // 지하철검색
            if( $this->station() ) {
                $res = $this->res;
            }
            else if( $this->dong() ) {
                $res = $this->res;
            }
            else if( $this->gu() ) {
                $res = $this->res;
            }
            else if($this->complexOnly()){
                $res = $this->res;
            }
            else $res = false;
            
            $this->cache->save($saletype.'|'.$this->keylist[4], $res, 3600 );
            $this->cached = true;
        }
        
        return $res;
    }
    
    // 지하철역 검색
    function station()
    {
        $this->db
        ->select(" '' as COMPLEX_IDX ,STATION as title, 'STATION' as icontype ,ADDR as addr, LAT as lat, LNG as lng")
        ->where ('STATION', $this->keylist[0] );
        if($this->keylist[2] != '') $this->db->like('ADDR', $this->keylist[1] );
        $qry = $this->db->limit(1)->get('TB_CB_SUBWAY');
        if($qry->num_rows() > 0) {
            $this->res = $qry->result_array();
            return true;
        }
        else return false;
    }
    
    // 구검색
    function gu()
    {
        $qry = $this->db->select ( "'' as COMPLEX_IDX, LAW_DONG_CODE ,LAW_DONG_NAME AS title,'street' AS icontype, LAW_DONG_NAME addr,  LAT as lat, LNG as lng")
        ->where('USE_YN','Y')
        ->like ('LAW_DONG_NAME', $this->keylist[4])->ORDER_BY('LAW_DONG_CODE')->get('TB_CB_ADDR');
        if($qry->num_rows() > 0) {
            $this->res = $qry->result_array();
            return true;
        }
        else return false;
    }
    
    // 동검색
    function dong()
    {
        //마지막 단어로 검색
        $sql = 'SELECT ifnull( count(1), 0) as cnt FROM TB_CB_ADDR_EXPANSION ae WHERE EXPANSION_NAME ="'.$this->keylist[0].'"';
        $matching = $this->db->query($sql)->row_array();
        if($matching['cnt'] > 0) {
            $this->db->select ( "'' as COMPLEX_IDX, LAW_DONG_CODE ,LAW_DONG_NAME AS title,'street' AS icontype, LAW_DONG_NAME addr,  LAT as lat, LNG as lng")
            ->where('USE_YN','Y')
            ->where('`LAW_DONG_CODE` IN ( SELECT EXPANSION_LAW_DONG_CODE FROM TB_CB_ADDR_EXPANSION ae WHERE EXPANSION_NAME ="'.$this->keylist[0].'" )', NULL, FALSE);
        }
        else
        {
            $this->db->select ( "'' as COMPLEX_IDX, LAW_DONG_CODE ,LAW_DONG_NAME AS title,'street' AS icontype, LAW_DONG_NAME addr,  LAT as lat, LNG as lng")
            ->where('USE_YN','Y')
            ->group_start()
            ->like ( 'DONG', $this->keylist[0], 'after')
            ->or_like ( 'RI', $this->keylist[0], 'after' )
            ->or_where('`LAW_DONG_CODE` IN ( SELECT EXPANSION_LAW_DONG_CODE FROM TB_CB_ADDR_EXPANSION ae WHERE EXPANSION_NAME ="'.$this->keylist[0].'" )', NULL, FALSE)
            ->group_end();
        }
        
        if($this->keylist[2] != '') $this->db->LIKE( 'LAW_DONG_NAME', $this->keylist[2] );
        $qry = $this->db->ORDER_BY('LAW_DONG_CODE')->get('TB_CB_ADDR');
        if($qry->num_rows() > 0) {
            $this->res = $qry->result_array();
            $this->complex();
            return true;
        }
        
        if(count($this->keys) < 2) return false;
        
        // 두번째 단어로 검색
        if( $matching['cnt'] > 0) {
            $this->db->select ( "'' as COMPLEX_IDX, LAW_DONG_CODE ,LAW_DONG_NAME AS title,'street' AS icontype, LAW_DONG_NAME addr, LAT as lat, LNG as lng")
            ->where('USE_YN','Y')
            ->where('`LAW_DONG_CODE` IN ( SELECT EXPANSION_LAW_DONG_CODE FROM TB_CB_ADDR_EXPANSION ae WHERE EXPANSION_NAME ="'.$this->keylist[1].'" )', NULL, FALSE);
        }
        else {
            $this->db->select ( "'' as COMPLEX_IDX, LAW_DONG_CODE ,LAW_DONG_NAME AS title,'street' AS icontype, LAW_DONG_NAME addr, LAT as lat, LNG as lng")
            ->where('USE_YN','Y')
            ->group_start()
            ->where ( 'DONG', $this->keylist[1])
            ->or_where ( 'RI', $this->keylist[1])
            ->or_where('`LAW_DONG_CODE` IN ( SELECT EXPANSION_LAW_DONG_CODE FROM TB_CB_ADDR_EXPANSION ae WHERE EXPANSION_NAME ="'.$this->keylist[1].'" )', NULL, FALSE)
            ->group_end();
        }
        
        if( $this->keylist[3] != '' ) $this->db->LIKE( 'LAW_DONG_NAME', $this->keylist[3] );
        $qry = $this->db->ORDER_BY('LAW_DONG_CODE')->get('TB_CB_ADDR');
        if( $qry->num_rows() > 0) {
            $this->res = $qry->result_array();
            $this->complex($this->keylist[0]);
            return true;
        }
        else return false;
    }
    
    // 건물검색
    function complex($key='')
    {
        if(SEARCH_SORT_TYPE =='STREET') $ret = array();
        else $ret = $this->res;
        
        foreach( $this->res as $row )
        {
            $this->db->select ('COMPLEX_IDX, LAW_DONG_CODE , COMPLEX_NAME AS title, COMPLEX_TYPE AS icontype, LAW_ADDRESS AS addr, LAT AS lat, LNG AS lng')
            ->where ('LAW_DONG_CODE', $row['LAW_DONG_CODE'])
            ->where ('COMPLEX_TYPE', $this->complex_type)
            ->where('USE_YN','Y');
            if( $key !='') $this->db->like('COMPLEX_NAME', $key, 'after');
            
            $qry = $this->db->order_by('COMPLEX_NAME')->get('TB_CB_COMPLEX USE INDEX (IDX_TB_CB_COMPLEX_LAW_DONG_CODE)');
            if( $qry->num_rows() > 0)
            {
                if( SEARCH_SORT_TYPE == 'STREET' ) {
                    $ret[] = $row;
                    $ret = array_merge($ret, $qry->result_array());
                }
                else {
                    $ret = array_merge($ret, $qry->result_array());
                }
            }
            else {
                if(SEARCH_SORT_TYPE =='STREET') {
                    $ret[] = $row;
                }
            }
        }
        
        $this->res = $ret;
    }
    
    function complexOnly()
    {
        $cpxname = implode('',$this->keys);
                
        if(mb_strlen($cpxname, "UTF-8") < 2) return false;
        
        $this->db->select ('COMPLEX_IDX, LAW_DONG_CODE , COMPLEX_NAME AS title, COMPLEX_TYPE AS icontype, LAW_ADDRESS AS addr, LAT AS lat, LNG AS lng')
        ->where ('COMPLEX_TYPE', $this->complex_type)->where('USE_YN','Y');
        $this->db->like("replace(COMPLEX_NAME,' ','')" , $cpxname, 'after');
        $qry = $this->db->order_by('LAW_DONG_CODE, COMPLEX_NAME')->get('TB_CB_COMPLEX USE INDEX (IDX_TB_CB_COMPLEX_COMPLEX_NAME)');
        if($qry->num_rows() > 0) $this->res = $qry->result_array();
        else
        {
            $this->db->select ('COMPLEX_IDX, LAW_DONG_CODE , COMPLEX_NAME AS title, COMPLEX_TYPE AS icontype, LAW_ADDRESS AS addr, LAT AS lat, LNG AS lng')
            ->where ('COMPLEX_TYPE', $this->complex_type)->where('USE_YN','Y');
            $this->db->like("replace(COMPLEX_NAME,' ','')" , $cpxname, 'both');
            $qry = $this->db->order_by('LAW_DONG_CODE, COMPLEX_NAME')->get('TB_CB_COMPLEX USE INDEX (IDX_TB_CB_COMPLEX_COMPLEX_NAME)');
            if($qry->num_rows() > 0) $this->res = $qry->result_array();
            else return false;
        }
        
        return true;
    }
    
    // return array( 마지막 str, 마지막-1, 마지막제거 str,마지막2개 제거,  FULL str )
    function mixkey($method = 'last')
    {
        $cnt = count($this->keys);
        $tmpkeys = $this->keys;
        if($cnt < 1) return false;
        else if( $cnt == 1 ) return array( $this->keys[0], '','','', $this->keys[0]);
        else
        {
            array_pop($tmpkeys);$tmp1 = implode(' ', $tmpkeys);
            array_pop($tmpkeys);$tmp2 = implode(' ', $tmpkeys);
            return array( $this->keys[ ($cnt-1) ], $this->keys[ ($cnt-2) ],$tmp1, $tmp2 , implode(' ', $this->keys) );
        }
    }
}
