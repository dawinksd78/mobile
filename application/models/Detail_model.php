<?php
define('SEARCH_SORT_TYPE', 'STREET');//STREET - 동에따른 건물순
define('USECACHE', false);

class Detail_model extends CI_Model
{
    public $info, $spaceunit, $condition, $condition_str;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDetail($complex_idx, $complex_type, $transtype)
    {
        /*$sql = "
            SELECT
                COMPLEX_IDX,
                COMPLEX_TYPE,
                '".$transtype."' as transtype,
                cpx.COMPLEX_NAME,
                concat(LAW_ADDRESS,' ', LAW_ADDRESS_DETAIL) AS address,
                MIN_SUPPLY_AREA,
                floor(MIN_SUPPLY_AREA*0.325) AS MIN_SUPPLY_AREA_PYEONG,
                MAX_SUPPLY_AREA,
                floor(MAX_SUPPLY_AREA*0.325) AS MAX_SUPPLY_AREA_PYEONG,
                cpx.TOTAL_HOUSE_HOLD_COUNT,
                LEFT(CONSTRUCT_YEAR_MONTH,4) CONSTRUCT_YEAR,
                right(CONSTRUCT_YEAR_MONTH,2) CONSTRUCT_MONTH,
                cpx.TOTAL_DONG_COUNT,
                cpx.CONSTRUCTION_COMPANY_NAME,
                cpx.HIGH_FLOOR,
                cpx.LOW_FLOOR,
                cpx.PARKING_COUNT_BY_HOUSEHOLD,
                HEAT_METHOD_TYPE_CODE_NAME,
                HEAT_FUEL_TYPE_CODE_NAME,
                BATL_RATIO,
                BTL_RATIO,
                MANAGEMENT_OFFICE_TELNO,
                (SELECT GROUP_CONCAT(concat(AREA_NO,'|',floor(SUPPLY_AREA))) FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX=cpx.COMPLEX_IDX AND COMPLEX_TYPE=cpx.COMPLEX_TYPE order by SUPPLY_AREA) AS SUPPLY_AREA,
                (SELECT GROUP_CONCAT(IMAGE_FULL_PATH) FROM TB_CB_COMPLEX_IMG WHERE COMPLEX_IDX = cpx.COMPLEX_IDX ) AS images,
                ifnull(cpx.NAVER_FLOOR_PLAN_LINK,'') as linkto
            FROM TB_CB_COMPLEX cpx USE INDEX (IDX_TB_CB_COMPLEX)
            WHERE cpx.COMPLEX_IDX = ? AND cpx.COMPLEX_TYPE = ?
        ";*/
        
        $sql="
            SELECT
                cpx.COMPLEX_IDX,
                cpx.COMPLEX_TYPE,
                '".$transtype."' as transtype,
                cpx.COMPLEX_NAME,
                concat(LAW_ADDRESS,' ', LAW_ADDRESS_DETAIL) AS address,
                MIN_SUPPLY_AREA , floor(MIN_SUPPLY_AREA*0.325) AS MIN_SUPPLY_AREA_PYEONG,
                MAX_SUPPLY_AREA , floor(MAX_SUPPLY_AREA*0.325) AS MAX_SUPPLY_AREA_PYEONG,
                cpx.TOTAL_HOUSE_HOLD_COUNT,
                LEFT(CONSTRUCT_YEAR_MONTH,4) CONSTRUCT_YEAR,
                right(CONSTRUCT_YEAR_MONTH,2) CONSTRUCT_MONTH,
                cpx.TOTAL_DONG_COUNT,
                cpx.CONSTRUCTION_COMPANY_NAME,
                cpx.HIGH_FLOOR,
                cpx.LOW_FLOOR,
                cpx.PARKING_COUNT_BY_HOUSEHOLD,
                HEAT_METHOD_TYPE_CODE_NAME,
                HEAT_FUEL_TYPE_CODE_NAME,
                BATL_RATIO,BTL_RATIO,
                MANAGEMENT_OFFICE_TELNO,
                (SELECT GROUP_CONCAT(concat(AREA_NO,'|',floor(SUPPLY_AREA))) FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX=cpx.COMPLEX_IDX AND COMPLEX_TYPE=cpx.COMPLEX_TYPE order by SUPPLY_AREA) AS SUPPLY_AREA,
                (SELECT GROUP_CONCAT(IMAGE_FULL_PATH) FROM TB_CB_COMPLEX_IMG WHERE COMPLEX_IDX=cpx.COMPLEX_IDX) AS images,
                ifnull(cpx.NAVER_FLOOR_PLAN_LINK,'') as linkto,
                ca.CURR_SELL_MIN_PRICE,
                ca.CURR_SELL_MAX_PRICE,
                ca.CURR_CHARTERED_MIN_PRICE,
                ca.CURR_CHARTERED_MAX_PRICE
            FROM TB_CB_COMPLEX cpx USE INDEX (IDX_TB_CB_COMPLEX)
            LEFT JOIN TB_CB_COMPLEX_ATTATCH ca ON cpx.COMPLEX_IDX = ca.COMPLEX_IDX AND cpx.COMPLEX_TYPE = ca.COMPLEX_TYPE
            WHERE cpx.COMPLEX_IDX = ? AND cpx.COMPLEX_TYPE =?;
        ";
        $qry = $this->db->query($sql ,array($complex_idx, $complex_type));
        if($qry->num_rows() > 0) {
            return $qry->row_array();
        }
        else return array();
    }
    
