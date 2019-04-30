<?php
class Member_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    
    // 회원가입 아이디 체크 (이메일)
    function joininfocheck($user_id)
    {
        $sql = "SELECT * FROM TB_UB_MEMBER WHERE MBR_ID='$user_id' OR MBR_EMAIL='$user_id'";
        $qry = $this->db->query($sql);
        if( $qry->num_rows() > 0 ) {
            return "Y";
        }
        else {
            return "N";
        }
    }
    
    // 회원가입 처리
    function joinprocess($JOINDATA)
    {
        $user_name = urldecode($JOINDATA['user_name']);
        $user_id = $JOINDATA['user_id'];
        $password = $JOINDATA['password'];
        
        $this->load->helper('cookie');
        $idx = get_cookie('certIDX');
        $sql = "SELECT * FROM TB_HISTORY_NICE WHERE idx='$idx'";
        $qry = $this->db->query($sql);
        $getCookies = $qry->row_array();
        
        $MOBILE_NO = $getCookies['MOBILE_NO'];
        $MBR_CP_FLAG = 'Y';
        $USERNAME = $getCookies['UTF8_NAME'];
        $MBR_BIRTH = $getCookies['BIRTHDATE'];
        $MBR_GENDER = $getCookies['GENDER'];
        $MBR_CP_CERTIFICATED_DATE = date('Y-m-d H:i:s');
        
        $pwd = $this->makePassword($password);
        
        $meminfo = array('MBR_NAME'=>$USERNAME, 'MBR_ID'=>$user_id, 'MBR_EMAIL'=>$user_id, 'MBR_PW'=>$pwd, 'MBR_CP'=>$MOBILE_NO, 'MBR_CP_FLAG'=>$MBR_CP_FLAG, 'MBR_CP_CERTIFICATED_DATE'=>$MBR_CP_CERTIFICATED_DATE, 'MBR_BIRTH'=>$MBR_BIRTH, 'MBR_GENDER'=>$MBR_GENDER);

        $this->db->trans_begin();
        $this->db->insert('TB_UB_MEMBER', $meminfo);
        $MBR_IDX = $this->db->insert_id();
        $this->db->set('MBR_IDX', $MBR_IDX)->where('idx', $idx)->update('TB_HISTORY_NICE');
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "FAIL";
        }
        else {
            $this->db->trans_commit();
            //$this->load->library('sendsms', array("private_info"=>$MOBILE_NO));
            //$this->sendsms->send("join");
            return "COMPLETE";
        }
    }
    
    //--------------------------------------------------------------//
    
    // 비밀번호 찾기 이메일 발송
    public function sendemailprocess($MAILDATA)
    {
        $email = $MAILDATA['email'];
        $sendType = $MAILDATA['sendType'];
        
        $info = $this->db->select('MBR_IDX, MBR_STATUS,MBR_GUBUN')->where('MBR_EMAIL', $email)->limit(1)->get_where('TB_UB_MEMBER')->row_array();
                  
        if( !isset($info['MBR_IDX']) ) return "NODATA";
        else if( in_array( $info['MBR_STATUS'], array('SE', 'FS') ) ) return "NODATA";
        else if( in_array( $info['MBR_GUBUN'], array('AA') ) ) return "NODATA";
        else
        {
            // 유효기간30분으로
            $this->load->library('encryption');
            $this->encryption->initialize(array('driver'=>'openssl'));
            $data = array("createdtime"=>time(), "email"=>$email, "expire"=>time()+1800, "findtype"=>$sendType);
            $token = urlencode($this->encryption->encrypt(json_encode($data)));

            // 이메일 발송 내용
            if($sendType == 'dormancy')
            {
                $title ="[다윈중개] 휴면계정 해제 안내 메일.";
                $msg = "<p><h3>안녕하세요. 다윈중개입니다.<h3></p>
                        <p></p>
                        <p>회원님이 요청하신 휴면계정 해제는 아래 URL을 통해 가능합니다.</p>
                        <p>아래 URL로 접속해서 새로운 비밀번호를 등록해 주시면 휴면계정이 해제됩니다.<p>
                        <p><a href='".$this->config->item('COMPANYINFO')['COMPANY_SITE']."member/setpasswd1?token=".$token."' target ='_blank'>[휴면계정 해제하러 가기]</a></p>
                        <p></p>
                        <p>감사합니다.</p>";
            }
            else
            {
                $title ="[다윈중개] 비밀번호 변경 안내 메일.";
                $msg = "<p><h3>안녕하세요. 다윈중개입니다.<h3></p>
                        <p></p>
                        <p>회원님이 요청하신 비밀번호 변경은 아래 URL을 통해 가능합니다.</p>
                        <p>아래 URL로 접속해서 새로운 비밀번호를 등록해 주세요.<p>
                        <p><a href='".$this->config->item('COMPANYINFO')['COMPANY_SITE']."member/setpasswd1?token=".$token."' target ='_blank'>[비밀번호 변경하러 가기]</a></p>
                        <p></p>
                        <p>감사합니다.</p>";
            }
            
            // 이메일 발송 처리
            $this->load->library('email');
            $config['protocol']     = 'smtp';
            $config['smtp_host']    = 'ssl://smtp.gmail.com';
            $config['smtp_port']    = '465';
            $config['smtp_timeout'] = '7';
            $config['smtp_user']    = $this->config->item('COMPANYINFO')['EMAIL_SUPPORT'];
            $config['smtp_pass']    = 'ekdnlstjvhxm';
            $config['charset']      = 'utf-8';
            $config['newline']      = "\r\n";
            $config['mailtype']     = 'html';
            $config['validation']   = TRUE; // bool whether to validate email or not
            
            $this->email->initialize($config);
            
            $this->email->from($this->config->item('COMPANYINFO')['EMAIL_SUPPORT'], $this->config->item('COMPANYINFO')['SITE_NAME']);
            $this->email->to($email);
            
            $this->email->subject($title);
            $this->email->message($msg);
            
            $this->email->send();
            return "COMPLETE";
        }
    }
    
    // 비밀번호 재등록 처리
    public function updatePassword($email, $pwd, $findtype)
    {
        if($email == '') return false;
        
        $pwd = $this->makePassword($pwd);
        $this->db->set('MBR_PW', $pwd);
        if($findtype == 'dormancy') {
            $this->db->set('MBR_STATUS', 'NM');
        }
        $this->db->where('MBR_EMAIL', $email)->update('TB_UB_MEMBER');
        
        return $this->db->affected_rows();
    }
    
    //--------------------------------------------------------------//
    
    // 비밀번호 해시 생성
    public function makePassword($password_string) {
        return password_hash($password_string, PASSWORD_BCRYPT, ["cost"=>11]);
    }
    
    //--------------------------------------------------------------//
    
    // 로그인 처리 함수
    function userloginprocess($USERINFO)
    {
        $user_id = $USERINFO['user_id'];
        $password = $USERINFO['password'];
        $autologin = $USERINFO['autologin'];
        if(empty($autologin)) $autologin = 'N';
        
        $this->load->model('mypage_model');
        $res = $this->mypage_model->isMember($user_id, $password);
        
        if($res['code'] == "SUCCESS")
        {
            // 휴대폰번호 존재여부 체크
            /*if($res['data']['MBR_CP'] =='') // 없는 경우
            {
                $this->input->set_cookie('atdl','',0 );
                //$this->session->set_userdata( array("nullCPIDX"=>$res['data']['MBR_IDX']) );
                $this->input->set_cookie('nullCPIDX',$res['data']['MBR_IDX'],0 );
                $res['code'] = "NOMBRCP";
            }
            else
            {*/
                // 로그인 성공시 세션등록
                $this->session->set_userdata( array("userinfo"=>$res['data']) );
                
                // 자동로그인 체크
                if($autologin == 'Y')
                {
                    $this->load->library('encryption');
                    $this->encryption->initialize(array('driver' => 'openssl'));
                    $ciphertext = $this->encryption->encrypt($user_id."|@|123123123|@|".$password);
                    $this->input->set_cookie('atl',$ciphertext, 86400*90 );
                }
                else {
                    $this->input->set_cookie('atl','',0 );
                }
                
                $this->mypage_model->addLoginHistory($res['data']['MBR_IDX'], true);
            //}
        }
        
        return $res['code'];
    }
    
    //--------------------------------------------------------------//
    
    public function deleteBrokerTemp($data)
    {
        if( $data['bizCert'] > 0 ) $this->db->where('IMG_IDX' ,$data['bizCert'] )->delete('TB_TMP_FOR_JOIN_IMAGE');
        if( $data['regCert'] > 0 ) $this->db->where('IMG_IDX' ,$data['bizCert'] )->delete('TB_TMP_FOR_JOIN_IMAGE');
        if( $data['prfImg'] > 0 ) $this->db->where('IMG_IDX' ,$data['bizCert'] )->delete('TB_TMP_FOR_JOIN_IMAGE');
        $this->db->where("COOK", $data['COOK'] )->delete('TB_TMP_REALTOR_JOIN');
        $this->load->helper('cookie');
        $cook = delete_cookie('skdicysw1b5dtrt');
    }
    
    public function makeBrokerId($data)
    {
        $date = new DateTime("now", new DateTimeZone('Asia/Seoul') );
        
        $qry = $this->db->where('BROKER_OFFICE_INFO_IDX', $data['BROKER_OFFICE_INFO_IDX'])->get('TB_AB_BROKER_OFFICE_INFO');
        if($qry->num_rows() < 1) return false;
        else $officeinfo = $qry->row_array();
        
        // 기존 가입자 휴대폰번호 초기화
        if(strpos($_SERVER["HTTP_HOST"], 'test') === false) {
            $this->db->set('MBR_CP', '')->where('MBR_CP', $data['MOBILE_NO'])->update('TB_UB_MEMBER');
        }
        
        //TB_UB_MEMBER
        $member = array(
            "MBR_NAME"=>$data['UTF8_NAME'],
            "MBR_ID"=>$data['email'],
            "MBR_EMAIL"=>$data['email'],
            "MBR_PW"=>$data['passwd'],
            "MBR_CP"=>$data['MOBILE_NO'],
            "MBR_CP_FLAG"=>'Y',
            "MBR_CP_CERTIFICATED_DATE"=>$data['CERTIFICATED_DATE'],
            "MBR_BIRTH"=>$data['BIRTHDATE'],
            "MBR_GENDER"=>$data['GENDER'],
            "MBR_GUBUN"=>'BU',
            "MBR_IMAGE_FULL_PATH"=>$data['prfFullPath'],
            "MBR_STATUS"=>'NM'
        );
        
        $this->db->insert("TB_UB_MEMBER", $member);
        $idx = $this->db->insert_id();
        
        //TB_AB_BROKER_OFFICE
        $office = array(
            "BROKER_OFFICE_IDX"=>$idx,
            "INFO_BROKER_OFFICE_CODE"=>$officeinfo['BROKER_OFFICE_CODE'],
            "OFFICE_NAME"=>$data['BROKER_OFFICE_NAME'],
            "BIZ_GBN"=>($data['isCompany']=='P' ? "PER":"COP"),
            "BIZ_LICENSE_IMG"=>$data['bizFullPath'],
            "ADDR1"=>$data['FULL_ADDR'],
            "ADDR_TYPE"=>'1',
            "PHONE"=>$data['PHONE'],
            "LAW_DONG_CODE"=>$data['DONG_CODE'],
            "LAT"=>$data['LAT'],
            "LNG"=>$data['LNG'],
            "OFFICE_TITLE"=>$data['BROKER_OFFICE_NAME'],
            "BROKER_REG_LICENSE_IMG"=>$data['regFullPath'],
            "CAREER"=>$data['career'],
            "OFFICE_STATUS"=>'1',
            "APPROVAL_STATUS"=>'PS1',
            "WORKING_STATUS"=>"WO",
            "MEMBER_LEVEL"=>"FR",
            "BROKER_POINT"=>0,
            "BROKER_POINT_CNT"=>0,
            "ST_FROM_DATE"=>'',
            "ST_TO_DATE"=>'',
            "JOIN_DATE"=>$date->format('Y-m-d H:i:s')
        );
        $this->db->insert("TB_AB_BROKER_OFFICE", $office);
        //TB_HA_DW_BROKER_RATE_INFO
        $rate = array("BROKER_OFFICE_IDX"=>$idx);
        $this->db->insert("TB_HA_DW_BROKER_RATE_INFO", $rate);
        //TB_TMP_REALTOR_JOINED
        $joined = array(
            "MBR_IDX"=>$idx, "BROKER_OFFICE_INFO_IDX"=>$data['BROKER_OFFICE_INFO_IDX'], "niceHistoryIdx"=>$data['niceHistoryIdx']
        );
        $this->db->insert("TB_TMP_REALTOR_JOINED", $joined);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            $res = $this->db
            ->select("mem.*, code.CODE_NAME as MBR_GUBUN_TXT, code2.CODE_NAME as MBR_STATUS_TXT")
            ->from("TB_UB_MEMBER mem")
            ->join("TB_CB_CODE code", "mem.MBR_GUBUN = code.CODE_DETAIL")
            ->join("TB_CB_CODE code2", "mem.MBR_STATUS = code2.CODE_DETAIL")
            ->where ('mem.MBR_IDX', $idx)
            ->get()->row_array();
            session_start();
            $this->session->set_userdata( array("usesrinfo"=>$res) );
            return true;
        }
    }
    
    //--------------------------------------------------------------//
    
    // 매물사진수정 등록,삭제
    function getGoodsImg($goods_idx)
    {
        $qry = $this->db->order_by('FILE_SEPARATE ASC, SORT_ORDER ASC')->get_where('TB_UM_GOODS_IMG', array('GOODS_IDX'=>$goods_idx, 'DISPLAY_FLAG'=>'Y'));
        if($qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    // 매물사진등록,삭제
    function getSalepicture($MBR_IDX, $category, $inout='')
    {
        $this->db->select('*')->where('MBR_IDX', (int)$MBR_IDX)->where('CATEGORY', $category);
        if( $inout != '' ) $this->db->where('INOUT', $inout);
        $qry = $this->db->order_by('IMG_IDX')->get('TB_TMP_FOR_SALE_IMAGE');
        if( $qry->num_rows() > 0) return $qry->result_array();
        else return array();
    }
    
    function delSalepicture($MBR_IDX, $category)
    {
        $qry = $this->db->query("select filename from TB_TMP_FOR_SALE_IMAGE where MBR_IDX = ? and CATEGORY = ? ", array($this->userinfo['MBR_IDX'], $category ) );
        if($qry->num_rows() < 1) {
            return true;
        }
        else {
            $rows = $qry->result_array();
            foreach($rows as $row ) @unlink("./tempfile/".$row['filename']);
            return $this->db->where ('MBR_IDX',$this->userinfo['MBR_IDX'])->where('CATEGORY', $category)->delete('TB_TMP_FOR_SALE_IMAGE');
        }
    }
    
    //--------------------------------------------------------------//
    
    //좋아요 추가
    public function setFavorite($MBR_IDX, $goods_idx, $on=true)
    {
        if($on) {
            $sql ="delete from TB_UM_MY_GOODS PARTITION(p". ($MBR_IDX % 5) .") where MBR_IDX = ? and GOODS_IDX = ?";
            $res = $this->db->query( $sql, array($MBR_IDX, $goods_idx) );
        }
        else {
            $data = array('MBR_IDX'=>$MBR_IDX, 'GOODS_IDX'=>$goods_idx );
            $res = $this->db->insert('TB_UM_MY_GOODS', $data);
        }
        
        return $res;
    }
    
    //좋아요 리스트
    public function getFavlrite($MBR_IDX)
    {
        $sql = "select GOODS_IDX from TB_UM_MY_GOODS PARTITION(p". ($MBR_IDX % 5) .") where MBR_IDX = ".(int)$MBR_IDX;
        $qry = $this->db->query($sql);
        
        if($qry->num_rows() > 0) {
            return $qry->row_array();
        }
        else return array();
    }
    
    public function getFavorite($MBR_IDX)
    {
        $sql = "SELECT
                	gd.*, cpx.COMPLEX_NAME , date_format( gd.TRADE_DATE, '%Y-%m-%d') as TRADE_DATE_FORMAT
                  ,IFNULL(
              		 (SELECT concat(SERVER_PATH, FULL_PATH) FROM TB_UM_GOODS_IMG WHERE GOODS_IDX = gd.GOODS_IDX and DISPLAY_FLAG='Y' ORDER BY SORT_ORDER LIMIT 1)
              		 , if ( gd.CATEGORY = 'ONE' , null
              		 		, ( SELECT IMAGE_FULL_PATH FROM TB_CB_COMPLEX_IMG where COMPLEX_IDX=gd.COMPLEX_IDX ORDER BY SORT_ORDER LIMIT 1 )
              		 		)
              		) AS imgsrc
                FROM TB_UM_MY_GOODS PARTITION(p". ($MBR_IDX % 5) .") mygd
                JOIN TB_UM_GOODS gd ON mygd.GOODS_IDX = gd.GOODS_IDX
                LEFT JOIN TB_CB_COMPLEX cpx ON gd.COMPLEX_IDX = cpx.COMPLEX_IDX AND gd.CATEGORY = cpx.COMPLEX_TYPE
                WHERE mygd.MBR_IDX = ? and gd.GOODS_STATUS != 'TR'
                ORDER BY mygd.REG_DATE desc";
        $qry = $this->db->query($sql, array($MBR_IDX));
        if($qry->num_rows() > 0) {
            return $qry->result_array();
        }
        else return array();
    }
    
    //--------------------------------------------------------------//
    
    //추가 20190425 임성택
    public function getQnaList($MBR_IDX, $page =0, $perpage=2)
    {
        $sql = "
      SELECT *, date_format( regdate , '%Y-%m-%d') as regdate_format from
      (
        SELECT
          QNA_IDX idx, gd.GOODS_NO,qna.GOODS_IDX, gd.GOODS_STATUS, gd.GOODS_PROCESS_STATUS ,'UA' tbname,qna.QNA_CATEGORY,  qna.`CONTENTS` title,'' cont, qna.ANSWER_YN ans, qna.REG_DATE AS regdate
          ,cpx.COMPLEX_NAME, gd.CATEGORY,  if( cpx.TB_CB_COMPLEX_IDX IS NULL, gd.LAW_ADDR1 ,  concat(cpx.LAW_ADDRESS, ' ', cpx.LAW_ADDRESS_DETAIL) ) addr
          , IFNULL( (SELECT REG_DATE from TB_UA_QNA_ANSWER ans where ans.QNA_IDX =qna.QNA_IDX ORDER BY REG_DATE DESC LIMIT 1 ), qna.REG_DATE) AS lastdate
        FROM TB_UA_QNA qna
        JOIN TB_UM_GOODS gd ON qna.GOODS_IDX = gd.GOODS_IDX
        LEFT JOIN TB_CB_COMPLEX cpx ON gd.COMPLEX_IDX = cpx.COMPLEX_IDX and gd.CATEGORY = cpx.COMPLEX_TYPE
        WHERE qna.MBR_IDX = ?
      UNION
        SELECT qna2.QNA_IDX idx,'' GOODS_NO,'' as GOODS_IDX , '' GOODS_STATUS, '' GOODS_PROCESS_STATUS ,'UH_DW' tbname,cd.CODE_NAME as QNA_CATEGORY,  qna2.QNA_TITLE title, qna2.QNA_CONTENTS cont, qna2.ANSWER_YN ans, qna2.REG_DATE regdate
        , '' COMPLEX_NAME, '' CATEGORY, '' addr
        ,IFNULL( (SELECT REG_DATE from TB_UH_DW_QNA_ANSWER ans where ans.QNA_IDX = qna2.QNA_IDX ORDER BY REG_DATE DESC LIMIT 1), qna2.REG_DATE) AS lastdate
        FROM TB_UH_DW_QNA qna2
        JOIN TB_CB_CODE cd ON cd.CODE_GBN='FAQ_QUESTION_GUBUN' and qna2.QNA_CATEGORY = cd.CODE_DETAIL
        WHERE qna2.MBR_IDX = ?
      )untb
      Order BY lastdate DESC
      LIMIT ? , ?
      ";
        $qry = $this->db->query($sql, array((int)$MBR_IDX, (int)$MBR_IDX, (int)$page*(int)$perpage, (int)$perpage+1) );
        if($qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    function getQnaAns($data)
    {
        $sql = " SELECT a.*, if( a.REG_MBR_IDX = ? , 'N', 'Y') AS is_ans, DATE_FORMAT( a.REG_DATE, '%Y.%m.%d') AS regdate_format ";
        if($data['TB'] == 'UA') $sql .= " , b.MBR_NAME, b.MBR_IMAGE_FULL_PATH AS img, c.OFFICE_NAME ";
        $sql .="
            FROM TB_".$data['TB']."_QNA chk
            JOIN TB_".$data['TB']."_QNA_ANSWER a ON chk.QNA_IDX = a.QNA_IDX
        ";
        
        if($data['TB'] == 'UA')
        {
            $sql .= "
                JOIN TB_UB_MEMBER b ON a.REG_MBR_IDX = b.MBR_IDX
                LEFT JOIN TB_AB_BROKER_OFFICE c ON a.REG_MBR_IDX = c.BROKER_OFFICE_IDX
                WHERE chk.QNA_IDX = ? AND (chk.MBR_IDX = ? OR chk.BROKER_OFFICE_IDX = ".(int)$data['MBR_IDX'].")
            ";
        }
        else {
            $sql .= " WHERE chk.QNA_IDX = ? AND chk.MBR_IDX = ? ";
        }
        $sql .= " ORDER BY a.QNA_ANSWER_IDX ";
        $qry = $this->db->query($sql, array((int)$data['MBR_IDX'], (int)$data['QNA_IDX'] , (int)$data['MBR_IDX'] ) );
        
        if($qry->num_rows() > 0 ) return $qry->result_array();
        else return array();
    }
    
    // 댓글 작성 가능여부
    function checkauthQna($MBR_IDX, $qna_idx, $tb)
    {
        if($tb == 'UA')
        {
            $sql = "
                SELECT ifnull(count(1),0) as chk
                FROM TB_" . $tb . "_QNA chk
                where chk.QNA_IDX = ".(int)$qna_idx." AND (  chk.MBR_IDX = ".(int)$MBR_IDX." OR chk.BROKER_OFFICE_IDX = ".(int)$MBR_IDX." )
            ";
        }
        else if($tb == 'UH_DW')
        {
            $sql = "
                SELECT ifnull(count(1),0) as chk
                FROM TB_".$tb."_QNA chk
                where chk.QNA_IDX = ".(int)$qna_idx." AND (  chk.MBR_IDX = ".(int)$MBR_IDX." )
            ";
        }
        else return false;
        $res = $this->db->query($sql)->row_array();
        return $res['chk'];
    }
    
    function setQnaMore( $data, $tb)
    {
        $this->db->insert( "TB_" . $tb . "_QNA_ANSWER" , $data );
        return $this->db->affected_rows();
    }
    //추가완료 20190425 임성택
}