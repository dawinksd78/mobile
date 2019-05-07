// 2019년 4월 오픈 알림창
function dawinOpenAlert() {
	swal("4월15일 그랜드 오픈 예정");
}

// 페이지 이동 함수
function goPage(page)
{
	if(openState == true && (page != '/agent/joinAgent1' && page != '/member/login')) {
		// 오픈 알림창
		dawinOpenAlert();
		return false;
	}
	else {
		// URL 설정
		location.href = page;
	}
}
function goPagePop(page)
{
	if(openState == true && (page != '/agent/joinAgent1' && page != '/member/login')) {
		// 오픈 알림창
		dawinOpenAlert();
		return false;
	}
	else {
		// URL 설정
		window.open(page);
	}
}
function backmain(page)
{
	swal({
	    text: "작성하신 내용이 저장되지 않을 수 있습니다.\n집내놓기 메인페이지로 이동하시겠습니까?",
	    buttons: [
	        'No',
	        'Yes'
	    ],
	}).then(function(isConfirm) {
		if(isConfirm) {
			location.href = page;
		}
		else {
			return false;
		}
	});
	
	//if(confirm('작성하신 내용이 저장되지 않을 수 있습니다.\n집내놓기 메인페이지로 이동하시겠습니까?')) {
		//location.href = page;
	//}
}

function icontype(type)
{
	var icon;
	
	switch( type)
	{
    	case('street') :	icon = "schico01";	break;
    	case('STATION') :	icon = "schico03";	break;
    	case('APT') : 		icon = "schico02";	break;
    	case('OFT') :  		icon = "schico02";	break;
    	case('ONE') :  		icon = "schico02";	break;
    	case('SCH') :  		icon = "schico02";	break;
    	default:    		icon = "schico02"
	}
	
	return icon;
}

// 햄버거 메뉴
function hamburgerMenuList(type)
{
	var menuList = "";
	if(type != 'common') {
		menuList += '<span class="btn_menu02 '+type+'">';
	} else {
		menuList += '<span class="btn_menu02">';
	}
	menuList += '<button type="button" onclick="rightMenu()"><span class="">메뉴</span></button>';
	menuList += '</span>';
	
	menuList += '<div class="box_submenu" style="display:none;">';
	menuList += '<span class="close_menu">';
	menuList += '<button type="button" onclick="rightMenu()"><span class="">닫기</span></button>';
	menuList += '</span>';
	menuList += '<ul id="submenuList" style="display:none;">';
	menuList += '<li><a href="javascript:void(0);" onclick="goPage(\'/\')" class="">홈으로</a></li>';
	menuList += '<li><a href="javascript:void(0);" onclick="goPage(\'/sellhome/main\')" class="">집내놓기</a></li>';
	menuList += '<li><a href="javascript:void(0);" onclick="goPage(\'/buyhome\')" class="">집구하기</a></li>';
	menuList += '<li><a href="javascript:void(0);" onclick="goPage(\'/mypage/myinfo\')" class="">마이페이지</a></li>';
	menuList += '</ul>';
	menuList += '</div>';
	menuList += '<div class="hamburgerMenuMask" style="display:none;" onmousedown="rightMenu()"></div>';
	document.write(menuList);
}

//-------------------------------------------------------//

