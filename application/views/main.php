<section id="main_section">
  <div class="slide_box">
      <div class="m_sch_wrap">
      <form name="searchform" method="post" onsubmit="return false">
          <div class="m_text">
              <p>부동산 중개혁명!</p>
              <p class="p01">집 내놓을 때 중개수수료 <big>0원</big></p>
              <p class="p01">집 구할 때 중개수수료 <big>반값</big></p>
              <p >모두가 WinWin하는 <i class="f_yelloe">'다윈중개'</i></p>
          </div>
          <ul class="m_tab" id="main_searchtab">
              <li><a class="tab01 on" data-category="APT" data-placeholder="지역, 지하철역, 단지명을 입력해주세요."><span>아파트</span></a></li>
              <li><a class="tab02" data-category="OFT" data-placeholder="지역, 지하철역, 단지명을 입력해주세요."><span>오피스텔</span></a></li>
              <li><a class="tab03" data-category="ONE" data-placeholder="지역, 지하철역을 입력해주세요."><span>원룸/투룸</span></a></li>
          </ul>
          <div class="tabcon">
              
              <div class="inpout">
              	<input type="text" id="main_searchtab_keyword" placeholder="지역, 지하철역, 단지명을 입력해주세요." title="지역, 지하철역, 단지명을 입력해주세요." class="inp m_sch_inp" autocomplete="off">
              	<div class="btn_sch">
                	<button type="button" onclick="fnkeywordSearch"><span>검색</span></button>
              	</div>
                <!-- 3/28 검색어 삭제버튼 추가 -->
              	<button type="button" class="btn_del02" id="searchbtndel" onclick="searchKeywordDel()" style="display:none;">삭제</button>
              </div>
              
              <!-- 검색결과 영역 -->
              <div class="sch_result" id="search_result" style="display:none;">
                  <ul>
                      <li style="display:none;"><p class="sch_word">검색결과값이 없습니다.</p></li>
                  </ul>
              </div>
              <!-- //검색결과 영역 끝 --> 
          </div>
      </form>
      </div>
  </div>
</section>

<section id="sub_section">
  <div class="sec_box">
      <p class="sc_tit">낮은 중개수수료!</p>
      <p class="sc_dec">중개 효율화를 통해<br>
          중개수수료 거품을 확 낮췄습니다.</p>
      <p class="scdec_img"><img src="images/img_dec01.png" alt="중개수수료설명"></p>
      <p class="addt">거래 종류/매물 금액별로<br>
                      수수료율은 다르기에 확인해주세요.</p>
      <p class="addt">
          <button class="btn_line" onclick="goPage('/company/bkpee')">다윈중개 중개수수료요율표</button>
      </p>
  </div>
  <div class="sec_box">
      <p class="sc_tit">검증된 중개사!</p>
      <p class="sc_dec">실제 거래한 고객들을 통한 중개사 평가체계 구축,<br>
                      이제 전문성을 갖춘 검증된 중개사를<br>
                      선택할 수 있습니다.</p>
      <p class="scdec_img"><img src="images/img_dec02.png" alt="중개수수료설명"></p>
  </div>
  <div class="sec_box">
      <p class="sc_tit">허위 매물 제로!</p>
      <p class="sc_dec">다윈중개의 모든 매물은 집주인 본인이 직접 등록합니다.<br>
                      따라서 중개사들의 낚시성 허위매물이 없습니다.</p>
      <p class="scdec_img"><img src="images/img_dec03.png" alt="중개수수료설명"></p>
  </div>
</section>

<!-- 레이어팝업 -->
<div class="mask" id="grandOpenBack" onclick="grandOpenClose();" style="display:none;"></div>
<div class="ban_pop" id="grandOpenPopup" style="display:none;">
  	<div class="btn_close"><button type="button" class="" onclick="grandOpenClose();"><span>닫기</span></button></div>
  	<div class="ban_cont">다윈중개 grand open</div>
  	<div class="check_box">
    	<div class="check">
      		<label for="dshow">
        		<input type="checkbox" name="dshow" id="dshow" value="" onclick="grandOpenPopup();">
        		<i></i>
        		<strong>다시보지않기</strong>
      		</label>
    	</div>
  	</div> 
</div>

<script type="text/javascript">
// 스크립트 완성후 js파일로
var searching = null;
var search_category = 'APT';

