<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">아이디찾기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap"> 
                    <div class="inpbox" style="padding:0 0 15px 0;">
                      	<input type="tell" name="findIdHp" id="findIdHp" placeholder="휴대폰 번호를 입력해주세요." title="휴대폰 번호를 입력해주세요." class="inp" autocomplete="off">
                    </div>
                    
                    <!-- 휴대폰인증영역 -->
                    <div class="btn_area mgt">
                        <button class="btn_type07 btn_cirtf" onclick="findID()">휴대폰인증</button>
                    </div>                    
                </div>
                
                <!-- 비밀번호 찾기, 회원가입 링크는 휴대폰인증영역시만 오픈 -->
                <div class="lg_link"><a href="javascript:void(0);" onclick="goPage('/member/findpass1')">비밀번호찾기</a> <a href="javascript:void(0);" onclick="goPage('/member/join1')">회원가입</a></div>
            </div>
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03">확인</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
//보내기 버튼 활성 & 비활성
$("#findIdHp").keyup(function(){
	if($("#findIdHp").val() == '') {
		$(".btn_type03").removeClass('on');
	}
	else {
		$(".btn_type03").addClass('on');
	}
});

// 메인으로 이동
$(".btn_type03").click(function(){
	if($("#findIdHp").val() != '') {
		location.href = "/member/findid2";
	}
	else {
		swal('인증번호를 입력하세요');
		return;
	}
});

function isCellPhone(p) {
    p = p.split('-').join('');
    var regPhone = /^((01[1|6|7|8|9])[1-9]+[0-9]{6,7})|(010[1-9][0-9]{7})$/;
    return regPhone.test(p);
}
	
function findID()
{
    var hp = $("#findIdHp").val();
    if(isCellPhone(hp))
    {
        $.ajax({
            url:"/member/findid1Cert",
            type:"post" ,
            data : {hp:hp},
            dataType : "json" ,
            success: function(result){
              	if(result.code == 200) {
              		swal("휴대폰으로 인증번호를 발송하였습니다.\n확인 버튼을 눌러 인증번호를 입력해주세요")
                	$('.findIdHp').focus();
              	}
              	else {
              		swal(result.msg);
              	}
            },
            error: function(request, status, error) {
            	swal("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
			}
        });
    }
    else {
    	swal("휴대폰 번호를 확인해주세요");
    }
}
</script>