// 비밀번호 영문숫자특수문자 체크
function checkpwd(str_val)
{
	regStrpw = /^(?=(.*[a-zA-Z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){0,})(?!.*\s).{8,20}$/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	//regStrpw = /^(?=(.*[a-zA-Z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	//regStr = regStr = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}/; //1개이상 특수문자, 1개이상 숫자, 8자이상 문자
	return regStrpw.test(str_val);
}

// 휴대폰 번호 하이픈'-' 자동입력
function cellphoneInput(str)
{
    str = str.replace(/[^0-9]/g, '');
    var tmp = '';
    if(str.length < 4) {
        return str;
    }
    else if(str.length < 7)
    {
        tmp += str.substr(0, 3);
        tmp += '-';
        tmp += str.substr(3);
        return tmp;
    }
    else if(str.length < 11)
    {
        tmp += str.substr(0, 3);
        tmp += '-';
        tmp += str.substr(3, 3);
        tmp += '-';
        tmp += str.substr(6);
        return tmp;
    }
    else
    {              
        tmp += str.substr(0, 3);
        tmp += '-';
        tmp += str.substr(3, 4);
        tmp += '-';
        tmp += str.substr(7);
        return tmp;
    }
    
    return str;
}

//-------------------------------------------------------//

// 전화번호 및 휴대전화 자동 하이픈 입력
function OnCheckPhone(oTa)
{ 
    var oForm = oTa.form ; 
    var sMsg = oTa.value ; 
    var onlynum = "" ; 
    var imsi = 0; 
    onlynum = RemoveDash2(sMsg);  //하이픈 입력시 자동으로 삭제함 
    onlynum =  checkDigit(onlynum);  // 숫자만 입력받게 함 
    var retValue = ""; 

    if(event.keyCode != 12 )
    { 
    	// 서울전화번호일 경우  10자리까지만 나타나교 그 이상의 자리수는 자동삭제
    	if(onlynum.substring(0,2) == 02)
        { 
            if (GetMsgLen(onlynum) <= 1) oTa.value = onlynum; 
            if (GetMsgLen(onlynum) == 2) oTa.value = onlynum + "-"; 
            if (GetMsgLen(onlynum) == 4) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,3); 
            if (GetMsgLen(onlynum) == 4) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,4); 
            if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,5); 
            if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,6); 
            if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,5) + "-" + onlynum.substring(5,7); 
            if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,6) + "-" + onlynum.substring(6,8); 
            if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,5) + "-" + onlynum.substring(5,9); 
            if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,6) + "-" + onlynum.substring(6,10); 
            if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,6) + "-" + onlynum.substring(6,10); 
            if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,2) + "-" + onlynum.substring(2,6) + "-" + onlynum.substring(6,10); 
        }
    	
    	// 05로 시작되는 번호 체크
    	if(onlynum.substring(0,2) == 05 )
    	{ 
    		// 050으로 시작되는지 따지기 위한 조건문
    		if(onlynum.substring(2,3) == 0)
    		{ 
                if (GetMsgLen(onlynum) <= 3) oTa.value = onlynum; 
                if (GetMsgLen(onlynum) == 4) oTa.value = onlynum + "-"; 
                if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,5); 
                if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,6); 
                if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,7); 
                if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
                if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,7) + "-" + onlynum.substring(7,9); 
                if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8) + "-" + onlynum.substring(8,10); 
                if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,7) + "-" + onlynum.substring(7,11); 
                if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8) + "-" + onlynum.substring(8,12); 
                if (GetMsgLen(onlynum) == 13) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8) + "-" + onlynum.substring(8,12); 
    		}
    		else
    		{ 
                if (GetMsgLen(onlynum) <= 2) oTa.value = onlynum; 
                if (GetMsgLen(onlynum) == 3) oTa.value = onlynum + "-"; 
                if (GetMsgLen(onlynum) == 4) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,4); 
                if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,5); 
                if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6); 
                if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7); 
                if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6) + "-" + onlynum.substring(6,8); 
                if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,9); 
                if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6) + "-" + onlynum.substring(6,10); 
                if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
                if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
    		} 
        } 

    	// 서울전화번호가 아닌 번호일 경우(070,080포함 // 050번호가 문제군요)
    	if(onlynum.substring(0,2) == 03 || onlynum.substring(0,2) == 04  || onlynum.substring(0,2) == 06  || onlynum.substring(0,2) == 07  || onlynum.substring(0,2) == 08 )
        { 
            if (GetMsgLen(onlynum) <= 2) oTa.value = onlynum; 
            if (GetMsgLen(onlynum) == 3) oTa.value = onlynum + "-"; 
            if (GetMsgLen(onlynum) == 4) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,4); 
            if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,5); 
            if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6); 
            if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7); 
            if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6) + "-" + onlynum.substring(6,8); 
            if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,9); 
            if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6) + "-" + onlynum.substring(6,10); 
            if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
            if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
        }
    	
    	// 휴대폰일 경우
    	if(onlynum.substring(0,2) == 01)
    	{ 
            if (GetMsgLen(onlynum) <= 2) oTa.value = onlynum; 
            if (GetMsgLen(onlynum) == 3) oTa.value = onlynum + "-"; 
            if (GetMsgLen(onlynum) == 4) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,4); 
            if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,5); 
            if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6); 
            if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7); 
            if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,8); 
            if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,9); 
            if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,6) + "-" + onlynum.substring(6,10); 
            if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
            if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,3) + "-" + onlynum.substring(3,7) + "-" + onlynum.substring(7,11); 
        } 

    	// 1588, 1688등의 번호일 경우
    	if(onlynum.substring(0,1) == 1)
    	{ 
            if (GetMsgLen(onlynum) <= 3) oTa.value = onlynum; 
            if (GetMsgLen(onlynum) == 4) oTa.value = onlynum + "-"; 
            if (GetMsgLen(onlynum) == 5) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,5); 
            if (GetMsgLen(onlynum) == 6) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,6); 
            if (GetMsgLen(onlynum) == 7) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,7); 
            if (GetMsgLen(onlynum) == 8) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
            if (GetMsgLen(onlynum) == 9) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
            if (GetMsgLen(onlynum) == 10) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
            if (GetMsgLen(onlynum) == 11) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
            if (GetMsgLen(onlynum) == 12) oTa.value = onlynum.substring(0,4) + "-" + onlynum.substring(4,8); 
        } 
    } 
} 

