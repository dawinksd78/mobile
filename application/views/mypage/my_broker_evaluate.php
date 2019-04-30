<div id="dawinWrap">
    <header id="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span>닫기</span></button>
        </span> 
  	</header>
  
    <section id="container">
    <form id="realtorevalform" onSubmit="return false;">
        <input type="hidden" name="evaltype" value="<?php echo $evaltype?>">
        <input type="hidden" name="broker_idx" value="<?php echo $broker_idx?>">
        <input type="hidden" name="goods_idx" value="<?php echo $goods_idx?>">
        <div class="sub_container">
            <div class="cont_wrap public_cont02 rate">
              	<div class="subjwrap">
                    <h2 class="subj_tit">
                    	<span class="m_tit">중개평가하기</span>
                    	<p class="m_exp">고객님께서 남겨주시는 소중한 후기는 다른고객님들께 유익한 정보가 됩니다.</p>
    	                <div class="star_score">
    	                	<span class="st_off"><span class="st_on" style="width:0%"></span></span>
                        	<output for="star_input"><span class="t_score"><b class="realtorStarPoint">0</b>/5</span></output>
                    	</div>
                    </h2>
              	</div>
              	
                <div class="cont">
                    <div class="rt_wrap">
                        <div class="rt_items">
                        	<span class="p_area">1. 친절하고 신뢰를 드렸나요?</span>
                            <span class="e_area star_input">
                            	<span class="input">
                                    <input type="radio" name="star_input1" value="1" id="p1">
                                    <label for="p1" class="lbl01">1</label>
                                    <input type="radio" name="star_input1" value="2" id="p2">
                                    <label for="p2" class="lbl02">2</label>
                                    <input type="radio" name="star_input1" value="3" id="p3">
                                    <label for="p3" class="lbl03">3</label>
                                    <input type="radio" name="star_input1" value="4" id="p4">
                                    <label for="p4" class="lbl04">4</label>
                                    <input type="radio" name="star_input1" value="5" id="p5">
                                    <label for="p5" class="lbl05">5</label>
                            	</span>
                            	<output for="star_input"><b class="realtorStarPoint">0</b>/5</output>
                            </span>
                        </div>
                        <div class="rt_items">
                        	<span class="p_area">2. 전문적 지식과 경험을 가지고 잘 설명해 주었나요?</span>
                            <span class="e_area star_input">
                            	<span class="input">
                                    <input type="radio" name="star_input2" value="1" id="p6">
                                    <label for="p6" class="lbl01">1</label>
                                    <input type="radio" name="star_input2" value="2" id="p7">
                                    <label for="p7" class="lbl02">2</label>
                                    <input type="radio" name="star_input2" value="3" id="p8">
                                    <label for="p8" class="lbl03">3</label>
                                    <input type="radio" name="star_input2" value="4" id="p9">
                                    <label for="p9" class="lbl04">4</label>
                                    <input type="radio" name="star_input2" value="5" id="p10">
                                    <label for="p10" class="lbl05">5</label>
                                </span>
                                <output for="star_input"><b class="realtorStarPoint">0</b>/5</output>
                            </span>
                        </div>
                        <div class="rt_items">
                        	<span class="p_area">3. 문의하신 내용에 대해 빠른 응대를 드렸나요?</span>
                            <span class="e_area star_input">
                            	<span class="input">
                                    <input type="radio" name="star_input3" value="1" id="p11">
                                    <label for="p11" class="lbl01">1</label>
                                    <input type="radio" name="star_input3" value="2" id="p12">
                                    <label for="p12" class="lbl02">2</label>
                                    <input type="radio" name="star_input3" value="3" id="p13">
                                    <label for="p13" class="lbl03">3</label>
                                    <input type="radio" name="star_input3" value="4" id="p14">
                                    <label for="p14" class="lbl04">4</label>
                                    <input type="radio" name="star_input3" value="5" id="p15">
                                    <label for="p15" class="lbl05">5</label>
                                </span>
                                <output for="star_input"><b class="realtorStarPoint">0</b>/5</output>
                            </span>
                        </div>
                        <div class="rt_items">
                        	<span class="p_area">4. 거래 당사자간 의견을 잘 조율해 주셨나요?</span>
                            <span class="e_area star_input">
                            	<span class="input">
                                    <input type="radio" name="star_input4" value="1" id="p16">
                                    <label for="p16" class="lbl01">1</label>
                                    <input type="radio" name="star_input4" value="2" id="p17">
                                    <label for="p17" class="lbl02">2</label>
                                    <input type="radio" name="star_input4" value="3" id="p18">
                                    <label for="p18" class="lbl03">3</label>
                                    <input type="radio" name="star_input4" value="4" id="p19">
                                    <label for="p19" class="lbl04">4</label>
                                    <input type="radio" name="star_input4" value="5" id="p20">
                                    <label for="p20" class="lbl05">5</label>
                                </span>
                                <output for="star_input"><b class="realtorStarPoint">0</b>/5</output>
                            </span>
                        </div>
                        <div class="rt_items">
                        	<span class="p_area">5. 
                            	<?php if($this->input->get('evaltype'=='sell') ){ ?>
                            		중개수수료를 요구 받으신 적이 있으신가요?
                            	<?php } else { ?>
              						약정된 중개수수료 이외의 다른 금품 등을 요구받으신 적이 있나요?
              					<?php } ?>
                        	</span>
                            <div class="radio_box">
                                <div class="radio">
                                    <label for="paym01">
                                        <input type="radio" name="paym" id="paym01" value="Y">
                                        <i></i><strong>있음</strong>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label for="paym02">
                                        <input type="radio" name="paym" id="paym02" value="N">
                                        <i></i><strong>없음</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="rt_items"> 
                          	<span class="p_area">6. 중개사에게 하고싶은 말이나 평가하는 이유를 작성해주세요.</span>
                          	<textarea name="etc" id="etc" class="txtarea" onkeydown="buttonView()" placeholder="내용을 입력해주세요."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type03" onClick="sendrealtoreval()">중개평가완료</button>
                <!-- 사유 선택 후 경우 on 클래스 추가 --> 
            </div>
        </div>
    </form>
    </section>
    
    <!-- 중개평가완료 시 레이어 팝업 -->
    <div class="mask" style="display:none;"></div>
    <div class="lyr lyrpop01" style="display:none;">
        <div class="lyr_inner">
            <p class="cont"><b>중개평가</b>가 완료되었습니다.<br>감사합니다.</p>
        </div>
        <div class="btn">
            <button type="button" class="btn_type02">확인</button>
        </div>
    </div>
