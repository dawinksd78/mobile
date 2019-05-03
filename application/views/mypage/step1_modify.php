<?php
$REG_TYPE = $step_1['REG_TYPE'];
$OWNER_CP = $step_1['OWNER_CP'];
$TRADE_TYPE = $step_1['TRADE_TYPE'];
$ONE_ROOM_TYPE = null;
$SIDO_CODE = null;
$SIGUNGU_CODE = null;
$DONG_CODE = $step_1['LAW_DONG_CODE'];
$CATEGORY = $step_1['CATEGORY'];
$COMPLEX_IDX = null;
$DONG = null;
$FLOOR = $step_1['FLOOR'];
$HO = $step_1['HO'];
$AREA1 = null;
$AREA2 = $step_1['AREA2'];
$SPACE_IDX = $step_1['SPACE_IDX'];
$TOTAL_FLOOR = $step_1['TOTAL_FLOOR'];
$LAW_ADDR1 = $step_1['LAW_ADDR1'];
$LAW_ADDR2 = $step_1['LAW_ADDR2'];
$LAT = $step_1['LAT'];
$LNG = $step_1['LNG'];

if($CATEGORY == 'OFT' || $CATEGORY == 'ONE') {
    $ONE_ROOM_TYPE = $step_1['ROOM_TYPE'];
}

if($CATEGORY == 'APT' || $CATEGORY == 'OFT')
{
    $SIDO_CODE = $step_1['LAW_SIDO_CODE'];
    $SIGUNGU_CODE = $step_1['LAW_SIGUNGU_CODE'];
    $COMPLEX_IDX = $step_1['COMPLEX_IDX'];
    $DONG = $step_1['DONG'];
    $AREA1 = $step_1['AREA1'];
    $AREA_SELECTED = $step_1['SPACE_IDX'];
}
?>

<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">집내놓기</h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
    <form onSubmit="return false;" id="step1form">
        <div class="sub_container">            
            <div class="cont_wrap join_wrap sellitm">
                <h2 class="subj_tit"><span class="m_tit">개인 및 매물정보 입력</span></h2>
                
                <div class="proc">
                	<a href="/mypage/step1_modify/<?php echo $step_1['GOODS_IDX']; ?>" class="bul_proc on"></a><a href="/mypage/step2_modify/<?php echo $step_1['GOODS_IDX']; ?>" class="bul_proc"></a><a href="/mypage/step3_modify/<?php echo $step_1['GOODS_IDX']; ?>" class="bul_proc"></a><a href="/mypage/step4_modify/<?php echo $step_1['GOODS_IDX']; ?>" class="bul_proc"></a>
                </div>
                
                <div class="cont">
                    <div class="info_gp">개인정보</div>
                    <p class="m_exp">안전한 거래를 위하여 매도(임대)안 확인 절차를 거치고 있습니다. 본인 또는 세입자가 아닌 제3자가 등록할 경우, 등록이 거부됩니다.</p>
                    
                    <div class="inpbox">
                        <label for="seller_name" class="lbl">이름</label>
                        <input type="text" name="seller_name" id="seller_name" placeholder="이름 자동입력" title="이름 자동입력" class="inp readinp" autocomplete="off" value="<?php echo $this->userinfo['MBR_NAME']; ?>" readonly>
                    </div>
                    
                    <div class="inpbox" id="insertInfoArea1">
                        <div class="radio_box">
                            <div class="radio">
                                <label for="relat01">
                                    <input type="radio" name="REG_TYPE" id="REG_TYPE01" value="1" onclick="ownertenantcheck('1')" <?php if($step_1['REG_TYPE'] == '1') echo 'checked=""'; ?>>
                                    <i></i><strong><label for="REG_TYPE01">본인(집주인)</label></strong>
                                </label>
                            </div>
                            <div class="radio">
                                <label for="relat02">
                                    <input type="radio" name="REG_TYPE" id="REG_TYPE02" value="2" onclick="ownertenantcheck('2')" <?php if($step_1['REG_TYPE'] == '2') echo 'checked=""'; ?>>
                                    <i></i><strong><label for="REG_TYPE02">세입자</label></strong>
                                </label>
                            </div>
                        </div>
                        <p class="add_text">* 본인 또는 세입자 이외의 대리인(법정대리인포함)은 집내놓기 신청이 불가합니다.</p>
                    </div>
                    
                    <div class="inpbox" id="ownerPhoneInput" style="display:<?php if($step_1['REG_TYPE'] == '1') echo "none"; ?>;">
                        <label for="host_phone" class="lbl">집주인연락처(세입자일 경우)</label>
                        <input type="tell" name="OWNER_CP" id="OWNER_CP" value="<?php echo ((isset($step_1['REG_TYPE']) && ($step_1['REG_TYPE'] == '2') && isset($step_1['OWNER_CP']))) ? $step_1['OWNER_CP'] : ""; ?>" placeholder="집주인연락처입력" title="집주인연락처입력" class="inp" autocomplete="off">
                        <p class="add_text">* 집주인이 매물등록을 동의하였는지 확인하기 위해 필요합니다.</p>
                    </div>
                    
                    
                    <div class="info_gp">매물기본정보</div>
                    <div class="inpbox rdinp">
                        <label for="itm_type01" class="lbl">매물종류</label>
                        <div class="radio_box02">
                            <div class="rd01 rd02">
                                <input type="radio" name="CATEGORY" id="CATEGORY01" value="APT" onclick="cateSelFn('APT')" <?php if($CATEGORY=='APT') echo 'checked=""'; ?>>
                                <label for="CATEGORY01">아파트</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" name="CATEGORY" id="CATEGORY02" value="OFT" onclick="cateSelFn('OFT')" <?php if($CATEGORY=='OFT') echo 'checked=""'; ?>>
                                <label for="CATEGORY02">오피스텔</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" name="CATEGORY" id="CATEGORY03" value="ONE" onclick="cateSelFn('ONE')" <?php if($CATEGORY=='ONE') echo 'checked=""'; ?>>
                                <label for="CATEGORY03">원룸/투룸</label>
                            </div>
                        </div>
                        <p class="add_text">* 다세대, 다가구의 경우 '원룸/투룸'을 선택해주세요.</p>
                    </div>
                    
                    <div id="insertInfoArea2">
    					<!-- 아파트 & 오피스텔 주소 검색 -->
    					<div id="category_apt_officetel_addr" style="display:;"></div>
                      	
                      	<!-- 원룸 주소 및 방구조 -->
                      	<div id="category_oneroom_addr_roomtype" style="display:none;"></div>
                      	
                      	<!-- 오피스텔 및 원룸인 경우 추가 (S) -->
                        <div class="inpbox rdinp" id="category_oftone_roomtypeview" style="display:none;">
    						<label for="r_str" class="lbl">방구조</label>
                            <div class="radio_box02 rdbmulti" id="roomStructureArr"></div>
                        </div>
                        <!-- 오피스텔 및 원룸인 경우 추가 (E) -->
                                            
                        <div class="inpbox rdinp">
                            <label for="itm_type02" class="lbl">매물유형</label>
                            <div class="radio_box02">
                                <div class="rd01 rd02">
                                    <input type="radio" id="TRADE_TYPE01" name="TRADE_TYPE" value="1" <?php echo (!isset($TRADE_TYPE) ||  $TRADE_TYPE == 1) ? 'checked=""':''; ?> onclick="tradeType('1')">
                                    <label for="TRADE_TYPE01">매매</label>
                                </div>
                                <div class="rd01 rd02">
                                    <input type="radio" id="TRADE_TYPE02" name="TRADE_TYPE" value="2" <?php echo (isset($TRADE_TYPE) &&  $TRADE_TYPE == 2) ? 'checked=""':''; ?> onclick="tradeType('2')">
                                    <label for="TRADE_TYPE02">전세</label>
                                </div>
                                <div class="rd01 rd02">
                                    <input type="radio" id="TRADE_TYPE03" name="TRADE_TYPE" value="3" <?php echo (isset($TRADE_TYPE) &&  $TRADE_TYPE == 3) ? 'checked=""':''; ?> onclick="tradeType('3')">
                                    <label for="TRADE_TYPE03">월세</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 매매인 경우 -->
                        <div class="inpbox" id="sellTypeDealing" style="display:none;"></div>
                        
                        <!-- 전세인 경우 -->
                        <div class="inpbox" id="sellTypeLease" style="display:none;"></div>
                        
                        <!-- 월세인 경우 -->
                        <div class="inpbox" id="sellTypeMonth" style="display:none;"></div>
                    </div>
				</div>
				
                <div class="modi_btn"><button class="btn_line03 btn_next" type="button" onclick="goPage('/mypage/step2_modify/<?php echo $step_1['GOODS_IDX']; ?>')">다음</button></div>
			</div>
                
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" onclick="sellstep1MdfProc()">수정완료</button>
            </div>
		</div>
		<input type="hidden" value="<?php echo $step_1['GOODS_IDX']; ?>" name="idx" id="idx">
	</form>
    </section>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none"></div>
    <div class="lyr lyrpop01" style="display:none"> <a href="" class="close">닫기</a>
        <div class="lyr_inner">
            <p class="cont">해당지역은 현재 서비스 지역이 아닙니다.<br><strong>추후 해당 지역 오픈 시 연락을 원하시면</strong><br>이름과 전화번호를 남겨주세요.</p>
            <div class="inpbox">
                <div class="selecout">
                    <select id="" title="지역선택" class="selec">
                        <option value="1">서울</option>
                        <option value="2">경기도</option>
                        <option value="3">강원도</option>
                    </select>
                </div>
                <div class="inpout">
                    <input type="text" id="u_name" placeholder="이름을 입력하세요." title="이름을 입력하세요." class="inp" autocomplete="off">
                </div>
                <div class="inpout">
                    <input type="tel" id="u_phone" placeholder="휴대폰번호를 입력하세요." title="휴대폰번호를 입력하세요." class="inp" autocomplete="off">
                </div>
            </div>
        </div>
        
        <div class="btn">
            <button type="button" class="btn_type02">확인</button>
        </div>
    </div>
	
	<!-- 다음 주소 API 보기 -->
	<div class="daumpostmask" style="display:none;" onmousedown="closeDaumPostcode()"></div>
	<div class="daumpostclose" style="display:none;" onclick="closeDaumPostcode()"><img src="/images/btn_close.png"></div>
    <div class="daumpostlayer" id="daumpostlayer" style="display:none;"></div>
