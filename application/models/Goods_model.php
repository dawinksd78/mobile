<?php
class Goods_model extends CI_Model
{
    public $info, $spaceunit, $condition, $condition_str;
    
    public function __construct() {
        parent::__construct();
    }
  
    public function checkInCode($code ,$CODE_GBN, $CODE_TYPE='A')
    {
        if ( $CODE_GBN =='GOODS_FEATURE') $CODE_GBN = 'GOODS_FEATURES';
        else if ( $CODE_GBN =='DIRECTION') $CODE_GBN = 'ARR_DIRECTIONS';
    
        $sql = "SELECT CODE_DETAIL FROM TB_CB_CODE a
        WHERE a.CODE_GBN = ? AND a.USE_YN ='Y' AND a.CODE_TYPE = ? AND a.CODE_DETAIL = ? limit 1";
        $qry = $this->db->query( $sql, array($CODE_GBN, $CODE_TYPE,( $CODE_GBN=='OPTIONS' ? 'O'.$code: $code) ) );
    
        if( $qry->num_rows() > 0 ) return true;
        else return false;
    }
    
    public function makeGoodsNo($Complex_type, $LAW_DONG_CODE)
    {
        $this->load->helper('string');
        $match =array("APT"=>'A', 'OFT'=>'F','ONE'=>'N');
        
        if(strlen( $LAW_DONG_CODE) == 10) $LAW_DONG_CODE = substr($LAW_DONG_CODE,0,8);
        return $match[$Complex_type].$LAW_DONG_CODE.date('yd').random_string('nozero',5).date('m');
    }
    
    public function getComplexAddrInfo($complex_idx)
    {
        $sql = "SELECT
                a.LAW_ADDRESS AS LAW_ADDR1, a.LAW_ADDRESS_DETAIL as LAW_ADDR2, 
                a.SIDO_CODE AS LAW_SIDO_CODE,a.SIDO as LAW_SIDO, a.SIGUNGU_CODE AS LAW_SIGUNGU_CODE, a.SIGUNGU AS LAW_SIGUNGU, 
                a.LAW_DONG_CODE , a.LAW_DONG_NAME AS LAW_DONG, CONCAT(SIDO , ' ',SIGUNGU ) AS  ROAD_ADDR, a.ROAD_ADDRESS ROAD_ADDR1
                FROM TB_CB_COMPLEX a
                WHERE COMPLEX_IDX=?";
        return $this->db->query($sql, array($complex_idx))->row_array();
    }
    
    public function getAddrInfobyDONG($LAW_DONG_CODE)
    {
        $sql = "SELECT
                a.SIDO_CODE AS LAW_SIDO_CODE, a.SIDO AS LAW_SIDO, 
                a.SIGUNGU_CODE AS LAW_SIGUNGU_CODE, a.SIGUNGU AS LAW_SIGUNGU, 
                a.DONG AS LAW_DONG
                FROM TB_CB_ADDR a
                WHERE a.LAW_DONG_CODE = ?";
        return $this->db->query($sql, array($LAW_DONG_CODE))->row_array();
    }
    
    // 매물 등록시 입력되는 중개사 정보 등록 처리
    public function realtorselectedToArr($MBR_IDX, $realtors)
    {
        if($realtors == '') return true;
        $tmp = explode ( ",", $realtors);
        $ret = array();
        foreach($tmp as $idx=>$val) {
            $ret[] = array( 'GOODS_IDX'=> $MBR_IDX, "BROKER_OFFICE_IDX"=> (int)$val);
        }
        
        if(count($ret) > 0) {
            $this->db->insert_batch('TB_UA_GOODS_BROKER', $ret );
            return true;
        }
        
        return false;
    }
    
    // 코드명 출력
    public function getCodeName($CODE_GBN, $CODE_DETAIL, $CODE_TYPE='A')
    {
        $qry = $this->db->select("CODE_NAME")->get_where('TB_CB_CODE', array('CODE_GBN'=>$CODE_GBN, 'CODE_DETAIL'=>$CODE_DETAIL,'CODE_TYPE'=>$CODE_TYPE));
        if ($qry->num_rows() < 1) return false;
        $row = $qry->row_array();
        return $row['CODE_NAME'];
    }
    
