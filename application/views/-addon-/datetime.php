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
		$now = strtotime(date('Y-m-d H:i:s'));
		if(isset($evaluasi['kelas_id']))
		{
			$kelas_id = $evaluasi['kelas_id'];
			$evaluasi_ditutup = strtotime($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_ditutup']);
			$evaluasi_mulai = strtotime($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_mulai']);
			$evaluasi_durasi 	= JamToDetik($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
			//$evaluasi_ditutup = strtotime(date('Y-m-d H:i:s'))+3600;
			
		}else
		{	$evaluasi_ditutup='';	}
		
		$simulasi=0;
		if(($user['role']=='admin')||($user['role']=='sdm')){
			$pengerjaan_ljs['waktu']=date('Y-m-d H:i:s');
			$simulasi=1;
		}
		
		//$waktu = TIME_LJS;
		
		if(isset($evaluasi_durasi)){
			$waktu = $evaluasi_durasi;
			
			$awal_dikerjakan = strtotime($pengerjaan_ljs['waktu']);
			if($evaluasi_ditutup>1){
				
				$sisa_waktu = $evaluasi_ditutup - $awal_dikerjakan;
				// WAKTU DURASI 0 atau WAKTU TUTUP KURANG DARI WAKTU BERAKHIR
				if( ($waktu > $sisa_waktu)||($waktu==0) ){
					$waktu = $sisa_waktu;
				}
			
			}else{
				// WAKTU TUTUP DAN DURASI 0
				$waktu = 7200;
			}
			//$limit_durasi_full = $evaluasi_ditutup - $evaluasi_durasi;
			//if()
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
		
		//if((isset($pengerjaan_ljs['waktu'])) && ($change_waktu == 0))
		//{	$waktu = $waktu - ($now - strtotime($pengerjaan_ljs['waktu']));	}
	
		//echo "AAA ".$pengerjaan_ljs['waktu']." BBB ".$waktu." CC";
	?>
   
	//var time_last = <?php echo $waktu;?>;
	var durasi = <?=$waktu?>000;
	//var awal_pengerjaan = <?=strtotime($pengerjaan_ljs['waktu'])?>;
	var date = "<?php echo $pengerjaan_ljs['waktu']; ?>";
	var t = date.split(/[- :]/);

	// Apply each element to the Date function
	var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
	var actiondate = new Date(d);
	var awal_pengerjaan = new Date(actiondate).getTime();
	
	var target_date = (awal_pengerjaan + durasi);
	 
	var days, hours, minutes, seconds; // variables for time units

	getCountdown();

	setInterval(function () { getCountdown(); }, 1000);

	function pad(n) {
		return (n < 10 ? '0' : '') + n;
	}
	
	function getCountdown(){

		// find the amount of "seconds" between now and target
		var current_date = new Date().getTime();
		
		var seconds_left = (target_date - current_date) / 1000;
			 
		hours = pad( parseInt(seconds_left / 3600) );
		seconds_left = seconds_left % 3600;
			  
		minutes = pad( parseInt(seconds_left / 60) );
		seconds = pad( parseInt( seconds_left % 60 ) );

		<?php
		if($simulasi==0){ 
		/*
		?>
				if((seconds_left<=0))
				{	
					document.forms["myform"].submit();
						
				}
		<?php
		*/
			}
		?>
		
		// format countdown string + set tag value
		if( (seconds_left<=0) ){
			countdown.innerHTML = "<span> Waktu Habis </span>"; 
		}else{
			countdown.innerHTML = "<span>" + hours + "</span>:<span>" + minutes + "</span>:<span>" + seconds + "</span>"; 
		}
		//countdown.innerHTML = awal_pengerjaan+' '+durasi;
	}

	
	
</script>