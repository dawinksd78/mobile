<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">비밀번호찾기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap"> 
                    <!-- 이메일 입력 -->
                    <div class="c_cont">
                        <div class="ntc_txt">
                            <p class="ntc_p">가입하신 이메일을 입력하시면<br>해당 이메일로 비밀번호 재설정 URL을<br>보내드립니다.</p>
                        </div>
                        <div class="inpbox">
                            <input type="email" name="email" id="email" placeholder="아이디(이메일)" title="아이디(이메일)" class="inp" autocomplete="off">
                        </div>
                    </div>                    
                </div>
                <div class="lg_link"><a href="#" onclick="goPage('/member/findid1')">아이디찾기</a> <a href="#" onclick="goPage('/member/join1')">회원가입</a></div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03">보내기</button><!-- 이메일이 입력되면 완료되면 on클래스 추가 -->
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
// 보내기 버튼 활성 & 비활성
$("#email").keyup(function(){
	if($("#email").val() == '') {
		$(".btn_type03").removeClass('on');
	}
	else {
		$(".btn_type03").addClass('on');
	}
});

// 이메일 형식 체크 및 발송
$(".btn_type03").click(function(){
	var idemail = $("#email").val();		// 이메일

	// 아이디(이메일) 체크
	if(idemail == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		$("#email").focus();
		return false;
	}

	// 아이디(이메일) 정상메일 체크
	var emailChk = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	if(idemail.match(emailChk) == null) {
		swal('적합하지 않은 아이디(이메일) 형식입니다. 다시 입력해 주세요.');
		$("#email").focus();
		return false;
	}

	// 전송할 데이터
    var sendData = "&email=" + idemail + "&sendType=pwd";
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url:"/member/findpassemail", 
    	data: sendData, 
    	success: function(data) {
     		if(data == 'SUCCESS') 
     		{ 
     			location.href = "/member/findpass2"; 
      			return;
     		} 
     		else 
     		{ 
     			swal({
      			  	title: "발송 실패!",
      			  	text: "이메일 발송에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
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
});
</script>