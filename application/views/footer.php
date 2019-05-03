<?php
if(!empty($this->userinfo['MBR_ID'])) {
    $reportbroker = "/board/reportbroker";
}
else {
    $reportbroker = "/mypage/login";
}
?>   	
        <footer id="footer">
            <div class="footer_inner">
              	<ul class="cm_link">
                    <li class=""><a href="javascript:void(0);" onclick="goPage('/company/companyintro')">회사소개</a></li>
                    <li class=""><a href="javascript:void(0);" onclick="swal('채용 문의는 cs@dawin.xyz로 해주세요.')">채용문의</a></li>
                    <li class=""><a href="javascript:void(0);" onclick="goPage('/company/terms')">서비스이용약관</a></li>
                    <li class=""><a href="javascript:void(0);" onclick="goPage('/company/privacy')">개인정보처리방침</a></li>
              	</ul>

              	<ul class="cm_info02">
                    <li class="cminfo_ltm01">(주)다윈소프트</li>
                    <li class="cminfo_ltm02">경기 성남시 분당구 성남대로 170 한국프라자 6층</li>
                    <li class="cminfo_ltm02">개인정보보호책임자 : 김석환</li>
                    <li class="cminfo_ltm02">사업자등록번호 : 293-87-00980</li>
                    <li class="cminfo_ltm02">통신판매신고번호 : 2018-성남분당A-0331</li>                      
                </ul>
                
              	<ul class="cm_info01">  
                  	<li><b>고객센터</b> 1544-6075 (오전9시 ~ 오후6시)</li>
                  	<li><b>E-mail</b> cs@dawin.xyz</li>
              	</ul>                  
              	<div class="btn_area">
                  	<button class="btn_help" onclick="goPage('/board/faq')">도움말</button>
                  	<button class="btn_bkreport" onclick="goPage('<?php echo $reportbroker; ?>')">중개사신고하기</button>
                </div>
            	<div class="btn_area02">
                  	<button class="btn_pee" onclick="goPage('/company/bkpee')">다윈중개 중개수수료요율표</button>
              	</div>
            	<ul class="cm_info01"><li>Copyrightⓒ Dawinsoft. All Rights Reserved.</li></ul>
            </div>
        </footer>
    </div>

</div>
  
<!-- 중개사 다음 지도 API 보기 -->
<input type="hidden" name="office_name" id="office_name">
<input type="hidden" name="office_lat" id="office_lat">
<input type="hidden" name="office_lng" id="office_lng">
<div class="apiMapMask" style="display:none;" onmousedown="mapClose()"></div>
<div class="apiMapClose" style="display:none;" onclick="mapClose()"><img src="/images/btn_close.png"></div>
<div class="apiMap" id="apiMap" style="display:none;"></div>

<!-- Page Loading -->
<div id="ajax_loader"></div>

<script type=text/javascript>
$(document).ready(function(){
	$("#dawinWrap").on('scroll', function(){
	    var scrollValue = $(this).scrollTop();
	    if(scrollValue > 55) {
        	//$(".header").addClass("change");
	    	$(".header").css("background","#7a1d05");
        }
        else {
        	//$(".header").removeClass("change");
        	$(".header").css("background","none"); 
		}
	});
});
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134936659-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-134936659-2');
</script>

</body>
</html>