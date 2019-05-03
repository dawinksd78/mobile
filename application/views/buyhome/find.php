<?php
$saletypeData = $this->input->get('sale_type');
switch($saletypeData)
{
    case ('OFT') :
        $sale_type_cmt = '오피스텔';
        $saletypedefault = "OFT";
    break;
    
    case ('ONE') :
        $sale_type_cmt = '원룸/투룸';
        $saletypedefault = "ONE";
    break;
    
    default :
        $sale_type_cmt = '아파트';
        $saletypedefault = "APT";
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<link rel="stylesheet" href="/css/swiper.min.css">

<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    <form id="filter_form" name="filter_form" onsubmit="return false;">
        <div class="sch_box">
            <div class="inpout">
                <input type="text" id="main_searchtab_keyword" name="main_search_keyword" value="<?php echo $keyword; ?>" onkeyup="delicon()" onkeydown="delicon()" class="inp issearchclass" autocomplete="off" placeholder="지역,지하철역,아파트명 검색" title="아파트이름검색">
                <div class="btn_sch">
                    <button type="button" onClick="fnkeywordSearch();"><span>검색</span></button>
                </div>
                <button class="btn_del02" id="searchbtndel" onclick="searchKeywordDel()" style="display:<?php echo ($keyword) ? '' : 'none' ; ?>;">삭제</button>
            </div>
            
            <!-- 검색결과 영역 -->
            <div class="sch_result" id="search_result" style="z-index:101; display:none;">
                <ul>
                    <li><p class="sch_word issearchclass"></p></li>
                </ul>
            </div>
            <!-- //검색결과 영역 끝 --> 
        </div>
      	
      	<div class="sub_filter">
          	<ul class="sub_filter_inner">
                <li class=""><a href="javascript:void(0);" onclick="filterSelect('sale')" class="filterTypes on" id="filerMenuName_sale"><?php echo $sale_type_cmt; ?></a></li>
                <li class=""><a href="javascript:void(0);" onclick="filterSelect('deal')" class="filterTypes" id="filerMenuName_deal">거래유형</a></li>
                <li class=""><a href="javascript:void(0);" onclick="filterSelect('area')" class="filterTypes" id="filerMenuName_area">면적</a></li>
                <li class=""><a href="javascript:void(0);" onclick="filterSelect('roomtype')" class="filterTypes" id="filerMenuName_roomtype" style="display:<?php echo ($saletypedefault == 'ONE') ? '' : 'none'; ?>;">방구조</a></li>
                <li class=""><a href="javascript:void(0);" onclick="filterSelect('price')" class="filterTypes" id="filerMenuName_price" style="display:none;">금액</a></li><?php //echo ($saletypedefault == 'ONE') ? '' : 'none'; ?>
                <li class=""></li>
          	</ul>
        </div>
                
        <!-- 필터박스 -->
    	<div class="sub_filter_group filter_cont" style="z-index:100;" style="display:none;">
        
          	<!-- 매물종류 -->
          	<div class="inpbox rdinp searchfilterbox" id="searchfilterbox_sale" style="display:none;">
              	<div class="radio_box02">
                    <div class="rd01 rd02">
                      	<input type="radio" id="type_rd01" name="saletype" value="APT" data-default="<?php echo $saletypedefault?>" <?php echo ($saletypedefault == '' || $saletypedefault =='APT') ? 'checked' : ''; ?>>
                      	<label for="type_rd01">아파트</label>
                    </div>
                    <div class="rd01 rd02">
                      	<input type="radio" id="type_rd02" name="saletype" value="OFT" data-default="<?php echo $saletypedefault?>" <?php echo ($saletypedefault == 'OFT') ? 'checked' : ''; ?>>
                      	<label for="type_rd02">오피스텔</label>
                    </div>
                    <div class="rd01 rd02">
                      	<input type="radio" id="type_rd03" name="saletype" value="ONE" data-default="<?php echo $saletypedefault?>" <?php echo ($saletypedefault == 'ONE') ? 'checked' : ''; ?>>
                      	<label for="type_rd03">원룸/투룸</label>
                    </div>
              	</div>
			</div>
              	
            <!-- 거래유형 -->
            <div class="inpbox rdinp searchfilterbox" id="searchfilterbox_deal" style="display:none;">
              	<!-- 아파트 (S) -->
              	<div class="radio_box02" id="filtertype_APT" style="display:<?php if($saletypedefault !='' && $saletypedefault !='APT') echo 'none'; ?>;">                                        
                    <div class="rd01 rd02">
						<input type="radio" id="type02_rd00" name="transtype" value="all" <?php if($saletypedefault =='' || $saletypedefault == 'APT') echo 'checked=""'; ?>>
						<label for="type02_rd00">전체</label>
					</div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd01" name="transtype" value="sale">
                        <label for="type02_rd01">매매</label>
                    </div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd03" name="transtype" value="previous">
                        <label for="type02_rd03">전/월세</label>
                    </div>
                </div>
                
                <!-- 오피스텔 (S) -->
                <div class="radio_box02" id="filtertype_OFT" style="display:<?php if($saletypedefault !='' && $saletypedefault !='OFT') echo 'none'; ?>;">
                    <div class="rd01 rd02">
						<input type="radio" id="type02_rd04" name="transtype" value="all" <?php if($saletypedefault == 'OFT') echo 'checked=""'; ?>>
						<label for="type02_rd04">전체</label>
					</div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd05" name="transtype" value="sale">
                        <label for="type02_rd05">매매</label>
                    </div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd06" name="transtype" value="previous_2">
                        <label for="type02_rd06">전세</label>
                    </div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd07" name="transtype" value="previous_3">
                        <label for="type02_rd07">월세</label>
                    </div>
                </div>
                
                <!-- 원룸 (S) -->
                <div class="radio_box02" id="filtertype_ONE" style="display:<?php if($saletypedefault !='' && $saletypedefault !='ONE') echo 'none'; ?>;">
                    <div class="rd01 rd02">
						<input type="radio" id="type02_rd09" name="transtype" value="all" <?php if($saletypedefault == 'ONE') echo 'checked=""'; ?>>
						<label for="type02_rd09">전체</label>
					</div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd10" name="transtype" value="previous_2">
                        <label for="type02_rd10">전세</label>
                    </div>
                    <div class="rd01 rd02">
                        <input type="radio" id="type02_rd11" name="transtype" value="previous_3">
                        <label for="type02_rd11">월세</label>
                    </div>
                </div>
            </div>
                
            <!-- 면적 -->
            <div class="inpbox rdinp searchfilterbox" id="searchfilterbox_area" style="display:none;">
                <!-- 아파트 & 오피스텔 -->
                <div class="check_box02" id="searchfilterbox_area_apt" style="display:none;">
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk01" name="area[]" data-first="all" data-end="all" value="all" <?php if($saletypedefault != 'ONE') echo 'checked=""'; ?>>
                      	<label for="ar_chk01">전체</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk02" name="area[]" data-first="0" data-end="66" value="0-66">
                      	<label for="ar_chk02">66m²이하</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk03" name="area[]" data-first="66" data-end="99" value="66-99">
                      	<label for="ar_chk03">66-99m²</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk04" name="area[]" data-first="99" data-end="132" value="99-132">
                      	<label for="ar_chk04">99-132m²</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk05" name="area[]" data-first="132" data-end="165" value="132-165">
                      	<label for="ar_chk05">132-165m²</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk06" name="area[]" data-first="165" data-end="166" value="165-">
                      	<label for="ar_chk06">165m²이상</label>
                    </div>
              	</div>
              	
              	<!-- 원룸/투룸 -->
              	<div class="check_box02" id="searchfilterbox_area_one" style="display:none;">
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk07" name="area[]" data-first="all" data-end="all" value="all" <?php if($saletypedefault == 'ONE') echo 'checked=""'; ?>>
                      	<label for="ar_chk07">전체</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk08" name="area[]" data-first="0" data-end="33" value="0-33">
                      	<label for="ar_chk08">33m²이하</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk09" name="area[]" data-first="33" data-end="66" value="33-66">
                      	<label for="ar_chk09">33-66m²</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk10" name="area[]" data-first="66" data-end="99" value="66-99">
                      	<label for="ar_chk10">66-99m²</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="ar_chk11" name="area[]" data-first="99" data-end="100" value="99-">
                      	<label for="ar_chk11">99m²이상</label>
                    </div>
              	</div>
            </div>
            
            <!-- 방구조 (원룸만) -->
			<div class="inpbox rdinp searchfilterbox" id="searchfilterbox_roomtype" style="display:none;">
                <div class="check_box02">
                    <div class="chk01">
                      	<input type="checkbox" id="rstr01" name="ROOM_TYPE[]" value="all" checked="">
                      	<label for="rstr01">전체</label>
                    </div>                    
                    <?php foreach($ROOM_TYPE as $idx=>$row) { ?>
					<div class="chk01">
						<input type="checkbox" id="rstr<?php echo sprintf("%2d", $idx+2)?>" name="ROOM_TYPE[]" data-roomname="<?php echo $row['CODE_NAME']?>" value="<?php echo $row['CODE_DETAIL']?>" class="fit">
						<label for="rstr<?php echo sprintf("%2d", $idx+2)?>"><?php echo $row['CODE_NAME']?></label>
					</div>
  					<?php } ?>
              	</div>
            </div>
            
            <!-- 금액 -->
          	<div class="inpbox rdinp searchfilterbox" id="searchfilterbox_price" style="display:none;">             	
              	<div class="check_box02 mgt" id="filterCosts1">
                	<h4 class="ft_tit">전세(보증금)</h4>
                	<div class="chk01">
                  		<input type="checkbox" id="type04_rd07" name="charterprice[]" data-first="all" data-end="all" value="all" checked="">
                  		<label for="type04_rd07">전체</label>
                	</div>
                	<div class="chk01">
                  		<input type="checkbox" id="type04_rd08" name="charterprice[]" data-first="0" data-end="5천이하" value="0-5000">
                  		<label for="type04_rd08">5천이하</label>
                	</div>
                	<div class="chk01">
                  		<input type="checkbox" id="type04_rd09" name="charterprice[]" data-first="5천" data-end="1억" value="5000-10000">
                  		<label for="type04_rd09">5천-1억</label>
                	</div>
                	<div class="chk01">
                  		<input type="checkbox" id="type04_rd10" name="charterprice[]" data-first="1억" data-end="3억" value="10000-30000">
                  		<label for="type04_rd10">1억-3억</label>
                	</div>
                	<div class="chk01">
                  		<input type="checkbox" id="type04_rd11" name="charterprice[]" data-first="3억" data-end="3억이상" value="30000-">
                  		<label for="type04_rd11">3억이상</label>
                	</div>
              	</div>
              	
              	<div class="check_box02 mgt" id="filterCosts2">
                    <h4 class="ft_tit">월세(보증금)</h4>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd13" name="monthly_deposit[]" data-first="all" data-end="all" value="all" checked="">
                      	<label for="type04_rd13">전체</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd14" name="monthly_deposit[]" data-first="0" data-end="1천이하" value="0-1000">
                      	<label for="type04_rd14">1천이하</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd15" name="monthly_deposit[]" data-first="1천" data-end="5천" value="1000-5000">
                      	<label for="type04_rd15">1천-5천</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd16" name="monthly_deposit[]" data-first="5천" data-end="1억" value="5000-10000">
                      	<label for="type04_rd16">5천-1억</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd17" name="monthly_deposit[]" data-first="1억" data-end="1억이상" value="10000-">
                      	<label for="type04_rd17">1억이상</label>
                    </div>
              	</div>
              	
              	<div class="check_box02 mgt" id="filterCosts3">
                    <h4 class="ft_tit">월세</h4>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd20" name="monthly[]" data-first="all" data-end="all" value="all" checked="">
                      	<label for="type04_rd20">전체</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd21" name="monthly[]" data-first="0" data-end="50만이하" value="0-50">
                      	<label for="type04_rd21">50만이하</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd22" name="monthly[]" data-first="50만" data-end="70만" value="50-70">
                      	<label for="type04_rd22">50-70만</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd23" name="monthly[]" data-first="70만" data-end="100만" value="70-100">
                      	<label for="type04_rd23">70-100만</label>
                    </div>
                    <div class="chk01">
                      	<input type="checkbox" id="type04_rd24" name="monthly[]" data-first="100만" data-end="100만이상" value="100-">
                      	<label for="type04_rd24">100만이상</label>
                    </div>
              	</div>
          	</div>
          	
          	<span class="filterSearchForms btn_reset" style="display:none;">
                <button type="button" onclick="filterReset()"><span class="">필터 초기화</span></button>
            </span> 
            <span class="filterSearchForms btn_ftclose" style="display:none;">
                <button type="button" onclick="filterboxclose()"><span class="">필터닫기</span></button>
            </span>
        </div>
          	
      	<!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </form>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap map_wrap">
            	<div class="apiMapView" id="apiMapView" style="width:100%;height:100%;"></div>
                <div class="bg_map">
                    <div class="map_vbtn">
                    	<!-- span class="btn_arnd">
                        	<button type="button"><span class="">주변</span></button>
                        </span -->
                        <!-- 주변선택 팝업 -->
                        <div class="arnd_wrap" style="display:none;">
                            <ul class="arnd_lst">
                                <li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SW8" data-aroundcatesub="">지하철역</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="어린이집" data-aroundcatesub="">어린이집</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="유치원" data-aroundcatesub="">유치원</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="초등학교">초등학교</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="중학교">중학교</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="고등학교">고등학교</a></li>
                  				<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="HP8" data-aroundcatesub="">병원</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="마트" data-aroundcatesub="">마트</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="BK9" data-aroundcatesub="">은행</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="PO3" data-aroundcatesub="">관공서</a></li>
                            </ul>
                        </div>
                        <!-- // 주변선택 팝업 끝 --> 
                    </div>
                    
                    <div class="mapview_tag" style="z-index:100;">3.3m²실거래가</div>
                    
                  	<p class="txt_noti" style="display:none;"><span>지도를 조금 더 확대해 주세요!</span></p>
                </div>
                
                <!-- 단지숫자 클릭했을 떄 view -->
                <div class="itm_lst mbot_area danji_prev" id="dangiDetailView" style="display:none;"></div>
                <!-- // 단지숫자 클릭했을 떄 view 끝 -->                 
            </div>
            
            <?php /* 원룸일 경우 (S) */ ?>
            <!-- 기본 단지 목록 숫자 -->
            <div class="btn_area bot_btn" id="oneroomDanjiListButton" style="display:none;"> 
                <!-- 단지목록 view가 가능한 시점부터 on 클랙스 추가 -->
                <button class="btn_type06" type="button" onclick="oneroomDanjiLists()">매물목록 <span class="count">0</span></button>
            </div>
            
            <!-- 단지숫자 클릭했을 떄만 view -->
            <div class="itm_lst mbot_area" id="oneroomDanjiListView" style="display:none;">
                <div class="itm_count"><a href="javascript:void(0);" onclick="fnoneRoomAllListPrint()" class="dn">지도내 매물목록 <b class="count">0</b></a></div>
                <div class="itm_wrap oneitm_wrap"></div>
            </div>
            <!-- // 단지숫자 클릭했을 떄 view 끝 -->
            <?php /* 원룸일 경우 (E) */ ?>
        </div>
    </section>
</div>

<!-- 매물등록, 삭제요청 클릭시 팝업 -->
<div class="mask" style="display:none"></div>
<div class="lyr lyrpop01" style="display:none">
	<a href="javascript:fnpoploginClose();" class="close">닫기</a>
    <div class="lyr_inner">
        <p class="cont">로그인이 필요한 메뉴입니다.<br>기존 중개수수료의 50% 수준인<br>다윈의 매수(임차)인 중개수수료는<br>회원에게만 적용됩니다.<br></p>
    </div>
    <div class="btn double">
        <button type="button" class="btn_type08" onclick="goPage('/member/join1')">회원가입</button>
        <button type="button" class="btn_type02" onclick="goPage('/member/login/buyhome')">로그인</button>
    </div>
</div>

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>

<script type="text/javascript">
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 4,
    paginationClickable: true,
    spaceBetween: 0,
    freeMode: true,
	pagination: false
});

