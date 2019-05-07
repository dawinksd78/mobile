<div id="dawinWrap" class="bgrey">
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
        $attributes = array('method'=>'post','id'=>'joinagentform','onsubmit'=>'return false'); //'onkeypress'=>'return event.keyCode != 13'
        echo form_open('/agent/joinAgentResult',$attributes);
        ?>
        <div class="sub_container">
            <div class="cont_wrap join_wrap joinbk">
                <h2 class="subj_tit"><span class="m_tit">개인정보 입력</span></h2>
                <div class="proc"> <a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc on"></a><a href="javascript:;" class="bul_proc"></a></div>
                <p class="m_exp">안전하고 신뢰성 있는 중개를 위해 '대표 개업공인중개사'에 한해 회원가입이 가능합니다. 중개사무소 내 소속공인중개사 또는 중개보조원이 있을 경우, 대표 개업공인중개사가 회원가입 후 '마이페이지'에서 등록해주세요.</p>
                <div class="cont">
                    <div class="prof_area">
                        <div class="prof_frame">
                        	<input type="file" class="btn_file_pic" id="fileupload1" name="fileupload1" onchange="fileupload1pic()">
                        	<span class="pic_circles" <?php echo ($prfImg < 1 ) ? '' : 'hidden'?>></span>
                        	<span class="add_pic <?php echo ($prfImg > 0 ) ? '' : 'hidden'?>"><img src="<?php echo $prfFullPath?>" class="prof_image"></span>
                        	<a href="#" class="btn_del01 <?php echo ($prfImg > 0 ) ?'':'hidden'?>" data-type="prfImg" data-uuid="<?php echo ($prfImg > 0) ? $prfImg : ''; ?>" onClick="imgdel(this)"></a>
                            <label class="btn_pic" for="fileupload1" <?php echo ($prfImg > 0) ? 'style="display:none;"' : ''; ?>> 사진올리기</label>
                        </div>
                    </div>
                    <div class="inpbox readinp02">
                        <label for="bk_name" class="lbl">이름(대표자명)</label>
                        <input type="text" id="off_name" placeholder="대표자이름 자동입력" title="대표자이름 자동입력" value="<?php echo $BROKER_NAME; ?>" class="inp readinp" autocomplete="off" readonly>
                    </div>
                    <div class="inpbox inpbn" id="phoneform">
                        <label for="u_phone" class="lbl">휴대폰인증</label>
                        <?php if($MOBILE_NO == '') { ?>
                        <button class="btn_type07 btn_cirtf" type="button" onClick="fnPopupRealtorNC()">휴대폰인증</button>
                        <p class="add_text">* 대표자 명의의 휴대폰번호로 인증해주세요.</p>
                        <?php } else { ?>
                        <button class="btn_type07 btn_cirtf" type="button">핸드폰인증완료</button>
                        <?php } ?>                        
                        <input type="hidden" id="MOBILE_NO" value="<?php echo $MOBILE_NO; ?>">
                   	</div>
                   	<div class="inpbox inpbn" id="emailform">
                        <label for="u_id" class="lbl">아이디</label>
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>" onkeyup="if (window.event.keyCode == 13) { idemail_confirmRepetition(); }" placeholder="아이디(이메일)" title="아이디(이메일)" class="inp" autocomplete="off">
                        <span class="dcbtn">
                        <button type="button" class="btn_line02" onclick="idemail_confirmRepetition()">중복확인 </button>
                        </span>
                    </div>
                    <div class="inpbox" id="passwdform">
                        <label for="u_pass" class="lbl">비밀번호</label>
                        
                        <input type="password" name="passwd" id="passwd" onkeyup="passwordChk()" placeholder="비밀번호(영문+숫자8-15)" title="비밀번호(영문+숫자8-15)" class="inp" autocomplete="off">
                        <!-- 입력내용 문제있을 경우 에러메세지 출력 -->
                        <div class="err_msg_passwd"><span id="password_check" style="display:none;">* 비밀번호를 영문+숫자 8-15로 입력하세요.</span></div>
                                     
                        <input type="password" name="passwd_confirm" id="passwd_confirm" onkeyup="repasswordChk()" placeholder="비밀번호 확인" title="비밀번호 확인" class="inp error" autocomplete="off">
                        <div class="err_msg" style="display:none;"><span id="password_result">* 비밀번호가 동일하지 않습니다.</span></div>
                    </div>
                    <div class="inpbox">
                        <label for="bk_career" class="lbl">경력사항 <small>* 선택</small></label>
                        <textarea id="career" name="career" class="txtarea" onkeyup="phoneCert()" placeholder="중개의뢰 고객이 믿고 선택할 수 있도록, 내용을 상세하게 입력헤주세요. &#13;&#10;ex) 1. 금곡동 까치마을 주변에서 개업 (1995) &#13;&#10; 2. 분당구 중개사회 총무 (2010-2013) &#13;&#10; 3. 총 계약건수 200회 이상 등"><?php echo nl2br($career); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn double">
                <button class="btn_type03" type="button" onclick="goPage('/agent/joinAgent3');">이전</button>
                <button class="btn_type02" type="button" onclick="nextStep5()">다음</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </section>
