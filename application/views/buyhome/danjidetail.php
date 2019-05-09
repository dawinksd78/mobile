<?php
// 매매타입 (기본 설정)
if(!$transtype) $transtype = "all"; // 전체
?>

<!-- 그래프 JS -->
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/drag-panes.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript">
// highchart
var chart;
var tooltipMaxwidth = 100;
var tooltip_nowmonth;
</script>

<!-- 이미지 swiper(S) -->
<link rel="stylesheet" href="/css/swiper.min.css">
<style>
.swiper-container {
    width: 100%;
    height: 100%;
}
.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
}
</style>
<!-- 이미지 swiper(E) -->

<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
    		<?php //if($getDevideCookie == '1' && $DEVICE == 'AND') { ?>
    		<!-- button type="button" onclick="dawin_popclose();"><span class="">뒤로</span></button -->
    		<?php //} else { ?>
        	<!-- button type="button" onclick="window.close();"><span class="">뒤로</span></button -->
        	<?php //} ?>
        	<button type="button" onclick="goPage('/buyhome');"><span class="">뒤로</span></button>
        </span>
        
        <h2 class="title itm_tit"><?php echo $COMPLEX_NAME ?><p class="info01"><?php echo $address; ?></p></h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap public_cont02">
                <div class="itm_detail">
                    <div class="itmbox_wrap">
                        <div class="itmbox itmbox01">
                        	
                        	<div class="swiper-container pic_box">
                              	<ul class="swiper-wrapper slider">
                                  	<?php if(count($images_arr) < 1  || count($images_arr)==1 && $images_arr[0] =='') { ?>
                                        <li class="swiper-slide"><img src="/images/img_noimg.png"></li>
                                    <?php } else { ?>
                                        <?php foreach($images_arr as $key=>$item) { ?>
                                        <li class="swiper-slide"><img src="<?php echo $item; ?>"></li>
                                        <?php } ?>
                                    <?php } ?>
                              	</ul>
                              	<div class="swiper" style="z-index:1000;"><span class="cu">1</span> / <span class="tot"><?php echo count($images_arr); ?></span></div>
                            </div>
                            
                            <div class="itm_summ itm_exp">
                                <p class="ex_info"><?php echo $min_supply_area_m2; ?>m²(<?php echo $MIN_SUPPLY_AREA_PYEONG; ?>평) ~ <?php echo $max_supply_area_m2; ?>m²(<?php echo $MAX_SUPPLY_AREA_PYEONG; ?>평)</p>
                                <p class="ex_info"><?php echo $TOTAL_DONG_COUNT ?>개동, <?php echo $HIGH_FLOOR; ?>층, <?php echo $TOTAL_HOUSE_HOLD_COUNT; ?>세대, <?php echo $CONSTRUCT_YEAR; ?>준공 (여기는 단지정보입니다)</p>
                                <p class="mark">1년내 실거래가기준</p>
                                <p class="price"> <span class="s_type01"><b>매매</b> <script>document.write(fnrangeStr(<?php echo $CURR_SELL_MIN_PRICE * 10000; ?>, <?php echo $CURR_SELL_MAX_PRICE * 10000; ?>));</script></span> <span class="s_type02"><b>전세</b> <script>document.write(fnrangeStr(<?php echo $CURR_CHARTERED_MIN_PRICE * 10000; ?>, <?php echo $CURR_CHARTERED_MAX_PRICE * 10000; ?>));</script></span> </p>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">타입별 실거래가</h3>
                        <div class="btn_space_box">
                        	<button type="button" class="mtype btn_space on" onclick="spaceUnitChange('m')" aria-label="제곱미터로 평형전환">㎡</button>
                        	<button type="button" class="ptype btn_space" onclick="spaceUnitChange('p')" aria-label="평으로 평형전환">평</button>
                        </div>
                        
                        <div class="itmbox">
                        	<div class="tab02 scroll" id="trade_history_ul">
                                <ul id="areaPrint"></ul>
                            </div>
                                                       
                            <div class="tabcon" id="tradehistory_div">
                              	
                              	<p class="r_deal_price" id="view_detail_template_price">0 원</p>
                              	
                                <div class="tab_style04 danji">
                                    <ul class="tab">
                                        <li><a href="javascript:;" class="bt_change_range" data-year="1" onClick="fnchartRangeChange(this)">1년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range" data-year="3" onClick="fnchartRangeChange(this)" id="after_chartinit" class="on">3년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range" data-year="5" onClick="fnchartRangeChange(this)">5년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range" data-year="10" onClick="fnchartRangeChange(this)">10년</a></li>
                                    </ul>
                            	</div>
                                
                                <div class="tab03">
                                    <ul id="charttoggle_tab">
                                        <li><a href="javascript:;" data-btenable="true" data-chartview="all" onclick="charttoggle(this)" class="<?php echo ($transtype == 'all') ? 'on' : ''; ?>">전체</a></li>
                                        <li><a href="javascript:;" data-btenable="true" data-chartview="sale" onclick="charttoggle(this)" class="<?php echo ($transtype == 'sale') ? 'on' : ''; ?>">매매</a></li>
                                        <li><a href="javascript:;" data-btenable="true" data-chartview="charter" onclick="charttoggle(this)" class="<?php echo ($transtype == 'previous') ? 'on' : ''; ?>">전세</a></li>
                                    </ul>
                                </div>
                                
                                <!-- 실거래가 출력 -->
                                <div class="dltbl02 tabcont">
                                	<!-- graph print -->
                                    <div class="graph_area">
                                    	<div style="position:relative; width:100%;">
                                            <div id="chartcontainer" style="height:200px; width:100%"></div>
                                    	</div>
                                    </div>
                                    
                                    <div class="real_detail">
										<table class="list">
											<thead>
												<tr class="header">
													<td>계약월</td>
													<td>매매/전세</td>
													<td>가격</td>
													<td>층</td>
												</tr>
											</thead>
											
											<!-- 실거래가 리스트 출력 -->
											<tbody id="view_detail_template_price_list"></tbody>
										</table>
										<a href="javascript:;" class="btn_more-price" onClick="getTradeList(this)" id="view_detail_template_price_list_more"><span>실거래가 더보기 +</span></a>
									</div>
									<div id="tradenull" style="display:none;padding:50px 0; font-size:20px;text-align:center">데이터가 없습니다.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  	<?php /* if($linkto != '') { ?>
                  	<div class="itmbox_wrap itm_go">
						<div class="itmbox">
                          	<a href="javascript:goPagePop('<?php echo $linkto; ?>');" class="go_naver">네이버평면도 보러가기</a>
                        </div>
                    </div>
                    <?php } */ ?>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">단지기본정보</h3>
                        <div class="itmbox">
                            <div class="dltbl">
                                <dl>
                                    <dt>총 세대수</dt>
                                    <dd><?php echo $TOTAL_HOUSE_HOLD_COUNT; ?>세대</dd>
                                </dl>
                                <dl>
                                    <dt>총 동수</dt>
                                    <dd><?php echo $TOTAL_DONG_COUNT; ?>개동</dd>
                                </dl>
                                <dl>
                                    <dt>준공년월</dt>
                                    <dd><?php echo $CONSTRUCT_YEAR; ?>.<?php echo $CONSTRUCT_MONTH; ?></dd>
                                </dl>
                                <dl>
                                    <dt>건설사명</dt>
                                    <dd><?php echo $CONSTRUCTION_COMPANY_NAME; ?></dd>
                                </dl>
                                <dl>
                                    <dt>최고층/최저층</dt>
                                    <dd><?php echo $HIGH_FLOOR; ?>층/<?php echo $LOW_FLOOR; ?>층</dd>
                                </dl>
                                <dl>
                                    <dt>세대당 주차</dt>
                                    <dd><?php echo ($PARKING_COUNT_BY_HOUSEHOLD > 0) ? $PARKING_COUNT_BY_HOUSEHOLD.' 대' : '-'; ?></dd>
                                </dl>
                                <dl>
                                    <dt>난방방식</dt>
                                    <dd><?php echo $HEAT_METHOD_TYPE_CODE_NAME; ?></dd>
                                </dl>
                                <dl>
                                    <dt>난방연료</dt>
                                    <dd><?php echo $HEAT_FUEL_TYPE_CODE_NAME; ?></dd>
                                </dl>
                                <dl>
                                    <dt>용적율</dt>
                                    <dd><?php echo $BATL_RATIO; ?>%</dd>
                                </dl>
                                <dl>
                                    <dt>건폐율</dt>
                                    <dd><?php echo $BTL_RATIO; ?>%</dd>
                                </dl>
                                <?php /*
                                <dl>
                                    <dt>평형</dt>
                                    <dd>
                                    	<?php $i=0;  foreach($area_arr as $key=>$item) { ?>
                                        <?php echo ($i==0) ? '' : ','; ?>
                                        <?php echo $item['AREA_NAME']."m²"; ?>
                                      	<?php $i++; } ?>
                                    </dd>
                                </dl>
                                */ ?>
                                <dl>
                                    <dt>관리사무소전화번호</dt>
                                    <dd><?php echo $MANAGEMENT_OFFICE_TELNO; ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <?php /*
                    <div class="itmbox_wrap">
                        <h3 class="tit03">위치 및 주변편의시설</h3>
                        <div class="itmbox itmbox02">
                            <div class="bg_map01" style="padding:0 0 15px 0;" onclick="goPage('/buyhome/comforts/<?php echo $COMPLEX_IDX; ?>/<?php echo $COMPLEX_TYPE; ?>')">
                            	<div class="apiMapView" id="apiMapView" style="width:100%;height:250px;"></div>
                            </div>
                        </div>
                    </div>
                    */ ?>
                </div>
            </div>
            
            <?php
            $goodsCnt = $sale_cnt + $charter_cnt + $monthly_cnt;
            if($goodsCnt > 0) {
                $pageUrl = "goPage('/buyhome/salelist/" . $COMPLEX_IDX . "/" . $COMPLEX_TYPE . "/" . $transtype . "/" . $ygtype . "')";
            }
            else {
                $pageUrl = "swal('매물이 없습니다');";
            }
            ?>            
            <div class="btn_area bot_btn">
                <button class="btn_type05" type="button" onclick="<?php echo $pageUrl; ?>">매물목록 ( <span class="count"><?php echo $goodsCnt; ?></span> )</button>
            </div>
        </div>
    </section>
