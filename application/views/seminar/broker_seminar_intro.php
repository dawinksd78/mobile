<!--
프리젠테이션.. 렌딩페이지.

경로 구분 : <?=$gubun?><p>


설명회 페이지내용..(모바일)

<button id="gomain" name="gomain" onclick="javascript:gomain();">접수하러가기</button>
-->

<!DOCTYPE Html>
<html lang="Ko">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>dawin</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<meta name="format-detection" content="telephone=no, address=no, email=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" href="../../css/m_seminar.css" type="text/css"/>
<link rel="stylesheet" href="../../css/m_all.css" type="text/css"/>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/notosanskr.css">
<link rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>

<body>
<div id="semWrap" class="">
    <section id="container" class="seminar_main_section">
        <div id="m_section">
            <div class="img_box">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="p01"><b>네이버</b>와<br><b>직방</b>을 대체한다!!</p>
                        <p>임대료와 광고비 걱정 없는<br>신개념 부동산 중개플랫폼 론칭!</p>
                        <button class="btn_apply_seminar" onclick="javascript:gomain();">설명회 신청하기</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="sub_section" class="smain_sub">
            <div class="img_box bgseminar02">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="p02">임대료 걱정 NO!</p>
                        <p>단지내 상가나 1층 사무실이 아니어도<br>매물과 매수인을 확보하는데<br>전혀 어려움이 없는 시스템</p>
                    </div>
                </div>
            </div>
            <div class="img_box bgseminar03">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="p02">광고비 걱정 NO!</p>
                        <p class="mgb01">매물과 매수인 확보에 필요한 모든 광고는<br>저희 다윈중개가 직접 해드립니다.<br>중개사님들은 중개에만 집중하세요. </p>
                        <p class="mgb02"><img src="../images/img_adv01.png" alt="지하철광고"></p>
                        <p><img src="../images/img_adv02.png" alt="지하철광고"></p>
                        <p><img src="../images/img_adv03.png" alt="지하철광고"></p>
                    </div>
                </div>
            </div> 
            <div class="img_box bgseminar04">
                <div class="m_sch_wrap">
                    <div class="m_text">
                        <p class="p03"><b>다윈중개</b><br>론칭설명회</p>
                        <p>일시: <b>2019년 3월 12일(화) 오전 11시</b></p>
                        <p>장소: <b>판교 워크앤올 코워킹 스페이스 4층 세미나실</b>(판교역 2번출구)<br></p>
                        <p class="addr">(성남시 분당구 분당내곡로 117 크래프톤타워-구 알파돔타워Ⅳ)</p>
                        <p>대상: <b>공인중개사</b></p>
                        <p>문의: <b>1544-6075</b></p>
                        <p>참가비 없음</p>                        
                        <p class="small">* 저희 ㈜다윈소프트는 중견 부동산 종합개발회사가 출자한 회사입니다.</p>
                        <button class="btn_apply_seminar" onclick="javascript:gomain();">설명회 신청하기</button>
                  </div>
              </div>
          </div>
        </div>
    </section>
</div>
</body>
</html>


<script type="text/javascript">
	
	function gomain(){
	
		var filter = "win16|win32|win64|mac|macintel";

		if(navigator.platform){

			if(0 > filter.indexOf(navigator.platform.toLowerCase())){

			//console.log ("gubun data : " , "<?=$gubun?>");

				//alert("Mobile");
				window.location.href ='brokersseminar/mobile?gubun=<?=$gubun?>';

			}else{

			//console.log ("gubun data : " , "<?=$gubun?>");

				//alert("PC");
				window.location.href ='brokersseminar/pc?gubun=<?=$gubun?>';

			}
		}
	}

</script>

 