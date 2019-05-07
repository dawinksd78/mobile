<div id="dawinWrap" class="">
    <header id="header" class="header">
    	<span class="btn_close03">
        	<button type="button" onclick="history.back();"><span class="">닫기</span></button>
        </span>
        <h2 class="title">1:1문의하기</h2>
    </header>
    
    <section id="container">
        <div class="sub_container">
        	<?php
            $attributes = array('method'=>'post','id'=>'inquiryform');
            echo form_open('/board/inquiryprocess',$attributes);
            ?>
            <div class="cont_wrap public_cont qna">
                <!-- 카테고리 -->
                <div class="f_tab">
                    <p class="exp">카테고리 선택 후 문의내용을 입력해주세요.</p>
                    <ul>
                        <?php foreach($categorylist as $category) { ?>
                        <li><a href="#" onclick="categorySel('<?php echo $category['CODE_DETAIL'] ?>');" id="<?php echo $category['CODE_DETAIL']; ?>" class="inqcate"><?php echo $category['CODE_NAME']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                
                <!-- 내용입력 -->
                <div class="cont q_cont">
                    <input type="text" name="title" id="title" placeholder="제목입력" title="제목입력" class="inp" autocomplete="off">
                    <textarea name="contents" id="contents" class="txtarea" placeholder="문의할 내용을 입력해주세요."></textarea>
                </div>
            </div>
            
            <div class="btn_area bot_btn">
                <button class="btn_type02" type="submit">문의하기</button>
            </div>
            
            <input type="hidden" name="inquirycate" id="inquirycate">
            <?php echo form_close(); ?>
        </div>
    </section>
</div>

<script type="text/javascript">
// faq 카테고리
function categorySel(code)
{
	$(".inqcate").removeClass('on');
	$("#"+code).addClass('on');
	$("#inquirycate").val(code);
}

// 등록하기
$(".btn_type02").click(function(){
	// 1. 카테고리 선택
	if($('#inquirycate').val() == '') {
		swal('카테고리를 선택하세요');
		return false;
	}

	// 2. 제목입력
	if($('#title').val() == '') {
		swal('문의할 제목을 입력하세요.');
		$('#title').focus();
		return false;
	}

	// 3. 내용입력
	if($('#contents').val() == '') {
		swal('문의할 내용을 입력하세요.');
		$('#contents').focus();
		return false;
	}
});
</script>