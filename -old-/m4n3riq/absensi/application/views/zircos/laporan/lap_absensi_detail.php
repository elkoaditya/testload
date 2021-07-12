<?php 
	/// CEK SISWA
	$login_siswa=0;
	if(isset( $this->session->userdata['user']['no_peserta'])){
		$data_siswa ='';
		if(isset($data['data_siswa']['data'])){
			$data_siswa = $data['data_siswa']['data'];
		}
		cek_siswa_bersangkutan( $this->session->userdata['user']['id'], $data_siswa);
		
		$login_siswa=1;
	}
	
	$array_alfabet = array(
		1 => 'a',
		2 => 'b',
		3 => 'c',
		4 => 'd',
		5 => 'e',
	);
	$array_identitas1 = array(
		'a. Nama Lengkap' 			=> 'siswa_nama',
		'b. No Peserta' 			=> 'siswa_no_peserta',
		'c. Peminatan'				=> 'siswa_peminatan',
		'd. Mapel Lintas Minat'		=> 'siswa_lintas_minat',
		'e. Jenis Kelamin'			=> 'siswa_jenis_kelamin',
		'f. NISN'					=> 'siswa_nisn',
		'g. NIK'					=> 'siswa_nik',
		'h. Tempat, Tanggal Lahir'	=> 'siswa_tempat_lahir',
		'i. Agama'					=> 'siswa_agama',
		'j. Golongan Darah'			=> 'siswa_gol_darah',
		'k. No. Telp./HP'			=> 'siswa_telepon_anak',
		'l. Nilai Ujian Nasional'	=> 'nilai',
		'm. Catatan Prestasi'		=> 'prestasi',
		'n. Riwayat Beasiswa' 		=> 'siswa_beasiswa_nama',
		'o. Status Tempat Tinggal' 	=> 'siswa_status_tinggal',
		'p. Alamat Tempat Tinggal' 	=> 'alamat',
	);
	
	$array_nilai = array(
		'Bhs. Indonesia' 			=> 'siswa_nilai_ind',
		'Matematika' 				=> 'siswa_nilai_mat',
		'IPA' 						=> 'siswa_nilai_ipa',
		'Bhs. Inggris' 				=> 'siswa_nilai_ing',
	);
	
	$array_identitas2 = array(
		'1. Nama Jalan/Dusun' 		=> 'siswa_alamat_anak',
		'2. Desa/Kelurahan' 		=> 'siswa_kelurahan_anak',
		'3. Kecamatan' 				=> 'siswa_kecamatan_anak',
		'4. Kode Pos' 				=> 'siswa_kode_pos_anak',
		'5. Kab./Kota' 				=> 'siswa_kota_anak',
		'6. Provinsi' 				=> 'siswa_provinsi_anak',
	);
	
	$array_ortu['a. Ayah'] = array(
		'1. Nama Ayah' 				=> 'siswa_ayah_nama',
		'2. Pekerjaan' 				=> 'siswa_ayah_pekerjaan',
		'3. No. Telp./HP' 			=> 'siswa_ayah_telepon',
		'4. Alamat Kantor' 			=> 'siswa_ayah_alamat_kantor',
		'5. Gaji (Penghasilan)/bln' 	=> 'siswa_ayah_gaji',
	);
	
	$array_ortu['b. Ibu'] = array(
		'1. Nama Ibu' 				=> 'siswa_ibu_nama',
		'2. Pekerjaan' 				=> 'siswa_ibu_pekerjaan',
		'3. No. Telp./HP' 			=> 'siswa_ibu_telepon',
		'4. Alamat Kantor' 			=> 'siswa_ibu_alamat_kantor',
		'5. Gaji (Penghasilan)/bln' 	=> 'siswa_ibu_gaji',
	);
	
	$array_ortu['c. Wali'] = array(
		'1. Nama Wali' 				=> 'siswa_wali_nama',
		'2. Alamat' 					=> 'siswa_wali_alamat',
		'3. Pekerjaan' 				=> 'siswa_wali_pekerjaan',
		'4. No. Telp./HP' 			=> 'siswa_wali_telepon',
		'5. Alamat Kantor' 			=> 'siswa_wali_alamat_kantor',
		'6. Gaji (Penghasilan)/bln' 	=> 'siswa_wali_gaji',
	);
	/*
	$detail = array(
			//'siswa_no_daftar'		=> 'Nomor Pendaftaran',
			'siswa_no_peserta'		=> 'Nomor Peserta',
			'siswa_nisn' 			=> 'NISN',
			'siswa_nama'			=> 'Nama Lengkap Siswa',
			'siswa_tempat_lahir' 	=> 'Tempat Lahir',
			'siswa_tanggal_lahir' 	=> 'Tanggal Lahir',
			'siswa_jenis_kelamin' 	=> 'Jenis Kelamin',
			'siswa_agama'			=> 'Agama',
			'siswa_kewarganegaraan'	=> 'Kewarganegaraan',
			'siswa_status_keluarga' => 'Status Dalam Keluarga',
			'siswa_anak_ke' 		=> 'Anak Ke',
			'siswa_alamat_anak' 	=> 'Alamat Siswa',
			'siswa_telepon_anak' 	=> 'Telepon Siswa',
			'siswa_sekolah_asal' 	=> 'Sekolah Asal Siswa',
			
			
			
			
			'siswa_ayah_nama' 		=> 'Nama Lengkap Ayah',
			'siswa_ayah_pekerjaan' 	=> 'Pekerjaan Ayah',
			
			'siswa_ibu_nama' 		=> 'Nama Lengkap Ibu',
			'siswa_ibu_pekerjaan' 	=> 'Pekerjaan Ibu',
			
			//'siswa_ortu_alamat' 	=> 'Alamat Orang Tua',
			//'siswa_ortu_telepon' 	=> 'Telepon Orang Tua',
			
			
			'siswa_wali_nama' 		=> 'Nama Lengkap Wali',
			'siswa_wali_alamat'		=> 'Alamat Wali',
			'siswa_wali_telepon' 	=> 'Telepon Wali',
			'siswa_wali_pekerjaan' 	=> 'Pekerjaan Wali',
			'siswa_created_time'	=> 'Waktu Ditambahkan',
			'siswa_modified_time'	=> 'Waktu Diubah Terakhir',
			//'modified_username'		=> 'User Menambahkan',
	)*/
	
	$jml_kosong =0;
	$char='';
	$data_siswa = $data['data_siswa']['data'];
	foreach($data_siswa as $value_ds=>$ds){
		foreach($ds as $cek_value){
			//echo $ds;
			if($cek_value == ''){
				$char = $ds;
				$jml_kosong++;
			}
		}
	}