</div>

<script type="text/javascript">
var roomType 			= "<?php echo $ONE_ROOM_TYPE; ?>";
var getSidoCode 		= "<?php echo $SIDO_CODE; ?>";
var getGugunCode 		= "<?php echo $SIGUNGU_CODE; ?>";
var getDongCode 		= "<?php echo $DONG_CODE; ?>";
var getDangiCode 		= "<?php echo $COMPLEX_IDX; ?>";
var getDangiDongCode 	= "<?php echo $DONG; ?>";
var getFloorCode 		= "<?php echo $FLOOR; ?>";
var getFloorDongCode 	= "<?php echo $HO; ?>";
var getFloorDongHoCode 	= "<?php echo $AREA1; ?>";

//page point
var pagePoint = '';

//변경사항 저장여부 체크
var datachanged = false;

// 본인 및 세입자 체크
function ownertenantcheck(regtype)
{
	if(regtype == '2') {
		$('#ownerPhoneInput').css('display', 'block');
	}
	else {
		$('#ownerPhoneInput').css('display', 'none');
	}
}

// 방구조 값
function roomTypeVal()
{
	var roomStructureView = "";

	$.ajax({ 
		url:"/sellhome/roomStructurePrint",
     	type: "POST", 
     	dataType: "json",
     	async: false,
     	success: function(data) {
     		for(var i = 0, len = data.length; i < len; ++i)
         	{
     		   	roomStructureView += '<div class="rd01 rd02">';
     		   	if(roomType == data[i].val) {
     		   		roomStructureView += '<input type="radio" name="ROOM_TYPE" id="ROOM_TYPE' + data[i].number + '" value="' + data[i].val + '" checked>';
     		   	} else {
     		   		roomStructureView += '<input type="radio" name="ROOM_TYPE" id="ROOM_TYPE' + data[i].number + '" value="' + data[i].val + '">';
     		   	}
     		   	roomStructureView += '<label for="ROOM_TYPE' + data[i].number + '">' + data[i].name + '</label>';
     		   	roomStructureView += '</div>';
     		}
     	}
	});

	return roomStructureView;
}