    public function moveTmpImages($MBR_IDX,$goods_idx,$category)
    {
        $sql = "SELECT * FROM TB_TMP_FOR_SALE_IMAGE a WHERE a.MBR_IDX = ? AND a.CATEGORY = ? order by a.`INOUT`, IMG_IDX";
        $qry = $this->db->query( $sql, array($MBR_IDX, $category) );
        if( $qry->num_rows() > 0 )
        {
            $rows = $qry->result_array();
            $insRows = [];
            foreach( $rows as $idx=>$row )
            {
                $tmp = array( "GOODS_IDX"=>$goods_idx);
                $url = parse_url($row['IMG_FULL_PATH']);
                $tmp['SERVER_PATH']= $url['scheme']."://".$url['host'];
                $tmp['FULL_PATH'] = $url['path'];
                $tmp['FILE_NAME'] = $row['FILEKEY'];
                $tmp['FILE_SEPARATE'] = $row['INOUT'];
                $tmp['FILE_CATEGORY'] = $category;
                $tmp['DISPLAY_FLAG'] ='Y';
                $tmp['SORT_ORDER'] = ($idx+1);
                $insRows[] = $tmp;
            }
            
            if( $this->db->insert_batch('TB_UM_GOODS_IMG', $insRows) ) {
                $this->makeGoodsDefaultImg($goods_idx);
                $this->db->where('MBR_IDX', $MBR_IDX)->where('CATEGORY', $category)->delete('TB_TMP_FOR_SALE_IMAGE');
            }
        }
        
        return true;
    }
    
    public function makeGoodsDefaultImg($goods_idx)
    {
        $default_img='';
        $sql ="SELECT CONCAT(a.SERVER_PATH, a.FULL_PATH) AS img  FROM TB_UM_GOODS_IMG a WHERE a.GOODS_IDX = ? ORDER BY a.FILE_SEPARATE, a.SORT_ORDER, a.GOODS_IMG_IDX LIMIT 1";
        $qry = $this->db->query( $sql, array($goods_idx) );
        if( $qry->num_rows() > 0 ) {
            $row = $qry->row_array();
            $default_img = $row['img'];
        }
        else
        {
            $sql = "SELECT
                    IFNULL (
                    (
                      SELECT b.DEFAULT_IMG AS img
                      FROM TB_UM_GOODS a
                      JOIN TB_CB_COMPLEX b on a.COMPLEX_IDX = b.COMPLEX_IDX AND a.CATEGORY = b.COMPLEX_TYPE
                      WHERE a.GOODS_IDX= ?
                    ), (
                      SELECT b.IMAGE_FULL_PATH AS img
                      FROM TB_UM_GOODS a
                      JOIN TB_CB_COMPLEX_IMG b ON a.COMPLEX_IDX = b.COMPLEX_IDX
                      WHERE a.GOODS_IDX= ?
                      ORDER BY b.SORT_ORDER , b.TB_CB_COMPLEX_IMG_IDX
                      LIMIT 1
                      )
                    ) AS img";
            $qry = $this->db->query( $sql, array($goods_idx, $goods_idx) );
            if( $qry->num_rows() > 0 ) {
                $row = $qry->row_array();
                $default_img = $row['img'];
            }
        }
        
        return $this->db->set("DEFAULT_IMG_PATH", $default_img)->where('GOODS_IDX', $goods_idx)->update('TB_UM_GOODS');
    }
    
    public function changeRealtorAvail( $goods_idx)
    {
        $sql = "SELECT if( SUM( if( REG_DATE > DATE_SUB( NOW() , INTERVAL 7 DAY), 1, 0 )) > 0, 'disable','able' ) disablecheck FROM TB_UA_GOODS_BROKER WHERE GOODS_IDX= ?";
        $row = $this->db->query($sql, array($goods_idx) )->row_array();
        return $row['disablecheck'];
    }
    
