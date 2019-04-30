<?php
// 평점 이미지 출력
$avgpercent = (int)($info['BROKER_POINT']*2*10);

// 사업자등록증
if($profile['BIZ_LICENSE_IMG'] == '') $BIZ_LICENSE_IMG = "/images/btn_camera.png";
else $BIZ_LICENSE_IMG = $info['BIZ_LICENSE_IMG'];

// 개설자격등
if($profile['BROKER_REG_LICENSE_IMG'] == '') $BROKER_REG_LICENSE_IMG = "/images/btn_camera.png";
else $BROKER_REG_LICENSE_IMG = $profile['BROKER_REG_LICENSE_IMG'];

// 중개사 대표 이미지
if($profile['MBR_IMAGE_FULL_PATH'] == '') $profileimg = "/images/btn_camera.png";
else $profileimg = $profile['MBR_IMAGE_FULL_PATH'];
?>

<link rel="stylesheet" href="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.css" />
<script src="//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>

<style>
.js-load {
    display: none;
}
.js-load.active {
    display: block;
}
</style>

<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close03">
        	<button type="button" onclick="window.close();"><span class="">닫기</span></button>
        </span>
        <h2 class="title"><span class="bk_name"><?php echo $info['OFFICE_NAME']; ?></span> <!-- 중개사 --> <i class="btn_loc" style="z-index:1000;" onclick="selmapview('<?php echo $info['OFFICE_NAME']; ?>', '<?php echo $info['LAT']; ?>', '<?php echo $info['LNG']; ?>')"></i></h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap public_cont02">
                <div class="ag_intro">
                    <div class="agbox agbox01">
                        <div class="thumbnail_area">
                            <div class="thumbnail"><img src="<?php echo $profileimg; ?>" alt="중개사사진" /></div>
                        </div>
                        <div class="star_score"> <span class="st_off"><span class="st_on" style="width:<?php echo $avgpercent; ?>%"><?php echo $info['BROKER_POINT']; ?></span></span> <a href="javascript:void(0);" class="rv_count">(<?php echo $info['BROKER_POINT_CNT']; ?>)</a> </div>
                        <span class="p_num"><?php echo $info['PHONE']; ?></span>
                        <span class="offi_name"><?php echo $info['OFFICE_NAME']; ?></span>
                        <span class="offi_addr"><?php echo $info['ADDR1']; ?> <?php echo $info['ADDR2']; ?></span>
                    </div>
                    
                    <div class="agbox">
                        <h3 class="ag_tit">중개사무소소개</h3>
                        <p><span class="bolder"><?php echo $info['OFFICE_NAME']; ?></span> <?php echo nl2br($info['OFFICE_INTRODUCE']); ?></p>
                        <div class="scroll">
                            <ul class="lics_lst">
                                <li><a class="img_file file01" href="<?php echo $BIZ_LICENSE_IMG; ?>" data-fancybox="gallery" data-caption="사업자등록증"><span class="st_hover2"></span><!-- 마우스 오버시 보여짐 --><img src="<?php echo $BIZ_LICENSE_IMG; ?>"><span class="f_text">사업자등록증</span></a></li>
                                <li><a class="img_file file02"  href="<?php echo $BROKER_REG_LICENSE_IMG; ?>" data-fancybox="gallery" data-caption="개설자격증"><span class="st_hover2"></span><!-- 마우스 오버시 보여짐 --><img src="<?php echo $BROKER_REG_LICENSE_IMG; ?>"><span class="f_text">개설등록증</span></a></li>
                                <?php if ( $profile['CERTIFICATE_OF_DEDUCTION_IMG'] != '' ) { ?>
                                <li><a class="img_file file03"  href="<?php echo $profile['CERTIFICATE_OF_DEDUCTION_IMG']?>" data-fancybox="gallery" data-caption="공제증서"><span class="st_hover2"></span><!-- 마우스 오버시 보여짐 --><img src="<?php echo $profile['CERTIFICATE_OF_DEDUCTION_IMG']; ?>"><span class="f_text">공제증서</span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    
                    <?php if($info['CAREER'] != '') { ?>
                    <div class="agbox">
                        <h3 class="ag_tit">경력사항</h3>
                        <p><?php echo nl2br($info['CAREER']); ?></p>
                    </div>
                    <?php } ?>
                    
                    <?php if(count($belong) > 0) { ?>
                    <div class="agbox">
                        <h3 class="ag_tit">소속공인중개사/중개보조원</h3>
                        <div class="scroll">
                            <ul class="empl_lst">
                                <?php foreach($belong as $row) { ?>
                                <li>
                                    <div class="thumbnail_area">
                                        <div class="thumbnail"><img src="<?php echo ($row['BR_PROFILE_IMG'] !='' ) ? $row['BR_PROFILE_IMG'] : '/images/btn_camera.png' ?>" alt="중개사사진" /></div>
                                    </div>
                                    <span class="bk_name bolder"><?php echo ($row['BR_NAME'])?></span> <span class="empl_type"><?php echo ($row['BR_GUBUN']=='SU') ? '소속공인중개사' : '중개보조원'; ?></span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if(count($review) > 0) {?>
                    <div class="agbox">
                        <h3 class="ag_tit">중개REVIEW <span class="rv_count">(<?php echo count($review); ?>)</span></h3>
                        <ul class="rv_lst" id="js-load">
                        	<?php
                        	foreach($review as $reviewdata)
                        	{
                        	    // 평점 이미지 출력
                        	    $avgtotpercent = $reviewdata['TOT_RATE'] / 5 * 100;
                        	?>
                            <li class="js-load">
                                <div class="star_score">
                                	<span class="st_off"><span class="st_on" style="width:<?php echo $avgtotpercent; ?>%"><?php echo $reviewdata['TOT_RATE']; ?></span></span>
                                    <p class="rv_cont"><?php echo $reviewdata['RATE_REASON']; ?></p>
                                    <span class="rv_date"><?php echo substr($reviewdata['RATE_DATE'], 0, 10); ?></span>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                        <span class="view_more">
                        	<button type="button" class="btn_review"><span class="">더보기 +</span></button>
                        </span>
                    </div>
                    <?php } ?>
                    
                    <?php if( $profile['YOUTUBE'] != '') { ?>
                    <div class="agbox">
                        <h3 class="ag_tit">소개영상</h3>
                        <p class="intro_ytube">
                            <?php if($profile['YOUTUBE'] != '') { ?>
                            <iframe src="https://www.youtube.com/embed/iPeLEqo2ocs" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            <?php } ?>
                        </p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <div class="btn_area bot_btn" id="inquiryButton">
            <?php if($qnabtnopen == '1') { ?>
            	<?php if($qnaCnt == '0') { ?>
                <button type="button" class="btn_type05" onclick="inquiry()">문의하기</button>
                <?php } else { ?>
                <button type="button" class="btn_type05">문의완료</button>
                <?php } ?>
            <?php } ?>
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
        <input type="hidden" name="officeidx" id="officeidx" value="<?php echo $info['BROKER_OFFICE_IDX']; ?>">
        <input type="hidden" name="goods_idx" id="goods_idx" value="<?php echo $goods_idx; ?>">
    </form>
    </div>
</div>

<script type="text/javascript">
// 중개리뷰 출력 및 더보기
$(window).on('load', function(){
	var loadcnt = '3';
    load('#js-load', loadcnt);
    $(".btn_review").on("click", function(){
        load('#js-load', loadcnt, '.btn_review');
    })
});
// 중개리뷰 불러오기
function load(id, cnt, btn)
{
    var page_list = id + " .js-load:not(.active)";
    var page_length = $(page_list).length;
    var page_total_cnt;
    if (cnt < page_length) {
    	page_total_cnt = cnt;
    }
    else {
    	page_total_cnt = page_length;
        $('.view_more').hide()
    }
    $(page_list + ":lt(" + page_total_cnt + ")").addClass("active");
}

// 문의하기 레이어팝업창
function inquiry()
{
	$('.mask').css('display', 'block');
	$('.lyr').css('display', 'block');
}

// 문의하기 팝업창 닫기
function inquiryclose()
{
	$('.mask').css('display', 'none');
	$('.lyr').css('display', 'none');
}

// 문의하기 등록
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
              	$('#inquiryButton').html('<button type="button" class="btn_type05">문의완료</button>');
              	
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

//위치지도보기
function selmapview(office, lat, lng)
{
	$('#office_name').val(office);
	$('#office_lat').val(lat);
	$('#office_lng').val(lng);

	// 지도 출력
	officeposition();
}
</script>