</div>

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>
<script type="text/javascript">
//이미지 스와이프
var swiper = new Swiper('.swiper-container');
swiper.on('slideChange', function () {
	var pageNumber = swiper.realIndex;
	$('.cu').html(pageNumber + 1);
});
</script>

<!-- 그래프 JS -->
<script src="/js/chart.js?ver=<?php echo $this->config->item('js_css_ver')?>"></script>
<script type="text/javascript">
// 그래프
var echart;
var ohlc = [], ohlc2 = []
volume = [], volume2=[]
groupingUnits = [
  	['month',[1, 2, 3, 4, 6]],
  	['year',[1]]
];
var last_sale_price, last_charter_price = null;

// 매매 거래 (차트용)
var view_detail_template, view_detail_salelist_template, view_for_sale_list_template, oneroom_list_template = null;

// 거래리스트 리셋 (차트용)
var tradelistset = null;

// 실거래정보 (그래프 출력)
var selnum = null;
function getTradeHistory(obj)
{
	var mapno, maptype, no = null;
	
	if(obj === undefined) {
		mapno = $('#realDealData0').attr('data-mapno');
		maptype = $('#realDealData0').attr('data-maptype');
		no = $('#realDealData0').attr('data-no');

		$('#realDealData0').addClass("on");        
	}
	else {
		mapno = $(obj).data('mapno');
		maptype = $(obj).data('maptype');
		no = $(obj).data('no');

		$("#trade_history_ul .item.on").removeClass("on");
		$(obj).addClass("on");
	}

	selnum = no;
	
  	$.ajax({
    	url: '/buyhome/getTradeHistory',
    	type: 'GET',
    	data: {complex_idx:mapno, complex_type:maptype, area_no:no, transtype:'<?php echo $transtype; ?>'},
    	dataType: 'json',
    	success: function(result){
      		if(result.code != 200) {
        		return;
      		}

      		ohlc = result.data.sale, ohlc2 = result.data.charter, volume = result.data.sale_cnt, volume2=result.data.charter_cnt;
      		last_sale_price = result.data.sale_price, last_charter_price = result.data.charter_price;
      		chart = chartinit('chartcontainer');
      		$("#after_chartinit").trigger("click");	// 년도 클릭 상태
      		setlastprice('<?php echo $transtype; ?>');
    	},
    	error: function(request, status, error) {
      		console.log(error);
     	}
  	});

  	tradelistset= {complex_idx:mapno, complex_type:maptype, area_no:no, transtype:'<?php echo $transtype; ?>', page:0}
  	$("#view_detail_template_price_list_more").show();	// 실거래가 더보기 출력
  	getTradeList(obj);
}

