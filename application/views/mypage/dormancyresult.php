<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span class="">닫기</span></button>
        </span> 
        <h2 class="title">휴면계정안내</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap">                     
                    <!-- 이메일 발송결과 -->
                    <div class="result_area">
                        <p class="rst_p">이메일발송완료!!</p>
                        <p class="ntc_p">비밀번호 재설정을 위해<br>
                            이메일을 확인해주세요.</p>
                    </div>
                </div>                
            </div>
            
            <div class="btn_area bot_btn">
                <button class="btn_type02">확인</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
// 메인으로 이동
$(".btn_type02").click(function(){
	location.href = "/";
});
</script>