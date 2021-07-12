
		<!-- picker -->
		<script src="<?=base_url();?>plugins/moment/moment.js"></script>
     	<script src="<?=base_url();?>plugins/timepicker/bootstrap-timepicker.js"></script>
     	<script src="<?=base_url();?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     	<script src="<?=base_url();?>plugins/clockpicker/js/bootstrap-clockpicker.min.js"></script>
     	<script src="<?=base_url();?>plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		
		
		
		<!--<script src="<?=base_url();?>assets/pages/jquery.form-pickers.init.js"></script>-->
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
		</script>