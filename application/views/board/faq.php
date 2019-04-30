<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span> 
    	<h2 class="title">도움말</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">            
            <div class="cont_wrap public_cont03">
                <!-- 카테고리 -->
                <div class="f_tab">
                  <ul>
                    <?php foreach($categorylist as $category) { ?>
                    <li><a href="#" onclick="categorySel('<?php echo $category['FAQ_IDX']; ?>', '<?php echo $category['CATEGORY']; ?>');" id="<?php echo $category['FAQ_IDX']; ?>" class="faqcate"><?php echo $category['CATEGORY']; ?></a></li>
                    <?php } ?>
                  </ul>    
                </div>
                
                <!-- 내용 -->
                <div class="f_tabcon">
                    <ul class="faq_lst"></ul>
                </div>
                <br>
            </div>
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" onclick="inqueryProc()">1:1문의하기</button>
            </div>
        </div>
    </section>
    
    <!-- 비로그인시 팝업 (S) -->
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none;"></div>    
    <div class="lyr lyrpop01" style="display:none;"> <a href="javascript:void(0);" onclick="closePop()" class="close">닫기</a>
        <div class="lyr_inner">
            <p class="cont">로그인이 필요한 메뉴입니다.<br>
                로그인하시겠습니까?</p>
        </div>
        <div class="btn double">
            <button type="button" class="btn_type08" onclick="goPage('/member/join1')">회원가입</button>
            <button type="button" class="btn_type02" onclick="goPage('/member/login')">로그인</button>
        </div>
    </div>
    <!-- 비로그인시 팝업 (E) -->
</div>

<script type="text/javascript">
// 문의하기
function inqueryProc()
{
	<?php if(!empty($this->userinfo['MBR_ID'])) { ?>
	goPage('/board/inquiry');
	<?php } else { ?>
	$('.mask').css('display', 'block');
	$('.lyrpop01').css('display', 'block');
	<?php } ?>
}

// 로그인 창 닫기
function closePop() {
	$('.mask').css('display', 'none');
	$('.lyrpop01').css('display', 'none');
}

// faq 카테고리
function categorySel(idx, code)
{
	$('.faq_lst').children().remove().end();

	$(".faqcate").removeClass('on');
	$("#"+idx).addClass('on');
	
	// 시도 리스트 가져오기
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/faqlist", 
    	data: "&category="+code, 
    	success: function(data) {
    		var html1 = '';    		
    		for(var i = 0, len = data.length; i < len; ++i) {
    		    html1 += '<li><a href="javascript:contentsView(' + data[i].idx + ');" class="qitem active"><b>Q.</b>' + data[i].question + '</a><div class="aitem" id="faqview_' + data[i].idx + '" style="display:none;">' + data[i].answer + '</div></li>';
    		}
    		$('.faq_lst').append(html1); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR1');
    	} 
   	});
}

// faq 내용보기
var idxview = null;
function contentsView(idx)
{
	if(idxview == idx) {
		$("#faqview_"+idx).toggle();
	}
	else {
		$(".aitem").hide();
		$("#faqview_"+idx).show();
	}
	
	idxview = idx;
}

// 첫번째 카테고리 리스트 출력
categorySel('1', '서비스 일반');
</script>