<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">중개사신고하기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <?php
            $attributes = array('method'=>'post','id'=>'reportform');
            echo form_open('/board/reportbrokerprocess',$attributes);
            ?>
                <div class="cont_wrap public_cont reportbk">              
                    <p class="m_exp">신고할 내용을 선택해주세요.</p>
                    <div class="cont">
                        <div class="selarea">
                            <div class="radio_box">
                                <div class="radio">
                                    <label for="relat01">
                                        <input type="radio" name="agree" id="relat01" value="Y">
                                        <i></i><strong>선택한 중개사 중 선택</strong>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="relat02">
                                        <input type="radio" name="agree" id="relat02" value="N">
                                        <i></i><strong>직접검색</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                                            
                        <!-- 중개사 선택 후 -->
                        <?php
                        if($brokerinfo != '')
                        {
                            if(!empty($brokerinfo['BROKER_OFFICE_IDX']))
                            {
                                $display = "block";
                                
                                $broker_idx = $brokerinfo['BROKER_OFFICE_IDX'];
                                $broker_office = $brokerinfo['OFFICE_NAME'];
                                $broker_point = $brokerinfo['BROKER_POINT'];
                                $broker_point_cnt = number_format($brokerinfo['BROKER_POINT_CNT']);
                                $broker_phone = $brokerinfo['PHONE'];
                                $broker_lat = $brokerinfo['LAT'];
                                $broker_lng = $brokerinfo['LNG'];
                                $broker_name = $brokerinfo['MBR_NAME'];
                                
                                // 이미지 출력
                                if($brokerinfo['BIZ_LICENSE_IMG'] != '' || !empty($brokerinfo['BIZ_LICENSE_IMG'])) {
                                    $thumnail = $brokerinfo['BIZ_LICENSE_IMG'];
                                }
                                else {
                                    $thumnail = "/images/btn_camera.png";
                                }
                                
                                // 평점 이미지 출력
                                $avgpercent = $brokerinfo['BROKER_POINT'] / 5 * 100;
                            }
                            else
                            {
                                $display = "none";
                                
                                $broker_idx = "";
                                $broker_office = "";
                                $broker_point = "";
                                $broker_point_cnt = "";
                                $broker_phone = "";                            
                                $broker_lat = "";
                                $broker_lng = "";
                                $thumnail = "";
                                $avgpercent = "";
                                $broker_name = "";
                            }
                        ?>
                        <div class="sch_area" style="display:<?php echo $display; ?>;">
                            <div class="agent_lst"> <a onclick="selectBrokerOfficeAutoDel('<?php echo $broker_idx; ?>')" class="del02" style="z-index:10000;">삭제</a>
                                <div class="itm_inner">
                                    <div class="thumbnail_area">
                                        <div class="thumbnail"><img src="<?php echo $thumnail; ?>" alt="중개사사진" /></div>
                                    </div>
                                    <span class="agent_info">
                                        <div class="broker_info">
                                            <p class="commtype"><?php echo $broker_office; ?> <i class="btn_loc" style="z-index:1000;" onclick="selmapview('<?php echo $broker_office; ?>', '<?php echo $broker_lat; ?>', '<?php echo $broker_lng; ?>')"></i></p>
                                            <p class="bk_name"><?php echo $broker_name; ?></p>
                                            <div class="star_score"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $broker_point; ?></span></span> <span href="" class="ct_review">(<?php echo $broker_point_cnt; ?>)</span>  </div>
                                            <span class="p_num"><?php echo $broker_phone; ?></span>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- // 중개사 선택 후 끝 -->
                        
                        <!-- 중개사 직접 검색한 경우 -->
                        <div class="sch_area2" style="display:none;">
                            <select name="sido" id="sido" title="시/도선택" class="selec">
                              <option value="">시/도선택</option>
                            </select>
                            <div class="flt">
                              <select name="gugun" id="gugun" title="시/도/구선택" class="selec">
                                <option value="">시/도/구선택</option>
                              </select>
                              <select name="dong" id="dong" title="읍/면/동선택" class="selec">
                                <option value="">읍/면/동선택</option>
                              </select>
                            </div>
                            <div class="sch_box">
                              <input type="text" name="broker_search" id="broker_search" onkeyup="brokerOfficeSearch();" onkeydown="brokerOfficeSearch();" placeholder="신고할 중개사 검색" title="" class="inp" autocomplete="off">
                              <div class="btn_sch"><button type="button" onclick="brokerOfficeSearch()"><span>검색</span></button></div>
                              <button type="button" class="btn_del02 inpdel" onclick="selectBrokerOfficeDel()" style="display:none;">삭제</button>
                              <div class="sle_bk" style="display:none;"></div>
                            </div>
                            
                            <!-- 검색결과 영역 -->
                            <div class="sch_result" style="display:none;">
                                <ul id="sch_result_list"></ul>
                            </div>
                            <!-- // 검색결과 영역 끝 -->
                        </div>
                        <!-- // 중개사 직접 검색한 경우 끝-->
                        
                        <div class="selec_option">
                            <div class="radio_box">
                                <div class="radio">
                                    <label for="rept01">
                                        <input type="radio" name="rept" id="rept01" value="CI1">
                                        <i></i><strong>휴폐업/행정처분 기간 중 영업한 경우</strong> </label>
                                </div>
                                <div class="radio">
                                    <label for="rept02">
                                        <input type="radio" name="rept" id="rept02" value="CI2">
                                        <i></i><strong>다윈중개에서 제시한 중개보수 이외 초과보수를 요구한 경우</strong> </label>
                                </div>
                                <div class="radio">
                                    <label for="rept03">
                                        <input type="radio" name="rept" id="rept03" value="CI3">
                                        <i></i><strong>중개사의 품위를 현저하게 훼손한 경우</strong> </label>
                                </div>
                                <div class="radio">
                                    <label for="rept04">
                                        <input type="radio" name="rept" id="rept04" value="CI4">
                                        <i></i><strong>과도하게 다른 매물을 권유한 경우</strong> </label>
                                </div>
                                <div class="radio">
                                    <label for="rept05">
                                        <input type="radio" name="rept" id="rept05" value="CI5">
                                        <i></i><strong>사이트에서 매물을 내리라고 권유한 경우</strong> </label>
                                </div> 
                                <div class="radio">
                                    <label for="rept06">
                                        <input type="radio" name="rept" id="rept06" value="CI6">
                                        <i></i><strong>동의 없이 내 매물을 사이트에서 내린 경우</strong> </label>
                                </div> 
                                <div class="radio">
                                    <label for="rept07">
                                        <input type="radio" name="rept" id="rept07" value="ETC">
                                        <i></i><strong>기타</strong> </label>
                                </div> 
                                <textarea name="reptExplain" id="reptExplain" class="txtarea" placeholder="기타 선택 시 내용을 입력해주세요."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="btn_area bot_btn">
                    <button class="btn_type03 on" type="submit">신고하기</button>
                </div>
                
                <!-- 중개사 선택 -->
                <input type="hidden" name="brokerofficeidx" id="brokerofficeidx" value="<?php echo $broker_idx; ?>">
        	<?php echo form_close(); ?>
        </div>
    </section>
</div>

<script type="text/javascript">
// 신고하기 처리
$(".btn_type03").click(function(){
	// 1. 중개사 선택
	if($('#brokerofficeidx').val() == '') {
		swal('중개사를 선택하세요');
		return false;
	}

	// 2. 신규사유 선택
	var reptVal = $(":input:radio[name=rept]:checked").val();
	if(!reptVal) {
		swal('신고사유를 선택해주세요.');
		return false;
	}

	if(reptVal == 'ETC') {
		if($('#reptExplain').val() == '') {
			swal('기타사유를 입력하세요.');
			$('#reptExplain').focus();
			return false;
		}
	}
	else {
		$('#reptExplain').val('');
	}
});

//--------------------------------------------------------------//

// 중개사 선택 클릭시
$("#relat01").click(function(){
	$(".sch_area").css('display', 'none');
	$(".sch_area2").css('display', 'none');
	location.href = "/board/reportbrokerchoice"; 
});

// 선택된 중계사 삭제
function selectBrokerOfficeAutoDel(idx)
{
	$(".sch_area").css('display', 'none');
	$('#brokerofficeidx').val('');

	var renewURL = '/board/reportbroker';
	history.pushState(null, null, renewURL);
}

//--------------------------------------------------------------//

// 직접검색 클릭시
$("#relat02").click(function(){
	$(".sch_area").css('display', 'none');
	$(".sch_area2").css('display', 'block');

	// 시도 리스트 가져오기
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

// 구군 리스트 가져오기
$('#sido').on('change', function() {
	var sido = this.value;

	$('#gugun').children().remove().end().append('<option value="">시/도선택</option>') ;

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

	$('#dong').children().remove().end().append('<option value="">읍/면/동선택</option>') ;

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

// 직접검색 검색어 입력
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
    	url:"/board/brokerofficesearch", 
    	data: sendData, 
    	success: function(data) {
    		var ulli = '', i = 0, len = data.length;
    		if(parseInt(len) > 0)
    		{    		
        		for(i = 0; i < len; ++i) {
        			ulli += "<li><a href=\"javascript:selectBrokerOffice('" + data[i].office_idx + "', '" + data[i].office_name + "', '" + data[i].office_phone + "', '"+data[i].office_username+"')\" class=\"sch_word\">'" + data[i].office_name + "' <span class=\"address\">'" + data[i].office_addr1 + "'("+data[i].office_username+"/'" + data[i].office_phone + "')</span></a></li>";
        		}
    		}
    		else
    		{
    			ulli += '<li><p class="sch_word">검색결과값이 없습니다.</p></li>';
    		}
    		$('#sch_result_list').append(ulli); 
    	}, 
    	error:function(data){ 
    		$('#sch_result_list').append('<li><p class="sch_word">검색결과값이 없습니다.</p></li>');
    	}
   	});
}

// 중개소 선택
function selectBrokerOffice(idx, office, phone, name)
{
	$('#broker_search').removeAttr( 'placeholder' );
	$('#broker_search').val('');
	$('.sle_bk').children().remove().end();
	$('.sle_bk').css('display', 'block');
	//$('.sle_bk').append('<span class="" id="sbo' + idx + '">' + office + ' (' + name + ') ' + phone + ' <a href="javascript:selectBrokerOfficeDel()" class="del01">삭제</a></span>');
	$('.sch_result').css('display', 'none');
	$('#sch_result_list').children().remove().end();
	$('#broker_search').val(office + ' (' + name + ') ' + phone);
	$('.btn_del02').css('display', 'block');
	$('#brokerofficeidx').val(idx);
}

//위치지도보기
function selmapview(office, lat, lng)
{
	$('#office_name').val(office);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);

	// 지도 출력
	officeposition();
}

// 중개소 삭제
function selectBrokerOfficeDel() {
	$('#broker_search').val('');
	$('#brokerofficeidx').val('');
	$('#broker_search').focus();
	$('.btn_del02').css('display', 'none');
	$('.sle_bk').children().remove().end();
}

// 문자 제거
$("#reptExplain").click(function(){
	$(this).attr("placeholder", "");
});
</script>