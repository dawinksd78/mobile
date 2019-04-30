<script type="text/javascript">
<?php if($result) { ?>
swal({
  	title: "1:1문의 완료!",
  	text: "입력하신 내용이 등록 되었습니다.",
  	icon: "success",
  	button: "확 인",
}).then(function(){ 
	   location.href='/';
});
<?php } else { ?>
swal({
  	title: "1:1문의 실패!",
  	text: "1:1문의하기에 실패하였습니다. 다시 시도해 주시기 바랍니다.",
  	icon: "error",
  	button: "확 인",
}).then(function(){ 
	   location.href='/board/inquiry';
});
<?php } ?>
</script>