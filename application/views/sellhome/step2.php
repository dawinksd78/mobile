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
    <form id="step2form" onsubmit="return false">
        <div class="sub_container">
            <div class="cont_wrap join_wrap sellitm">
                <h2 class="subj_tit"><span class="m_tit">매물옵션정보</span></h2>
                <div class="proc">
                	<a href="" class="bul_proc prev"></a><a href="" class="bul_proc on"></a><a href="" class="bul_proc"></a><a href="" class="bul_proc"></a>
                </div>
                
                <div class="cont" id="signforms">
                    <div class="inpbox rdinp">
                        <label for="itm_type01" class="lbl">입주희망일</label>
                        <div class="radio_box02">
                            <div class="rd01 rd02">
                                <input type="radio" id="ENTER_TYPE01" name="ENTER_TYPE" value="1" <?php echo ( isset($step2['ENTER_TYPE']) &&  $step2['ENTER_TYPE']=='1') ? "checked data-ischeked='checked'":""?>>
                                <label for="ENTER_TYPE01">즉시가능</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="ENTER_TYPE02" name="ENTER_TYPE" value="2" <?php echo ( isset($step2['ENTER_TYPE']) &&  $step2['ENTER_TYPE']=='2') ? "checked data-ischeked='checked'":""?>>
                                <label for="ENTER_TYPE02">협의필요</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="ENTER_TYPE03" name="ENTER_TYPE" value="3" <?php echo ( isset($step2['ENTER_TYPE']) &&  $step2['ENTER_TYPE']=='3') ? "checked data-ischeked='checked'":""?>>
                                <label for="ENTER_TYPE03">날짜지정</label>
                            </div>
                        </div>
                        <div class="dtinp" style="display:<?php echo ( !isset($step2['ENTER_TYPE']) ||  $step2['ENTER_TYPE']!='3') ? "none":""?>">
                            <input type="date" id="today" name="ENTER_DATE" value="<?php echo (isset($step2['ENTER_DATE'])) ? $step2['ENTER_DATE'] : '' ; ?>" placeholder="날짜지정" title="날짜지정" class="inp" autocomplete="off">
                            <span class="unit">이후</span>
                        </div>
                    </div>
                    
                    <?php /* 아파트 & 오피스텔 설정 */ if($CATEGORY != 'ONE') { ?>
                    <div class="inpbox">
                        <label for="" class="lbl">방수/욕실수</label>
                        <div class="flt">
                            <select id="ROOM_CNT" name="ROOM_CNT" title="방수" class="selec">
                                <option value="">방수</option>
                                <?php for( $i=1; $i <= 8;$i++ ) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ( isset($step2['ROOM_CNT']) &&  $step2['ROOM_CNT']==$i) ? "selected":""?>><?php echo $i; ?>개</option>
                                <?php } ?>
                            </select>
                            <select id="BATHROOM_CNT" name="BATHROOM_CNT" title="욕실수" class="selec">
                                <option value="">욕실수</option>
                                <?php for( $i=1; $i <= 8;$i++ ) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ( isset($step2['BATHROOM_CNT']) &&  $step2['BATHROOM_CNT']==$i) ? "selected":""?>><?php echo $i; ?>개</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="inpbox rdinp">
                        <label for="itm_type01" class="lbl">거주상태</label>
                        <div class="radio_box02">
                            <div class="rd01 rd02">
                                <input type="radio" id="OWNER_LIVE01" name="OWNER_LIVE" value="1" <?php echo ( isset($step2['OWNER_LIVE']) &&  $step2['OWNER_LIVE']=='1') ? "checked data-ischeked='checked'":""?>>
                                <label for="OWNER_LIVE01">집주인</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="OWNER_LIVE02" name="OWNER_LIVE" value="2" <?php echo ( isset($step2['OWNER_LIVE']) &&  $step2['OWNER_LIVE']=='2') ? "checked data-ischeked='checked'":""?>>
                                <label for="OWNER_LIVE02">세입자</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="OWNER_LIVE03" name="OWNER_LIVE" value="3" <?php echo ( isset($step2['OWNER_LIVE']) &&  $step2['OWNER_LIVE']=='3') ? "checked data-ischeked='checked'":""?>>
                                <label for="OWNER_LIVE03">공실</label>
                            </div>
                        </div>
                    </div>
                                       
                    <div class="inpbox rdinp">
                        <label for="itm_type01" class="lbl">방향</label>
                        <div class="radio_box02 rdbmulti">
                            <?php foreach ( $ARR_DIRECTIONS as $row ) { ?>
                            <div class="rd01 rd02 rd03">
                                <input type="radio" id="rd_di_<?php echo $row['CODE_DETAIL']; ?>" name="DIRECTION" value="<?php echo $row['CODE_DETAIL']; ?>" <?php echo ( isset($step2['DIRECTION']) &&  $step2['DIRECTION']==$row['CODE_DETAIL']) ? "checked data-ischeked='checked'":""?>>
                                <label for="rd_di_<?php echo $row['CODE_DETAIL']; ?>"><?php echo $row['CODE_NAME']; ?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <?php /* 아파트 & 오피스텔 설정 */ if($CATEGORY == 'APT' || $CATEGORY == 'OFT') { ?>
                        <!-- div class="inpbox rdinp">
                            <label for="itm_type01" class="lbl">현관구조</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="stru01" name="radios" value="" checked>
                                    <label for="stru01">계단식</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="stru02" name="radios" value="">
                                    <label for="stru02">복도식</label>
                                </div>
                            </div>
                        </div -->
                        
                        <div class="inpbox rdinp">
                            <label for="itm_type01" class="lbl">발코니</label>
                            <div class="radio_box02">
                                <div class="rd01 rd02">
                                    <input type="radio" id="BALCONY01" name="BALCONY" value="1" <?php echo ( isset($step2['BALCONY']) &&  $step2['BALCONY']=='1') ? "checked data-ischeked='checked'":""?>>
                                    <label for="BALCONY01">확장</label>
                                </div>
                                <div class="rd01 rd02">
                                    <input type="radio" id="BALCONY02" name="BALCONY" value="2" <?php echo ( isset($step2['BALCONY']) &&  $step2['BALCONY']=='2') ? "checked data-ischeked='checked'":""?>>
                                    <label for="BALCONY02">비확장</label>
                                </div>
                                <div class="rd01 rd02">
                                    <input type="radio" id="BALCONY03" name="BALCONY" value="0" <?php echo ( isset($step2['BALCONY']) &&  $step2['BALCONY']=='0') ? "checked data-ischeked='checked'":""?>>
                                    <label for="BALCONY03">없음</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- div class="inpbox rdinp">
                            <label for="itm_type01" class="lbl">내부주소</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="stru03" name="radios" value="" checked>
                                    <label for="stru03">단층</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="stru04" name="radios" value="">
                                    <label for="stru04">복층</label>
                                </div>
                            </div>
                        </div -->
                        
                        <?php if($step1['TRADE_TYPE']==2 || $step1['TRADE_TYPE']==3) { ?>
                        <div class="inpbox rdinp">
                            <label for="itm_type01" class="lbl">반려동물</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="ANIMAL01" name="ANIMAL" value="1" <?php echo ( isset($step2['ANIMAL']) &&  $step2['ANIMAL']=='1') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ANIMAL01">가능</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="ANIMAL02" name="ANIMAL" value="2" <?php echo ( isset($step2['ANIMAL']) &&  $step2['ANIMAL']=='2') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ANIMAL02">불가능</label>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <div class="inpbox rdinp otapt">
                            <label for="opt_info" class="lbl">옵션정보(복수선택가능)</label>
                            <div class="check_box02">
                                <?php foreach($goods_option as $row) { ?>
                                    <div class="chk01 f_chk">
                                        <input type="checkbox" id="chkopt<?php echo $row['CODE_DETAIL']?>" name="OPTIONS[]" value="<?php echo $row['CODE_DETAIL']?>" class="opt<?php echo $row['CODE_DETAIL']?>" <?php echo (in_array($row['CODE_DETAIL'], $goods_option_selected)) ? 'checked':''?>>
                                        <label for="chkopt<?php echo $row['CODE_DETAIL']?>"><?php echo $row['CODE_NAME']?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="inpbox">
                            <label for="itm_char" class="lbl">물건특징(복수선택가능)</label>
                            <div class="selec_option">
                                <div class="check_box">
                                    <?php
                                    $feature_etc = false;
                                    $i = 1;
                                    foreach( $ARR_GOODS_FEATURES as $row )
                                    {
                                        if( $row['CODE_DETAIL'] == 'ETC' && in_array($row['CODE_DETAIL'], $goods_feature_selected) ) $feature_etc = true;
                                    ?>
                                        <div class="check">
                                            <label for="itm_char0<?php echo $i; ?>">
                                                <input type="checkbox" name="GOODS_FEATURE[]" id="itm_char0<?php echo $i; ?>" value="<?php echo $row['CODE_DETAIL']?>" <?php echo ($row['CODE_DETAIL'] == 'ETC') ? "onClick='changeEtcArea(this)'" : ""; ?> <?php echo (in_array($row['CODE_DETAIL'], $goods_feature_selected)) ? 'checked' : ''; ?>>
                                                <i></i> <strong><?php echo $row['CODE_NAME']?></strong>
                                            </label>
                                        </div>
                                    <?php $i++; } ?>
                                    <textarea class="txtarea" id="GOODS_FEATURE_ETC" name="GOODS_FEATURE_ETC" placeholder="기타 선택 시 입력하세요." <?php echo (!$feature_etc) ? "readonly" :""?> placeholder="기타선택시 입력하세요."><?php echo ($feature_etc) ? $step2['GOODS_FEATURE_ETC'] :"" ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                    <?php /* 원룸 */ } else if($CATEGORY == 'ONE') { ?>
                        <div class="inpbox">
                            <label for="ad_expens" class="lbl">관리비</label>
                            <div class="inptxt">
                                <input type="number" id="price01" name="EXPENSE" placeholder="관리비입력" title="관리비입력" class="inp" autocomplete="off" data-span="#trade01" onkeyUp="priceKRup(this)" value="<?php echo isset($step2['EXPENSE']) ? $step2['EXPENSE']:"" ?>">
                                <span class="unit">만원</span>
                            </div>
                            <p class="kr" id="trade01">만원</p>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="opt_info" class="lbl">관리비 포함항목</label>
                            <div class="check_box02 chbox01">
                                <?php $k=1; foreach( $expense_item_arr as $idx=>$val ) { ?>                                
                                <div class="chk01"><!-- f_chk -->
                                    <input type="checkbox" id="mngfee0<?php echo $k; ?>" class="opt0<?php echo $k; ?>" name="EXPENSE_ITEM[]" value="<?php echo $idx?>" <?php echo (in_array($idx, $expense_item_selected)) ? 'checked':''?>>
                                    <label for="mngfee0<?php echo $k; ?>"><?php echo $val?></label>
                                </div>
                                <?php $k++; } ?>
                            </div>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="busi_type" class="lbl">반려동물</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="ani01" name="ANIMAL" value="1" <?php echo ( isset($step2['ANIMAL']) &&  $step2['ANIMAL']=='1') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ani01">가능</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="ani02" name="ANIMAL" value="2" <?php echo ( isset($step2['ANIMAL']) &&  $step2['ANIMAL']=='2') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ani02">불가능</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="busi_type" class="lbl">주차</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="pk01" name="PARKING_FLAG" value="Y" <?php echo ( isset($step2['PARKING_FLAG']) &&  $step2['PARKING_FLAG']=='Y') ? "checked data-ischeked='checked'":""?>>
                                    <label for="pk01">가능</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="pk02" name="PARKING_FLAG" value="N" <?php echo ( isset($step2['PARKING_FLAG']) &&  $step2['PARKING_FLAG']=='N') ? "checked data-ischeked='checked'":""?>>
                                    <label for="pk02">불가능</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="busi_type" class="lbl">난방방식</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="heat01" name="HEAT_TYPE" value="P" <?php echo ( isset($step2['HEAT_TYPE']) &&  $step2['HEAT_TYPE']=='P') ? "checked data-ischeked='checked'":""?>>
                                    <label for="heat01">개별</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="heat02" name="HEAT_TYPE" value="C" <?php echo ( isset($step2['HEAT_TYPE']) &&  $step2['HEAT_TYPE']=='C') ? "checked data-ischeked='checked'":""?>>
                                    <label for="heat02">중앙</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="busi_type" class="lbl">엘리베이터</label>
                            <div class="radio_box02">
                                <div class="rd01">
                                    <input type="radio" id="ev01" name="ELEVATOR_FLAG" value="Y"  <?php echo ( isset($step2['ELEVATOR_FLAG']) &&  $step2['ELEVATOR_FLAG']=='Y') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ev01">있음</label>
                                </div>
                                <div class="rd01">
                                    <input type="radio" id="ev02" name="ELEVATOR_FLAG" value="N"  <?php echo ( isset($step2['ELEVATOR_FLAG']) &&  $step2['ELEVATOR_FLAG']=='N') ? "checked data-ischeked='checked'":""?>>
                                    <label for="ev02">없음</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="inpbox rdinp">
                            <label for="opt_info" class="lbl">옵션정보(복수선택가능)</label>
                            <div class="check_box02">
                                <?php foreach( $goods_option as $row) { ?>
                                    <div class="chk01"><!--  f_chk -->
                                        <input type="checkbox" class="opt<?php echo $row['CODE_DETAIL']?>" id="chkopt<?php echo $row['CODE_DETAIL']?>" name="OPTIONS[]" value="<?php echo $row['CODE_DETAIL']?>" <?php echo (in_array($row['CODE_DETAIL'], $goods_option_selected)) ? 'checked':''?>>
                                        <label for="chkopt<?php echo $row['CODE_DETAIL']?>"><?php echo $row['CODE_NAME']?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="inpbox">
                            <label for="itm_char" class="lbl">물건특징(복수선택가능)</label>
                            <div class="selec_option">
                                <div class="check_box">
                                    <?php
                                    $feature_etc = false;
                                    $s=1;
                                    foreach( $ARR_GOODS_FEATURES as $row )
                                    {
                                        if( $row['CODE_DETAIL'] == 'ETC' && in_array($row['CODE_DETAIL'], $goods_feature_selected) ) $feature_etc = true;
                                    ?>
                                    <div class="check">
                                        <label for="itm_char0<?php echo $s; ?>">
                                            <input type="checkbox" id="itm_char0<?php echo $s; ?>" name="GOODS_FEATURE[]" value="<?php echo $row['CODE_DETAIL']?>" <?php echo ($row['CODE_DETAIL'] == 'ETC') ? "onClick='changeEtcArea(this)'" : ""; ?> <?php echo (in_array($row['CODE_DETAIL'], $goods_feature_selected)) ? 'checked' : ''; ?>>
                                            <i></i> <strong><?php echo $row['CODE_NAME']?></strong>
                                        </label>
                                    </div>
                                    <?php $s++; } ?>

                                    <textarea class="txtarea" id="GOODS_FEATURE_ETC" name="GOODS_FEATURE_ETC" placeholder="기타 선택 시 입력하세요." <?php echo (!$feature_etc) ? "readonly" :""?> ><?php echo ($feature_etc) ? $step2['GOODS_FEATURE_ETC'] :"" ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="inpbox">
                        <label for="host_commt" class="lbl">집주인 한마디</label>
                        <textarea class="txtarea" name="OWNER_COMMENT" onkeydown="" placeholder="빠른 거래를 위해 장점 위주로 간략하게 설명해주세요. &#13;&#10;ex) 1년전 인테리어 공사로 깨끗하고 고층이라 조망권이 좋습니다. 단지내 어린이집이 있어 아이 키우기 너무 좋아요 등"><?php echo (isset($step2['OWNER_COMMENT'])) ? $step2['OWNER_COMMENT']:"" ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn double">
                <button type="button" class="btn_type03" onclick="goPage('/sellhome/step1/<?php echo $CATEGORY; ?>')">이전</button>
                <button type="button" class="btn_type02" onclick="saveStep2()">다음</button>
            </div>
        </div>
    </form>
    </section>
</div>

<script type="text/javascript">
var category = "<?php echo $CATEGORY; ?>";

//변경사항 저장여부 체크
var datachanged = false;

function changeEtcArea(chk) {
	if( $(chk).is(":checked") ) $("#GOODS_FEATURE_ETC").attr('readonly', false);
	else  $("#GOODS_FEATURE_ETC").attr('readonly', true);
}

function saveStep2()
{
	var param = $("#step2form").serialize() + "&CATEGORY=" + category + "&step=step_2&";
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/sellhome/saveStep2/", 
    	data: param, 
    	success: function(data) {
    		if(data.code == 200) {
    			datachanged = false;	// 경고창 제거
        		location.href = "/sellhome/step3/" + category;
      		}
      		else {
        		swal(data.msg);
      		} 
    	}, 
    	error:function(data){ 
     		swal('AJAX ERROR1');
    	}
   	});
}

$("document").ready( function(){
	// 경고창 활성 (아무작업을 안했을 경우 띄움
    /*$(window).on("beforeunload", function(){
    	console.log (datachanged);
      	if(datachanged == true) return false;
    });*/
    
    $("input[type=radio]").on("click", function(){
    	if($(this).data('ischeked') == 'checked') {
      		$(this).attr("checked", false);
      		$(this).data('ischeked','')
    	}
    	else {
      		$(this).data('ischeked','checked');
    	}
    });
    
    $("input[name=ENTER_TYPE]").on("click", function(){
    	if( $("input[name=ENTER_TYPE]:checked").val() == "3" ) {
      		$("#today").parent().show();
      		$('#today').trigger('click');
    	}
    	else {
      		$("#today").val('')
      		$("#today").parent().hide();
    	}
    });

    
 	// 선택시 경고창 활성
	$("#signforms").on("change keyup paste", function(){
		datachanged = true;
	});
});
</script>