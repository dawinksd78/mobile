<div id="dawinWrap" class="mainwrap">
    <header id="header" class="maphd"> 
      	<span class="btn_back back02">
      		<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
      	</span>
      
      	<!-- hamburgerMenu -->
      	<script>hamburgerMenuList('menu_wh');</script>
    </header>
    
    <section id="container">
        <div id="sellmain_section">
            <div class="img_box">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="scdec_img"><img src="../../images/img_smain07.png" alt="다윈에 집을 내놓아야 할 3가지 이유!"></p>
                        <p class="scdec_img"><img src="../../images/img_smain02.png" alt="중개수수료0원, 빠름, 신뢰"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ban_area">
          <a href="javascript:goPage('/sellhome/agencyservice');" class="link_sv">매물등록서비스오픈</a>
        </div>
        <div id="sub_section" class="smain_sub">
            <div class="sec_box">
                <p class="sc_tit"><i class="f_red"><b>1.</b></i> 집 내놓을 때 중개수수료 0원</p>
                <p class="sc_dec">다윈중개는 저렴한 비용으로<br>
                    중개 가능한 시스템을 구축하였습니다.<br>
                    집 내놓을 때는 수수료 0원,<br>
                    집을 구할 때만 기존 수수료의 절반을 받습니다.</p>
                <p class="scdec_img"><img src="../../images/img_smain03.png" alt="중개수수료설명"></p>
            </div>
            <div class="sec_box">
                <p class="sc_tit"><i class="f_red"><b>2.</b></i> 가장 빨리, 가장 좋은 가격으로 성사</p>
                <p class="sc_dec">다윈중개는 매물이 등록됨과 동시에<br>
                    인근 중개사들 모두에게 자동 노출됨으로써<br>
                    중개사들간 경쟁을 통해 가장 경쟁력있는 가격으로<br>
                    가장 빨리 중개를 성사시킵니다.</p>
                <p class="scdec_img"><img src="../../images/img_smain04.png" alt="가장 빨리, 가장 좋은 가격으로 성사"></p>
            </div>
            <div class="sec_box">
                <p class="sc_tit"><i class="f_red"><b>3.</b></i> 검증되고 신뢰할 수 있는 중개사</p>
                <p class="sc_dec">다윈중개에는 직접 거래한 고객의 평가를 비롯한<br>
                    다양한 중개사 평가 시스템이 있습니다.<br>
                    검증되고 신뢰할 수 있는 중개사님들을<br>
                    선택할 수 있습니다.</p>
                <p class="scdec_img"><img src="../../images/img_smain05.png" alt="검증되고 신뢰할 수 있는 중개사"></p>
            </div>
            <div class="sec_box">
                <p class="sc_tit">다윈중개 거래 프로세스</p>
                <p class="scdec_img"><img src="../../images/img_smain06.png" alt="다윈 중개거래 흐름도"></p>
            </div>
        </div>
        <div class="btn_area bot_btn sellm"> 
            <!-- 스크롤 했음이 확인됐을 경우 on 클래스 추가-->
            <button class="btn_type03 on">집 내놓기</button>
        </div>
    </section>
</div>

<script type="text/javascript">
var pageCheck;

// 페이지 하단 체크
/*$("#dawinWrap").scroll(function(){
    var ele = document.getElementById('dawinWrap');
    if(ele.scrollHeight - ele.scrollTop === ele.clientHeight){
    	$(".btn_type03").addClass('on');
    	pageCheck = "view";
    }
});*/

// 아파트로 이동
$(".btn_type03").click(function(){
	/*if(pageCheck != "view") {
		swal('위 내용을 전부 확인 후 매물 등록 페이지로 이동하세요!');
		return false;
	}*/

	<?php /* 비로그인 시 */ if($memType == '') { ?>
	swal('로그인이 필요한 페이지 입니다.')
	.then(function(){ 
	   location.href='/member/login/sellhome_main';
	});
	return;
	<?php } ?>

	<?php if($memType != '' && $memType != 'PU') { ?>
	swal('중개사회원은 매물 등록을 하실 수 없습니다.');
	return false;
	<?php } ?>

	// 이전 등록 매물 체크
	var gotoCategory = "<?php echo ( isset($last_category) ) ? $last_category : ''; ?>";
    var gotoStep = "<?php echo ( isset($last_step) ) ? $last_step : ''; ?>";

	if( gotoCategory !='' && gotoStep !='' )
	{
		swal({
		    text: "매물등록정보가 있습니다.\n이어서 등록하시겠습니까?\n새로 등록하시려면 취소버튼을 누르세요!",
		    buttons: [
		        'Cancel',
		        'Yes'
		    ],
		}).then(function(isConfirm) {
			if(isConfirm) {
				location.href = "/sellhome/"+ gotoStep+"/"+ gotoCategory;
			}
			else
			{
				// 기존데이터 삭제
		    	$.ajax({ 
		         	type: "POST", 
		         	dataType: "text",
		         	async: false, 
		         	url:"/sellhome/main_initialize", 
		         	data: "", 
		         	success: function(data) {
		             	if(data == 'SUCCESS') {
		         			location.href = "/sellhome/step1";
		             	}
		             	else {
		             		swal('AJAX ERROR1');
		             	} 
		         	}, 
		         	error:function(data){ 
		          		swal('AJAX ERROR2');
		         	} 
		    	});
			}
		});
		/*if(confirm("매물등록정보가 있습니다.\n이어서 등록하시겠습니까?\n새로 등록하시려면 취소버튼을 누르세요!")) {
			location.href = "/sellhome/"+ gotoStep+"/"+ gotoCategory;
		}*/
	}
	else
	{
		// 기존데이터 삭제
    	$.ajax({ 
         	type: "POST", 
         	dataType: "text",
         	async: false, 
         	url:"/sellhome/main_initialize", 
         	data: "", 
         	success: function(data) {
             	if(data == 'SUCCESS') {
         			location.href = "/sellhome/step1";
             	}
             	else {
             		swal('AJAX ERROR1');
             	} 
         	}, 
         	error:function(data){ 
          		swal('AJAX ERROR2');
         	} 
    	});
	}
});

$(document).ready(function(){
	$("#dawinWrap").on('scroll', function(){
	    var scrollValue = $(this).scrollTop();
	    if(scrollValue > 450) {
	    	$(".btn_back").removeClass('back02');
			$(".btn_menu02").removeClass('menu_wh');
        }
        else {
        	$(".btn_back").addClass('back02');
        	$(".btn_menu02").addClass('menu_wh'); 
		}
	});
});
</script>