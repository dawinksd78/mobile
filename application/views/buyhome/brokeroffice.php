<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        
        <h2 class="title">중개사무소 위치</h2>
              	
      	<!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap map_wrap">
                <!-- 지도 표시 -->
                <div class="bg_map" id="pop_realtor_area"></div>
                
                <!-- 상단 중개사무소 위치포인터 클릭했을 떄 view -->
              	<div class="agent_lst mbot_area" id="agent_lst" style="display:none;"></div>                
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type05">인근중개사무소목록 <span class="count">0</span></button>
            </div>
        </div>
    </section>
    
    <!-- 매물등록, 삭제요청 클릭시 팝업 -->
    <div class="mask" style="display:none;"></div>
    <div class="lyr lyrpop01" style="display:none;">
    <form name="inquiryform" id="inquiryform" onsubmit="return false">
    	<a href="javascript:void(0);" class="close" onclick="inquiryclose()">닫기</a>
        <div class="lyr_inner">
            <p class="cont">중개사에게 문의하세요.</p>
            <textarea name="contents" id="contents" class="txtarea" placeholder="문의할 내용을 입력하세요."></textarea>
        </div>
        <div class="btn">
            <button type="button" class="btn_type02" onclick="inquiryProc()">문의하기</button>
        </div>
        <input type="hidden" name="officeidx" id="officeidx">
    </form>
    </div>
</div>

<script type="text/javascript">
//문의하기 레이어팝업창
function inquiry(idx)
{
	$('.mask').css('display', 'block');
	$('.lyr').css('display', 'block');
	$('#officeidx').val(idx);
}

// 문의하기 팝업창 닫기
function inquiryclose()
{
	$('.mask').css('display', 'none');
	$('.lyr').css('display', 'none');
}

//문의하기 등록
function inquiryProc()
{
	var param =  $("#inquiryform").serialize();
    $.ajax({
    	url: '/sellhome/step4_inquiry',
    	type: 'POST',
    	contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    	data: param,
    	dataType: 'text',
    	success: function(result){
      		if(result == 'SUCCESS')
          	{
      			swal({
      			  	title: "등록완료!",
      			  	text: "등록이 완료 되었습니다!",
      			  	icon: "success",
      			  	button: "확 인",
      			})
      			.then(function () {
      				inquiryclose();
      			});
      			return false;
      		}
      		else {
        		swal('등록에 실패하였습니다.');
        		inquiryclose();
        		return false;
      		}
    	},
    	error:function(data){
     		swal('AJAX ERROR');
    	}
	});
}
</script>

<script type="text/javascript">
var category = "<?php echo $CATEGORY; ?>";
var realtordata = <?php echo json_encode($realtor['data'], true); ?>;
var lat ="<?php echo $lat; ?>";
var lng ="<?php echo $lng; ?>";
var searchitems = Object.keys(realtordata).length;

var selectOfficeNumbers = [];	// 선택된 중개 사무소

// 검색된 사무소 개수
$('.count').html(searchitems);

function check_realtor_id(ln) {
	$(ln).closest("div.itm_inner").children('.check_box').children('div.check').children('label').children('input').trigger("click")
}

// 건물 위치
function estatecompany_map()
{
    var pos = realtordata;
    var mapContainer = document.getElementById('pop_realtor_area'), // 지도를 표시할 div
    mapOption = {
        center: new daum.maps.LatLng(lat, lng), // 지도의 중심좌표
        level: 7 // 지도의 확대 레벨
    };
    var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
    var ec_marker = new daum.maps.Marker({
       	position: new daum.maps.LatLng(lat, lng),
       	image: new daum.maps.MarkerImage('/images/ico_pointer.png', new daum.maps.Size(37, 50), {offset: new daum.maps.Point(18, 50)} )
    });
    map.setMaxLevel(8);
    ec_marker.setMap(map);
    
    var markers = $(pos).map(function (i, d) {
       	customOverlay = new daum.maps.CustomOverlay({
           	clickable: true,
           	position: new daum.maps.LatLng(d.LAT, d.LNG),
           	zIndex: 10,
           	content: ec_overlay_template(d),  // 마커생성
           	xAnchor: 0.3,
           	yAnchor: 0.91
     	});
     	customOverlay.setMap(map);
    });
    
    return map;
}

function ec_overlay(div)
{
    var isoff = $(div).hasClass("off");
    var office = $(div).data("officeidx")
    $(".loc_pointer").map( function(i,r){
    	$(r).addClass('off');
    })
    
    if(isoff) $(div).removeClass('off');
    var prc = true
    $("#agent_list").scrollTop(0);

    $("#pop_agent_list li.st_li_over").removeClass("st_li_over")
    
    $("#pop_agent_list li").each( function(){
        if( prc && $(this).data('idx') == office )
        {
            prc = false
            var offsettop = $(this).offset().top - 103-$(document).scrollTop();
            console.log($(document).scrollTop())
            $("#agent_list").scrollTop(0).animate({ scrollTop: offsettop }, 500);
            $(this).addClass("st_li_over")
            return;
        }
    })
}

function ec_overlay_info(officeidx, imgpath, officetitle, username)
{
	if(imgpath == null || imgpath == '') {
		imgpath = '/images/btn_camera.png';
	}

	var picturePrint  = '<div class="itm_inner"><div class="thumbnail_area"><div class="thumbnail"><img src="' + imgpath + '" alt="중개사사진" /></div></div>';
		picturePrint += '<a class="agent_info" href="javascript:void(0);"><div class="broker_info"><p class="commtype">' + officetitle + '</p><p class="bk_name">' + username + '</p>';
		picturePrint += '<div class="star_score"> <span class="st_off"><span class="st_on" style="width:85%">4.12</span></span> </div>';
		picturePrint += '<span class="p_num">010-1234-5678</span> </div></a>';
		picturePrint += '<div class="btn_ques"><button type="button" class="" onclick="inquiry(' + officeidx + ')">문의하기</button></div></div>';


	$('#agent_lst').css('display','block');
	$('#agent_lst').html(picturePrint);
}

function changeclass(officeidx)
{
	if(selectOfficeNumbers.includes(officeidx) == false) {
    	$('#iconview'+officeidx).toggleClass('ico_position_selc');
    	selectOfficeNumbers.push(officeidx);
	}
	else {
		$('#iconview'+officeidx).toggleClass('ico_position_selc');

		var index = selectOfficeNumbers.indexOf(officeidx);
		if (index !== -1) selectOfficeNumbers.splice(index, 1);
	}
	
    $('#agent_lst').css('display','none');
    $('#agent_lst').html('');
}

function ec_overlay_template(d) {
	var content = '<div class="loc_pointer off" data-officeidx="'+d.BROKER_OFFICE_IDX+'" style="position: absolute;top: -33px;left: -12px;" onClick="ec_overlay_info(' + d.BROKER_OFFICE_IDX + ', \'' + d.MBR_IMAGE_FULL_PATH + '\', \'' + d.OFFICE_TITLE + '\', \'' + d.MBR_NAME + '\')" onmouseenter="ec_overlay_info(' + d.BROKER_OFFICE_IDX + ', ' + d.MBR_IMAGE_FULL_PATH + ', '+ d.OFFICE_TITLE + ', ' + d.MBR_NAME + ')"> <span class="ico_position" id="iconview'+d.BROKER_OFFICE_IDX+'"></span>';
	return content;
}

$("document").ready( function() {
	// 지도 출력
    estatecompany_map();
});

function brokerofficelist() {
	location.href = "/sellhome/step4_brokers_list/" + category + "/?selbroker=" + selectOfficeNumbers;
}
</script>