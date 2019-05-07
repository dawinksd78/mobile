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
    <form id="realtorform" onsubmit="return false">
    <input type="hidden" name="idx" value="<?php echo $step4['GOODS_IDX']?>">
        <div class="sub_container">
            <div class="cont_wrap public_wrap sell_selbk">
                <h2 class="subj_tit"><span class="m_tit">중개사선택</span></h2>
                <div class="proc"> <a href="/mypage/step1_modify/<?php echo $step4['GOODS_IDX']?>" class="bul_proc prev"></a><a href="/mypage/step2_modify/<?php echo $step4['GOODS_IDX']?>" class="bul_proc prev"></a><a href="/mypage/step3_modify/<?php echo $step4['GOODS_IDX']?>" class="bul_proc prev"></a><a href="/mypage/step4_modify/<?php echo $step4['GOODS_IDX']?>" class="bul_proc on"></a></div>
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
                                            <input type="radio" <?php if($change_avail == "able" || $this->config->item('SERVERSTATE') == 'test') { ?> name="AGENCY_OPEN_FLAG" id="relat01" value="N" <?php } else {?> onClick="return false"<?php } ?> <?php echo ((!isset($step4['AGENCY_OPEN_FLAG']) && $step4['AGENCY_OPEN_FLAG']=='N') || count($realtor['data']) < 1) ? 'checked=""' : ""; ?>>
                                            <i></i><strong>인근 모든 중개사 자동 선택</strong>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="AGENCY_OPEN_FLAG_Y">
                                            <input type="radio" id="AGENCY_OPEN_FLAG_Y" onClick="<?php echo( $change_avail == "able" || $this->config->item('SERVERSTATE') == 'test' ) ? 'fnRealtorSelecter()' : 'popalert()'; ?>" name="AGENCY_OPEN_FLAG" value="Y" <?php echo ((isset($step4['AGENCY_OPEN_FLAG']) && $step4['AGENCY_OPEN_FLAG']=='Y') || count($realtor['data']) > 0) ? 'checked=""' : ""; ?>>
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
                                    //if($selbrokercnt > 0)
                                    //{
                                        //foreach($selbrokers as $selbrokerinfo)
                                        //{
                                            //if($brokerInfo['BROKER_OFFICE_IDX'] == $selbrokerinfo)
                                            //{
                                                $userimg = $brokerInfo['MBR_IMAGE_FULL_PATH'];
                                                if( $userimg == '' || empty($userimg) ) {
                                                    $userimg = "/images/btn_camera.png";
                                                }
                                                
                                                // 평점 이미지 출력
                                                $avgpercent = $brokerInfo['BROKER_POINT'] / 5 * 100;
                            ?>
                            <li class="agent_lst" data-idx="<?php echo $brokerInfo['BROKER_OFFICE_IDX']; ?>"> <a href="javascript:void(0);" data-officeidx="<?php echo $brokerInfo['BROKER_OFFICE_IDX']; ?>" class="del02" onClick="fnDelinUl(this)">삭제</a>
                                <div class="itm_inner">
                                    <div class="thumbnail_area">
                                        <div class="thumbnail" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><img src="<?php echo $userimg; ?>" alt="중개사사진" /></div>
                                    </div>
                                    <span class="agent_info">
                                        <div class="broker_info">
                                            <p class="commtype"><?php echo $brokerInfo['OFFICE_NAME']; ?> <i class="btn_loc" onclick="selmapview('<?php echo $brokerInfo['OFFICE_NAME']; ?>', '<?php echo $brokerInfo['LAT']; ?>', '<?php echo $brokerInfo['LNG']; ?>')"></i></p>
                                            <p class="bk_name" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><?php echo $brokerInfo['OFFICE_NAME']; ?></p>
                                            <div class="star_score" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $brokerInfo['BROKER_POINT']; ?></span></span> <span class="ct_review">(<?php echo $brokerInfo['BROKER_POINT_CNT']; ?>)</span> </div>
                                            <span class="p_num" onclick="goPagePop('/sellhome/step4_agentinfo/<?php echo $brokerInfo['MBR_IDX']; ?>');"><?php echo $brokerInfo['PHONE']; ?></span>
                                        </div>
                                    </span>
                                </div>
                                <input type="hidden" name="realtorselected[]" value="<?php echo $brokerInfo['BROKER_OFFICE_IDX']; ?>">
                            </li>
                            <?php
                                           // }
                                        //}
                                    //}
                                }
                            }
                            ?>
                        </ul>
                        
						<ul class="sel_al_inner" id="sel_al_inner"></ul>
                        
                        <?php if($selbrokercnt > 0) { ?>
                        <span class="agent_lst add_agent">
                            <button type="button" onClick="<?php echo ($change_avail == "able" || $this->config->item('SERVERSTATE') == 'test') ? 'fnRealtorSelecter()' : 'popalert()'; ?>">+ 중개사추가하기</button>
                        </span>
                        <br><br><br>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="modi_btn"><button class="btn_line03 btn_prev" type="button" onclick="goPage('/mypage/step3_modify/<?php echo $step4['GOODS_IDX']; ?>')">이전</button></div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" style="z-index:10000;" onclick="<?php echo ($change_avail == "able" || $this->config->item('SERVERSTATE') == 'test') ? 'fnSaveRelatorPrc()' : 'popalert()'; ?>">수정완료</button>
            </div>
        </div>
    </form>
    </section>
</div>

<?php if($this->config->item('SERVERSTATE') != 'test' && $change_avail != "able") { ?>
<!-- 중개사 선택 후 7일 이내에는 변경불가 팝업 -->
<div class="mask" id="bigmask" style="display:none"></div>
<div class="lyr lyrpop01" id="notChangeBrokerInfo" style="display:none;">
    <div class="lyr_inner">
        <p class="cont">중개사 선택 후 <b>7일간</b>은<br>중개사 변경을 할 수 없습니다.</p>
    </div>
    <div class="btn">
        <button type="button" class="btn_type02" onclick="notChangeBrokerInfoPop()">확인</button>
    </div>
</div>
<?php } ?>

<style>
.jconfirm .jconfirm-box div.jconfirm-title-c {
    padding:0;
    padding-bottom: 20px;
    padding-top: 20px;
    height:0;
}
.jconfirm-box.realtorEvalBox .header{
  padding-left: 20px;
}
.jconfirm-box.realtorEvalBox div.cont{padding:20px;}
.st_cont_msg{
  text-align: center;
    font-size: 17px;
    margin-bottom: 30px;
}
.st_alert_cont{
  margin-bottom: 30px;
}
.st_cont_btn_wrap{
  text-align: center;
}
.stn-confirm-btn{
  padding: 8px 40px;
  background: #7a1d05;
  border-color: #6E0709;
  color: #fff;
  font-size: 15px;
}
</style>

<script type="text/javascript">
var datachanged = false;
var isSaved = false;
var category = "";

var realtor_template, realtorMap, selli_template,ec_map2;
var lat = "<?php echo $step4['LAT']; ?>";
var lng = "<?php echo $step4['LNG']; ?>";

var goods_idx = "<?php echo $step4['GOODS_IDX']; ?>";

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
	<?php if($change_avail == "able" || $this->config->item('SERVERSTATE') == 'test') { ?>
    //$(ln).closest("li").remove();
    //datachanged = true;
    //isSaved = false;
    realtorchecked =[];
    $(ln).closest("li").remove();
    $('.agent_box input[name="realtorselected[]"]').each(function(){
	    realtorchecked.push($(this).val());
    });
	    
    var realtorchecked1 = JSON.stringify(realtorchecked); 
	var realtorchecked2 = encodeURIComponent(realtorchecked1);
    var param = "&brk_check=" + realtorchecked2;
	$.ajax({
        url:"/mypage/step4_brokercookie/j/" + goods_idx,
        type:"post",
        data: param,
        dataType: "json",
        success: function(result){
          	if(result.code == 'SUCCESS')
            {
          	    datachanged = false;
          	    isSaved = false;
            	location.href = "/mypage/step4_modify/" + goods_idx;
          	}
          	else {
          		swal("오류가 발생하였습니다.다시 시도해주세요.");
          	}
       	}
    });
    <?php } else { ?>
    popalert();
    <?php } ?>
}