</div>

<!-- 휴대폰 인증 -->
<form name="form_chk_realtor" id="form_chk_realtor" method="post">
<input type="hidden" name="m" value="checkplusSerivce">		<!-- 필수 데이타로, 누락하시면 안됩니다. -->
<input type="hidden" name="EncodeData" id="EncodeData">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>

<script type="text/javascript">
var chekdupemail = false;

//변경사항 저장여부 체크
var datachanged = false;

<?php if($certState == 'N') { ?>
//swal('대표자명과 휴대폰 인증한 이름이 같지 않습니다. 재인증하시기 바랍니다.');
<?php } ?>

// 휴대폰 인증
function fnPopupRealtorNC()
{
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url: "/agent/joinAgent4CertInfo", 
    	success: function(data) {
			if(data.code == '100')
			{
				$('#EncodeData').val(data.res);
				document.form_chk_realtor.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
				document.form_chk_realtor.submit();          			
      			return false;
			}
     		else
     		{
         		// 실패
     			swal("오류!", "오류가 발생하였습니다. 다시 시도해 주시기 바랍니다!", "error");  
      			return false;
     		} 
    	}, 
    	error:function(data){
    		// 실패
 			swal("오류!", "오류가 발생하였습니다. 다시 시도해 주시기 바랍니다!", "error");  
  			return false;
    	} 
   	});
   	
	
}

// 인증체크
function phoneCert()
{
	var mobileCert = "<?php echo $MOBILE_NO; ?>";
	if(mobileCert == '') {
		swal("휴대폰 인증 후 진행하시기 바랍니다.");
		$("#email").val('');
		return false;
	}
}

// 아이디(이메일) 체크
function idemail_confirmRepetition()
{
	// 폰인증체크
	var mobileCert = "<?php echo $MOBILE_NO; ?>";
	if(mobileCert == '') {
		swal("휴대폰 인증 후 진행하시기 바랍니다.");
		$("#email").val('');
		return false;
	}
	
	var idemail = $.trim($("#email").val());		// 이메일
	
	// 아이디(이메일) 체크
	if(idemail == '') {
		swal("아이디(이메일)를 입력해 주세요.");
		$("#email").val('');
		$("#email").focus();
		return false;
	}

	// 아이디(이메일) 정상메일 체크
	var emailChk = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
	if(idemail.match(emailChk) == null) {
		swal('적합하지 않은 아이디(이메일) 형식입니다. 다시 입력해 주세요.');
		$("#email").val('');
		$("#email").focus();
		return false;
	}

	// 전송할 데이터
    var join_data = "&user_id=" + $.trim($("#email").val());
     
    $.ajax({ 
    	type: "POST", 
    	dataType: "text",
    	async: false, 
    	url: "/member/joincheck", 
    	data: join_data, 
    	success: function(data) {
     		if(data == 'Y') 
     		{ 
      			swal('이미 존재하는 아이디(이메일)입니다. 다시 아이디(이메일)를 입력하세요.');
      			$("#email").val('');
      			return false; 
     		} 
     		else 
     		{ 
     			swal('등록 가능한 아이디(이메일)입니다.');
     			chekdupemail = true;
     		}
    	}, 
    	error:function(data){ 
     		alert('ajax error'); 
    	} 
   	}); 
}