</div>

<script type="text/javascript">
$("document").ready( function(){
	$("#realtorevalform span.input input[type=radio]").on("click", function(){
		$(this).parent().next().children('b.realtorStarPoint').text($(this).val())
		realtorstartchange();
	});

	$("input[type=radio][name=paym]").on("click", function(){
		realtorstartchange();
	});
});

// 평가 별점 처리
function realtorstartchange()
{
    var point = 0;

    if( $("input[type=radio][name=paym]:checked").val() == 'N' ) point = 1;
    
    $("#realtorevalform span.input input[type=radio]:checked").each(function(){
		var star = $(this).val();
		var width = 0;

		if(star != 'N') point += star*0.2;
		
		if(point == 0) width = 0;
		else width = Math.floor(point*10*2);

		$("#realtorevalform .st_on").css("width", width + "%");
		star = ( point == Math.floor(point) ) ? Math.floor(point) : point.toFixed(1);
		$(".t_score").html('<b>'+star+'</b>/5');
    });
}

// 버튼 on
function buttonView()
{	
	if($("#etc").val() != '') {
        $('.btn_type03').addClass('on');
    }
}

// 평가 처리하기
function sendrealtoreval()
{
	// 별점 체크
	if($("input[type=radio][name=star_input1]:checked").val() == '') {
		swal('1번 항목 별점수를 선택해 주세요!');
		return false;
	}
	if($("input[type=radio][name=star_input2]:checked").val() == '') {
		swal('2번 항목 별점수를 선택해 주세요!');
		return false;
	}
	if($("input[type=radio][name=star_input3]:checked").val() == '') {
		swal('3번 항목 별점수를 선택해 주세요!');
		return false;
	}
	if($("input[type=radio][name=star_input4]:checked").val() == '') {
		swal('4번 항목 별점수를 선택해 주세요!');
		return false;
	}
	
	// 수수료 및 금품 요구 체크
	if($("input[type=radio][name=paym]:checked").val() == '') {
		swal('5번 항목을 선택해 주세요!');
		return false;
	}
	
	// 평가 이유 체크
	if($("#etc").val() == '') {
		swal('중개사에게 하고 싶은 말이나 평가하는 이유를 작성해 주세요!');
		return false;
	}
	
    $.ajax({
		url: '/mypage/realtoreval',
		type: 'post',
		data: $("#realtorevalform").serialize(),
		dataType: 'json',
		success: function(result){
			if(result.code == 200)
			{
				swal({
      			  	title: "평가완료!",
      			  	text: "평가를 완료하셨습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				location.href = "/mypage/myhousesale";
      			});
			}
			else if(result.code == 420)
			{
				swal({
      			  	title: "평가완료!",
      			  	text: "이미 평가 완료하셨습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				location.href = "/mypage/myhousesale";
      			});
        	}
      	},
      	error: function(request, status, error) {
        	console.log(error);
      	},
      	beforeSend: function() {
        	$('#ajax_loader').show();
       	},
       	complete: function(){
        	$('#ajax_loader').hide();
       	},
	});
}
</script>