// 매물 종류 선택
function cateTypeSel(type, point)
{
	var roomview = '';
	
	// 원룸인 경우
	if(type == 'ONE')
	{
		var addr = "/tpl/sellhome_step1_oneroom.tpl?_=";
		$("#category_apt_officetel_addr").html('');
		$('#category_apt_officetel_addr').css('display', 'none');
		$('#category_oneroom_addr_roomtype').css('display', 'block');

		$('#category_oftone_roomtypeview').css('display', 'block');
		roomview = roomTypeVal();
	}
	// 아파트 & 오피스텔
	else
	{
		var addr = "/tpl/sellhome_step1_aptofficetel.tpl?_=";
		$("#category_oneroom_addr_roomtype").html('');
		$('#category_oneroom_addr_roomtype').css('display', 'none');
		$('#category_apt_officetel_addr').css('display', 'block');

		if(type == 'OFT') {
			$('#category_oftone_roomtypeview').css('display', 'block');
			roomview = roomTypeVal();
		}
		else {
			$('#category_oftone_roomtypeview').css('display', 'none');
			roomview = "";
		}
	}

	pagePoint = point;
	
	$.ajax({
		url: addr + new Date().getTime(),
		method: 'GET',
		dataType: 'html',
		async: false,
		success: function(data) {
			if(type == 'ONE')
			{
				$("#category_oneroom_addr_roomtype").html(data);
				$("#roomStructureArr").html(roomview);
			}
			else
			{
				$("#category_apt_officetel_addr").html(data);
				if(type == 'OFT') {
					$("#roomStructureArr").html(roomview);
					$('#addrTitle').text('오피스텔');
				}
				else {
					$('#addrTitle').text('아파트');
				}
				
				// 시,도 출력
				sidoListPrint(point);
			}
			$("#PRICE1").val('');
			$("#PRICE2").val('');
			$("#PRICE3").val('');
		}
	});
}

// 매물유형
function tradeType(type)
{
	// 매매폼
	var tradeform1 = '<label for="sell_price" class="lbl">매매희망가</label><div class="inptxt" style="display:"><input type="number" name="PRICE1" id="PRICE1" placeholder="매매희망가(숫자만)" title="매매희망가(숫자만)" class="inp" autocomplete="off" data-span="#trade01" onkeyUp="priceKRup(this)"><span class="unit">만원</span></div><p class="kr" id="trade01">만원</p>';

	// 전세폼
	var tradeform2 = '<label for="sell_price" class="lbl">전세희망가</label><div class="inptxt" style="display:"><input type="number" name="PRICE2" id="PRICE2" placeholder="전세보증금(숫자만)" title="전세보증금(숫자만)" class="inp" autocomplete="off" data-span="#trade02" onkeyUp="priceKRup(this)"><span class="unit">만원</span></div><p class="kr" id="trade02">만원</p>';

	// 월세폼
	var tradeform3 = '<label for="sell_price" class="lbl">월세희망가</label><div class="inptxt" style="display:"><input type="number" name="PRICE2" id="PRICE2" placeholder="월세보증금(숫자만)" title="월세보증금(숫자만)" class="inp" autocomplete="off" data-span="#trade03" onkeyUp="priceKRup(this)"><span class="unit">만원</span></div><p class="kr" id="trade03">만원</p><div class="inptxt" style="display:inptxt"><input type="number" name="PRICE3" id="PRICE3" placeholder="월세(숫자만)" title="월세(숫자만)" class="inp" autocomplete="off" data-span="#trade04" onkeyUp="priceKRup(this)"><span class="unit">만원</span></div><p class="kr" id="trade04">만원</p>';

	// 매매
	if(type == '1')
	{
		$('#sellTypeDealing').css('display', 'block');
		$('#sellTypeLease').css('display', 'none');
		$('#sellTypeMonth').css('display', 'none');

		$("#TRADE_TYPE01").prop("checked", true);
		$("#TRADE_TYPE02").prop("checked", false);
		$("#TRADE_TYPE03").prop("checked", false);

		$('#sellTypeDealing').html(tradeform1);
		$('#sellTypeLease').html('');
		$('#sellTypeMonth').html('');
	}
	// 전체
	else if(type == '2')
	{
		$('#sellTypeDealing').css('display', 'none');
		$('#sellTypeLease').css('display', 'block');
		$('#sellTypeMonth').css('display', 'none');

		$("#TRADE_TYPE01").prop("checked", false);
		$("#TRADE_TYPE02").prop("checked", true);
		$("#TRADE_TYPE03").prop("checked", false);

		$('#sellTypeDealing').html('');
		$('#sellTypeLease').html(tradeform2);
		$('#sellTypeMonth').html('');
	}
	// 월세
	else if(type == '3')
	{
		$('#sellTypeDealing').css('display', 'none');
		$('#sellTypeLease').css('display', 'none');
		$('#sellTypeMonth').css('display', 'block');

		$("#TRADE_TYPE01").prop("checked", false);
		$("#TRADE_TYPE02").prop("checked", false);
		$("#TRADE_TYPE03").prop("checked", true);

		$('#sellTypeDealing').html('');
		$('#sellTypeLease').html('');
		$('#sellTypeMonth').html(tradeform3);
	}
}

//--------------------------------------------------------------------------------//

// 시도리스트 출력
function sidoListPrint(point)
{
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/board/search_sido", 
     	data: "", 
     	success: function(data) {
     		var html1 = '';    		
     		for(var i = 0, len = data.length; i < len; ++i) {
				if(point == 'selval' && getSidoCode == data[i].sido_code) {
     		    	html1 += '<option value="' + data[i].sido_code + '" selected>' + data[i].sido + '</option>';
				}
				else {
					html1 += '<option value="' + data[i].sido_code + '">' + data[i].sido + '</option>';
				}
     		}
     		$('#SIDO_CODE').append(html1); 
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR1');
     	} 
	});
}

// 구군 리스트 가져오기
function gugunListPrint(sido)
{
	$('#SIGUNGU_CODE').children().remove().end().append('<option value="">구/군선택</option>') ;
	$('#DONG_CODE').children().remove().end().append('<option value="">읍/면/동선택</option>') ;
	$('#COMPLEX_IDX').children().remove().end().append('<option value="">단지선택</option>') ;
	$('#DONG_PREV').children().remove().end().append('<option value="">동선택</option>') ;
	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>') ;
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>') ;
	$('#AREA1').children().remove().end().append('<option value="">면적정보선택</option>') ;

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
				if(pagePoint == 'selval' && getGugunCode == data[i].gugun_code) {
     		    	html2 += '<option value="' + data[i].gugun_code + '" selected>' + data[i].gugun + '</option>';
				} else {
     		   		html2 += '<option value="' + data[i].gugun_code + '">' + data[i].gugun + '</option>';
				}
     		}
     		$('#SIGUNGU_CODE').append(html2); 
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR2');
     	} 
	});
}

