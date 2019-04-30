<div id="dawinWrap">
    <header id="header">
    	<span class="btn_close03">
        	<button type="button"><span>닫기</span></button>
        </span>
        <span class="btn_text btn_reset">
        	<button type="button" onclick="pageReset()"><span>초기화</span></button>
        </span>
    </header>
    
    <div id="container">
    <form name="filterform" id="filterform" onsubmit="return false">
        <div class="sub_container">
            <div class="cont_wrap public_cont filter_cont">
                <div class="cont">
                
                    <div class="inpbox rdinp">
                        <label for="m_date" class="lbl">매물종류</label>
                        <div class="radio_box02">
                            <div class="rd01 rd02">
                                <input type="radio" id="type_rd01" name="saletype" value="APT" onchange="saleTypeSel(this.value)">
                                <label for="type_rd01">아파트</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="type_rd02" name="saletype" value="OFT" onchange="saleTypeSel(this.value)">
                                <label for="type_rd02">오피스텔</label>
                            </div>
                            <div class="rd01 rd02">
                                <input type="radio" id="type_rd03" name="saletype" value="ONE" onchange="saleTypeSel(this.value)">
                                <label for="type_rd03">원룸/투룸</label>
                            </div>
                        </div>                     
                    </div>
                    
                    <div class="inpbox rdinp">
                        <label for="opt_info" class="lbl">거래유형</label>
                        <div class="check_box02">
                            <!-- 아파트 / 오피스텔 (S) -->
                            <div class="chk01">
                                <input type="checkbox" id="tr_chk01" name="transtype" value="sale">
                                <label for="tr_chk01">매매</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="tr_chk02" name="transtype" value="previous_2">
                                <label for="tr_chk02">전세</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="tr_chk03" name="transtype" value="previous_3">
                                <label for="tr_chk03">월세</label>
                            </div>
                            <!-- 아파트 / 오피스텔 (E) -->
                        
                        	<!-- 원룸 (S) -->
                            <div class="chk01 f_chk" style="display:none;">
                                <input type="checkbox" id="tr_chk04" name="transtype" value="previous">
                                <label for="tr_chk04">전/월세</label>
                            </div>
                            <!-- 원룸 (E) -->                       
                        </div>
                    </div>
                    
                    <div class="inpbox rdinp">
                        <label for="opt_info" class="lbl">면적</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="ar_chk01" name="area[]" value="all">
                                <label for="ar_chk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="ar_chk02" name="area[]" value="0-66">
                                <label for="ar_chk02">66m²미만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="ar_chk03" name="area[]" value="66-99">
                                <label for="ar_chk03">66-99m²</label>
                            </div>
                            <div class="chk01 f_chk">
                                <input type="checkbox" id="ar_chk04" name="area[]" value="99-132">
                                <label for="ar_chk04">99-132m²</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="ar_chk05" name="area[]" value="132-165">
                                <label for="ar_chk05">132-165m²</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="ar_chk06" name="area[]" value="165-">
                                <label for="ar_chk06">165m²이상</label>
                            </div>
                        </div>
                    </div>
                    
                <!-- 아파트 (S) -->
                    <!-- 매매일때 -->
                    <div class="inpbox rdinp" id="apt_search_filter">
                        <label for="opt_info" class="lbl">매매금액</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="pchk01" name="saleprice[]" value="all">
                                <label for="pchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk02" name="saleprice[]" value="0-10000">
                                <label for="pchk02">1억이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk03" name="saleprice[]" value="10000-30000">
                                <label for="pchk03">1억-3억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk04" name="saleprice[]" value="30000-50000">
                                <label for="pchk04">3억-5억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk05" name="saleprice[]" value="50000-70000">
                                <label for="pchk05">5억-7억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk06" name="saleprice[]" value="70000-">
                                <label for="pchk06">7억이상</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 월세일때 추가-->
                    <div class="inpbox rdinp">
                        <label for="opt_info" class="lbl">월세</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="rpchk01" name="monthly[]" class="opt01" value="all">
                                <label for="rpchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk02" name="monthly[]" class="opt01" value="0-50">
                                <label for="rpchk02">50만이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk03" name="monthly[]" class="opt01" value="50-60">
                                <label for="rpchk03">60만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk04" name="monthly[]" class="opt01" value="60-70">
                                <label for="rpchk04">70만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk05" name="monthly[]" class="opt01" value="70-80">
                                <label for="rpchk05">80만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk06" name="monthly[]" class="opt01" value="80-90">
                                <label for="rpchk06">90만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk07" name="monthly[]" class="opt01" value="100-">
                                <label for="rpchk07">100만이상</label>
                            </div>
                        </div>
                <!-- 아파트 (E) -->
                
                <!-- 오피스텔 (S) -->
                	<div class="inpbox rdinp" id="oft_search_filter1" style="display:none;">
                        <label for="opt_info" class="lbl">방구조</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="rst01" name="ROOM_TYPE[]" value="all">
                                <label for="rst01">전체</label>
                            </div>
                            <?php foreach($ROOM_TYPE as $idx=>$row) {?>
                            <div class="chk01">
                                <input type="checkbox" id="rst0<?php echo sprintf("%2d", $idx+2); ?>" name="ROOM_TYPE[]" value="<?php echo $row['CODE_DETAIL']; ?>">
                                <label for="rst0<?php echo sprintf("%2d", $idx+2); ?>"><?php echo $row['CODE_NAME']; ?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- 매매일때 -->
                    <div class="inpbox rdinp" id="oft_search_filter2" style="display:none;">
                        <label for="opt_info" class="lbl">월세(보증금)</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="pchk01" name="monthly_deposit[]" value="all">
                                <label for="pchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk02" name="monthly_deposit[]" value="0-3000">
                                <label for="pchk02">3천이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk03" name="monthly_deposit[]" value="3000-5000">
                                <label for="pchk03">3천-5천</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk04" name="monthly_deposit[]" value="5000-10000">
                                <label for="pchk04">5천-1억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk05" name="monthly_deposit[]" value="10000-15000">
                                <label for="pchk05">1억-1억5천</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk06" name="monthly_deposit[]" value="15000-20000">
                                <label for="pchk06">1억5천-2억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk07" name="monthly_deposit[]" value="20000-">
                                <label for="pchk07">2억이상</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 월세일때 추가-->
                    <div class="inpbox rdinp">
                        <label for="opt_info" class="lbl">월세</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="rpchk01" name="monthly[]" class="opt01" value="all">
                                <label for="rpchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk02" name="monthly[]" class="opt01" value="0-50">
                                <label for="rpchk02">50만이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk03" name="monthly[]" class="opt01" value="50-60">
                                <label for="rpchk03">60만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk04" name="monthly[]" class="opt01" value="60-70">
                                <label for="rpchk04">70만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk05" name="monthly[]" class="opt01" value="70-80">
                                <label for="rpchk05">80만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk06" name="monthly[]" class="opt01" value="80-90">
                                <label for="rpchk06">90만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk07" name="monthly[]" class="opt01" value="100-">
                                <label for="rpchk07">100만이상</label>
                            </div>
                        </div>
                <!-- 오피스텔 (E) -->
                
                <!-- 원룸 (S) -->
                	<div class="inpbox rdinp" id="one_search_filter1" style="display:none;">
                        <label for="opt_info" class="lbl">방구조</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="str_chk01" name="ROOM_TYPE[]" value="">
                                <label for="str_chk01">전체</label>
                            </div>
                            <?php foreach($ROOM_TYPE as $idx=>$row) {?>
                            <div class="chk01">
                                <input type="checkbox" id="str_chk0<?php echo sprintf("%2d", $idx+2); ?>" name="ROOM_TYPE[]" value="<?php echo $row['CODE_DETAIL']; ?>">
                                <label for="str_chk02<?php echo sprintf("%2d", $idx+2); ?>"><?php echo $row['CODE_NAME']; ?></label>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <!-- 전세일때 -->
                    <div class="inpbox rdinp" id="one_search_filter2" style="display:none;">
                        <label for="opt_info" class="lbl">전세(보증금)</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="pchk01" name="pchk" value="">
                                <label for="pchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk02" name="pchk" value="">
                                <label for="pchk02">1억이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk03" name="pchk" value="">
                                <label for="pchk03">1억-3억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk04" name="pchk" value="">
                                <label for="pchk04">3억-5억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk05" name="pchk" value="">
                                <label for="pchk05">5억-7억</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="pchk06" name="pchk" value="">
                                <label for="pchk06">7억이상</label>
                            </div>
                        </div>
                    </div>
                                       
                    <!-- 월세일때 추가-->
                    <div class="inpbox rdinp">
                        <label for="opt_info" class="lbl">월세</label>
                        <div class="check_box02">
                            <div class="chk01">
                                <input type="checkbox" id="rpchk01" name="rpchk" class="opt01" value="">
                                <label for="rpchk01">전체</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk02" name="rpchk" class="opt01" value="">
                                <label for="rpchk02">50만이하</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk03" name="rpchk" class="opt01" value="">
                                <label for="rpchk03">60만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk04" name="rpchk" class="opt01" value="">
                                <label for="rpchk04">70만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk05" name="rpchk" class="opt01" value="">
                                <label for="rpchk05">80만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk06" name="rpchk" class="opt01" value="">
                                <label for="rpchk06">90만</label>
                            </div>
                            <div class="chk01">
                                <input type="checkbox" id="rpchk07" name="rpchk" class="opt01" value="">
                                <label for="rpchk07">100만이상</label>
                            </div>
                        </div>
                    </div>
                <!-- 원룸 (E) -->
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02">적용하기</button>
            </div>
        </div>
    </form>
    </div>
</div>

<script type="text/javascript">
// 초기화
function pageReset() {
	document.filterform.reset();
}

// 매물종류 선택
function saleTypeSel(val)
{
	if(val == 'APT')
	{
		$('#apt_search_filter').show();
		$('#oft_search_filter1').hide();
		$('#oft_search_filter2').hide();
		$('#one_search_filter1').hide();
		$('#one_search_filter2').hide();
	}
	else if(val == 'OFT')
	{
		$('#apt_search_filter').hide();
		$('#oft_search_filter1').show();
		$('#oft_search_filter2').show();
		$('#one_search_filter1').hide();
		$('#one_search_filter2').hide();
	}
	else if(val == 'ONE')
	{
		$('#apt_search_filter').hide();
		$('#oft_search_filter1').hide();
		$('#oft_search_filter2').hide();
		$('#one_search_filter1').show();
		$('#one_search_filter2').show();
	}
}
</script>