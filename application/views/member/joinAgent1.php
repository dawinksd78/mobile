<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="dawinWrap" class="mainwrap">
    <header id="header" class="">
    	<span class="btn_back back02">
        	<button type="button"><span class="">뒤로</span></button>
        </span>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <ul class="j_slide">
                <!-- 첫번째 페이지 -->
                <li class="s_jabg sjabg01" id="intro1" onclick="pageShow('2')" style="display:">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">부동산 중개의<br>
                            대변화에 올라타세요!</p>
                        <p class="ja_tit02">온라인상에 중개사무실을 개설하세요.<br>
                            수많은 고객들이 알아서 찾아옵니다.</p>
                    </div>
                </li>
                
                <!-- 두번째 페이지 -->
                <li class="s_jabg sjabg02" id="intro2" onclick="pageShow('3')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">중개 매물 확보<br>
                            걱정 No!</p>
                        <p class="ja_tit02">매도인(임대인)은<br>
                            중개수수료가 무료이기에<br>
                            언제나 중개매물이 넘쳐나고,<br>
                            중개사무실 기준 반경 10km 이내의<br>
                            모든 매물을 중개하실 수 있습니다.<br>
                            매물확보 걱정마시고<br>
                            중개에만 집중하세요.</p>
                    </div>
                </li>
                
                <!-- 세번째 페이지 -->
                <li class="s_jabg sjabg03" id="intro3" onclick="pageShow('4')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">매수인, 임차인 확보<br>
                            걱정 No!</p>
                        <p class="ja_tit02">다윈에서 다양한 광고를 통해<br>
                            매수인, 임차인을 확보해드립니다.<br>
                            중개사님은 중개 서비스 향상에만<br>
                            집중하세요.</p>
                    </div>
                </li>
                
                <!-- 네번째 페이지 -->
                <li class="s_jabg sjabg04" id="intro4" onclick="pageShow('5')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">광고비<br>
                            걱정 No!</p>
                        <p class="ja_tit02">매물확보와 매수인 확보를 위한<br>
                            모든 광고는 다윈에서 해드립니다.<br>
                            더이상 광고비 지출하지 마세요.</p>
                    </div>
                </li>
                
                <!-- 다섯번째 페이지 -->
                <li class="s_jabg sjabg05" id="intro5" onclick="pageShow('6')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">임대료<br>
                            걱정 No!</p>
                        <p class="ja_tit02">더이상 비싼 임대료를 내가며<br>
                            1층 상가에 있을 필요가 없습니다.<br>
                            매물확보에서 매수인, 임차인 확보,<br>
                            모든 중개업무까지 <br>
                            책상 하나만 있으면 O.K.<br>
                            컴퓨터와 휴대폰만으로 완벽한 업무를<br>
                            처리할 수 있도록 지원해드립니다.</p>
                    </div>
                </li>
                
                <!-- 여섯번째 페이지 -->
                <li class="s_jabg sjabg06" id="intro6" onclick="pageShow('7')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">완벽한<br>
                            IT 지원 시스템!</p>
                        <p class="ja_tit02">매물확보에서 매수인(임차인)확보,<br>
                            매물관리, 고객관리, 계약서 작성까지<br>
                            중개에 필요한 모든 업무를<br>
                            하나의 시스템에서 해결.<br>
                            노트북과 휴대폰만 있으면 언제 어디서나<br>
                            중개업무 완벽 해결</p>
                    </div>
                </li>
                
                <!-- 일곱번째 페이지 -->
                <li class="s_jabg sjabg07" id="intro7" onclick="pageShow('8')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">이제 저비용 고효율<br>
                            중개의 시대로</p>
                        <p class="ja_tit02">다윈의 중개 수수료는<br>
                            기존 중개수수료의 1/2 수준입니다.<br>
                            그러나 임대료, 광고비 등의 비용절감과<br>
                            IT 기반의 고효율 중개업무를 통해<br>
                            수익성은 더 좋아집니다.</p>
                    </div>
                </li>
                
                <!-- 여덟번째 페이지 -->
                <li class="s_jabg sjabg08" id="intro8" onclick="pageShow('1')" style="display:none">
                    <div class="jatit_wrap">
                        <p class="ja_tit01">다윈<br>
                            중개 프로세스</p>
                        <p class="ja_tit02 jaimg"><img src="../../images/img_dec04.png" alt="다윈 중개 프로세스"></p>
                    </div>
                </li>
            </ul>
            <div class="bul_area">
            	<a href="#" id="introbtn1" onclick="pageShow('1')" class="on"></a>
            	<a href="#" id="introbtn2" onclick="pageShow('2')" class=""></a>
            	<a href="#" id="introbtn3" onclick="pageShow('3')" class=""></a>
            	<a href="#" id="introbtn4" onclick="pageShow('4')" class=""></a>
            	<a href="#" id="introbtn5" onclick="pageShow('5')" class=""></a>
            	<a href="#" id="introbtn6" onclick="pageShow('6')" class=""></a>
            	<a href="#" id="introbtn7" onclick="pageShow('7')" class=""></a>
            	<a href="#" id="introbtn8" onclick="pageShow('8')" class=""></a>
            </div>
        </div>
        
        <div class="btn_area bot_btn"> 
            <!-- 7개의 슬라이드를 모두 확인했을 경우 on 클래스 추가-->
            <button type="button" class="btn_type03">중개사 회원 가입하기</button>
        </div>
    </section>
</div>

<script type="text/javascript">
var prevPage, viewPage1, viewPage2, viewPage3, viewPage4, viewPage5, viewPage6, viewPage7, viewPage8;

// 페이지 넘겨보기
function pageShow(num)
{
	$("#introbtn"+prevPage).removeClass('on');
	$("#introbtn"+num).addClass('on');

	if(num > prevPage) {
		$("#intro"+prevPage).hide("slide", { direction: "left" }, 500);
		$("#intro"+num).show("slide", { direction: "right" }, 500);
	}
	else {
		$("#intro"+prevPage).hide("slide", { direction: "right" }, 500);
		$("#intro"+num).show("slide", { direction: "left" }, 500);
	}

	prevPage = num;

	if(num == '1') viewPage1 = '1';
	else if(num == '2') viewPage2 = '2';
	else if(num == '3') viewPage3 = '3';
	else if(num == '4') viewPage4 = '4';
	else if(num == '5') viewPage5 = '5';
	else if(num == '6') viewPage6 = '6';
	else if(num == '7') viewPage7 = '7';
	else if(num == '8') viewPage8 = '8';

	if(viewPage1 == '1' && viewPage2 == '2' && viewPage3 == '3' && viewPage4 == '4' && viewPage5 == '5' && viewPage6 == '6' && viewPage7 == '7' && viewPage8 == '8') {
		$(".btn_type03").addClass('on');
	}
}
pageShow('1');

// 중개사 회원 가입하기
$('.btn_type03').click(function(){
	if(viewPage1 == '1' && viewPage2 == '2' && viewPage3 == '3' && viewPage4 == '4' && viewPage5 == '5' && viewPage6 == '6' && viewPage7 == '7' && viewPage8 == '8') {
		// 페이지 이동
		location.href = '/member/joinAgent2';
	}
	else {
		swal('모든 페이지를 차례로 다 보셔야 회원가입 진행이 가능합니다.');
		return false;
	}
});
</script>