<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button><span class="">뒤로</span></button>
        </span>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap lg_wrap">
                <div class="lg_area">
                    <p class="p01">안녕하세요</p>
                    <p class="p02">다윈중개입니다.</p>
                    
                   	<input type="text" name="user_id" id="user_id" placeholder="아이디(이메일)" title="아이디(이메일)를  입력해 주세요" class="inp" autocomplete="off">
                   	<input type="password" name="password" id="password" onkeyup="if (window.event.keyCode == 13) { loginCheck(); }" placeholder="비밀번호" title="비밀번호를 입력해 주세요." class="inp" autocomplete="off">
                   	<button class="btn_login" onclick="loginCheck()">로그인</button>
                    
                    <div class="join_btnarea multi">
                        <button class="btn_line" onclick="goPage('/member/join1')">일반회원가입</button>
                        <button class="btn_line" onclick="goPage('/member/joinAgent1')">중개사회원가입</button>
                    </div>
                    <div class="lg_link"><a href="#" onclick="goPage('/member/findid1')">아이디찾기</a> <a href="#" onclick="goPage('/member/findpass1')">비밀번호찾기</a></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
function loginCheck()
{ 
	if($("#user_id").val() == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		return false;
	}

	// 비밀번호 체크
	if($("#password").val() == '') {
		swal("비밀번호를 입력해 주세요.");
		return false;
	} 
	
    var login_data = "&user_id=" + $("#user_id").val() + "&password=" + $("#password").val();
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url: "/mypage/loginprocess", 
    	data: login_data, 
    	success: function(data){
     		if(data == 'NOT EXIST') 
     		{ 
      			swal('존재하지 않는 계정입니다. 다시 로그인 해 주시기 바랍니다.');
      			$("#user_id").val('');
      			$("#password").val('');
      			return false;
     		}
     		else if(data == 'PASSWORD FAIL')
     		{
     			swal('입력하신 비밀번호가 맞지 않습니다. 다시 로그인 해 주시기 바랍니다.');
     			$("#password").val(''); 
      			return false;
     		}
     		else if(data == 'DORMANCY')
     		{
     			swal('접속하신 계정은 현재 휴면상태입니다. 휴면 해제 후 이용하시기 바랍니다.');
     			location.href = "/mypage/dormancy"; 
      			return false;
     		}
     		else if(data == 'SUCCESS')
     		{ 
      			location.href = "/"; 
     		}
     		else {
     			swal('알 수 없는 오류');
     		}
    	}, 
    	error:function(data){ 
    		swal('AJAX 오류'); 
    	} 
   	}); 
} 
</script>