// 읍면동 리스트 가져오기
function dongListPrint(gugun)
{
	$('#DONG_CODE').children().remove().end().append('<option value="">읍/면/동선택</option>') ;
	$('#COMPLEX_IDX').children().remove().end().append('<option value="">단지선택</option>') ;
	$('#DONG_PREV').children().remove().end().append('<option value="">동선택</option>') ;
	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>') ;
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>') ;
	$('#AREA1').children().remove().end().append('<option value="">면적정보선택</option>') ;

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
				if(pagePoint == 'selval' && getDongCode == data[i].dong_code+'00') {
     		    	html3 += '<option value="' + data[i].dong_code + '00" selected>' + data[i].dong + '</option>';
				} else {
					html3 += '<option value="' + data[i].dong_code + '00">' + data[i].dong + '</option>';
				}
     		}
     		$('#DONG_CODE').append(html3); 
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR3');
     	} 
	});
}

// 단지 리스트 가져오기
function dangiListPrint(dong)
{
	var category = $(":input:radio[name=CATEGORY]:checked").val();

	$('#COMPLEX_IDX').children().remove().end().append('<option value="">단지선택</option>') ;
	$('#DONG_PREV').children().remove().end().append('<option value="">동선택</option>') ;
	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>') ;
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>') ;
	$('#AREA1').children().remove().end().append('<option value="">면적정보선택</option>') ;

	// 전송할 데이터
 	var sendData = "&dong=" + dong + "&category=" + category;
 
	// 검색된 단지 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangi_search", 
     	data: sendData, 
     	success: function(data) {
     		var html4 = '';    		
     		for(var i = 0, len = data.length; i < len; ++i) {
				if(pagePoint == 'selval' && getDangiCode == data[i].com_idx) {
     		    	html4 += '<option value="' + data[i].com_idx + '" selected>' + data[i].com_name + '</option>';
				} else {
					html4 += '<option value="' + data[i].com_idx + '">' + data[i].com_name + '</option>';
				}
     		}
     		$('#COMPLEX_IDX').append(html4); 
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR4');
     	} 
	});
}

// 단지 -> 동검색 리스트 가져오기
function dangiDongListPrint(comidx)
{
	var category = $(":input:radio[name=CATEGORY]:checked").val();

	$('#DONG_PREV').children().remove().end().append('<option value="">동선택</option>') ;
	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>') ;
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>') ;
	$('#AREA1').children().remove().end().append('<option value="">면적정보선택</option>') ;

	// 좌표값 입력
	mapCoordinate(comidx);

	// 전송할 데이터
 	var sendData = "&comidx=" + comidx + "&category=" + category;
 
	// 검색된 동 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangidong_search", 
     	data: sendData, 
     	success: function(data) {
	     	// 검색된 동 출력
     		var html5 = '';

	     	// 동 검색시 건수가 있으면 select box로
     		if(data.length > 0)
     		{
     			$('#DONG_PREV').css('display', 'block');
     			$('#DONG_PREV').attr('disabled', false);
     			$('#DONG_NEW_INPUT_FORM').css('display', 'none');
     			    		
         		for(var i = 0, len = data.length; i < len; ++i)
             	{
    				if(pagePoint == 'selval' && getDangiDongCode == data[i].bildName) {
         		    	html5 += '<option data-id="' + data[i].dongNo + '" value="' + data[i].bildName + '" selected>' + data[i].bildName + '동</option>';
         		    	//$('#dongNm').val(data[i].dongNo);
         		    	//floorListPrint();
    				}
    				else {
    					html5 += '<option data-id="' + data[i].dongNo + '" value="' + data[i].bildName + '">' + data[i].bildName + '동</option>';
    				}
         		}
         		
         		$('#DONG_PREV').append(html5);
         		$('#DONG_NEW').attr('disabled', true);

         		//--------------------------------------//

         		// 층
         		$('#FLOOR_FORM1').css('display', 'block');
     			$('#FLOOR_PREV').attr('disabled', false);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', false);

     			$('#FLOOR_FORM2').css('display', 'none');
     			//$('#FLOOR_FORM2').val('');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', true);
     			$('#FLOOR_NEW').attr('disabled', true);

				// 호
     			$('#HO_PREV').css('display', 'block');
     			$('#HO_PREV').attr('disabled', false);
     			$('#HO_NEW').css('display', 'none');
     			$('#HO_NEW_UNIT').css('display', 'none');
     			$('#HO_NEW').attr('disabled', true);

     			// 검색된 면적 출력
         		//floorDongHoListPrint();
     		}
     		// 동 검색시 건수가 없으면 text box로
     		else
     		{
         		// select 차단
     			$('#DONG_PREV').css('display', 'none');
     			$('#DONG_PREV').attr('disabled', true);

     			// input 사용
     			$('#DONG_NEW_INPUT_FORM').css('display', 'block');
     			$('#DONG_NEW').attr('disabled', false);

     			//--------------------------------------//

     			// 층
     			$('#FLOOR_FORM1').css('display', 'none');
     			$('#FLOOR_PREV').attr('disabled', true);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', true);

     			$('#FLOOR_FORM2').css('display', 'block');
     			$('#FLOOR_FORM2').val('');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', false);
     			$('#FLOOR_NEW').attr('disabled', false);

     			// 호
     			$('#HO_PREV').css('display', 'none');
     			$('#HO_PREV').attr('disabled', true);
     			$('#HO_NEW').css('display', 'block');
     			$('#HO_NEW_UNIT').css('display', 'block');
     			$('#HO_NEW').attr('disabled', false);

     			//--------------------------------------//

     			// 정보 입력
     			$('#DONG_NEW').val('<?php echo $DONG; ?>');
     			$('#TOTAL_FLOOR_NEW').val('<?php echo $TOTAL_FLOOR; ?>');
     			$('#FLOOR_NEW').val('<?php echo $FLOOR; ?>');
     			$('#HO_NEW').val('<?php echo $HO; ?>');
     		} 

     		// 검색된 면적 출력
     		floorDongHoListPrint();
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR5');
     	} 
	});
}

