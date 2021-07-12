<?php
	if($this->input->get('tanggal')){
		$date_value = $this->input->get('tanggal');
	}else{
		$date_value = date("d-m-Y");
	}
	
	if($this->input->get('kelas')){
		$kelas_id = $this->input->get('kelas');
	}else{
		$kelas_id = '';
	}
?>
<div class="wrapper" >
	<div class="container" >

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							
							<li class="active">
								Laporan Absensi
							</li>
						</ol>
					</div>
					<h4 class="page-title">Laporan Absensi <?php //echo $_SERVER['HTTP_HOST']?></h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-8">
				<div class="card-box">
					<div class="row">
						<div class="form-group">
							<label class="col-md-1 "><h5><b>Tanggal</b></h5></label>
							<div class="col-md-3">
								<input type="text" id="tanggal" name="tanggal" class="form-control datepicker" 
								 onchange="call()"  value="<?=$date_value?>" data-mask="99-99-9999" >
								
							</div>
						<!--</div>
						<div class="form-group">-->
							<div class="col-md-1"></div>
							<label class="col-md-1 "><h5><b>Kelas</b></h5></label>
							<div class="col-md-3">
							<select class="form-control " id="kelas_id" name="kelas_id" onchange="call()">
								<option value="0">- semua -</option>';
								<?php
								foreach($data['data_kelas']['data'] as $select)
								{
									$selected ='';
									if($kelas_id==$select['id'])
									{	$selected = 'selected';	}
									?><option value="<?=$select['id']?>" <?=$selected?>><?=$select['nama']?></option><?php
								}?>
							</select>
							</div>
						</div>
					</div>
				</div>
			 </div>
			<div class="col-md-4" style="text-align:right">
			 
			 <a class="btn btn-purple waves-effect w-md waves-light m-b-5" 
			 href="<?=base_url();?>laporan/lap_absensi/excel_download/download?tanggal=<?=$date_value?>&kelas=<?=$kelas_id?>">
			 <i class="fa fa-file-excel-o"></i> Download Laporan</a>
			 
			 <a class="btn btn-orange waves-effect w-md waves-light m-b-5" 
			 href="<?=base_url();?>laporan/lap_absensi/excel_download_rekap/download?tanggal=<?=$date_value?>&kelas=<?=$kelas_id?>">
			 <i class="fa fa-file-excel-o"></i> Download Rekap Bulanan</a>
			 
			</div>
		</div>
		<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Laporan Absensi : <?=Hari(tgltodb($date_value))?>, <?=$date_value?></b></h4>
					
						<?php //print_r($data['data_lap_absensi']['data'])?>
					<table class="table table-bordered m-0">
						
						<thead>
							<tr>
								<th> No </th>
								<th class="col-md-1"> Siswa </th>
								<th> Kelas </th>
								<?php 
									
									if(isset($data['data_jam_ajar']['data'])){
										$data_jam_ajar = $data['data_jam_ajar']['data'];
										foreach($data_jam_ajar as $value=>$key){
											
									?>
									<th> <?=$key['nama']?> </th>
								<?php } 
									}?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
							if(isset($data['data_siswa']['data'])){
								foreach($data['data_siswa']['data'] as $value=>$key){
									$no++;
							?>
							<tr>
								<td style="padding-top:5px; padding-bottom:5px"> <?=$no?> </td>
								
								<td style="padding-top:5px; padding-bottom:5px"> <?=$key['nama']?> </td> 
								<td style="padding-top:5px; padding-bottom:5px"> <?=$key['nama_kelas']?> </td> 
								<?php 
									
									if(isset($data['data_jam_ajar']['data'])){
										$data_jam_ajar = $data['data_jam_ajar']['data'];
										foreach($data_jam_ajar as $value=>$key2){
											if(isset($data['data_lap_absensi']['data'][$key['id']][$key2['id']])){
												/// STATUS
												if($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['status'] == 'gembira'){
													$icon = 'smiley.png';
												}elseif($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['status'] == 'sedih'){
													$icon = 'sad.png';
												}
												
												/// ABSEN
												if($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['absen'] == 'm'){
													$absen_color = 'success';
													$absen_ket = 'MASUK';
												}elseif($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['absen'] == 's'){
													$absen_color = 'purple';
													$absen_ket = 'SAKIT';
													$icon = ''; 
												}elseif($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['absen'] == 'i'){
													$absen_color = 'warning';
													$absen_ket = 'IJIN';
													$icon = ''; 
												}elseif($data['data_lap_absensi']['data'][$key['id']][$key2['id']]['absen'] == 'a'){
													$absen_color = 'danger';
													$absen_ket = 'ALPHA';
													$icon = ''; 
												}
												?>
												<td style="padding-top:5px; padding-bottom:5px"> 
													<button type="button" class="btn btn-<?=$absen_color?> btn-xs w-xs waves-effect waves-light">
														<?php
														if($icon!=''){?>
															<img src="<?=base_url()?>content/images/<?=$icon?>" width="15px"> 
														<?php
														}?>
														<?=$absen_ket?>
													</button>
												</td>
												<?php 
											}else{
												?>
												<td> </td>
												<?php 
											}	
										} 
									}?>
									
							</tr>
						<?php } 
							}?>
							
						</tbody>
					</table>
					<?php 
					//print_r($data);
					?>
						
				</div>
			</div>
		</div>
<script>
	function call() {
		window.location = "<?=base_url()?>laporan/lap_absensi?tanggal="+document.getElementById("tanggal").value
		+"&kelas="+document.getElementById("kelas_id").value;
	}
	
</script>				
		