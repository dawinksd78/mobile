<?php
// 매매타입 (기본 설정)
if(!$transtype) $transtype = "all"; // 전체
?>

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
                           	
                            <div class="itm_summ itm_exp itmlst">
                                <div class="pre_tag">입주예정</div>
                                <p class="ex_info"><?php echo $min_supply_area_m2; ?>m²(<?php echo $MIN_SUPPLY_AREA_PYEONG; ?>평) ~ <?php echo $max_supply_area_m2; ?>m²(<?php echo $MAX_SUPPLY_AREA_PYEONG; ?>평)</p>
                                <p class="ex_info"><?php echo $TOTAL_DONG_COUNT ?>동, <?php echo $HIGH_FLOOR; ?>층, <?php echo $TOTAL_HOUSE_HOLD_COUNT; ?>세대</p> 
                                <span class="addinfo02"><b class="exp01"><?php echo $CONSTRUCT_YEAR; ?>년 <?php echo $CONSTRUCT_MONTH; ?>월 입주예정</b></span>		
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="itmbox_wrap">
                        <h3 class="tit03">타입별 정보</h3>                        
                        <div class="itmbox">
                          	<div class="type_group">
                            	<dl class="type_info subj">
                              		<dt>타입</dt>
                              		<dd>세대</dd>
                              		<dd>면적</dd>
                             	</dl>
                             	
                             	<?php
                                $i = 0;
                                foreach($area_arr as $item) {
                                ?>
                                <dl class="type_info">
                                   	<dt><b><?php echo $item['AREA_NAME']; ?>m²</b></dt>
                                   	<dd><?php echo $item['HO_CNT']; ?>세대</dd>
                                   	<dd>공급 <b><?php echo floor($item['SUPPLY_AREA']); ?>m²</b> / 전용 <b><?php echo floor($item['EXCLUSIVE_AREA']); ?>m²</b></dd>
                                </dl>
                                <?php
                                    $i++;
                                }
                                ?>
							</div>                                          
                        </div>
                  	</div>
                  	
                  	<!-- div class="itmbox_wrap itm_go">
                        <div class="itmbox"><a href="" class="go_naver">네이버평면도 보러가기</a></div>
                    </div -->
                    
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
                                    <dd><?php echo ($BATL_RATIO=='0' || $BATL_RATIO=='') ? '-' : $BATL_RATIO.'%'; ?></dd>
                                </dl>
                                <dl>
                                    <dt>건폐율</dt>
                                    <dd><?php echo ($BTL_RATIO=='0' || $BTL_RATIO=='') ? '-' : $BTL_RATIO.'%'; ?></dd>
                                </dl>
                                <dl>
                                    <dt>관리사무소전화번호</dt>
                                    <dd><?php echo $MANAGEMENT_OFFICE_TELNO; ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>                        
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