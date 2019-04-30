<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">(매물의뢰한) 중개사선택</h2>
    </header>
    
    <section id="container">
        <div class="sub_container subg02">
            <div class="cont_wrap contw02">
                <div class="agcard_wrap">
                    <ul class="agent_box">
                        <?php
                        $i = 1;
                        foreach($brokerlist as $info)
                        {
                            // 이미지 출력
                            if($info['BIZ_LICENSE_IMG'] != '' || !empty($info['BIZ_LICENSE_IMG'])) {
                                $thumnail = $info['BIZ_LICENSE_IMG'];
                            }
                            else {
                                $thumnail = "/images/btn_camera.png";
                            }
                            
                            // 평점 이미지 출력
                            $avgpercent = $info['BROKER_POINT'] / 5 * 100;
                        ?>
                        <li class="agent_lst">
                            <div class="itm_inner">
                                <div class="thumbnail_area">
                                    <div class="thumbnail"><img src="<?php echo $thumnail; ?>" alt="중개사사진" /></div>
                                </div>
                                <a class="agent_info">
                                	<div class="broker_info">
                                        <p class="commtype"><?php echo $info['OFFICE_NAME']; ?> <i class="btn_loc" style="z-index:1000;" onclick="selmapview('<?php echo $info['OFFICE_NAME']; ?>', '<?php echo $info['LAT']; ?>', '<?php echo $info['LNG']; ?>')"></i></p>
                                        <p class="bk_name"><?php echo $info['MBR_NAME']; ?></p>
                                        <div class="star_score"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $info['BROKER_POINT']; ?></span></span> <span href="" class="ct_review">(<?php echo number_format($info['BROKER_POINT_CNT']); ?>)</span> </div>
                                        <span class="p_num"><?php echo $info['PHONE']; ?></span>
                                    </div>
                                </a>
                                <div class="check_box chkbox02">
                                    <div class="check">
                                        <form>
                                            <label for="chkag0<?php echo $i; ?>">
                                                <input type="checkbox" name="brk_check" id="chkag0<?php echo $i; ?>" value="<?php echo $info['BROKER_OFFICE_IDX'] ?>">
                                                <i></i>
                                            </label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php $i++; } ?>
                    </ul>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03 on">확인</button>
            </div>
        </div>
    </section>
</div>

<input type="hidden" name="brokeridx" id="brokeridx">

<script type="text/javascript">
// 체크박스 해제
$("input:checkbox[name=brk_check]").click(function() {
	var customerNumber = $(this).val();
	$("input:checked[name=brk_check]").each(function() {
		if(customerNumber != $(this).val()) {
			$(this).attr("checked", false); // uncheck all checkboxes
		}
	});
});

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
$(".btn_type03").click(function(){
	var brokeridx;
    $.each($("input[name='brk_check']:checked"), function() {
    	brokeridx = $(this).val();
    });
    
	location.href = "/board/reportbroker/?brokeridx="+brokeridx;
});
</script>