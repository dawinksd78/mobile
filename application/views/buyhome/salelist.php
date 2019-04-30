<div id="dawinWrap" class="bgrey">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        
        <h2 class="title"><?php echo $complex_name; ?> 매물 <span class="count"><?php echo count($result); ?></span></h2>
                
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container subg02">
            <div class="cont_wrap">
                <div class="itmcard_wrap">
                    <ul class="itm_box">
                    
                        <?php foreach($result as $key=>$item) { ?>
                        <li class="itm_lst aptitm <?php if($realEstateType == 'ABYG' || $realEstateType == 'OBYG') { ?>prelst<?php } ?>">
                            <?php if($item['GOODS_STATUS'] == 'DR') { ?>
            					<!-- 거래완료 매물 표시 -->
            					<div class="sd_wrap">
                                    <div class="mask"></div>
                                    <div class="soldout"> <span class="txt">거래완료</span><span class="date"><?php echo $item['TRADE_DATE_FORMAT']; ?></span> </div>
                                </div>
            					<!-- 거래완료 매물 표시 끝 -->
                          	<?php } ?>
                            <?php if($realEstateType == 'ABYG' || $realEstateType == 'OBYG') { ?><div class="pre_tag">입주예정</div><?php } ?>
                            <div class="itm_inner">                               
                                <?php
                                if($useridx > 0)
                                {
                                    if($getDevideCookie == '1' && $DEVICE == 'AND') {
                                        $jslink = "dawin_newpop('/buyhome/saledetail/".$item['GOODS_IDX']."')";
                                    }
                                    else {
                                        $jslink = "goPagePop('/buyhome/saledetail/".$item['GOODS_IDX']."')";
                                    }
                                }
                                else {
                                    $jslink = "fnpoploginOpen()";
                                }
                                ?>
                                <div class="itm_pic">
                                    <div class="like_area">
                                    	<?php if($useridx > 0) { ?>
                                    	<span class="like <?php echo ($item['isfavo'] == 1) ? 'on' : ''; ?>" data-saleno="<?php echo $item['GOODS_IDX']; ?>" onclick="complexFavorate(this)"></span>
                                    	<?php } else { ?>
                                    	<span class="like" onclick="fnpoploginOpen()"></span>
                                    	<?php } ?>
                                    </div>
                                    <div class="itm_thumb" onclick="<?php echo $jslink; ?>"><img src="<?php echo ($item['img'] == '' || $item['img'] == null) ? '/images/img_noimg02.png' : $item['img']; ?>" alt="매물사진" /></div>
                                </div>
                                <a class="itm_info" onclick="<?php echo $jslink; ?>">
                                <div class="itm_exp">
                                    <p class="info01"><?php echo $item['COMPLEX_NAME']; ?> <?php echo $item['DONG']; ?>동</p>
                                    <p class="price bolder">
                                    	<span class="s_type0<?php echo $item['TRADE_TYPE']; ?>"><b><?php echo ($item['TRADE_TYPE']==3) ? '월세' : (($item['TRADE_TYPE']==2) ? '전세' : '매매'); ?></b></span> 
                                    	<span>
                                    		<?php if($item['TRADE_TYPE'] == 3) { ?>
                                                <?php echo number_format($item['PRICE2']); ?> / <?php echo number_format($item['PRICE3']); ?>
                                            <?php  } else if($item['TRADE_TYPE'] == 2) { ?>
                                                <script>document.write(fnMoneyAboutText(<?php echo $item['PRICE2'] * 10000; ?>));</script>
                                            <?php  } else { ?>
                                                <script>document.write(fnMoneyAboutText(<?php echo $item['PRICE1'] * 10000; ?>));</script>
                                            <?php } ?>
                                    	</span>
                                    </p>
                                    <p class="ex_info"><span><?php echo $item['FLOOR']; ?>층<?php if($item['TOTAL_FLOOR'] > 0) { ?>/<?php echo $item['TOTAL_FLOOR']; ?>층<?php } ?></span></p>                                  
                                    <p class="area"><?php echo $item['AREA1']; ?>m²(<?php echo floor($item['AREA1']*0.3025); ?>평)/<?php echo $item['AREA2']; ?>m²(<?php echo floor($item['AREA2']*0.3025); ?>평)</p>
                                </div>
                                </a>  
                            </div>
                        </li>
                        <?php } ?>
                        
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none"></div>
    <div class="lyr lyrpop01" style="display:none">
    	<a href="javascript:fnpoploginClose();" class="close">닫기</a>
        <div class="lyr_inner">
            <p class="cont">로그인이 필요한 메뉴입니다.<br>기존 중개수수료의 50% 수준인<br>다윈의 매수(임차)인 중개수수료는<br>회원에게만 적용됩니다.<br></p>
        </div>
        <div class="btn double">
            <button type="button" class="btn_type08" onclick="goPage('/member/join1')">회원가입</button>
            <button type="button" class="btn_type02" onclick="goPage('/member/login/PG_buyhome_salelist_<?php echo $URLRES; ?>')">로그인</button>
        </div>
    </div>
</div>

<script type="text/javascript">
function fnpoploginOpen() {
  	$(".mask").show();
  	$(".lyr").show();
}

function fnpoploginClose() {
  	$(".mask").hide();
  	$(".lyr").hide();
}
</script>