// 단지 -> 동 -> 층검색 리스트 가져오기
function floorListPrint(obj)
{
	var comidx = $("select[name=COMPLEX_IDX]").val();
	var category = $(":input:radio[name=CATEGORY]:checked").val();
	
	
	if(obj == '' || obj == 'undefined') {
		var dongNo = $('#dongNm').val();
		var dong = '<?php echo $DONG; ?>';
	}
	else {
		var dongNo = $(obj).find('option:selected').data('id');
		var dong = $(obj).val();
	}

	// 전송할 데이터
 	var sendData = "&comidx=" + comidx + "&category=" + category + "&dong=" + dong + "&dongNo=" + dongNo;

 	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>');
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>');
 
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangidongfloor_search", 
     	data: sendData, 
     	success: function(data) {
     		var html6 = '';
     		var tmpsvfloor = '';

	     	// 층 정보가 있는 경우 select box    		
     		if(data.length > 0)
     		{
     			$('#FLOOR_FORM1').css('display', 'block');
     			$('#FLOOR_PREV').attr('disabled', false);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', false);

     			$('#FLOOR_FORM2').css('display', 'none');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', true);
     			$('#FLOOR_NEW').attr('disabled', true);
     			    		
         		for(var i = 0, len = data.length; i < len; ++i)
             	{
    				//if(getFloorCode == data[i].floor) {
         		    	//html6 += '<option value="' + data[i].floor + '" selected>' + data[i].floor + '층</option>';
    				//}
    				//else {
    					html6 += '<option data-supplyarea="' + data[i].supplyArea + '" value="' + data[i].floor + '">' + data[i].floor + '층</option>';
    				//}
    
    				if(i == len - 1) {
    					tmpsvfloor = data[i].floor;
         		    }
         		}

         		// 전체층
         		$('input[name=TOTAL_FLOOR]').val(tmpsvfloor);
         		
         		$('#FLOOR_PREV').append(html6);
         		 
         		// 호
     			$('#HO_PREV').css('display', 'block');
     			$('#HO_PREV').attr('disabled', false);
     			$('#HO_NEW').css('display', 'none');
     			$('#HO_NEW_UNIT').css('display', 'none');
     			$('#HO_NEW').attr('disabled', true);
     		}
	     	// 층 정보가 없는 경우 input box
     		else
     		{
     			$('#FLOOR_FORM1').css('display', 'none');
     			$('#FLOOR_PREV').attr('disabled', true);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', true);

     			$('#FLOOR_FORM2').css('display', 'block');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', false);
     			$('#FLOOR_NEW').attr('disabled', false);

     			// 호
     			$('#HO_PREV').css('display', 'none');
     			$('#HO_PREV').attr('disabled', true);
     			$('#HO_NEW').css('display', 'block');
     			$('#HO_NEW_UNIT').css('display', 'block');
     			$('#HO_NEW').attr('disabled', false);

     			//--------------------------------------//

     			// 정보 입력
     			$('#TOTAL_FLOOR_NEW').val('<?php echo $TOTAL_FLOOR; ?>');
     			$('#FLOOR_NEW').val('<?php echo $FLOOR; ?>');
     			$('#HO_NEW').val('<?php echo $HO; ?>');
     		}
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR6');
     	} 
	});
}

//단지 -> 동 -> 층검색 리스트 가져오기 (수정용)
function floorListPrint1(obj)
{
	var comidx = $("select[name=COMPLEX_IDX]").val();
	var category = $(":input:radio[name=CATEGORY]:checked").val();

	<?php if($CATEGORY != '') { ?>
		<?php if($CATEGORY == 'APT' || $CATEGORY == 'OFT') { ?>
			var dongNo = '<?php echo $step_1['SPACE_IDX']; ?>';
			var dong = '<?php echo ($DONG) ? $DONG : $step_1['DONG']; ?>';
		<?php } ?>
	<?php } else { ?>
		var dongNo = $(obj).find('option:selected').data('id');
		var dong = $(obj).val();
	<?php } ?>

	// 전송할 데이터
 	var sendData = "&comidx=" + comidx + "&category=" + category + "&dong=" + dong + "&dongNo=" + dongNo;

 	$('#FLOOR_PREV').children().remove().end().append('<option value="">층선택</option>');
	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>');
 
	// 층 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangidongfloor_search", 
     	data: sendData, 
     	success: function(data) {
     		var html6 = '';
     		var tmpsvfloor = '';

     		// 층 정보가 있는 경우 select box    		
     		if(data.length > 0)
     		{     			
     			$('#FLOOR_FORM1').css('display', 'block');
     			$('#FLOOR_PREV').attr('disabled', false);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', false);

     			$('#FLOOR_FORM2').css('display', 'none');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', true);
     			$('#FLOOR_NEW').attr('disabled', true);
         		
         		for(var i = 0, len = data.length; i < len; ++i)
             	{
    				if(pagePoint == 'selval' && getFloorCode == data[i].floor) {
         		    	html6 += '<option data-supplyarea="' + data[i].supplyArea + '" value="' + data[i].floor + '" selected>' + data[i].floor + '층</option>';
    				}
    				else {
    					html6 += '<option data-supplyarea="' + data[i].supplyArea + '" value="' + data[i].floor + '">' + data[i].floor + '층</option>';
    				}
    
    				if(i == len - 1) {
    					tmpsvfloor = data[i].floor;
         		    }
         		}

         		// 전체층
         		$('input[name=TOTAL_FLOOR]').val(tmpsvfloor);
         		
         		$('#FLOOR_PREV').append(html6); 

         		// 호
     			$('#HO_PREV').css('display', 'block');
     			$('#HO_PREV').attr('disabled', false);
     			$('#HO_NEW').css('display', 'none');
     			$('#HO_NEW_UNIT').css('display', 'none');
     			$('#HO_NEW').attr('disabled', true);
     		}
	     	// 층 정보가 없는 경우 input box
     		else
     		{
     			$('#FLOOR_FORM1').css('display', 'none');
     			$('#FLOOR_PREV').attr('disabled', true);
     			$('#TOTAL_FLOOR_PREV').attr('disabled', true);

     			$('#FLOOR_FORM2').css('display', 'block');
     			$('#TOTAL_FLOOR_NEW').attr('disabled', false);
     			$('#FLOOR_NEW').attr('disabled', false);

     			// 호
     			$('#HO_PREV').css('display', 'none');
     			$('#HO_PREV').attr('disabled', true);
     			$('#HO_NEW').css('display', 'block');
     			$('#HO_NEW_UNIT').css('display', 'block');
     			$('#HO_NEW').attr('disabled', false);
     		}
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR6');
     	} 
	});
}

