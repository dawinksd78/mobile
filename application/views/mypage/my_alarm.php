<div id="dawinWrap" class="alarm">
  <header id="header" class="header">
    <span class="btn_back back02">
      <button type="button" onclick="history.back();"><span class="">뒤로</span></button>
    </span> 
    <h2 class="title">알림</h2>
    <!-- span class="btn_text">
      <button><span class="">모두읽음</span></button>
    </span --> 
  </header>
    
  <section id="container">
    <div class="sub_container">            
      <div class="cont_wrap public_cont03">                
        <div class="al_cont">
          <ul class="al_lst">
            <?php
            if(!empty($result))
            {
                $i = 1;
                foreach($result as $list)
                {
                    $classState = "";
                    if(empty($list['VIEW_DATE'])) {
                        $classState = "unread";
                    }
                    
                    // 시간
                    $timeresult = time() - strtotime($list['SEND_DATE']);
                    
                    $s = 60; //1분 = 60초
                    $h = $s * 60; //1시간 = 60분
                    $d = $h * 24; //1일 = 24시간
                    $y = $d * 10; //1년 = 1일 * 10일
                    
                    if ($timeresult < $s) {
                        $timeprint = $timeresult . '초전';
                    } elseif ($h > $timeresult && $timeresult >= $s) {
                        $timeprint = round($timeresult/$s) . '분전';
                    } elseif ($d > $timeresult && $timeresult >= $h) {
                        $timeprint = round($timeresult/$h) . '시간전';
                    } else {
                        $timeprint = date('Y-m-d.', strtotime($list['SEND_DATE']));
                    }
                ?>
                <li id="alarmlist_<?php echo $i; ?>" class="<?php echo $classState; ?>" onclick="alarmView('<?php echo $list['SMS_SEND_RESULT_IDX']; ?>', '<?php echo $classState; ?>');">
                  <a href="javascript:contentsView('<?php echo $i; ?>');">
                    <span class="txt"><?php echo $list['TITLE'] ?></span>
                    <span class="date"><?php echo $timeprint; ?></span>
                  </a>
                  <div class="txtview" id="alarmview_<?php echo $i; ?>" style="display:none;"><?php echo $list['MESSAGE'] ?></div>
                </li>
                <?php $i++; } ?>
            <?php } else { ?>
            	<li class="">
                  <a>
                    <span class="txt">알림 정보가 없습니다.</span>
                  </a>
                </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </section>    
</div>

<script type="text/javascript">
// 알림 내용 보기
function alarmView(smsidx,code)
{
	$.ajax({ 
    	type: "POST", 
    	dataType: "json",
    	async: false, 
    	url:"/mypage/alarmview", 
    	data: "&smsidx="+smsidx, 
    	success: function(data) {
    		if(data == 'SUCCESS') {
        		if(code == 'unread') {
    				$("#alarmlist_"+code).removeClass('unread');
        		}
    		}
    	}
   	});
}

// 알림 내용보기
function contentsView(idx) {
	$(".txtview").hide();
	$("#alarmview_"+idx).show();
}
</script>