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
                    <!-- 휴대폰인증번호 입력 영역 -->
                    <div class="cirti_area">
                        <div class="ntc_txt">
                            <p>휴대폰으로 발송된<br>인증번호를 입력해주세요.</p>
                        </div>
                        <div class="inpbox inpbn">
                          <input type="number" name="findIdChk" id="findIdChk" placeholder="인증번호입력" title="인증번호입력" class="inp" autocomplete="off">
                          <span class="dcbtn"><button class="btn_line02" onClick="findIdprc()">인증</button></span>
                      </div>
                    </div>
                </div>                
            </div>
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03">확인</button><!-- 인증완료 후 on클래스 추가 --> 
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
function isnumberOnly(p) {
	var numberonly = /^([0-9]{6})$/;
	return numberonly.test(p);
}

var confirm = "000";
var userid = "";

function findIdprc()
{
    var certno = $("#findIdChk").val();
    if(certno == '') {
    	swal("인증번호를 입력해주세요");
    	return;
    }
    
    if(!isnumberOnly(certno)) {
    	swal("인증번호를 확인해주세요");
    	return;
    }
    
    $.ajax({
        url:"/member/findIDChk/",
        type:"post" ,
        data: {certno:certno},
        dataType: "json",
        success : function(result){
            if(result.code == 200)
            {
            	confirm = result.code;
            	userid = result.data;
            	$(".btn_type03").addClass('on');
            	
            	swal({
            	  	title: "인증 완료!",
            	  	text: "휴대폰 인증이 완료 되었습니다.\n확인 버튼을 눌러 아이디를 확인 하시기 바랍니다.",
            	  	icon: "success",
            	  	button: "확 인",
            	});
            }
            else
            {
            	$(".btn_type03").removeClass('on');
            	swal({
        		  	title: "발송 실패!",
        		  	text: "인증번호 발송에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
        		  	icon: "error",
        		  	button: "확 인",
        		});
            }
        },
        error: function(request, status, error) {
			alert("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
        },
    });
}

// 아이디 확인
$(".btn_type03").click(function(){
	if(confirm == 200) 
	{ 
		location.href = "/member/findid3/" + encodeURIComponent(userid); 
		return;
	} 
	else 
	{ 
		swal({
		  	title: "발송 실패!",
		  	text: "인증번호 발송에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
		  	icon: "error",
		  	button: "확 인",
		});
		return false; 
	}
});
</script>