// 단지 -> 동 -> 층 -> 호 검색 리스트 가져오기
function floorDongListPrint(floor)
{
	var dongNo = $('#DONG_PREV').find('option:selected').data('id');
	var comidx = $("select[name=COMPLEX_IDX]").val();

	$('#HO_PREV').children().remove().end().append('<option value="">호선택</option>');

	// dongNm 저장
	$('#dongNm').val(dongNo);

	// 전송할 데이터
 	var sendData = "&comidx=" + comidx + "&floor=" + floor + "&dongNo=" + dongNo;
 
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangidongfloorho_search", 
     	data: sendData, 
     	success: function(data) {
     		var html7 = '';

     		// 호 선택 select box
     		if(data.length > 0)
     		{
     			$('#HO_PREV').css('display', 'block');
     			$('#HO_PREV').attr('disabled', false);
     			$('#HO_NEW').css('display', 'none');
     			$('#HO_NEW_UNIT').css('display', 'none');
     			$('#HO_NEW').attr('disabled', true);
     			
         		for(var i = 0, len = data.length; i < len; ++i)
             	{
         			if(pagePoint == 'selval' && getFloorDongCode == data[i].ho) {
             		    html7 += '<option data-supplyarea="' + data[i].supplyArea + '" value="' + data[i].ho + '" selected>' + data[i].ho + '호</option>';
         		    }
         		    else {
         		    	html7 += '<option data-supplyarea="' + data[i].supplyArea + '" value="' + data[i].ho + '">' + data[i].ho + '호</option>';
         		    }
         		}
         		$('#HO_PREV').append(html7);
     		}
     		// 호 선택 input box
     		else
     		{
     			$('#HO_PREV').css('display', 'none');
     			$('#HO_PREV').attr('disabled', true);
     			$('#HO_NEW').css('display', 'block');
     			$('#HO_NEW_UNIT').css('display', 'block');
     			$('#HO_NEW').attr('disabled', false);

     			//--------------------------------------//

     			// 정보 입력
     			$('#HO_NEW').val('<?php echo $HO; ?>');
     		}  
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR7');
     	} 
	});
}

//호 선택시 면적 자동 선택
function hoSelAreaAutoSel(obj) {
	var area = $(obj).find('option:selected').data('supplyarea');
	if(area != 'undefined' && area != '') {
		floorDongHoListPrint(area);
	}
}

// 단지 -> 동 -> 층 -> 호 -> 면적 검색 리스트 가져오기
function floorDongHoListPrint(ho)
{
	var comidx = $("select[name=COMPLEX_IDX]").val();
	var category = $(":input:radio[name=CATEGORY]:checked").val();

	// 전송할 데이터
 	var sendData = "&comidx=" + comidx + "&category=" + category;

 	$('#AREA1').children().remove().end().append('<option value="">면적정보 선택</option>');
 
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/dangidongfloorhoarea_search", 
     	data: sendData, 
     	success: function(data) {
     		var html8 = '';
     		for(var i = 0, len = data.length; i < len; ++i)
         	{
     			var select = null;
             	if(len == 1) {
             		select = "selected";

             		// AREA_SELECTED 저장
             		$('#AREA2').val(data[i].exclusiveArea);
             		$('#AREA_SELECTED').val(data[i].idx);
             	}
             	else if(pagePoint == 'selval' && getFloorDongHoCode == data[i].supplyArea) {
             		select = "selected";
             		// AREA_SELECTED 저장
             		$('#AREA2').val(data[i].exclusiveArea);
             		$('#AREA_SELECTED').val(data[i].idx);
     		    }
             	else if(pagePoint == 'selval' && ho == data[i].supplyArea) {
             		select = "selected";
             	    // AREA_SELECTED 저장
             		$('#AREA2').val(data[i].exclusiveArea);
             		$('#AREA_SELECTED').val(data[i].idx);
     		    }
     		    else {
     		    	select = "";
     		    }

     		    if(isNaN(data[i].areaName) == true) {
         		    var areaNames = " - " + data[i].areaName + "형";
     		    }
     		    else {
     		    	var areaNames = "";
     		    }
     		    
     		    /*if(getFloorDongHoCode == data[i].supplyArea) {
         		    html8 += '<option data-no="' + data[i].idx + '" data-excl="' + data[i].exclusiveArea + '" value="' + data[i].supplyArea + '" selected>' + data[i].supplyArea + '㎡  (' + data[i].pyeong + '평) - ' + data[i].areaName + '형</option>';
     		    }
     		    else {
     		    	html8 += '<option data-no="' + data[i].idx + '" data-excl="' + data[i].exclusiveArea + '" value="' + data[i].supplyArea + '">' + data[i].supplyArea + '㎡  (' + data[i].pyeong + '평) - ' + data[i].areaName + '형</option>';
     		    }*/
     		   html8 += '<option data-no="' + data[i].idx + '" data-excl="' + data[i].exclusiveArea + '" value="' + data[i].supplyArea + '" ' + select + '>' + data[i].supplyArea + '㎡ (' + data[i].pyeong + '평)' + areaNames + '</option>';
     		}
     		$('#AREA1').append(html8);
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR8');
     	} 
	});
}

//아파트, 오피스텔 area2 저장
function aptOftArea2Print(obj)
{	
	var no = $(obj).find('option:selected').data('no');
	var excl = $(obj).find('option:selected').data('excl');
	
	$('#AREA2').val(excl);

	// AREA_SELECTED 저장
	$('#AREA_SELECTED').val(no);
}

<?php if($AREA2 != '') { ?>
$('#AREA2').val('<?php echo $AREA2; ?>');
<?php } ?>

//--------------------------------------------------------------------------------//

//### 기본값 출력 ###//

// 매물종류
cateTypeSel('<?php echo $CATEGORY; ?>', 'selval');
tradeType('<?php echo $TRADE_TYPE; ?>');

