		</div> <!-- end div of container -->
<footer>
	<nav class="navbar navbar-default">
      <div class="container footer">
        <div class="text-center">
        	CopyRights &copy; QPE <?php echo date('Y'); ?> 
        </div>
      
      </div>
    </nav>
		<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		<script src="<?php echo base_url(); ?>assets/timepicker/jquery-ui-timepicker-addon.js"></script>
		<script src="<?php echo base_url(); ?>assets/evaluate/js/footer-vendors-v13860.js?v=1"></script>
		<script src="<?php echo base_url(); ?>assets/evaluate/js/16p-core30f4.js?v=3"></script>
        <script src="<?php echo base_url(); ?>assets/evaluate/js/test3860.js?v=1"></script>

	    <script>
    	$j('#test-form .option').button();
    	</script>
        <script>
		  $( function() {
		    $( ".datepicker" ).datepicker({
		    	dateFormat: "yy-mm-dd"
		    	// timeFormat: 'HH:mm:ss'
		    });
		  } );
		  $('#selectLeadType').on('click', function() {
			var leadType = this.value;
			$('#leadNameLabel').children('span').text(leadType);
			});
		  
		  </script>
</footer>		  
	</body>
</html>