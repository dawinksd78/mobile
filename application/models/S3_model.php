<?php
require_once './vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class S3_model extends CI_Model
{
    private $connect, $bucket;
    public function __construct()
    {
        parent::__construct();
        $this->load->config('s3');
        $this->load->helper('string');
        $this->bucket =$this->config->item('s3_default_bucket');
        $connect_param = array('region' => 'ap-northeast-2', 'version' => 'latest', 'credentials' => array('key' => $this->config->item('access_key'), 'secret' => $this->config->item('secret_key')));
        $this->connect= new S3Client($connect_param);
    }
    
    function makePrefix( $config )
    {
        $prefix='';
        if( !is_array($config) ) $config= array( "type"=> $config);
        if ( isset ($config['type']) )
        {
            switch( $config['type'] ){
                case ("sale") :
                    $prefix .= "salegoods/".date('Ymd')."/";
                break;
            }
        }
    
        return $prefix;
    }
  
    public function upload($prefix, $srcFile, $ext='')
    {
        //$filekey = date('His').md5($srcFile).date('mYd').random_string('alnum',4);
        $filekey =$prefix.random_string('alnum',4).random_string('md5').date('HmsYid').( $ext!='' ? ".".$ext : "" ) ;
        $tmparr = explode(".", $srcFile);
        if( count($tmparr) > 1)
        {
            $ext = strtolower($tmparr[ (count($tmparr) - 1)]);
            if (!in_array($ext , array('jpg', 'jpeg', 'png', 'gif')) ) return array("code"=>"500", "msg"=>"업로드 가능한 확장자가 아닙니다.");
            $filekey= $filekey.".".$ext;
        }
        try {
            $result = $this->connect->putObject(Array(
                'ACL' => 'public-read',
                'SourceFile' => $srcFile,
                'Bucket' => $this->bucket,
                'Key' => $filekey
            ));
            return array( "code"=>"200","url"=>$result['ObjectURL'], "key"=>$filekey);
        } catch (S3Exception $e) {
            return array( "code"=>"500",'msg'=>$e->getMessage());
        }
    }
    
    public function uploadFromTmp($prefix, $srcFile, $exttype='')
    {
        $extArr = array("image/jpeg"=>'jpg', "image/gif"=>'gif', "image/png"=>'png');
        $ext = isset($extArr[$exttype]) ? $extArr[$exttype] : '';

        $filekey = $prefix.random_string('alnum',4).random_string('md5').date('HmsYid').( $ext!='' ? ".".$ext : "" ) ;

        try {
            $result = $this->connect->putObject(Array(
                'ACL' => 'public-read',
                'Body' => fopen($srcFile, 'r'),
                'ContentType' => $exttype,
                'Bucket' => $this->bucket,
                'Key' => $filekey
            ));
            return array("code"=>"200", "url"=>$result['ObjectURL'], "key"=>$filekey);
        }
        catch (S3Exception $e) {
            //return array( "code"=>500 ,'msg'=>$e->getMessage());
            return array("code"=>"500", 'msg'=>"CONNECTION ERROR");
        }
    }

    public function delimage( $data )
    {
        $toDelete_img_list = array();
        if( is_array($data) )
        {
            for($i = 0; $i < sizeof($data); $i++) {
                array_push($toDelete_img_list, array('Key' => $this->getkey($data[$i])));
            }
        }
        else array_push($toDelete_img_list, array('Key' => $this->getkey($data)));
        $objects = array('Objects' => $toDelete_img_list);
        try {
            $result = $this->connect->deleteObjects(Array(
                'Bucket' => $this->bucket,
                'Delete' => $objects
            ));
            return array("code"=>"200");
        }
        catch (S3Exception $e) {
            return array("code"=>"500", 'msg'=>$e->getMessage());
        }
    }

    function delSalepicture($MBR_IDX, $category)
    {
        $qry = $this->db->query("select FILEKEY from TB_TMP_FOR_SALE_IMAGE where MBR_IDX = ? and CATEGORY = ? ", array($this->userinfo['MBR_IDX'], $category ) );
        if($qry->num_rows() < 1 ) {
            return true;
        }
        else
        {
            $imgs = array();
            $rows = $qry->result_array();
            foreach( $rows as $row) $imgs[] = $row['FILEKEY'];
            $res = $this->delimage( $imgs );
            if($res['code'] == 200) {
                $this->db->where('MBR_IDX',$this->userinfo['MBR_IDX'])->where('CATEGORY', $category)->delete('TB_TMP_FOR_SALE_IMAGE');
                return $res;
            }
            else return $res;
        }
    }
    
    public function getkey($str)
    {
        $url = parse_url($str);
        if( isset($parsed_url['scheme']) ) return $parsed_url['path'];
        else return $str;
    }
}
