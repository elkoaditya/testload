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
								Laporan Jurnal Guru
							</li>
						</ol>
					</div>
					<h4 class="page-title">Laporan Jurnal Guru</h4>
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
			 href="<?=base_url();?>laporan/lap_jurnal_guru/excel_download/download?tanggal=<?=$date_value?>&kelas=<?=$kelas_id?>">
			 <i class="fa fa-file-excel-o"></i> Download Laporan</a>
			 
			 <a class="btn btn-orange waves-effect w-md waves-light m-b-5" 
			 href="<?=base_url();?>laporan/lap_jurnal_guru/excel_download_rekap/download?tanggal=<?=$date_value?>&kelas=<?=$kelas_id?>">
			 <i class="fa fa-file-excel-o"></i> Download Rekap Bulanan</a>
			 
			</div>
		</div>
		<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				
				<h4 class="m-t-0 header-title"><b>Data Laporan Jurnal Guru : <?=Hari(tgltodb($date_value))?>, <?=$date_value?></b></h4>
					
				
			</div>
		</div>
		
		<?php 
		$jml_absensi = array(
			"Masuk" => "data_masuk",
			"Sakit" => "data_sakit",
			"Ijin" => "data_ijin",
			"Alpha" => "data_alpha",
		);
		
		$no = 0;
		if(isset($data['data_kelas']['data'])){
			foreach($data['data_kelas']['data'] as $value=>$key){
				if(($kelas_id=='')||($kelas_id==$key['id'])){
					$no++;
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="card-box table-responsive">
								<h4 class="m-t-0 header-title"><b><?=$key['nama']?></b></h4>
							
								<?php
								if(isset($data['data_lap_jurnal_guru']['data'][$key['id']])){
									$lap_jurnal_guru = $data['data_lap_jurnal_guru']['data'][$key['id']];
									foreach($lap_jurnal_guru as $value=>$key2){
										?>
										<div class="col-sm-6">
											<div class="card-box">
												<table width="100%">
													<tr>
														<td width="20%"> <b>Materi </b> </td>
														<td width="2%">:</td>
														<td > <?=$key2['materi_ajar']?> </td>
													</tr>
													<tr>
														<td > <b>MaPel </b> </td>
														<td >:</td>
														<td > <?=$key2['nama_mapel']?> </td>
													</tr>
													<tr>
														<td > <b>Guru </b> </td>
														<td >:</td>
														<td > <?=$key2['nama_guru']?> </td>
													</tr>
													<tr>
														<td > <b>Jam Ajar </b> </td>
														<td >:</td>
														<td > <?=$key2['jam_ajar_id']?> </td>
													</tr>
													<tr>
														<td> <b>Jam Masuk</b> </td>
														<td> : </td>
														<td> <?=$key2['jam_masuk']?> </td>
													</tr>
													<tr>	
														<td > <b>Jam Keluar</b> </td>
														<td > : </td>
														<td > <?=$key2['jam_keluar']?> </td>
													</tr>
													<tr>
														<td > <b>Status Belajar </b> </td>
														<td >:</td>
														<td > <?php
														if($key2['status_belajar_id']>0){
															echo $data['data_status_belajar']['data'][$key2['status_belajar_id']]['nama'];
															//print_r($data['data_status_belajar']['data']);
														}?> </td>
													</tr>		
													<tr>
														<td> <b>Jumlah Siswa</b> </td>
														<td> : </td>
														<td > <?=$key2['jml_siswa']?> </td>
														
													</tr>
													
													<?php
													foreach($jml_absensi as $index3 => $key3){?>
													<tr>
														<td> <b>Jumlah Siswa <?=$index3?></b> </td>
														<td> : </td>
														<td > <?php
														if(isset( $data[$key3]['data'][$key['id']][$key2['id']] )){
															echo $data[$key3]['data'][$key['id']][$key2['id']]['jml_siswa'];
														}?> </td>
														
													</tr>
													<?php }?>
													
													<tr>
														<td> <b>Keterangan</b> </td>
														<td> : </td>
														<td > <?=$key2['keterangan']?> </td>
														
													</tr>
												</table>
												
												
											</div>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
		
		<?php	} 
			} 
		}?>
<script>
	function call() {
		window.location = "<?=base_url()?>laporan/lap_jurnal_guru?tanggal="+document.getElementById("tanggal").value
		+"&kelas="+document.getElementById("kelas_id").value;
	}
	
</script>				
		