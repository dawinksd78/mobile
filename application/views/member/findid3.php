<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span class="">닫기</span></button>
        </span> 
        <h2 class="title">아이디찾기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap find_wrap">
                <div class="v_align_wrap">                     
                    <!-- 인증 후 아이디 노출 영역 -->
                    <div class="result_area" style="display:">
                        <p class="rst_p"><?php echo $userid; ?></p>
                    </div>
                </div>                
            </div>
            <div class="btn_area bot_btn">                
                <button type="button" class="btn_type02">로그인</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
// 로그인 페이지 이동
$(".btn_type02").click(function(){
	location.href = "/member/login";
});
</script>

<?php if($RESULT == 'FAIL') { ?>
<script type="text/javascript">
swal({
  	title: "아이디 찾기 실패!",
  	text: "아이디 찾기에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
  	icon: "error",
  	button: "확 인",
}).then(function(){ 
	   location.href='/member/findid1';
});
</script>
<?php } ?>