function RemoveDash2(sNo)
{ 
	var reNo = "";
	for(var i=0; i<sNo.length; i++) { 
	    if ( sNo.charAt(i) != "-" ) { 
	    	reNo += sNo.charAt(i); 
	    } 
	}
	
	return reNo; 
} 

// 0-127 1byte, 128~ 2byte
function GetMsgLen(sMsg)
{ 
	var count = 0;
    for(var i=0; i<sMsg.length; i++)
    { 
        if( sMsg.charCodeAt(i) > 127 ) { 
            count += 2;
        } 
        else { 
            count++;
        } 
    }
    
	return count; 
} 

function checkDigit(num)
{ 
    var Digit = "1234567890"; 
    var string = num; 
    var len = string.length 
    var retVal = ""; 

    for(i=0; i < len; i++) 
    { 
        if(Digit.indexOf(string.substring(i, i+1)) >= 0) { 
            retVal = retVal + string.substring(i, i+1);
        } 
    }
    
    return retVal; 
}

//-------------------------------------------------------//

//매물 위치 확인
function officeposition()
{
	var officename = $('#office_name').val();
	var lat = $('#office_lat').val();
	var lng = $('#office_lng').val();

	if(officename == '' || lat == '' || lng == '') {
		swal('중개사무소를 검색 후 위치확인하시기 바랍니다.');
		return false;
	}

	$('.apiMapMask').css('display', 'block');
	$('.apiMapClose').css('display', 'block');
	$('.apiMap').css('display', 'block');

	var mapContainer = document.getElementById('apiMap'),
		mapOption = {
	  	center: new daum.maps.LatLng(lat, lng), //지도의 중심좌표.
		level: 2 //지도의 레벨(확대, 축소 정도 - 낮을수록 확대)
	};

	var map = new daum.maps.Map(mapContainer, mapOption); //지도 생성 및 객체 리턴

	//---------------------------------------------------------------------//
	
	// 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
	var mapTypeControl = new daum.maps.MapTypeControl();
  
  	// 지도에 컨트롤을 추가해야 지도위에 표시됩니다
  	// daum.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
  	map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);
  
  	// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
  	var zoomControl = new daum.maps.ZoomControl();
  	map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);

	//---------------------------------------------------------------------//
	
	// 마커가 표시될 위치입니다 
	var markerPosition  = new daum.maps.LatLng(lat, lng); 

	// 마커를 생성합니다
	var marker = new daum.maps.Marker({
	    position: markerPosition
	});

	// 마커가 지도 위에 표시되도록 설정합니다
	marker.setMap(map);

	var iwContent = '<div style="padding:5px;">' + officename + '</div>', // 인포윈도우에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다
	    iwPosition = new daum.maps.LatLng(lat, lng); //인포윈도우 표시 위치입니다

	// 인포윈도우를 생성합니다
	var infowindow = new daum.maps.InfoWindow({
	    position : iwPosition, 
	    content : iwContent 
	});
	  
	// 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
	infowindow.open(map, marker);
}

