<div id="dawinWrap" class="">
    <header id="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span>닫기</span></button>
        </span>
    </header>
        
    <section id="container">
    <form onSubmit="return false;" id="resonform">
		<input type="hidden" name="idx" value="<?php echo $idx; ?>">
		
        <div class="sub_container">            
            <div class="cont_wrap public_cont formcont">
                <h2 class="subj_tit">
                	<span class="m_tit">매물삭제</span>
                	<p class="m_exp">매물삭제 사유를 선택해 주세요.</p>
                </h2>
                
                <div class="cont">
                    <div class="selec_option">
                        <div class="radio_box">
                            <?php foreach($goods_del as $delinfo) { ?>
                            <div class="radio">
                                <label for="cancelregi<?php echo $delinfo['CODE_DETAIL']; ?>">
                                    <input type="radio" name="reson" id="cancelregi<?php echo $delinfo['CODE_DETAIL']; ?>" value="<?php echo $delinfo['CODE_DETAIL']; ?>" data-etc="#etc_reson" onClick="fnresonChange(this)">
                                    <i></i><strong><?php echo $delinfo['CODE_NAME']; ?></strong>
                                </label>
                            </div>
                            <?php } ?>
                            <textarea class="txtarea" placeholder="기타 선택 시 내용을 입력해주요." id="etc_reson" name="etc" onkeyup="reasonWrite(this)" disabled></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03" onclick="fnDeleteSellingPrc()">확인</button>
                <!-- 사유선택 시 on 클래스 추가 --> 
            </div>
        </div>
    </form>
    </section>
</div>

<script type="text/javascript">
function fnresonChange(obj)
{
    var etc = $(obj).data("etc");
    if($(obj).val() == 'ETC') {
	    $(etc).prop("disabled", false);
	    $(".btn_type03").removeClass('on');
    }
    else {
        $(etc).prop("disabled", true);
        $(etc).val('');
        $(".btn_type03").addClass('on');
    }
}

// 확인
function fnDeleteSellingPrc()
{
	var selectVal = $(":input:radio[name='reson']:checked").val();
	
	if(selectVal == '') {
		swal('매물삭제 사유를 선택해주세요');
		return false;
	}

	if(selectVal == 'ETC')
	{
		if($('#etc_reson').val() == '')
		{
			swal('매물삭제 사유를 입력해주요');
			return false;
		}
	}
	
    $.ajax({
        url: "/mypage/myhousedeleteproc",
        type: "post",
        data: $("#resonform").serialize(),
        dataType: "json",
        success: function(result){
            if(result.code == 200 || result.code == 521)
            {
            	swal({
      			  	title: "삭제완료!",
      			  	text: "삭제 하였습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				location.href = "/mypage/myhousesale";
      			});
            }
            else if(result.code == 501) {
            	window.location.reload();
            }
            else {
            	swal(result.msg);
            }
        },
        error: function(request, status, error) {
        	swal("삭제중 오류가 발생하였습니다. 다시 시도해 주세요!");
		},
		beforeSend: function() {
			$('#ajax_loader').show();
		},
		complete: function(){
			$('#ajax_loader').hide();
		}
    });
}

function reasonWrite(val)
{
	if(val != '') {
		$(".btn_type03").addClass('on');
	}
	else {
		$(".btn_type03").removeClass('on');
	}
}
</script>