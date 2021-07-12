		<footer id="footer">
            FRESTO E-SCHOOL

            <ul class="f-menu">
                <li><a href="">Home</a></li>
                <li><a href="">Dashboard</a></li>
                <li><a href="">Reports</a></li>
                <li><a href="">Support</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </footer>

        	
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/flot/jquery.flot.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/flot/jquery.flot.resize.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>

        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js "></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
-->    
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
        
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/autosize/dist/autosize.min.js"></script>
        
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url("assets/material_admin"); ?>/js/app.min.js"></script>

		<script type="text/javascript">
			/*function delayAnimation($var,$jenis_animasi,$delay_time=4000) {
				$("#"+$var).removeClass("animated");
				$("#"+$var).removeClass($jenis_animasi);
				setTimeout(function () {
					$("#"+$var).addClass("animated "+$jenis_animasi);
					setTimeout(function(){delayAnimation($var,$jenis_animasi)}, $delay_time);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}*/
			
			function delayAnimation($var,$jenis_animasi,$delay_time) {
				$delay_time = typeof $delay_time !== 'undefined' ? $delay_time : 4000;
				var animatedEl = document.getElementById($var);
				animatedEl.className = animatedEl.className.replace(" animated","");
				animatedEl.className = animatedEl.className.replace(" "+$jenis_animasi,"");
				//animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className += " animated "+$jenis_animasi;
					//animatedEl.className = 'btn btn-primary btn-sm animated rubberBand';
					setTimeout(function(){delayAnimation($var,$jenis_animasi)}, $delay_time);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			
			function nowAnimation($var,$jenis_animasi) {
				$("#"+$var).addClass("animated "+$jenis_animasi);
			}
        </script>