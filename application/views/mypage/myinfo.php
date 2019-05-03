<div id="dawinWrap" class="mpwrap">
    <header id="header" class="header maphd">
    	<span class="btn_back back02">
        	<button type="button" onclick="history.back();"><span>뒤로</span></button>
        </span>
        <span class="btn_alarm">
        	<button type="button" onclick="goPage('/mypage/alarm')"><span>알람</span></button>
        </span>
        
        <!-- hamburgerMenu -->
      	<script>hamburgerMenuList('menu_wh');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="infobox">
                <div class="user_info">
                    <p class="name"><?php echo $this->userinfo['MBR_NAME']; ?></p>
                    <p class="id"><?php echo $this->userinfo['MBR_EMAIL']; ?></p>
                </div>
                <div class="mp_tab">
                    <ul>
                        <li><a href="#" onclick="goPage('/mypage/myzzimsale')">내집구하기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myhousesale')">내집내놓기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinfo')" class="on">내정보</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinquiry')">1:1문의</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="cont_wrap mp">
                <div class="cont">
                    <div class="inpbox">
                        <label for="u_name" class="lbl">이름</label>
                        <input type="text" name="u_name" id="u_name" value="<?php echo $this->userinfo['MBR_NAME']; ?>" class="inp readinp" autocomplete="off" readonly>
                        <p class="add_text">* 이름은 변경할 수 없습니다.</p>
                    </div>
                    
                    <div class="inpbox">
                        <label for="u_id" class="lbl">아이디</label>
                        <input type="text" name="u_id" id="u_id" value="<?php echo $this->userinfo['MBR_ID']; ?>" class="inp readinp" autocomplete="off" readonly>
                        <p class="add_text">* 아이디는 변경할 수 없습니다.</p>
                    </div>
                    
                    <div class="inpbox">
                      <label for="u_pass" class="lbl">비밀번호</label>
                      <input type="password" name="now_pass" id="now_pass" placeholder="현재비밀번호" title="현재비밀번호" class="inp" autocomplete="off">
                      
                      <input type="password" name="new_pass" id="new_pass" onkeyup="passwordChk()" placeholder="비밀번호를 입력하세요. (영문+숫자8-15)" title="비밀번호를 입력하세요. (영문+숫자8-15)" class="inp" autocomplete="off">
                      
                      <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                      <div class="err_msg_passwd"><span id="password_check" style="display:none;">* 비밀번호를 영문+숫자 8-15로 입력하세요.</span></div>
                      
                      <!-- 비밀번호 동일하지 않을 경우 error 클래스 추가 -->
                      <input type="password" name="re_pass" id="re_pass" onkeyup="repasswordChk()" placeholder="비밀번호를 다시입력하세요." title="비밀번호를 다시입력하세요." class="inp" autocomplete="off">
                      
                      <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                      <div class="err_msg"><span id="repassword_check" style="display:none;">* 비밀번호가 동일하지 않습니다.</span></div>
                      
                      <div class="btn wdth_btn">
                      	<button type="button" class="btn_line" onclick="passwordChange()">비밀번호변경</button>
                      </div>                        
                    </div>
                    
                    <div class="inpbox inpbn">
                        <label for="u_phone" class="lbl">휴대폰번호</label>
                        <input type="tel" name="cellphone" id="cellphone" value="<?php echo $MBR_CP; ?>" placeholder="010-0000-0000" title="010-0000-0000" class="inp" autocomplete="off" readonly="readonly">
                        <span class="dcbtn"><button type="button" class="btn_line02" onclick="cellphoneChange()">휴대폰변경</button></span> 
                    </div>
                    
                  	<div class="inpbox">
                    	<div class="btn wdth_btn"><button type="button" class="btn_line logout" onclick="goPage('/member/logout')">로그아웃</button></div>
                    	<button type="button" class="Withdrawal" onclick="withdrawal()">회원탈퇴</button>
                  	</div>
                </div>
            </div>
        </div>        
    </section>
</div>

<!-- 휴대폰 번호 변경 -->
<form name="form_chk_Hp" id="form_chk_Hp" method="post">
	<input type="hidden" name="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="EncodeData" id="EncodeData">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>

