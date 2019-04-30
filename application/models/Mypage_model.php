<?php
class Mypage_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    
    // 알람
    public function alarmlist($USERINFO)
    {
        $useridx = $USERINFO['memberidx'];
        
        $sql = "SELECT a.*, b.TITLE, b.MESSAGE FROM TB_CB_SMS_SEND_RESULT AS a LEFT JOIN TB_CB_SMS_HIS AS b ON a.SMS_HIS_IDX=b.SMS_HIS_IDX WHERE a.MBR_IDX='$useridx' AND a.VIEW_DATE IS NULL ORDER BY a.SMS_SEND_RESULT_IDX DESC";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    // 알람보기
    public function alarmviewresult($DATAINFO)
    {
        $smsidx = $DATAINFO['smsidx'];
        
        $viewdate = date("Y-m-d H:i:s");
        
        $data = array(
            'VIEW_DATE' => $viewdate,
        );
        $this->db->where('SMS_SEND_RESULT_IDX', $smsidx);
        $res = $this->db->update('TB_CB_SMS_SEND_RESULT', $data);
        if($res) {
            return "SUCCESS";
        }
        else {
            return "FAIL";
        }
    }
    
    // 내집구하기 (찜한매물)
    public function getMyFavorite($MBR_IDX)
    {
        $sql = "
            SELECT
                gd.*, cpx.COMPLEX_NAME , date_format( gd.TRADE_DATE, '%Y-%m-%d') as TRADE_DATE_FORMAT,
                IFNULL(
          		    (SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = gd.GOODS_IDX and DISPLAY_FLAG='Y' ORDER BY SORT_ORDER LIMIT 1),
          		    if(gd.CATEGORY = 'ONE', null, ( SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX=gd.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1))
          		) AS imgsrc
            FROM TB_UM_MY_GOODS PARTITION(p". ($MBR_IDX % 5) .") mygd
            JOIN TB_UM_GOODS gd ON mygd.GOODS_IDX = gd.GOODS_IDX
            LEFT JOIN TB_CB_COMPLEX cpx ON gd.COMPLEX_IDX = cpx.COMPLEX_IDX AND gd.CATEGORY = cpx.COMPLEX_TYPE
            WHERE mygd.MBR_IDX = ? and gd.GOODS_STATUS != 'TR'
            ORDER BY mygd.REG_DATE desc
        ";
        $qry = $this->db->query($sql, array($MBR_IDX));
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else return array();
    }
    
    // 내집구하기 (내계약매물)
    public function getMyContractGoods($MBR_IDX)
    {
        $sql = "
            SELECT
              gd.*,cntrt.BROKER_OFFICE_IDX,if( mygd.MBR_IDX is null, 'N', 'Y') as isfav
              , if( eva.EVALUATION_IDX IS NULL , 'N', 'Y') AS iseval, cpx.COMPLEX_NAME
              , date_format( gd.TRADE_DATE, '%Y-%m-%d') as TRADE_DATE_FORMAT
              ,IFNULL(
               (SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = gd.GOODS_IDX and DISPLAY_FLAG='Y' ORDER BY SORT_ORDER LIMIT 1)
               , if ( gd.CATEGORY = 'ONE' , null
                  , ( SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX=gd.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1 )
                  )
              ) AS imgsrc
            FROM TB_AB_CONTRACT cntrt
            JOIN TB_UM_GOODS gd ON cntrt.GOODS_IDX = gd.GOODS_IDX AND gd.GOODS_STATUS ='DR'
            LEFT JOIN TB_CB_COMPLEX cpx ON gd.COMPLEX_IDX = cpx.COMPLEX_IDX AND gd.CATEGORY = cpx.COMPLEX_TYPE
            LEFT JOIN TB_UM_MY_GOODS PARTITION(p". ($MBR_IDX % 5) .") mygd ON cntrt.BUYER_MBR_IDX = mygd.MBR_IDX   and cntrt.GOODS_IDX = mygd.GOODS_IDX
            LEFT JOIN TB_UA_BROKER_EVALUATION eva ON cntrt.BUYER_MBR_IDX = eva.MBR_IDX AND cntrt.GOODS_IDX = eva.GOODS_IDX AND cntrt.BROKER_OFFICE_IDX = eva.BROKER_OFFICE_IDX
            WHERE cntrt.BUYER_MBR_IDX = ?
        ";
        $qry = $this->db->query($sql, array($MBR_IDX));
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else return array();
    }
    
    // 마이페이지 1:1 문의
    public function myinquirylist($memidx)
    {
        $sql = "SELECT * FROM TB_UA_QNA WHERE MBR_IDX='$memidx'";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 )
        {
            //return $qry->result_array();
            $inquiryArr = array();
            foreach($qry->result_array() as $info)
            {
                $goodsidx = $info['GOODS_IDX'];
                
                $subSql = "SELECT a.LAW_ADDR1, a.LAW_ADDR2, b.COMPLEX_NAME FROM TB_UM_GOODS as a, TB_CB_COMPLEX as b WHERE a.GOODS_IDX='$goodsidx' AND a.COMPLEX_IDX=b.COMPLEX_IDX";
                $subQry = $this->db->query($subSql);
                if( $subQry->num_rows() > 0 )
                {
                    $subInfo = $subQry->row_array();
                    
                    $LAW_ADDR1 = $subInfo['LAW_ADDR1'];
                    $LAW_ADDR2 = $subInfo['LAW_ADDR2'];
                    $COMPLEX_NAME = $subInfo['COMPLEX_NAME'];
                }
                else
                {
                    $LAW_ADDR1 = "";
                    $LAW_ADDR2 = "";
                    $COMPLEX_NAME = "";
                }
                
                $inquiryArr[] = array(
                    "QNA_IDX" => $info['QNA_IDX'],
                    "MBR_IDX" => $info['MBR_IDX'],
                    "BROKER_OFFICE_IDX" => $info['BROKER_OFFICE_IDX'],
                    "GOODS_IDX" => $info['GOODS_IDX'],
                    "QNA_CATEGORY" => $info['QNA_CATEGORY'],
                    "CONTENTS" => $info['CONTENTS'],
                    "ANSWER_YN" => $info['ANSWER_YN'],
                    "READ_YN" => $info['READ_YN'],
                    "ADD_POINT" => $info['ADD_POINT'],
                    "REG_DATE" => $info['REG_DATE'],
                    "LAW_ADDR1" => $LAW_ADDR1,
                    "LAW_ADDR2" => $LAW_ADDR2,
                    "COMPLEX_NAME" => $COMPLEX_NAME
                );
            }
            
            return $inquiryArr;
        }
        else {
            return array();
        }
    }
    
    // 1:1 문의 답글 목록
    public function myinquiry_reply($idx)
    {
        $sql = "SELECT * FROM TB_UA_QNA_ANSWER WHERE QNA_IDX='$idx' ORDER BY REG_DATE ASC";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 )
        {
            $inquiryInfo = array();
            foreach($qry->result_array() as $info)
            {
                $memidx = $info['REG_MBR_IDX'];
                
                $subSql = "SELECT tm.MBR_IDX, tm.MBR_NAME, tm.MBR_IMAGE_FULL_PATH, tb.OFFICE_NAME, tb.ADDR1 FROM TB_UB_MEMBER AS tm, TB_AB_BROKER_OFFICE AS tb WHERE tm.MBR_IDX='$memidx' AND tm.MBR_IDX=tb.BROKER_OFFICE_IDX";
                $subQry = $this->db->query($subSql);
                if( $subQry->num_rows() > 0 )
                {
                    $memInfo = $subQry->row_array();
                    
                    $MBR_NAME = $memInfo['MBR_NAME'];
                    $MBR_PHOTO = $memInfo['MBR_IMAGE_FULL_PATH'];
                    $OFFICE_NAME = $memInfo['OFFICE_NAME'];
                    $ADDR1 = $memInfo['ADDR1'];
                }
                else
                {
                    $MBR_NAME = '';
                    $MBR_PHOTO = '';
                    $OFFICE_NAME = '';
                    $ADDR1 = '';
                }
                
                $inquiryInfo[] = array(
                    "QNA_IDX" => $info['QNA_IDX'],
                    "QNA_ANSWER_IDX" => $info['QNA_ANSWER_IDX'],
                    "CONTENTS" => $info['CONTENTS'],
                    "REG_MBR_IDX" => $info['REG_MBR_IDX'],
                    "REG_DATE" => $info['REG_DATE'],
                    "MBR_NAME" => $MBR_NAME,
                    "MBR_PHOTO" => $MBR_PHOTO,
                    "OFFICE_NAME" => $OFFICE_NAME,
                    "ADDR1" => $ADDR1
                );
            }
            
            return $inquiryInfo;
        }
        else
        {
            return array();
        }
    }
    
    // 내 1:1문의 답댓글 쓰기
    public function myinquiry_replycomment_process($INPUTDATA)
    {
        $idx = $INPUTDATA['idx'];
        $comments = $INPUTDATA['comments'];
        $memidx = $INPUTDATA['memidx'];
        
        $data = array('QNA_IDX'=>$idx, 'CONTENTS'=>$comments, 'REG_MBR_IDX'=>$memidx);
        $res = $this->db->insert('TB_UA_QNA_ANSWER', $data);
        if($res) return true;
        else return false;
    }
    
    // 회원상태
    public function isMember($user_id, $user_pwd, $is_login = true)
    {
        $res = $this->db
        ->select("mem.*, code.CODE_NAME as MBR_GUBUN_TXT, code2.CODE_NAME as MBR_STATUS_TXT")
        ->from("TB_UB_MEMBER mem")
        ->join("TB_CB_CODE code", "mem.MBR_GUBUN = code.CODE_DETAIL")
        ->join("TB_CB_CODE code2", "mem.MBR_STATUS = code2.CODE_DETAIL")
        ->where ('mem.MBR_ID', $user_id)
        ->get()->row_array();
        
        if( is_null($res) ) {
            return array("code"=>"NOT EXIST", "msg"=>"회원아이디로 정보를 찾을 수 없습니다.");
        }
        else if( $is_login && in_array($res['MBR_STATUS'], array('SE', 'FS')) ) {
            $this->addLoginHistory($res['MBR_IDX']);
            return array("code"=>"NOT EXIST", "msg"=>"회원아이디로 정보를 찾을 수 없습니다.");
        }
        else if( !password_verify($user_pwd , $res['MBR_PW']) ) {
            $this->addLoginHistory($res['MBR_IDX']);
            return array("code"=>"PASSWORD FAIL","msg"=>"패스워드가 틀립니다.");
        }
        else if ( $is_login &&  $res['MBR_STATUS']=='DO' ) {
            $this->addLoginHistory($res['MBR_IDX']);
            return array("code"=>"DORMANCY", "msg"=>"휴면계정입니다.");
        }
        else if($res['MBR_ID'] = $user_id) {
            return array("code"=>"SUCCESS", "data"=>$res);
        }
        else {
            return array("code"=>"ERROR", "msg"=>"알 수 없는 오류가 발생하였습니다.");
        }
    }
    
    //--------------------------------------------------------------//
    
    // 마이페이지 비밀번호 변경
    function passwordchangeprocess($PWDINFO)
    {
        $userid = $PWDINFO['userid'];
        $now_password = $PWDINFO['nowpwd'];
        $new_password = $PWDINFO['newpwd'];
        
        // 현재 비밀번호 체크
        $res = $this->db->query( "select * from TB_UB_MEMBER where MBR_ID = ?", array($userid))->row_array();
        if( is_null($res) ) {
            return "NOEXIST";
        }
        else if( in_array($res['MBR_STATUS'], array('SE', 'FS')) ) {
            return "OUTMEMBER";
        }
        else if( !password_verify($now_password , $res['MBR_PW']) ) {
            return "PWDFAIL";
        }
        else
        {
            $change = $this->updatePassword($userid, $new_password, "useraction");
            if( $change > 0 ) {
                $this->changeSession($userid);
                return "COMPLETE";
            }
            else {
                return "ERROR";
            }
        }
    }
    
    // 비밀번호 업데이트
    function updatePassword($userid, $pwd, $findtype)
    {
        if($userid =='') {
            return false;
        }
        
        $this->load->model('member_model');
        $pwd = $this->member_model->makePassword($pwd);
        
        $this->db->set('MBR_PW', $pwd);
        if( $findtype == 'dormancy') {
            $this->db->set('MBR_STATUS', 'NM');
        }
        $this->db->where('MBR_ID', $userid)->update('TB_UB_MEMBER');
        return $this->db->affected_rows();
    }
    
    //--------------------------------------------------------------//
    
    // 마이페이지 휴대폰번호 변경
    function cellphonechangeprocess($DATAINFO)
    {
        $userid = $DATAINFO['userid'];
        $cellphone = $DATAINFO['cellphone'];
        
        // 현재 휴대폰번호 체크
        $res = $this->db->query( "select * from TB_UB_MEMBER where MBR_ID = ?", array($userid))->row_array();
        if( is_null($res) ) {
            return "FAIL";
        }
        else if( in_array($res['MBR_STATUS'], array('SE', 'FS')) ) {
            return "FAIL";
        }
        else
        {
            $this->db->set('MBR_CP', $cellphone);
            $change = $this->db->where('MBR_ID', $userid)->update('TB_UB_MEMBER');
            if( $change ) {
                $this->changeSession($userid);
                return "SUCCESS";
            }
            else {
                return "ERROR";
            }
        }
    }
    
    //--------------------------------------------------------------//
    
    // 정보 업데이트 후 세션 정보 변경
    public function changeSession($user_id)
    {
        $res = $this->db
        ->select("mem.*, code.CODE_NAME as MBR_GUBUN_TXT, code2.CODE_NAME as MBR_STATUS_TXT")
        ->from("TB_UB_MEMBER mem")
        ->join("TB_CB_CODE code", "mem.MBR_GUBUN = code.CODE_DETAIL")
        ->join("TB_CB_CODE code2", "mem.MBR_STATUS = code2.CODE_DETAIL")
        ->where ('mem.MBR_ID', $user_id)
        ->get()->row_array();
        
        // 로그인 성공시 세션등록
        $this->session->set_userdata( array("userinfo"=>$res) );
        
        return true;
    }
        
    // 중복 로그인 로그아웃, 로그인 로그
    public function addLoginHistory($MBR_IDX, $isLoged=false)
    {
        $this->load->library('user_agent');
        $lastsession = $this->db->select('SESSION_ID')->where('MBR_IDX', (int)$MBR_IDX )->get('TB_UB_MEMBER_LOGIN_LAST_DATETIME')->row_array();
        
        if(isset($lastsession['SESSION_ID']) && $lastsession['SESSION_ID']!=''  && $isLoged) {
            $this->db->where('id',$lastsession['SESSION_ID'])->delete('TB_CB_SESSION');
        }
        
        // 앱정보 저장
        $this->load->helper('cookie');
        $PUSHKEY = get_cookie('PUSHKEY');
        //$UDID = get_cookie('UDID');
        $DEVICE = get_cookie('DEVICE');
        
        if($PUSHKEY != '' && $DEVICE != '')
        {
            $osinfo = strtoupper($DEVICE);
            $this->db->insert( 'TB_UB_MEMBER_LOGIN_LOG', array('MBR_IDX'=>(int)$MBR_IDX, 'LOGIN_IP'=>$this->input->ip_address(), 'LOGIN_SUCCESS_YN'=>($isLoged ? 'Y' : 'N'), 'OS_INFO'=>$osinfo, 'DEVICE_KEY'=>$PUSHKEY) );
            if($isLoged) {
                $sql = "insert into TB_UB_MEMBER_LOGIN_LAST_DATETIME (MBR_IDX, LAST_LOGIN_DATETIME, SESSION_ID, OS_INFO, DEVICE_KEY) VALUES (?, now(), ?, ?, ?) ON DUPLICATE KEY UPDATE LAST_LOGIN_DATETIME = NOW(), SESSION_ID = ?, OS_INFO = ?, DEVICE_KEY = ?";
                $this->db->query($sql, array($MBR_IDX, $this->session->session_id, $osinfo, $PUSHKEY, $this->session->session_id, $osinfo, $PUSHKEY));
            }
        }
        else
        {
            $this->db->insert('TB_UB_MEMBER_LOGIN_LOG', array('MBR_IDX'=>(int)$MBR_IDX, 'LOGIN_IP'=>$this->input->ip_address(), 'LOGIN_SUCCESS_YN'=> ($isLoged ? 'Y' : 'N')) );
            if($isLoged) {
                $sql = "insert into TB_UB_MEMBER_LOGIN_LAST_DATETIME (MBR_IDX, LAST_LOGIN_DATETIME, SESSION_ID ) VALUES (? , now(), ? ) ON DUPLICATE KEY UPDATE LAST_LOGIN_DATETIME = NOW(), SESSION_ID = ?";
                $this->db->query($sql, array($MBR_IDX, $this->session->session_id, $this->session->session_id ));
            }
        }
    }
    
    //--------------------------------------------------------------//
    
    // 내 매물
    public function getMySellGoods($MBR_IDX)
    {
        $sql = "
                SELECT
                 	goods.GOODS_IDX,goods.CATEGORY, goods.TRADE_TYPE, goods.PRICE1, goods.PRICE2, goods.PRICE3, 
                 	goods.AREA1, goods.AREA2, goods.DONG, goods.FLOOR_KIND, goods.FLOOR, goods.TOTAL_FLOOR, 
                	goods.ROOM_CNT, goods.BATHROOM_CNT , goods.ANIMAL, goods.PARKING_FLAG, 
                	goods.GOODS_STATUS, goods.GOODS_PROCESS_STATUS, goods.ROOM_TYPE, goods.DEFAULT_IMG_PATH, 
                    IFNULL(
                        IFNULL(
                  		    (SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = goods.GOODS_IDX and DISPLAY_FLAG='Y' order by FILE_SEPARATE, SORT_ORDER limit 1),
                  		    cpx.DEFAULT_IMG
                  	    ),
                        ( SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX=goods.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1 ) ) AS DEFAULT_IMG_PATH,
                    if( goods.TRADE_DATE IS NOT NULL , DATE_FORMAT( goods.TRADE_DATE, '%Y.%m.%d') , '') AS TRADE_DATE,
                    goods.DELETED_DATE, 
            	    cpx.COMPLEX_NAME, ifnull(cd.CODE_NAME,'') AS room_type_txt,
            	    IFNULL( cntrt.BROKER_OFFICE_IDX , brk_goods.BROKER_OFFICE_IDX) AS BROKER_OFFICE_IDX, 
                    if(fav.GOODS_IDX IS NULL ,'N', 'Y') isfav,
           	        if(eva.EVALUATION_IDX IS NULL , 'N', 'Y') iseval
                FROM TB_UM_GOODS goods
                LEFT JOIN TB_CB_COMPLEX cpx ON goods.COMPLEX_IDX = cpx.COMPLEX_IDX AND goods.CATEGORY = cpx.COMPLEX_TYPE
                LEFT JOIN TB_CB_CODE cd ON cd.CODE_GBN='ROOM_TYPE' and goods.ROOM_TYPE = cd.CODE_DETAIL AND cd.CODE_TYPE='A'
                LEFT JOIN TB_AB_CONTRACT cntrt ON goods.GOODS_IDX = cntrt.GOODS_IDX AND cntrt.CONTRACT_STATUS = 'CA'
                LEFT JOIN TB_HA_CS_BROKER_GOODS brk_goods ON goods.GOODS_IDX = brk_goods.GOODS_IDX
                LEFT JOIN TB_UM_MY_GOODS fav ON  goods.REG_MBR_IDX= fav.MBR_IDX and goods.GOODS_IDX = fav.GOODS_IDX
                LEFT JOIN TB_UA_BROKER_EVALUATION eva ON goods.GOODS_IDX = eva.GOODS_IDX AND goods.REG_MBR_IDX = eva.MBR_IDX AND eva.EVAL_TYPE = 'sell'
                WHERE goods.REG_MBR_IDX = ?
                order by goods.GOODS_IDX DESC
        ";
        $qry = $this->db->query( $sql, array($MBR_IDX) );
        if($qry->num_rows() > 0 ) {
            return $qry->result_array();
        }
        else {
            return array();
        }
    }
    
    //--------------------------------------------------------------//
    
    // 회원탈퇴처리
    function widthdrawresult($memidx)
    {
        $qry = $this->db->set('MBR_STATUS','SE')->set('SECESSION_DATE' ,'now()' ,false)->where ('MBR_IDX', $memidx)->update('TB_UB_MEMBER');
        if( $this->db->affected_rows() > 0 ) echo "SUCCESS";
        else echo "FAIL";
    }
}