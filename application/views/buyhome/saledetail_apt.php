<?php
// 매매 종류
switch($data['TRADE_TYPE'])
{
    case("3"):
        $tradeType = "월세";
        $tradeTypePay = "<script>document.write(fnMoneyAboutText(".$data['PRICE2']."*10000));</script>/<script>document.write(fnMoneyAboutText(".$data['PRICE3']."*10000));</script>";
        break;
        
    case("2"):
        $tradeType = "전세";
        $tradeTypePay = "<script>document.write(fnMoneyAboutText(".$data['PRICE2']."*10000));</script>";
        break;
        
    default:
        $tradeType = "매매";
        $tradeTypePay = "<script>document.write(fnMoneyAboutText(".$data['PRICE1']."*10000));</script>";
}

// 입주타입
switch($data['ENTER_TYPE'])
{
    case("1"):  $enterType = "즉시입주";                       break;
    case("2"):  $enterType = "입주일협의가능";                   break;
    case("3"):  $enterType = "입주일:".$data['ENTER_DATE']."이후";    break;
    default:    $enterType = "즉시입주";
}
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
    <header id="header" class="maphd">
    	<span class="btn_back">
        	<?php if($getDevideCookie == '1' && $DEVICE == 'AND') { ?>
    		<button type="button" onclick="dawin_popclose();"><span class="">뒤로</span></button>
    		<?php } else { ?>
        	<button type="button" onclick="window.close();"><span class="">뒤로</span></button>
        	<?php } ?>
        </span>
        
        <h2 class="title dt_tit">
            <p class="itmnum">매물번호 <b><?php echo $data['GOODS_NO']; ?></b></b></p>
            <span><?php echo $data['COMPLEX_NAME']; ?> <?php echo $data['DONG']; ?>동</span>
            <div class="like_area"> <span class="like <?php echo $data['isfav'] =='1' ? 'on' : ''; ?>" data-saleno="<?php echo $data['GOODS_IDX']; ?>" onclick="complexFavorate(this)"></span> </div>
        </h2>
              	
      	<!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap public_cont02">
                <div class="itm_detail">
                    <div class="itmbox_wrap">
                        <div class="itmbox itmbox01 dtailbox">
                          	
                          	<div class="swiper-container pic_box">  
                          		<ul class="swiper-wrapper slider">
									<?php
									$imgState = "O";
                                    if($data['images']=='' || $data['images']==null) {
                                        if($data['cpx_images']=='' || $data['cpx_images']==null) {
                                            $imgState = "X";
                                            $images = '/images/img_noimg.png';
                    					}
                                    }
									
                                    if($imgState == 'O')
                                    {
    									$images1 = explode(',',  $data['images']);
    									$images2 = explode(',',  $data['cpx_images']);
                                        
                                        $totImgCnt1 = count($images1); 
                                        foreach($images1 as $imgrow)
                                        {
                                            ?>
                                        	<li class="swiper-slide"><img src="<?php echo $imgrow; ?>" alt="단지사진"></li>
                                            <?php
                                        }
                                        
                                        $totImgCnt2 = count($images2);
                                        foreach($images2 as $imgrow)
                                        {
                                            ?>
                                    		<li class="swiper-slide"><img src="<?php echo $imgrow; ?>" alt="단지사진"></li>
                                        	<?php
                                        }
                                        
                                        $totImgCnt = $totImgCnt1 + $totImgCnt2;
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="swiper-slide"><img src="<?php echo $images; ?>" alt="단지사진"></li>
                                        <?php
                                        $totImgCnt = 0;
                                    }
                                    ?>
                            	</ul>
                            	<div class="swiper" style="z-index:1000;"><span class="cu">1</span> / <span class="tot"><?php echo $totImgCnt; ?></span></div>
                          	</div>
                          	
                            <?php
                            // 글자숫자 (평)
                            $areaNameNum1 = preg_replace("/[^0-9]*/s", "", floor($data['AREA1']));
                            $areaNameEng1 = preg_replace("/[^a-zA-Z]*/s", "", $data['AREA1']);
                            $areaNameNum2 = preg_replace("/[^0-9]*/s", "", floor($data['AREA2']));
                            $areaNameEng2 = preg_replace("/[^a-zA-Z]*/s", "", $data['AREA2']);
                            ?>
                            <div class="itm_summ itm_exp">
                                <p class="price"><span class="s_type01"><b><?php echo $tradeType; ?></b> <?php echo $tradeTypePay; ?></span></p>
                                <p class="ex_info">
                                	<span><?php echo $data['DONG']; ?>동</span>
                                	<span><?php echo $data['FLOOR']; ?>층<?php if($data['TOTAL_FLOOR'] > 0) { ?>/<?php echo $data['TOTAL_FLOOR']; ?>층<?php } ?></span>
                                	<span><?php echo $data['AREA1']; ?>m²(<?php echo floor($areaNameNum1*0.3025).$areaNameEng1; ?>평)/<?php echo $data['AREA2']; ?>m²(<?php echo floor($areaNameNum2*0.3025).$areaNameEng2; ?>평)</span>
                                	<span><?php echo $enterType; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <?php /* if($data['NAVER_FLOOR_PLAN_LINK'] != '') { ?>
                        <div class="itmbox_wrap itm_go">
                          	<div class="itmbox">
                          		<a href="<?php echo $data['NAVER_FLOOR_PLAN_LINK']; ?>" class="go_naver">네이버평면도 보러가기</a>
                          	</div>
                        </div>
                    <?php } */ ?>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">중개수수료(VAT별도)</h3>
                        <div class="itmbox">
                            <div class="pee_wrap"> 
                                <!--<p class="p_txt">중개수수료</p>-->
                                <div class="bk_pee">
                                    <ul>
                                        <li><span class="g_term">타중개사</span><span class="g_bar orig" style="height:100%"><span><?php echo number_format($goodsrate['price'][0]); ?>만원</span></span></li>
                                        <li><span class="g_term">다윈중개</span><span class="g_bar dawinpee" style="height:<?php echo $goodsrate['percent']; ?>%"><span><?php echo number_format($goodsrate['price'][1]); ?>만원</span></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($data['CATEGORY'] == 'APT') { /* 아파트 */ ?>
                        <div class="itmbox_wrap">
                            <h3 class="tit03">매물기본정보</h3>
                            <div class="itmbox">
                                <div class="dltbl">
                                    <dl>
                                        <dt>면적</dt>
                                        <dd><?php echo $data['AREA1']; ?>m²(<?php echo floor($areaNameNum1*0.3025).$areaNameEng1; ?>평) / <?php echo $data['AREA2']; ?>m²(<?php echo floor($areaNameNum2*0.3025).$areaNameEng2; ?>평)</dd>
                                    </dl>
                                    <dl>
                                        <dt>방수/욕실수</dt>
                                        <dd><?php echo ($data['ROOM_CNT']) ? $data['ROOM_CNT'].'개' : '-'; ?>/<?php echo ($data['BATHROOM_CNT']) ? $data['BATHROOM_CNT'].'개' : '-'; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>방향</dt>
                                        <dd><?php echo $data['DIRECTIONTEXT']=='' ? ' - ':$data['DIRECTIONTEXT']; ?><?php echo ( $data['DIRECTIONTEXT']=='' || trim($data['DIRECTIONTEXT'])=='-')?'':"향"; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>현관구조</dt>
                                        <dd><?php echo $data['FRONT_DOOR_TYPE']=='' ? ' - ' : $data['FRONT_DOOR_TYPE']; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>발코니</dt>
                                        <dd>
                                        	<?php
                                			switch( $data['BALCONY'])
                                			{
                                				case("0"):  echo "없음";  break;
                                				case("1"):  echo "확장";  break;
                                				case("2"):  echo "비확장"; break;
                                				default:    echo "-";
                                			}
                                			?>
                                        </dd>
                                    </dl>
                                    <?php if($data['TRADE_TYPE'] == "3" || $data['TRADE_TYPE']=='2') { ?>
                        			<dl>
                                        <dt>반려동물</dt>
                                        <dd><?php echo $data['ANIMAL']=='1' ? '가능' : ($data['ANIMAL']=='2' ? "불가능" : '-'); ?></dd>
                                    </dl>
                        			<?php } ?>                                  
                                </div>
                            </div>
                        </div>
                    <?php } else { /*오피스텔*/ ?>
                        <div class="itmbox_wrap">
                            <h3 class="tit03">매물기본정보</h3>
                            <div class="itmbox">
                                <div class="dltbl">
                                    <dl>
                                        <dt>방구조</dt>
                                        <dd><?php echo ($data['ROOMTYPETXT']=='방구조')?'-':$data['ROOMTYPETXT'] ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>면적</dt>
                                        <dd><?php echo $data['AREA1']; ?>m²(<?php echo floor($areaNameNum1*0.3025).$areaNameEng1; ?>평) / <?php echo $data['AREA2']; ?>m²(<?php echo floor($areaNameNum2*0.3025).$areaNameEng2; ?>평)</dd>
                                    </dl>
                                    <dl>
                                        <dt>방수/욕실수</dt>
                                        <dd><?php echo $data['ROOM_CNT'] =='' ? '-' : $data['ROOM_CNT'].'개'; ?>/<?php echo $data['BATHROOM_CNT']=='' ? '-' : $data['BATHROOM_CNT'].'개'; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>방향</dt>
                                        <dd><?php echo $data['DIRECTIONTEXT']=='' ? " - " : $data['DIRECTIONTEXT']; ?><?php echo ($data['DIRECTIONTEXT']=='' || trim($data['DIRECTIONTEXT'])=='-') ? '' : "향"; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>현관구조</dt>
                                        <dd><?php echo $data['FRONT_DOOR_TYPE']; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>발코니</dt>
                                        <dd>
                                        	<?php
                                			switch( $data['BALCONY'])
                                			{
                                				case("0"):  echo "없음";  break;
                                				case("1"):  echo "확장";  break;
                                				case("2"):  echo "비확장"; break;
                                				default:    echo "-";
                                			}
                                			?>
										</dd>
                                    </dl>
                                    <?php if($data['TRADE_TYPE'] == "3" || $data['TRADE_TYPE']=='2') { ?>
                        			<dl>
                                        <dt>반려동물</dt>
                                        <dd><?php echo $data['ANIMAL']=='1' ? '가능' : ($data['ANIMAL']=='2' ? "불가능" : '-'); ?></dd>
                                    </dl>
                        			<?php } ?>                                   
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">매물옵션정보</h3>
                        <div class="itmbox">
                            <div class="opt_grp">
                            	<?php foreach($goods_option as $row) { ?>
									<span class="<?php echo (in_array($row['CODE_DETAIL'], $goods_option_selected)) ? 'yes' : ''; ?>"><?php echo $row['CODE_NAME']; ?></span>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($data['OWNER_COMMENT'] != '') { ?>
                    <div class="itmbox_wrap">
                        <h3 class="tit03">집주인한마디</h3>
                        <div class="itmbox">
                            <p><?php echo nl2br($data['OWNER_COMMENT']); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if(count($goods_feature_selected) > 0) { ?>
                    <div class="itmbox_wrap">
                        <h3 class="tit03">매물특징</h3>
                        <div class="itmbox">
                            <p>
                            <?php
                            foreach($goods_feature_arr as $idx=>$row)
                            {
								if(in_array($row['CODE_DETAIL'], $goods_feature_selected))
								{
									if($row['CODE_DETAIL'] != 'ETC') {
									    ?>
										<p><?php echo $row['CODE_NAME']; ?></p>
										<?php
                                    }
                                    else {
                                        ?>
										<p><?php echo nl2br($data['GOODS_FEATURE_ETC']); ?><p>
										<?php
                                    }
								}
                            }
                            ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">실거래가</h3>
                        <div class="btn_space_box">
                        	<button type="button" class="mtype btn_space on" onclick="spaceUnitChange('m')" aria-label="제곱미터로 평형전환">㎡</button>
                        	<button type="button" class="ptype btn_space" onclick="spaceUnitChange('p')" aria-label="평으로 평형전환">평</button>
                        </div>
                        <div class="itmbox">
                            <div class="tab02 scroll">
                                <ul id="areaPrint"></ul>
                            </div>                           
                        	<div class="tabcon" id="echart">
                          		<p class="r_deal_price price">0원</p>
                             	<div class="tab_style04 danji">
                                	<ul class="tab">
                                        <li><a href="javascript:;" class="bt_change_range" data-year="1">1년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range on" data-year="3">3년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range" data-year="5">5년</a></li>
                                        <li><a href="javascript:;" class="bt_change_range" data-year="10">10년</a></li>
                                	</ul>
                        		</div>
                                <div class="tab03">
                                    <ul>
                                        <!-- li><a href="" class="on">전체</a></li -->
                                        <li><a href="javascript:;" data-btenable="true" data-chartview="sale" class="bt_chage_saletype <?php echo ($data['TRADE_TYPE'] == 1 ) ? 'on' : ''; ?>">매매</a></li>
                                        <li><a href="javascript:;" data-btenable="true" data-chartview="charter" class="bt_chage_saletype <?php echo ($data['TRADE_TYPE'] == 1 ) ? '' : 'on'; ?>">전세</a></li>
                                    </ul>
                                </div>
                                <div class="dltbl02 tabcont">
                                    <div class="graph_area" id="ec_chartinit"></div>
                                    <div class="real_detail">
        								<table class="list">
        									<thead>
        										<tr class="header">
        											<td>계약월</td>
        											<td>가격</td>
        											<td>동</td>
        											<td>층</td>
        										</tr>
        									</thead>
        									<tbody></tbody>
        								</table>
        								<a href="javascript:;" class="btn_more-price" style="display:none" onclick="ecchart.getTradeListget()"><span>실거래가 더보기 +</span></a>
        							</div>
                                </div>
                    		</div>
                    		<div id="echartnull" style="display:none;text-align:center;padding:70px 0 50px;font-size:20px;">
								데이터가 없습니다.
							</div>
                		</div>
            		</div>
            		
                    <div class="itmbox_wrap">
                        <h3 class="tit03">단지기본정보</h3>
                        <div class="itmbox">
                            <div class="dltbl">
                                <dl>
                                    <dt>총 세대수</dt>
                                    <dd><?php echo $data['TOTAL_HOUSE_HOLD_COUNT']; ?>세대</dd>
                                </dl>
                                <dl>
									<dt>총 동수</dt>
                                    <dd><?php echo $data['TOTAL_DONG_COUNT']; ?>개동</dd>
                                </dl>
                                <dl>
                                    <dt>준공년월</dt>
                                    <dd><?php echo $data['CONSTRUCT_YEAR_MONTH']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>건설사명</dt>
                                    <dd><?php echo $data['CONSTRUCTION_COMPANY_NAME']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>최고층/최저층</dt>
                                    <dd><?php echo $data['HIGH_FLOOR']; ?>층/<?php echo $data['LOW_FLOOR']; ?>층</dd>
                                </dl>
                                <dl>
                                    <dt>세대당 주차</dt>
                                    <dd><?php echo ($data['PARKING_COUNT_BY_HOUSEHOLD'] > 0) ? $data['PARKING_COUNT_BY_HOUSEHOLD'] : '-'; ?> 대</dd>
                                </dl>
                                <dl>
                                    <dt>난방방식</dt>
                                    <dd><?php echo $data['HEAT_METHOD_TYPE_CODE_NAME']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>난방연료</dt>
                                    <dd><?php echo $data['HEAT_FUEL_TYPE_CODE_NAME']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>용적율</dt>
                                    <dd><?php echo $data['BATL_RATIO']; ?>%</dd>
                                </dl>
                                <dl>
                                    <dt>건폐율</dt>
                                    <dd><?php echo $data['BTL_RATIO']; ?>%</dd>
                                </dl>
                                <dl>
                                    <dt>평형</dt>
                                    <dd>
                                    	<?php
                                    	$i = 0;
                                    	foreach($areainfo as $idx=>$val)
                                    	{
                                    	    if($i != 0) echo ", ";
											echo ($this->input->get('space_unit')=='p') ? $val['PYEONG_NAME']."평" : $val['AREA_NAME'].'㎡';
											$i++;
                                        }
                                        ?>
                      				</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <?php /*
                    <div class="itmbox_wrap">
                        <h3 class="tit03">위치 및 주변편의시설</h3>
                        <div class="itmbox itmbox02 loc_box">
                            <div class="bg_map01" onclick="goPage('/buyhome/comforts/<?php echo $data['COMPLEX_IDX']; ?>/<?php echo $data['CATEGORY']; ?>')">
                            	<div class="apiMapView" id="apiMapView" style="width:100%;height:250px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="itmbox_wrap itm_go mgt" style="padding:0 0 15px 0;">
                      	<div class="itmbox">
                      		<a href="javascript:void(0);" onclick="goPage('/buyhome/brokeroffice/<?php echo $data['COMPLEX_IDX'] ?>/<?php echo $data['CATEGORY'] ?>')" class="go_naver">중개사무소 위치정보 보기</a>
                      	</div>
                    </div>
                    */ ?>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type05" onclick="goPage('/buyhome/saleinquiry/<?php echo $data['COMPLEX_IDX']; ?>/<?php echo $data['CATEGORY'] ?>/<?php echo $data['GOODS_IDX']; ?>')">중개사 문의하기</button>
            </div>
        </div>
    </section>
</div>

<!-- 그래프 출력 -->
<script type="text/javascript">
//그래프
var ecchart = function(){
	var self, opt;
	var ohlc, ohlc2, volume, volume2, last_sale_price , last_charter_price = [];
	var groupingUnits = [
	  	['month',[1, 2, 3, 4, 6]],
	  	['year',[1]]
	];
	var chart = null;
	var tradelistset;	// 거래리스트 리셋 (차트용)
	var view_detail_salelist_template = null;

	return {
		init: function(option){
			self = this;
			opt = option;

			tradelistset = {complex_idx:opt.mapno, complex_type:opt.maptype, area_no:opt.no, transtype: opt.saletype, page:0 };
			$.ajax({
    		    url: '/buyhome/getTradeHistory',
    		    type: 'GET',
    		    data: {complex_idx:opt.mapno, complex_type:opt.maptype, area_no:opt.no, transtype:'all',},
    		    dataType: 'json',
    		    success: function(result){
    		      	if( result.code != 200 )
    			    {
        		        //TODO 실거래가 없을경우
        				$("#echart").hide();
        				$("#echartnull").show();
        		        return;
    		      	}
    
    		      	if(result.data.length < 1)
    			    {
    					$("#echart").hide();
    					$("#echartnull").show();
    		        	return false;
    		      	}
    		      	else
    			    {
    					$("#echartnull").hide();
    					$("#echart").show();
    				}
    				
    		      	ohlc = result.data.sale,ohlc2 = result.data.charter ,volume = result.data.sale_cnt, volume2=result.data.charter_cnt;
    		      	last_sale_price = result.data.sale_price,
    				last_charter_price = result.data.charter_price;
    				self.makechart( opt.chaartid );
    				self.makelink();
    				self.setlastprice(opt.saletype);
    				self.getTradeList();
    				$(opt.selector + " a.bt_change_range.on").trigger("click");
    				$(opt.selector + " a.bt_chage_saletype.on").trigger("click");
    		    },
    		    error : function(request, status, error) {
    		      	console.log(error);
    		    }
    		});
    	},
		makelink: function(){
			$(opt.selector + " a.bt_change_range").on( "click" , self.onClickRange );
			$(opt.selector + " a.bt_chage_saletype").on( "click" , self.onClickSaleType );
		},
		setlastprice: function(){
		  	if (tradelistset.transtype == 'previous') {
		    	$(opt.selector + " .price").text(fnMoneyAboutText(last_charter_price*10000));
		  	}
		  	else {
		   		$(opt.selector + " .price").text(fnMoneyAboutText(last_sale_price*10000));
		  	}
		},
		makechart: function(chartcontainer){
			if(chart != null ) chart.destroy();
			chart = Highcharts.stockChart(chartcontainer, {
				exporting: {
			        enabled: false
			    },
			    plotOptions: {
					series: {
			        	lineWidth: 1,
			            marker: {
			                states: {
			                	hover: {
			                    	radiusPlus: 5,
			                        lineWidthPlus: 1
			                    }
			                }
			            },
			            states: {
			                hover: {
			                    lineWidth: 1
			                }
			            },
		                point: {
		                  events: {
		                      click: function () {
		                          //alert(tooltip_nowmonth);
		                      }
		                  }
		                }
			        },
			    },
		        chart: {
		            events: {
		                click: function(event) {
		                    //alert(Highcharts.dateFormat('%Y-%m', event.xAxis[0].value) );
		                    //alert(tooltip_nowmonth);
		                },
		                load : function () {
		                    this.xAxis[0].setExtremes( caldate(1) );
		                }
		            }
		        },
			    legend: {
			        enabled:false,
			        align: 'top',
			        verticalAlign: 'top',
			        borderWidth: 0,
			        //labelFormatter: function() { return "123"; }
			    },
			    rangeSelector: {
		            enabled : false,
		            allButtonsEnabled: false,
		            inputEnabled: false,
		            buttonPosition: {
		                align: 'left',
		                x : -15
		            },
		            buttonTheme: { // styles for the buttons
		                fill: 'none',
		                stroke: 'none',
		                'stroke-width': 0,
		                r: 10,
		                width: 32,
		                style: {
		                    color: '#626262',
		                    fontWeight: 'bold',
		                    fontSize: '14px'
		                },
		                states: {
		                    hover: {},
		                    select: {
		                        fill: '#626262',
		                        style: {
		                            color: 'white'
		                        }
		                    }
		                    // disabled: { ... }
		                }
		            },
		            buttons: [{
		                type: 'month',
		                count: 12,
		                text: '1년',
		                dataGrouping: {
		                    forced: true,
		                    units: [
		                        ['month', [1]]
		                    ]
		                }
		            }, {
		                type: 'month',
		                count: 36,
		                text: '3년',
		                dataGrouping: {
		                    forced: false,
		                    units: [
		                        ['month', [1]]
		                    ]
		                }
		            }, {
		                type: 'month',
		                count: 60,
		                text: '5년',
		                dataGrouping: {
		                    forced: false,
		                    units: [
		                        ['month', [1]]
		                    ]
		                }
		            }, {
		                type: 'all',
		                text: '10년',
		                dataGrouping: {
		                    forced: false,
		                    units: [
		                        ['month', [1]]
		                    ]
		                }
		            }],
		            selected: 0
		        },
		        navigator: {
		            enabled: false,
		            xAxis: {
		                type: 'datetime',
		                dateTimeLabelFormats: {
		                    month: '%Y-%m'
		                }
		            }
		        },
		        scrollbar: {
		            enabled: false
		        },
		        //title: {text: 'AAPL Historical'},
		        xAxis: {
		            type: 'datetime',
		            dateTimeLabelFormats: {
		                month: '%Y-%m'
		            }
		        },
		        yAxis: [{
		            opposite: false,
		            labels: {
		                formatter: function() {
		                    return fnMoneyAboutText(this.value*10000);
		                },
		                align: 'right',
		                x: -3
		            },
		            //title: {text: 'OHLC'},
		            height: '100%',
		            lineWidth: 0,
		            resize: {
		                enabled: true,
		                lineWidth: 1,
		                lineColor: '#999',
		            }
		        }, {
		            labels: {
		                enabled: false,
		                align: 'right',
		                x: -3
		            },
		            opposite: false,
		            //title: { text: 'Volume'},
		            top: '100%',
		            height: '0%',
		            offset: 0,
		            lineWidth: 0
		        }],

		        series: [{
		            id: 'mainchart',
		            data: ohlc,
		            lineWidth: 2,
		            type: 'spline',
		            name: '매매',
		            color: '#ff5c14',
		            dataGrouping: {
		                units: groupingUnits
		            },
		            //tooltip: {xDateFormat: '%Y-%m',valueSuffix: '억'},
		        }, {
		            linkto: 'mainchart',
		            data: ohlc2,
		            //      type: 'spline',
		            lineWidth: 2,
		            name: '전세',
		            color: '#3dbf9f',
		            dataGrouping: {
		                units: groupingUnits
		            },
		            // tooltip: {xDateFormat: '%Y-%m', valueSuffix: '억'},
		        }, {
		            type: 'column',
		            id: 'columntype',
		            name: '매매건수',
		            data: volume,
		            color: '#ff5c14',
		            yAxis: 1,
		            dataGrouping: {
		                units: groupingUnits
		            }
		        }, {
		            type: 'column',
		            linkto: 'columntype',
		            name: '전세건수',
		            data: volume2,
		            color: '#3dbf9f',
		            yAxis: 1,
		            dataGrouping: {
		                units: groupingUnits
		            }
		        }], // series
		        tooltip: {
		            shared: !0,
		            borderWidth: 0,
		            shadow: false,
		            style: {
		                fontSize: '10px'
		            },
		            positioner: function(e, t, n) {
		                return {
		                    x: this.chart.chartWidth - n.plotX > tooltipMaxwidth ? n.plotX : this.chart.chartWidth - tooltipMaxwidth,
		                    y: 0
		                }
		            },
		            formatter: function() {
		                var s = '<b>' + Highcharts.dateFormat('%Y.%m', this.x) + '</b>';
		                var s1='' , s2='';
		                tooltip_nowmonth = Highcharts.dateFormat('%Y.%m', this.x);
		                $.each(this.points, function() {
		                    if (this.series.name == "매매") s1 = '<br/>' + this.series.name + ': ' + fnMoneyAboutText(this.y*10000);
		                    else if (this.series.name == "전세") s2 = '<br/>' + this.series.name + ': ' + fnMoneyAboutText(this.y*10000);
		                    else if (this.series.name == "매매건수") s1 += ' (' + this.y + '건)';
		                    else if (this.series.name == "전세건수") s2 += ' (' + this.y + '건)';
		                });
		                return s + s1 + s2;
		            }
		        },
		    });
		    return chart;
		},
		getTradeList: function(){
			if(view_detail_salelist_template == null)
			{
				$.ajax({
					url: "/tpl/view_detail_salelist_template.tpl?_="+ new Date().getTime(),
					method: 'GET',
					dataType: 'html', //** Must add
					async: false,
					success: function(data) {
						view_detail_salelist_template = _.template(data);
						self.getTradeListget();
					}
				});
			}
			else self.getTradeListget( );
		},
		getTradeListget: function(){
			$.ajax({
				url: '/buyhome/getTradeList',
				type: 'GET',
				data: tradelistset ,
				dataType: 'json',
				success: function(result){
					if(result.data.length < 1) {
						$(opt.selector + " a.btn_more-price").hide();
						return;
					}
					
					if(tradelistset.page == 0) $(opt.selector +" table.list tbody").html(view_detail_salelist_template(result));
					else $(opt.selector +" table.list tbody").append(view_detail_salelist_template(result));
					tradelistset.page = result.nextpage;
					$(opt.selector + " a.btn_more-price").show()
				},
				error: function(request, status, error) {
					console.log(error);
				}
			});
		},
		onClickRange: function(){
			var year = $(this).data('year');
		  	var utc = caldate(year);
		    chart.xAxis[0].setExtremes(utc);
		    $(opt.selector + " a.bt_change_range").removeClass("on")
		    $(this).addClass("on");
		},
		onClickSaleType : function(){
			if($(this).data('btenable') != true) return false;
		  	var toggledata = $(this).data('chartview');
		  	if(toggledata == 'all')
			{
			  	chart.series[0].show();
			  	chart.series[1].show();
			  	chart.series[2].show();
			  	chart.series[3].show();
			  	tradelistset.transtype = 'all';
			  	tradelistset.page = 0;
		  	}
		  	else if(toggledata == 'sale')
			{
			  	chart.series[0].show();
			  	chart.series[1].hide();
			  	chart.series[2].show();
			  	chart.series[3].hide();
			  	tradelistset.transtype = 'sale';
			  	tradelistset.page = 0;
		  	}
		  	else
			{
			  	chart.series[0].hide();
			  	chart.series[1].show();
			  	chart.series[2].hide();
			  	chart.series[3].show();
			  	tradelistset.transtype = 'previous';
			  	tradelistset.page = 0;
		  	}

		  	$(opt.selector + " a.bt_chage_saletype").each (function() {
		    	$(this).removeClass("on");
		  	});

			$(this).addClass("on");
			self.setlastprice();
			self.getTradeList();
			$(opt.selector + " a.btn_more-price").show();
		},
		onClickListMore : function(){
		}
	}
}();

//실거래정보 (그래프 출력)
var selnum = null;
function fnecmakechart(obj)
{
	var ch_target, ch_mapno, ch_maptype, ch_no = null;

	if(obj == undefined) {
		ch_target = $('#realDealData0').attr('data-target');
		ch_mapno = $('#realDealData0').attr('data-mapno');
		ch_maptype = $('#realDealData0').attr('data-maptype');
		ch_no = $('#realDealData0').attr('data-no');

		$("div.changeMpInPop.on").removeClass("on");
		$('#realDealData0').addClass("on");        
	}
	else {
		ch_target = $(obj).data('target');
		ch_mapno = $(obj).data('mapno');
		ch_maptype = $(obj).data('maptype');
		ch_no = $(obj).data('no');

		$("div.changeMpInPop.on").removeClass("on");
		$(obj).addClass("on");
	}

	selnum = ch_no;

	ecchart.init({
		selector: "#echart",
		chaartid: ch_target,
		no: ch_no,
		mapno: ch_mapno,
		maptype: ch_maptype,
		saletype: "<?php echo ($data['TRADE_TYPE'] == 1 ) ? 'sale' : 'previous'; ?>"
	});
}
</script>

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>
<script type="text/javascript">
// 이미지 스와이프
var swiper = new Swiper('.swiper-container');
swiper.on('slideChange', function () {
	var pageNumber = swiper.realIndex;
	$('.cu').html(pageNumber + 1);
});

//---------------------------------------------------------------------//

//건물맵표시
function estatecompany_map()
{
	var lat = '<?php echo $data['LAT']; ?>';
	var lng = '<?php echo $data['LNG']; ?>';

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

//제곱 & 평 변환
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
	foreach($areainfo as $key=>$val)
	{
		if( $val['idx'] == 'N'.$data['SPACE_IDX'])
		{
		    $areaNameNum = preg_replace("/[^0-9]*/s", "", $val['AREA_NAME']);
		    $areaNameEng = preg_replace("/[^a-zA-Z]*/s", "", $val['AREA_NAME']);
    		?>
    		if(selnum == '<?php echo $val['idx'] ?>') {
    			classState = 'on';
    		}
    		else {
    			classState = '';
    		}
    		
    		// m2
    		if(type == 'm') {
    			unitType = "<?php echo $val['AREA_NAME']."m²"; ?>";
    		}
    		// 평
    		else if(type == 'p') {
    			unitType = "<?php echo floor($areaNameNum*0.3025) . $areaNameEng . "평"; ?>";
    		}
    		
    		htmls += '<li><a href="javascript:;" id="realDealData<?php echo $i; ?>" class="changeMpInPop st_area_link change_mp_conv_name ' + classState + '" data-target="ec_chartinit" data-no="<?php echo $val['idx']?>" data-mname="<?php echo $val['AREA_NAME']?>" data-pname="<?php echo $val['PYEONG_NAME']?>" data-mapno="<?php echo $data['COMPLEX_IDX']?>" data-maptype="<?php echo $data['CATEGORY']?>" onclick="fnecmakechart(this)">' + unitType + '</a></li>';
    		<?php
    		$i++;
        }
	}
	?>

	$("#areaPrint").html(htmls);
}

$("document").ready(function(){
	spaceUnitChange('m');	//기본출력
	fnecmakechart();
	estatecompany_map();	// 맵
});
</script>