    // 상세 정보 추가
    public function getDetailInfoView($complex_idx, $complex_type, $transtype)
    {
        if($transtype == 'sale') {
            $whereTrans = "AND g1.TRADE_TYPE IN ('1')";
        }
        else if($transtype == 'previous') {
            $whereTrans = "AND g1.TRADE_TYPE IN ('2', '3')";
        }
        else if($transtype == 'previous_2') {
            $whereTrans = "AND g1.TRADE_TYPE IN ('2')";
        }
        else if($transtype == 'previous_3') {
            $whereTrans = "AND g1.TRADE_TYPE IN ('3')";
        }
        else {
            $whereTrans = "";
        }
        
        $sql = "
            SELECT
                cpx.COMPLEX_IDX,
                cpx.COMPLEX_TYPE,
                '".$transtype."' as transtype,
                cpx.COMPLEX_NAME,
                concat(cpx.LAW_ADDRESS,' ', cpx.LAW_ADDRESS_DETAIL) AS address,
                FLOOR(cpx.MIN_SUPPLY_AREA) AS min_supply_area_m2,
                FLOOR(cpx.MIN_SUPPLY_AREA*0.325) AS MIN_SUPPLY_AREA_PYEONG,
                FLOOR(cpx.MAX_SUPPLY_AREA) AS max_supply_area_m2,
                FLOOR(cpx.MAX_SUPPLY_AREA*0.325) AS MAX_SUPPLY_AREA_PYEONG,
                cpx.TOTAL_HOUSE_HOLD_COUNT,
                LEFT(cpx.CONSTRUCT_YEAR_MONTH,4) CONSTRUCT_YEAR,
                right(cpx.CONSTRUCT_YEAR_MONTH,2) CONSTRUCT_MONTH,
                cpx.TOTAL_DONG_COUNT,
                cpx.CONSTRUCTION_COMPANY_NAME,
                cpx.HIGH_FLOOR,
                cpx.LOW_FLOOR,
                cpx.PARKING_COUNT_BY_HOUSEHOLD,
                cpx.HEAT_METHOD_TYPE_CODE_NAME,
                cpx.HEAT_FUEL_TYPE_CODE_NAME,
                cpx.BATL_RATIO,
                cpx.BTL_RATIO,
                cpx.LAT,
                cpx.LNG,
                cpx.MANAGEMENT_OFFICE_TELNO,
                cpx.REAL_ESTATE_TYPE,
                (SELECT GROUP_CONCAT(concat(AREA_NO,'|',floor(SUPPLY_AREA))) FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX=cpx.COMPLEX_IDX AND COMPLEX_TYPE=cpx.COMPLEX_TYPE order by SUPPLY_AREA) AS SUPPLY_AREA,
                if(cpx.DEFAULT_IMG IS NULL OR cpx.DEFAULT_IMG ='',
                (SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX= cpx.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1), cpx.DEFAULT_IMG) AS images,
                (SELECT GROUP_CONCAT(IMAGE_FULL_PATH) FROM TB_CB_COMPLEX_IMG WHERE COMPLEX_IDX = cpx.COMPLEX_IDX ) AS images_arr,
                ifnull(cpx.NAVER_FLOOR_PLAN_LINK,'') as linkto,

                ca.CURR_SELL_MIN_PRICE,
                ca.CURR_SELL_MAX_PRICE,
                ca.CURR_CHARTERED_MIN_PRICE,
                ca.CURR_CHARTERED_MAX_PRICE,

                SUM(CASE WHEN g1.TRADE_TYPE = 1 THEN 1 ELSE 0 END ) AS sale_cnt ,
                SUM(CASE WHEN g1.TRADE_TYPE = 2 THEN 1 ELSE 0 END ) AS charter_cnt,
                SUM(CASE WHEN g1.TRADE_TYPE = 3 THEN 1 ELSE 0 END ) AS monthly_cnt,

                IFNULL(cpx_attc.PYEONG_SELL_PRICE,0) PYEONG_SELL_PRICE,
                IFNULL(cpx_attc.PYEONG_CHARTERED_PRICE,0) PYEONG_CHARTERED_PRICE,
                IFNULL(cpx_attc.PYEONG_MONTHLY_PRICE,0) PYEONG_MONTHLY_PRICE,
                IFNULL(cpx_attc.CURR_SELL_MIN_PRICE,0) CURR_SELL_MIN_PRICE,
                IFNULL(cpx_attc.CURR_SELL_MAX_PRICE,0) CURR_SELL_MAX_PRICE,
                IFNULL(cpx_attc.CURR_CHARTERED_MIN_PRICE,0) CURR_CHARTERED_MIN_PRICE,
                IFNULL(cpx_attc.CURR_CHARTERED_MAX_PRICE,0) CURR_CHARTERED_MAX_PRICE,
                IFNULL(cpx_attc.PYEONG_DEPOSIT_PRICE,0) PYEONG_DEPOSIT_PRICE,
                IFNULL(cpx_attc.CURR_MONTHLY_MIN_PRICE,0) CURR_MONTHLY_MIN_PRICE,
                IFNULL(cpx_attc.CURR_MONTHLY_MAX_PRICE,0) CURR_MONTHLY_MAX_PRICE,
                IFNULL(cpx_attc.CURR_MONTHLY_DEPOSIT_MIN_PRICE,0) CURR_MONTHLY_DEPOSIT_MIN_PRICE,
                IFNULL(cpx_attc.CURR_MONTHLY_DEPOSIT_MAX_PRICE,0) CURR_MONTHLY_DEPOSIT_MAX_PRICE
            FROM TB_CB_COMPLEX cpx USE INDEX (IDX_TB_CB_COMPLEX)
                LEFT JOIN TB_CB_COMPLEX_ATTATCH cpx_attc on cpx.COMPLEX_IDX = cpx_attc.COMPLEX_IDX and cpx.COMPLEX_TYPE = cpx_attc.COMPLEX_TYPE
                LEFT JOIN TB_CB_COMPLEX_ATTATCH ca ON cpx.COMPLEX_IDX = ca.COMPLEX_IDX AND cpx.COMPLEX_TYPE = ca.COMPLEX_TYPE
                LEFT JOIN TB_UM_GOODS g1 on cpx.COMPLEX_IDX = g1.COMPLEX_IDX and cpx.COMPLEX_TYPE = g1.CATEGORY AND g1.GOODS_PROCESS_STATUS ='PS2' $whereTrans AND ( g1.GOODS_STATUS ='SB' or g1.GOODS_STATUS='CF' OR (g1.GOODS_STATUS ='DR' AND g1.TRADE_DATE > DATE_ADD(NOW(), INTERVAL -1 WEEK) ) )
            WHERE cpx.COMPLEX_IDX = ? AND cpx.COMPLEX_TYPE = ?
        ";
        $qry = $this->db->query($sql ,array($complex_idx, $complex_type));
        if($qry->num_rows() > 0) {
            return $qry->row_array();
        }
        else return array();
    }
    
