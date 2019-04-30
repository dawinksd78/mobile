<div id="dawinWrap" class="">
    <header id="header" class="header maphd"> 
      	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        
        <h2 class="title"><span>위치 및 주변편의시설</span></h2>
              	
      	<!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap map_wrap">
            	<div class="apiMapView" id="apiMapView" style="width:100%;height:100%;"></div>
                <div class="bg_map">
                    <div class="map_vbtn">
                    	<span class="btn_arnd">
                        	<button type="button"><span class="">주변</span></button>
                        </span> 
                        
                        <!-- 주변선택 팝업 -->
                        <div class="arnd_wrap" style="display:none;">
                            <ul class="arnd_lst">
                                <li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SW8" data-aroundcatesub="">지하철역</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="어린이집" data-aroundcatesub="">어린이집</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="유치원" data-aroundcatesub="">유치원</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="초등학교">초등학교</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="중학교">중학교</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="SC4" data-aroundcatesub="고등학교">고등학교</a></li>
                  				<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="HP8" data-aroundcatesub="">병원</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="마트" data-aroundcatesub="">마트</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="BK9" data-aroundcatesub="">은행</a></li>
    							<li><a href="javascript:void(0);" onClick="aroundView(this)" data-aroundcate="PO3" data-aroundcatesub="">관공서</a></li>
                            </ul>
                        </div>
                        <!-- // 주변선택 팝업 끝 --> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
// 지도 default
var lat = '<?php echo $lat; ?>';
var lng = '<?php echo $lng; ?>';
var level = 4;
var infowindow = null;
var around_obj, around_subobj;

var markers = [];
var map, clusterer, bounds, swLatlng, neLatlng = null;

var mapContainer = document.getElementById('apiMapView'),
    mapOption = {
      	center: new daum.maps.LatLng(lat, lng), //지도의 중심좌표.
    	level: level, //지도의 레벨(확대, 축소 정도)
    };

// 다음 Map API Load
$("document").ready(function(){
  	map = new daum.maps.Map(mapContainer, mapOption); //지도 생성 및 객체 리턴

  	var ec_marker = new daum.maps.Marker({
       	position: new daum.maps.LatLng(lat, lng),
       	image: new daum.maps.MarkerImage('/images/ico_pointer.png', new daum.maps.Size(37, 50), {offset: new daum.maps.Point(18, 50)})
    });
    map.setMaxLevel(12);
    ec_marker.setMap(map);
  	
  	clusterer = new daum.maps.MarkerClusterer({
    	map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체
    	gridSize: 100, minClusterSize: 1,
    	minLevel: 12, // 클러스터 할 최소 지도 레벨
    	averageCenter: true,
    	calculator: [10, 50, 100], // 클러스터의 크기 구분 값, 각 사이값마다 설정된 text나 style이 적용된다
    	styles: [
        	{
            	// calculator 각 사이 값 마다 적용될 스타일을 지정한다
                width : '50px', height : '50px',
                background: '#dc4f34',
                opacity: '.85',
                borderRadius: '25px',
                color: '#000',
                fontSize:'17px',
                textAlign: 'center',
                fontWeight: 'bold',
                lineHeight: '51px',
                color:'white',
                transform: 'scale(1)',
                transition: 'all 0.3s ease-in-out'
            },
            {
              	// calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '60px', height : '60px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '30px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '61px',
              	color:'white'
            },
            {
                // calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '70px', height : '70px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '35px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '71px',
              	color:'white'
            },
            { 
                // calculator 각 사이 값 마다 적용될 스타일을 지정한다
              	width : '80px', height : '80px',
              	background: '#dc4f34',
              	opacity: '.85',
              	borderRadius: '40px',
              	color: '#000',
              	fontSize:'17px',
              	textAlign: 'center',
              	fontWeight: 'bold',
              	lineHeight: '81px',
              	color:'white'
            }
		]
  	});

  	map.relayout();
  	fnloadInfo();	// 주변 주요 건물 정보 맵에 실시간 로딩

  	daum.maps.event.addListener(map, 'idle', function () {
    	fnloadInfo();	// 주변 주요 건물 정보 맵에 실시간 로딩
  	});

	// 주변 검색 기능 
  	$(".btn_arnd").on("click", function(){
  	    if( $(this).hasClass('on') )
  	  	{
  	      	$(this).removeClass('on');
  	      	$("div.arnd_wrap").hide();
  	      	fnaroundViewClear();
  	    }
  	    else {
  	      	$(this).addClass('on');
  	      	$("div.arnd_wrap").show();
  	    }
	})
});