// 중개소 위치 닫기
function mapClose() {
	$('.apiMapMask').css('display', 'none');
	$('.apiMapClose').css('display', 'none');
	$('.apiMap').css('display', 'none');
}

//-------------------------------------------------------//

// 입력한 숫자를 한글로 변환
function priceKRup(inp) {
	var target = $(inp).data("span");
	$(target).text(number2Hangeul(""+$(inp).val()*10000));
}

// 입력한 숫자를 한글로 변환처리
function number2Hangeul( strNumber ) 
{ 
   strNumber = strNumber.replace(new RegExp(",", "g"), ""); 

   var arrayAmt = new Array("일", "이", "삼", "사", "오", "육", "칠", "팔", "구", "십"); 
   var arraypos = new Array("", "십", "백", "천"); 
   var arrayUnit = new Array("", "만", "억", "조", "경", "해", "자", "양", "구", "간", "정", "재", "극", "항하사", "아승기", "나유타", "불가사의", "무량대수"); 

   var pos = strNumber.length%4;                        //자리수 
   var len = (strNumber.length/4).toString(); 

   if(len.indexOf(".") > 0) 
       var unit = len.substring(0, len.indexOf("."));      //단위(0:일단위, 1:만단위...) 
   else 
       var unit = strNumber.length/4-1; 

   var korNumber = ""; 
   var op = 0; 

   for(i=0; i<strNumber.length; i++) 
   { 
       if(pos==0) pos=4; 
       var num = parseInt( strNumber.substring( i, i+1 ) ); 
       if(num != 0) 
       { 
           korNumber += arrayAmt[ num-1 ]; 
           korNumber += arraypos[ pos-1 ]; 
           op=1; 
       } 
       if(pos==1)
       { 
           if(op==1) korNumber += arrayUnit[unit]; 
           unit--; 
           op = 0; 
       } 
       pos--; 
   } 

   if(korNumber.length==0 || korNumber.length==null) 
       return  "-"; 
   else 
       return korNumber; 
}

// 금액표기
function fnMoneyAboutText(float)	//fnMoneyAboutText
{
	var int = Math.floor(float); //소수점 버림

	var strInt = int.toString();
	var strFloat_1 = "";

	if(int > 999999999) {
		strFloat_1 = int.toString().substring(0, 2);
		if(int.toString().substring(2, 3) != '0') strFloat_1 += '.' + int.toString().substring(2, 3);
	}
	else
	{
		var strFirstNumber = int.toString().substring(0, 1);
		strFloat_1 = int.toString().substring(0, 1);
		if(int != 0) {
			if(int.toString().substring(1, 2) != '0') strFloat_1 += '.' + int.toString().substring(1, 2);
		}
	}
	
	var unit = "";
	switch (strInt.length)
	{
		case 3: unit = ""; break;
		case 4: unit = ""; break;
		case 5: unit = ""; break;//만
		case 6: unit = "십"; break;
		case 7: unit = "백"; break;
		case 8: unit = "천"; break;
		case 9: unit = "억"; break;
		case 10: unit = "억"; break;
		case 11: unit = "억"; break;
		case 12: unit = "억"; break;
		case 13: unit = "조"; break;
		default: unit = ""; break;
	}
	
	if(strFloat_1 == 0 || strFloat_1 == '') 
	    return  "-"; 
	else 
	    return strFloat_1 + unit; 
}

