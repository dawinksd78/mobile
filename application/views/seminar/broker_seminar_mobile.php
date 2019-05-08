<!DOCTYPE Html>
<html lang="Ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>다윈중개 모바일</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<meta name="format-detection" content="telephone=no, address=no, email=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" href="/css/m_seminar.css" type="text/css"/>  
<link rel="stylesheet" href="/css/m_all.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/earlyaccess/notosanskr.css">
<link rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css">
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
</head>

<body>
<div id="semWrap" class="">
    <div class="sem_contwrap">
        <h1 class="logo"><a href="/">dawin</a></h1>
        <div class="box_infotemp">
          	<h2 class="tit"><b>설명회</b> 참석신청</h2>
          	<h4 class="sub_tit">설명회 신청을 위해 2가지 항목을 입력해주세요.</h4>
    	  	<form class="sem_inp" id="frmseminar" name="frmseminar" onsubmit="return false;">
      		<input type='hidden' id="gubun" name="gubun" value="<?=$gubun?>">
            <input type="text" id="bname" name="bname" placeholder="이름을 입력해주세요." name="" class="inp" autocomplete="off"> 
            <input type="number" id="phone" name="phone" placeholder="휴대폰번호를 입력해주세요.(- 제외)" name="" class="inp mgt" autocomplete="off">
    		<div class="check_box">
    			<div class="check">
    				<label for="agree3">
    					<input type="checkbox" name="agree" id="agree3" value="" checked>
    					<i></i>
    					<strong>개인정보수집동의</strong>
    					<button class="btn_view_detail" onmousedown="javascript:btn_view_detail();">자세히보기</button>
    				</label>
    			</div>
            </div> 
            <button type="submit" id="goseminar" name="goseminar" class="btn_type01 btn_color01 btn_apply">설명회 신청하기</button>
    		</form>
        </div>
  	</div>   
</div>
</body>
</html>


<script>
$(function(){
	$("#goseminar").on("mousedown",function(){
		var bdatacheck = seminardatacheck();
		if(!bdatacheck) {
			return false; 
		}

		$("#frmseminar").attr("action","/brokersseminar/saveresult_mobile");
		$("#frmseminar").attr("method","POST");
		$("#frmseminar").attr("onsubmit","");
		$("#frmseminar").submit();
	});

	$(".close").click(function(){
		popclose();
	});

	$("#bname").keyup(function(e) {
		if(e.keyCode == 13) { // enter key maps to keycode `13`
			$("#phone").focus();;
			return false; 
		}
	});   

	$(document).keyup(function(e) {
		if(e.keyCode == 27) { // escape key maps to keycode `27`
			popclose();
		}
	});
});


//개인정보수집동의 자세히 보기 
function btn_view_detail()
{
	$(".mask").show();
	$(".lyrpop01").show();
	return false; 
}

function seminardatacheck()
{
	var bchk = false; 

	if($("#bname").val().replace(/\s/g,"").length < 2)
	{
		alert("이름을 입력하여 주세요."); 
		$("#bname").focus().select();
		bchk = false; 
		return bchk;
	}

	var phone = $("#phone").val();
	var regex= /^\d{2,3}\d{3,4}\d{4}$/;

	if(!regex.test(phone))
	{		
		alert("전화번호를 확인해주세요."); 
		$("#phone").focus().select();
		bchk = false; 
		return bchk;
	}

	if($("#agree3").is(":checked")) {
		bchk = true; 			
	}
	else {
		alert("개인정보수집 동의를 해주세요."); 
		return bchk; 
	}

	return bchk; 
}

function popclose()
{
	$(".mask").hide();
	$(".lyrpop01").hide();
}
</script> 

<!--개인정보처리방침 팝업 -->
<div class="mask" style="display:none"></div>
	<!-- 중개평가완료 시 팝업 -->
	<div class="lyr lyrpop01" style="display:none">
		<div class="lyr_inner">
		   	<p><strong>1. 개인정보 수집 항목 (필수)</strong><br>성명, 전화번호</p><br>
			<p><strong>2. 이용목적</strong><br>다윈소프트 설명회 참석</p><br>
			<p><strong>3. 보유기간</strong><br>설명회 참석에 대한 이용 목적이 달성된 후에는 해당 정보를 지체없이 파기</p><br><br>								
			<p>※ 위의 개인정보 수집 및 이용동의에 거부할 수 있으며, 거부시 설명회 참석 예약이 제한됨을 알려드립니다.</p>	
		</div>
		<div class="btn">
			<button class="btn_type02" onmousedown="javascript:popclose()">확인</button>
		</div>
	</div>
</div>