// 비밀번호 체크
function passwordChk()
{
	// 폰인증체크
	var mobileCert = "<?php echo $MOBILE_NO; ?>";
	if(mobileCert == '') {
		swal("휴대폰 인증 후 진행하시기 바랍니다.");
		$("#email").val('');
		return false;
	}
	
	var password = $("#passwd").val();	// 비밀번호

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		$(".err_msg_passwd").css("display", "block");
		$("#password_check").css("display", "block");
		$("#password_check").text("* 비밀번호를 영문+숫자 8-15로 입력하세요.");
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        $(".err_msg_passwd").css("display", "block");
        $("#password_check").css("display", "block");
        $("#password_check").text("* 비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다."); 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    { 
	        $(".err_msg_passwd").css("display", "block");
	        $("#password_check").css("display", "block");
	        $("#password_check").text("* 비밀번호는 숫자와 영문자를 혼용하여야 합니다."); 
	    }
		else
		{
			$("#password_check").text("");
		}
	}

    return;
}

// 비밀번호 확인 체크
function repasswordChk()
{
	// 폰인증체크
	var mobileCert = "<?php echo $MOBILE_NO; ?>";
	if(mobileCert == '') {
		swal("휴대폰 인증 후 진행하시기 바랍니다.");
		$("#email").val('');
		return false;
	}
	
	var password = $("#passwd").val();	// 비밀번호
	var repassword = $("#passwd_confirm").val();// 재입력 비밀번호

	if(password != repassword) {
		$(".err_msg").css("display", "block");
	}
	else {
		$(".err_msg").css("display", "none");
	}
	
	return false;
}

// 이미지 삭제
function imgdel(bt)
{
    var uuid = $(bt).data('uuid');
    var imgType = $(bt).data('type');
    $.ajax({
        url: '/agent/joinAgentFileDel/', // point to server-side PHP script
        dataType: 'json', // what to expect back from the PHP script
        cache: false,
        data: {uuid :uuid, imgType:imgType},
        type: 'post',
        success: function(result){
            if( result.code == 200 ) {
              $(bt).addClass("hidden");
              $(bt).parent().children(".add_pic").addClass("hidden");
              $(bt).parent().children('.btn_del01').data("uuid", '');
              $('.btn_pic').show();
            }
            else {
              swal(result.msg); // display success response from the PHP script
            }
            $("#fileupload1").val('');
        },
        error: function(request, status, error) {
         	swal("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요");
       	},
       	beforeSend: function() {
         	$('#ajax_loader').show();
        },
        complete: function(){
         	$('#ajax_loader').hide();
        },
    });
}

