<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">문의하기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap public_cont02">
                <div class="agcard_wrap">
                    <ul class="agent_box agqbox">
                        
                        <?php $i=1; foreach($realtor['data'] as $key=>$info) { ?>
                        <li class="agent_lst">
                            <div class="itm_inner">
                                <div class="thumbnail_area">
                                    <?php
                                	if($info['MBR_IMAGE_FULL_PATH'] != '') {
                                	    $img = $info['MBR_IMAGE_FULL_PATH'];
                                	}
                                	else {
                                	    $img = "/images/btn_camera.png";
                                	}
                                	?>
                                    <div class="thumbnail"><img src="<?php echo $img; ?>" alt="중개사사진"/></div>
                                </div>
                                <?php if($getDevideCookie=='1' && $DEVICE=='AND') { ?>
                                <a class="agent_info" href="javascript:void(0);" onclick="dawin_newpop('/sellhome/step4_agentinfo/<?php echo $info['BROKER_OFFICE_IDX']; ?>/<?php echo $goods_idx; ?>')">
                                <?php } else { ?>
                                <a class="agent_info" href="javascript:void(0);" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $info['BROKER_OFFICE_IDX']; ?>/<?php echo $goods_idx; ?>')">
                                <?php } ?>
                                <div class="broker_info">
                                    <p class="commtype"><?php echo $info['OFFICE_NAME']; ?></p>
                                    <p class="bk_name"><?php echo $info['MBR_NAME']; ?></p>
                                    <p class="p_num"><?php echo $info['PHONE']; ?></p>
                                    <div class="star_score"> <span class="st_off"><span class="st_on" style="width:<?php echo $info['BROKER_POINT'] / 5 * 100; ?>%"><?php echo $info['BROKER_POINT']; ?></span></span><span class="rv_count">(<?php echo number_format($info['BROKER_POINT_CNT']); ?>)</span> </div>
                                </div>
                                </a>
                                <div class="btn_ques" id="inquiryBtn<?php echo $i; ?>">
                                	<?php if($info['QNA_IDX'] != '') { ?>
                                	<button type="button" class="">문의<br>완료</button>
                                	<?php } else { ?>
                                	<button type="button" onclick="inquiryPop('<?php echo $info['BROKER_OFFICE_IDX']; ?>','<?php echo $i; ?>')" class="">문의<br>하기</button>
                                	<?php } ?>
                                </div>
                            </div>
                        </li>
                        <?php $i++; } ?>
                        
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none;"></div>
    <div class="lyr lyrpop01 qalyr" style="display:none;"> 
    <form name="inquiryform" id="inquiryform" onsubmit="return false">
        <span class="btn_close04">
        	<button type="button" onclick="popupClose()"><span class="">닫기</span></button>
        </span> 
        <div class="lyr_inner">
            <p class="cont">중개사에게 문의하세요.</p>
            <textarea name="contents" id="contents" class="txtarea" placeholder="문의할 내용을 입력하세요."></textarea>
        </div>
        <div class="btn">
            <button type="button" class="btn_type02" onclick="inquiryProc()">문의하기</button>
        </div>
        <input type="hidden" name="brk_check" id="chkag01">
        <input type="hidden" name="goods_idx" id="goods_idx" value="<?php echo $goods_idx; ?>">
        <input type="hidden" name="selpopnum" id="selpopnum">
    </form>
    </div>
</div>

<script type="text/javascript">
// 문의하기 팝업 오픈
function inquiryPop(idx, num)
{
	$('.mask').show();
	$('.lyr').show();
	$('#chkag01').val(idx);
	$('#selpopnum').val(num);
}

// 문의하기 팝업 닫기
function popupClose()
{
	$('.mask').hide();
	$('.lyr').hide();
	$('#chkag01').val('');
	$('#contents').val('');
}

// 문의하기 처리하기
function inquiryProc()
{
	var param =  $("#inquiryform").serialize();
    $.ajax({
    	url: '/buyhome/saleinquiryProc',
    	type: 'POST',
    	contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    	data: param,
    	dataType: 'text',
    	success: function(result){
      		if(result == 'SUCCESS')
          	{
              	var selnum = $('#selpopnum').val();
              	$('#inquiryBtn'+selnum).html('<button type="button" class="">문의<br>완료</button>')
              	
      			swal({
      			  	title: "문의완료!",
      			  	text: "문의 하신 내용이 등록 되었습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				popupClose();
      			});
      			return false;
      		}
      		else if(result == 'LOGIN') {
      			swal('로그인 후 문의 하세요!');
        		popupClose();
        		return false;
      		}
      		else {
        		swal('등록에 실패하였습니다.');
        		popupClose();
        		return false;
      		}
    	},
    	error:function(data){
     		swal('AJAX ERROR');
    	}
	});
}
</script>