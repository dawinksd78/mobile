<div id="dawinWrap" class="mpwrap">
    <header id="header" class="header maphd">
    	<span class="btn_back back02">
        	<button type="button" onclick="history.back();"><span>뒤로</span></button>
        </span>
        <span class="btn_alarm">
        	<button type="button" onclick="goPage('/mypage/alarm')"><span>알람</span></button>
        </span>
        
        <!-- hamburgerMenu -->
      	<script>hamburgerMenuList('menu_wh');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="infobox">
                <div class="user_info">
                    <p class="name"><?php echo $this->userinfo['MBR_NAME']; ?></p>
                    <p class="id"><?php echo $this->userinfo['MBR_EMAIL']; ?></p>
                </div>
                <div class="mp_tab">
                    <ul>
                        <li><a href="#" onclick="goPage('/mypage/myzzimsale')">내집구하기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myhousesale')" class="on">내집내놓기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinfo')">내정보</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinquiry')">1:1문의</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="cont_wrap public_cont02 mp mp_sell">
                <div class="cont">
                    <div class="itmcard_wrap">
                        <?php if( count($items) < 1 ) { ?>
                            <!-- 등록한 매물이 없는 경우 -->
                            <div class="no_itm">
                              <p>내가 내놓은 매물이 없습니다.</p>
                              <div class="btn">
                                  <button type="button" class="btn_line04" onclick="goPage('/sellhome/main');">+ 매물등록하기</button>
                              </div>
                            </div>
                        <?php } ?>
                        
                        <?php if( count($items) > 0 ) { ?>
                        	<!-- 등록한 매물 리스트 -->
                            <div class="cont_exp">
                                <p>내가 등록한 매물입니다.</p>
                            </div>
                            <ul class="itm_box">
                                <?php foreach ($items as $row) { ?>
                                <?php
                                switch( $row['TRADE_TYPE'])
                                {
                                    case("3"):
                                        $tradeType = number_format($row['PRICE2'])."/".$row['PRICE3'];
                                    break;
                                    
                                    case("2"):
                                        $tradeType = "<span class='changeaboutmoney'>".($row['PRICE2']*10000)."</span>";
                                    break;
                                    
                                    default:
                                        $tradeType = "<span class='changeaboutmoney'>".($row['PRICE1']*10000)."</span>";
                                    break;
                                }
                                ?>
                                    <li class="itm_lst aptitm">
                                        <div class="itm_inner">
                                            <?php if ( $row['GOODS_STATUS'] !='SB' || $row['GOODS_PROCESS_STATUS'] !='PS2') {?>
                                                <div class="sd_wrap">
                                                    <?php if( $row['GOODS_STATUS'] != 'SB') { ?>
                                                    <div class="mask"></div>
                                                    <?php } ?>
                                                    
                                                    <!-- 처리상태 -->
                                                    <?php if( $row['GOODS_STATUS'] == 'BL') { ?>
                                                    	<!-- 등록대기중 -->
                                                    	<div class="del"> <span class="txt">등록대기중</span> </div>
                                                    <?php } else if ( $row['GOODS_STATUS'] == 'CF') { ?>
                                                    	<!-- 삭제요청중 -->
                                                    	<div class="del"> <span class="txt">삭제요청중</span><span class="date"><?php echo $row['TRADE_DATE']?></span> </div>
                                                    <?php } else if ( $row['GOODS_STATUS'] == 'DR') { ?>
                                                    	<!-- 거래완료 -->
                                                    	<div class="soldout"> <span class="txt">거래완료</span><span class="date"><?php echo $row['TRADE_DATE']?></span> </div>
                                                    <?php } else if ($row['GOODS_STATUS'] == 'RC') { ?>
                                                    	<!-- 등록취소완료 -->
                                                    	<div class="del"> <span class="txt">등록취소완료</span> </div>
                                                    <?php } else if ($row['GOODS_STATUS'] == 'TR') { ?>
                                                    	<!-- 매물삭제완료 -->
                                                    	<div class="del"> <span class="txt">매물삭제완료</span> </div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            
                                            <div class="itm_pic">
                                                <div class="itm_thumb"><img src="<?php echo (isset($row['DEFAULT_IMG_PATH'])) ? $row['DEFAULT_IMG_PATH'] : '/images/img_noimg02.png'; ?>" alt="매물사진" /></div>
                                            </div>
                                            
                                            
                                            <?php
                                            /*if($getDevideCookie == '1' && $DEVICE == 'AND') {
                                                $pageLink = "javascript:dawin_newpop('/buyhome/saledetail/".$row['GOODS_IDX']."');";
                                            }
                                            else {
                                                $pageLink = "javascript:goPagePop('/buyhome/saledetail/".$row['GOODS_IDX']."');";
                                            }*/
                                            $pageLink = "javascript:goPage('/buyhome/saledetail/".$row['GOODS_IDX']."');";
                                            ?>
                                            
                                            <?php if($row['CATEGORY'] != 'ONE') { ?>
                                            <a class="itm_info" href="<?php echo $pageLink; ?>">
                                                <div class="itm_exp">
                                                  	<p class="info01"><?php echo $row['COMPLEX_NAME']; ?> <?php echo $row['DONG']; ?>동</p>
                                                  	<p class="price bolder">
                                                  		<span class="s_type0<?php echo $row['TRADE_TYPE']?>"><b><?php echo ($row['TRADE_TYPE'] == 3) ? "월세" : ( $row['TRADE_TYPE'] == 2 ? "전세" : "매매"); ?></b></span>
                                                  		<span><?php echo $tradeType; ?></span>
                                                  	</p>
                                                  	<p class="ex_info"><span><?php echo $row['FLOOR']; ?>층/<?php echo $row['TOTAL_FLOOR']; ?>층</span></p>                                  
                                                  	<p class="area"><?php echo $row['AREA1']; ?>m²(<?php echo number_format($row['AREA1']/3.3058,1); ?>평) / <?php echo $row['AREA2']; ?>m²(<?php echo number_format($row['AREA2']/3.3058,1); ?>평)</p>
                                                </div>
                                            </a>
                                            <?php } else { ?>
                                            <a class="itm_info" href="<?php echo $pageLink; ?>">
                                                <div class="itm_exp">
                                                    <p class="price bolder">
                                                    	<span class="s_type0<?php echo $row['TRADE_TYPE']?>"><b><?php echo ($row['TRADE_TYPE'] == 3) ? "월세" : ($row['TRADE_TYPE'] == 2 ? "전세" : "매매"); ?></b> <?php echo $tradeType; ?></span>
                                                    </p>
                                                    <p class="area"><?php echo $row['AREA1']; ?>m² (<span><?php echo number_format($row['AREA1']/3.3058,1); ?>평형</span>)</p>
                                                    <p class="ex_info"><?php  echo (isset( $ROOM_TYPE[ $row['ROOM_TYPE'] ])) ? $ROOM_TYPE[ $row['ROOM_TYPE'] ] : '-'; ?>, <?php echo $row['FLOOR']; ?>층/총 <?php echo $row['TOTAL_FLOOR']; ?>층<br>반려동물<?php echo $row['ANIMAL']=='' ? " - " : ($row['ANIMAL']=='1' ? '가능' : '불가'); ?>, 주차<?php echo $row['PARKING_FLAG']=='' ? " - " : ($row['PARKING_FLAG']=='Y' ? '가능' : '불가'); ?></p>
                                                </div>
                                            </a>
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="btn double">
                                            <?php if($row['GOODS_STATUS'] =='BL') { ?>
                                            	<button type="button" onclick="cancelDataPopupOpen('<?php echo $row['GOODS_IDX']; ?>')" class="btn_line02">등록요청취소</button>
                                            	<button type="button" class="btn_line02" onClick="location.href='/mypage/step1_modify/<?php echo $row['GOODS_IDX']; ?>'">매물정보수정</button>
                                            <?php } else if($row['GOODS_STATUS'] =='DR') { ?>
                                            	<button type="button" class="btn_line02" onclick="contractview()">계약서보기</button>
                                        		<button type="button" class="btn_line02" data-goods="<?php echo $row['GOODS_IDX']; ?>" data-idx="<?php echo $row['BROKER_OFFICE_IDX']?>" <?php echo ($row['iseval'] =='N' && $row['BROKER_OFFICE_IDX']>0) ? 'onClick="fnRealtorEval(this)"' : 'disabled'?>>중개평가하기</button>
                                            <?php } else if($row['GOODS_STATUS']=='TR' || $row['GOODS_STATUS']=='RC') { ?>
                    						<?php } else { ?>
                    							<button type="button" class="btn_line02" data-idx="<?php echo $row['GOODS_IDX']; ?>" <?php echo ($row['GOODS_STATUS']=='CF') ? 'onClick="swal(\'현재 삭제요청중입니다.\')"' : 'onClick="deleteDataPopupOpen(this)"'; ?>><?php  echo ($row['GOODS_STATUS'] =='CF') ? "삭제요청중" : "매물삭제"; ?></button>
                                        		<button type="button" class="btn_line02" onClick="location.href='/mypage/step1_modify/<?php echo $row['GOODS_IDX']; ?>'">매물정보수정</button>
                    						<?php } ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- 레이어팝업 -->
    <div class="mask" id="bigmask" style="display:none;"></div>
    
    <!-- 매물등록요청을 취소 클릭시 팝업 -->
    <div class="lyr lyrpop01" id="cancelDataPopup" style="display:none;"> 
        <div class="lyr_inner">
            <p class="cont">매물등록요청을 취소하시겠습니까?</p>
        </div>
        <div class="btn double">
            <button type="button" onclick="cancelDataPopupClose()" class="btn_type06">아니오</button>
            <button type="button" class="btn_type02" onclick="cancelDataReqProc()">예</button>
        </div>
    </div>
    
    <!-- 매물삭제 클릭시 팝업 -->
    <div class="lyr lyrpop01" id="deleteDataPopup" style="display:none;"> 
        <div class="lyr_inner">
            <p class="cont">매물 삭제 하시겠습니까?</p>
        </div>
        <div class="btn double">
            <button type="button" onclick="deleteDataPopupClose()" class="btn_type06">아니오</button>
            <button type="button" class="btn_type02" onclick="deleteDataReqProc()">예</button>
        </div>
    </div>
    
    <!-- 계약서보기 클릭시 팝업 -->
    <div class="lyr lyrpop01" id="contractPopup" style="display:none;"> 
        <div class="lyr_inner">
            <p class="cont">계약서보기는 PC버전에서만 지원합니다.</p>
        </div>
        <div class="btn">
            <button type="button" class="btn_type02" onclick="contractviewclose()">확인</button>
        </div>
    </div>
</div>

<!-- 등록요청취소 선택값 -->
<input type="hidden" name="cancelDataNumber" id="cancelDataNumber">

<!-- 매물삭제 선택값 -->
<input type="hidden" name="deleteDataNumber" id="deleteDataNumber">

<script type="text/javascript">
var prevScroll = $.cookie('myhousesalePostion');

$("document").ready(function(){
	if(prevScroll > 0 && prevScroll != 'undefined') {
		$(".cont_wrap").scrollTop(prevScroll);
	}
	
	$(".cont_wrap").on('scroll', function(){
	    var scrollValue = $(this).scrollTop();
	    $.cookie('myhousesalePostion', scrollValue);
	});
	
  	$(".changeaboutmoney").each( function() {
    	$(this).text( fnMoneyAboutText($(this).text() ) )
  	});
});

// 매물등록하기 페이지로 이동
$(".btn_line04").click(function(){
	location.href = "/sellhome/main";
});

// 등록요청취소 팝업오픈
function cancelDataPopupOpen(goodsidx)
{
	// 값 제거
	$('#cancelDataNumber').val(goodsidx);
	
	// 레이어 팝업창 오픈
	$('#bigmask').css('display', 'block');
	$('#cancelDataPopup').css('display', 'block');
}
// 등록요청취소 처리
function cancelDataReqProc()
{
    $.ajax({
		url: "/mypage/myhousesellcancel",
		type: "post",
		data: { idx : $('#cancelDataNumber').val() },
		dataType: "json" ,
		success: function(result){
			if(result.code == 200 || result.code == 521)
			{
				swal({
      			  	title: "등록취소완료!",
      			  	text: "등록요청취소가 완료 되었습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				location.reload();
      			});
      			return false;
		    }
		    else if(result.code == 501)
			{
		    	location.reload();
		    }
		    else {
		       	swal(result.msg);
		       	cancelDataPopupClose();
		       	return false;
		    }
      	},
      	error: function(request, status, error) {
         	swal('오류가 발생하였습니다. 다시 시도해 주세요.');
    		cancelDataPopupClose()
    		return false;
       	},
       	beforeSend: function() {
         	$('#ajax_loader').show();
        },
        complete: function(){
         	$('#ajax_loader').hide();
        }
    });
}

// 매물등록요청취소 팝업닫기
function cancelDataPopupClose()
{
	// 값 제거
	$('#cancelDataNumber').val('');

	// 레이어 팝업창 닫기
	$('#bigmask').css('display', 'none');
	$('#cancelDataPopup').css('display', 'none');
}

//--------------------------------------------------//

// 계약서 보기 알림창
function contractview()
{
	// 레이어 팝업창 열기
	$('#bigmask').css('display', 'block');
	$('#contractPopup').css('display', 'block');
}

// 계약서 보기 알림창 닫기
function contractviewclose()
{
	// 레이어 팝업창 열기
	$('#bigmask').css('display', 'none');
	$('#contractPopup').css('display', 'none');
}

//--------------------------------------------------//

//매물삭제 팝업오픈
function deleteDataPopupOpen(bt)
{
	// 값 입력
	$('#deleteDataNumber').val($(bt).data("idx"));
	
	// 레이어 팝업창 오픈
	$('#bigmask').css('display', 'block');
	$('#deleteDataPopup').css('display', 'block');
}
//매물삭제 처리
function deleteDataReqProc() {
    location.href = "/mypage/myhousedelete/" + $('#deleteDataNumber').val();
}

//매물삭제 팝업닫기
function deleteDataPopupClose()
{
	// 값 제거
	$('#deleteDataNumber').val('');

	// 레이어 팝업창 닫기
	$('#bigmask').css('display', 'none');
	$('#deleteDataPopup').css('display', 'none');
}

// 중개평가하기
function fnRealtorEval(bt) {
	location.href = "/mypage/evaluation?evaltype=sell&broker_idx=" + $(bt).data("idx") + "&goods_idx=" + $(bt).data("goods");
}
</script>