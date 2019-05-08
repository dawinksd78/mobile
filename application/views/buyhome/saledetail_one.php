<?php
// 매매 종류
switch($data['TRADE_TYPE'])
{
    case("3"):
        $tradeType = "월세";
        $tradeTypePay = "<script>document.write(fnMoneyAboutText(".$data['PRICE2']."*10000));</script>"."/"."<script>document.write(fnMoneyAboutText(".$data['PRICE3']."*10000));</script>";
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

<div id="dawinWrap" class="grey">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<?php //if($getDevideCookie == '1' && $DEVICE == 'AND') { ?>
    		<!-- button type="button" onclick="dawin_popclose();"><span class="">뒤로</span></button  -->
    		<?php //} else { ?>
        	<!-- button type="button" onclick="window.close();"><span class="">뒤로</span></button -->
        	<?php //} ?>
        	<button type="button" onclick="goPage('/buyhome');"><span class="">뒤로</span></button>
        </span>
        
        <h2 class="title dt_tit">
            <p class="itmnum">매물번호 <b><?php echo $data['GOODS_NO']?></b></p>
            <span><?php echo $data['dongname']?></span>
            <div class="like_area"> <span class="like <?php echo $data['isfav'] =='1' ? 'on' : ''; ?>" data-saleno="<?php echo $data['GOODS_IDX']; ?>" onclick="complexFavorate(this)"></span> </div>
        </h2>
        
      	<!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap public_cont02">
                <div class="cont">
                    <div class="itm_detail">
                        <div class="itmbox_wrap">
                            <div class="itmbox itmbox01 dtailbox">
                              	<div class="swiper-container pic_box">  
    								<ul class="swiper-wrapper slider">
                                    	<?php
                                        if($data['images']=='' || $data['images']==null) {
                                            if($data['cpx_images']=='' || $data['cpx_images']==null) {
                        						$images[] = '/images/img_noimg.png';
                        					}
                                            else $images = explode(',',  $data['cpx_images']);
                                        }
                                        else $images = explode(',',  $data['images']);
                                        
                                        //$totImgCnt = count($images); 
                                        $totImgCnt = 0;
                                        foreach($images as $imgrow)
                                        {
                                            if($imgrow != '')
                                            {
                                                ?>
                                            	<li class="swiper-slide"><img src="<?php echo $imgrow; ?>" alt="단지사진"></li>
                                                <?php
                                                $totImgCnt++;
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <div class="swiper" style="z-index:1000;"><span class="cu"><?php if($totImgCnt > 0) { echo "1"; } else { echo "0"; } ?></span> / <span class="tot"><?php echo $totImgCnt; ?></span></div>
    							</div>
                                <div class="itm_summ itm_exp">
                                    <?php /*<p class="itmnum">매물번호 <b><?php echo $data['GOODS_NO']?></b></p>*/ ?>
                                    <p class="price"><span class="s_type0<?php echo $data['TRADE_TYPE']?>"><b><?php echo $tradeType; ?></b> <?php echo $tradeTypePay; ?></span></p>
                                    <?php
                                    // 글자숫자 (평)
                                    $areaNameNum1 = preg_replace("/[^0-9]*/s", "", floor($data['AREA1']));
                                    $areaNameEng1 = preg_replace("/[^a-zA-Z]*/s", "", $data['AREA1']);
                                    ?>
                                    <p class="ex_info">
                                    	<span><?php echo $data['ROOMTYPETXT']?></span>
                                    	<span><?php echo $data['AREA1']?>m²(<?php echo floor($areaNameNum1*0.3025).$areaNameEng1; ?>평형)</span>
                                    	<span><?php echo $enterType; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="itmbox_wrap">
                            <h3 class="tit03">중개수수료</h3>
                            <div class="itmbox">
                                <div class="pee_wrap"> 
                                    <div class="bk_pee">
                                        <ul>
                                            <li><span class="g_term">타중개사</span><span class="g_bar orig" style="height:100%"><span><?php echo number_format($goodsrate['price'][0]); ?>만원</span></span></li>
                                            <li><span class="g_term">다윈중개</span><span class="g_bar dawinpee" style="height:<?php echo $goodsrate['percent']; ?>%"><span><?php echo number_format($goodsrate['price'][1]); ?>만원</span></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="itmbox_wrap">
                            <h3 class="tit03">매물기본정보</h3>
                            <div class="itmbox">
                                <div class="dltbl">
                                    <dl>
                                        <dt>건물형태</dt>
                                        <dd>다세대/다가구</dd>
                                    </dl>
                                    <dl>
                                        <dt>방향</dt>
                                        <dd><?php echo ($data['DIRECTIONTEXT']=='') ? '-' : $data['DIRECTIONTEXT']; ?><?php echo ($data['DIRECTIONTEXT']=='' || trim($data['DIRECTIONTEXT'])=='-') ? '' : "향"; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>관리비</dt>
                                        <dd><?php echo ($data['EXPENSE'] =='') ? '-' : $data['EXPENSE'].'만원'; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>관리비포함항목</dt>
                                        <dd><?php echo $data['EXPENSE_ITEM']; ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>엘레베이터</dt>
                                        <dd><?php echo $data['ELEVATOR_FLAG']=='Y' ? '있음' : ($data['ELEVATOR_FLAG']=='N' ? "없음" : '-'); ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>주차</dt>
                                        <dd><?php echo $data['PARKING_FLAG']=='Y' ? '가능' : ($data['PARKING_FLAG']=='N' ? "불가능" : '-'); ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>반려동물</dt>
                                        <dd><?php echo $data['ANIMAL']=='1' ? '가능' : ($data['ANIMAL']=='2' ? "불가능" : '-'); ?></dd>
                                    </dl>
                                    <dl>
                                        <dt>난방방식</dt>
                                        <dd><?php echo $data['HEAT_TYPE']=='P' ? '개별' : ($data['HEAT_TYPE']=='C' ? "중앙" : '-'); ?></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        
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
                        
                        <?php if ( $data['OWNER_COMMENT'] !='' ) { ?>
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
                                    <?php
                                    foreach($goods_feature_arr as $idx=>$row)
                                    {
                                        if(in_array($row['CODE_DETAIL'], $goods_feature_selected))
                                        {
                                            if($row['CODE_DETAIL'] != 'ETC') {
                                                ?>
    											<p><?php echo $row['CODE_NAME']?></p>
    											<?php
                                            }
                                            else {
                                                ?>
    											<p><?php echo nl2br($data['GOODS_FEATURE_ETC'])?><p>
    											<?php
                                            }
                                        }
                                    }
									?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php /*
                        <div class="itmbox_wrap itm_go mgt">
                          	<div class="itmbox">
                          		<a href="javascript:void(0);" onclick="goPage('/buyhome/brokeroffice/<?php echo $data['COMPLEX_IDX'] ?>/<?php echo $data['CATEGORY'] ?>')" class="go_naver">중개사무소 위치정보 보기</a>
                          	</div>
                        </div>
                        */ ?>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button class="btn_type05" onclick="goPage('/buyhome/saleinquiry/<?php echo $data['COMPLEX_IDX']; ?>/<?php echo $data['CATEGORY'] ?>/<?php echo $data['GOODS_IDX']; ?>')">중개사 문의하기</button>
            </div>
        </div>
    </section>
</div>

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>
<script type="text/javascript">
// 이미지 스와이프
var swiper = new Swiper('.swiper-container');
swiper.on('slideChange', function () {
	var pageNumber = swiper.realIndex;
	$('.cu').html(pageNumber + 1);
});
</script>