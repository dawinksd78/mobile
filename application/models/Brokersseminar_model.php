<?php
class Brokersseminar_model extends CI_Model {

  public function __construct()
  {
     parent::__construct();
  }


  public function saveseminar($name,$phone,$gubun,$device){
   
	$savedata = array("BROKER_NAME"=>$name, "BROKER_CP"=>$phone, "GUBUN"=>$gubun, "DEVICE"=>$device);
	$this->db->insert("TB_UB_SEMINAR", $savedata);

  }
}