// 실거래 목록 보기
function getTradeList()
{
	if(view_detail_salelist_template == null)
	{
	    $.ajax({
	      	url: "/tpl/view_detail_salelist_template.tpl?_="+ new Date().getTime(),
	      	method: 'GET',
	      	dataType: 'html',
	      	async: false,
	      	success: function(data) {
	          	view_detail_salelist_template = _.template(data);
	          	getTradeListTpl();
	      	}
		});
	}
	else {
	    getTradeListTpl();
	}
}

// 실거래 목록 출력 template
function getTradeListTpl()
{
  	$.ajax({
    	url: '/buyhome/getTradeList',
    	type: 'GET',
    	data: {complex_idx:tradelistset.complex_idx, complex_type:tradelistset.complex_type, area_no:tradelistset.area_no, transtype: tradelistset.transtype, page:tradelistset.page},
    	dataType: 'json',
    	success: function(result){
      		if(result.data.length < 1) {
        		$("#view_detail_template_price_list_more").hide();	// 실거래가 더보기 숨기기
        		return;
      		}

			// 실거래 목록 출력
      		if(tradelistset.page == 0) $("#view_detail_template_price_list").html(view_detail_salelist_template(result));
      		else $("#view_detail_template_price_list").append(view_detail_salelist_template(result));
      		tradelistset.page = result.nextpage;
    	},
    	error : function(request, status, error){
      		console.log(error);
     	}
  	});
}