function fnpoploginOpen()
{
	$(".mask").show();
  	$(".lyr").show();
}
	
function fnpoploginClose() {
  	$(".mask").hide();
  	$(".lyr").hide();
}

//------------------------------------------------------

var type = "1";
var cate = '<?php echo $saletype; ?>'; 
var complexdetail = {type:'<?php echo $saletype; ?>', idx:<?php echo $complex_idx; ?>};
var memSet = '<?php echo $memidx; ?>';

// 지도 default
var lat = '<?php echo $lat; ?>';
var lng = '<?php echo $lng; ?>';
var defaultLevel = 4;
var level = 4;
var tooltipMaxwidth = 100;
var tooltip_nowmonth;
var echart;
var chartdata = [];
var ohlc = [], ohlc2 = []
	volume = [], volume2=[]
    groupingUnits = [
    	['month',[1, 2, 3, 4, 6]],
    	['year',[1]]
    ];
var space_unit = "m"; //m, py
var last_sale_price, last_charter_price = null;
var fnloadInfocall = null;
var reloadmapcall = null;
var positions = null;
var searching = null;
var infowindow = null;
var view_detail_template,view_detail_salelist_template,view_for_sale_list_template,oneroom_list_template = null;
var tradelistset = null;
var searchStateRes = false;
var searchStateResCnt = 0;

var around_obj, around_subobj;

var markers = [];
var map, clusterer, bounds, swLatlng, neLatlng = null;

var mapContainer = document.getElementById('apiMapView'),
    mapOption = {
      	center: new daum.maps.LatLng(lat, lng), //지도의 중심좌표.
    	level: level //지도의 레벨(확대, 축소 정도)
    };

var selMenuValueCost = '';

var isDragging = false;
var startingPos = [0,0];
var getSamrt = "<?php echo $getDevideCookie; ?>";
var getDevice = "<?php echo $DEVICE; ?>";

var monthCostSave1 = null;//월세보증금
var monthCostSave2 = null;//월세

function fnComplexmousedown(evt) {
  	isDragging = false;
  	startingPos = [evt.pageX, evt.pageY];
}
function fnComplexmousemove(evt) {
  	if(!(evt.pageX === startingPos[0] && evt.pageY === startingPos[1])) {
      	isDragging = true;
  	}
}
function fnComplexDetailonmap(idx, cate) {
  	if(isDragging) return;
  	fnComplexDetailSrch(idx, cate);
}

//검색어 삭제버튼 생성
function delicon() {
	var searchword = $('#main_searchtab_keyword').val();
	if(searchword != '') {
		$('.btn_del02').show();
	}
	else {
		$('.btn_del02').hide();
	}
}

// 필터 선택
var filterName = null;
function filterSelect(value)
{
	// 필터박스 노출
	$('.sub_filter_group').show();

	// 필터 초기화&닫기 부분 노출
	$('.filterSearchForms').show();

	// 활성화된 필터 on class 추가
	$('#filerMenuName_'+value).addClass('on');

	// 전체 닫기
	$('.searchfilterbox').hide();

	$('.sub_filter_inner').css("height", "43px");
	$('.sub_filter_group').css("top", "100px");
	if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
		$('.sub_filter_inner').css("height", "80px");
		$('.sub_filter_group').css("top", "137px");
	}

	if(filterName == value) {
		filterboxclose();
		filterName = null;
	}
	else
	{
		$('#searchfilterbox_'+value).show();

		var saletypeVal = $(":input:radio[name=saletype]:checked").val();

    	// 면적 변경
    	if(value == 'area')
    	{
      		if(saletypeVal == 'ONE') {
      			$('#searchfilterbox_area').show();
      			$('#searchfilterbox_area_one').show();
    			$('#searchfilterbox_area_apt').hide();
      		}
      		else {
      			$('#searchfilterbox_area').show();
      			$('#searchfilterbox_area_one').hide();
    			$('#searchfilterbox_area_apt').show();
      		}
    	}

    	// 원룸/투룸인 경우
    	if(saletypeVal == 'ONE')
    	{
        	// 거래유형 (매매, 전월세)
    		var transtype = $(":input:radio[name=transtype]:checked").val();

    		// 전세일때 전세(보증금)만 나오도록
    		if(transtype == 'previous_2') {
    			$('#filterCosts1').show();
    			$('#filterCosts2').hide();
    			$('#filterCosts3').hide();
    		}
    		// 월세에서 금액 필터 월세(보증금), 월세만 나오도록
    		else if(transtype == 'previous_3') {
    			$('#filterCosts1').hide();
    			$('#filterCosts2').show();
    			$('#filterCosts3').show();
    		}
    		else {
    			$('#filterCosts1').show();
    			$('#filterCosts2').show();
    			$('#filterCosts3').show();
    		}
    	}

    	var valtxt = $('#filerMenuName_'+value).text();

    	if(value != 'sale' && (valtxt == '전체' || valtxt == '거래유형' || valtxt == '면적' || valtxt == '방구조' || valtxt == '금액'))	{
        	$('#filerMenuName_'+value).html('전체');
    	}
        
    	filterName = value;
	}
}

// 필터 초기화
function filterReset()
{
	document.filter_form.reset();

	$('.sub_filter_inner').css("height", "43px");
	$('.sub_filter_group').css("top", "100px");
	
	filterboxclose();
	
    $(':radio[name=saletype]:input[value=APT]').prop("checked", true);
    $('#filerMenuName_sale').html('아파트');
    $('#filerMenuName_deal').html('거래유형');
    $('#filerMenuName_deal').removeClass('on');
    $('#filerMenuName_area').html('면적');
    $('#filerMenuName_area').removeClass('on');
    $('#filerMenuName_roomtype').hide();
    $('#filerMenuName_roomtype').html('방구조');
    $('#filerMenuName_roomtype').removeClass('on');
    $('#filerMenuName_price').hide();
    $('#filerMenuName_price').html('금액');
    $('#filerMenuName_price').removeClass('on');

    $(':radio[name=transtype]:input[value=all]').prop("checked", true);
    $('input:checkbox[name="area[]"]:input[value=all]').attr("checked", true);
    $('input:checkbox[name="ROOM_TYPE[]"]:input[value=all]').attr("checked", true);
    $('input:checkbox[name="charterprice[]"]:input[value=all]').attr("checked", true);
    $('input:checkbox[name="monthly_deposit[]"]:input[value=all]').attr("checked", true);
    $('input:checkbox[name="monthly[]"]:input[value=all]').attr("checked", true);

    fnloadInfoCall();
}

