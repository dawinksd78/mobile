<script>
    <?php
    if(isset($msg))
    {
        ?>
        swal("<?php echo $msg?>").then(function(){ 
        	window.location.href ='<?php echo $url?>';
        	self.close();
        });
        <?php
    }
    else {
        ?>
        window.location.href ='<?php echo $url?>';
        self.close();
        <?php
    }
    ?>
</script>