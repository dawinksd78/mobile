<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="goPage('/agent/joinAgent1');"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">중개사회원가입</h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <?php
        $attributes = array('method'=>'post','id'=>'joinagentform','onsubmit'=>'return false');
        echo form_open('/agent/joinAgent4',$attributes);
        ?>
        <div class="sub_container">
            <div class="cont_wrap join_wrap joinbk">
                <h2 class="subj_tit"><span class="m_tit">중개사무소 정보 입력</span></h2>
                <div class="proc"> <a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc on"></a><a href="javascript:;" class="bul_proc"></a><a href="javascript:;" class="bul_proc"></a></div>
                <p class="m_exp">입력하신 정보를 토대로 승인여부가 결정되니 정확한 정보를 입력해주세요.</p>
                <div class="cont">
                    <div class="inpbox sch_inpbox">
                        <div class="sch_area">
                            <label for="off_name" class="lbl">중개사무소명</label>
                            <select name="sido" id="sido" title="시/도선택" class="selec" onchange="sidoFunc(this.value)">
                                <option value="">시/도선택</option>
                            </select>
                            <div class="flt">
                                <select name="gugun" id="gugun" title="시/도/구선택" class="selec" onchange="gugunFunc(this.value)">
                                    <option value="">시/도/구선택</option>
                                </select>
                                <select name="dong" id="dong" title="읍/면/동선택" class="selec">
                                    <option value="">읍/면/동선택</option>
                                </select>
                            </div>
                            <div class="sch_box">
                                <input type="text" name="broker_search" id="broker_search" onkeyup="brokerOfficeSearch()" placeholder="중개사무소명을 검색하세요." title="" class="inp" autocomplete="off">
                                <div class="btn_sch">
                                    <button type="button" onclick="brokerOfficeSearch()"><span>검색</span></button>
                                </div>
                                
                                <!-- 1/0404 검색어 삭제버튼 추가 -->
                                <button type="button" onclick="selectBrokerOfficeDel()" class="btn_del02 inpdel">삭제</button>
                                <div class="sle_bk"></div>
                            </div>
                            
                            <!-- 검색결과 영역 -->
                            <div class="sch_result" style="display:none;">
                                <ul id="sch_result_list"></ul>
                            </div>
                            <!-- // 검색결과 영역 끝 -->
                            
                            <!-- p class="add_text">* 중개사무소 이름 또는 전화번호로 검색가능</p -->
                            <!-- div class="sle_bk"></div -->
                        </div>
                    </div>
                    
                    <div class="inpbox rdinp">
                        <label for="busi_type" class="lbl">사업자종류</label>
                        <div class="radio_box02">
                            <div class="rd01">
                                <input type="radio" id="isCompany01" name="isCompany" value="P" <?php echo ($isCompany =='P') ? 'checked=""':''?>>
                                <label for="isCompany01">개인</label>
                            </div>
                            <div class="rd01">
                                <input type="radio" id="isCompany02" name="isCompany" value="C" <?php echo ($isCompany =='C') ? 'checked=""':''?>>
                                <label for="isCompany02">법인</label>
                            </div>
                        </div>
                        <p class="add_text">* 법인의 경우 분사무소는 별도로 회원가입을 해야합니다.</p>
                    </div>
                    
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">사업자등록증</label>
                        <div class="btn_file_wrap">
                            <label for="file_upload">+ 파일업로드</label>
                            <input type="file" class="btn_file_pic" name="fileupload1" id="fileupload1" onchange="fileupload1pic()">
                            <!-- 첨부된 파일위치 -->
						    <span class="add_pic <?php echo ($bizCert > 0 ) ? '':'hidden'; ?>"><img src="<?php echo $bizFullPath; ?>"></span> <a href="#" class="btn_del01 <?php echo ($bizCert > 0 ) ? '':'hidden'?>" data-type="bizCert" data-uuid="<?php echo ($bizCert > 0 ) ? $bizCert:''; ?>" onClick="imgdel(this)"></a>
                           	<input type="hidden" name="bizCert">
                        </div>
                        <p class="add_text">* 4MB이하의 jpg, png 파일로 업로드해주세요.</p>
                    </div>
                    
                    <div class="inpbox">
                        <label for="u_pass" class="lbl">개설등록증</label>
                        <div class="btn_file_wrap"> 
                            <label for="file_upload">+ 파일업로드</label>
						    <input type="file" class="btn_file_pic" name="fileupload2" id="fileupload2" onchange="fileupload2pic()"> 
                            <!-- 첨부된 파일위치 --> 
                            <span class="add_pic <?php echo ($regCert > 0 ) ? '':'hidden'; ?>"><img src="<?php echo $regFullPath; ?>"></span> <a href="#" class="btn_del01 <?php echo ($regCert > 0 ) ? '':'hidden'; ?>" data-type="regCert" data-uuid="<?php echo ($regCert > 0 ) ? $regCert:''; ?>" onClick="imgdel(this)"></a>
                            <input type="hidden" name="regCert">
                        </div>
                        <p class="add_text">* 4MB이하의 jpg, png 파일로 업로드해주세요.</p>
                    </div>
                    
                    <div class="inpbox inpbn">
                        <label for="u_pass" class="lbl">주소</label>
                        <input type="text" name="office_addr" id="office_addr" placeholder="중개사무소주소 자동입력" title="중개사무소주소 자동입력" class="inp readinp" autocomplete="off" readonly>
                        <div class="btn">
                            <button class="btn_line04" type="button" onclick="officeposition()">위치확인하기</button>
                        </div>
                    </div>
                    
                    <div class="inpbox inpbn">
                        <label for="u_pass" class="lbl">전화번호</label>
                        <input type="tell" name="PHONE" id="PHONE" value="<?php echo $PHONE; ?>" placeholder="- 없이 숫자만 입력하세요." title="- 없이 숫자만 입력하세요." class="inp" autocomplete="off"><!--  onfocus="OnCheckPhone(this)" onKeyup="OnCheckPhone(this)" -->
                    </div>
                </div>
            </div>
            <div class="btn_area bot_btn double">
                <button class="btn_type03" type="button" onclick="javascript:location.href='/agent/joinAgent2';">이전</button>
                <button class="btn_type02" type="button" onclick="nextStep4()">다음</button>
            </div>
        </div>
        
        <!-- 중개사 선택 -->
    	<input type="hidden" name="brokerofficeidx" id="brokerofficeidx">
    	<?php echo form_close(); ?>
    </section>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none;" onmousedown="layerClose()"></div><!-- 배경 -->
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
var SIDOCODE = "<?php echo $SIDO_CODE; ?>";
var GUGUNCODE = "<?php echo $SIGUNGU_CODE; ?>";
var DONGCODE = "<?php echo $DONG_CODE; ?>";
var BROKEROFFICEINFOIDX = "<?php echo $BROKER_OFFICE_INFO_IDX; ?>";

