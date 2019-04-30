<div id="semWrap" class="mainwrap">
    <header id="header" class=""> 
      	<span class="btn_back back02">
      		<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
      	</span>
    </header>
    
    <section id="container" class="seminar_main_section sv">
        <div id="m_section">
            <div class="img_box">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="scdec_img"><img src="../images/img_sv01.png" alt="다윈에 집을 내놓아야 할 3가지 이유!"></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="sub_section" class="smain_sub">
        <form onsubmit="return false" id="regagencyform" class="sem_inp">
            <div class="img_box bgseminar04">
                <div class="m_text">
                    <p class="p03">정보를 남겨주시면<br>고객센터에서 매물 등록을<br>도와드립니다.<br><b>무료입니다.</b></p>
                    
                    <div class="inpbox inpbn">
                        <input type="tell" name="regphone" id="regphone" value="<?php echo (isset($MOBILE_NO)) ? $MOBILE_NO : ''; ?>" onmousedown="<?php echo (isset($MOBILE_NO)) ? '' : 'cellphoneChange()'; ?>" placeholder="휴대폰 인증 버튼을 눌러주세요" title="휴대폰번호" class="inp" autocomplete="off" readonly>
                        <span class="dcbtn">
                          	<button class="btn_line02" type="button" <?php echo (isset($MOBILE_NO)) ? '' : 'onclick="cellphoneChange()"'; ?>><?php echo (isset($MOBILE_NO)) ? '휴대폰인증완료' : '휴대폰인증'; ?></button>
                        </span>
                    </div>
                    
                    <div style="padding:10px 0 0 0;">
                    	<input type="text" name="REG_NAME" id="REG_NAME" value="<?php echo (isset($UTF8_NAME)) ? $UTF8_NAME : ''; ?>" onmousedown="<?php echo (isset($MOBILE_NO)) ? "" : "swal('휴대폰 인증 하세요.')"; ?>" title="이름" placeholder="이름 (휴대폰 인증 후 자동입력)" class="inp" autocomplete="off" readonly>
                    </div>
                    
                    <div class="inpbox inpbn">
                        <input type="text" name="LAW_ADDR1" id="addr" placeholder="주소를 검색하세요." title="주소를 검색하세요." class="inp" autocomplete="off" onmousedown="<?php echo (isset($MOBILE_NO)) ? "findAddressPop()" : "swal('휴대폰 인증 후 주소검색 하세요.')"; ?>" readonly>
                        <span class="dcbtn">
                          	<button class="btn_line02" type="button" onclick="<?php echo (isset($MOBILE_NO)) ? "findAddressPop()" : "swal('휴대폰 인증 후 주소검색 하세요.')"; ?>">주소검색</button>
                        </span>
                    </div>
                    
                    <div style="padding:10px 0 0 0;">
                    	<input type="text" id="REG_ADDR2" name="REG_ADDR2" placeholder="상세주소입력" title="상세주소입력" onmousedown="<?php echo (isset($MOBILE_NO)) ? "" : "swal('휴대폰 인증 하세요.')"; ?>" class="inp" autocomplete="off">
                    </div>
                    <input type="hidden" name="LAWDONG" id="LAWDONG" value="">
                    
                    <div class="check_box">
                        <div class="check">
                          	<label for="agree3">
                            	<input type="checkbox" name="REG_AGREE" id="REG_AGREE" value="Y">
                            	<i></i>
                            	<strong>개인정보수집동의</strong>
                            	<button class="btn_view_detail" type="button" onclick="popOpen()">자세히보기</button>
                          	</label>
                        </div>
                    </div> 

                    <p class="small">* 직접등록하시는 것보다 시간이 더 많이 소요되니 컴퓨터 사용이 익숙하신분들은 직접 매물을 등록해주세요.<br>
                      * 허위 매물 방지를 위해 매물 소유주만 신청이 가능합니다.<br>
                      * 현재는 분당, 판교, 수지, 광교 지역에서만 서비스 제공중입니다
                    </p>
                    
                    <center><button type="button" class="btn_apply_seminar" onclick="agencySave()">매물등록신청하기</button></center>
                </div>
          	</div>
        </form>
        </div>
    </section>
    
    <!-- 중개평가완료 시 팝업 -->
    <div class="mask" style="display:none;"></div>
    <div class="lyr lyrpop01" style="display:none;">
        <div class="lyr_inner">
           	<p><strong>1. 개인정보 수집 항목 (필수)</strong><br>성명, 전화번호, 주소</p><br>
            <p><strong>2. 이용목적</strong><br>매물등록대행 서비스 이용</p><br>
            <p><strong>3. 보유기간</strong><br>매물등록대행 서비스 이용 목적이 달성된 후에는 해당 정보를 지체없이 파기</p><br><p>※ 위의 개인정보 수집 및 이용동의에 거부할 수 있으며, 거부시 서비스 이용이 제한됨을 알려드립니다.</p>	
        </div>
        <div class="btn">
            <button type="button" class="btn_type02" onclick="popClose()">확인</button>
        </div>
    </div>
