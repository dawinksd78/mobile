<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

<link rel="stylesheet" href="/css/swiper.min.css">

<style>
/* 중개사 회원가입 swipe */
.swiper-container {width:100%;height:100%;}
.swiper-slide {display: -webkit-box;display: -ms-flexbox;display: -webkit-flex;display: flex;-webkit-box-pack: center;-ms-flex-pack: center;-webkit-justify-content: center;justify-content: center;-webkit-box-align: center;-ms-flex-align: center;-webkit-align-items: center;align-items: center;}

.swiper-pagination-red .swiper-pagination-bullet-active{background:#E06135}
.swiper-pagination-progressbar.swiper-pagination-red{background:rgba(255,255,255,.25)}
.swiper-pagination-progressbar.swiper-pagination-red .swiper-pagination-progressbar-fill{background:#E06135}
</style>

<div id="dawinWrap" class="mainwrap">
    <header id="header" class="maphd">
    	<span class="btn_back back02">
        	<button type="button" onclick="goPage('/');"><span class="">뒤로</span></button>
        </span>
        
        <!-- hamburgerMenu -->
      	<script>hamburgerMenuList('menu_wh');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="swiper-container" style="position:absolute; top:0; left:0; right:0; bottom:0;">
    			<ul class="swiper-wrapper">
    				<li class="s_jabg sjabg01 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit03">네이버, 직방은 이제그만!!</p>
                            <p class="ja_tit01">부동산 중개의 <b class="t_yellow">대변화</b>에<br> 올라타세요!</p>
                            <p class="ja_tit02">온라인상에 중개사무실을 개설하세요.<br>수많은 고객들이 알아서 찾아옵니다.</p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg02 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">매물 확보<br>걱정 No!</p>
                            <p class="ja_tit02">매도인(임대인)은 중개수수료가 무료인 대신<br>온라인에 직접 매물을 등록하므로<br>언제나 중개매물이 넘쳐납니다.<br>중개사무소 기준 반경 10km 이내의<br>모든 매물을 중개하실 수 있습니다.<br><b>매물 확보 걱정마시고 중개에만 집중하세요.</b></p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg03 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">매수인, 임차인 확보<br>걱정 No!</p>
                          <p class="ja_tit02">다윈중개에서 다양한 광고를 통해<br><b>매수인, 임차인을 확보해드립니다.</b><br>중개사님은 중개 서비스 향상에만 집중하세요.</p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg04 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">광고비<br>걱정 No!</p>
                          <p class="ja_tit02">매물 확보와 매수인 확보를 위한<br><b>모든 광고는 다윈중개에서 해드립니다.</b><br>더 이상 광고비 지출하지 마세요.</p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg05 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">임대료<br>걱정 No!</p>
                            <p class="ja_tit02">더 이상 비싼 임대료를 내가며<br>1층 상가에 있을 필요가 없습니다.<br><b>매물 확보에서 매수인, 임차인 확보,<br>모든 중개업무까지 온라인</b>으로 해결.<br>컴퓨터와 휴대폰만으로 완벽한 업무를<br>처리할 수 있도록 지원해드립니다.</p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg06 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">얻어걸린<br>고객 No!</p>
                            <p class="ja_tit02">이제는 내 이름만으로도<br>고객이 찾아오는 중개사가 되십시요.<br><b>고객으로부터 높은 평가를 받는 중개사가<br>최고의 중개사가 되는 시스템.</b><br>스타 중개사의 꿈을 이루어드립니다.</p>
                        </div>
                    </li>
                    <li class="s_jabg sjabg07 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">하루종이 사무실에서<br>뻗치기 No!</p>
                            <p class="ja_tit02">더 이상 하루 종일 사무실에서<br>대기할 필요가 없습니다.<br><b>모든 일은 언제, 어디서든 컴퓨터와 휴대폰으로.</b><br>이젠 근무시간과 근무장소를<br>자유롭게 활용하세요.
                        </div>
                    </li>
                    <li class="s_jabg sjabg08 swiper-slide">
                        <div class="jatit_wrap">
                            <p class="ja_tit01">다윈중개<br>중개 프로세스</p>
                            <p class="ja_tit02 jaimg"><img src="../../images/img_dec04.png" alt="다윈 중개 프로세스"></p>
                        </div>
                    </li>
    			</ul>
    			
    			<div class="swiper-pagination swiper-pagination-red" style="bottom:100px;"></div>
  			</div>
        </div>
        
        <div class="btn_area bot_btn"> 
            <!-- 7개의 슬라이드를 모두 확인했을 경우 on 클래스 추가-->
            <button type="button" class="btn_type03 on">중개사 회원 가입하기</button>
        </div>
    </section>
</div>

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script type="text/javascript">
var viewPage0, viewPage1, viewPage2, viewPage3, viewPage4, viewPage5, viewPage6, viewPage7;

var swiper = new Swiper('.swiper-container', {
	spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
});

swiper.on('slideChange', function () {
	var pageNumber = swiper.realIndex;
	
	viewPage0 = '1';
	$(".btn_back").addClass('back02');
	$(".btn_menu02").addClass('menu_wh');
	if(pageNumber == '1') {
		viewPage1 = '2';
		$(".btn_back").removeClass('back02');
		$(".btn_menu02").removeClass('menu_wh');
	}
	else if(pageNumber == '2') {
		viewPage2 = '3';
		$(".btn_back").removeClass('back02');
		$(".btn_menu02").removeClass('menu_wh');
	}
	else if(pageNumber == '3') {
		viewPage3 = '4';
		$(".btn_back").addClass('back02');
		$(".btn_menu02").addClass('menu_wh');
	}
	else if(pageNumber == '4') {
		viewPage4 = '5';
		$(".btn_back").addClass('back02');
		$(".btn_menu02").addClass('menu_wh');
	}
	else if(pageNumber == '5') {
		viewPage5 = '6';
		$(".btn_back").addClass('back02');
		$(".btn_menu02").addClass('menu_wh');
	}
	else if(pageNumber == '6') {
		viewPage6 = '7';
		$(".btn_back").addClass('back02');
		$(".btn_menu02").addClass('menu_wh');
	}
	else if(pageNumber == '7') {
		viewPage7 = '8';
		$(".btn_back").removeClass('back02');
		$(".btn_menu02").removeClass('menu_wh');
	}
});

// 중개사 회원 가입하기
$('.btn_type03').click(function(){
	//if(viewPage0 == '1' && viewPage1 == '2' && viewPage2 == '3' && viewPage3 == '4' && viewPage4 == '5' && viewPage5 == '6' && viewPage6 == '7' && viewPage7 == '8') {
		// 페이지 이동
		location.href = '/agent/joinAgent2';
	//}
	//else {
		//swal('모든 페이지를 차례로 다 보셔야 회원가입 진행이 가능합니다.');
		//return false;
	//}
});
</script>