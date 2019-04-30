<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a835b66d59703e60522fdeb1da106a8f&libraries=services,clusterer"></script>

<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">중개사회원가입</h2>
    </header>
    
    <section id="container">
        <?php
        $attributes = array('method'=>'post','id'=>'joinagentform','onsubmit'=>'return confirmNext()'); //'onkeypress'=>'return event.keyCode != 13'
        echo form_open('/member/joinAgent4',$attributes);
        ?>
        <div class="sub_container">
            <div class="cont_wrap join_wrap joinbk">
                <h2 class="subj_tit"><span class="m_tit">중개사무소 정보</span></h2>
                <div class="proc"> <a href="" class="bul_proc prev"></a><a href="" class="bul_proc on"></a><a href="" class="bul_proc"></a><a href="" class="bul_proc"></a></div>
                <p class="m_exp">입력하신 정보를 토대로 승인여부가 결정되니 정확한 정보를 입력해주세요.</p>
                <div class="cont">
                    <div class="inpbox sch_inpbox">
                        <div class="sch_area">
                            <label for="off_name" class="lbl">중개사무소명</label>
                            <select name="sido" id="sido" title="시/도선택" class="selec">
                                <option value="">시/도선택</option>
                                <option value="">---------------------------------</option>
                            </select>
                            <div class="flt">
                                <select name="gugun" id="gugun" title="시/도/구선택" class="selec">
                                    <option value="">시/도/구선택</option>
                                    <option value="">---------------------------------</option>
                                </select>
                                <select name="dong" id="dong" title="읍/면/동선택" class="selec">
                                    <option value="">읍/면/동선택</option>
                                    <option value="">---------------------------------</option>
                                </select>
                            </div>
                            <div class="sch_box">
                                <input type="text" name="broker_search" id="broker_search" onkeyup="if (window.event.keyCode == 13) { brokerOfficeSearch(); }" onkeypress="return event.keyCode != 13" placeholder="중개사 검색" title="" class="inp" autocomplete="off">
                                <div class="btn_sch">
                                    <button type="button" onclick="brokerOfficeSearch()"><span>검색</span></button>
                                </div>
                            </div>
                            
                            <!-- 검색결과 영역 -->
                            <div class="sch_result" style="display:none;">
                                <ul id="sch_result_list"></ul>
                            </div>
                            <!-- // 검색결과 영역 끝 -->
                            
                            <!-- p class="add_text">* 중개사무소 이름 또는 전화번호('-' 추가)로 검색가능</p -->
                            <div class="sle_bk"></div>
                        </div>
                    </div>
                    
                    <div class="inpbox rdinp">
                        <label for="busi_type" class="lbl">사업자종류</label>
                        <div class="radio_box02">
                            <div class="rd01">
                                <input type="radio" id="rd01" name="licensee" value="individual" checked>
                                <label for="rd01">개인</label>
                            </div>
                            <div class="rd01">
                                <input type="radio" id="rd02" name="licensee" value="corporate">
                                <label for="rd02">법인</label>
                            </div>
                        </div>
                        <p class="add_text">* 법인의 경우 분사무소는 별도로 회원가입을 해야합니다.</p>
                    </div>
                    
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">사업자등록증</label>
                        <div class="btn_file_wrap">
                            <label for="file_upload">+ 파일업로드</label>
                            <input type="file" class="btn_file_pic" name="licensecard" id="licensecard">
                            <!-- 첨부된 파일위치 -->
						    <!-- span class="add_pic"><img src="../images/img_item.png" alt=""></span> <a href="" class="btn_del01"></a> --> 
                        </div>
                        <p class="add_text">* 1MB이하의 jpg, png 파일로 업로드해주세요.</p>
                    </div>
                    
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">개설등록증</label>
                        <div class="btn_file_wrap"> 
                            <label for="file_upload">+ 파일업로드</label>
						    <input type="file" class="btn_file_pic" name="opencard" id="opencard"> 
                            <!-- 첨부된 파일위치 --> 
                            <!-- span class="add_pic"><img src="../../images/img_item.png" alt=""></span> <a href="" class="btn_del01"></a -->
                        </div>
                        <p class="add_text">* 1MB이하의 jpg, png 파일로 업로드해주세요.</p>
                    </div>
                    
                    <div class="inpbox inpbn">
                        <label for="u_pass" class="lbl">중개사무소 주소</label>
                        <input type="text" name="office_addr" id="office_addr" placeholder="중개사무소주소 자동입력" title="중개사무소주소 자동입력" class="inp readinp" autocomplete="off" readonly>
                        <div class="btn">
                            <button class="btn_line04" type="button" onclick="officeposition()">위치확인하기</button>
                        </div>
                    </div>
                    
                    <div class="inpbox inpbn">
                        <label for="u_pass" class="lbl">중개사무소 전화번호</label>
                        <input type="tell" name="office_phone" id="office_phone" placeholder="중개사무소전화번호 입력" title="중개사무소전화번호 입력" class="inp" autocomplete="off" onfocus="OnCheckPhone(this)" onKeyup="OnCheckPhone(this)">
                    </div>
                </div>
            </div>
            <div class="btn_area bot_btn double">
                <button class="btn_type03" type="button" onclick="history.back();">이전</button>
                <button class="btn_type02" type="submit">다음</button>
            </div>
        </div>
        
        <!-- 중개사 선택 -->
    	<input type="hidden" name="brokerofficeidx" id="brokerofficeidx">
    	<input type="hidden" name="office_name" id="office_name">
    	<input type="hidden" name="office_lat" id="office_lat">
    	<input type="hidden" name="office_lng" id="office_lng">
    	<?php echo form_close(); ?>
    </section>
        
    <!-- 다음 지도 API 보기 -->
    <div class="apiMapMask" style="display:none;" onmousedown="mapClose()"></div>
   	<div class="apiMapClose" style="display:none;" onclick="mapClose()"><img src="/images/btn_close.png"></div>
	<div class="apiMap" id="apiMap" style="display:none;"></div>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none;" onmousedown="mapClose()"></div><!-- 배경 -->
    <div class="lyr lyrpop01" style="display:none;">
        <div class="lyr_inner">
            <p class="cont">해당지역은 서비스지역이 아닙니다.<br>
                가입신청은 가능하며, <strong>해당 지역 오픈 시<br>
                우선적으로 활동이</strong> 가능합니다.</p>
        </div>
        <div class="btn">
            <button class="btn_type02" type="button" onclick="layerClose()">확인</button>
        </div>
    </div>