//변경사항 저장여부 체크
var datachanged = false;

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
        		if(data[i].sido_code == SIDOCODE) {
    		    	html1 += '<option value="' + data[i].sido_code + '" selected>' + data[i].sido + '</option>';
        		}
        		else {
        			html1 += '<option value="' + data[i].sido_code + '">' + data[i].sido + '</option>';
        		}
    		}
    		$('#sido').append(html1); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR1');
    	} 
    });
}); 

//구군 리스트 가져오기
//$('#sido').on('change', function() {
function sidoFunc(sido)
{
	//var sido = this.value;

	$('#gugun').children().remove().end().append('<option value="">시/도선택</option>') ;

	// 전송할 데이터
    var sendData = "&sido=" + sido;
    
	// 시도 리스트 가져오기
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/search_gugun/broker", 
    	data: sendData, 
    	success: function(data) {
    		var html2 = '';
    		for(var i = 0, len = data.length; i < len; ++i) {
				if(data[i].gugun_code == GUGUNCODE) {
    		    	html2 += '<option value="' + data[i].gugun_code + '" selected>' + data[i].gugun + '</option>';
				}
				else {
					html2 += '<option value="' + data[i].gugun_code + '">' + data[i].gugun + '</option>';
				}
    		}
    		$('#gugun').append(html2); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR2');
    	} 
   	});
}
//});
if(SIDOCODE != '') sidoFunc(SIDOCODE);

