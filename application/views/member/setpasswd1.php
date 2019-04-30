<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span class="">닫기</span></button>
        </span>
        <h2 class="title">비밀번호재설정</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">            
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap">
                    <div class="ntc_txt">
                        <p class="ntc_p">새로운 비밀번호를 입력해주세요.</p>
                    </div>
                    <div class="inpbox">
                      <input type="password" name="change_pw" id="change_pw" onkeyup="pwdChk1()" placeholder="비밀번호를 입력하세요(영문+숫자8-15)" title="비밀번호를 입력하세요(영문+숫자8-15)" class="inp" autocomplete="off">
                      <input type="password" name="change_pw_re" id="change_pw_re" onkeyup="pwdChk2()" placeholder="비밀번호를 다시입력하세요." title="비밀번호를 다시입력하세요." class="inp error" autocomplete="off">
                      <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                      <div class="err_msg"><span id="err_msg_res">* 비밀번호를 입력하세요.</span></div>
                    </div>
                </div>
            </div>
            <div class="btn_area bot_btn">
                <button class="btn_type03" type="button" onclick="changepassword()">확인</button>
                <!-- 인증이 완료되면 on클래스 추가 --> 
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
function checkpwd(str_val) {
  	regStrpw = /^(?=(.*[a-zA-Z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){0,})(?!.*\s).{8,20}$/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	//regStrpw = /^(?=(.*[a-zA-Z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	//regStr = regStr = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	return regStrpw.test(str_val);
}
	
// 비번 체크 1
function pwdChk1()
{
	if($("#change_pw").val().trim() == '') {
    	//swal("비밀번호를 입력하여주세요");
    	$('#err_msg_res').html('* 비밀번호를 입력하여주세요.');
    	$("#change_pw").focus();
  	}
  	else if(!checkpwd($("#change_pw").val().trim())) {
  		//swal("비밀번호는 영문, 숫자를 포함한 8자이상 문자의 조합입니다.");
  		$('#err_msg_res').html('* 비밀번호는 영문, 숫자를 포함한 8자이상 문자의 조합입니다.');
  	}
  	else {
  		$('#err_msg_res').html('* 비밀번호가 정상입니다.');
  	}
}

//비번 체크 2
function pwdChk2()
{
	if($("#change_pw").val() != $("#change_pw_re").val()) {
  		//swal("동일한 비밀번호를 입력해 주세요.");
  		$('#err_msg_res').html('* 비밀번호가 동일하지 않습니다.');
  	}
	else {
		$('#err_msg_res').html('* 비밀번호가 동일합니다.');
		$('.btn_type03').addClass('on');
	}
}

// 비번 변경 처리
function changepassword()
{
  	event.preventDefault();
  	if($("#change_pw").val().trim() == '') {
    	//swal("비밀번호를 입력하여주세요");
    	$('#err_msg_res').html('* 비밀번호를 입력하여주세요.');
    	$("#change_pw").focus();
  	}
  	else if(!checkpwd($("#change_pw").val().trim())) {
  		//swal("비밀번호는 영문, 숫자를 포함한 8자이상 문자의 조합입니다.");
  		$('#err_msg_res').html('* 비밀번호는 영문, 숫자를 포함한 8자이상 문자의 조합입니다.');
  	}
  	else if($("#change_pw").val() != $("#change_pw_re").val()) {
  		//swal("동일한 비밀번호를 입력해 주세요.");
  		$('#err_msg_res').html('* 비밀번호가 동일하지 않습니다.');
  	}
  	else
  	{
        $.ajax({
          	url:"/member/setpasswdChange" ,
          	type:"post" ,
          	data : {change_pw: $("#change_pw").val().trim(), change_pw_re: $("#change_pw_re").val().trim()} ,
          	dataType : "json" ,
          	success : function (result){
            	if(result.code == 200) {
              		location.href = "/member/setpasswd2/COM";
            	}
            	else {
            		swal(result.msg);
            	}
          	},
          	error : function(request, status, error) {
          		swal("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요");
           	}
        });
  	}
  	
  	return false;
}
</script>