?>
<div class="wrapper">
	<div class="container" style="margin-top:-40px">

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							<li >
								 <a href="<?=base_url();?>/data/siswa">SISWA</a>
							</li>
							<li class="active">
								Detail SISWA 
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Detail SISWA </h4><?php //echo $jml_kosong; print_r($char);?>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		

			<div class="row">
				<div class="col-md-4">
				<?php
				if($login_siswa==0){ ?>
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa"><i class="fa fa-chevron-left"></i> Kembali</a>
				<?php }else{?>
				<div style="color:red" ><b>Silahkan "EDIT IDENTITAS & ANGKET" terlebih dahulu SEBELUM "PRINT LAMPIRAN"</b></div> 
				<?php }?>
				</div>
				
				<div class="col-md-8" align="right">
					<a class="btn btn-warning waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa/edit/<?=$data['id']?>">
					<i class="fa fa-pencil"></i> Edit Identitas & Angket</a>
					<?php
					$disabled = "";
					if($jml_kosong>20){
						$disabled = "disabled";
					}?>
					<a class="btn btn-purple  waves-effect w-md waves-light <?=$disabled?> m-b-5" href="<?=base_url();?>data/siswa/print_surat/<?=$data['id']?>"
					target="_blank"><i class="fa fa-print"></i> Print Lampiran</a>
				</div>
				
				
				
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
					
					<div class="row">
						<div class="col-md-12">
							&nbsp;&nbsp;<h5> <b>I.IDENTITAS PESERTA DIDIK<b></h5>
						</div>
					<?php
					
					foreach($data['data_siswa']['data'] as $value_di=>$key){
						//////////////// ANGGOTA /////////
						foreach($array_identitas1 as  $nama => $value){
						?>
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-3">
								<p><b><?=$nama?></b></p>
							</div>
							<div class="col-md-8">
								<p>
								
								<?php 
								if($value == 'nilai'){
									?>
									</div></div>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-10">
									<table id="datatable-buttons" class="table table-striped table-bordered">
										<tr>
											<td width='5%'><b>No.</b></td>
											<td width='18%'><b>Mata Pelajaran</b></td>
											<td><b>Nilai(<i>Angka,Terbilang</i>)</b></td>
										</tr>
										<?php
										$no = 0;												
										foreach($array_nilai as $label_nilai => $value_nilai){
											$no++;
											?>
											<tr>
												<td><?=$no?></td>
												<td><?=$label_nilai?></td>
												<td align="left" style="padding-left:10px"><?=$key[$value_nilai]?> , <?=ucwords(terbilang_koma($key[$value_nilai]))?></td>
											</tr>
										<?php 
										}?>
									</table>
									<?php
								}elseif($value == 'prestasi'){
									?>
									</div></div>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-10">
									<table id="datatable-buttons" class="table table-striped table-bordered">
										<tr>
											<td width='5%'><b>No.</b></td>
											<td width='18%'><b>Tingkat</b></td>
											<td><b>Nama Kegiatan Lomba</b></td>
											<td width='10%'><b>Juara</b></td>
											<td width='12%'><b>Tahun</b></td>
										</tr>
										<?php
										$no = 0;		
										if(isset($data['data_siswa_prestasi']['data'])){
											foreach($data['data_siswa_prestasi']['data'] as $value_prestasi=>$key_prestasi){
												$no++;
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$key_prestasi['prestasi_tingkat']?></td>
													<td><?=$key_prestasi['prestasi_nama']?></td>
													<td><?=$key_prestasi['prestasi_juara']?></td>
													<td><?=$key_prestasi['prestasi_tahun']?></td>
												</tr>
											<?php 
											}
										}
										
										$x=$no;
										while($x<2){
											$x++;
											?>
											<tr>
												<td><?=$x?></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										<?php 
										}
										
										?>
									</table>
									
									<?php
								}elseif($value == 'alamat'){ ?>
								</div></div>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-10">
								<?php
									foreach($array_identitas2 as  $nama => $value){?>
										<div class="row">
											
											<div class="col-md-3">
												<p><b><?=$nama?></b></p>
											</div>
											<div class="col-md-9">
												<?php 
												if($key[$value] == "")
													echo "-";
												else
													echo nl2br($key[$value]);
												?>
											</div>
										</div>
									<?php } ?>
								
									<?php	
								}else{
									if($value=='siswa_beasiswa_nama'){
										if($key['siswa_beasiswa_tahun']!="0000"){
											$key[$value] = $key[$value].' Tahun ' .$key['siswa_beasiswa_tahun'];
										}
									}
									if (strpos($value, 'gaji') !== false) {
										$key[$value] = buatrp_new($key[$value]);
									}
									
									if($key[$value] == "")
										echo "-";
									else
										echo nl2br($key[$value]);
								}?>
								</p>
							</div>
						</div>
				<?php 	}	?>
				
						<div class="col-md-12">
							&nbsp;&nbsp;<h5> <b>II.IDENTITAS ORANG TUA / WALI<b></h5>
						</div>
							<?php foreach($array_ortu as $label_ortu => $value_ortu){?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11">
										&nbsp;&nbsp;<h5> <b><?=$label_ortu?><b></h5>
									</div>
								</div>
								<?php
								foreach($value_ortu as  $nama => $value){
									
									if (strpos($value, 'gaji') !== false) {
										
										$key[$value] = buatrp_new($key[$value]);
									}
									?>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-3">
											<p><b><?=$nama?></b></p>
										</div>
										<div class="col-md-7">	
										<?php	
											if($key[$value] == "")
												echo "-";
											else
												echo nl2br($key[$value]);
											?>
										</div>
									</div>
									<?php
								}	
							}?>
							
						<div class="col-md-12">
							&nbsp;&nbsp;<h5> <b>III.Hasil Angket<b></h5>
						</div>	
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-11">
									&nbsp;&nbsp;<h5> <b>Yang dilakukan setelah Lulus (hanya 1 opsi yang diambil)<b></h5>
								</div>
							</div>
							<?php
							$jml=0;
							if($key['siswa_setelah_lulus_lainya']!=''){
								$jml++; ?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11"><b> <?=$key['siswa_setelah_lulus_lainya']?></b></div>
								</div>
								<?php
							}elseif($key['siswa_setelah_lulus_id']>0){
								$jml++; ?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11"><b> <?=$key['siswa_setelah_lulus']?></b></div>
								</div>
								<?php
							} ?>
							
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-11">
									&nbsp;&nbsp;<h5> <b>Alasan memilih bersekolah di SMAN 1 Semarang (boleh dipilih lebih dari satu)<b></h5>
								</div>
							</div>
							
							<?php
							$jml=0;
							if(isset($data['data_siswa_alasan_sekolah']['data'] )){
								foreach($data['data_siswa_alasan_sekolah']['data'] as $value_alasan_sekolah=>$key_alasan_sekolah){
									$jml++; ?>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-11"><b><?=$jml?>. <?=$key_alasan_sekolah['alasan_sekolah_nama']?></b></div>
									</div>
									<?php
								}
							}
							
							if($key['siswa_alasan_sekolah']!=''){
								$jml++; ?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11"><b><?=$jml?>. <?=$key['siswa_alasan_sekolah']?></b></div>
								</div>
								<?php }
							?>
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-11">
									&nbsp;&nbsp;<h5> <b>Seandainya melanjutkan studi di perguruan tinggi saya bercita - cita kuliah di :<b></h5>
								</div>
							</div>
							<?php
			
							$jml=0;
							if(isset($data['data_siswa_kuliah']['data'] )){
								foreach($data['data_siswa_kuliah']['data'] as $value_kuliah=>$key_kuliah){
									$jml++; ?>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-11"><?=$array_alfabet[$jml]?>. Perguruan Tinggi <b><?=$key_kuliah['kuliah_nama']?></b> jurusan  <b><?=$key_kuliah['kuliah_jurusan']?></b></div>
									</div>
									<?php
								}
							}
							while($jml<KULIAH)
							{
								$jml++; ?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11"><?=$array_alfabet[$jml]?>. Perguruan Tinggi ................. jurusan .................</div>
								</div>
								<?php
							}?>
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-11">
									&nbsp;&nbsp;<h5> <b>Seandainya saya bekerja, pekerjaan yang saya cita - citakan adalah :<b></h5>
								</div>
							</div>
							<?php
							$jml=0;
							if(isset($data['data_siswa_kerja']['data'] )){
								foreach($data['data_siswa_kerja']['data'] as $value_kerja=>$key_kerja){
									$jml++; ?>
									<div class="row">
										<div class="col-md-1"></div>
										<div class="col-md-11"><b><?=$array_alfabet[$jml]?>. Di <b><?=$key_kerja['kerja_nama']?></b> sebagai  <b><?=$key_kerja['kerja_jabatan']?></b></div>
									</div>
									<?php
								}
							}
							
							while($jml<KERJA)
							{
								$jml++; ?>
								<div class="row">
									<div class="col-md-1"></div>
									<div class="col-md-11"><b><?=$array_alfabet[$jml]?>. Di ................. sebagai .................</div>
								</div>
								<?php
							}?>
							
							
						<?php 
					}?>
					<br>
											
						<!-- MODAL DELETE-->
						<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
							<form action="<?=base_url();?>data/siswa/delete" id="form_sample_1" class="form-horizontal" method="POST">
								<input type="hidden" name="siswa_id" value="<?=$data['id']?>"/>
						
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title"><b>DELETE</b></h4>
										</div>
										<div class="modal-body"> Yakin hapus <b><?=$key['siswa_nama']?></b></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default btn-rounded w-md waves-effect m-b-5" data-dismiss="modal">Cancel</button>
											<button type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5">OK</button>
										</div>
									</div>
								</div>
								
							</form>
							<!-- /.modal-dialog -->
						</div>
						<!-- MODAL DELETE-->
					</div>
				<!-- END FORM-->
				</div>	
			</div>
                                

                     
