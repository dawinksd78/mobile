<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close04">
        	<button type="button" onclick="history.back();"><span class="">닫기</span></button>
        </span>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap">
                <div class="c_align_wrap">
                    <p class="n_text"><big><b><?=$user_name?></b>님 환영합니다.</big>회원가입되었습니다.</p>
                </div>
            </div>
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" onclick="goPage('/member/login')">로그인</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.btn_close04').click(function(){
		location.href = '/';
		return false;
	});
});
</script>