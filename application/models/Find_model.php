<?php
define('SEARCH_SORT_TYPE', 'STREET');//STREET - 동에따른 건물순
define('USECACHE', false);

class Find_model extends CI_Model
{
    public $info, $spaceunit, $condition, $condition_str;
  
    public function __construct()
    {
        parent::__construct();
    }
    
    public function init($swlat, $swlng, $nelat, $nelng, $level, $saletype, $spaceunit, $condition)
    {
        $this->info = array('min_lat'=>$swlat, 'max_lat'=>$nelat,'min_lng'=>$swlng,'max_lng'=>$nelng,'level'=>$level, 'type'=>$saletype );
        $this->spaceunit = ( !in_array($spaceunit , array("m", "p")) ) ? 'm' : $spaceunit;
        $this->condition = $condition;
    }
    
    // 집구하기 - 건물 목록 출력
    public function list()
    {
        if( $this->info['level'] <= 4 ) return $this->list_complex();
        else if( $this->info['level'] <= 6 ) return $this->list_dong();
        else if( $this->info['level'] <= 8 ) return $this->list_gu();
        else if( $this->info['level'] <= 12 ) return $this->list_sido();
        else return array();
    }
  
    // 집구하기 - 원룸 목록
    public function listOneRoom($user=0)
    {
        //todo
        if( $this->info['level'] <= 4 ) return $this->listOneRoom_default($user);
        else if( $this->info['level'] <= 6 ) return $this->listOneRoom_dong();
        else if( $this->info['level'] <= 8 ) return $this->listOneRoom_dong('SIGUNGU');
        else if( $this->info['level'] <= 12 ) return $this->listOneRoom_dong('SIDO');
        else return array();
    }

    /*function listOneRoom_default($user)
    {
        if((int)$user < 1) $user = '-1';
        
        $goods_sale_price_where =$this->makeCondition($this->condition, 'saleprice', 'PRICE1', 'PRICE1');
        $goods_charter_price_where =$this->makeCondition($this->condition, 'charterprice', 'PRICE2', 'PRICE2',1, ' TRADE_TYPE = 2 and ','');
        $goods_mon_de_price_where =$this->makeCondition($this->condition, 'monthly_deposit', 'PRICE2', 'PRICE2', 1, ' TRADE_TYPE = 3 and ','');
        $goods_mon_price_where =$this->makeCondition($this->condition, 'monthly', 'PRICE3', 'PRICE3', 1, ' TRADE_TYPE = 3 and ','');
        if($this->condition['transtype'] == 'previous' && $goods_charter_price_where =='') {
            $goods_charter_price_where = " ( TRADE_TYPE = 2 ) ";
        }
        
        if($this->condition['transtype'] == 'previous' && $goods_mon_de_price_where =='' && $goods_mon_price_where =='') {
          $goods_mon_de_price_where = " ( TRADE_TYPE = 3 ) ";
        }
        
        //$pricewhere = $this->orgrouping( array( $goods_charter_price_where, $goods_mon_de_price_where ,$goods_mon_price_where ) );
        $pricewhere = $this->orgrouping( array( $goods_charter_price_where, $this->andgrouping(array($goods_mon_de_price_where ,$goods_mon_price_where)) ) );
    
        $goods_area_where =$this->makeCondition($this->condition, 'area', 'AREA1', 'AREA1');
        $sql = "
            SELECT g1.GOODS_IDX,g1.COMPLEX_IDX, g1.CATEGORY AS COMPLEX_TYPE, LAT lat, LNG lng,
                GOODS_STATUS, TRADE_DATE, date_format(TRADE_DATE,'%Y.%m.%d') as TRADE_DATE_FORMAT,
                TRADE_TYPE ,g1.PRICE1, g1.PRICE2, g1.PRICE3, g1.AREA1, g1.ROOM_TYPE, g1.ANIMAL, g1.PARKING_FLAG,
                g1.DONG, g1.FLOOR, g1.FLOOR_KIND , g1.TOTAL_FLOOR, g1.ROOM_CNT, g1.BATHROOM_CNT,
                if ( g1.ROOM_TYPE = '', '-' , ( select CODE_NAME FROM TB_CB_CODE where CODE_GBN='ROOM_TYPE' and CODE_DETAIL = g1.ROOM_TYPE ) ) as ROOM_TYPE_TEXT,
                IFNULL((SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = g1.GOODS_IDX and DISPLAY_FLAG='Y' ORDER BY SORT_ORDER LIMIT 1)	, '') AS img,
                IF(my.MBR_IDX IS NULL , 0 , 1) AS isfavo
            FROM TB_UM_GOODS g1
            LEFT JOIN TB_UM_MY_GOODS my ON my.MBR_IDX = ".$user." AND my.GOODS_IDX = g1.GOODS_IDX
            WHERE
               g1.LAT > ".$this->info['min_lat']."
               AND g1.LAT < ".$this->info['max_lat']."
               AND g1.LNG > 	".$this->info['min_lng']."
               AND g1.LNG < ".$this->info['max_lng']."
               AND g1.CATEGORY = ".$this->db->escape($this->info['type']);
        
        if( $this->condition['transtype'] !='all' )
        {
            if( $this->condition['transtype'] =='sale' ) $sql .=" AND TRADE_TYPE = 1 ";
            else if($this->condition['transtype'] == 'previous_2') $sql .=" AND TRADE_TYPE = 2 ";
            else if($this->condition['transtype'] == 'previous_3') $sql .=" AND TRADE_TYPE = 3 ";
            else  $sql .=" AND (TRADE_TYPE = 2 or TRADE_TYPE = 3)";
        }
        
        if($this->condition['ROOM_TYPE'] !='' && $this->condition['ROOM_TYPE'][0] !='all')
        {
            $tmproomtype = array();
            foreach($this->condition['ROOM_TYPE'] as $idx=>$val) {
                $tmproomtype[] = "'".$val."'";
            }
            $sql .= "
                AND g1.ROOM_TYPE in(".implode($tmproomtype).")
            ";
        }
        
        $sql .= "
          AND GOODS_PROCESS_STATUS ='PS2'
          AND (g1.GOODS_STATUS ='SB' OR g1.GOODS_STATUS='CF' OR (GOODS_STATUS ='DR' AND TRADE_DATE > DATE_ADD(NOW(), INTERVAL -1 WEEK) ))
    
          $goods_area_where
          $goods_sale_price_where
          $pricewhere
          ORDER BY AREA1 ,TRADE_TYPE
        ";
        $qry = $this->db->query($sql);
        //echo $this->db->last_query();exit;
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }*/
    
