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
                    <div class="result_area">
                        <p class="rst_p">비밀번호 재설정 완료!!</p>
                        <p class="ntc_p">비밀번호 재설정이 완료되었습니다.</p>
                    </div>
                </div>
            </div>
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" onclick="goPage('/member/login')">로그인</button>
            </div>
        </div>
    </section>
</div>

<?php if($RESULT == 'FAIL') { ?>
<script type="text/javascript">
swal({
  	title: "재설정 실패!",
  	text: "재설정에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
  	icon: "error",
  	button: "확 인",
}).then(function(){ 
	   location.href='/member/setpasswd1';
});
</script>
<?php } ?>