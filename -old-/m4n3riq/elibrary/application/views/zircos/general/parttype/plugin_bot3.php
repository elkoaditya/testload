
		<!-- picker -->
		<script src="<?=URL_MASTER;?>plugins/moment/moment.js"></script>
     	<script src="<?=URL_MASTER;?>plugins/timepicker/bootstrap-timepicker.js"></script>
     	<script src="<?=URL_MASTER;?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     	<script src="<?=URL_MASTER;?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
     	<script src="<?=URL_MASTER;?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		
		
		
		<!--<script src="<?=URL_MASTER;?>assets/pages/jquery.form-pickers.init.js"></script>-->
		<script>
		
		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			//startDate: '-0d',
			buttonClasses: ['btn', 'btn-sm'],
			applyClass: 'btn-success',
			cancelClass: 'btn-default',
			showTodayButton: true,
			showClear: true,
		});
		
		
		jQuery('#date-range').datepicker({
			format: 'dd-mm-yyyy',
			toggleActive: true,
			autoclose: true,
		});
		
		</script>