    public function getAreaList($complex_idx, $complex_type)
    {
       // $sql = "SELECT CONCAT('N', a.AREA_NO) AS idx, a.AREA_NAME, a.SUPPLY_AREA, a.PYEONG_NAME FROM TB_CB_COMPLEX_AREA a WHERE COMPLEX_IDX = ? and COMPLEX_TYPE= ?";
        $sql = "SELECT CONCAT('N', a.AREA_NO) AS idx, a.AREA_NAME, a.SUPPLY_AREA, a.PYEONG_NAME ,SUPPLY_PYEONG, EXCLUSIVE_AREA, EXCLUSIVE_PYEONG, HO_CNT, EXCLUSIVE_RATE, ENTRANCETYPE
                FROM TB_CB_COMPLEX_AREA a WHERE COMPLEX_IDX = ? and COMPLEX_TYPE = ? ORDER BY SUPPLY_AREA";
        $qry = $this->db->query($sql ,array($complex_idx, $complex_type));
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else return array();
    }
    
    public function goodsGetImages($goods_idx, $filesep)
    {
        $sql = "SELECT * FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = ? AND FILE_SEPARATE = ?";
        $qry = $this->db->query($sql ,array($goods_idx, $filesep));
        
        $qry = $this->db->order_by('FILE_SEPARATE ASC, SORT_ORDER ASC')->get_where('TB_UM_GOODS_IMG', array('GOODS_IDX'=>$goods_idx, 'DISPLAY_FLAG'=>'Y'));
        
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else return array();
    }
    