// 중개사 추가
function fnRealtorSelecter()
{
    if( $("input[name=AGENCY_OPEN_FLAG]:checked").val() != 'Y' ) {
    	swal("[특정 중개사 선택]일때만 추가가 가능합니다.");
    	return;
    }
    
    location.href = "/mypage/step4_brokers_modify/" + goods_idx;
}

// 중개사 변경 불가 안내
function popalert()
{
	// 레이어 팝업창 오픈
	$('#bigmask').css('display', 'block');
	$('#notChangeBrokerInfo').css('display', 'block');
}
// 중개사 변경 불가 안내 닫기
function notChangeBrokerInfoPop()
{
	// 레이어 팝업창 닫기
	$('#bigmask').css('display', 'none');
	$('#notChangeBrokerInfo').css('display', 'none');
}
	
function fnSaveRelator()
{
  	if( $("input[name=AGENCY_OPEN_FLAG]:checked").val() == 'Y' )
  	{
  	  	/*
    	if(confirm("중개사 선택을 하시면 7일동안은 변경이 불가능 합니다.\n저장하시겠습니까?")) {
      		fnSaveRelatorPrc()
    	}
    	*/
  		swal({
  		    text: "중개사 선택을 하시면 7일동안은 변경이 불가능 합니다.\n저장하시겠습니까?",
  		    buttons: [
  		        'No',
  		        'Yes'
  		    ],
  		}).then(function(isConfirm) {
  			if(isConfirm) {
  				fnSaveRelatorPrc();
  			}
  			else {
  				return false;
  			}
  		});
  	}
  	else fnSaveRelatorPrc();
}

