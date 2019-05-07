<div id="dawinWrap" class="mpwrap">
    <header id="header" class="header maphd">
    	<span class="btn_back back02">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
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
                        <li><a href="#" onclick="goPage('/mypage/myzzimsale')" class="on">내집구하기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myhousesale')">내집내놓기</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinfo')">내정보</a></li>
                        <li><a href="#" onclick="goPage('/mypage/myinquiry')">1:1문의</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="cont_wrap public_cont02 mp mp_sell">
                <div class="cont">
                    <div class="itmcard_wrap">
                        <div class="mbuy_tab">
                            <ul>
                                <li><a href="#" onclick="goPage('/mypage/myzzimsale')">찜한매물</a></li>
                                <li><a href="#" onclick="goPage('/mypage/mycontractsale')" class="on">내계약매물</a></li>
                            </ul>
                        </div>
                        
                        <div class="cont_exp">
                            <p>내가 다윈중개에서 계약한 매물입니다.</p>
                        </div>
                        
                        <ul class="itm_box">
                        	<?php foreach($contract as $row) { ?>
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
                                    <div class="sd_wrap">
                                        <div class="mask"></div>
                                        <div class="soldout"> <span class="txt">거래완료</span><span class="date"><?php echo $row['TRADE_DATE_FORMAT']?></span> </div>
                                    </div>
                                    
                                    <div class="itm_pic">
                                        <div class="itm_thumb"><img src="<?php echo $row['imgsrc']?>" alt="매물사진" /></div>
                                    </div>
                                    
                                    <?php
                                    if($getDevideCookie == '1' && $DEVICE == 'AND') {
                                        $pageLink = "javascript:dawin_newpop('/buyhome/saledetail/".$row['GOODS_IDX']."');";
                                    }
                                    else {
                                        $pageLink = "javascript:goPagePop('/buyhome/saledetail/".$row['GOODS_IDX']."');";
                                    }
                                    ?>
                                    
                                    <?php if ( $row['CATEGORY'] !='ONE' ) { ?>
                                    <a class="itm_info" href="<?php echo $pageLink; ?>">
                                        <div class="itm_exp">
                                            <p class="info01"><?php echo $row['COMPLEX_NAME']; ?> <?php echo $row['DONG']; ?>동</p>
                                            <p class="price bolder"><span class="s_type0<?php echo $row['TRADE_TYPE']?>"><b><?php echo ($row['TRADE_TYPE'] == 3) ? "월세" : ($row['TRADE_TYPE'] == 2 ? "전세" : "매매"); ?></b></span> <span><?php echo $tradeType; ?></span></p>
                                            <p class="ex_info"><span><?php echo $row['FLOOR']?>층/<?php echo $row['TOTAL_FLOOR']?>층</span></p>                                  
                                            <p class="area"><?php echo $row['AREA1']?>m²(12평)/<?php echo $row['AREA2']?>m²(24평)</p>
                                        </div>
                                    </a>
                                    <?php } else { ?>                                    
                                    <a class="itm_info" href="<?php echo $pageLink; ?>">
                                        <div class="itm_exp">
                                            <p class="price bolder"><span class="s_type0<?php echo $row['TRADE_TYPE']; ?>"><b><?php echo ($row['TRADE_TYPE'] == 3) ? "월세" : ($row['TRADE_TYPE'] == 2 ? "전세" : "매매"); ?></b> <?php echo $tradeType; ?></span></p>
                                            <p class="area"><?php echo $row['AREA1']; ?>m² <span>(<?php echo number_format($row['AREA1']/3.3058,1); ?>평)</span></p>
                                            <p class="ex_info"><?php  echo (isset($ROOM_TYPE[ $row['ROOM_TYPE'] ])) ? $ROOM_TYPE[ $row['ROOM_TYPE'] ] : '-'; ?>, <?php echo $row['FLOOR']?>층/총 <?php echo $row['TOTAL_FLOOR']?>층<br>반려동물<?php echo $row['ANIMAL']=='' ? " - " : ($row['ANIMAL']=='1' ? '가능' : '불가'); ?>, 주차<?php echo $row['PARKING_FLAG']=='' ? " - " : ($row['PARKING_FLAG']=='Y' ? '가능' : '불가'); ?></p>
                                        </div>
                                    </a>
                                    <?php } ?>
                                </div>
                                
                                <div class="btn double">
                                    <button type="button" class="btn_line02" onClick="">계약서보기</button>
                                    <button type="button" onclick="contractAppraise()" class="btn_line02">중개평가하기</button>
                                </div>
                            </li>
                        	<?php } ?>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>    
</div>

<script type="text/javascript">
// 중개 평가
function contractAppraise() {
	var num = '';
	location.href = "/mypage/mycontractsaleappraise?contNumber=" + num;
}
</script>