// 필터박스 닫기
function filterboxclose()
{
	$('.sub_filter_group').hide();
	$('.searchfilterbox').hide();
	$('.filterSearchForms').hide();	
}

// 검색 처리
function fnkeywordSearch()
{
    var saletype = $(":input:radio[name=saletype]:checked").val();
    var keywords = $("#main_searchtab_keyword").val();
    var time = new Date().getTime();
    if( keywords == '' ) {
    	$("#search_result").hide();
    	return;
    }
    
    $("#search_result").data('time', time );
    $.ajax({
    	url: '/search',
    	type: 'GET',
    	data: {saletype:saletype, keywords:keywords} ,
    	dataType: 'json',
    	success: function (result) {
      		load_template("#search_result", result.data, time);
      		searchStateRes = true;
    	},
    	error : function(request, status, error) {
      		$("#search_result ul").empty().append('<li><p class="sch_word issearchclass">검색결과값이 없습니다.</p></li>');
     	}
    });
}

// 검색결과 표시
function load_template(target, data, time)
{
    var ul = $(target + " ul");
    if( $("#search_result").data('time') != String(time) ) { return false; }
    $(ul).empty();
    if ( data == null || data==''||data.length < 1) {
    	$(ul).append('<li><p class="sch_word issearchclass">검색결과값이 없습니다.</p></li>');
    }
    else {
    	$.each( data, function (idx, row) {
      		$(ul).append('<li><a href="javascript:searchResultUPClose(\''+row.title+'\');" onClick="mapcenter('+row.lat+', '+row.lng+', \''+row.COMPLEX_IDX+'\', \''+row.icontype+'\');" class="sch_word issearchclass"><i class="sch_ico ' + icontype(row.icontype) + '"></i> '+row.title+' <span class="address">'+row.addr+'</span></a></li>');
    	});
    }
    $(target).show();
}

// 검색시 이동
function mapcenter(lat, lng, COMPLEX_IDX, cate)
{
    map.setLevel(defaultLevel);
    map.panTo(new daum.maps.LatLng(lat, lng)); //맵이동 -> 맵이동하면서   idle Event 발생으로 서치변경

   	complexdetail.type = cate;
   	complexdetail.idx = COMPLEX_IDX;

	if(COMPLEX_IDX != '')
	{
		searchStateRes = true;
		searchStateResCnt = 1;
		setTimeout( function() {
			fnComplexDetailSrch(COMPLEX_IDX, cate);
		}, 500);
	}
}

// 검색 이동시 검색결과 닫기
function searchResultClose() {
	$('#search_result').hide();
}

//검색 이동시 검색결과 닫기
function searchResultUPClose(word) {
	$('#main_searchtab_keyword').val(word);
	$('#search_result').hide();
}

// 검색어 삭제
function searchKeywordDel() {
	$('#main_searchtab_keyword').val('');
	$('#search_result').hide();
	$('#searchbtndel').hide();
}

// 주변 검색 마킹
function aroundView(alink)
{
  	if( $(alink).hasClass('on') ) {
      	fnaroundViewClear();
      	return;
  	}
  	
  	$('.arnd_lst a.on').removeClass('on');
  	$(alink).addClass('on');

  	// 출력할 정보
  	around_obj = $(alink).data('aroundcate');
  	around_subobj = $(alink).data('aroundcatesub');

	// 주변 검색 건물 위치에 아이콘 표기
  	fnaroundView(around_obj, around_subobj);
}

// 주변 검색 제거
function fnaroundViewClear()
{
    $('.arnd_lst a.on').removeClass('on');
    setMarkers(null);
    around_obj = null;
    around_subobj = '';
}

