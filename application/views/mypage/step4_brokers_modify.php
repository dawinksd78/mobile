<div id="dawinWrap" class="subloc">
    <header id="header" class="header">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">인근 중개사무소 보기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container subloc">
            <div class="cont_wrap">
            	<!-- 지도 표시 -->
                <div class="bg_map" id="pop_realtor_area"></div> 
              
                <!-- 상단 중개사무소 위치포인터 클릭했을 떄 view -->
              	<div class="agent_lst mbot_area" id="agent_lst" style="display:none;"></div>
            </div>
            
            <!-- div class="btn_area bot_btn">
                <button class="btn_type05" type="button" onclick="brokerofficelist()">인근중개사무소목록 <span class="count">0</span></button>
            </div -->            
            <!-- 190411 맵클릭후 하단 네임카드 선택완료 후 나오는 버튼 -->
            <div class="btn_area bot_btn double">
                <button class="btn_type05" type="button" onclick="brokerofficelist()">인근중개사무소 <span class="count">0</span></button>
                <button class="btn_type02 btn_type09" type="button" onclick="brokerSelect()">선택완료</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
var datachanged = false;
var isSaved = false;
var category = "<?php echo $CATEGORY; ?>";

var realtor_template, realtorMap, selli_template, ec_map2;
var realtordata = <?php echo json_encode($realtor, true); ?>;
var realtorcnt = <?php echo json_encode($realtorcount, true); ?>;
var lat ="<?php echo $lat; ?>";
var lng ="<?php echo $lng; ?>";
var searchitems = Object.keys(realtorcnt).length;

var goods_idx = "<?php echo $step4['GOODS_IDX']; ?>";

var selectOfficeNumbers = [<?php echo $selbrokers; ?>];	// 선택된 중개 사무소

var getSamrt = "<?php echo $getDevideCookie; ?>";
var getDevice = "<?php echo $DEVICE; ?>";

// 검색된 사무소 개수
$('.count').html(searchitems);

function check_realtor_id(ln) {
	$(ln).closest("div.itm_inner").children('.check_box').children('div.check').children('label').children('input').trigger("click")
}

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
           	content: ec_overlay_template_position(d),  // 마커생성
           	xAnchor: 0.3,
           	yAnchor: 0.91
     	});
     	customOverlay.setMap(map);
    });
    
    return map;
}

//-----

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
function changeclass1(officeidx) {
   	$('#iconview'+officeidx).addClass('ico_position_selc');
}

function ec_overlay_template(d) {
	var content = '<div class="loc_pointer off" data-officeidx="'+d.BROKER_OFFICE_IDX+'" style="position: absolute;top: -33px;left: -12px;" onClick="ec_overlay_info(\'' + d.BROKER_OFFICE_IDX + '\', \'' + d.MBR_IMAGE_FULL_PATH + '\', \'' + d.OFFICE_TITLE + '\', \'' + d.MBR_NAME + '\', \'' + d.PHONE + '\', \'' + d.BROKER_POINT + '\', \'' + d.BROKER_POINT_CNT + '\')" onmouseenter="ec_overlay_info(\'' + d.BROKER_OFFICE_IDX + '\', \'' + d.MBR_IMAGE_FULL_PATH + '\', \''+ d.OFFICE_TITLE + '\', \'' + d.MBR_NAME + '\', \'' + d.PHONE + '\', \'' + d.BROKER_POINT + '\', \'' + d.BROKER_POINT_CNT + '\')"> <span class="ico_position" id="iconview'+d.BROKER_OFFICE_IDX+'"></span>';
	return content;
}

function ec_overlay_info(officeidx, imgpath, officetitle, username, phone, point, pointcnt)
{
	if(imgpath == null || imgpath == '') {
		imgpath = '/images/btn_camera.png';
	}

	var avgpercent = point / 5 * 100;

	var picturePrint  = '<div class="itm_inner"><div class="thumbnail_area"><div class="thumbnail"><img src="' + imgpath + '" alt="중개사사진" /></div></div>';
		picturePrint += '<a class="agent_info" href="javascript:void(0);"><div class="broker_info"><p class="commtype">' + officetitle + '</p><p class="bk_name">' + username + '</p>';
		picturePrint += '<div class="star_score"> <span class="st_off"><span class="st_on" style="width:' + avgpercent + '%">' + point + '</span></span> </div>';
		picturePrint += '<span class="p_num">' + phone + '</span></div></a>';
		if(selectOfficeNumbers.includes(officeidx) == true) {
			picturePrint += '<div class="check_box chkbox02"><div class="check"><label for="chkag0' + officeidx + '"><input type="checkbox" name="brk_check" id="chkag0' + officeidx + '" value="' + officeidx + '" onclick="changeclass(' + officeidx + ');" checked><i></i></label></div></div></div>';
		}
		else {
			picturePrint += '<div class="check_box chkbox02"><div class="check"><label for="chkag0' + officeidx + '"><input type="checkbox" name="brk_check" id="chkag0' + officeidx + '" value="' + officeidx + '" onclick="changeclass(' + officeidx + ');"><i></i></label></div></div></div>';
		}

	$('#agent_lst').css('display','block');
	$('#agent_lst').html(picturePrint);
}