// 주소 출력
<?php if($CATEGORY == 'APT' || $CATEGORY == 'OFT') { ?>
	gugunListPrint('<?php echo $SIDO_CODE; ?>');
	dongListPrint('<?php echo $SIGUNGU_CODE; ?>');
	dangiListPrint('<?php echo $DONG_CODE; ?>');
	dangiDongListPrint('<?php echo $COMPLEX_IDX; ?>');

	<?php if($step_1['SPACE_IDX'] != '') { ?>
    	floorListPrint1('<?php echo $DONG; ?>');
    	floorDongListPrint('<?php echo $FLOOR; ?>');
    	floorDongHoListPrint('<?php echo $HO; ?>');
    	$('#TOTAL_FLOOR_PREV').val('<?php echo $TOTAL_FLOOR; ?>');
    	$('#FLOOR_NEW').val('<?php echo $FLOOR; ?>');
    	$('#HO_NEW').val('<?php echo $HO; ?>');
    <?php } else { ?>
		// 동
		$('#DONG_NEW_INPUT_FORM').attr('disabled', false);
		$('#DONG_NEW').val('<?php echo $DONG; ?>');
	
    	// 층
    	$('#FLOOR_FORM1').css('display', 'none');
    	$('#FLOOR_PREV').attr('disabled', true);
    	$('#TOTAL_FLOOR_PREV').attr('disabled', true);
    
    	$('#FLOOR_FORM2').css('display', 'block');
    	$('#TOTAL_FLOOR_NEW').attr('disabled', false);
    	$('#FLOOR_NEW').attr('disabled', false);
    
    	// 호
    	$('#HO_PREV').css('display', 'none');
    	$('#HO_PREV').attr('disabled', true);
    	$('#HO_NEW').css('display', 'block');
    	$('#HO_NEW_UNIT').css('display', 'block');
    	$('#HO_NEW').attr('disabled', false);
    	
    	$('#FLOOR_NEW').val('<?php echo $FLOOR; ?>');
    	$('#HO_NEW').val('<?php echo $HO; ?>');
    <?php } ?>
    $('#TOTAL_FLOOR_NEW').val('<?php echo $TOTAL_FLOOR; ?>');
	$('#AREA2').val('<?php echo $AREA2; ?>');
	$('#AREA_SELECTED').val('<?php echo $AREA_SELECTED; ?>');
<?php } else if($CATEGORY == 'ONE') { ?>
    $('#addr').val('<?php echo $LAW_ADDR1; ?>');
    $('#addrDetail').val('<?php echo $LAW_ADDR2; ?>');
    $('#TOTAL_FLOOR').val('<?php echo $TOTAL_FLOOR; ?>');
    $('#FLOOR').val('<?php echo $FLOOR; ?>');
    $('#HO').val('<?php echo $HO; ?>');
    $('#AREA2').val('<?php echo $AREA2; ?>');
    $('#LAWDONG').val('<?php echo $DONG_CODE; ?>');
    $('#addr_LAT').val('<?php echo $LAT; ?>');
    $('#addr_LNG').val('<?php echo $LNG; ?>');
<?php } ?>

<?php if($TRADE_TYPE == '1') { ?>
	$('#PRICE1').val('<?php echo $step_1['PRICE1']; ?>');
	$('#trade01').text(number2Hangeul(""+$('#PRICE1').val()*10000));
<?php } else if($TRADE_TYPE == '2') { ?>
	$('#PRICE2').val('<?php echo $step_1['PRICE2']; ?>');
	$('#trade02').text(number2Hangeul(""+$('#PRICE2').val()*10000));
<?php } else if($TRADE_TYPE == '3') { ?>
    $('#PRICE2').val('<?php echo $step_1['PRICE2']; ?>');
    $('#trade03').text(number2Hangeul(""+$('#PRICE2').val()*10000));
    $('#PRICE3').val('<?php echo $step_1['PRICE3']; ?>');
    $('#trade04').text(number2Hangeul(""+$('#PRICE3').val()*10000));
<?php } ?>

//--------------------------------------------------------------------------------//

// 좌표 체크
function mapCoordinate(comidx)
{
	// 전송할 데이터
 	var sendData = "&comidx=" + comidx;
 
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/map_position", 
     	data: sendData, 
     	success: function(data) {
     		var lat = data.lat;
     		var lng = data.lng;

     		$('#addr_LAT').val(lat);
     		$('#addr_LNG').val(lng);
     	},
     	error:function(data){ 
      		swal('AJAX ERROR');
     	}
	});	
}

// 위치 확인
function selectOfficeMapview()
{
	var comidx = $("select[name=COMPLEX_IDX]").val();

	if(!comidx) {
		swal('아파트 위치 정보를 입력하세요.');
		return false;
	}
	
	// 전송할 데이터
 	var sendData = "&comidx=" + comidx;
 
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/sellhome/map_position", 
     	data: sendData, 
     	success: function(data) {
     		var office = data.office_name;
     		var lat = data.lat;
     		var lng = data.lng;

     		$('#office_name').val(office);
     		$('#office_lat').val(lat);
     		$('#office_lng').val(lng);

     		officeposition();
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR');
     	} 
	});	
}

// 원룸 위치 확인
function oneroomPosition()
{
	$('#office_name').val($('#addr').val());
	$('#office_lat').val($('#addr_LAT').val());
	$('#office_lng').val($('#addr_LNG').val());

	// 지도출력
	officeposition();
}

function changePyeong(inp){
  	if( $(inp).val() <= 0) return;
  	$("#pyeongRes").text(parseInt($(inp).val() / 3.3058) + " 평형");
}
$("#pyeongRes").text(parseInt(<?php echo $AREA2; ?> / 3.3058) + " 평형");

var prevSelcate = $('input[type=radio][name="CATEGORY"]:checked').val();
function cateSelFn(val)
{	
    if(datachanged)
    {
    	swal({
    	    text: "입력사항을 저장하지 않고 변경하시겠습니까?",
    	    buttons: [
    	        '아니요',
    	        '네'
    	    ],
    	}).then(function(isConfirm) {
			if(isConfirm) {
				cateTypeSel(val, 'common');
				datachanged = false;	// 경고창 제거
				prevSelcate = val;
			}
			else {
				$('input:radio[name="CATEGORY"][value="'+prevSelcate+'"]').prop('checked', true);
				prevSelcate = prevSelcate;
			}
		});
    }
    else {
    	cateTypeSel(val, 'common');
    	prevSelcate = val;
	}
}

$("document").ready(function(){
	// 경고창 활성
	$("#insertInfoArea2").on("change keyup paste", function(){
		datachanged = true;	// 경고창 생성
	});
});

//--------------------------------------------------------------------------------//

