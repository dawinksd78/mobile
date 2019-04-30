<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">중개사선택</h2>
    </header>
    
    <section id="container">
    <form name="brokerform" id="brokerform" onsubmit="return false">
        <div class="sub_container subg02">
            <div class="cont_wrap contw02">
                <div class="agcard_wrap">
                
                    <ul class="agent_box">

                        <?php
                        foreach($realtor['data'] as $brokerlist)
                        {
                            $userimg = $brokerlist['MBR_IMAGE_FULL_PATH'];
                            if( $userimg == '' || empty($userimg) ) {
                                $userimg = "/images/btn_camera.png";
                            }
                            
                            $brokerSel = false;
                            $result = explode(',', $selbroker);
                            for($i=0; $i<count($result); $i++) {
                                if($brokerlist['MBR_IDX'] == $result[$i]) {
                                    $brokerSel = true;
                                    break;
                                }
                            }
                            
                            // 평점 이미지 출력
                            $avgpercent = $brokerlist['BROKER_POINT'] / 5 * 100;
                        ?>
                        <li class="agent_lst">
                            <div class="itm_inner">
                                <div class="thumbnail_area">
                                    <div class="thumbnail"><img src="<?php echo $userimg; ?>" alt="중개사사진" onclick="goPagePopup('/sellhome/step4_agentinfo/<?php echo $brokerlist['MBR_IDX']; ?>')" /></div>
                                </div>
                                <a class="agent_info">
                                    <div class="broker_info">
                                        <p class="commtype"><span onclick="goPagePopup('/sellhome/step4_agentinfo/<?php echo $brokerlist['MBR_IDX']; ?>')"><?php echo $brokerlist['OFFICE_NAME']; ?></span> <i class="btn_loc" onclick="selmapview('<?php echo $brokerlist['OFFICE_NAME']; ?>', '<?php echo $brokerlist['LAT']; ?>', '<?php echo $brokerlist['LNG']; ?>')"></i></p>
                                        <p class="bk_name" onclick="goPagePopup('/sellhome/step4_agentinfo/<?php echo $brokerlist['MBR_IDX']; ?>')"><?php echo $brokerlist['MBR_NAME']; ?></p>
                                        <div class="star_score" onclick="goPagePopup('/sellhome/step4_agentinfo/<?php echo $brokerlist['MBR_IDX']; ?>')"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $brokerlist['BROKER_POINT']; ?></span></span> <span class="ct_review">(<?php echo $brokerlist['BROKER_POINT_CNT']; ?>)</span> </div>
                                        <span class="p_num" onclick="goPagePopup('/sellhome/step4_agentinfo/<?php echo $brokerlist['MBR_IDX']; ?>')"><?php echo $brokerlist['PHONE']; ?></span>
                                    </div>
                                </a>
                                <div class="check_box chkbox02">
                                    <div class="check">
                                        <label for="chkag<?php echo $brokerlist['MBR_IDX']; ?>">
                                            <input type="checkbox" name="brk_check[]" id="chkag<?php echo $brokerlist['MBR_IDX']; ?>" value="<?php echo $brokerlist['MBR_IDX']; ?>" <?php if($brokerSel == true) { echo "checked"; } ?>>
                                            <i></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                                                
                    </ul>
                </div>
            </div>
            
            <div class="btn_area bot_btn" style="z-index:10000;">
                <button class="btn_type03 on" type="button" onclick="brokerSelect()" style="z-index:10000;">중개사선택완료</button>
            </div>
        </div>
    </form>
    </section>
</div>

<input type="hidden" name="brokeridx" id="brokeridx">

<script type="text/javascript">
var datachanged = false;
var isSaved = false;
var category = "<?php echo $CATEGORY; ?>";

var goods_idx = "<?php echo $step4['GOODS_IDX']; ?>";

// 체크박스 해제
$("input:checkbox[name=brk_check]").click(function() {
	var customerNumber = $(this).val();
	$("input:checked[name=brk_check]").each(function() {
		if(customerNumber != $(this).val()) {
			$(this).attr("checked", false); // uncheck all checkboxes
		}
	});
});

// 중개사 정보 보기
function goPagePopup(url) {
	window.open(url);
}

// 위치지도보기
function selmapview(office, lat, lng)
{
	$('#office_name').val(office);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);

	// 지도 출력
	officeposition();
}

// 신고페이지로 이동
/*$(".btn_type03").click(function(){
    var docs = document.brokerform;
    docs.method = "POST";
	docs.action = "/mypage/step4_modify/" + goods_idx;
	docs.submit();
});*/

//중개사선택완료
function brokerSelect()
{
	var param = $("#brokerform").serialize();
	$.ajax({
        url:"/mypage/step4_brokercookie/p",
        type:"post",
        data: param,
        dataType: "json",
        success: function(result){
          	if(result.code == 'SUCCESS') {
            	location.href = "/mypage/step4_modify/" + goods_idx;
          	}
          	else {
          		swal("오류가 발생하였습니다.다시 시도해주세요.");
          	}
       	}
    });
}
</script>