//-----

function changeclassposition(officeidx, cnt, lat, lng)
{
	var setPosition = lat.replace(".", "") + lng.replace(".", "");
	
	if(selectOfficeNumbers.includes(officeidx) == false)
	{
    	selectOfficeNumbers.push(officeidx);
    	
    	if($('#setPositionVal_'+setPosition).val() == '') {
    		$('#setPositionVal_'+setPosition).val(officeidx);
    	}
    	else {
        	var dataidxs = $('#setPositionVal_'+setPosition).val() + ',' + officeidx; 
    		$('#setPositionVal_'+setPosition).val(dataidxs);
    	}
	}
	else
	{
		var index = selectOfficeNumbers.indexOf(officeidx);
		if(index !== -1) selectOfficeNumbers.splice(index, 1);

		if($('#setPositionVal_'+setPosition).val() != '') {
    		var splitdata = $('#setPositionVal_'+setPosition).val().split(',');
    		var setdatas = '';
    		for( var i in splitdata )
        	{
            	if(i == 0) {
					if(officeidx != splitdata[i]) setdatas += splitdata[i];
            	}
            	else {
            		if(officeidx != splitdata[i]) setdatas += ','+splitdata[i];
            	}
			}
    		$('#setPositionVal_'+setPosition).val(setdatas);
    	}
		else {
			$('#setPositionVal_'+setPosition).val('');
		}
	}

	if(cnt < 2) closebrokerlist();

	if($('#setPositionVal_'+setPosition).val() == '') {
		//$('#iconview_'+setPosition).toggleClass('ico_position_selc');
		$('#iconview_'+setPosition).removeClass('ico_position_selc');
	}
	else {
		$('#iconview_'+setPosition).addClass('ico_position_selc');
	}
}
function changeclassposition2(setPosition) {
   	$('#iconview_'+setPosition).addClass('ico_position_selc');
}
function closebrokerlist() {
	$('#agent_lst').css('display','none');
    $('#agent_lst').html('');
}