// 저장하기
function sellstep1MdfProc()
{
	var REG_TYPE = $(":input:radio[name=REG_TYPE]:checked").val();
	if(!REG_TYPE) {
		swal('본인 및 세입자를 선택해 주세요.');
		return false;
	}

	var OWNER_CP = $("#OWNER_CP").val();
	if(REG_TYPE=='2' && !OWNER_CP) {
		swal('집주인 연락처를 입력해 주세요.');
		return false;
	}

	var CATEGORY = $(":input:radio[name=CATEGORY]:checked").val();
	if(!CATEGORY) {
		swal('매물 종류를 선택해 주세요.');
		return false;
	}

	if(CATEGORY == 'APT' || CATEGORY == 'OFT')
	{
		var SIDO_CODE = $("select[name=SIDO_CODE]").val();
		if(!SIDO_CODE) {
			swal('시/도를 선택해 주세요.');
			return false;
		}

		var SIGUNGU_CODE = $("select[name=SIGUNGU_CODE]").val();
		if(!SIGUNGU_CODE) {
			swal('구/군을 선택해 주세요.');
			return false;
		}

		var DONG_CODE = $("select[name=DONG_CODE]").val();
		if(!DONG_CODE) {
			swal('읍/면/동을 선택해 주세요.');
			return false;
		}

		var COMPLEX_IDX = $("select[name=COMPLEX_IDX]").val();
		if(!COMPLEX_IDX) {
			swal('단지를 선택해 주세요.');
			return false;
		}

		if($("#DONG_PREV").val() != '') {
			var DONG = $("#DONG_PREV").val();
		}
		else {
			var DONG = $("#DONG_NEW").val();
		}
		if(!DONG) {
			swal('동을 선택(입력)해 주세요.');
			return false;
		}

		if($("#FLOOR_PREV").val() != '') {
			var FLOOR = $("#FLOOR_PREV").val();
		}
		else {
			var FLOOR = $("#FLOOR_NEW").val();
		}
		if(!FLOOR) {
			swal('층을 선택(입력)해 주세요.');
			return false;
		}

		if($("#HO_PREV").val() != '') {
			var HO = $("#HO_PREV").val();
		}
		else {
			var HO = $("#HO_NEW").val();
		}
		if(!HO) {
			swal('호를 선택(입력)해 주세요.');
			return false;
		}

		var AREA1 = $("select[name=AREA1]").val();
		if(!AREA1) {
			swal('면적을 선택해 주세요.');
			return false;
		}

		if($("#TOTAL_FLOOR_PREV").val() != '') {
			var TOTAL_FLOOR = $("#TOTAL_FLOOR_PREV").val();
		}
		else {
			var TOTAL_FLOOR = $("#TOTAL_FLOOR_NEW").val();
		}
		var AREA2 = $("#AREA2").val();
		var dongNm = $("#dongNm").val();
		var AREA_SELECTED = $("#AREA_SELECTED").val();
	}

	if(CATEGORY == 'OFT')
	{
		var ROOM_TYPE = $(":input:radio[name=ROOM_TYPE]:checked").val();
		if(!ROOM_TYPE) {
			swal('방구조를 선택해 주세요.');
			return false;
		}
	}

	if(CATEGORY == 'ONE')
	{
		var LAW_ADDR1 = $("#addr").val();
		var LAW_DONG_CODE = $("#LAWDONG").val();
		if(!LAW_ADDR1) {
			swal('주소검색을 해 주세요. #1');
			return false;
		}

		var LAW_ADDR2 = $("#addrDetail").val();
		if(!LAW_ADDR2) {
			swal('상세주소를 입력해 주세요.');
			return false;
		}

		var TOTAL_FLOOR = $("#TOTAL_FLOOR").val();
		if(!TOTAL_FLOOR) {
			swal('전체층을 입력해 주세요.');
			return false;
		}

		var FLOOR = $("#FLOOR").val();
		if(!FLOOR) {
			swal('해당층을 입력해 주세요.');
			return false;
		}

		var HO = $("#HO").val();
		if(!HO) {
			swal('호수를 입력해 주세요.');
			return false;
		}

		var AREA2 = $("#AREA2").val();
		if(!AREA2) {
			swal('전용면적을 입력해 주세요.');
			return false;
		}

		var ROOM_TYPE = $(":input:radio[name=ROOM_TYPE]:checked").val();
		if(!ROOM_TYPE) {
			swal('방구조를 선택해 주세요.');
			return false;
		}
	}

	var LAT = $("#addr_LAT").val();
	if(!LAT) {
		swal('주소를 검색해 주세요. #2');
		return false;
	}
	
	var LNG = $("#addr_LNG").val();
	if(!LNG) {
		swal('주소를 검색해 주세요. #3');
		return false;
	}

	var TRADE_TYPE = $(":input:radio[name=TRADE_TYPE]:checked").val();
	if(!TRADE_TYPE) {
		swal('매물유형을 선택해 주세요.');
		return false;
	}

	// 매매선택
	if(TRADE_TYPE == '1')
	{
		var PRICE1 = $("#PRICE1").val();
		if(!PRICE1) {
			swal('매매희망가를 입력해 주세요.');
			return false;
		}
	}

	// 전세선택
	if(TRADE_TYPE == '2')
	{
		var PRICE2 = $("#PRICE2").val();
		if(!PRICE2) {
			swal('전세보증금을 입력해 주세요.');
			return false;
		}
	}

	// 월세선택
	if(TRADE_TYPE == '3')
	{
		var PRICE2 = $("#PRICE2").val();
		if(!PRICE2) {
			swal('월세보증금을 입력해 주세요.');
			return false;
		}

		var PRICE3 = $("#PRICE3").val();
		if(!PRICE3) {
			swal('월세를 입력해 주세요.');
			return false;
		}
	}
	
	// 전송할 데이터
 	var sendData = "&idx=" + $("#idx").val() + "&REG_TYPE=" + REG_TYPE + "&OWNER_CP=" + OWNER_CP + "&CATEGORY=" + CATEGORY + "&SIDO_CODE=" + SIDO_CODE  
 					+ "&SIGUNGU_CODE=" + SIGUNGU_CODE + "&DONG_CODE=" + DONG_CODE + "&COMPLEX_IDX=" + COMPLEX_IDX 
 					+ "&DONG=" + DONG + "&FLOOR=" + FLOOR + "&AREA1=" + AREA1 + "&LAW_ADDR1=" + LAW_ADDR1 + "&LAW_DONG_CODE=" + LAW_DONG_CODE 
 					+ "&LAT=" + LAT + "&LNG=" + LNG + "&LAW_ADDR2=" + LAW_ADDR2 + "&TOTAL_FLOOR=" + TOTAL_FLOOR + "&FLOOR=" + FLOOR 
 					+ "&ROOM_TYPE=" + ROOM_TYPE + "&HO=" + HO + "&AREA2=" + AREA2 + "&TRADE_TYPE=" + TRADE_TYPE + "&PRICE1=" + PRICE1
 					+ "&PRICE2=" + PRICE2 + "&PRICE3=" + PRICE3 + "&dongNm=" + dongNm + "&AREA_SELECTED=" + AREA_SELECTED;

 	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/mypage/step1_modify_save", 
     	data: sendData, 
     	success: function(result) {
     		if(result.code == 200) {
         		swal({
      			  	title: "변경완료!",
      			  	text: "변경하신 내용을 저장 하였습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				location.href = "/mypage/myhousesale";
      			});
         	}
         	else {
         		swal('저장에 실패하였습니다. 다시 확인하여 주십시요.');
         	}
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR');
     	} 
	});
}
</script>