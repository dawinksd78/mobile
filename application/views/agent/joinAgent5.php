<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<!-- span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span -->
        <h2 class="title">중개사회원가입</h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap join_wrap joinbk">
                <h2 class="subj_tit"><span class="m_tit">회원권구매</span></h2>
                <div class="proc"><a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc prev"></a><a href="javascript:;" class="bul_proc on"></a></div>
                <p class="m_exp">다윈은 서비스의 질을 높이기 위해 유료 정책을 펴고 있습니다. 단, <b class="t_red">초기 6개월간은 프로모션 기간으로써 무료로 사용하실 수 있습니다.</b></p>
                <div class="cont bkmem">
                    <div class="tabcon">
                        <ul class="mem_lst">
                            <li class="mem_item lch_mem memship01"> <span class="name">Standard</span> <span class="exp">모든 매물의 매도(임대)인 연락처 제공<br>
                                매도(임차)인 중개사 선택 시 중개사무소 노출<br>
                                매수(임대)인 중개사 선택 시 중개사무소 노출</span> <span class="price">월<strong>100,000원</strong></span> </li>
                            <li class="mem_item lch_mem memship02"> <span class="name">Business</span> <span class="exp">모든 매물의 매도(임대)인 연락처 제공<br>
                                매도(임차)인 중개사 선택 시 중개사무소 상위 노출<br>
                                매수(임대)인 중개사 선택 시 중개사무소 상위 노출</span> <span class="price">월<strong>300,000원</strong></span> </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button class="btn_type02" type="button" onclick="freeSMSproc()">무료이용하기</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
function freeSMSproc()
{
	goPage('/agent/joinAgentResult');
	/*
	var sendData = "&phone=< ? p h p echo $phone; ? >";
	 
	// 층 리스트 가져오기
	$.ajax({ 
     	type: "POST", 
     	dataType: "text",
     	async: false, 
     	url:"/agent/joinSMSproc", 
     	data: sendData, 
     	success: function(result) {
     		if(result == 'COMPLETE') {     			
     			goPage('/agent/joinAgentResult');
     		}
     		else {
     			swal("오류가 발생하였습니다.");
     		}
     	}, 
     	error:function(data){ 
      		swal('AJAX ERROR');
     	} 
	});
	*/
}
</script>