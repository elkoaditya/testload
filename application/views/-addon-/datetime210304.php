<?php
//print_r($evaluasi);
//print_r($d);
echo NL . '<link href="'. base_url("assets/impromptu").'/jquery-impromptu.css" rel="stylesheet">' . NL;
echo NL . '<script type="text/javascript" src="' . base_url('assets/impromptu/jquery-impromptu.js') . '"></script>' . NL;
?>
<script>
	// Get the countdown element
    var countdown = document.getElementById("countdown");
    
    // Set the total time in seconds
	<?php
		$now = strtotime(date('Y-m-d H:i:s', time()));
		if(isset($evaluasi['kelas_id']))
		{
			$kelas_id = $evaluasi['kelas_id'];
			$evaluasi_ditutup = strtotime($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_ditutup']);
			$evaluasi_mulai = strtotime($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_mulai']);
			$evaluasi_durasi 	= JamToDetik($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
			//$evaluasi_ditutup = strtotime(date('Y-m-d H:i:s'))+3600;
			
		}else
		{	$evaluasi_ditutup='';	}
		
		//$waktu = TIME_LJS;
		if(isset($evaluasi_durasi)){
			$waktu = $evaluasi_durasi;
		}else{
			$waktu = 7200;
		}
		
		$change_waktu=0;
		/*if($evaluasi_ditutup)
		{
			if(($evaluasi_ditutup - $evaluasi_mulai) <= $waktu){	
				$waktu = $evaluasi_ditutup - $now;	
				$change_waktu = 1;
			}
		}*/
		
		if((isset($pengerjaan_ljs['waktu'])) && ($change_waktu == 0))
		{	
			if($this->input->get("simulasi")){
			
			}else{
				$waktu = $waktu - ($now - strtotime($pengerjaan_ljs['waktu']));
			}
		}
	
		// cek lebih cepat tutup atau durasi
		if($evaluasi_ditutup>0){
			$sisa_time = $evaluasi_ditutup - $now;
			if($sisa_time < $waktu){
				$waktu = $sisa_time;
			}
		}
	?>
    var totalTime = <?php echo $waktu;?>;
	var time_last = <?php echo $waktu;?>;
	var date_reload = Date.now();
			date_reload = Math.round(date_reload/1000);
	//var now = <?php echo $now?>;
	
	// NEW
	//Explicit string conversion using "" + n
	function pad(n){
		return n > 9 ? "" + n : "0" + n;
	}
	var original = totalTime;
	function padMinute(n){
		return original >= 60 && n <= 9 ? "0" + n : original < 60 ? "00" : "" + n;
	}
	function padHour(n){
		return original >= 3600 && n <= 9 ? "0" + n : original < 3600 ? "00" : "" + n;
	}
	// END of new
	
	// Every second...
    var interval = setInterval(function(){
        // Update the time remaining
        updateTime();
        
        // If time runs out, stop the countdown
        if(totalTime == -1){
            clearInterval(interval);
            return;
        }
    }, 1000);

    // Display the countdown
    function displayTime(){
        // Determine the number of minutes and seconds remaining
        var hour	= Math.floor(totalTime / 3600);
		var minutes = Math.floor((totalTime% 3600) / 60);
        var seconds = totalTime % 60;
        
		if((hour==0)&&(minutes==15)&&(seconds==0))
		{	last_minute(15);	}
		
		if((hour==0)&&(minutes==0)&&(seconds==0))
		{	
			var date_now = Date.now();
			date_now = Math.round(date_now/1000);
			/*
			var start_LJS = <?php echo strtotime($pengerjaan_ljs['waktu']);?>;
			//var time_ljs = <?php echo $waktu; ?>;
			var time_start = <?php echo $evaluasi_mulai; ?>;
			var time_close = <?php echo $evaluasi_ditutup; ?>;
			var time_LJS = <?php echo TIME_LJS;?>;
			
			var count_close = time_LJS - (time_close - start_LJS);
			if((time_close - time_start) <= time_LJS){
				time_LJS = (time_close - time_start);
			}
			
			var count_LJS = date_now - (time_LJS + start_LJS);
			
			
			if(date_now <= (date_reload + time_last + 60)){
				//alert("<b>WAKTU TINGGAL "+date_now+" "+date_reload+" "+time_last+" "+now+" "+(date_reload + time_last)+" </b>");
				document.forms["myform"].submit();
			}else{
				location.reload();
			}
			*/
			//window.location = '<?php echo base_url()."{$uri}?id={$evaluasi['id']}";?>';	
		}
		
		
		hour	= "<span>" + padHour(hour).split("").join("</span><span>") + "</span>";
		
        minutes = "<span>" + padMinute(minutes).split("").join("</span><span>") + "</span>";
        
        seconds = "<span>" + pad(seconds).split("").join("</span><span>") + "</span>";
        countdown.innerHTML = hour + ":" + minutes + ":" + seconds;
		
    }

    // Update the time remaining
    function updateTime(){
        displayTime();
        totalTime--;
    }
    
    // Start the countdown immediately on the initial pageload
    updateTime();
	
	
	function last_minute(minute){
		/*
		$.prompt("<b>WAKTU TINGGAL "+minute+" MENIT </b>",{
			top	: '35%' ,
			show: 'slideDown'
		})
		*/;
		alert("<b>WAKTU TINGGAL "+minute+" MENIT </b>");
	}
</script>