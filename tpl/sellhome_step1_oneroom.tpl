					<!-- 원룸 주소검색 (S) -->
					<div class="inpbox sch_inpbox">
                        <label for="itm_name" class="lbl">원룸/투룸</label>
                        <div class="inpbn">
                            <input type="text" id="addr" name="LAW_ADDR1" placeholder="주소검색결과" title="주소검색결과" class="inp" autocomplete="off" onmousedown="findAddressPop()" readonly>
                            <input type="hidden" id="LAWDONG" name="LAW_DONG_CODE">
                            <input type="hidden" id="addr_LAT" name="LAT">
                            <input type="hidden" id="addr_LNG" name="LNG">
                            <span class="dcbtn">
                            	<button class="btn_line02" onClick="findAddressPop()">주소검색 </button>
                            </span>
                        </div>
                        <input type="text" id="addrDetail" name="LAW_ADDR2" placeholder="상세주소입력" title="상세주소입력" class="inp" autocomplete="off">
                        <div class="btn">
                            <button class="btn_line04" onclick="oneroomPosition()">위치확인하기</button>
                        </div>
                        <div class="flt">
                            <div class="inptxt">
                                <input type="number" id="TOTAL_FLOOR" name="TOTAL_FLOOR" placeholder="전체층" title="전체층" class="inp" autocomplete="off">
                                <span class="unit">층</span>
                            </div>
                            <div class="inptxt">
                                <input type="number" id="FLOOR" name="FLOOR" placeholder="해당층" title="해당층" class="inp" autocomplete="off">
                                <span class="unit">층</span>
                            </div>
                        </div>
                        <div class="inptxt">
                            <input type="number" id="HO" name="HO" placeholder="호수입력(비노출)" title="호수입력(비노출)" class="inp" autocomplete="off">
                            <span class="unit">호</span>
                        </div>
                        <p class="add_text">* 호수는 사이트에 공개되지 않습니다.</p>
                    </div>
                    <div class="inpbox sch_inpbox">
                        <label for="sizeinfo" class="lbl">전용면적</label>
                        <div class="inptxt">
                            <input type="number" id="AREA2" name="AREA2" onkeydown="return dotnumber_only(event)" onkeyup="changePyeong(this)" placeholder="전용면적평형입력" title="전용면적평형입력" class="inp" autocomplete="off">
                            <span class="unit">m²</span>
                        </div>
                        <p class="kr" id="pyeongRes">평형</p>
                        <p class="add_text">* 임대계약서 또는 건축물 대장을 확인해주세요.</p>
                    </div>
                    <!-- 원룸 주소검색 (E) -->