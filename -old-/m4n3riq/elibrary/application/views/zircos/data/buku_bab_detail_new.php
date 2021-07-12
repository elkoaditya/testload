<style>
div[aria-label="Pop-out"] {
    display: none;
}
div["aria-label=toolbar"] {
    width: 52px;
}
</style>
<?php
	$data_buku = $data['data_buku_bab']['data'][1];
?>
<div class="wrapper">
	<div class="container">

		<!-- Page-Title 
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box" style="margin-bottom:-10px">
					<div class="btn-group pull-right">
						
					</div>
					<h4 class="page-title"> <?=$data_buku['buku_nama']?> </h4>
					<h4><?=$data_buku['buku_bab_nama']?> [<?=$data['kode_unik']?>]</h4>
				</div>
			</div>
		</div>
		 end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-12">
					<table width="100%">
						<tr>
							<td>
								<a class="btn btn-xs btn-inverse " href="<?=base_url();?>data/buku/detail/<?=$data_buku['buku_bab_buku_id']?>"><i class="fa fa-chevron-left"></i> Kembali</a>
							</td>
							<!--<td align="center">
								<?=$data_buku['buku_nama']?> / <?=$data_buku['buku_bab_nama']?>
							</td>-->
							<td align="right">
								<h4><b>READ</b> <label id="minutes">00</label>:<label id="seconds">00</label></h4>
							</td>
						</tr>
					</table>
						
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12" id="notification">
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					
					<iframe style="width:100%; height:480px;" src="http://fresto.co/book/2/#page=1"></iframe>
					
				</div>	
			</div>
              
			<script>
				
				
				function reading(akses){
					if (this.timer) clearTimeout(this.timer);
					  
					this.timer = setTimeout(function () {
						  var result;
						$.ajax({
							url: '<?php echo base_url()."data/baca/save_time";?>',
							data: 'kode=<?=$data['kode_unik']?>&buku_bab_id= <?=$data_buku['buku_bab_id']?>&siswa_id=<?=$this->session->userdata['user']['id']?>&akses='+akses,
							dataType: 'json',
							type: 'POST',
							success: function (j) {
								 //result =  j;
								//handleData(j); 
								 document.getElementById("notification").innerHTML = j.message;
							},
							error: function (j) {
								document.getElementById("notification").innerHTML = '<div class="alert alert-danger" role="alert">'+
                                        'Waktu baca GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".'+
									'</div>';
							}  
						  
						});
					}, 200);
				}
				
				var akses = 1;
				var minutesLabel = document.getElementById("minutes");
				var secondsLabel = document.getElementById("seconds");
				var totalSeconds = 0;
				setInterval(setTime, 1000);

				function setTime() {
				  ++totalSeconds;
				  secondsLabel.innerHTML = pad(totalSeconds % 60);
				  minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
				  
				  <?php 
				  if( $this->session->userdata['user']['role'] == 'user' ){
					  ?>
					  if(parseInt(totalSeconds % 60)==0)
					  {
						  reading(akses);
						  akses = 0;
					  }
				  <?php }?>
				}

				function pad(val) {
				  var valString = val + "";
				  if (valString.length < 2) {
					return "0" + valString;
				  } else {
					return valString;
				  }
				}
				
				
				//$('.ndfHFb-c4YZDc-Wrql6b').remove();
				//document.getElementByClass('ndfHFb-c4YZDc-Wrql6b').style.display='none';
				
				var appBanners = document.getElementsByClassName('ndfHFb-c4YZDc-Wrql6b'), i;

				for (var i = 0; i < appBanners.length; i ++) {
					appBanners[i].style.display = 'none';
				}
				
				
			</script>
			

                     
