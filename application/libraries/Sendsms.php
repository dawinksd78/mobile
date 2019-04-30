<?php
class Sendsms
{
    protected $CI;
    protected $smsData;
    public function __construct($param=null)
    {
        $this->CI =& get_instance();
        $this->smsData =array(
            "member_type"=>"PV",
            "private_info"=>'', //hp
            "send_manager"=>"S",
            "send_rsv_date"=>"",
            "title"=>"",
            "link_url"=>"",
            "message"=>"",
            "token"=>''
        );
        $this->set($param);
    }
  
    public function to($mbr_idx)
    {
        $qry = $this->CI->db->get_where("TB_UB_MEMBER", array("MBR_IDX"=> $mbr_idx));
        if($qry->num_rows() > 0) {
            $row = $qry->row_array();
            $this->smsData['private_info'] = trim(str_replace("-","",$row['MBR_CP']));
        }
    }
    
    public function set($param) {
        if(is_array($param) && count($param)>0) $this->smsData = array_merge($this->smsData, $param);
    }
    
    public function send($type='')
    {
        $this->CI->load->library('encryption');
        $this->CI->encryption->initialize(array('driver'=>'openssl'));
        $this->smsData['token'] = urlencode($this->CI->encryption->encrypt(json_encode(array("createdtime"=>time(), "expire"=>time()+600))));
        $typemsg = $this->messagetype($type);

        if( $this->smsData['private_info'] == '' ) return array("result"=>false, "msg"=>"private_info");
        else if ( $typemsg =="" && $this->smsData['message'] == '' ) return array("result"=>false, "msg"=>"message");
        else
        {
            if( $this->smsData['message'] == '' ) $this->smsData['message'] =$typemsg;
            return $this->sendmessage();
        }
    }
    
    private function sendmessage()
    {
        $url = "http://api.dawin.xyz/sendsms";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->smsData);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT,5);
        $result = curl_exec($curl);
        curl_close($curl);

        if($result===false) {
            return array("result"=>false, "msg"=>"sending error");
        }
        
        $res = json_decode($result, true);
        if($res['code'] !='100') {
            return array("result"=>false, "msg"=>"result error", "data"=>$res);
        }
        else return array("result"=>true);
    }
    
    private function messagetype($type)
    {
        $msg = array(
            "join"=>"회원가입이 완료되었습니다.",
            "qna"=>"매물에 대한 새로운 문의가 등록되었습니다."
        );
        
        if(isset($msg[$type])) return $msg[$type];
        else return '';
    }
}
?>
