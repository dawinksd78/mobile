<div id="dawinWrap" class="">
    <header id="header" class="header maphd">
    	<span class="btn_back">
        	<button type="button" onclick="history.back();"><span class="">뒤로</span></button>
        </span>
        <h2 class="title">집내놓기</h2>
        
        <!-- hamburgerMenu -->
        <script>hamburgerMenuList('common');</script>
    </header>
    
    <section id="container">
        <div class="sub_container">
            <div class="cont_wrap join_wrap sellitm">
                <h2 class="subj_tit"><span class="m_tit">매물 사진 등록</span></h2>
                <div class="proc"> <a href="/mypage/step1_modify/<?php echo $step3['GOODS_IDX']?>" class="bul_proc prev"></a><a href="/mypage/step2_modify/<?php echo $step3['GOODS_IDX']?>" class="bul_proc prev"></a><a href="/mypage/step3_modify/<?php echo $step3['GOODS_IDX']?>" class="bul_proc on"></a><a href="/mypage/step4_modify/<?php echo $step3['GOODS_IDX']?>" class="bul_proc"></a></div>
                
                <div class="cont">
                <?php
                /* 아파트 & 오피스텔 */
                if($step3['CATEGORY'] == 'APT' || $step3['CATEGORY'] == 'OFT')
                {
                    switch($step3['CATEGORY'])
                    {
                        case 'APT': $expl = "아파트"; break;
                        case 'OFT': $expl = "오피스텔"; break;
                    }
                ?>
                    <div class="cont_exp">
                        <p><?php echo $expl; ?> 내부와 단지 사진을 등록해주세요. 사진은 4MB 이하의 jpg, png 파일로 업로드해주세요.<br><small class="t_red">* 사진등록은 선택사항이지만 좋은 사진을 올릴수록 빨리 거래될 확률이 높아집니다.</small></p>
                    </div>   
                                     
                    <div class="inpbox">
                        <label for="itm_type01" class="lbl">내부사진</label>
                        <p class="lbl_exp">* 거실, 방, 화장실, 주방, 현관, 베란다 등 최대 6장까지 등록가능</p>  
                        <div class="scroll">
                            <ul class="upload_pic" id="viewul1">
                            	<?php $q=6; foreach($inimage as $row) { ?>
                                    <li class="addeditem userimg">
                                        <div class="btn_file_wrap">
                                            <span class="add_pic"><img src="<?php echo $row['SERVER_PATH'].$row['FULL_PATH']?>" alt=""></span> <a onClick="removeGoodsImg(this)" data-picname="up1" data-numbers="<?php echo $q; ?>" data-imguuid="<?php echo $row['GOODS_IMG_IDX']; ?>" class="btn_del01"></a>
                                        </div>
                                    </li>
                                <?php $q--; } ?>
                                <li id="uploadbt1" class="addfile">
                                    <div class="btn_file_wrap">
                                        <label for="file_upload">+ 파일업로드</label>
                                        <input type="file" class="btn_file_pic" name="" id="fileupload1" data-limitlen="6" data-target="#viewul1" multiple>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="inpbox">
                        <label for="itm_type01" class="lbl">외부사진</label>
                        <p class="lbl_exp">* 주출입구, 전경, 주도로/산책로, 주차장, 현관입구, 관리사무소, 놀이터 등 최대 10장까지 등록가능</p>  
                        <div class="scroll">
                            <ul class="upload_pic" id="viewul2">
                            	<?php
                            	$totoutimg = count($outimage);
                            	$p = 0;
                            	foreach($outimage as $row)
                            	{
                            	    if($p == 0) {
                            	        ?>
                            			<div class="btn_file_wrap addeditem userimg">
                                        	<span class="symbol">대표이미지</span>
                                            <!-- 첨부된 파일위치 --> 
                                        	<span class="add_pic"><img src="<?php echo $row['SERVER_PATH'].$row['FULL_PATH']; ?>"></span> <a onClick="removeGoodsImg(this)" data-picname="up" data-numbers="<?php echo $p; ?>" data-imguuid="<?php echo $row['GOODS_IMG_IDX']; ?>" class="btn_del01"></a>
                                    	</div>
                                    	<?php
                                    } else {
                                        ?>
                                        <li class="addeditem userimg">
                                        	<div class="btn_file_wrap">
                                           		<span class="add_pic"><img src="<?php echo $row['SERVER_PATH'].$row['FULL_PATH']; ?>"></span> <a onClick="removeGoodsImg(this)" data-picname="up" data-numbers="<?php echo $p; ?>" data-imguuid="<?php echo $row['GOODS_IMG_IDX']; ?>" class="btn_del01"></a>
                                           	</div>
                                        </li>
                                    	<?php
                                    }
                                    $p++;
                            	}
                            	?>
                              	
                              	<?php
                              	$k = count($default_outimage);
                                foreach($default_outimage as $row)
                                {
                                    if($totoutimg == 0 && $k == count($default_outimage)) {
                                        ?>
                                        <div class="btn_file_wrap addeditem userimg">
                                        	<span class="symbol">대표이미지</span>
                                            <!-- 첨부된 파일위치 --> 
                                        	<span class="add_pic"><img src="<?php echo $row['IMAGE_FULL_PATH']?>"></span>
                                    	</div>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <li class="addeditem userimg">
                                        	<div class="btn_file_wrap">
                                            	<span class="add_pic"><img src="<?php echo $row['IMAGE_FULL_PATH']?>"></span>
                                            </div>
                                        </li>
                                  		<?php
                                    }
                                    $k--;
                                }
                                ?>
                              	
                              	<?php if( count($default_outimage) < 10 ) { ?>
                                <li id="uploadbt2" class="addfile">
                                	<div class="btn_file_wrap">
                                		<label for="file_upload">+ 파일업로드</label>
                                    	<input type="file" class="btn_file_pic" name="" id="fileupload" data-limitlen="10" data-target="#viewul2" multiple>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php /* 원룸 */ } else if($step3['CATEGORY'] == 'ONE') { ?>
                	<div class="cont_exp">
                        <p>매물 사진을 꼭 등록해주세요. 사진은 4MB 이하의 jpg, png 파일로 업로드해주세요. </p>
                    </div>                    
                    <div class="inpbox">
                        <label for="itm_type01" class="lbl">내/외부사진</label>
                        <p class="lbl_exp">* 최대 10장까지 등록 가능하며 방, 부엌, 욕실, 현관 4장은 필수등록사항입니다.</p>  
                        <div class="scroll">
                            <ul class="upload_pic" id="viewul1">
                                <?php $p=6; foreach($inimage as $row) {?>
                                	<?php if($p == 10) { ?>
                            			<div class="btn_file_wrap addeditem userimg">
                                        	<span class="symbol">대표이미지</span>
                                            <!-- 첨부된 파일위치 --> 
                                        	<span class="add_pic"><img src="<?php echo $row['SERVER_PATH'].$row['FULL_PATH']?>"></span> <a onClick="removeGoodsImg(this)" data-picname="up1" data-numbers="<?php echo $p; ?>" data-imguuid="<?php echo $row['GOODS_IMG_IDX']; ?>" class="btn_del01"></a>
                                    	</div>
                                    <?php } else { ?>
                                        <li class="addeditem userimg">
                                            <div class="btn_file_wrap">
                                                <span class="add_pic"><img src="<?php echo $row['SERVER_PATH'].$row['FULL_PATH']?>" alt=""></span> <a onClick="removeGoodsImg(this)" data-picname="up1" data-numbers="<?php echo $p; ?>" data-imguuid="<?php echo $row['GOODS_IMG_IDX']; ?>" class="btn_del01"></a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                <?php $p--; } ?>
                                <li class="addfile" id="uploadbt1">
                                    <div class="btn_file_wrap">
                                        <label for="file_upload">+ 파일업로드</label>
                                        <input type="file" class="btn_file_pic" name="" id="fileupload1" data-limitlen="10" data-target="#viewul1" multiple>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                </div>
                
                <div class="modi_btn"><button class="btn_line03 btn_prev" type="button" onclick="goPage('/mypage/step2_modify/<?php echo $step3['GOODS_IDX']; ?>')">이전</button><button class="btn_line03 btn_next" type="button" onclick="goPage('/mypage/step4_modify/<?php echo $step3['GOODS_IDX']; ?>')">다음</button></div>
            </div>
            
            <div class="btn_area bot_btn">
                <button type="button" class="btn_type02" onclick="goPage('/mypage/myhousesale');">수정완료</button>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
var datachanged = false;
var isSaved = false;

var outerimagecnt = <?php echo count($outimage); ?>;

var category = "";
var idx = "<?php echo $step3['GOODS_IDX']; ?>";
var itemInlimit = <?php echo ($inimage_avail - count($inimage)); ?>;
var initem = <?php echo json_encode($inimage, true); ?>;

// 대표이미지 아이콘 출력
function changeDefault()
{
	$("li.userimg").each( function (i, r){
		if( i == 0 ){ $(this).children(".rep_tag").show() }
		else  $(this).children(".rep_tag").hide()
	})
}

// 선택 이미지 삭제
function removeGoodsImg(bt)
{
	var uuid = $(bt).data("imguuid");
	var numbers = $(bt).data("numbers");
  	var picname = $(bt).data("picname");
    $.ajax({
        url: '/sendfile/delGoodImg',
        type: 'POST',
        data: { uuid :  $(bt).data("imguuid") },
        dataType: 'json',
        success: function (result) {
          	if(result.code == 200)
            {            	
            	if(picname == 'up')
          		{
              		if(numbers == 0) {
            			location.href = '/mypage/step3_modify/' + idx;
              		}
              		else {
              			$(bt).parent().parent().remove();
              		}
          			outerimagecnt = outerimagecnt - 1;
          		}
          		else
          		{
          			$(bt).parent().parent().remove();
              		itemInlimit = itemInlimit + 1;
          		}
          	}
        },
        error: function(request, status, error) {
          	swal("오류가 발생 하였습니다. 다시 시도해 주세요!");
            $("#fileupload1").val('');
        }
    });
}

$(document).ready(function (e) {
	// 내부사진
	$('#fileupload1').on('change', function(){
		var ins = document.getElementById('fileupload1').files.length;
		var len = Number($(this).data('limitlen'));
		var target = $(this).data('target');
		if( ($(target).children("div.addeditem").length + $(target).children("li.addeditem").length) >= len ) {
	        $(this).val('');
	        swal("최대 장까지 "+len+"가능합니다.");
	        return;
		}

	    for(var x=0; x < ins; x++)
		{
			var form_data = new FormData();
			form_data.append("files", document.getElementById('fileupload1').files[x]);
			$.ajax({
				url: '/sendfile/goodsImgUp/in/'+ idx, // point to server-side PHP script
				dataType: 'json', // what to expect back from the PHP script
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: form_data,
	            type: 'post',
	            success: function (result) {
	        		if( result.code == 200 )
		        	{
	        			var inserthtml = '<li class="addeditem userimg"><div class="btn_file_wrap"><span class="add_pic"><img src="' + result.data +'"></span> <a onClick="removeGoodsImg(this)" data-picname="up1" data-numbers="' + itemInlimit + '" data-imguuid="' + result.newUuid + '" class="btn_del01"></a></div></li>';
                    	$(inserthtml).insertBefore("#uploadbt1");

		        		itemInlimit = itemInlimit - 1;
	            	}
	                else {
	                    swal(result.msg); // display success response from the PHP script
	                }
	                $("#fileupload1").val('');
		       	},
	           	error: function(request, status, error) {
	           		swal("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요");
	                $("#fileupload1").val('');
	           	}
			});
		}
	});

	// 외부사진
	$('#fileupload').on('change', function(){
		var ins = document.getElementById('fileupload').files.length;
		var len = Number($(this).data('limitlen'));
		var target = $(this).data('target');
		if( $(target).children("li.addeditem").length >= len ) {
			$(this).val('');
	        swal("최대 장까지 "+len+"가능합니다.");
	        return;
		}
		
		for(var x=0; x < ins; x++)
		{
			var form_data = new FormData();
			form_data.append("files", document.getElementById('fileupload').files[x]);
			$.ajax({
				url: '/sendfile/goodsImgUp/out/'+ idx, // point to server-side PHP script
				dataType: 'json', // what to expect back from the PHP script
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (result) {
					if( result.code == 200 )
					{
						if(outerimagecnt == 0) {
							var inserthtml = '<div class="btn_file_wrap addeditem userimg"><span class="symbol">대표이미지</span><span class="add_pic"><img src="' + result.data + '" alt=""></span> <a onClick="removeImg(this)" data-picname="up" data-numbers="' + outerimagecnt + '" data-imguuid="' + result.newUuid + '" class="btn_del01"></a></div>';
						}
						else {
							var inserthtml = '<li class="addeditem userimg"><div class="btn_file_wrap"><span class="add_pic"><img src="' + result.data + '" alt=""></span> <a onClick="removeGoodsImg(this)" data-picname="up" data-numbers="' + outerimagecnt + '" data-imguuid="' + result.newUuid + '" class="btn_del01"></a></div></li>';
						}
	                    $(inserthtml).insertBefore("#uploadbt2");
	                    
	                    outerimagecnt = outerimagecnt + 1;
	    			}
					else {
						swal(result.msg); // display success response from the PHP script
					}
					$("#fileupload").val('');
				},
	            error: function(request, status, error) {
					swal("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요");
				}
			});
		}
	});
});
</script>