</div>

<script type="text/javascript">
//시도 리스트 가져오기
$(document).ready(function(){
    $.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/search_sido", 
    	data: "", 
    	success: function(data) {
    		var html1 = '';    		
    		for(var i = 0, len = data.length; i < len; ++i) {
    		    html1 += '<option value="' + data[i].sido_code + '">' + data[i].sido + '</option>';
    		}
    		$('#sido').append(html1); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR1');
    	} 
    });
}); 

//구군 리스트 가져오기
$('#sido').on('change', function() {
	var sido = this.value;

	$('#gugun').children().remove().end().append('<option value="">시/도선택</option><option value="">---------------------------------</option>') ;

	// 전송할 데이터
    var sendData = "&sido=" + sido;
    
	// 시도 리스트 가져오기
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/search_gugun", 
    	data: sendData, 
    	success: function(data) {
    		var html2 = '';    		
    		for(var i = 0, len = data.length; i < len; ++i) {
    		    html2 += '<option value="' + data[i].gugun_code + '">' + data[i].gugun + '</option>';
    		}
    		$('#gugun').append(html2); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR2');
    	} 
   	});
});

//읍면동 리스트 가져오기
$('#gugun').on('change', function() {
	var gugun = this.value;

	$('#dong').children().remove().end().append('<option value="">읍/면/동선택</option><option value="">---------------------------------</option>') ;

	// 전송할 데이터
    var sendData = "&gugun=" + gugun;
    
	// 시도 리스트 가져오기
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/search_dong", 
    	data: sendData, 
    	success: function(data) {
    		var html3 = '';    		
    		for(var i = 0, len = data.length; i < len; ++i) {
    		    html3 += '<option value="' + data[i].dong_code + '">' + data[i].dong + '</option>';
    		}
    		$('#dong').append(html3); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR3');
    	} 
   	});
});