</div>

<!-- 휴대폰 번호 변경 -->
<form name="form_chk_Hp" id="form_chk_Hp" method="post">
	<input type="hidden" name="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="EncodeData" value="<?php echo $enc_data?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>

<!-- 다음 주소 API 보기 -->
<div class="daumpostmask" style="display:none;" onmousedown="closeDaumPostcode()"></div>
<div class="daumpostclose" style="display:none;" onclick="closeDaumPostcode()"><img src="/images/btn_close.png"></div>
<div class="daumpostlayer" id="daumpostlayer" style="display:none;"></div>

<script type="text/javascript">
// 팝업열기
function popOpen()
{
	$('.lyrpop01').css('position', 'fixed');
	$('.mask').show();
	$('.lyrpop01').show();
}

// 팝업닫기
function popClose() {
	$('.mask').hide();
	$('.lyrpop01').hide();
}

//휴대폰 번호 변경
function cellphoneChange()
{
	document.form_chk_Hp.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
	document.form_chk_Hp.submit();
}

function findAddressPop() {
    <?php //if($PUSHKEY != '' && $DEVICE == 'AND') { ?>
	//$('.daumpostlayer').css('position', 'relative');
	$('.daumpostlayer').css('top', '300px');
	<?php //} ?>
	findAddress();
}

// 신청처리
function agencySave()
{
  	if(!$("#REG_AGREE").prop("checked")) {
    	swal('개인정보수집에 동의해주세요')
    	return;
  	}
  	
  	if($("#REG_NAME").val().trim() == '') {
  		swal('이름을 입력해주세요')
    	return;
  	}
  	else if($("#addr").val().trim() == '') {
  		swal('주소를 검색해주세요')
    	return;
  	}
  	else if($("#REG_ADDR2").val().trim() == '') {
  		swal('상세주소를 입력해주세요')
    	return;
  	}
  	else
  	{
  		swal({
  		    text: "매물등록대행을 신청하시겠습니까?",
  		    buttons: [
  		        'No',
  		        'Yes'
  		    ],
  		}).then(function(isConfirm) {
  			if(isConfirm)
  	  		{
  				$.ajax({
  	        		url: '/sellhome/agencyserviceSave',
  	        		type: 'POST',
  	        		data: $("#regagencyform").serialize(),
  	        		dataType: 'json',
  	        		success: function(result){
  	          			if(result.code == 200) {
      	          			swal("정상적으로 신청되었습니다.\n고객센터(1544-6075)에서 연락드리겠습니다.").then(function(){ 
      	          				self.location.href="/"
      	                  	});
  	          			}
  	          			else {
  	            			swal(result.msg)
  	          			}
  	        		},
  	        		error : function(request, status, error) {
  	        			swal("오류가 발생하여 다시 시도 해주세요.");
  	        		},
  	      		});
  			}
  			else {
  				return false;
  			}
  		});

  		/*
    	if(confirm('매물등록대행을 신청하시겠습니까?'))
        {
      		$.ajax({
        		url: '/sellhome/agencyserviceSave',
        		type: 'POST',
        		data: $("#regagencyform").serialize(),
        		dataType: 'json',
        		success: function(result){
          			if(result.code == 200) {
          				swal("정상적으로 신청되었습니다.\n고객센터(1544-6075)에서 연락드리겠습니다.")
            			self.location.href="/"
          			}
          			else {
            			swal(result.msg)
          			}
        		},
        		error : function(request, status, error) {
        			swal("오류가 발생하여 다시 시도 해주세요.");
        		},
      		});
    	}
    	*/
  	}
}
</script>