<script>
    <?php if( isset($msg) ) { ?>
  	alert("<?php echo $msg; ?>");
    <?php } ?>
    
    <?php if( isset($close) && $close ) { ?>
  	self.close();
    <?php } ?>
    
    <?php if( isset($url) ) { ?>
  	location.href = "<?php echo $url; ?>";
    <?php } ?>
</script>