// 다음 단계로 이동
function nextStep5()
{
	// 폰인증체크
	var mobileCert = "<?php echo $MOBILE_NO; ?>";
	if(mobileCert == '') {
		swal("휴대폰 인증 후 진행하시기 바랍니다.");
		$("#email").val('');
		return false;
	}
	
	/*if(!checkEmail($("#email").val()))
	{
		swal("ID는 EMAIL을 적어주셔야 합니다.");
		$("#email").focus();
		return;
	}*/
	
	if(!chekdupemail) {
    	swal("ID중복확인을 해주세요.");
    	return;
    }
    
	/*if(!checkpwd( $("#passwd").val()))
    {
  		swal("비밀번호는 숫자와 영문을 포함하여 8자 이상 15자 이하로 적어주세요.");
  		$("#passwd").focus();
  		return;
  	}*/

  	var password = $("#passwd").val();	// 비밀번호

	// 혼용여부 체크
	var chk_num = password.search(/[0-9]/g); 
    var chk_eng = password.search(/[a-z]/ig);

	// 비밀번호 영문숫자 체크
	//if(!/^[a-zA-Z0-9]{8,15}$/.test(password))
	if(!checkpwd(password))
	{
		$(".err_msg_passwd").css("display", "block");
		$("#password_check").css("display", "block");
		$("#password_check").text("* 비밀번호를 영문+숫자 8-15로 입력하세요.");
	}
	else if(/(\w)\1\1\1/.test(password))
    {
        $(".err_msg_passwd").css("display", "block");
        $("#password_check").css("display", "block");
        $("#password_check").text("* 비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다."); 
    }
	else
	{
		if(chk_num < 0 || chk_eng < 0)
	    { 
	        $(".err_msg_passwd").css("display", "block");
	        $("#password_check").css("display", "block");
	        $("#password_check").text("* 비밀번호는 숫자와 영문자를 혼용하여야 합니다."); 
	    }
		else
		{
			$("#password_check").text("");
		}
	}
  	
	if($("#passwd").val() !== $("#passwd_confirm").val())
    {
  		swal("비밀번호가 동일하지 않습니다.");
  		$("#passwd_confirm").focus();
  		return;
	}
	
	if($("#fileupload1").parent().children('.btn_del01').data("uuid") =='')
    {
  		swal("프로필 사진을 올려주세요.");
  		$("#fileupload1").focus();
  		return;
	}
	
	/*
	if( confirm( $("#email").val() + " 으로 회원가입을 진행하시겠습니까?") ) {
		fnPrcSave();
	}
	else {
		return false;
	}
	*/
	swal({
	    text: $.trim($("#email").val()) + " 으로 회원가입을 진행하시겠습니까?",
	    buttons: [
	        'No',
	        'Yes'
	    ],
	}).then(function(isConfirm) {
		if(isConfirm) {
			fnPrcSave();
		}
		else {
			return false;
		}
	});
}

function fnPrcSave()
{
  	var param = $("#joinagentform").serialize();
	$.ajax({
        url:"/agent/joinAgent4Save/",
        type:"post" ,
        data : param,
        dataType : "json" ,
        success : function (result){
          	if(result.code == 200) {
          		datachanged = false;	// 저장시 활성경고 제거
            	location.href = "/agent/joinAgent5/<?php echo $MOBILE_NO; ?>";
          	}
          	else {
            	swal(result.msg);
          	}
       	},
        error : function(request, status, error) {
           	swal("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
       	},
    });
}

// 사진등록
function fileupload1pic()
{
	var ins = document.getElementById('fileupload1').files.length;
    for(var x = 0; x < ins; x++)
    {
        var form_data = new FormData();
        form_data.append("files", document.getElementById('fileupload1').files[x]);
        $.ajax({
            url: '/agent/joinAgentFileUp/prfImg', // point to server-side PHP script
            dataType: 'json', // what to expect back from the PHP script
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(result){
                if( result.code == 200 ) {
                  	$("#fileupload1").parent().children('.add_pic').children("img").attr("src", result.data);
                  	$("#fileupload1").parent().children('.add_pic').removeClass("hidden");
                  	$("#fileupload1").parent().children('.btn_del01').data("uuid", result.newUuid).removeClass("hidden");
                  	$("#fileupload1").parent().children("input[type=hidden]:first-child").val(result.newUuid);
                  	$('.btn_pic').hide();
                }
                else {
                	swal(result.msg); // display success response from the PHP script
                }
                $("#fileupload1").val('');
            },
            error: function(request, status, error) {
             	swal("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요");
               	$("#fileupload1").val('');
           	},
           	beforeSend: function() {
             	$('#ajax_loader').show();
            },
            complete: function(){
             	$('#ajax_loader').hide();
            },
        });
    }
}

//사진등록
$(document).ready(function(e){
	// 경고창 활성 (아무작업을 안했을 경우 띄움
    /*$(window).on("beforeunload", function(){
    	console.log(datachanged);
      	if(datachanged == true) return false;
    });*/

	// 폰인증 선택시 경고창 활성
	$("#phoneform").on("change keyup paste", function(){
		datachanged = true;
	});

	// 아이디 선택시 경고창 활성
	$("#emailform").on("change keyup paste", function(){
		datachanged = true;
	});

	// 비밀번호 선택시 경고창 활성
	$("#passwdform").on("change keyup paste", function(){
		datachanged = true;
	});
});
</script>