//읍면동 리스트 가져오기
//$('#gugun').on('change', function() {
function gugunFunc(gugun)
{
	//var gugun = this.value;

	$('#dong').children().remove().end().append('<option value="">읍/면/동선택</option>') ;

	// 전송할 데이터
    var sendData = "&gugun=" + gugun;
    
	// 시도 리스트 가져오기
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/board/search_dong/broker", 
    	data: sendData, 
    	success: function(data) {
    		var html3 = '';    		
    		for(var i = 0, len = data.length; i < len; ++i) {
        		if(data[i].dong_code == DONGCODE) {
    		    	html3 += '<option value="' + data[i].dong_code + '" selected>' + data[i].dong + '</option>';
        		}
        		else {
    		    	html3 += '<option value="' + data[i].dong_code + '">' + data[i].dong + '</option>';
        		}
    		}
    		$('#dong').append(html3); 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR3');
    	} 
   	});
}
//});
if(GUGUNCODE != '') gugunFunc(GUGUNCODE);

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

	if(broker_search == '') return;

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

// 저장된 중개소
function saveBrokerOffice(brokeridx)
{
	// 전송할 데이터
 	var sendData = "&brokeridx=" + brokeridx;
 	
	// 시도 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "json",
     	async: false, 
     	url:"/board/brokerofficesavesearch", 
     	data: sendData, 
     	success: function(data) {
     		var i = 0, len = data.length;   		
     		for(i = 0; i < len; ++i)
         	{
             	if(data[i].office_idx == brokeridx) {
     				selectBrokerOffice(data[i].office_idx, data[i].office_name, data[i].broker_name, data[i].office_addr, data[i].office_lat, data[i].office_lng);
             	}
     		}
     	}
	});
}
// 중개소 출력
if(BROKEROFFICEINFOIDX != '') saveBrokerOffice(BROKEROFFICEINFOIDX);

// 중개소 선택
function selectBrokerOffice(idx, office, broker, office_addr, lat, lng)
{
	$('.sle_bk').children().remove().end();
	//$('.sle_bk').css('display', 'block');
	//$('.sle_bk').append('<span class="" id="sbo' + idx + '">' + office + ' (' + broker + ') <a href="javascript:selectBrokerOfficeDel()" class="del01">삭제</a></span>');
	$('.sch_result').css('display', 'none');
	$('#sch_result_list').children().remove().end();
	$('#brokerofficeidx').val(idx);
	$('#office_name').val(office);
	$('#office_addr').val(office_addr);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);
	//$("#broker_search").val('');
	$("#broker_search").val(office + ' (' + broker + ') ');
}

// 중개소 삭제
function selectBrokerOfficeDel() {
	$('#brokerofficeidx').val('');
	$('#office_addr').val('');
	$('#office_lat').val('');
	$('#office_lng').val('');
	$("#broker_search").val('');
	$('.sle_bk').children().remove().end();
}

// 중개소 결과창 제거
function brokerdisplaynone() {
	$('.sch_result').css('display', 'none');
	$('#sch_result_list').children().remove().end();
	$("#broker_search").val('');
}

// 레이어창 닫기
function layerClose() {
	$('.mask').css('display', 'none');
	$('.lyr').css('display', 'none');
}

//업로드 이미지 파일 삭제
function imgdel(bt)
{
	var uuid = $(bt).data('uuid');
	var imgType = $(bt).data('type');
	$.ajax({
		url: '/agent/joinAgentFileDel', // point to server-side PHP script
		dataType: 'json', // what to expect back from the PHP script
		cache: false,
		data: {uuid :uuid, imgType:imgType},
		type: 'post',
		success: function(result){
			if( result.code == 200 ){
				$(bt).addClass("hidden");
				$(bt).parent().children(".add_pic").addClass("hidden");
			}
			else {
				swal(result.msg); // display success response from the PHP script
			}
			$("#fileupload1").val('');
			$("#fileupload2").val('');
		},
		error: function(request, status, error){
			swal("오류가 발생하였습니다. 잠시 후에 다시 시도해 주세요!");
		},
		beforeSend: function() {
			$('#ajax_loader').show();
		},
		complete: function(){
			$('#ajax_loader').hide();
		}
	});
}

//--------------------------------------------------------------//

