<?php 
//-----------------------------------------
// 안드로이드, IOS 기가ID 및 PUSHKEY 저장
// m.dawin.xyz/app/setpushkey.php?pushkey=앱키값&udid=기기UDID값&device=ios,and
//-----------------------------------------

function DbChk($pStr)
{
    $pStr = str_replace('--', '', $pStr);
    $pStr = str_replace('/*', '', $pStr);
    $pStr = str_replace('*/', '', $pStr);
    $pStr = preg_replace('/script/i', '', $pStr);
    $pStr = preg_replace('/\.js/i', '', $pStr);
    $pStr = preg_replace('/select/i', '', $pStr);
    $pStr = preg_replace('/insert/i', '', $pStr);
    $pStr = preg_replace('/update/i', '', $pStr);
    $pStr = preg_replace('/delete/i', '', $pStr);
    $pStr = preg_replace('/drop/i', '', $pStr);
    $pStr = preg_replace('/union/i', '', $pStr);
    $pStr = preg_replace('/varchar/i', '', $pStr);
    
    return $pStr;
}

$PUSHKEY    = DbChk(trim($_REQUEST['pushkey']));    // PUSHKEY
//$UDID       = DbChk(trim($_REQUEST['udid']));       // 기기UDID값
$DEVICE     = DbChk(trim($_REQUEST['device']));     // 전송될 값 => ios : IOS, and : ANDROID


### 전송값 쿠키 저장 (로그인시 혹은 가입시 디바이스 정보 저장) ###

$domain = ".m.dawin.xyz";
$expire = "0";
$path = "/";

// 1. pushkey 쿠키 생성
if($PUSHKEY != '') {
    setcookie("PUSHKEY", $PUSHKEY, $expire, $path, $domain);
}

// 2. 기기값 쿠키 생성
//if($UDID != '') {
//    setcookie("UDID", $UDID, $expire, $path, $domain);
//}

// 3 디바이스 종류 쿠키 생성
if($DEVICE != '') {
    setcookie("DEVICE", $DEVICE, $expire, $path, $domain);
}

echo "<meta http-equiv='refresh' content='0; url=/'>";
?>