    // 매물사진수정 등록,삭제
    function getGoodsImg($goods_idx, $filesep)
    {
        $qry = $this->db->order_by('FILE_SEPARATE ASC, SORT_ORDER ASC')->get_where('TB_UM_GOODS_IMG', array('GOODS_IDX'=>$goods_idx, 'DISPLAY_FLAG'=>'Y', 'FILE_SEPARATE'=>$filesep));
        if($qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    public function getGoodsCount($complex_idx, $complex_type,$transtype) {
        ;
    }
    
    public function getTradeHistory($complex_idx, $complex_type, $area_no, $transtype)
    {
        if ($transtype == 'sale') $trance = "1";
        else if ($transtype == 'previous') $trance = "2";
        else $trance = "1,2";
        
        $sql = "
            SELECT
            	a.TRADE_YEAR REG_YEAR, a.TRADE_MONTH REG_MONTH, a.TRADE_TYPE TRADE_TYPE, a.PRICE1 AVG1, a.PRICE2 AVG2, a.TRADE_COUNT cnt
            FROM TB_CB_SCHD_REAL_PRICE a
            WHERE
            a.COMPLEX_IDX = ?
            AND a.COMPLEX_TYPE = ?
            AND a.AREA_NO = ?
            AND TRADE_TYPE IN (".$trance.")
            ORDER BY TRADE_YEAR, TRADE_MONTH
        ";
        $qry = $this->db->query( $sql, array($complex_idx, $complex_type, $area_no ) );
        
        if( $qry->num_rows() > 0 ) {
            $data = $qry->result_array();
        }
        else return false;
        
        if( $this->input->get("view") == "human" ) {
            return array("org"=>$data, "js"=>$this->makeTradeHistoryArray($data, $transtype));
        }
        
        return $this->makeTradeHistoryArray($data, $transtype);
    }
    
    public function getTradeList($complex_idx, $complex_type, $area_no, $transtype, $page=0, $per_page=5)
    {
        if ($transtype == 'sale') $trance = "1";
        else if ($transtype == 'previous') $trance = "2";
        else $trance = "1,2";
        
        $sql = "
            (
              SELECT
                 b1.TRADE_TYPE, b1.TRADE_YM, b1.FLOOR, b1.PRICE1, b1.PRICE2, b1.PRICE3,
                 case
                  when TRADE_D_CODE = 1 then '초'
                  when TRADE_D_CODE = 2 then '중'
                  when TRADE_D_CODE = 3 then '말'
                  else ''
                end as rangecode
               FROM TB_CB_SCHD_REAL_PRICE_HIS b1
               WHERE
                 b1.COMPLEX_IDX = ? AND b1.COMPLEX_TYPE = ? AND b1.AREA_NO = ?
                   and b1.TRADE_TYPE IN(".$trance.")
            ) UNION ALL (
              SELECT
                 b2.TRADE_TYPE, b2.TRADE_YM, b2.FLOOR, b2.PRICE1, b2.PRICE2, b2.PRICE3,
                 case
                  when TRADE_D_CODE = 1 then '초'
                  when TRADE_D_CODE = 2 then '중'
                  when TRADE_D_CODE = 3 then '말'
                  else ''
                end as rangecode
               FROM TB_CB_SCHD_REAL_PRICE_PREV_HIS b2
               WHERE
                b2.COMPLEX_IDX = ? AND b2.COMPLEX_TYPE = ? AND b2.AREA_NO = ?
                and b2.TRADE_TYPE IN(".$trance.")
            )
            ORDER BY TRADE_YM DESC LIMIT ?,?
            ";
        $qry = $this->db->query($sql, array($complex_idx, $complex_type,$area_no,$complex_idx, $complex_type,$area_no, (($page==0 ) ? 0: ($per_page*$page-($per_page-3)) ), ( ($page==0)? 3: $per_page) ) );
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else return array();
    }
    
    private function makeTradeHistoryArray(&$data, $transtype)
    {
        date_default_timezone_set('UTC');
        $his = array("sale"=>array(), "charter"=>array(), "un"=>array() );
        $startyear = null;
        $startmonth = null;
    
        foreach($data as $ind=>&$row)
        {
            $type = "";
            if($row['TRADE_TYPE'] == '1') $type = "sale";
            else if($row['TRADE_TYPE'] == '2') $type = "charter";
            else $type = "un";
            
            if( $ind == 0 ) {
                $startyear = $row['REG_YEAR']; $startmonth=$row['REG_MONTH'];
            }
            $his[$type][ sprintf("%04d-%02d", $row['REG_YEAR'], $row['REG_MONTH']) ] = $row;
        }
        
        list($sale, $sale_cnt, $last_sale_price) = $this->makeTradeHistory($his['sale'],1, $transtype, $startyear, $startmonth);
        list($charter, $charter_cnt, $last_charter_price) = $this->makeTradeHistory($his['charter'],2, $transtype, $startyear, $startmonth);
        
        return array("sale"=>$sale, "sale_cnt"=>$sale_cnt, "sale_price"=>$last_sale_price, "charter"=>$charter, "charter_cnt"=>$charter_cnt, "charter_price"=>$last_charter_price);
    }
    
    private function makeTradeHistory(&$his, $trade_type, $transtype, $startyear, $startmonth)
    {
        date_default_timezone_set('UTC');
        $price=$cnt = array();
        $nowyear = date('Y');
        $nowmonth = date('m');
        $setprice = $prev_price=$prev_cnt = NULL;
        $isset = false;
        $year = $nowyear-10;
        $month = $nowmonth;
        $start2 = (int)(sprintf("%04d-%02d", $year, $month) );
    
        $start1 = (int)(sprintf("%04d-%02d", $startyear, $startmonth) );
        if( $start1 > $start2 ) {
            $year = $startyear;
            $month = $startmonth;
        }
        if( $transtype == 'all' || ($transtype == "sale" && $trade_type == 1) || ($transtype == "charter" && $trade_type == 2) ) $isavail = true;
        else $isavail = false;
    
        for($year; $year <= $nowyear;  $year++)
        {
            for($month ; $month <=12; $month++)
            {
                $yearmonth = sprintf("%04d-%02d", $year, $month);
                if(isset($his[$yearmonth])) {
                    $isset = true;
                    $setprice =$prev_price= round($his[$yearmonth]['AVG'. $trade_type]);
                    $setcnt = (int)$his[$yearmonth]['cnt'];
                }
                else {
                    if( !$isset ) continue;
                    $setprice = $prev_price;
                    $setcnt = NULL;
                }
                $time = strtotime($yearmonth."-01")*1000;
    
                $price[] = array( $time, $setprice );
                $cnt[] = array( $time, (int)$setcnt );
                if($year == $nowyear && $month == $nowmonth) break;
            }
            $month = 1;
        }
        
        return array( $price, $cnt, $setprice);
    }
}