<script type="text/javascript">
//비밀번호 체크
function passwordChk()
{
	var password = $("#new_pass").val();	// 새 비밀번호

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		$(".err_msg_passwd").css("display", "block");
		$("#password_check").css("display", "block");
		$("#password_check").text("* 비밀번호를 영문+숫자 8-15로 입력하세요.");
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        $(".err_msg_passwd").css("display", "block");
        $("#password_check").css("display", "block");
        $("#password_check").text("* 비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다."); 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    { 
	        $(".err_msg_passwd").css("display", "block");
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
	var password = $("#new_pass").val();	// 비밀번호
	var repassword = $("#re_pass").val();	// 재입력 비밀번호

	if(password != repassword) {
		$(".err_msg").css("display", "block");
		$("#repassword_check").css("display", "block");
	}
	else {
		$(".err_msg").css("display", "none");
		$("#repassword_check").css("display", "none");
	}
	
	return false;
}

// 비밀번호 변경
function passwordChange()
{
	var nowPwd = $("#now_pass").val();
	var newPwd = $("#new_pass").val();
	var rePwd = $("#re_pass").val();

	// 현재 비밀번호 체크
	if(nowPwd == '') {
		swal("현재 비밀번호를 입력하세요.");
		return false;
	}

	// 새비밀번호 체크
	if(newPwd == '') {
		swal("새비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}

	// 혼용여부 체크
	var chk_num = newPwd.search(/[0-9]/g); 
    var chk_eng = newPwd.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(newPwd))
	if(!checkpwd(newPwd))
	{
		swal("비밀번호를 입력하세요. (영문+숫자8-15)");
		return false;
	}
	else if(/(\w)\1\1\1/.test(newPwd))
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
	if(newPwd != rePwd) {
		swal('입력하신 비밀번호가 동일하지 않습니다. 다시 확인하여 주십시요.');
		return false;
	}

	// 현재 비밀번호와 새로운 비밀번호가 동일하면 안됨.
	if(nowPwd == newPwd) {
		swal('입력하신 비밀번호가 현재 비밀번호와 동일합니다. 다른 비밀번호로 입력하여 주십시요.');
		return false;
	}
	
	// 전송할 데이터
    var pwd_data = "&nowpwd=" + encodeURIComponent(nowPwd) + "&newpwd=" + encodeURIComponent(newPwd);
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url:"/mypage/passwordchange", 
    	data: pwd_data, 
    	success: function(data) {
			if(data == 'NOEXIST')
			{
				// 존재하지 않는 회원
      			swal('존재하지 않는 회원정보 입니다. 다시 시도해 주시기 바랍니다.'); 
      			return false;
			}
    		else if(data == 'OUTMEMBER') 
     		{
    			// 강제 탈퇴된 회원
      			swal('존재하지 않는 회원정보 입니다. 다시 시도해 주시기 바랍니다.'); 
      			return false;
     		}
    		else if(data == 'PWDFAIL') 
     		{
         		// 현재 비밀번호 틀림
      			swal('현재 비밀번호가 틀렸습니다. 다시 시도해 주시기 바랍니다.'); 
      			return false;
     		}
     		else if(data == 'COMPLETE') 
     		{
      			swal({
      			  	title: "변경 완료!",
      			  	text: "입력하신 비밀번호로 변경이 완료 되었습니다.",
      			  	icon: "success",
      			  	button: "확 인",
      			}); 
      			$("#now_pass").val('');
      			$("#new_pass").val('');
      			$("#re_pass").val('');
      			return; 
     		}
     		else
     		{
     			swal({
      			  	title: "오류 발생!",
      			  	text: "오류가 발생하였습니다. 다시 시도해 주시기 바랍니다.",
      			  	icon: "error",
      			  	button: "확 인",
      			}); 
      			return false;
     		} 
    	}, 
    	error:function(data){
     		swal('AJAX ERROR');
    	} 
   	}); 
}

$("#cellphone").keyup(function(){
	var _val = this.value.trim();
	this.value = cellphoneInput(_val);
});

// 휴대폰 번호 변경
function cellphoneChange()
{
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url: "/mypage/myinfo_certdata", 
    	success: function(data) {
			if(data.code == '100')
			{
				$('#EncodeData').val(data.res);
				document.form_chk_Hp.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
				document.form_chk_Hp.submit();          			
      			return false;
			}
     		else
     		{
         		// 실패
     			swal("오류!", "오류가 발생하였습니다. 다시 시도해 주시기 바랍니다!", "error");  
      			return false;
     		} 
    	}, 
    	error:function(data){
    		// 실패
 			swal("오류!", "오류가 발생하였습니다. 다시 시도해 주시기 바랍니다!", "error");  
  			return false;
    	} 
   	});
}

// 회원탈퇴
function withdrawal()
{
	/* text: '회원 탈퇴하시면 3개월간 회원 재가입이 제한됩니다. 회원탈퇴하시겠습니까?', */
	swal({
		title: '회원탈퇴',
		text: '회원 탈퇴하시겠습니까?',
		buttons: {
    		cancel: "탈퇴취소",
    		catch: {
      			text: "탈퇴확인",
      			value: "catch",
    		},
  		}
	})
	.then(function (value) {
		switch (value)
		{	 
	    	case "catch":
	    		$.ajax({ 
	    	    	type: "POST", 
	    	    	dataType: "text",
	    	    	async: false, 
	    	    	url: "/mypage/widthdraw", 
	    	    	success: function(data) {
	    				if(data == 'SUCCESS')
	    				{
	    					// 탈퇴완료
	    	      			swal({
                  			  	title: "탈퇴완료!",
                  			  	text: "그동안 다윈중개를 이용해 주셔서 감사합니다!",
                  			  	icon: "success",
                  			  	button: "확 인",
                  			})
                  			.then(function () {
	    	      				goPage('/member/logout');
                  			});                  			
	    	      			return false;
	    				}
	    	     		else
	    	     		{
	    	         		// 탈퇴실패
	    	     			swal("탈퇴실패!", "회원탈퇴에 실패하였습니다. 다시 시도해 주시기 바랍니다!", "error");  
	    	      			return false;
	    	     		} 
	    	    	}, 
	    	    	error:function(data){
	    	     		swal('AJAX ERROR');
	    	    	} 
	    	   	});
	      	break;
	 
	    	default:
	      		swal("탈퇴취소 되었습니다!");
	  	}
	})
}
</script>