//--------------------------------------------------------------//

//직접검색 검색어 입력
function brokerOfficeSearch()
{
	var broker_search = $("#broker_search").val();
	var sido = $("#sido option:selected").val();
	var gugun = $("#gugun option:selected").val();
	var dong = $("#dong option:selected").val();

	$('.sch_result').css('display', 'block');
	$('#sch_result_list').children().remove().end();

	// 전송할 데이터
 	var sendData = "&broker_search=" + encodeURIComponent(broker_search) + "&sido=" + sido + "&gugun=" + gugun + "&dong=" + dong;

	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/board/brokerofficejoinsearch", 
     	data: sendData, 
     	success: function(data) {
     		var ulli = '', i = 0, len = data.length;
     		if(parseInt(len) > 0)
     		{    		
         		for(i = 0; i < len; ++i) {
         			ulli += "<li><a href=\"javascript:selectBrokerOffice('" + data[i].office_idx + "', '" + data[i].office_name + "', '" + data[i].broker_name + "', '" + data[i].office_addr + "', '" + data[i].office_lat + "', '" + data[i].office_lng + "')\" class=\"sch_word\">'" + data[i].office_name + "' <span class=\"address\">'" + data[i].office_addr + "'(" + data[i].broker_name + ")</span></a></li>";
         		}
     		}
     		else
     		{
     			ulli += '<li onkeydown="brokerdisplaynone()"><p class="sch_word">검색결과값이 없습니다.<br><b>최근 개설등록한 중개사무소의 경우</b> 2~3일 후<br>다시 회원가입을 시도해 주세요.</p></li>';
     		}
     		$('#sch_result_list').append(ulli); 
     	}, 
     	error:function(data){ 
     		$('#sch_result_list').append('<li onmousedown="brokerdisplaynone()"><p class="sch_word">검색결과값이 없습니다.<br><strong>최근 개설등록한 중개사무소의 경우</strong> 2~3일 후<br>다시 회원가입을 시도해 주세요.</p></li>');
     	}
	});
	return false;
}

// 중개소 선택
function selectBrokerOffice(idx, office, broker, office_addr, lat, lng)
{
	$('.sle_bk').children().remove().end();
	$('.sle_bk').css('display', 'block');
	$('.sle_bk').append('<span class="" id="sbo' + idx + '">' + office + ' (' + broker + ') <a href="javascript:selectBrokerOfficeDel()" class="del01">삭제</a></span>');
	$('.sch_result').css('display', 'none');
	$('#sch_result_list').children().remove().end();
	$('#brokerofficeidx').val(idx);
	$('#office_name').val(office);
	$('#office_addr').val(office_addr);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);
}

// 중개소 삭제
function selectBrokerOfficeDel() {
	$('#brokerofficeidx').val('');
	$('#office_addr').val('');
	$('#office_lat').val('');
	$('#office_lng').val('');
	$('.sle_bk').children().remove().end();
}

// 중개소 결과창 제거
function brokerdisplaynone() {
	$('.sch_result').css('display', 'none');
	$('#sch_result_list').children().remove().end();
}

// 레이어창 닫기
function layerClose() {
	$('.mask').css('display', 'none');
	$('.lyr').css('display', 'none');
}

//--------------------------------------------------------------//

// 다음페이지 이동
function confirmNext()
{
	if($('#brokerofficeidx').val() == '') {
		swal('중개사를 선택해 주세요.');
		return false;
	}

	if($('#office_phone').val() == '') {
		swal('중개사무소 전화번호를 입력해 주세요.');
		return false;
	}

	$('#joinagentform').sumbit();
}
</script>