// 마커 표기
function setMarkers(map)
{
    if( infowindow != null ) infowindow.close()
    for(var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// 시간간격 맵출력
function fnloadInfoCall() {
  	if(fnloadInfocall) { clearTimeout(fnloadInfocall); }
  	fnloadInfocall = setTimeout(function () {
    	fnloadInfo();
  	}, 200);
}

// 주변 검색 보기
function fnloadInfo()
{
    bounds = map.getBounds();
    swLatlng = bounds.getSouthWest();
    neLatlng = bounds.getNorthEast();
    
    var mapCT = map.getCenter();
    
    lat = mapCT.getLat();
    lng = mapCT.getLng();
    level = map.getLevel();

    // 기본 건물 정보 출력 (APT 기본 출력)
    loaddata();
    
    if(level > 6) {
    	$('.arnd_lst a.on').removeClass('on');
    	setMarkers(null);
    	$(".btn_arnd").removeClass('on');
    	$("div.arnd_lst").hide();
    }
    else {
    	$(".btn_arnd").show();
    }
}

// 주변 검색 건물 위치에 아이콘 표기
function fnaroundView(obj, subobj)
{
    if(obj == null) return;
    if(level > 6) { setMarkers(null); return; }
    if(infowindow != null) infowindow.close();
    else infowindow = new daum.maps.InfoWindow({zIndex: 100});
    var ps = new daum.maps.services.Places(map);

    if($.inArray(obj, ["MT1","CS2","PS3","SC4","AC5","PK6","OL7","SW8","BK9","CT1","AG2","PO3","AT4","AD5","FD6","CE7","HP8","PM9"]) > -1) {
        ps.categorySearch(obj, placesSearchCB, { useMapBounds: true });
    }
    else {
      	ps.keywordSearch( obj, placesSearchCB,{useMapBounds:true});
    }
    
    setMarkers(null);

    // 키워드 검색 완료 시 호출되는 콜백함수 입니다
    function placesSearchCB(data, status, pagination)
    {
        if(status === daum.maps.services.Status.OK)
        {
            //marker.clear();
            for(var i = 0; i < data.length; i++) {
                if(subobj != '' ) {
                  	if( data[i].place_name.indexOf(subobj) > -1 ) displayMarker(data[i]);
                }
                else displayMarker(data[i]);
            }
        }
    }
    
    // 마커 이미지의 이미지 주소입니다
	var imageSrc = "http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png";
  	var ico = (subobj != '') ? subobj : obj;
	switch(ico)
	{
		case 'SC4': 	imageSrc = '/images/ico_school02.png';	break;
		case 'PS3': 	imageSrc = '/images/ico_hos.png'; 		break;
		case 'SW8': 	imageSrc = '/images/ico_bus.png'; 		break;
        case 'BK9': 	imageSrc = '/images/ico_bank.png';		break;
        case 'PO3': 	imageSrc = '/images/ico_public.png';	break;
        case '어린이집': 	imageSrc = '/images/ico_school01.png';	break;
        case '유치원': 	imageSrc = '/images/ico_school02.png';	break;
        case '초등학교': 	imageSrc = '/images/ico_school03.png';	break;
        case '중학교': 	imageSrc = '/images/ico_school04.png';	break;
        case '고등학교': 	imageSrc = '/images/ico_school05.png';	break;
        case '마트': 		imageSrc = '/images/ico_mart.png';		break;
        case 'HP8': 	imageSrc = '/images/ico_hos.png';		break;
	}

	// 마커 이미지의 이미지 크기 입니다
  	var imageSize = new daum.maps.Size(30, 30);
  	var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize);

	// 마커 출력
  	function displayMarker(place)
  	{
    	var marker1 = new daum.maps.Marker({
      		map: map,
      		zIndex:8,
      		position: new daum.maps.LatLng(place.y, place.x),
      		image: markerImage // 마커 이미지
    	});
    	
    	markers.push(marker1);

		// 클릭한 위치 업체 혹은 건물명 마커 출력
    	daum.maps.event.addListener(marker1, 'click', function(){
      		var infohtml = '<div style="padding:5px;font-size:12px;">' + place.place_name + '</div>';
      		if(infowindow.getContent() == infohtml) {
          		infowindow.setContent('');
        		infowindow.close();
      		}
      		else {
        		infowindow.setContent(infohtml);
        		infowindow.open(map, marker1);
      		}
    	});
  	}
}

// 기본 출력 데이터 로드
function loaddata()
{
    var param  = $('#filter_form').serialize();
    var oldcate = cate;
    var url = '/buyhome/getdata';

    param = param + '&spaceunit=' + space_unit + '&level=' + level + '&swlat=' + swLatlng.jb + '&swlng=' + swLatlng.ib + '&nelat=' + neLatlng.jb + '&nelng=' + neLatlng.ib;
    cate =  $(":input:radio[name=saletype]:checked").val();

    if(cate != oldcate) {
        $("#main_searchtab_keyword").val('');
        $("#search_result ul").empty();
	}
    
    $('div.i_apt').each(function(){
    	if($(this).hasClass('on')) {$(this).removeClass("on");}
    });
    
    $.ajax({
    	url: url,
    	type: 'GET',
    	data: param ,
    	dataType: 'json',
    	success: function(result){
          	positions = result.POSITION;
          	if(cate == 'ONE')
            {
            	if(level <= 4)
               	{
              		oneroomcluster(positions);

              		if(level < 4) {
						if(positions.length > 0) oneroomListPrint(result);
              			fnoneRoomList('view');
              		}
              		else {
              			fnoneRoomList('hidden');
              		}
              		
              		$("#apiMapView > div > div > div > div").each(function(){
                		$(this).addClass('cluster2')
              		});
            	}
            	else {
              		makeCluster(positions);
              		fnoneRoomList('hidden');
            	}
          	}
          	else
            {
            	makeCluster(positions);
          	}
          	
			// 주변 검색 건물 위치에 아이콘 표기
          	fnaroundView(around_obj, around_subobj);
        },
        error: function(request, status, error){
          	console.log(error);
        }
    });
}

// 원룸 체크
function oneroomcluster(position)
{
    clusterer.clear();	// 기존 클러스터 삭제
    
    map.setMinLevel(3);
    clusterer.setMinLevel(3);

 	// 지도 확대 알림 경고창 출력 여부
	$(".txt_noti").hide();
	$(".btn_type06").addClass('on');
	$(".count").html(position.length);
	if(level > 4) {
		$(".txt_noti").show();
		$(".txt_noti").css("bottom","70px");
		$(".btn_type06").removeClass('on');
		$(".count").html('0');
	}

    var markers = $(position).map(function(i, d){
    	return new daum.maps.Marker({
        	position : new daum.maps.LatLng(d.lat, d.lng)
    	});
    });
    
    clusterer.addMarkers(markers);
}

// 원룸 단지 목록 보기
function oneroomDanjiLists()
{
	if(level > 4) {
		swal('지도를 조금 더 확대해 주세요!');
	}
	else {
	    map.setLevel(level - 1);
	}
}

// 원룸목록출력
function oneroomListPrint(result)
{
  	if(oneroom_list_template == null)
  	{
    	$.ajax({
      		url: "/tpl/buyhome_oneroom_list.tpl?_="+ new Date().getTime(),
      		method: 'GET',
      		dataType: 'html', //** Must add
      		async: false,
      		success: function(data){
          		oneroom_list_template = _.template(data);
          		fnoneRoomListTpl(result);
      		}
    	});
  	}
  	else {
    	fnoneRoomListTpl(result);
  	}
}
// tpl 출력
function fnoneRoomListTpl(result) {
  	$(".itm_wrap").html(oneroom_list_template(result));
}

// 원룸 목록 하나 출력
function fnoneRoomList(result)
{	
	if(result == 'view')
	{
		$("#oneroomDanjiListButton").hide();
		if($(".itm_inner").length > 0) {
			$("#oneroomDanjiListView").show();
			$(".itm_wrap > div:gt(0)").hide();
		}
	}
	else
	{
		$("#oneroomDanjiListButton").show();
		$("#oneroomDanjiListView").hide();
	}
}

// 원룸 전체목록 보기 및 숨기기
var roomListView = false;
function fnoneRoomAllListPrint()
{
	$('.itm_count a').removeClass('dn');
	
	if(roomListView == false)
	{
		$(".itm_wrap > div:gt(0)").show();
		roomListView = true;

		if($(".itm_wrap")[0].scrollHeight > 359)
		{
			$(".itm_wrap").css("height", "360");
    		$(".itm_wrap").scroll();
    		$(".itm_wrap").css("overflow", "auto");
    		$(".itm_wrap").css("overflow-x", "hidden");
		}
		else if($(".itm_wrap")[0].scrollHeight < 241 && $(".itm_wrap")[0].scrollHeight > 120)
		{
			$(".itm_wrap").css("height", "240");
    		$(".itm_wrap").scroll();
    		$(".itm_wrap").css("overflow", "auto");
    		$(".itm_wrap").css("overflow-x", "hidden");
		}
		else if($(".itm_wrap")[0].scrollHeight < 121)
		{
    		$(".itm_wrap").css("height", "120");
    		$(".itm_wrap").scroll();
    		$(".itm_wrap").css("overflow", "auto");
    		$(".itm_wrap").css("overflow-x", "hidden");
		}
		else {
			$(".itm_wrap").css("height", "120");
		}
	}
	else
	{
		$('.itm_count a').addClass('dn');
				
		$(".itm_wrap > div:gt(0)").hide();
		roomListView = false;

		$(".itm_wrap").css("height", "120");
	}
}
function fnoneRoomAllListPrintClose() {
	$(".itm_wrap > div:gt(0)").hide();
	roomListView = false;

	$('.itm_count a').addClass('dn');

	$(".itm_wrap").css("height", "120");
}

// 클러스터 생성
function makeCluster(position)
{
  	if(typeof cate =="undefined" || cate == null ) cate ="APT";
	var markers = null;
	clusterer.clear();// 기존 클러스터 삭제

	// 지도 확대 알림 경고창 출력 여부
	$(".txt_noti").hide();
	if(cate == 'ONE')
	{
		$(".btn_type06").addClass('on');
		$(".count").html(position.length);
	}

	if( level > 4 )
	{
		$(".txt_noti").show();
		if(cate == 'ONE')
		{
			$(".txt_noti").css("bottom","70px");
			$(".btn_type06").removeClass('on');
			$(".count").html('0');
		}
	}

  	map.setMinLevel(1);
  	clusterer.setMinLevel(13);

  	markers = $(position).map(function(i, d){
    	customOverlay = new daum.maps.CustomOverlay({
      		clickable: false,
      		position: new daum.maps.LatLng(d.lat, d.lng),
      		zIndex: 1,
      		content: getCustomLayout(d)  // 마커생성
    	});
    	return customOverlay;
  	});

	clusterer.addMarkers(markers);
	
  	$('.i_apt').mouseover(function(){
  		$(this).parent().css('z-index', 20);
  	}).mouseout(function() {
      	$(this).parent().css('z-index', 10);
    });
}

function ison(idx, cate)
{
  	if(cate == complexdetail.type && idx == complexdetail.idx) {
    	return 'on';
  	}
  	else {
    	return '';
  	}
}

// 건물 마커 생성
function getCustomLayout(d)
{
    var p1_price = 0;
    var C1 = '';
    var transtype = $(":input:radio[name=transtype]:checked").val();
    var goods_cnt = 0;
    
    if(level < 5)
    {
    	if(d.map_type != "ONE")
       	{
      		if(transtype == 'sale') goods_cnt = d.sale_cnt;
      		else if(transtype == 'previous') goods_cnt = Number(d.monthly_cnt) + Number(d.charter_cnt);
      		else if(transtype == 'previous_2') goods_cnt = Number(d.charter_cnt);
      		else if(transtype == 'previous_3') goods_cnt = Number(d.monthly_cnt);
      		else goods_cnt = Number(d.sale_cnt) + Number(d.monthly_cnt) + Number(d.charter_cnt);
   
      		if(d.REAL_ESTATE_TYPE=='ABYG' || d.REAL_ESTATE_TYPE=='OBYG') {
    			C1='<div class="i_apt iapt6 '+ ison(d.map_code , cate) +'" data-cate="'+d.REAL_ESTATE_TYPE+'" data-mapcode="' + d.map_code + '" data-cnt="0" onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+d.REAL_ESTATE_TYPE+'\')">	<div class="info01">입주예정</div>	'
            }
      		// OFFICETEL
      		else if(d.map_type == 'OFT')
          	{
        		var pname = "3.3㎡";
        		if(transtype == 'previous_3' ||transtype == 'previous_2') pname = d.PYEONG_NAME+"평";
    
				// 전월세
        		if(transtype == 'previous') {
          			p1_price = fnMoneyAboutText(Number(d.PYEONG_CHARTERED_PRICE) * 10000 );
          			C1 += '<div class="i_apt  iapt1 ' + ison(d.map_code, cate) + '" data-cate="' + cate + '" data-mapcode="' + d.map_code + '"  data-cnt="' + goods_cnt + '"  onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+cate+'\')">';
          			C1 += '	<div class="info01"><small>'+pname+'</small>' + p1_price + '</div>';
        		}
        		// 전세
        		else if(transtype == 'previous_2') {
          			p1_price = fnMoneyAboutText(Number(d.PYEONG_CHARTERED_PRICE) * 10000 );
          			C1 += '<div class="i_apt  iapt1 ' + ison(d.map_code, cate) + '" data-cate="' + cate + '" data-mapcode="' + d.map_code + '"  data-cnt="' + goods_cnt + '"  onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+cate+'\')">';
          			C1 += '<div class="info01">' + p1_price + '</div>';//<small>'+pname+'</small>
        		}
        		// 월세
        		else if(transtype == 'previous_3') {
          			p1_price = fnMoneyAboutText(Number(d.PYEONG_MONTHLY_PRICE) * 10000);
          			C1 += '<div class="i_apt  iapt1 ' + ison(d.map_code, cate) + '" data-cate="' + cate + '" data-mapcode="' + d.map_code + '"  data-cnt="' + goods_cnt + '"  onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+cate+'\')">';
          			C1 += '<div class="info01">' + fnMoneyAboutText(Number(d.PYEONG_DEPOSIT_PRICE) * 10000 ) + '/' + d.PYEONG_MONTHLY_PRICE +'</div>';//<small>'+pname+'</small>
        		}
        		// 매매
        		else {
          			p1_price = fnMoneyAboutText(Number(d.PYEONG_SELL_PRICE) * 10000);
          			C1 += '<div class="i_apt  iapt1 ' + ison(d.map_code, cate) + '" data-cate="' + cate + '" data-mapcode="' + d.map_code + '"  data-cnt="' + goods_cnt + '"  onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+cate+'\')">';
          			C1 += '<div class="info01">' + p1_price + '</div>';
        		}
      		}
     		// APT
      		else
          	{
        		if(transtype == 'previous') p1_price = fnMoneyAboutText(Number(d.PYEONG_CHARTERED_PRICE) * 10000);
        		else p1_price = fnMoneyAboutText(Number(d.PYEONG_SELL_PRICE) * 10000);

        		C1 += '<div class="i_apt iapt3 ' + ison(d.map_code, cate) + '" data-cate="' + cate + '" data-mapcode="' + d.map_code + '" data-cnt="' + goods_cnt + '" onmousedown="fnComplexmousedown(event)" onmousemove="fnComplexmousemove(event)" onmouseup="fnComplexDetailonmap(\''+d.map_code+'\', \''+cate+'\')">';
        		C1 += '<div class="info01">' + p1_price + '</div>';
      		}
    
      		C1 += '<div class="info02">' + d.map_title + '</div>';
      		C1 += '<div class="info03">' + goods_cnt + '</div>';
      		C1 += '</div>';
    	}
    	else
        {
      		if(d.goods_cnt > 99) {
        		C1 += '<div class="cluster clst04 clst_bg05">';
      		}
      		else if(d.goods_cnt > 49) {
        		C1 += '<div class="cluster clst03 clst_bg05">';
      		}
      		else if(d.goods_cnt > 9) {
        		C1 += '<div class="cluster clst02 clst_bg05">';
      		}
      		else {
          		C1 += '<div class="cluster clst01 clst_bg05">';
      		}
      		C1 += '<div class="cluster_inner"><span class="count">' + d.goods_cnt + '</span></div>';
      		C1 += '</div>';
    	}
    }
    else
    {    	
    	if(cate == 'APT') {
        	var classCluster = "clst03";
    	}
    	else if(cate == 'OFT') {
    		var classCluster = "clst01";
    	}
    	else if(cate == 'ONE') {
    		var classCluster = "clst02";
    	}
    	
      	C1 += '<div class="cluster ' + classCluster + '"><div class="cluster_inner"><span class="info02">' + d.map_title + '</span></div></div>';
    }
    
    return C1;
}

// 선택 건물 상세 정보 하단 출력
function fnComplexDetailSrch(idx, cate)
{
	var realcate = cate;
	var transtypeVal = $(":input:radio[name=transtype]:checked").val();
	
    $('.i_apt.on').removeClass("on");
    $("div.i_apt[data-mapcode='" + idx + "']").addClass("on");

    if(realcate == 'ABYG') cate = 'APT';
    else if(realcate == 'OBYG') cate = 'OFT';   

    $.ajax({
    	url: '/buyhome/getDetailInfoView',
    	type: 'GET',
    	data: {complex_idx:idx, complex_type:cate, transtype:transtypeVal} ,
    	dataType: 'json',
    	success: function(result){
      		if(result.data.length < 1 ) return false;
        	
        	$("#dangiDetailView").css('display', 'block');
        	if(result.data.REAL_ESTATE_TYPE == 'ABYG' || result.data.REAL_ESTATE_TYPE == 'OBYG')
        	{
        		var views1 = '';
            	views1 += '<div class="itm_inner">';
            	views1 += '<div class="pre_tag">입주예정</div>';
            	views1 += '<div class="itm_pic">';

            	var imgsrc = (result.data.images=='' || result.data.images==null) ? '/images/img_noimg02.png' : result.data.images;
            	views1 += '<div class="itm_thumb"><img src="' + imgsrc + '" alt="매물사진" /></div>';
            	
            	views1 += '</div>';

            	if(getSamrt == '1' && getDevice == 'AND') {
            		views1 += '<a class="itm_info" href="javascript:void(0);" onclick="dawin_newpop(\'/buyhome/danjidetail/' + idx + '/' + cate + '/' + transtypeVal + '/' + result.data.REAL_ESTATE_TYPE + '\')">';
            	}
            	else {
            		views1 += '<a class="itm_info" href="javascript:void(0);" onclick="goPagePop(\'/buyhome/danjidetail/' + idx + '/' + cate + '/' + transtypeVal + '/' + result.data.REAL_ESTATE_TYPE + '\')">';
            	}
            	
            	views1 += '<div class="itm_exp">';
            	views1 += '<p class="info01 bolder">' + result.data.COMPLEX_NAME + '</p>';
            	
            	if(result.data.min_supply_area_m2 == result.data.max_supply_area_m2 && result.data.MIN_SUPPLY_AREA_PYEONG == result.data.MAX_SUPPLY_AREA_PYEONG) {
            		views1 += '<p class="area"><b>' + result.data.min_supply_area_m2 + 'm²(' + result.data.MIN_SUPPLY_AREA_PYEONG + '평)</b></p>';
    			}
    			else {
    				views1 += '<p class="area"><b>' + result.data.min_supply_area_m2 + 'm²(' + result.data.MIN_SUPPLY_AREA_PYEONG + '평) ~ ' + result.data.max_supply_area_m2 + 'm²(' + result.data.MAX_SUPPLY_AREA_PYEONG + '평)</b></p>';
    			}
            	
            	// 각 타입에 따른 매물건수
            	if(result.data.transtype == 'sale') {
            		views1 += '<p class="info02"><span class="s_type01">매매 <b>' + result.data.sale_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous') {
            		views1 += '<p class="info02"><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous' || result.data.transtype == 'previous_2') {
            		views1 += '<p class="info02"><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous_3') {
            		views1 += '<p class="info02"><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
            	}
        		else {
        			views1 += '<p class="info02"><span class="s_type01">매매 <b>' + result.data.sale_cnt + '</b></span><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
        		}
            	
            	views1 += '<p class="ex_info"><span>' + result.data.TOTAL_DONG_COUNT + '개동</span>, <span>' + result.data.HIGH_FLOOR + '층</span>, <span>' + result.data.TOTAL_HOUSE_HOLD_COUNT + '세대</span></p>';//<span>' + result.data.CONSTRUCT_YEAR + '년준공</span>
            	views1 += '<p class="ex_info02">' + result.data.CONSTRUCT_YEAR + '년 ' + result.data.CONSTRUCT_MONTH + '월 입주예정</p>';
            	views1 += '</div>';
            	views1 += '</a>';
            	views1 += '</div>';
            	$("#dangiDetailView").html(views1);
            	$("#dangiDetailView").addClass('prelst');
        	}
        	else
        	{
        		var views2 = '';
            	views2 += '<div class="itm_inner">';
            	views2 += '<div class="itm_pic">';
    
            	var imgsrc = (result.data.images=='' || result.data.images==null) ? '/images/img_noimg02.png' : result.data.images;
            	views2 += '<div class="itm_thumb"><img src="' + imgsrc + '" alt="매물사진" /></div>';
            	
            	views2 += '</div>';
            	
            	if(getSamrt == '1' && getDevice == 'AND') {
            		views2 += '<a class="itm_info" href="javascript:void(0);" onclick="dawin_newpop(\'/buyhome/danjidetail/' + idx + '/' + cate + '/' + transtypeVal + '/' + result.data.REAL_ESTATE_TYPE + '\')">';
            	}
            	else {
            		views2 += '<a class="itm_info" href="javascript:void(0);" onclick="goPagePop(\'/buyhome/danjidetail/' + idx + '/' + cate + '/' + transtypeVal + '/' + result.data.REAL_ESTATE_TYPE + '\')">';
            	}
            	
            	views2 += '<div class="itm_exp">';
            	views2 += '<p class="info01 bolder">' + result.data.COMPLEX_NAME + '</p>';
            	
    			if(result.data.min_supply_area_m2 == result.data.max_supply_area_m2 && result.data.MIN_SUPPLY_AREA_PYEONG == result.data.MAX_SUPPLY_AREA_PYEONG) {
            		views2 += '<p class="area"><b>' + result.data.min_supply_area_m2 + 'm²(' + result.data.MIN_SUPPLY_AREA_PYEONG + '평)</b></p>';
    			}
    			else {
    				views2 += '<p class="area"><b>' + result.data.min_supply_area_m2 + 'm²(' + result.data.MIN_SUPPLY_AREA_PYEONG + '평) ~ ' + result.data.max_supply_area_m2 + 'm²(' + result.data.MAX_SUPPLY_AREA_PYEONG + '평)</b></p>';
    			}
            	
            	views2 += '<p class="mark">1년내 실거래가 기준</p>';
            	
    			// 각 타입에 따른 매물건수
            	if(result.data.transtype == 'sale') {
            		views2 += '<p class="info02"><span class="s_type01">매매 <b>' + result.data.sale_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous') {
            		views2 += '<p class="info02"><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous' || result.data.transtype == 'previous_2') {
            		views2 += '<p class="info02"><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span></p>';
            	}
        		else if(result.data.transtype == 'previous_3') {
            		views2 += '<p class="info02"><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
            	}
        		else {
        			views2 += '<p class="info02"><span class="s_type01">매매 <b>' + result.data.sale_cnt + '</b></span><span class="s_type02">전세 <b>' + result.data.charter_cnt + '</b></span><span class="s_type03">월세 <b>' + result.data.monthly_cnt + '</b></span></p>';
        		}
            	
    			//--- 각 타입에 따른 매물 가격대 ---//
    			// 매매
    			if(result.data.transtype == 'sale') {
            		views2 += '<p class="price"> <span class="s_type01"><b>매매</b> ' + fnrangeStr(result.data.CURR_SELL_MIN_PRICE * 10000, result.data.CURR_SELL_MAX_PRICE * 10000) + '</span></p>';
    			}
    			// 전세
    			else if(result.data.transtype == 'previous' || result.data.transtype == 'previous_2') { 
    				views2 += '<p class="price"> <span class="s_type02"><b>전세</b> ' + fnrangeStr(result.data.CURR_CHARTERED_MIN_PRICE * 10000, result.data.CURR_CHARTERED_MAX_PRICE * 10000) + '</span></p>';
    			}
    			else if (result.data.transtype == 'previous_3') {
    				views2 += '<p class="price"> <span class="s_type01"><b>월세</b> '
    						  + result.data.CURR_MONTHLY_DEPOSIT_MIN_PRICE + "/" + result.data.CURR_MONTHLY_MIN_PRICE
            			      + " ~ "
            			      + result.data.CURR_MONTHLY_DEPOSIT_MIN_PRICE + "/" + result.data.CURR_MONTHLY_MAX_PRICE
            			      + '</span></p>';
    			}
    			else {
    				views2 += '<p class="price"> <span class="s_type01"><b>매매</b> ' + fnrangeStr(result.data.CURR_SELL_MIN_PRICE * 10000, result.data.CURR_SELL_MAX_PRICE * 10000) + '</span><span class="s_type02"><b>전세</b> ' + fnrangeStr(result.data.CURR_CHARTERED_MIN_PRICE * 10000, result.data.CURR_CHARTERED_MAX_PRICE * 10000) + '</span></p>';
    			}
    			
            	views2 += '<p class="ex_info"><span>' + result.data.TOTAL_DONG_COUNT + '개동</span>, <span>' + result.data.HIGH_FLOOR + '층</span>, <span>' + result.data.TOTAL_HOUSE_HOLD_COUNT + '세대</span>, <span>' + result.data.CONSTRUCT_YEAR + '년준공</span></p>';
            	views2 += '</div>';
            	views2 += '</a>';
            	views2 += '</div>';
            	$("#dangiDetailView").html(views2);
            	$("#dangiDetailView").removeClass('prelst');
        	}
    	},
    	error: function(request, status, error){
      		console.log(error);
    	}
    });
}

// 서브메뉴
var submenuStateView = 'none';
function rightMenu()
{
	if(submenuStateView == 'none') {
		$('#submenuList').show(300);
		$('.hamburgerMenuMask').show();
		submenuStateView = 'block';
	}
	else {
		$('#submenuList').hide(100);
		$('.hamburgerMenuMask').hide();
		submenuStateView = 'none';
	}
    $('.box_submenu').animate({width:'toggle'});
}

//다음 Map API Load
$("document").ready(function(){
  	$('body').click(function(e){
		// 검색 부분 처리
      	var cont = $(e.target).context;
        if( $(e.target).hasClass("issearchclass") && $("#main_searchtab_keyword").val() !='' ) {
          	$("#search_result").show();
        }
        else $("#search_result").hide();
  	});

  	map = new daum.maps.Map(mapContainer, mapOption); //지도 생성 및 객체 리턴
  	map.setMaxLevel(12);
  	clusterer = new daum.maps.MarkerClusterer({
    	map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체
    	gridSize: 100, minClusterSize:1,
    	minLevel: 12, // 클러스터 할 최소 지도 레벨
    	averageCenter: true,
    	calculator: [10, 50, 100], // 클러스터의 크기 구분 값, 각 사이값마다 설정된 text나 style이 적용된다
    	styles: [
        	{
            	// calculator 각 사이 값 마다 적용될 스타일을 지정한다
                width : '50px', height : '50px',
                background: '#dc4f34',
                opacity: '.85',
                borderRadius: '25px',
                color: '#000',
                fontSize:'17px',
                textAlign: 'center',
                fontWeight: 'bold',
                lineHeight: '51px',
                color:'white',
                transform: 'scale(1)',
                transition: 'all 0.3s ease-in-out'
            },
            {
              	// calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '60px', height : '60px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '30px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '61px',
              	color:'white'
            },
            {
                // calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '70px', height : '70px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '35px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '71px',
              	color:'white'
            },
            { 
                // calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '80px', height : '80px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '40px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '81px',
              	color:'white'
            }
		]
  	});

  	map.relayout();
  	fnloadInfo();	// 주변 주요 건물 정보 맵에 실시간 로딩
  	
  	daum.maps.event.addListener(map, 'idle', function(){
    	fnloadInfo();	// 주변 주요 건물 정보 맵에 실시간 로딩

		if(searchStateRes == false)
		{
        	complexdetail.type = null;
            complexdetail.idx = null;
    
        	// 맵정보 로딩시 건물 정보 제거
        	$("#dangiDetailView").css('display', 'none');
        	$("#dangiDetailView").html('');
    
        	// 원룸정보 제거
        	$(".itm_wrap").html('');
        	$("#oneroomDanjiListButton").hide();
    		$("#oneroomDanjiListView").hide();
		}
		searchStateResCnt = 0;
		searchStateRes = false;
  	});

  	// 검색
    $("#main_searchtab_keyword").on("keyup", function(){
        if($("#main_searchtab_keyword").val() == '') {
          	$("#search_result").hide();
          	return;
        }

    	if(searching) { clearTimeout(searching); }

    	searching = setTimeout(function(){
          	if($("#main_searchtab_keyword").val() == '') {
            	$("#search_result").hide();
            	return;
          	}
          	
          	fnkeywordSearch();
        }, 200);
    	searchStateRes = true;
    });

	// 주변 검색 기능 
  	$(".btn_arnd").on("click", function(){
  	    if( $(this).hasClass('on') )
  	  	{
  	      	$(this).removeClass('on');
  	      	$("div.arnd_wrap").hide();
  	      	fnaroundViewClear();
  	    }
  	    else {
  	      	$(this).addClass('on');
  	      	$("div.arnd_wrap").show();
  	    }
	});
	
	// 필터선택 (매물종류)
  	$('input[type=radio][name=saletype]').click(function(){
		$('.filterSearchForms').show();
  		$('#filerMenuName_roomtype').hide();
  		
  		$("#dangiDetailView").hide();

  		$(".itm_wrap").html('');
  		$("#oneroomDanjiListButton").hide();// 원룸버튼숨김
		$("#oneroomDanjiListView").hide();	// 원룸단지목록숨김
		
		$('#searchfilterbox_roomtype').hide();	//방구조숨김
		$('#searchfilterbox_roomtype').hide();	//방구조숨김
		$('#searchfilterbox_price').hide();	//금액숨김
  		
  		// 아파트
		if(this.value == 'APT')
		{
			$('#filerMenuName_sale').html('아파트');

			// 아파트 금액제거
			$('#filerMenuName_price').hide();
			$('#searchfilterbox_roomtype').hide();
			$('#searchfilterbox_price').hide();
			
			$('#filtertype_APT').show();
			$('#filtertype_OFT').hide();
			$('#filtertype_ONE').hide();

			$("input[name='area[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("#type02_rd00").prop("checked", true);
			$("#ar_chk01").prop("checked", true);

			//$('#filerMenuName_deal').html('거래유형');
			//$('#filerMenuName_area').html('면적');

			$('#filerMenuName_deal').html('거래유형');
			$('#filerMenuName_deal').removeClass('on');
			$('#filerMenuName_area').html('면적');
			$('#filerMenuName_area').removeClass('on');
			$('#filerMenuName_roomtype').html('방구조');
			$('#filerMenuName_roomtype').removeClass('on');
			$('#filerMenuName_price').html('금액');
			$('#filerMenuName_price').removeClass('on');
		}
		// 오피스텔
		else if(this.value == 'OFT') {
			$('#filerMenuName_sale').html('오피스텔');

			// 오피스텔 금액제거
			$('#filerMenuName_price').hide();
			$('#searchfilterbox_roomtype').hide();
			$('#searchfilterbox_price').hide();
			
			$('#filtertype_APT').hide();
			$('#filtertype_OFT').show();
			$('#filtertype_ONE').hide();

			$("input[name='area[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });
	        
			$("#type02_rd04").prop("checked", true);
			$("#ar_chk01").prop("checked", true);

			//$('#filerMenuName_deal').html('거래유형');
			//$('#filerMenuName_area').html('면적');

			$('#filerMenuName_deal').html('거래유형');
			$('#filerMenuName_deal').removeClass('on');
			$('#filerMenuName_area').html('면적');
			$('#filerMenuName_area').removeClass('on');
			$('#filerMenuName_roomtype').html('방구조');
			$('#filerMenuName_roomtype').removeClass('on');
			$('#filerMenuName_price').html('금액');
			$('#filerMenuName_price').removeClass('on');
		}
		// 원룸
		else if(this.value == 'ONE')
		{
			$('#filerMenuName_sale').html('원룸/투룸');

			$('#filerMenuName_roomtype').show();
			//$('#filerMenuName_price').show();
			$('#filerMenuName_price').hide();
			
			$("#oneroomDanjiListButton").show();
			$("#oneroomDanjiListView").show();
			
			$('#filtertype_APT').hide();
			$('#filtertype_OFT').hide();
			$('#filtertype_ONE').show();

			$("input[name='area[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("input[name='ROOM_TYPE[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("input[name='charterprice[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("input[name='monthly_deposit[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("input[name='monthly[]']").each(function() {
	           if($(this).val()!='all') $(this).prop("checked", false);
	           else $(this).prop("checked", true);
	        });

			$("#type02_rd09").prop("checked", true);
			$("#ar_chk07").prop("checked", true);

			//$('#filerMenuName_deal').html('거래유형');
			//$('#filerMenuName_area').html('면적');

			$('#filerMenuName_deal').html('거래유형');
			$('#filerMenuName_deal').removeClass('on');
			$('#filerMenuName_area').html('면적');
			$('#filerMenuName_area').removeClass('on');
			$('#filerMenuName_roomtype').html('방구조');
			$('#filerMenuName_roomtype').removeClass('on');
			//$('#filerMenuName_price').html('금액');
			//$('#filerMenuName_price').removeClass('on');
			$('#searchfilterbox_price').hide();	//금액숨김
		}

		$('.sub_filter_inner').css("height", "43px");
		$('.sub_filter_group').css("top", "100px");
		if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
			$('.sub_filter_inner').css("height", "80px");
			$('.sub_filter_group').css("top", "137px");
		}

		fnloadInfoCall();	// 맵로딩 
  	});

  	// 필터선택 (거래유형)
  	$('input[type=radio][name=transtype]').click(function(){
  		$('.filterSearchForms').show();
  		$('#filerMenuName_deal').html($(this).next("label").text());
  		var dealTypeSel = $(this).val();

  		$("#ar_chk01").prop("checked", true);

		//$('#filerMenuName_area').html('면적');

		// 원룸 하단닫기
		$(".itm_wrap").html('');
		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

		// 원룸 금액 전세 보증금 리셋
		$("input[name='charterprice[]']").each(function() {
           	if($(this).val() != 'all') $(this).prop("checked", false);
           	else $(this).prop("checked", true);
        });

        // 원룸 금액 월세 보증금 리셋
        $("input[name='monthly_deposit[]']").each(function() {
           	if($(this).val() != 'all') $(this).prop("checked", false);
           	else $(this).prop("checked", true);
        });

		// 원름 금액 월세 리셋
        $("input[name='monthly[]']").each(function() {
           	if($(this).val() != 'all') $(this).prop("checked", false);
           	else $(this).prop("checked", true);
        });

        $('#filerMenuName_deal').addClass('on');

		// 면적 초기화
		//$('#filerMenuName_area').html("면적");
        //$('#filerMenuName_area').removeClass('on');
        //$("input[name='area[]']").each(function() {
        	//$(this).attr("checked", false);
        //});

        // 방구조 초기화
        //$('#filerMenuName_roomtype').html("방구조");
        //$('#filerMenuName_roomtype').removeClass('on');
        $("input[name='ROOM_TYPE[]']").each(function() {
        	$(this).attr("checked", false);
        });

        // 금액 초기화
        //$('#filerMenuName_price').html("금액");
		//$('#filerMenuName_price').removeClass('on');
		$("input[name='charterprice[]']").each(function() {
        	$(this).attr("checked", false);
        });
		$("input[name='monthly_deposit[]']").each(function() {
        	$(this).attr("checked", false);
        });
		$("input[name='monthly[]']").each(function() {
        	$(this).attr("checked", false);
        });

        if(dealTypeSel == 'all')
        {
        	$('#filerMenuName_price').hide();

        	$('#filterCosts1').hide();
			$('#filterCosts2').hide();
			$('#filterCosts3').hide();

			// 면적 초기화
			$('#filerMenuName_area').html("면적");
	        $('#filerMenuName_area').removeClass('on');
	        $("input[name='area[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	        // 방구조 초기화
	        $('#filerMenuName_roomtype').html("방구조");
	        $('#filerMenuName_roomtype').removeClass('on');
	        $("input[name='ROOM_TYPE[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	     	// 금액 초기화
	        $('#filerMenuName_price').html("금액");
			$('#filerMenuName_price').removeClass('on');
			$("input[name='charterprice[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly_deposit[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

			monthCostSave1 = null;//월세보증금
			monthCostSave2 = null;//월세
        }
        else if(dealTypeSel == 'previous_2')
        {
        	$('#filerMenuName_price').show();
        	$('#filerMenuName_price').html("금액");
        	$('#filerMenuName_price').removeClass('on');

			$('#filterCosts1').show();
			$('#filterCosts2').hide();
			$('#filterCosts3').hide();
			$("input:checkbox[name='charterprice[]']:input[value=all]").prop("checked", true);

			// 면적 초기화
			$('#filerMenuName_area').html("면적");
	        $('#filerMenuName_area').removeClass('on');
	        $("input[name='area[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	        // 방구조 초기화
	        $('#filerMenuName_roomtype').html("방구조");
	        $('#filerMenuName_roomtype').removeClass('on');
	        $("input[name='ROOM_TYPE[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	     	// 금액 초기화
	        $('#filerMenuName_price').html("금액");
			$('#filerMenuName_price').removeClass('on');
			$("input[name='charterprice[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly_deposit[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

			monthCostSave1 = null;//월세보증금
			monthCostSave2 = null;//월세
        }
        else if(dealTypeSel == 'previous_3')
        {
        	$('#filerMenuName_price').show();
        	$('#filerMenuName_price').html("금액");
        	$('#filerMenuName_price').removeClass('on');

			$('#filterCosts1').hide();
			$('#filterCosts2').show();
			$('#filterCosts3').show();
			$("input:checkbox[name='monthly_deposit[]']:input[value=all]").prop("checked", true);
			$("input:checkbox[name='monthly[]']:input[value=all]").prop("checked", true);

			// 면적 초기화
			$('#filerMenuName_area').html("면적");
	        $('#filerMenuName_area').removeClass('on');
	        $("input[name='area[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	        // 방구조 초기화
	        $('#filerMenuName_roomtype').html("방구조");
	        $('#filerMenuName_roomtype').removeClass('on');
	        $("input[name='ROOM_TYPE[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

	     	// 금액 초기화
	        $('#filerMenuName_price').html("금액");
			$('#filerMenuName_price').removeClass('on');
			$("input[name='charterprice[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly_deposit[]']").each(function() {
	        	$(this).attr("checked", false);
	        });
			$("input[name='monthly[]']").each(function() {
	        	$(this).attr("checked", false);
	        });

			monthCostSave1 = null;//월세보증금
			monthCostSave2 = null;//월세
        }

        $('.sub_filter_inner').css("height", "43px");
        $('.sub_filter_group').css("top", "100px");
        if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
    		$('.sub_filter_inner').css("height", "80px");
    		$('.sub_filter_group').css("top", "137px");
    	}
		
		fnloadInfoCall();	// 맵로딩 
  	});

 	// 필터선택 (면적)
 	$('input[name="area[]"]').click(function(){
 		$('.filterSearchForms').show();
 		$('#filerMenuName_area').html($(this).next("label").text());

		// 원룸 하단닫기
		$('#searchfilterbox_roomtype').hide();
		$('#searchfilterbox_price').hide();
		$(".itm_wrap").html('');
 		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

        if($(this).val() == '' || $(this).val()=='all') {
        	$("input[name='area[]']").each(function() {
 	           	if($(this).val() != 'all') $(this).prop("checked", false);
 	           	else $(this).prop("checked", true);
 	        });
        }
        else
        {
        	$("input:checkbox[name='area[]']:input[value=all]").attr("checked", false);
        	if($(this).prop('checked')) {
        		$(this).prop("checked", true);
        	}
        	else
            {
        		var area = $("input:checkbox[name='area[]']:checked");
        	    if(area.length == 0) {
        	        $("input[name='area[]']").each(function(){
        	          	if($(this).val()=='' || $(this).val()=='all') $(this).prop('checked', true);
        	        })
        	    }
        	    else {
        			$(this).prop("checked", false);
        	    }
        	}
        }

		var setValueArea = null;
		var selAreaCtn = null;
		if($("input:checkbox[name='area[]']:input[value=all]").prop("checked") == false)
		{
			var seltranstype = $(":input:radio[name=saletype]:checked").val();
			
			// 원룸,투룸
    		if(seltranstype == 'ONE') {
        		var totCnts = 4;
        		var endNum = 100;
    		}
    		// 아파트 & 오피스텔
    		else {
    			var totCnts = 5;
    			var endNum = 166;
    		}
    		
			selAreaCtn = $("input:checkbox[name='area[]']:checked").length;
			if(selAreaCtn == 1)
    		{
				$("input[name='area[]']").each(function() {
    				if($(this).prop("checked") == true)
        			{
    					var labelecho = "";
    					if($(this).data('first') == "0") {
    						labelecho = '~ ' + $(this).data('end') + "m²";
    					}
    					else if($(this).data('end') == "100" || $(this).data('end') == "166") {
    						labelecho = $(this).data('end') + "m² ~";
    					}
    					else {
    						labelecho = $("input:checkbox[name='area[]']:checked").next("label").text();
    					}
    					$('#filerMenuName_area').html(labelecho);
    				}
     	        });
			}
			else
			{
    			if(selAreaCtn < totCnts)
        		{
        			var num = 0;
        			var first = null;
        			var end = null;
        			$("input[name='area[]']").each(function() {
        				if($(this).prop("checked") == true)
            			{
                			if(num == 0) first = $(this).data('first');
                			end = $(this).data('end');
         	           		num = num + 1;
        				}
         	        });

         	        if(first == '0' && end != endNum) {
         	        	setValueArea = "~ " + end + "m²";
         	        }
         	        else if(first != '0' && end == endNum) {
         	        	setValueArea = first + "m² ~";
         	        }
         	        else if(first == '0' && end == endNum) {
         	        	setValueArea = "전체";
         	        	$("input[name='area[]']").each(function() {
        					$(this).prop("checked", false);
             	        });
        				$("input:checkbox[name='area[]']:input[value=all]").prop("checked", true);
        	        }
         	        else {
         	        	setValueArea = first + "m² ~ " + end + "m²";
         	        }
        		}
    			else
    			{
    				setValueArea = "전체";
    				$("input[name='area[]']").each(function() {
    					$(this).prop("checked", false);
         	        });
    				$("input:checkbox[name='area[]']:input[value=all]").prop("checked", true);
    			}

    			$('#filerMenuName_area').html(setValueArea);
			}
		}
		else {
			$('#filerMenuName_area').html("전체");
		}

		$('#filerMenuName_area').addClass('on');
		$('.sub_filter_inner').css("height", "43px");
		$('.sub_filter_group').css("top", "100px");
		if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
			$('.sub_filter_inner').css("height", "80px");
			$('.sub_filter_group').css("top", "137px");
		}

		fnloadInfoCall();	// 맵로딩 
 	});

	// 방구조 선택
    $('input[name="ROOM_TYPE[]"]').click(function(){
    	$('.filterSearchForms').show();
    	$('#searchfilterbox_roomtype').show();
    	var selLabelName = $(this).next("label").text();
    	var selLavelVal = $(this).val();
    	var selLavelRooms = null;
    	var selLavelCheck = $(this).prop("checked");
     	$('#filerMenuName_roomtype').html(selLabelName);
     	if(selLavelCheck == true)
     	{
     		selLavelRooms = $(this).data('roomname');
         	if(selLavelRooms == '원룸(오픈형)' || selLavelRooms == '원룸(분리형)') {
         		selLavelRooms = "원룸";
    		}
    		else if(selLavelRooms == '쓰리룸이상') {
    			selLavelRooms = "쓰리룸";
    		}
    		else if(selLavelRooms == '복층형') {
    			selLavelRooms = "복층";
     		}
     	}

		// 원룸 하단닫기
		$('#searchfilterbox_price').hide();
		$(".itm_wrap").html('');
 		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

        if($(this).val()=='' || $(this).val()=='all')
        {
        	$("input[name='ROOM_TYPE[]']").each(function() {
 	           	if($(this).val() != 'all') $(this).prop("checked", false);
 	           	else $(this).prop("checked", true);
 	        });
        }
        else
        {
        	$('input:checkbox[name="ROOM_TYPE[]"]:input[value=all]').attr("checked", false);
        	if($(this).prop('checked')) {
        		$(this).prop("checked", true);
        	}
        	else
            {
        		var area = $("input:checkbox[name='ROOM_TYPE[]']:checked");
        	    if(area.length == 0) {
        	        $("input[name='ROOM_TYPE[]']").each(function(){
        	          	if($(this).val() == '' || $(this).val() == 'all') $(this).prop('checked', true);
        	          	$('#filerMenuName_roomtype').html('전체');
        	        })
        	    }
        	    else {
        			$(this).prop("checked", false);
        	    }
        	}
        }

		var setValueRoom = null;
		var selRoomCtn = null;
		if($("input:checkbox[name='ROOM_TYPE[]']:input[value=all]").prop("checked") == false)
		{
        	var totCnts = 6;
    		
        	selRoomCtn = $("input:checkbox[name='ROOM_TYPE[]']:checked").length;
			if(selRoomCtn == 1)
    		{
				$("input[name='ROOM_TYPE[]']").each(function() {
    				if($(this).prop("checked") == true)
        			{
    					setValueRoom = $(this).data('roomname');
    					if(setValueRoom == '원룸(오픈형)' || setValueRoom == '원룸(분리형)') {
    						setValueRoom = "원룸";
    					}
    					else if(setValueRoom == '쓰리룸이상') {
    						setValueRoom = "쓰리룸";
    					}
    					else if(setValueRoom == '복층형') {
    	        	 		setValueRoom = "복층";
    	    	 		}
    					 
    					$('#filerMenuName_roomtype').html(setValueRoom);
    				}
     	        });
			}
			else
			{
    			if(selRoomCtn < totCnts)
        		{
            		var sel = 1;
            		var firstNames = '';
            		var lastNames = '';
    				$("input[name='ROOM_TYPE[]']").each(function() {
        				if($(this).prop("checked") == true)
            			{
        					setValueRoom = $(this).data('roomname');

        					if(setValueRoom == '원룸(오픈형)' || setValueRoom == '원룸(분리형)') {
            					setValueRoom = "원룸";
            				}
            				else if(setValueRoom == '쓰리룸이상') {
            					setValueRoom = "쓰리룸";
            				}
            				else if(setValueRoom == '복층형') {
                    	 		setValueRoom = "복층";
                	 		}

                	 		if(sel == 1) firstNames = setValueRoom;
                	 		if(sel == selRoomCtn) lastNames = setValueRoom;
                	 		
                	 		sel++;
        				}
         	        });

    				//if(selLavelCheck == true && selLavelRooms != setValueRoom) setValueRoom = selLavelRooms;
    				if(firstNames != lastNames)	setValueRoom = firstNames + ' ~ ' + lastNames;
        		}
    			else
    			{
    				setValueRoom = "전체";
    				$("input[name='ROOM_TYPE[]']").each(function() {
    					$(this).prop("checked", false);
         	        });
    				$("input:checkbox[name='ROOM_TYPE[]']:input[value=all]").prop("checked", true);
    			}

    			$('#filerMenuName_roomtype').html(setValueRoom);
			}
		}
		else {
			$("input:checkbox[name='ROOM_TYPE[]']:input[value=all]").prop("checked", true);
			$('#filerMenuName_area').html("전체");
		}

		$('#filerMenuName_roomtype').addClass('on');
		$('.sub_filter_inner').css("height", "43px");
		$('.sub_filter_group').css("top", "100px");
		if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
			$('.sub_filter_inner').css("height", "80px");
			$('.sub_filter_group').css("top", "137px");
		}

    	fnloadInfoCall();	// 맵로딩    	
    });

    
    // --- 금액 선택 --- //
   
    // 전세 보증금
	$('input[name="charterprice[]"]').click(function(){
		$('.filterSearchForms').show();
		$('#searchfilterbox_price').show();
		// 원룸 하단닫기
		$(".itm_wrap").html('');
		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

		if($(this).val() == '' || $(this).val()=='all') {
        	$("input[name='charterprice[]']").each(function() {
 	           	if($(this).val() != 'all') $(this).prop("checked", false);
 	           	else $(this).prop("checked", true);
 	        });
        }
        else {
        	$('input:checkbox[name="charterprice[]"]:input[value=all]').attr("checked", false);
        	if ($(this).prop('checked')) {
        		$(this).prop("checked", true);
        	}
        	else
            {
        		var area = $("input:checkbox[name='charterprice[]']:checked");
        	    if ( area.length == 0 ) {
        	        $("input[name='charterprice[]']").each ( function() {
        	          if($(this).val() == '' || $(this).val()=='all') $(this).prop('checked', true);
        	        })
        	    }
        	    else {
        			$(this).prop("checked", false);
        	    }
        	}
        }

		var setValuePrice = null;
		var selPriceCtn = null;
		if($("input:checkbox[name='charterprice[]']:input[value=all]").prop("checked") == false)
		{   		
			selPriceCtn = $("input:checkbox[name='charterprice[]']:checked").length;
			if(selPriceCtn == 1)
    		{
				setValuePrice = $("input:checkbox[name='charterprice[]']:checked").next("label").text();

				$("input[name='charterprice[]']").each(function() {
    				if($(this).prop("checked") == true)
        			{
    					if($(this).data('first') == "0") {
    						setValuePrice = '~ ' + "5천";
    					}
    					else if($(this).data('end') == "3억이상") {
    						setValuePrice = $(this).data('first') + " ~";
    					}
    					else {
    						setValuePrice = $("input:checkbox[name='charterprice[]']:checked").next("label").text();
    					}
    				}
     	        });
			}
			else
			{
    			if(selPriceCtn < 4)
        		{
        			var num = 0;
        			var first = null;
        			var end = null;
        			var endNum = '3억이상';
        			$("input[name='charterprice[]']").each(function() {
        				if($(this).prop("checked") == true)
            			{
                			if(num == 0) first = $(this).data('first');
                			end = $(this).data('end');
         	           		num = num + 1;
        				}
         	        });

         	        if(first == '0' && end != endNum) {
         	    	  setValuePrice = "~ " + end;
        	        }
        	        else if(first != '0' && end == endNum) {
        	        	setValuePrice = first + " ~";
        	        }
        	        else if(first == '0' && end == endNum) {
        	        	setValuePrice = "전체";
        	        	$("input[name='charterprice[]']").each(function() {
       						$(this).prop("checked", false);
            	        });
       					$("input:checkbox[name='charterprice[]']:input[value=all]").prop("checked", true);
       	        	}
        	        else {
        	        	setValuePrice = first + " ~ " + end;
        	        }
        		}
    			else
    			{
    				setValuePrice = "전체";
    				$("input[name='charterprice[]']").each(function() {
    					$(this).prop("checked", false);
         	        });
    				$("input:checkbox[name='charterprice[]']:input[value=all]").prop("checked", true);
    			}
			}
		}
		else {
			setValuePrice = "전체";
		}

		selMenuValueCost = selMenuValueCost + setValuePrice;

		$('#filerMenuName_price').html(setValuePrice);
		$('#filerMenuName_price').addClass('on');
		$('.sub_filter_inner').css("height", "43px");
		$('.sub_filter_group').css("top", "100px");
		if(monthCostSave1 != null && monthCostSave2 != null && monthCostSave1 != '전체' && monthCostSave2 != '전체') {
			$('.sub_filter_inner').css("height", "80px");
			$('.sub_filter_group').css("top", "137px");
		}

		fnloadInfoCall();	// 맵로딩
  	});

    // 월세보증금 (monthCostSave1)
	$('input[name="monthly_deposit[]"]').click(function(){
		$('.filterSearchForms').show();
		$('#searchfilterbox_price').show();
		// 원룸 하단닫기
		$(".itm_wrap").html('');
		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

		if($(this).val() == '' || $(this).val()=='all')
		{
        	$("input[name='monthly_deposit[]']").each(function() {
 	           	if($(this).val() != 'all') $(this).prop("checked", false);
 	           	else $(this).prop("checked", true);
 	        });
        }
        else
        {
        	$('input:checkbox[name="monthly_deposit[]"]:input[value=all]').attr("checked", false);
        	if ($(this).prop('checked')) {
        		$(this).prop("checked", true);
        	}
        	else
            {
        		var area = $("input:checkbox[name='monthly_deposit[]']:checked");
        	    if ( area.length == 0 ) {
        	        $("input[name='monthly_deposit[]']").each ( function() {
        	          if($(this).val() == '' || $(this).val()=='all') $(this).prop('checked', true);
        	        })
        	    }
        	    else {
        			$(this).prop("checked", false);
        	    }
        	}
        }

		var setValuedeposit = null;
		var seldepositCtn = null;
		if($("input:checkbox[name='monthly_deposit[]']:input[value=all]").prop("checked") == false)
		{   		
			seldepositCtn = $("input:checkbox[name='monthly_deposit[]']:checked").length;
			if(seldepositCtn == 1)
    		{
				setValuedeposit = $("input:checkbox[name='monthly_deposit[]']:checked").next("label").text();

				$("input[name='monthly_deposit[]']").each(function() {
    				if($(this).prop("checked") == true)
        			{
    					if($(this).data('first') == "0") {
    						setValuedeposit = '~ ' + "1천";
    					}
    					else if($(this).data('end') == "1억이상") {
    						setValuedeposit = $(this).data('first') + " ~";
    					}
    					else {
    						setValuedeposit = $("input:checkbox[name='monthly_deposit[]']:checked").next("label").text();
    					}
    				}
     	        });
			}
			else
			{
    			if(seldepositCtn < 4)
        		{
        			var num = 0;
        			var first = null;
        			var end = null;
        			var endNum = '1억이상';
        			$("input[name='monthly_deposit[]']").each(function() {
        				if($(this).prop("checked") == true)
            			{
                			if(num == 0) first = $(this).data('first');
                			end = $(this).data('end');
         	           		num = num + 1;
        				}
         	        });

        	        if(first == '0' && end != endNum) {
         	        	setValuedeposit = "~ " + end;
         	        }
         	        else if(first != '0' && end == endNum) {
         	        	setValuedeposit = first + " ~";
         	        }
         	        else if(first == '0' && end == endNum) {
         	        	setValuedeposit = "전체";
         	        	$("input[name='monthly_deposit[]']").each(function() {
        						$(this).prop("checked", false);
             	        });
        					$("input:checkbox[name='monthly_deposit[]']:input[value=all]").prop("checked", true);
        	        	}
         	        else {
         	        	setValuedeposit = first + " ~ " + end;
         	        }
        		}
    			else
    			{
    				setValuedeposit = "전체";
    				$("input[name='monthly_deposit[]']").each(function() {
    					$(this).prop("checked", false);
         	        });
    				$("input:checkbox[name='monthly_deposit[]']:input[value=all]").prop("checked", true);
    			}
			}
		}
		else {
			setValuedeposit = "전체";
		}

		selMenuValueCost = selMenuValueCost + setValuedeposit;

		monthCostSave1 = setValuedeposit;

		var printSetValuedeposit = "";

		if(monthCostSave2 != null)
		{
			$('.sub_filter_inner').css("height", "43px");
			$('.sub_filter_group').css("top", "100px");
			
			if(monthCostSave1 == '전체' && monthCostSave2 == '전체') {
				printSetValuedeposit = '전체';
			}
			else if(monthCostSave1 != '전체' && monthCostSave2 == '전체') {
				printSetValuedeposit = monthCostSave1;
			}
			else if(monthCostSave1 == '전체' && monthCostSave2 != '전체') {
				printSetValuedeposit = monthCostSave2;
			}
			else {
				printSetValuedeposit = monthCostSave1+'/'+monthCostSave2;
				$('.sub_filter_inner').css("height", "80px");
				$('.sub_filter_group').css("top", "137px");
			}
		}
		else
		{
			printSetValuedeposit = monthCostSave1;
		}

		$('#filerMenuName_price').html(printSetValuedeposit);
		$('#filerMenuName_price').addClass('on');

		fnloadInfoCall();	// 맵로딩
  	});

	// 월세 (monthCostSave2)
	$('input[name="monthly[]"]').click(function(){
		$('.filterSearchForms').show();
		$('#searchfilterbox_price').show();
		// 원룸 하단닫기
		$(".itm_wrap").html('');
		$("#oneroomDanjiListButton").hide();
		$("#oneroomDanjiListView").hide();
		fnoneRoomAllListPrintClose();

		if($(this).val() == '' || $(this).val()=='all') {
        	$("input[name='monthly[]']").each(function() {
 	           	if($(this).val() != 'all') $(this).prop("checked", false);
 	           	else $(this).prop("checked", true);
 	        });
        }
        else {
        	$('input:checkbox[name="monthly[]"]:input[value=all]').attr("checked", false);
        	if ($(this).prop('checked')) {
        		$(this).prop("checked", true);
        	}
        	else
            {
        		var area = $("input:checkbox[name='monthly[]']:checked");
        	    if ( area.length == 0 ) {
        	        $("input[name='monthly[]']").each ( function() {
        	          if($(this).val() == '' || $(this).val()=='all') $(this).prop('checked', true);
        	        })
        	    }
        	    else {
        			$(this).prop("checked", false);
        	    }
        	}
        }

		var setValuemonthly = null;
		var selmonthlyCtn = null;
		if($("input:checkbox[name='monthly[]']:input[value=all]").prop("checked") == false)
		{   		
			selmonthlyCtn = $("input:checkbox[name='monthly[]']:checked").length;
			if(selmonthlyCtn == 1)
    		{
				setValuemonthly = $("input:checkbox[name='monthly[]']:checked").next("label").text();

				$("input[name='monthly[]']").each(function() {
    				if($(this).prop("checked") == true)
        			{
    					if($(this).data('first') == "0") {
    						setValuemonthly = '~ ' + "50만";
    					}
    					else if($(this).data('end') == "100만이상") {
    						setValuemonthly = $(this).data('first') + " ~";
    					}
    					else {
    						setValuemonthly = $("input:checkbox[name='monthly[]']:checked").next("label").text();
    					}
    				}
     	        });
			}
			else
			{
    			if(selmonthlyCtn < 4)
        		{
        			var num = 0;
        			var first = null;
        			var end = null;
        			var endNum = '100만이상';
        			$("input[name='monthly[]']").each(function() {
        				if($(this).prop("checked") == true)
            			{
                			if(num == 0) first = $(this).data('first');
                			end = $(this).data('end');
         	           		num = num + 1;
        				}
         	        });

         	        if(first == '0' && end != endNum) {
         	        	setValuemonthly = "~ " + end;
        	        }
        	        else if(first != '0' && end == endNum) {
        	        	setValuemonthly = first + " ~";
        	        }
        	        else if(first == '0' && end == endNum) {
        	        	setValuemonthly = "전체";
        	        	$("input[name='monthly[]']").each(function() {
       						$(this).prop("checked", false);
            	        });
       					$("input:checkbox[name='monthly[]']:input[value=all]").prop("checked", true);
       	        	}
        	        else {
        	        	setValuemonthly = first + " ~ " + end;
        	        }
        		}
    			else
    			{
    				setValuemonthly = "전체";
    				$("input[name='monthly[]']").each(function() {
    					$(this).prop("checked", false);
         	        });
    				$("input:checkbox[name='monthly[]']:input[value=all]").prop("checked", true);
    			}
			}
		}
		else {
			setValuemonthly = "전체";
		}

		selMenuValueCost = selMenuValueCost + setValuemonthly;

		monthCostSave2 = setValuemonthly;

		var printSetValuemonthly = '';

		if(monthCostSave1 != null)
		{
			$('.sub_filter_inner').css("height", "43px");
			$('.sub_filter_group').css("top", "100px");
			
			if(monthCostSave1 == '전체' && monthCostSave2 == '전체') {
				printSetValuemonthly = '전체';
			}
			else if(monthCostSave1 != '전체' && monthCostSave2 == '전체') {
				printSetValuemonthly = monthCostSave1;
			}
			else if(monthCostSave1 == '전체' && monthCostSave2 != '전체') {
				printSetValuemonthly = monthCostSave2;
			}
			else {
				printSetValuemonthly = monthCostSave1+'/'+monthCostSave2;
				$('.sub_filter_inner').css("height", "80px");
				$('.sub_filter_group').css("top", "137px");
			}
		}
		else {
			printSetValuemonthly = monthCostSave2;
		}

		$('#filerMenuName_price').html(printSetValuemonthly);
		$('#filerMenuName_price').addClass('on');

		fnloadInfoCall();	// 맵로딩
  	});

	if(cate != '' && complexdetail.type != '' && complexdetail.idx > 0) {
  		fnComplexDetailSrch(complexdetail.idx, complexdetail.type);
  	}
});
</script>