    function listOneRoom_default($user)
    {
        if((int)$user < 1 ) $user='-1';
        
        $goods_sale_price_where =$this->makeCondition($this->condition, 'saleprice', 'PRICE1', 'PRICE1');
        $goods_charter_price_where =$this->makeCondition($this->condition, 'charterprice', 'PRICE2', 'PRICE2',1, ' TRADE_TYPE = 2 and ','');
        $goods_mon_de_price_where =$this->makeCondition($this->condition, 'monthly_deposit', 'PRICE2', 'PRICE2', 1, ' TRADE_TYPE = 3 and ','');
        $goods_mon_price_where =$this->makeCondition($this->condition, 'monthly', 'PRICE3', 'PRICE3', 1, ' TRADE_TYPE = 3 and ','');
        if($this->condition['transtype'] == 'previous' && $goods_charter_price_where == '') {
            $goods_charter_price_where = " ( TRADE_TYPE = 2 ) ";
        }
        
        if( $this->condition['transtype'] == 'previous' && $goods_mon_de_price_where =='' && $goods_mon_price_where =='') {
            $goods_mon_de_price_where = " ( TRADE_TYPE = 3 ) ";
        }
        
        $pricewhere = $this->orgrouping( array( $goods_charter_price_where, $this->andgrouping(array($goods_mon_de_price_where ,$goods_mon_price_where)) ) );
        
        $goods_area_where =$this->makeCondition($this->condition, 'area', 'AREA1', 'AREA1');
        $sql = "
          SELECT g1.GOODS_IDX,g1.COMPLEX_IDX, g1.CATEGORY AS COMPLEX_TYPE, LAT lat, LNG lng
            ,GOODS_STATUS, TRADE_DATE, date_format(TRADE_DATE,'%Y.%m.%d') as TRADE_DATE_FORMAT
            ,TRADE_TYPE ,g1.PRICE1, g1.PRICE2, g1.PRICE3, g1.AREA1, g1.ROOM_TYPE, g1.ANIMAL, g1.PARKING_FLAG
            , g1.DONG, g1.FLOOR, g1.FLOOR_KIND , g1.TOTAL_FLOOR, g1.ROOM_CNT, g1.BATHROOM_CNT
            , if ( g1.ROOM_TYPE = '', '-' , ( select CODE_NAME FROM TB_CB_CODE where CODE_GBN='ROOM_TYPE' and CODE_DETAIL = g1.ROOM_TYPE ) ) as ROOM_TYPE_TEXT
            , IFNULL((SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = g1.GOODS_IDX and DISPLAY_FLAG='Y' ORDER BY SORT_ORDER LIMIT 1)	, '') AS img
            ,IF(my.MBR_IDX IS NULL , 0 , 1) AS isfavo
            FROM TB_UM_GOODS g1
            LEFT JOIN TB_UM_MY_GOODS my ON my.MBR_IDX = ".$user." AND my.GOODS_IDX = g1.GOODS_IDX
            WHERE
               g1.LAT > ".$this->info['min_lat']."
               AND g1.LAT < ".$this->info['max_lat']."
               AND g1.LNG > 	".$this->info['min_lng']."
               AND g1.LNG < ".$this->info['max_lng']."
               AND g1.CATEGORY = ".$this->db->escape($this->info['type'])."
        ";
        if($this->condition['transtype'] != 'all')
        {
            if( $this->condition['transtype'] =='sale' ) $sql .=" AND TRADE_TYPE = 1 ";
            else if( $this->condition['transtype'] == 'previous_2') $sql .=" AND TRADE_TYPE = 2 ";
            else if( $this->condition['transtype'] == 'previous_3') $sql .=" AND TRADE_TYPE = 3 ";
            else  $sql .=" AND (TRADE_TYPE = 2 or TRADE_TYPE = 3)";
        }        
        if($this->condition['ROOM_TYPE'] !='' && $this->condition['ROOM_TYPE'][0] !='all')
        {
            $tmproomtype = array();
            foreach($this->condition['ROOM_TYPE'] as $idx=>$val ){
                $tmproomtype[] = "'".$val."'";
            }
            $sql .= "
                AND g1.ROOM_TYPE in(".implode(',' , $tmproomtype).")
            ";
        }
        $sql .= "
          AND GOODS_PROCESS_STATUS ='PS2'
          AND (g1.GOODS_STATUS ='SB' OR g1.GOODS_STATUS='CF' OR (GOODS_STATUS ='DR' AND TRADE_DATE > DATE_ADD(NOW(), INTERVAL -1 WEEK) ))
          
          $goods_area_where
          $goods_sale_price_where
          $pricewhere
          ORDER BY AREA1 ,TRADE_TYPE
        ";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
  
    //DONG, SIGUNGU, SIDO
    private function listOneRoom_dong($div="DONG")
    {
        $goods_sale_price_where =$this->makeCondition($this->condition, 'saleprice', 'PRICE1', 'PRICE1');
        $goods_charter_price_where =$this->makeCondition($this->condition, 'charterprice', 'PRICE2', 'PRICE2',1, ' TRADE_TYPE = 2 and ','');
        $goods_mon_de_price_where =$this->makeCondition($this->condition, 'monthly_deposit', 'PRICE2', 'PRICE2', 1, ' TRADE_TYPE = 3 and ','');
        $goods_mon_price_where =$this->makeCondition($this->condition, 'monthly', 'PRICE3', 'PRICE3', 1, ' TRADE_TYPE = 3 and ','');
        if($this->condition['transtype'] == 'previous' && $goods_charter_price_where =='') {
            $goods_charter_price_where = " ( TRADE_TYPE = 2 ) ";
        }
        
        if($this->condition['transtype'] == 'previous' && $goods_mon_de_price_where =='' && $goods_mon_price_where =='') {
            $goods_mon_de_price_where = " ( TRADE_TYPE = 3 ) ";
        }
        
        //$pricewhere = $this->orgrouping( array( $goods_charter_price_where, $goods_mon_de_price_where ,$goods_mon_price_where ) );
        $pricewhere = $this->orgrouping( array( $goods_charter_price_where, $this->andgrouping(array($goods_mon_de_price_where ,$goods_mon_price_where)) ) );
        $goods_area_where =$this->makeCondition($this->condition, 'area', 'AREA1', 'AREA1');
        $sql = "
            SELECT adr.".$div." map_title, g1.lat, g1.lng
            FROM TB_UM_GOODS g1
            join TB_CB_ADDR adr on g1.LAW_DONG_CODE = adr.LAW_DONG_CODE
            WHERE
                g1.LAT > ".$this->info['min_lat']."
                AND g1.LAT < ".$this->info['max_lat']."
                AND g1.LNG > 	".$this->info['min_lng']."
                AND g1.LNG < ".$this->info['max_lng']."
                AND g1.CATEGORY = ".$this->db->escape($this->info['type']);
        if( $this->condition['transtype'] !='all' )
        {
            if ( $this->condition['transtype'] =='sale' ) $sql .=" AND TRADE_TYPE = 1 ";
            else if ( $this->condition['transtype'] == 'previous_2') $sql .=" AND TRADE_TYPE = 2 ";
            else if ( $this->condition['transtype'] == 'previous_3') $sql .=" AND TRADE_TYPE = 3 ";
            else  $sql .=" AND (TRADE_TYPE = 2 or TRADE_TYPE = 3)";
        }
        
        if( $this->condition['ROOM_TYPE'] !='' && $this->condition['ROOM_TYPE'][0] !='all')
        {
            $tmproomtype = array();
            foreach($this->condition['ROOM_TYPE'] as $idx=>$val) {
                $tmproomtype[] = "'".$val."'";
            }
            $sql .= "
                AND g1.ROOM_TYPE in(".implode($tmproomtype).")
            ";
        }
        
        $sql .= "
            AND g1.GOODS_PROCESS_STATUS ='PS2'
            AND ( g1.GOODS_STATUS ='SB' or g1.GOODS_STATUS ='CF' )
        
            $goods_area_where
            $goods_sale_price_where
            $pricewhere
        
            GROUP BY adr.".$div."_CODE
        ";
        $qry = $this->db->query($sql, array($this->info['min_lat'],$this->info['max_lat'],$this->info['min_lng'],$this->info['max_lng'],$this->info['type']) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }

    /* 레벨에 따른 지도검색 */
    private function list_complex()
    {
        //$cond1 = $this->makeCondition($this->condition, 'area', 'Max_SUPPLY_AREA', 'MIN_SUPPLY_AREA');
        $cond_good = $this->cond_goods();
        $joinsql = $this->searchcondsql();
        
        $sql = "
            SELECT
                cpx.COMPLEX_IDX AS map_code,
                cpx.COMPLEX_NAME AS map_title,
                cpx.COMPLEX_TYPE AS map_type,
                cpx.LAT AS lat, cpx.LNG AS lng,
                '1' AS goods_cnt,
                if(DEFAULT_IMG IS NULL OR DEFAULT_IMG ='', (SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX= cpx.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1), DEFAULT_IMG) AS imgsrc,
                cpx.TOTAL_DONG_COUNT AS dong_cnt,
                cpx.TOTAL_HOUSE_HOLD_COUNT AS house_cnt,
                cpx.LOW_FLOOR AS low_floor,
                cpx.HIGH_FLOOR AS high_floor,
                IFNULL(left(cpx.CONSTRUCT_YEAR_MONTH,4),'-') AS completion_year,
                FLOOR(cpx.MIN_SUPPLY_AREA) AS min_area,
                FLOOR(cpx.MAX_SUPPLY_AREA) AS max_area,
                FLOOR(cpx.MIN_SUPPLY_PYEONG) AS min_area_p,
                FLOOR(cpx.MAX_SUPPLY_PYEONG) AS  max_area_p,
                ifnull(typecnt.sale_cnt,0) AS sale_cnt,
                ifnull(typecnt.charter_cnt,0) AS charter_cnt,
                ifnull(typecnt.monthly_cnt,0) AS monthly_cnt,
                ifnull (sort_reg_date , '2999-12-31') as sort_reg_date,
                IFNULL(PYEONG_SELL_PRICE,0) PYEONG_SELL_PRICE, IFNULL(PYEONG_CHARTERED_PRICE,0) PYEONG_CHARTERED_PRICE,
          		IFNULL(PYEONG_MONTHLY_PRICE,0) PYEONG_MONTHLY_PRICE,
                IFNULL(CURR_SELL_MIN_PRICE,0) CURR_SELL_MIN_PRICE,
                IFNULL(CURR_SELL_MAX_PRICE,0) CURR_SELL_MAX_PRICE,
                IFNULL(CURR_CHARTERED_MIN_PRICE,0) CURR_CHARTERED_MIN_PRICE,
                IFNULL(CURR_CHARTERED_MAX_PRICE,0) CURR_CHARTERED_MAX_PRICE,
                IFNULL(PYEONG_DEPOSIT_PRICE,0) PYEONG_DEPOSIT_PRICE,
                IFNULL(CURR_MONTHLY_MIN_PRICE,0) CURR_MONTHLY_MIN_PRICE,
                IFNULL(CURR_MONTHLY_MAX_PRICE,0) CURR_MONTHLY_MAX_PRICE,
                IFNULL(CURR_MONTHLY_DEPOSIT_MIN_PRICE,0) CURR_MONTHLY_DEPOSIT_MIN_PRICE,
                IFNULL(CURR_MONTHLY_DEPOSIT_MAX_PRICE,0) CURR_MONTHLY_DEPOSIT_MAX_PRICE,
                floor(rand()) as isfavorite,
                ifnull((select PYEONG_NAME FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX = cond.COMPLEX_IDX AND COMPLEX_TYPE = cond.COMPLEX_TYPE AND MAX_HO_CNT_YN ='Y' LIMIT 1), '-') AS PYEONG_NAME,
                cpx.REAL_ESTATE_TYPE
            FROM
                (
                    $joinsql
                ) cond
            JOIN TB_CB_COMPLEX cpx on cond.COMPLEX_IDX = cpx.COMPLEX_IDX and cond.COMPLEX_TYPE = cpx.COMPLEX_TYPE
            LEFT JOIN TB_CB_COMPLEX_ATTATCH cpx_at ON cond.COMPLEX_IDX = cpx_at.COMPLEX_IDX and cond.COMPLEX_TYPE = cond.COMPLEX_TYPE
        ";
        
        $sql .= "JOIN ";
        
        $sql .= "
            (
                $cond_good
            ) as typecnt on cond.COMPLEX_IDX = typecnt.COMPLEX_IDX
            where cpx.USE_YN ='Y'
            order BY (sale_cnt+charter_cnt+ monthly_cnt) desc , sort_reg_date, map_title
        ";
        
        $qry = $this->db->query($sql, array($this->info['min_lat'], $this->info['max_lat'], $this->info['min_lng'], $this->info['max_lng'], $this->info['type']));
        if($qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
  
    private function list_dong()
    {
        $this->db->query("SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        $sql="
            SELECT
                LAW_DONG_NAME map_title, DONG_LAT lat, DONG_LNG lng
            FROM
            	TB_CB_COMPLEX cpx
            WHERE
              cpx.LAT > ?
              AND cpx.LAT < ?
              AND cpx.LNG > 	?
              AND cpx.LNG < ?
              AND cpx.COMPLEX_TYPE = ?
              AND cpx.USE_YN ='Y'
            GROUP BY LAW_DONG_NAME
        ";
        $qry = $this->db->query($sql, array($this->info['min_lat'],$this->info['max_lat'],$this->info['min_lng'],$this->info['max_lng'],$this->info['type']) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
  
    private function list_gu()
    {
        $this->db->query("SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        $sql = "
            SELECT
                SIGUNGU map_title, SIGUNGU_LAT lat, SIGUNGU_LNG lng
            FROM
            	TB_CB_COMPLEX cpx
            WHERE
                cpx.LAT > ?
                AND cpx.LAT < ?
                AND cpx.LNG > 	?
                AND cpx.LNG < ?
                AND cpx.COMPLEX_TYPE = ?
                AND cpx.USE_YN ='Y'
            GROUP BY SIGUNGU
        ";
        $qry = $this->db->query($sql, array($this->info['min_lat'],$this->info['max_lat'],$this->info['min_lng'],$this->info['max_lng'],$this->info['type']) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
  
    private function list_sido()
    {
        $this->db->query("SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        $sql = "
            SELECT
                SIDO map_title
                #, SIDO_LAT lat, SIDO_LNG lng
                ,lat, lng
            FROM
                TB_CB_COMPLEX cpx
            WHERE
                cpx.LAT > ?
                AND cpx.LAT < ?
                AND cpx.LNG > 	?
                AND cpx.LNG < ?
                AND cpx.COMPLEX_TYPE = ?
                AND cpx.USE_YN ='Y'
            GROUP BY SIDO
        ";
        $qry = $this->db->query($sql, array($this->info['min_lat'],$this->info['max_lat'],$this->info['min_lng'],$this->info['max_lng'],$this->info['type']) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }

    public function saleComplexList($complex_idx, $complex_type, $condition, $user)
    {
        $this->condition = $condition;
        if((int)$user < 1) $user = '-1';
        $goods_sale_price_where =$this->makeCondition($this->condition, 'saleprice', 'PRICE1', 'PRICE1');
        $goods_charter_price_where =$this->makeCondition($this->condition, 'charterprice', 'PRICE2', 'PRICE2',1, ' TRADE_TYPE = 2 and ','');
        $goods_mon_de_price_where =$this->makeCondition($this->condition, 'monthly_deposit', 'PRICE2', 'PRICE2', 1, ' TRADE_TYPE = 3 and ','');
        $goods_mon_price_where =$this->makeCondition($this->condition, 'monthly', 'PRICE3', 'PRICE3', 1, ' TRADE_TYPE = 3 and ','');
        if($this->condition['transtype'] == 'previous' && $goods_charter_price_where =='') {
            $goods_charter_price_where = " ( TRADE_TYPE = 2 ) ";
        }
        if($this->condition['transtype'] == 'previous' && $goods_mon_de_price_where =='' && $goods_mon_price_where =='') {
            $goods_mon_de_price_where = " ( TRADE_TYPE = 3 ) ";
        }
        $pricewhere = $this->orgrouping( array( $goods_charter_price_where, $this->andgrouping(array($goods_mon_de_price_where ,$goods_mon_price_where)) ) );
        $goods_area_where =$this->makeCondition($this->condition, 'area', 'AREA1', 'AREA1');
        $sql = "
            SELECT
                g1.GOODS_IDX,g1.COMPLEX_IDX, g1.CATEGORY AS COMPLEX_TYPE, cpx.COMPLEX_NAME,
                TRADE_TYPE, g1.PRICE1, g1.PRICE2, g1.PRICE3, g1.AREA1, g1.AREA2, g1.GOODS_STATUS, TRADE_DATE, date_format(TRADE_DATE,'%Y.%m.%d') as TRADE_DATE_FORMAT,
                g1.DONG, g1.FLOOR_KIND, g1.FLOOR, g1.TOTAL_FLOOR, cpx.TOTAL_DONG_COUNT, g1.ROOM_CNT, g1.BATHROOM_CNT,
                IFNULL(
                    IFNULL(
                        (SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = g1.GOODS_IDX and DISPLAY_FLAG='Y' order by FILE_SEPARATE, SORT_ORDER limit 1),
                        cpx.DEFAULT_IMG
                    ),
                    (SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX=g1.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1)
                ) AS img,
                IF(my.MBR_IDX IS NULL, 0, 1) AS isfavo,
                if(ROOM_TYPE != '', ifnull((select CODE_NAME from TB_CB_CODE where CODE_GBN= 'ROOM_TYPE' and CODE_DETAIL = g1.ROOM_TYPE), ''), '') as ROOM_TYPE_TEXT
            FROM TB_CB_COMPLEX cpx FORCE INDEX(ind_id_type)
            JOIN TB_UM_GOODS g1 FORCE INDEX (ind_id_type)  ON cpx.COMPLEX_IDX = g1.COMPLEX_IDX AND cpx.COMPLEX_TYPE = g1.CATEGORY AND g1.GOODS_PROCESS_STATUS ='PS2'
            LEFT JOIN TB_UM_MY_GOODS my ON my.MBR_IDX = ".$user." AND my.GOODS_IDX = g1.GOODS_IDX
            WHERE
                cpx.COMPLEX_IDX = ".$this->db->escape($complex_idx)."
                AND cpx.COMPLEX_TYPE = ".$this->db->escape($complex_type)."
                AND (g1.GOODS_STATUS ='SB' or g1.GOODS_STATUS='CF' OR (g1.GOODS_STATUS ='DR' AND g1.TRADE_DATE > DATE_ADD(NOW(), INTERVAL -1 WEEK)))
        ";
        if( $this->condition['transtype'] !='all' )
        {
            if ( $this->condition['transtype'] =='sale' ) $sql .=" AND TRADE_TYPE = 1 ";
            else if ( $this->condition['transtype'] == 'previous_2') $sql .=" AND TRADE_TYPE = 2 ";
            else if ( $this->condition['transtype'] == 'previous_3') $sql .=" AND TRADE_TYPE = 3 ";
            else  $sql .=" AND (TRADE_TYPE = 2 or TRADE_TYPE = 3)";
        }
        
        if( $this->condition['ROOM_TYPE'] !='' && $this->condition['ROOM_TYPE'][0] !='all')
        {
            $tmproomtype = array();
            foreach($this->condition['ROOM_TYPE'] as $idx=>$val ) {
                $tmproomtype[] = "'".$val."'";
            }
            $sql .= "
                AND g1.ROOM_TYPE in(".implode($tmproomtype).")
            ";
        }
        
        $sql .= "
            AND GOODS_PROCESS_STATUS ='PS2'#승인완료
    
            $goods_area_where
            $goods_sale_price_where
            $pricewhere
            ORDER BY AREA1 ,TRADE_TYPE
        ";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    public function getOneRoomSaleList() {
        return array();
    }
    
    /*========================================*/
    /*    검색 조건 만들기                 */
    /* ===================================== */
    private function searchcondsql()
    {
        $condarea = $this->makeCondition($this->condition, 'area', 'SUPPLY_AREA', 'SUPPLY_AREA');
    
        $sql = "
            SELECT
              cpx1.COMPLEX_IDX, cpx1.COMPLEX_TYPE
            FROM
              TB_CB_COMPLEX cpx1 USE INDEX (IDX_TB_CB_COMPLEX_COORDINATE)
        ";
        
        if( $condarea != '' )
        {
            $sql .="
                JOIN TB_CB_COMPLEX_AREA cpx_ar1 on cpx1.COMPLEX_IDX = cpx_ar1.COMPLEX_IDX
            ";
        }
    
        $sql  .= "
            WHERE
                cpx1.LAT > ".$this->info['min_lat']."
                AND cpx1.LAT < ".$this->info['max_lat']."
                AND cpx1.LNG > 	".$this->info['min_lng']."
                AND cpx1.LNG < ".$this->info['max_lng']."
                AND cpx1.COMPLEX_TYPE = ".$this->db->escape($this->info['type'])."
                AND cpx1.USE_YN ='Y'
                $condarea
                group by cpx1.COMPLEX_IDX, cpx1.COMPLEX_TYPE
        ";
        return $sql;
    }
    
    private function cond_goods()
    {
        $goods_sale_price_where =$this->makeCondition($this->condition, 'saleprice', 'PRICE1', 'PRICE1');
        
        $goods_charter_price_where =$this->makeCondition($this->condition, 'charterprice', 'PRICE2', 'PRICE2',1, ' TRADE_TYPE = 2 and ','');
        $goods_mon_de_price_where =$this->makeCondition($this->condition, 'monthly_deposit', 'PRICE2', 'PRICE2', 1, ' TRADE_TYPE = 3 and ','');
        $goods_mon_price_where =$this->makeCondition($this->condition, 'monthly', 'PRICE3', 'PRICE3', 1, ' TRADE_TYPE = 3 and ','');
        if( ($this->condition['transtype'] == 'previous' || $this->condition['transtype'] == 'previous_2' ) && $goods_charter_price_where =='') {
            $goods_charter_price_where = " ( TRADE_TYPE = 2 ) ";
        }
        if( ($this->condition['transtype'] == 'previous' || $this->condition['transtype'] == 'previous_3' ) && $goods_mon_de_price_where =='' && $goods_mon_price_where =='') {
            $goods_mon_de_price_where = " ( TRADE_TYPE = 3 ) ";
        }
        //$pricewhere = $this->orgrouping( array( $goods_charter_price_where, $goods_mon_de_price_where ,$goods_mon_price_where ) );
        $pricewhere = $this->orgrouping( array( $goods_charter_price_where, $this->andgrouping(array($goods_mon_de_price_where ,$goods_mon_price_where)) ) );
        
        $goods_area_where =$this->makeCondition($this->condition, 'area', 'AREA1', 'AREA1');
        
        $cond_sale_price = $this->makeCondition($this->condition, 'saleprice', 'CURR_SELL_MAX_PRICE', 'CURR_SELL_MIN_PRICE',1);
        $cond_charter_price = $this->makeCondition($this->condition, 'charterprice', 'CURR_CHARTERED_MAX_PRICE', 'CURR_CHARTERED_MIN_PRICE',1,'','');
        //$cond_monthly_price = $this->makeCondition($this->condition, 'monthly', 'CURR_MONTHLY_MAX_PRICE', 'CURR_MONTHLY_MIN_PRICE',1*250);
        $cond_monthly_price = $this->makeCondition($this->condition, 'monthly', 'CURR_MONTHLY_MIN_PRICE','CURR_MONTHLY_MAX_PRICE',1,'','');
        $cond_monthly_deposit_price = $this->makeCondition($this->condition, 'monthly_deposit', 'CURR_MONTHLY_DEPOSIT_MAX_PRICE','CURR_MONTHLY_DEPOSIT_MIN_PRICE',1,'','');
        
        $cond_monthly_where ='';
        if( $cond_monthly_price !='' && $cond_monthly_deposit_price !='' ) {
            $cond_monthly_where = "(
      $cond_monthly_price
      and
      $cond_monthly_deposit_price
      )";
        }
        else if ( $cond_monthly_price !='' || $cond_monthly_deposit_price !='' ) {
            $cond_monthly_where = $cond_monthly_price.$cond_monthly_deposit_price;
        }
        if ( $cond_charter_price !='' && $cond_monthly_where !='') {
            $cond_monthly_where = " and (
        $cond_charter_price
        or
        $cond_monthly_where
        )";
        }
        else if ( $cond_charter_price !='' || $cond_monthly_where !='' ) {
            $cond_monthly_where = " and " . $cond_monthly_where.$cond_charter_price;
        }
        $sql = "
  SELECT COMPLEX_IDX,
    SUM(CASE WHEN  TRADE_TYPE = 1 THEN 1 ELSE 0 END ) AS sale_cnt ,
    SUM(CASE WHEN  TRADE_TYPE = 2 THEN 1 ELSE 0 END ) AS charter_cnt,
    SUM(CASE WHEN  TRADE_TYPE = 3 THEN 1 ELSE 0 END ) AS monthly_cnt
    ,REG_DATE AS sort_reg_date
  FROM
    (
      (
      SELECT COMPLEX_IDX, TRADE_TYPE,REG_DATE
        FROM TB_UM_GOODS g1
        WHERE
           g1.LAT > ".$this->info['min_lat']."
           AND g1.LAT < ".$this->info['max_lat']."
           AND g1.LNG > 	".$this->info['min_lng']."
           AND g1.LNG < ".$this->info['max_lng']."
           AND g1.CATEGORY = ".$this->db->escape($this->info['type'])."
  ";
        if ( $this->condition['transtype'] !='all' ){
            if ( $this->condition['transtype'] =='sale' ) $sql .=" AND TRADE_TYPE = 1 ";
            else if ( $this->condition['transtype'] == 'previous_2') $sql .=" AND TRADE_TYPE = 2 ";
            else if ( $this->condition['transtype'] == 'previous_3') $sql .=" AND TRADE_TYPE = 3 ";
            else  $sql .=" AND (TRADE_TYPE = 2 or TRADE_TYPE = 3)";
        }
        if( $this->condition['ROOM_TYPE'] !='' && $this->condition['ROOM_TYPE'][0] !='all'){
            $tmproomtype = array();
            foreach($this->condition['ROOM_TYPE'] as $idx=>$val ){
                $tmproomtype[] = "'".$val."'";
            }
            $sql .= "
      AND g1.ROOM_TYPE in(".implode(',', $tmproomtype).")
    ";
        }
        $sql .= "
      AND GOODS_PROCESS_STATUS ='PS2'#승인완료
      AND ( GOODS_STATUS ='SB' or GOODS_STATUS='CF' OR (GOODS_STATUS ='DR' AND TRADE_DATE > DATE_ADD(NOW(), INTERVAL -1 WEEK) ) ) #정상 또는 일주일
      
      $goods_area_where
      $goods_sale_price_where
      $pricewhere
      
      ORDER BY REG_DATE
    ) UNION
    (
      SELECT g2.COMPLEX_IDX, null as TRADE_TYPE, '2999-12-31' AS REG_DATE
      FROM TB_CB_COMPLEX g2
      left JOIN TB_CB_COMPLEX_ATTATCH g2_at on g2.COMPLEX_IDX = g2_at.COMPLEX_IDX and g2.COMPLEX_TYPE = g2_at.COMPLEX_TYPE
      WHERE
          g2.LAT > ".$this->info['min_lat']."
          AND g2.LAT < ".$this->info['max_lat']."
          AND g2.LNG > 	".$this->info['min_lng']."
          AND g2.LNG < ".$this->info['max_lng']."
          AND g2.COMPLEX_TYPE = ".$this->db->escape($this->info['type'])."
          $cond_sale_price
          $cond_monthly_where
    )
  )  g1_1
  GROUP BY COMPLEX_IDX
    ";
          return $sql;
    }
    
    /*========================================*/
    /*    다중선택 조건 만들기                 */
    /* ===================================== */
    private function orgrouping($arr = array())
    {
        $tmp = array();$ret = '';
        foreach ( $arr as $idx=>$val ){
          if (trim($val) != '' ) $tmp[] = " (".$val.") ";
        }
        if( count( $tmp) > 0 ) return " and (".implode (' or ', $tmp ).") ";
        else return '';
    }
    
    private function andgrouping($arr = array())
    {
        $tmp = array();$ret = '';
        foreach ( $arr as $idx=>$val ){
          if (trim($val) != '' ) $tmp[] = " (".$val.") ";
        }
        if( count( $tmp) > 0 ) return " (".implode (' and ', $tmp ).") ";
        else return '';
    }
    
    private function makeCondition($condition, $name , $rep_name1='',$rep_name2='',$mul=1,$withand='', $andor = 'and'){
        if( !isset( $condition[$name])) return '';
        if( $rep_name1 =='') $rep_name1 = $name;
        if( $rep_name2 =='') $rep_name2 = $name;
        
        $data = $condition[$name];
        if( $data == null || $data == '' || $data == 'all') return '';
        else if ( is_array($data) && $name=='monthly' && ($rep_name1=='CURR_MONTHLY_MIN_PRICE' || $rep_name2=='CURR_MONTHLY_MIN_PRICE')) {
            $str ='';
            $str_arr= array();
            foreach ( $data as $idx=>$val ){
                $tmp = explode( "-", $val);
                if ( (int)$tmp[0] == 0 ){
                    if ( !isset($tmp[1]) ||  $tmp[1] =='') continue;
                    else if ( (int)$tmp[1] > 0 ){
                        $str_arr[] = " ( CURR_MONTHLY_MIN_PRICE <= ".(int)$tmp[1]." or CURR_MONTHLY_MAX_PRICE <= ".(int)$tmp[1].") ";
                    }
                }else if( !isset($tmp[1]) ||  $tmp[1] =='' || (int)$tmp[1] == 0) {
                    $str_arr[] = " ( CURR_MONTHLY_MIN_PRICE >= ".(int)$tmp[0]." or CURR_MONTHLY_MAX_PRICE >= ".(int)$tmp[0].") ";
                }else {
                    $str_arr[] = "
          (
             ( CURR_MONTHLY_MIN_PRICE >= ".(int)$tmp[0]." and CURR_MONTHLY_MIN_PRICE <= ".(int)$tmp[1].")
             or
             ( CURR_MONTHLY_MAX_PRICE >= ".(int)$tmp[0]." and CURR_MONTHLY_MAX_PRICE <= ".(int)$tmp[1].")
             or ( CURR_MONTHLY_MIN_PRICE < ".(int)$tmp[0]." and CURR_MONTHLY_MAX_PRICE >".(int)$tmp[1]." )
             or ( CURR_MONTHLY_MAX_PRICE < ".(int)$tmp[0]." and CURR_MONTHLY_MIN_PRICE > ".(int)$tmp[1].")
          ) ";
                }
            }
            if ( count($str_arr) == 0 ) return '';
            else {
                return " $andor ( ". implode(' or ', $str_arr) .") ";
            }
        }else if ( is_array($data) ){
            $str = $this->condition_parsing($name,$data,$rep_name1,$rep_name2,$mul,$withand );
            if ($str == '') return '';
            else return " ".$andor." ( ".$str.")";
        }else return ' '.$andor.' `'.$name.'` = "'.$data.'"';
    }
  
    /*private function makeCondition($condition, $name , $rep_name1='',$rep_name2='',$mul=1,$withand='', $andor = 'and')
    {
        if(!isset( $condition[$name])) return '';
        if($rep_name1 =='') $rep_name1 = $name;
        if($rep_name2 =='') $rep_name2 = $name;
    
        $data = $condition[$name];
        if($data == null || $data == '' || $data == 'all') return '';
        else if(is_array($data) && $name=='monthly' && ($rep_name1=='CURR_MONTHLY_MIN_PRICE' || $rep_name2=='CURR_MONTHLY_MIN_PRICE'))
        {
            $str ='';
            $str_arr= array();
            foreach ( $data as $idx=>$val )
            {
                $tmp = explode( "-", $val);
                if( (int)$tmp[0] == 0 )
                {
                    if(!isset($tmp[1]) ||  $tmp[1] =='') continue;
                    else if( (int)$tmp[1] > 0 ) {
                        $str_arr[] = " ( CURR_MONTHLY_MIN_PRICE <= ".(int)$tmp[1]." or CURR_MONTHLY_MAX_PRICE <= ".(int)$tmp[1].") ";
                    }
                }
                else if( !isset($tmp[1]) ||  $tmp[1] =='' || (int)$tmp[1] == 0) {
                    $str_arr[] = " ( CURR_MONTHLY_MIN_PRICE >= ".(int)$tmp[0]." or CURR_MONTHLY_MAX_PRICE >= ".(int)$tmp[0].") ";
                }
                else
                {
                    $str_arr[] = "
                    (
                        ( CURR_MONTHLY_MIN_PRICE >= ".(int)$tmp[0]." and CURR_MONTHLY_MIN_PRICE <= ".(int)$tmp[1].")
                        or
                        ( CURR_MONTHLY_MAX_PRICE >= ".(int)$tmp[0]." and CURR_MONTHLY_MAX_PRICE <= ".(int)$tmp[1].")
                        or ( CURR_MONTHLY_MIN_PRICE < ".(int)$tmp[0]." and CURR_MONTHLY_MAX_PRICE >".(int)$tmp[1]." )
                        or ( CURR_MONTHLY_MAX_PRICE < ".(int)$tmp[0]." and CURR_MONTHLY_MIN_PRICE > ".(int)$tmp[1].")
                    ) ";
                }
            }
            
            if( count($str_arr) == 0 ) return '';
            else {
                return " $andor ( ". implode(' or ', $str_arr) .") ";
            }
        }
        else if( is_array($data) )
        {
            $str = $this->condition_parsing($name,$data,$rep_name1,$rep_name2,$mul,$withand );
            if($str == '') return '';
            else return " ".$andor." ( ".$str.")";
        }
        else return ' '.$andor.' `'.$name.'` = "'.$data.'"';
    }*/
    
    private function condition_parsing($col, $arr,$rep_name1,$rep_name2,$mul,$withand)
    {
        $str='';
        $start = $end= null;
        $startstr=$endstr ='';
    
        if($arr[0] =='all' || $arr[0] =='' || $arr[0] =='0') return '';
        foreach( $arr as $row )
        {
            $tmp = explode( '-', $row);
            $start = (int)$tmp[0];
            if ($str == '' ) $startstr = " ( ".$withand." `$rep_name1` >= ".$start*$mul;
            else  $startstr = " or ( ".$withand." `$rep_name1` >= ".$start*$mul;
        
            if( $end !== $start ) {
                if($endstr !='' ) $str .= $endstr;
                $str .= $startstr;
            }
            
            $end = (int)$tmp[1];
            $endstr = " and `$rep_name2` <= ".$end*$mul." ) ";
        }
        
        if( $end === 0 ) $str .= " ) ";
        else $str .= $endstr;
        
        return $str;
    }
}