// 금액 range 표시
function fnrangeStr(start, end )
{
	var str='';
  	if( (start == null || start <= 0) && (end == null || end <= 0) ) return '-';
  	if ( start == null || start <= 0 ) str += '~';
  	else str += fnMoneyAboutText(start) + '~';
  	if ( end != null && end > 0 ) str += fnMoneyAboutText(end) ;
  	return str;
}

function caldate(year)
{
	//for utc
	var d = new Date();
	var o = new Date(d.getFullYear() - 1*year, (d.getMonth() ), d.getDate());
	return Date.UTC(o.getFullYear(), o.getMonth(),1);
}

//-------------------------------------------------------//

// 즐겨찾기 추가
function complexFavorate(target)
{
	var saleno = $(target).data("saleno");
	var on = $(target).hasClass("on")==true ? "on":"off";
	$.ajax({
		url: '/userapi/favorite',
		type: 'GET',
		data: {saleno:saleno, on:on},
		dataType: 'json',
		success: function(result){
			if(result.code == 200)
			{
				if(on == "on") $(target).removeClass("on");
				else $(target).addClass("on");
			}
			else if(result.msg != '') swal(result.msg);
		},
		error: function(request, status, error) {
			console.log(error);
		},
		/*beforeSend: function() {
			$(target).parent().append('<div class="favo_load_div" style="width:100%;height100%;position:absolute;top:0;left:0;background-color:white;z-index:5002"><img src="/images/heartloader.gif" style="width:100%;height:100%"></img></div>')
		},
		complete: function(){
			$(target).parent().children("div.favo_load_div").remove();
		},*/
	});
}

// 매물 상세 보기
function fnGetGoodsDetail(goodsidx) {
	// 경로이동
	location.href = "/buyhome/saledetail/" + goodsidx;
}

//-------------------------------------------------------//

// 다음 주소 검색 API 관련 JS 함수들
function findAddress()
{
	var element_layer = document.getElementById('daumpostlayer');
	
	new daum.Postcode({
        oncomplete: function(data) {
        	if(typeof data.jibunAddress != "undefined" && data.jibunAddress !='')
            {
            	for(var i = 0; i < availDongLawCode.length; i++)
            	{
            		if(typeof availDongLawCode[i] != "undefined" && data.bcode == availDongLawCode[i].LAW_DONG_CODE)
            		{
            			var geocoder = new daum.maps.services.Geocoder();
            			geocoder.addressSearch(data.jibunAddress, function(result, status){
            				if(status === daum.maps.services.Status.OK)
            				{
            					$("#addr").val(data.jibunAddress);
            					$("#LAWDONG").val(data.bcode);
            					$("#addrDetail").val(data.buildingName);
            					$("#addr_LAT").val(result[0].y);
            					$("#addr_LNG").val(result[0].x);
            				}
            				else {
            					swal("주소 검색을 다시 해주세요");
            				}
            			});
            			break;
            		}
            		else if( i+1 == availDongLawCode.length ) swal("등록 가능지역이 아닙니다.")
            	}
            	
            	$('.daumpostmask').css('display', 'none');
            	$('.daumpostclose').css('display', 'none');
            	$('.daumpostlayer').css('display', 'none');
            }
        },
        width : '100%',
        height : '100%',
        maxSuggestItems : 5
    }).embed(element_layer);
	
	$('.daumpostmask').css('display', 'block');
	$('.daumpostclose').css('display', 'block');
	$('.daumpostlayer').css('display', 'block');
}
    
function closeDaumPostcode() {
    $('.daumpostmask').css('display', 'none');
	$('.daumpostclose').css('display', 'none');
	$('.daumpostlayer').css('display', 'none');
}