                    <!-- 아파트 & 오피스텔 주소 검색 (S) -->
                    <div class="inpbox sch_inpbox">
                      	<div class="sch_area">
                        	<label for="itm_addr" class="lbl"><span id="addrTitle">아파트</span></label>
                            <select name="SIDO_CODE" id="SIDO_CODE" title="시/도선택" class="selec" onchange="gugunListPrint(this.value)">
                                <option value="">시/도선택</option>
                            </select>
                            
                            <div class="flt">
                                <select name="SIGUNGU_CODE" id="SIGUNGU_CODE" title="시/도/구선택" class="selec" onchange="dongListPrint(this.value)">
                                    <option value="">구/군선택</option>
                                </select>
                                <select name="DONG_CODE" id="DONG_CODE" title="읍/면/동선택" class="selec" onchange="dangiListPrint(this.value)">
                                    <option value="">읍/면/동선택</option>
                                </select>
                            </div>
                            
                            <select name="COMPLEX_IDX" id="COMPLEX_IDX" title="단지선택" class="selec" onchange="dangiDongListPrint(this.value); hoSelAreaAutoSel(this);">
                                <option value="">단지선택</option>
                            </select>
                                                    	
                          	<!-- 동 정보 -->
                            <div class="inptxt">
                                <select name="DONG" id="DONG_PREV" title="동선택" class="selec" style="display:;" onchange="floorListPrint(this);">
                                    <option value="">동선택</option>
                                </select>
                                
                                <div class="inptxt" id="DONG_NEW_INPUT_FORM" style="display:none;">
                                	<input type="number" align="right" name="DONG" id="DONG_NEW" value="" placeholder="동 입력" title="동 입력" class="inp" autocomplete="off">
                                	<span class="unit">동</span>
                               	</div>
                          	</div>
                          	
                            <!-- 층 정보 -->
                            <div class="inptxt" id="FLOOR_FORM1"><!-- select box -->
                             	<select name="FLOOR" id="FLOOR_PREV" title="층선택" class="selec" onchange="floorDongListPrint(this.value);;">
                                    <option value="">층선택</option>
                                </select>
                                <input type="hidden" name="TOTAL_FLOOR" id="TOTAL_FLOOR_PREV">
                            </div>                            
                            <div class="flt" id="FLOOR_FORM2" style="display:none;"><!-- input box -->
                             	<div class="inptxt">
                               		<input type="number" name="TOTAL_FLOOR" id="TOTAL_FLOOR_NEW" placeholder="총층" title="총층" class="inp" autocomplete="off">
                               		<span class="unit">층</span>
                             	</div>
                             	<div class="inptxt">
                               		<input type="number" name="FLOOR" id="FLOOR_NEW" placeholder="해당층" title="해당층" class="inp" autocomplete="off">
                               		<span class="unit">해당층</span>
                             	</div>
                            </div>
                            
                            <!-- 호수 입력 -->
                            <div class="inptxt">
                                <select name="HO" id="HO_PREV" title="호선택" class="selec" onchange="hoSelAreaAutoSel(this)">
                                    <option value="">호선택</option>
                                </select>
                                
                                <input type="number" name="HO" id="HO_NEW" placeholder="호수입력(비노출)" title="호수입력(비노출)" style="display:none;" class="inp" autocomplete="off">
                                <span class="unit" id="HO_NEW_UNIT" style="display:none;">호</span>
                          	</div>
                          	
                          	<div class="btn">
                              	<button type="button" class="btn_line04" onclick="selectOfficeMapview()">위치확인하기</button>
                          	</div>
                    	</div>
                  	</div>
                  	
                  	<div class="inpbox sch_inpbox">
                        <div class="sch_area">
                        	<label for="sizeinfo" class="lbl">면적정보</label>
                            <select name="AREA1" id="AREA1" title="공급면적" class="selec" onchange="aptOftArea2Print(this)">
                                <option value="">면적정보선택</option>
                            </select>
                      	</div>
                    </div>
                    
                    <input type="hidden" name="AREA2" id="AREA2">
                    <input type="hidden" name="dongNm" id="dongNm">
                    <input type="hidden" name="AREA_SELECTED" id="AREA_SELECTED">
                    
                    <input type="hidden" name="LAT" id="addr_LAT">
					<input type="hidden" name="LNG" id="addr_LNG">
                  	<!-- 아파트 & 오피스텔 주소검색 (E) -->