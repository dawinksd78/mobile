<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="backmain('/sellhome/main');"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">집내놓기</h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
    <form id="realtorform" onsubmit="return false">
        <div class="sub_container">
            <div class="cont_wrap public_wrap sell_selbk">
                <h2 class="subj_tit"><span class="m_tit">중개사 선택</span></h2>
                <div class="proc"> <a href="" class="bul_proc prev"></a><a href="" class="bul_proc prev"></a><a href="" class="bul_proc prev"></a><a href="" class="bul_proc on"></a></div>
                <div class="cont">
                
                    <div class="cont_t">
                        <div class="">
                            <p>매물을 내놓을 중개사를 선택하실 수 있습니다 (이 경우 선택하신 중개사들에게만 연락처가 공개됩니다.)<br>중개사를 선택하지 않은 경우에는 인근 중개사 모두에게 연락처가 공개됩니다.</p>
                        </div>
                        <div class="inpbox">
                            <div class="selec_option">
                                <div class="radio_box">
                                    <div class="radio">
                                        <label for="rept01">
                                            <input type="radio" name="AGENCY_OPEN_FLAG" id="rept01" value="N" onclick="selBrokerDel()" <?php echo ( !isset($step4['AGENCY_OPEN_FLAG']) || $step4['AGENCY_OPEN_FLAG']=='N') ? 'checked=""':""?>>
                                            <i></i><strong>인근 모든 중개사 자동 선택</strong>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="AGENCY_OPEN_FLAG_Y">
                                            <input type="radio" name="AGENCY_OPEN_FLAG" id="AGENCY_OPEN_FLAG_Y" value="Y"  onClick="fnRealtorSelecter()" <?php echo (/*(isset($step4['AGENCY_OPEN_FLAG']) && $step4['AGENCY_OPEN_FLAG']=='Y')*/$selbrokercnt > 0) ? 'checked=""' : ""; ?>>
                                            <i></i><strong>특정 중개사 선택</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="agcard_wrap selc_bk">
                        <ul class="agent_box">
                            <?php
                            if(count($realtor['data']) > 0)
                            {
                                foreach($realtor['data'] as $brokerInfo)
                                {
                                    /*if($selbrokercnt > 0)
                                    {
                                        foreach($selbrokers as $selbrokerinfo)
                                        {
                                            if($brokerInfo['BROKER_OFFICE_IDX'] == $selbrokerinfo)
                                            {*/
                                                $userimg = $brokerInfo['MBR_IMAGE_FULL_PATH'];
                                                if( $userimg == '' || empty($userimg) ) {
                                                    $userimg = "/images/btn_camera.png";
                                                }
                                                
                                                // 평점 이미지 출력
                                                $avgpercent = $brokerInfo['BROKER_POINT'] / 5 * 100;
                            ?>
                            <li class="agent_lst" data-idx="<?php echo $brokerInfo['BROKER_OFFICE_IDX']; ?>"> <a href="javascript:void(0);" class="del02" onClick="fnDelinUl(this)">삭제</a>
                                <div class="itm_inner">
                                    <div class="thumbnail_area">
                                        <div class="thumbnail" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><img src="<?php echo $userimg; ?>" alt="중개사사진" /></div>
                                    </div>
                                    <a class="agent_info">
                                        <div class="broker_info">
                                            <p class="commtype"><?php echo $brokerInfo['OFFICE_NAME']; ?> <i class="btn_loc" onclick="selmapview('<?php echo $brokerInfo['OFFICE_NAME']; ?>', '<?php echo $brokerInfo['LAT']; ?>', '<?php echo $brokerInfo['LNG']; ?>')"></i></p>
                                            <p class="bk_name" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><?php echo $brokerInfo['OFFICE_NAME']; ?></p>
                                            <div class="star_score" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $brokerInfo['BROKER_POINT']; ?></span></span> <span href="" class="ct_review">(<?php echo $brokerInfo['BROKER_POINT_CNT']; ?>)</span> </div>
                                            <span class="p_num" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><?php echo $brokerInfo['PHONE']; ?></span>
                                        </div>
                                    </a>
                                </div>
                                <input type="hidden" name="realtorselected[]" value="<?php echo $brokerInfo['BROKER_OFFICE_IDX']; ?>">
                            </li>
                            <?php
                                            /*}
                                        }
                                    }*/
                                }
                            }
                            ?>
                        </ul>
                        
                        <?php if($selbrokers > 0) { ?>
                        <span class="agent_lst add_agent">
                            <button type="button" onClick="fnRealtorSelecter()">+ 중개사추가하기</button>
                        </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn double" style="z-index:10000;">
                <button type="button" class="btn_type03" onclick="goPage('/sellhome/step3/<?php echo $CATEGORY; ?>');" style="z-index:10000;">이전</button>
                <button type="button" class="btn_type02" onclick="fnSave()" style="z-index:10000;">다음</button>
            </div>
        </div>
    </form>
    </section>
</div>

<!-- 매물등록, 삭제요청 클릭시 팝업 -->
<div class="mask" style="display:none"></div>
<div class="lyr lyrpop01" style="display:none">
    <div class="lyr_inner">
        <p class="cont">중개사 선택 후 <b>7일간</b>은<br>중개사 변경을 할 수 없습니다.</p>
    </div>
    <div class="btn">
        <button type="button" class="btn_type02">확인</button>
    </div>
</div>

<script type="text/javascript">
var datachanged = false;
var isSaved = false;
var category = "<?php echo $CATEGORY; ?>";

var realtor_template, realtorMap, selli_template,ec_map2;
var realtordata = <?php echo json_encode($realtor, true); ?>;
var realtorchecked = <?php echo json_encode($relatorChecked, true); ?>;
var lat ="<?php echo $lat?>";
var lng ="<?php echo $lng?>";

//위치지도보기
function selmapview(office, lat, lng)
{
	$('#office_name').val(office);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);

	// 지도 출력
	officeposition();
}

