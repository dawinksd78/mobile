<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">회원가입</h2>
    </header>
    
    <section id="container">
    <form id="join_form">
        <div class="sub_container">
            <div class="cont_wrap join_wrap">
                <h2 class="subj_tit"><span class="m_tit">개인정보입력</span></h2>
                <div class="proc"><a href="" class="bul_proc prev"></a><a href="" class="bul_proc on"></a></div>
                <div class="cont">
                    <div class="inpbox">
                      <label for="u_name" class="lbl">이름</label>
                      <input type="text" name="user_name" id="user_name" value="<?php echo $username; ?>" tabindex="1" placeholder="이름" title="이름" class="inp" autocomplete="off">
                    </div>
                    <div class="inpbox inpbn">
                        <label for="u_id" class="lbl">아이디</label>
                        <input type="text" name="user_id" id="user_id" value="<?php echo $idemail; ?>" tabindex="2" placeholder="아이디(이메일)" title="아이디(이메일)" class="inp" autocomplete="off">
                        <span class="dcbtn">
                        	<button type="button" class="btn_line02" onclick="idemail_confirmRepetition()">중복확인 </button>
                        </span>
                    </div>
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">비밀번호</label>
                        <input type="password" name="password" id="password" onkeyup="passwordChk()" value="<?php echo $password; ?>" tabindex="3" placeholder="비밀번호(영문+숫자8-15)" title="비밀번호(영문+숫자8-15)" class="inp" autocomplete="off">
                        
                        <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                        <div class="err_msg_passwd"><span id="password_check" style="<?php if($password == '') { echo "display:;"; } else { echo "display:none;"; } ?>">* 비밀번호를 영문+숫자 8-15로 입력하세요.</span></div>
                                     
                        <input type="password" name="repassword" id="repassword" onkeyup="repasswordChk()" value="<?php echo $password; ?>" tabindex="4" placeholder="비밀번호 확인" title="비밀번호 확인" class="inp" autocomplete="off">
                        <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                        <div class="err_msg" style="display:none;"><span id="password_result">* 비밀번호가 동일하지 않습니다.</span></div>
                    </div>
                    <div class="inpbox inpbn">
                        <label for="u_phone" class="lbl">휴대폰인증</label>
                        <?php if($certIDX != '') {?>
                        <button type="button" class="btn_type07 btn_cirtf">휴대폰인증완료</button>
                        <?php } else { ?>
                        <button type="button" onClick="phoneCert()" tabindex="5" class="btn_type07 btn_cirtf">휴대폰인증</button>
                        <?php } ?>
                        <p class="add_text">* 본인명의의 휴대폰번호로 인증해주세요.</p>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn double">
                <button type="button" class="btn_type03">뒤로</button>
                <button type="button" class="btn_type02" onclick="joinComplete()">가입하기</button>
            </div>
        </div>
        
        <!-- 아이디 중복 확인 -->
        <input type="hidden" name="idcertconfirm" id="idcertconfirm" value="<?php echo $idcertconfirm; ?>">
    </form>
    </section>
</div>

<form name="form_chk" method="post">
<input type="hidden" name="m" value="checkplusSerivce">             <!-- 필수 데이타로, 누락하시면 안됩니다. -->
<input type="hidden" name="EncodeData" id="ncEncData" value="">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>

<script type="text/javascript">
// 아이디 중복확인
function idemail_confirmRepetition()
{
	var idemail = $.trim($("#user_id").val());		// 이메일
	
	// 아이디(이메일) 체크
	if(idemail == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		$("#user_id").focus();
		return false;
	}

	// 아이디(이메일) 정상메일 체크
	var emailChk = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	if(idemail.match(emailChk) == null) {
		swal('적합하지 않은 아이디(이메일) 형식입니다. 다시 입력해 주세요.');
		$("#user_id").focus();
		$("#user_id").val('');
		return false;
	}

	// 전송할 데이터
    var join_data = "&user_id=" + idemail;
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url: "/member/joincheck", 
    	data: join_data, 
    	success: function(data) {
     		if(data == 'Y') 
     		{ 
      			swal('이미 존재하는 아이디(이메일)입니다. 다시 아이디(이메일)를 입력하세요.');
      			$("#user_id").val('');
      			$("#user_id").focus();
      			return false; 
     		} 
     		else 
     		{ 
     			swal('등록 가능한 아이디(이메일)입니다.');
     			$('#idcertconfirm').val(data);
     		}
    	}, 
    	error:function(data){ 
     		alert('ajax error'); 
    	}
   	}); 
}

// 비밀번호 체크
function passwordChk()
{
	var password = $("#password").val();	// 비밀번호

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		$("#password_check").css("display", "block");
		$("#password_check").text("* 비밀번호를 영문+숫자 8-15로 입력하세요.");
		//$("#password_check").text("* 비밀번호는 숫자와 영문을 포함하여 8자 이상 15자 이하로 적어주세요.");
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        $("#password_check").css("display", "block");
        $("#password_check").text("* 비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다."); 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    { 
	        $("#password_check").css("display", "block");
	        $("#password_check").text("* 비밀번호는 숫자와 영문자를 혼용하여야 합니다."); 
	    }
		else
		{
			$("#password_check").text("");
		}
	}

    return;
}