//---------------------------------
// 그랜드 오픈 팝업
function grandEventPop()
{
    function getCookie(name)
    {
        var nameOfCookie = name + "=";
        var x = 0;
        while (x <= document.cookie.length){
            var y = (x + nameOfCookie.length);
            if (document.cookie.substring(x, y) == nameOfCookie){
            if ((endOfCookie = document.cookie.indexOf(";", y)) == -1){
            endOfCookie = document.cookie.length;
            }
            return unescape (document.cookie.substring(y, endOfCookie));
            }
            x = document.cookie.indexOf (" ", x) + 1;
            if (x == 0) break;
        }
        return "";
    }
    
    if(getCookie("popGrand") != "done")
    {
    	$('#grandOpenBack').show();
    	$('#grandOpenPopup').show();
    }
}

function setCookie(name, value, expiredays) {
    var todayDate = new Date();
        todayDate.setDate (todayDate.getDate() + expiredays);
        document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
}
 
function grandOpenPopup()
{
    setCookie("popGrand", "done", 365);   
    $('#grandOpenBack').hide();
	$('#grandOpenPopup').hide();
}

function grandOpenClose()
{   
    $('#grandOpenBack').hide();
	$('#grandOpenPopup').hide();
}

//---------------------------------

$("documnet").ready(function(){
	$("#main_searchtab li a").on("click", function(){
		if(openState == true)
		{
			// 오픈 알림창
			dawinOpenAlert();
			return;
		}
		$("#main_searchtab li a.on").removeClass("on");
		$(this).addClass("on");
		search_category = $(this).data('category');
		$("#main_searchtab_keyword").attr('placeholder', $(this).data('placeholder'));
		if( $("main_searchtab_keyword").val() != '' ) fnkeywordcall();
	});

	<?php if($PUSHKEY != '' && $DEVICE == 'AND') { ?>
	$('#main_searchtab_keyword').click(function(){
		fnMove();
	});
	<?php } ?>
	
	$("#main_searchtab_keyword").on("keyup", function(){	
		if(openState == true)
		{
			// 오픈 알림창
			dawinOpenAlert();
			return;
		}
		
		$('.btn_del02').show();
		if($("#main_searchtab_keyword").val() == '' ) {
			$("#search_result").hide();
			$('.btn_del02').hide();
			return;
		}
		
		if(searching) {
			clearTimeout(searching); console.log("cleared")
		}
		
		searching = setTimeout(function() { fnkeywordSearch(); }, 200);
	});

	// 그랜드오픈
	grandEventPop();
});

function fnMove() {
	var position = $('.m_text').offset().top;
	position = 200;
	$('#dawinWrap').animate({
		scrollTop: position
	}, 'slow');
}

// 검색어 삭제버튼 생성
function delicon() {
	var searchword = $('#main_searchtab_keyword').val();
	if(searchword != '') {
		$('.btn_del02').show();
	}
	else {
		$('.btn_del02').hide();
	}
}

function fnkeywordcall() {
	if(searching) { clearTimeout(searching); }
	fnkeywordSearch();
}

function fnkeywordSearch()
{
	var saletype= search_category ;
	var keywords = $("#main_searchtab_keyword").val();
	var time = new Date().getTime();
	if( keywords == '' ) {
		$("#search_result").hide();
		return;
	}
	
	$("#search_result").data('time', time );
	$.ajax({
		url: '/search',
		type: 'GET',
		data: {saletype:saletype, keywords:keywords} ,
		dataType: 'json',
		success: function (result) {
			load_template("#search_result",result.data, time);
		},
		error: function(request, status, error) {
			$("#search_result ul").empty().append('<li><p class="sch_word issearchclass">검색결과값이 없습니다.</p></li>');
		}
	});
}

function load_template(target, data, time)
{
    var ul = $(target + " ul");
    if($("#search_result").data('time') != String(time)) {
        console.log("passed");
        return false;
    }
    
    $(ul).empty();
    if(data == null || data=='' || data.length < 1) {
    	$(ul).append('<li><p class="sch_word issearchclass">검색결과값이 없습니다.</p></li>');
    }
    else
    {
    	$.each( data, function (idx, row) {
    		var title ='';
    		if(row.icontype == 'street') {
    			title = row.addr;
    		}
    		else if(row.icontype == 'station') {
    			title = row.title;
    		}
    		else {
    			title = row.addr+' '+ row.title;
    		}
    		var param = {keyword:title,sale_type:search_category,cpxidx:row.COMPLEX_IDX, lat:row.lat, lng:row.lng};
      		$(ul).append('<li><a href="/buyhome?' + $.param(param) + '" class="sch_word issearchclass"><i class="sch_ico ' + icontype(row.icontype) + '"></i> ' + row.title + ' <span class="address">' + row.addr + '</span></a></li>');
    	});
    }
    
    $(target).show();
}

//검색어 삭제
function searchKeywordDel() {
	$('#main_searchtab_keyword').val('');
	$('#search_result').hide();
	$('#searchbtndel').hide();
}
</script>
  