function fnSaveRelatorPrc()
{
    var param =  $("#realtorform").serialize();
    $.ajax({
        url: '/mypage/step4_modify_save/',
        type: 'POST',
        data: param,
        dataType: 'json',
        success: function (result) {
          	if(result.code == 200)
            {
          		swal({
          		  	title: "중개사 저장완료!",
          		  	text: "중개사 정보 저장이 되었습니다.",
          		  	icon: "success",
          		  	button: "확 인",
          		}).then(function(){ 
          			location.href = "/mypage/myhousesale";
          		});
          	}
          	else {
            	swal(result.msg);
          	}
        },
        error: function(request, status, error) {
        	swal("잠시후에 다시 시도해 주세요!")
        }
    });
}

// 저장 후 이전 페이지로
function savePrev()
{
	<?php if($change_avail == "able" || $this->config->item('SERVERSTATE') == 'test') { ?>
		var param =  $("#realtorform").serialize();
	    $.ajax({
	        url: '/mypage/step4_modify_save/',
	        type: 'POST',
	        data: param,
	        dataType: 'json',
	        success: function (result) {
	          	if(result.code == 200) {
	          		location.href = "/mypage/step3_modify/<?php echo $step4['GOODS_IDX']; ?>";
	          	}
	          	else {
	            	swal(result.msg);
	          	}
	        },
	        error: function(request, status, error) {
	        	swal("잠시후에 다시 시도해 주세요!")
	        }
	    });
	<?php } else { ?>
		location.href = "/mypage/step3_modify/<?php echo $step4['GOODS_IDX']; ?>";
    <?php } ?>
}

$("document").ready( function() {
	<?php if($this->config->item('SERVERSTATE') != 'test' && $change_avail != "able") { ?>
		popalert();
	<?php } ?>
	
	$(window).on("beforeunload", function(){
		if (datachanged == true)  return false;
	});
	
	/*selli_template = _.template( $("#realtorli").html() );
	$("input[type=radio][name=AGENCY_OPEN_FLAG]").on("click", function(){
	    if( $(this).val() =='N' && $("#sel_al_inner li").length > 0 )
		{
	      	if( confirm("선택한 중개사가 있습니다.\n선택한 중개사를 삭제하시겠습니까?.") ){
	        	$("#sel_al_inner").empty();
	        	datachanged = true;
	      	}
	      	else {
	        	$("#AGENCY_OPEN_FLAG_Y").prop("checked", true);
	      	}
	    }
	});*/

	//initSelectedRelator();
});
</script>