// 비밀번호 확인 체크
function repasswordChk()
{
	var password = $("#password").val();	// 비밀번호
	var repassword = $("#repassword").val();// 재입력 비밀번호

	if(password != repassword) {
		$('#repassword').addClass('error');
		$(".err_msg").css("display", "block");
	}
	else {
		$('#repassword').removeClass('error');
		$(".err_msg").css("display", "none");
	}
	
	return false;
}

//----------------------------------------------------//

// 휴대폰 인증창 활성화
function fnPopupNC()
{
	//window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
	document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
	//document.form_chk.target = "popupChk";
	document.form_chk.submit();
}

// 인증 체크
function phoneCert()
{
  	event.preventDefault();

  	var username = $("#user_name").val();	// 이름
	var idemail = $.trim($("#user_id").val());		// 이메일
	var password = $("#password").val();	// 비밀번호
	var repassword = $("#repassword").val();// 재입력 비밀번호
	var idcertconfirm = $("#idcertconfirm").val();	// 아이디 중복 확인 결과
	
	// 이름 체크
	if(username == '') {
		swal("이름을 입력해 주세요.");
		$("#user_name").focus();
		return false;
	}

	// 아이디(이메일) 체크
	if(idemail == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		$("#user_id").focus();
		return false;
	}

	// 아이디(이메일) 정상메일 체크
	var emailChk = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	if(idemail.match(emailChk) == null) {
		swal('적합하지 않은 아이디(이메일) 형식입니다. 다시 입력해 주세요.');
		$("#user_id").focus();
		return false;
	}

	// 아이디 중복 확인 체크
	if(idcertconfirm != 'N') {
		swal('아이디 중복 확인을 해주세요.');
		return false;
	}

	// 비밀번호 체크
	if(password == '') {
		swal("비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		swal("비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        swal("비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.");
		return false; 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    {
	        swal("비밀번호는 숫자와 영문자를 혼용하여야 합니다.");
			return false; 
	    }
	}

	// 입력한 비밀번호 확인 체크
	if(password != repassword) {
		swal('입력하신 비밀번호가 동일하지 않습니다. 다시 확인하여 주십시요.');
		return false;
	}
  	
  	$.ajax({
    	url: "/member/cellphoneCertNum",
    	type: "post",
    	data: $("#join_form").serialize(),
    	dataType: "json",
    	success: function(result){
      		if(result.code == 200) {
        		$("#ncEncData").val(result.data);
        		fnPopupNC();
      		}
			else {
        		swal(result.msg);
      		}
    	},
    	error: function(request, status, error) {
       		swal("오류가 발생하였습니다. 잠시 후에 다시 시도해 주세요");
     	},
     	beforeSend: function() {
       		$('#ajax_loader').show();
      	},
      	complete: function(){
       		$('#ajax_loader').hide();
      	}
  	});
	
  	return false;
}

// 가입처리
function joinComplete()
{
	var username = $("#user_name").val();	// 이름
	var idemail = $.trim($("#user_id").val());		// 이메일
	var password = $("#password").val();	// 비밀번호
	var repassword = $("#repassword").val();// 재입력 비밀번호
	
	// 이름 체크
	if(username == '') {
		swal("이름을 입력해 주세요.");
		$("#user_name").focus();
		return false;
	}

	// 아이디(이메일) 체크
	if(idemail == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		$("#user_id").focus();
		return false;
	}

	// 아이디(이메일) 정상메일 체크
	var emailChk = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	if(idemail.match(emailChk) == null) {
		swal('적합하지 않은 아이디(이메일) 형식입니다. 다시 입력해 주세요.');
		$("#user_id").focus();
		return false;
	}

	// 비밀번호 체크
	if(password == '') {
		swal("비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		swal("비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        swal("비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.");
		return false; 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    {
	        swal("비밀번호는 숫자와 영문자를 혼용하여야 합니다.");
			return false; 
	    }
	}

	// 입력한 비밀번호 확인 체크
	if(password != repassword) {
		swal('입력하신 비밀번호가 동일하지 않습니다. 다시 확인하여 주십시요.');
		return false;
	}
	
	// 전송할 데이터
    var join_data = "&user_name=" + encodeURIComponent($("#user_name").val()) + "&user_id=" + $.trim($("#user_id").val()) + "&password=" + $("#password").val();
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url:"/member/joinprocess", 
    	data: join_data, 
    	success: function(data) {
     		if(data == 'N') 
     		{ 
      			swal('회원가입에 실패하였습니다. 다시 가입시도 해 주시기 바랍니다.'); 
      			return false;
     		} 
     		else 
     		{ 
      			location.href = "/member/join3/?user_name=" + encodeURIComponent($("#user_name").val()); 
     		} 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR');
    	} 
   	});
}

$(document).ready(function(){
	// 뒤로가기
    $('.btn_type03').click(function(){
    	history.back();
    	return false;
    });
});
</script>