function fnDelinUl(ln)
{
	realtorchecked =[];
    $(ln).closest("li").remove();
    $('.agent_box input[name="realtorselected[]"]').each(function(){
	    realtorchecked.push($(this).val());
    });
	    
    var realtorchecked1 = JSON.stringify(realtorchecked); 
	var realtorchecked2 = encodeURIComponent(realtorchecked1);
    var param = "&brk_check=" + realtorchecked2;
	$.ajax({
        url:"/sellhome/step4_brokercookie/j",
        type:"post",
        data: param,
        dataType: "json",
        success: function(result){
          	if(result.code == 'SUCCESS')
            {
          	    datachanged = true;
          	    isSaved = false;
            	location.href = "/sellhome/step4/" + category;
          	}
          	else {
          		swal("오류가 발생하였습니다.다시 시도해주세요.");
          	}
       	}
    });
}

// 중개사 추가
function fnRealtorSelecter()
{
    if( $("input[name=AGENCY_OPEN_FLAG]:checked").val() != 'Y' ) {
    	swal("[특정 중개사 선택]일때만 추가가 가능합니다.");
    	return;
    }
    
    location.href = "/sellhome/step4_brokers/" + category;
}

// 인근 모든 중개사 자동 선택시 특정 중개사 선택 제거
function selBrokerDel()
{
	$.ajax({
    	url: '/sellhome/step4_brokercookie_del/',
    	type: 'POST',
    	dataType: 'text',
    	success: function(result){
      		if(result == 'OK') {
        		datachanged = false;
        		location.href = "/sellhome/step4/" + category;
      		}
      		else {
        		swal(result.msg);
      		}
    	},
    	error : function(request, status, error) {
      		console.log(error);
    	},
	});
}

// 저장후 페이지 이동
function fnSave()
{
	if( $("input[name=AGENCY_OPEN_FLAG]:checked").val() != 'Y' )
	{
		/*
    	if(confirm('인근 모든 중개사를 선택하시겠습니까?'))
    	{
            var param =  $("#realtorform").serialize() + "&CATEGORY="+category+"&step=step_4";
            $.ajax({
            	url: '/sellhome/saveStep4/',
            	type: 'POST',
            	data: param,
            	dataType: 'json',
            	success: function(result){
              		if(result.code == 200) {
                		datachanged = false;
                		location.href = "/sellhome/saveLast/" + category;
              		}
              		else {
                		swal(result.msg);
              		}
            	},
            	error : function(request, status, error) {
              		console.log(error);
            	},
        	});
    	}
    	else {
    		return false;
    	}
    	*/
		swal({
		    text: "인근 모든 중개사를 선택하시겠습니까?",
		    buttons: [
		        'No',
		        'Yes'
		    ],
		}).then(function(isConfirm) {
			if(isConfirm)
			{
				var param =  $("#realtorform").serialize() + "&CATEGORY="+category+"&step=step_4";
	            $.ajax({
	            	url: '/sellhome/saveStep4/',
	            	type: 'POST',
	            	data: param,
	            	dataType: 'json',
	            	success: function(result){
	              		if(result.code == 200) {
	                		datachanged = false;
	                		location.href = "/sellhome/saveLast/" + category;
	              		}
	              		else {
	                		swal(result.msg);
	              		}
	            	},
	            	error : function(request, status, error) {
	              		console.log(error);
	            	},
	        	});
			}
			else {
				return false;
			}
		});
	}
	else
	{
		var param =  $("#realtorform").serialize() + "&CATEGORY="+category+"&step=step_4";
        $.ajax({
        	url: '/sellhome/saveStep4/',
        	type: 'POST',
        	data: param,
        	dataType: 'json',
        	success: function(result){
          		if(result.code == 200) {
            		datachanged = false;
            		location.href = "/sellhome/saveLast/" + category;
          		}
          		else {
            		swal(result.msg);
          		}
        	},
        	error : function(request, status, error) {
          		console.log(error);
        	},
    	});
	}
}
</script>