function ec_overlay_template_position(d) {
	var setPosition = d.LAT.replace(".", "") + d.LNG.replace(".", "");
	var content = '<div class="loc_pointer off" data-officeidx="'+setPosition+'" style="position:absolute; top:-33px; left:-12px;" onClick="ec_overlay_info_delayPop(\'' + d.LAT + '\', \'' + d.LNG + '\')" onmouseenter="ec_overlay_info_delayPop(\'' + d.LAT + '\', \'' + d.LNG + '\')"> <span class="ico_position" id="iconview_'+setPosition+'"></span><input type="hidden" namd="setPositionVal_'+setPosition+'" id="setPositionVal_'+setPosition+'">';
	return content;
}
function ec_overlay_info_delayPop(lat, lng)
{
	setTimeout( function() {
		ec_overlay_info_position(lat, lng);
	}, 250);
}
function ec_overlay_info_position(lat, lng)
{
	// 리스트 가져오기
	$.ajax({
    	type: "POST",
    	dataType: "json",
    	async: false,
    	url: "/sellhome/step4_brokersameposition",
    	data: "&lat=" + lat + "&lng=" + lng,
    	success: function(data) {
    		var picturePrint = '';
    		var avgpercent = 0;
    		var checked = '';
    		picturePrint += '<a href="javascript:void(0)" class="del02" onclick="closebrokerlist()">삭제</a>';
    		for(var i = 0, len = data.length; i < len; ++i)
        	{
        		if(data[i].imgpath == null || data[i].imgpath == '') {
        			data[i].imgpath = '/images/btn_camera.png';
        		}
    
        		avgpercent = data[i].point / 5 * 100;
    
        		picturePrint  += '<div class="itm_inner">';
    			picturePrint  += '<div class="thumbnail_area">';
    			picturePrint  += '<div class="thumbnail"><img src="' + data[i].imgpath + '" alt="중개사사진" /></div>';
    			picturePrint  += '</div>';
    			
    			if(getSamrt == '1' && getDevice == 'AND') {
        			picturePrint += '<a class="agent_info" href="javascript:void(0);" onclick="dawin_newpop(\'/sellhome/step4_agentinfo/' + data[i].officeidx + '\')">';
        		}
        		else {
        			picturePrint += '<a class="agent_info" href="javascript:void(0);" onclick="goPagePop(\'/sellhome/step4_agentinfo/' + data[i].officeidx + '\')">';
        		}
    			
    			picturePrint  += '<div class="broker_info">';
    			picturePrint  += '<p class="commtype">' + data[i].officetitle + '</p>';
    			picturePrint  += '<p class="bk_name">' + data[i].username + '</p>';
    			picturePrint  += '<div class="star_score"> <span class="st_off"><span class="st_on" style="width:' + avgpercent + '%">' + data[i].point + '</span></span> </div>';
    			picturePrint  += '<span class="p_num">' + data[i].phone + '</span> </div>';
    			picturePrint  += '</a>';

    			checked = '';
    			for(var n=0; n<selectOfficeNumbers.length; n++) {
    			    if(selectOfficeNumbers[n] == data[i].officeidx) checked = 'checked';
    			}
    			picturePrint  += '<div class="check_box chkbox02">';
    			picturePrint  += '<div class="check">';
    			picturePrint  += '<label for="chkag0' + data[i].officeidx + '">';
    			picturePrint  += '<input type="checkbox" name="brk_check" id="chkag0' + data[i].officeidx + '" value="' + data[i].officeidx + '" onclick="changeclassposition('+data[i].officeidx+', '+len+', \''+lat+'\', \''+lng+'\');" ' + checked + '>';
    			picturePrint  += '<i></i>';
    			picturePrint  += '</label>';
    			picturePrint  += '</div>';
    			picturePrint  += '</div>';
    			picturePrint  += '</div>';

    			if(i == 0) $('#agent_lst').css('height','125px'); 
    			if(i == 1) $('#agent_lst').css('height','250px');
    			if(i > 1) $('#agent_lst').css('height','360px');
    			if(i > 2) $('#agent_lst').css('overflow-y','scroll');
    			else $('#agent_lst').css('overflow-y','hidden');
        	}

    		$('#agent_lst').css('display','block');
    		$('#agent_lst').html(picturePrint);
    	},
    	error:function(data){
     		swal('comment write ajax error');
    	}
   	});
}

//-----

//중개사선택완료
function brokerSelect()
{
	var selectOfficeNumbers1 = JSON.stringify(selectOfficeNumbers); 
	var selectOfficeNumbers2 = encodeURIComponent(selectOfficeNumbers1);
	var param = "&brk_check=" + selectOfficeNumbers2;
	$.ajax({
        url:"/mypage/step4_brokercookie/j",
        type:"post",
        data: param,
        dataType: "json",
        success: function(result){
          	if(result.code == 'SUCCESS') {
            	location.href = "/mypage/step4_modify/" + goods_idx;
          	}
          	else {
          		swal("오류가 발생하였습니다.다시 시도해주세요.");
          	}
       	}
    });
}

function brokerofficelist() {
	location.href = "/mypage/step4_brokers_modify_list/" + goods_idx + "/?selbroker=" + selectOfficeNumbers;
}

$("document").ready( function() {
	// 지도 출력
    estatecompany_map();

    <?php if($selbrokers != '') { ?>
    //var selbrk = "<?php echo $selbrokers; ?>";
    //var selbrkspl = selbrk.split(',');
    //for(var i in selbrkspl) {
    	//changeclass1(selbrkspl[i]);
    //}
    var selbrk = "<?php echo $selbrokers; ?>";
    var selbrkspl = selbrk.split(',');
    for(var i in selbrkspl)
    {
    	// 리스트 가져오기
    	$.ajax({
        	type: "POST",
        	dataType: "json",
        	async: false,
        	url: "/sellhome/step4_brokerinfo",
        	data: "&brk_idx=" + selbrkspl[i],
        	success: function(data) {
            	var lat = data.LAT;
            	var lng = data.LNG;
            	var setPositions = lat.replace(".", "") + lng.replace(".", ""); 
            	changeclassposition2(setPositions);
        	},
        	error:function(data){
         		swal('comment write ajax error');
        	}
       	});
    }
    <?php } ?>
});
</script>