// 저장 후 다음 페이지 이동
function nextStep4()
{
	if($('#brokerofficeidx').val() == '') {
		swal('중개사무소를 선택해 주세요.');
		return false;
	}

	if($('#PHONE').val() == '') {
		swal('중개사무소 전화번호를 입력해 주세요.');
		return false;
	}
	
  	$.ajax({
      	url: '/agent/joinAgent3Save',
      	dataType: 'json', // what to expect back from the PHP script
      	cache: false,
      	data: $("#joinagentform").serialize(),
      	type: 'post',
      	success: function(result){
          	if(result.code == 200)
            {
          		datachanged = false;	// 저장시 활성경고 제거
          		location.href="/agent/joinAgent4";
          	}
          	else {
            	swal(result.msg); // display success response from the PHP script
          	}
      	},
      	error: function(request, status, error) {
      		swal("오류가 발생하였습니다. 잠시 후에 다시 시도해 주세요!");
     	},
     	beforeSend: function() {
       		$('#ajax_loader').show();
      	},
      	complete: function(){
       		$('#ajax_loader').hide();
      	},
  	});
}

// 사업자등록증 이미지 파일 업로드
function fileupload1pic()
{
	var ins = document.getElementById('fileupload1').files.length;
	for(var x=0; x < ins; x++)
	{
		var form_data = new FormData();
		form_data.append("files", document.getElementById('fileupload1').files[x]);
		$.ajax({
			url: '/agent/joinAgentFileUp/bizCert', // point to server-side PHP script
			dataType: 'json', // what to expect back from the PHP script
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function(result){
				if(result.code == 200)
				{
					$("#fileupload1").parent().children('.add_pic').children("img").attr("src", result.data);
					$("#fileupload1").parent().children('.add_pic').removeClass("hidden");
					$("#fileupload1").parent().children('.btn_del01').data("uuid", result.newUuid).removeClass("hidden");
					$("#fileupload1").parent().children("input[type=hidden]:first-child").val(result.newUuid)
				}
				else {
					swal(result.msg); // display success response from the PHP script
				}
				//$("#fileupload1").val('');
			},
			error: function(request, status, error){
				swal("사업자등록증 업로드중 오류가 발생하였습니다.\n잠시 후에 다시 시도해 주세요!");
				$("#fileupload1").val('');
				//location.href = "/agent/joinAgent3";
			},
			beforeSend: function() {
				$('#ajax_loader').show();
			},
			complete: function(){
				$('#ajax_loader').hide();
			}
		});
	}
}

//개설등록증 이미지 파일 업로드
function fileupload2pic()
{
	var ins = document.getElementById('fileupload2').files.length;
	for(var x = 0; x < ins; x++)
	{
     	var form_data = new FormData();
     	form_data.append("files", document.getElementById('fileupload2').files[x]);
     	$.ajax({
            url: '/agent/joinAgentFileUp/regCert', // point to server-side PHP script
            dataType: 'json', // what to expect back from the PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(result){
	            if(result.code == 200)
		        {
		            $("#fileupload2").parent().children('.add_pic').children("img").attr("src", result.data);
		            $("#fileupload2").parent().children('.add_pic').removeClass("hidden");
		            $("#fileupload2").parent().children('.btn_del01').data("uuid", result.newUuid).removeClass("hidden");
		            $("#fileupload2").parent().children("input[type=hidden]:first-child").val(result.newUuid)
		        }
                else {
    	            swal(result.msg); // display success response from the PHP script
    	        }
                //$("#fileupload2").val('');
            },
            error: function(request, status, error){
            	swal("개설등록증 업로드중 오류가 발생하였습니다.\n잠시 후에 다시 시도해 주세요!");
	            $("#fileupload2").val('');
            	//location.href = "/agent/joinAgent3";
	        },
			beforeSend: function() {
				$('#ajax_loader').show();
			},
			complete: function(){
				$('#ajax_loader').hide();
			}
		});
	}
}

//--------------------------------------------------------------//

//이미지 파일 업로드
$(document).ready(function(e){
	// 경고창 활성 (아무작업을 안했을 경우 띄움
    /*$(window).on("beforeunload", function(){
     	console.log(datachanged);
       	if(datachanged == true) return false;
    });*/

	// 중개사무소 주소 선택시 경고창 활성
	$(".sch_area").on("change keyup paste", function(){
		datachanged = true;
	});
});
</script>