//---------------------------------------------------------------------//

// 건물맵표시
function estatecompany_map()
{
	var lat = '<?php echo $LAT; ?>';
	var lng = '<?php echo $LNG; ?>';

	var mapContainer = document.getElementById('apiMapView'),
		mapOption = {
	  	center: new daum.maps.LatLng(lat, lng), //지도의 중심좌표.
		level: 3 //지도의 레벨(확대, 축소 정도 - 낮을수록 확대)
	};

	// 지도 생성 및 객체 리턴
	var map = new daum.maps.Map(mapContainer, mapOption);

	// 마커를 생성합니다
	var marker = new daum.maps.Marker({
	    position: new daum.maps.LatLng(lat, lng),	// 마커가 표시될 위치입니다. 
	    image: new daum.maps.MarkerImage('/images/ico_pointer.png', new daum.maps.Size(37, 50), {offset: new daum.maps.Point(18, 50)} )
	});

	// 마커가 지도 위에 표시되도록 설정합니다
	marker.setMap(map);
}

//---------------------------------------------------------------------//

$("document").ready(function(){
	getTradeHistory();	// 그래프
	//estatecompany_map();// 맵
});

// 제곱 & 평 변환
function spaceUnitChange(type)
{
	var htmls = [], classState = null, unitType = null;
	
	// m2
	if(type == 'm')
	{
		$('.mtype.btn_space').addClass("on");
		$('.ptype.btn_space').removeClass("on");
	}
	// 평
	else if(type == 'p')
	{
		$('.ptype.btn_space').addClass("on");
		$('.mtype.btn_space').removeClass("on");
	}

	<?php
	$i = 0;
	foreach($area_arr as $key=>$item) {
	    $areaNameNum = preg_replace("/[^0-9]*/s", "", $item['AREA_NAME']);
	    $areaNameEng = preg_replace("/[^a-zA-Z]*/s", "", $item['AREA_NAME']);
	?>
	if(selnum == '<?php echo $item['idx'] ?>') {
		classState = 'on';
	}
	else {
		classState = '';
	}

	// m2
	if(type == 'm') {
		unitType = "<?php echo $item['AREA_NAME'] . "m²"; ?>";
	}
	// 평
	else if(type == 'p') {
		unitType = "<?php echo floor($areaNameNum*0.3025) . $areaNameEng . "평"; ?>";
	}

	htmls += '<li><a id="realDealData<?php echo $i; ?>" class="item ' + classState + '" data-no="<?php echo $item['idx'] ?>" data-mapno="<?php echo $COMPLEX_IDX; ?>" data-mname="<?php echo $item['AREA_NAME']; ?>" data-pname="<?php echo $item['PYEONG_NAME']; ?>" data-maptype="<?php echo $COMPLEX_TYPE; ?>" onClick="getTradeHistory(this)">' + unitType + '</a></li>';
	<?php $i++; } ?>

	$("#areaPrint").html(htmls);
}
// 기본출력 (m2)
spaceUnitChange('m');
</script>