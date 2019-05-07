
<!-- 중개사 다음 지도 API 보기 -->
<input type="hidden" name="office_name" id="office_name">
<input type="hidden" name="office_lat" id="office_lat">
<input type="hidden" name="office_lng" id="office_lng">
<div class="apiMapMask" style="display:none;" onmousedown="mapClose()"></div>
<div class="apiMapClose" style="display:none;" onclick="mapClose()"><img src="/images/btn_close.png"></div>
<div class="apiMap" id="apiMap" style="display:none;"></div>

<!-- 우측상단 햄버거 메뉴 백그라운드 -->
<!-- div class="hamburgerMenuMask" style="display:none;" onmousedown="rightMenu()"></div -->
  
<!-- Page Loading -->
<div id="ajax_loader"></div>

<script type="text/javascript">
//서브메뉴
var submenuStateView = 'none';
function rightMenu()
{
	if(submenuStateView == 'none') {
		$('#submenuList').show(300);
		$('.hamburgerMenuMask').show();
		submenuStateView = 'block';
	}
	else {
		$('#submenuList').hide(100);
		$('.hamburgerMenuMask').hide();
		submenuStateView = 'none';
	}
    $('.box_submenu').animate({width:'toggle'});
}

<?php if($BROKER_OFFICE_NAME != '' && $LAT != '' && $LNG != '') { ?>
$('#office_name').val('<?php echo $BROKER_OFFICE_NAME; ?>');
$('#office_lat').val('<?php echo $LAT; ?>');
$('#office_lng').val('<?php echo $LNG; ?>');
<?php } ?>
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134936659-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-134936659-2');
</script>

</body>
</html>