    //반경 5km 중계사 정보
    public function nearEstate($lat, $lng)
    {
        $mbr_idx = ( isset($this->userinfo['MBR_IDX']) && $this->userinfo['MBR_IDX'] > 0 ) ? $this->userinfo['MBR_IDX'] : '-1';
        list( $lat0, $lat1, $lng0, $lng1) = $this->box($lat, $lng, 5);
        $sql = "SELECT 
                bo.BROKER_OFFICE_IDX, bo.OFFICE_NAME, bo.OFFICE_TITLE, bo.ADDR1, bo.ADDR2, bo.PHONE, bo.LAT, bo.LNG, bo.BROKER_POINT, bo.BROKER_POINT_CNT, bo.PHONE, 
                ( 6371 * acos( cos( radians(?) ) * cos( radians( bo.`LAT` ) ) * cos( radians( bo.`LNG` ) - radians(?) ) + sin( radians(?) ) * sin( radians( bo.`LAT` ) ) ) ) AS distancekm, 
                mbr.MBR_IDX, mbr.MBR_NAME, mbr.MBR_IMAGE_FULL_PATH 
                FROM TB_AB_BROKER_OFFICE bo 
                JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo_ac.ACC_START_DATE <= CURDATE() AND bo_ac.ACC_END_DATE >= CURDATE() 
                JOIN TB_UB_MEMBER mbr ON bo_ac.MBR_IDX = mbr.MBR_IDX AND mbr.MBR_GUBUN ='BU' AND mbr.MBR_STATUS='NM' 
                WHERE bo.LAT >= ? AND bo.LAT <= ? AND bo.LNG >= ? AND bo.LNG <= ? 
                AND ( bo.APPROVAL_STATUS in('PS3', 'CA','CN','CR') ) AND bo.WORKING_STATUS = 'WO' AND bo.OFFICE_STATUS='1' 
                HAVING distancekm <= 10
                ORDER BY distancekm ASC";
        $qry = $this->db->query($sql, array($lat, $lng, $lat ,$lat0, $lat1, $lng0, $lng1) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        return array();
    }
    //반경 5km 중계사 정보 중복제거
    public function nearEstateOver($lat, $lng)
    {
        $mbr_idx = ( isset($this->userinfo['MBR_IDX']) && $this->userinfo['MBR_IDX'] > 0 ) ? $this->userinfo['MBR_IDX'] : '-1';
        list( $lat0, $lat1, $lng0, $lng1) = $this->box($lat, $lng, 5);
        $sql = "SELECT
                    bo.LAT, bo.LNG,
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( bo.`LAT` ) ) * cos( radians( bo.`LNG` ) - radians(?) ) + sin( radians(?) ) * sin( radians( bo.`LAT` ) ) ) ) AS distancekm
                FROM TB_AB_BROKER_OFFICE bo
                JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo_ac.ACC_START_DATE <= CURDATE() AND bo_ac.ACC_END_DATE >= CURDATE()
                JOIN TB_UB_MEMBER mbr ON bo_ac.MBR_IDX = mbr.MBR_IDX AND mbr.MBR_GUBUN ='BU' AND mbr.MBR_STATUS='NM' 
                WHERE bo.LAT >= ? AND bo.LAT <= ? AND bo.LNG >= ? AND bo.LNG <= ?
                AND ( bo.APPROVAL_STATUS in('PS3', 'CA','CN','CR') ) AND bo.WORKING_STATUS = 'WO' AND bo.OFFICE_STATUS='1'
                GROUP BY bo.LAT, bo.LNG
                HAVING distancekm <= 10
                ORDER BY distancekm ASC";
        $qry = $this->db->query($sql, array($lat, $lng, $lat ,$lat0, $lat1, $lng0, $lng1) );
        if( $qry->num_rows() > 0 ) return $qry->result_array();
        return array();
    }
    
    // 매물기준 중계사 반경 5km , 매물문의 포함
    public function goodsNearEstate($goods_idx, $lat, $lng)
    {
        $mbr_idx = (isset($this->userinfo['MBR_IDX']) && $this->userinfo['MBR_IDX'] > 0) ? $this->userinfo['MBR_IDX'] : '-1';
        list($lat0, $lat1, $lng0, $lng1) = $this->box($lat, $lng, 5);
        $sql = "SELECT
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( bo.`LAT` ) ) * cos( radians( bo.`LNG` ) - radians(?) ) + sin( radians(?) ) * sin( radians( bo.`LAT` ) ) ) ) AS distancekm,
                    bo.*, mbr.MBR_IDX, mbr.MBR_NAME, mbr.MBR_IMAGE_FULL_PATH, qna.QNA_IDX, qna.ANSWER_YN
                FROM TB_AB_BROKER_OFFICE bo
                JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo_ac.ACC_START_DATE <= CURDATE() AND bo_ac.ACC_END_DATE >= CURDATE()
                JOIN TB_UB_MEMBER mbr ON bo_ac.MBR_IDX = mbr.MBR_IDX AND mbr.MBR_GUBUN ='BU' AND mbr.MBR_STATUS='NM' 
                LEFT JOIN TB_UA_QNA qna ON qna.MBR_IDX = ? AND qna.GOODS_IDX = ? AND  qna.BROKER_OFFICE_IDX= bo.BROKER_OFFICE_IDX
                WHERE bo.LAT >= ? AND bo.LAT <= ? AND bo.LNG >= ? AND bo.LNG <= ?
                AND ( bo.APPROVAL_STATUS in('PS3', 'CA','CN','CR') ) AND bo.WORKING_STATUS = 'WO' AND bo.OFFICE_STATUS='1' 
                HAVING distancekm <= 10 
                ORDER BY distancekm ASC";
        $qry = $this->db->query($sql, array($lat, $lng, $lat , $mbr_idx ,$goods_idx ,$lat0, $lat1, $lng0, $lng1));
        if($qry->num_rows() > 0) return $qry->result_array();
        return array();
    }
    
    // 매물연계된 중개사
    public function goodsConnectBroker($goods_idx)
    {
        $mbr_idx = (isset($this->userinfo['MBR_IDX']) && $this->userinfo['MBR_IDX'] > 0) ? $this->userinfo['MBR_IDX'] : '-1';
        $sql = "SELECT 
                bo.*, mbr.MBR_IDX, mbr.MBR_NAME, mbr.MBR_IMAGE_FULL_PATH, qna.QNA_IDX, qna.ANSWER_YN 
                FROM TB_UA_GOODS_BROKER gb
                JOIN TB_AB_BROKER_OFFICE bo ON gb.BROKER_OFFICE_IDX=bo.BROKER_OFFICE_IDX
                JOIN TB_AB_BROKER_ACCOUNT bo_ac ON gb.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo_ac.ACC_START_DATE <= CURDATE() AND bo_ac.ACC_END_DATE >= CURDATE()
                JOIN TB_UB_MEMBER mbr ON bo_ac.MBR_IDX = mbr.MBR_IDX AND mbr.MBR_GUBUN ='BU' AND mbr.MBR_STATUS='NM'
                LEFT JOIN TB_UA_QNA qna ON qna.MBR_IDX = ? AND qna.GOODS_IDX = ? AND  qna.BROKER_OFFICE_IDX= gb.BROKER_OFFICE_IDX 
                WHERE gb.GOODS_IDX = ? AND bo.WORKING_STATUS = 'WO' AND bo.OFFICE_STATUS='1'";
        $qry = $this->db->query($sql, array($mbr_idx ,$goods_idx, $goods_idx));
        if($qry->num_rows() > 0) return $qry->result_array();
        return array();
    }
    
    // 중계사 지정
    public function goodsEstate($goods_idx, $lat, $lng)
    {
        $mbr_idx =  ( isset($this->userinfo['MBR_IDX']) && $this->userinfo['MBR_IDX'] > 0 ) ? $this->userinfo['MBR_IDX'] : '-1';
        $sql = "SELECT
                    ( 6371 * acos( cos( radians(?) ) * cos( radians( bo.`LAT` ) ) * cos( radians( bo.`LNG` ) - radians(?) ) + sin( radians(?) ) * sin( radians( bo.`LAT` ) ) ) ) AS distancekm,
                    bo.*, mbr.MBR_IDX, mbr.MBR_NAME, mbr.MBR_IMAGE_FULL_PATH, qna.QNA_IDX, qna.ANSWER_YN
                FROM  TB_UA_GOODS_BROKER gb
            	JOIN TB_AB_BROKER_OFFICE bo ON gb.BROKER_OFFICE_IDX = bo.BROKER_OFFICE_IDX
                JOIN TB_AB_BROKER_ACCOUNT bo_ac ON bo.BROKER_OFFICE_IDX = bo_ac.BROKER_OFFICE_IDX AND bo_ac.ACC_START_DATE <= CURDATE() AND bo_ac.ACC_END_DATE >= CURDATE()
                JOIN TB_UB_MEMBER mbr ON bo_ac.MBR_IDX = mbr.MBR_IDX AND mbr.MBR_GUBUN ='BU' AND mbr.MBR_STATUS='NM' 
                LEFT JOIN TB_UA_QNA qna ON qna.MBR_IDX = ? AND qna.GOODS_IDX = ? AND  qna.BROKER_OFFICE_IDX= bo.BROKER_OFFICE_IDX
                WHERE gb.GOODS_IDX = ?
                AND ( bo.APPROVAL_STATUS in('PS3', 'CA','CN','CR') ) AND bo.WORKING_STATUS = 'WO' AND bo.OFFICE_STATUS='1'
                ORDER BY distancekm ASC
                ";
        $qry = $this->db->query($sql, array($lat, $lng, $lat, $mbr_idx, $goods_idx, $goods_idx));
        if($qry->num_rows() > 0) return $qry->result_array();
        return array();
    }
    
    // 아파트매물상세
    public function goodsViewinfoAPT($goods_idx, $MBR_IDX=false)
    {
        $sql = "SELECT ifnull(count(CONTRACT_IDX),0) isbuyer FROM TB_AB_CONTRACT WHERE GOODS_IDX = ? AND BUYER_MBR_IDX = ?";
        $tmp = $this->db->query($sql, array($goods_idx, $MBR_IDX))->row_array();
        $isbuyer = $tmp['isbuyer'];
        
        $sql = "SELECT
                	cpx.COMPLEX_NAME, cpx.TOTAL_HOUSE_HOLD_COUNT, cpx.TOTAL_DONG_COUNT, concat(left(cpx.CONSTRUCT_YEAR_MONTH,4), '.', RIGHT(cpx.CONSTRUCT_YEAR_MONTH,2)) AS CONSTRUCT_YEAR_MONTH,
                	cpx.CONSTRUCTION_COMPANY_NAME, cpx.PARKING_COUNT_BY_HOUSEHOLD, cpx.HEAT_METHOD_TYPE_CODE_NAME, cpx.HEAT_FUEL_TYPE_CODE_NAME, 
                    cpx.HIGH_FLOOR, cpx.LOW_FLOOR, cpx.BATL_RATIO, cpx.BTL_RATIO, cpx.NAVER_FLOOR_PLAN_LINK, IF(fav.GOODS_IDX IS null, 0, 1) AS isfav, 
                	(SELECT GROUP_CONCAT(concat(AREA_NO, '|', floor(SUPPLY_AREA))) FROM TB_CB_COMPLEX_AREA WHERE COMPLEX_IDX = cpx.COMPLEX_IDX AND COMPLEX_TYPE=cpx.COMPLEX_TYPE) AS SUPPLY_AREA,
                    (SELECT GROUP_CONCAT(concat(SERVER_PATH, FULL_PATH)) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = goods.GOODS_IDX order by FILE_SEPARATE, GOODS_IMG_IDX) AS images, 
                    (SELECT GROUP_CONCAT(CONCAT(IMAGE_FULL_PATH)) FROM TB_CB_COMPLEX_IMG WHERE COMPLEX_IDX = cpx.COMPLEX_IDX ORDER BY SORT_ORDER ) AS cpx_images, 
                	goods.*, cbcd.CODE_NAME AS ROOMTYPETXT, ifnull(cbcd_dir.CODE_NAME, ' - ') AS DIRECTIONTEXT, addr.LAW_DONG_NAME as dongname, 
                    (SELECT GROUP_CONCAT(concat(AREA_NO,'|', SUPPLY_AREA)) FROM TB_CB_COMPLEX_AREA a WHERE a.COMPLEX_IDX = cpx.COMPLEX_IDX AND a.COMPLEX_TYPE = cpx.COMPLEX_TYPE ORDER BY a.SUPPLY_AREA) AS areas
                FROM TB_UM_GOODS goods
                JOIN TB_CB_ADDR addr ON goods.LAW_DONG_CODE = addr.LAW_DONG_CODE
                LEFT JOIN TB_CB_COMPLEX cpx ON goods.COMPLEX_IDX = cpx.COMPLEX_IDX AND goods.CATEGORY = cpx.COMPLEX_TYPE
                LEFT JOIN TB_UM_MY_GOODS fav ON goods.GOODS_IDX = fav.GOODS_IDX
                LEFT JOIN TB_CB_CODE cbcd ON  cbcd.CODE_GBN = 'ROOM_TYPE' AND  goods.ROOM_TYPE = cbcd.CODE_DETAIL
                LEFT JOIN TB_CB_CODE cbcd_dir ON  cbcd.CODE_GBN = 'ARR_DIRECTIONS' AND  goods.DIRECTION = cbcd.CODE_DETAIL
                WHERE goods.GOODS_IDX = ? ";
        if($isbuyer) {
            ;
        }
        else if(!$MBR_IDX) $sql .= "AND (goods.GOODS_STATUS ='SB' OR goods.GOODS_STATUS ='CF' ) AND goods.GOODS_PROCESS_STATUS ='PS2'";
        else {
            $sql .= "AND ( ( (goods.GOODS_STATUS ='SB' OR goods.GOODS_STATUS ='CF' ) AND goods.GOODS_PROCESS_STATUS ='PS2') or (goods.REG_MBR_IDX = ".(int)$MBR_IDX.") )";
        }
        $qry = $this->db->query($sql, array($goods_idx));
        
        if($qry->num_rows() > 0)
        {
            $ret['data'] = $qry->row_array();
            if($ret['data']['AGENCY_OPEN_FLAG'] == 'Y')
            {
                // 중계사선택
                $res = $this->goodsEstate($goods_idx,$ret['data']['LAT'], $ret['data']['LNG']);
                if(count($res) > 0) {
                    $ret['estate'] = $res; return $ret;
                }
                else {
                    $ret['estate'] = array();
                    return $ret;
                    
                    // 반경중계사로
                    $ret['estate'] = $this->goodsNearEstate($goods_idx, $ret['data']['LAT'], $ret['data']['LNG']);
                    return $ret;
                }
            }
            else {
                // 반경중계사로
                $ret['estate'] = $this->goodsNearEstate($goods_idx, $ret['data']['LAT'], $ret['data']['LNG']);
                return $ret;
            }
        }
        else return array();
    }
    
    // 반경 좌표 계산
    private function box($lat, $lng, $distance)
    {
        $distance = $distance*0.621371;
        $lat1 = $lat-($distance/69);
        $lat2= $lat+($distance/69);
        $lng1 = $lng-$distance/abs(cos(deg2rad($lat))*69);
        $lng2 = $lng+$distance/abs(cos(deg2rad($lat))*69);
        
        return array($lat1, $lat2, $lng1, $lng2);
    }
    
    // 거리계산
    private function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        echo $lat1."<br>".$lat2."<br>";
        
        if(($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else
        {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            
            if($unit == "K") {
                return ($miles * 1.609344);
            }
            else if($unit == "N") {
                return ($miles * 0.8684);
            }
            else {
                return $miles;
            }
        }
    }
}