// 주변 검색 마킹
function aroundView(alink)
{
  	if( $(alink).hasClass('on') ) {
      	fnaroundViewClear();
      	return;
  	}
  	
  	$('.arnd_lst a.on').removeClass('on');
  	$(alink).addClass('on');

  	// 출력할 정보
  	around_obj = $(alink).data('aroundcate');
  	around_subobj = $(alink).data('aroundcatesub');

	// 주변 검색 건물 위치에 아이콘 표기
  	fnaroundView(around_obj, around_subobj);
}

// 주변 검색 제거
function fnaroundViewClear()
{
    $('.arnd_lst a.on').removeClass('on');
    setMarkers(null);
    around_obj = null;
    around_subobj = '';
}

// 마커 표기
function setMarkers(map)
{
    if( infowindow != null ) infowindow.close()
    for(var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// 주변 검색 보기
function fnloadInfo()
{
    bounds = map.getBounds();
    swLatlng = bounds.getSouthWest();
    neLatlng = bounds.getNorthEast();
    
    var mapCT = map.getCenter();
    
    lat = mapCT.getLat();
    lng = mapCT.getLng();
    level = map.getLevel();
    
    if(level > 6) {
    	$('.arnd_lst a.on').removeClass('on');
    	setMarkers(null);
    	$(".btn_arnd").removeClass('on');
    	$("div.arnd_lst").hide();
    }
    else {
    	$(".btn_arnd").show();
    }
}

// 주변 검색 건물 위치에 아이콘 표기
function fnaroundView(obj, subobj)
{
    if(obj == null) return;
    if(level > 6) { setMarkers(null); return; }
    if(infowindow != null) infowindow.close();
    else infowindow = new daum.maps.InfoWindow({zIndex: 100});
    var ps = new daum.maps.services.Places(map);

    if($.inArray(obj, ["MT1","CS2","PS3","SC4","AC5","PK6","OL7","SW8","BK9","CT1","AG2","PO3","AT4","AD5","FD6","CE7","HP8","PM9"]) > -1) {
        ps.categorySearch(obj, placesSearchCB, { useMapBounds: true });
    }
    else {
      	ps.keywordSearch( obj, placesSearchCB,{useMapBounds:true});
    }
    
    setMarkers(null);

    // 키워드 검색 완료 시 호출되는 콜백함수 입니다
    function placesSearchCB(data, status, pagination)
    {
        if(status === daum.maps.services.Status.OK)
        {
            //marker.clear();
            for(var i = 0; i < data.length; i++) {
                if(subobj != '' ) {
                  	if( data[i].place_name.indexOf(subobj) > -1 ) displayMarker(data[i]);
                }
                else displayMarker(data[i]);
            }
        }
    }
    
    // 마커 이미지의 이미지 주소입니다
	var imageSrc = "http://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png";
  	var ico = (subobj != '') ? subobj : obj;
	switch(ico)
	{
		case 'SC4': 	imageSrc = '/images/ico_school02.png';	break;
		case 'PS3': 	imageSrc = '/images/ico_hos.png'; 		break;
		case 'SW8': 	imageSrc = '/images/ico_bus.png'; 		break;
        case 'BK9': 	imageSrc = '/images/ico_bank.png';		break;
        case 'PO3': 	imageSrc = '/images/ico_public.png';	break;
        case '어린이집': 	imageSrc = '/images/ico_school01.png';	break;
        case '유치원': 	imageSrc = '/images/ico_school02.png';	break;
        case '초등학교': 	imageSrc = '/images/ico_school03.png';	break;
        case '중학교': 	imageSrc = '/images/ico_school04.png';	break;
        case '고등학교': 	imageSrc = '/images/ico_school05.png';	break;
        case '마트': 		imageSrc = '/images/ico_mart.png';		break;
        case 'HP8': 	imageSrc = '/images/ico_hos.png';		break;
	}

	// 마커 이미지의 이미지 크기 입니다
  	var imageSize = new daum.maps.Size(30, 30);
  	var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize);

	// 마커 출력
  	function displayMarker(place)
  	{
    	var marker1 = new daum.maps.Marker({
      		map: map,
      		zIndex:8,
      		position: new daum.maps.LatLng(place.y, place.x),
      		image: markerImage // 마커 이미지
    	});
    	
    	markers.push(marker1);

		// 클릭한 위치 업체 혹은 건물명 마커 출력
    	daum.maps.event.addListener(marker1, 'click', function(){
      		var infohtml = '<div style="padding:5px;font-size:12px;">' + place.place_name + '</div>';
      		if(infowindow.getContent() == infohtml) {
          		infowindow.setContent('');
        		infowindow.close();
      		}
      		else {
        		infowindow.setContent(infohtml);
        		infowindow.open(map, marker1);
      		}
    	});
  	}
}
</script>