<?php
	$array_identitas1 = array(
		'a. Nama Lengkap' 			=> 'siswa_nama',
		'b. No PPDB' 				=> 'siswa_no_peserta',
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
		'5. Kab./Kota' 					=> 'siswa_kota_anak',
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
?>



	<?php		
	foreach($data['data_siswa']['data'] as $value_di=>$key){
		$page_break = '';
		
			//$page_break = 'class="page-notend"';
		
		?>
	
		<div class="page-notend">
			
			
			<table style="width: 100%;">
				<tr>
					<td align="right" width="12%">
						<img src="<?=base_url()?>content/images/logo-jawa-tengah3.png" width="50px"><br>
					</td>
					<td align="center" >
						
						<div class="header1 ">
							<div class="style12" >
								PEMERINTAH PROVINSI JAWA TENGAH
							</div>
							<div class="style14" >
								DINAS PENDIDIKAN DAN KEBUDAYAAN
							</div>
							<div class="style16b" >
								SEKOLAH MENENGAH ATAS NEGERI 1 SEMARANG
							</div>
						</div>
						<div class="style9" >
						Jalan Taman Menteri Supeno No. 1 Semarang 50243 Telp.(024)8310447-8318539 Fax.(024)8414851 E-mail:sma1semarang@yahoo.co.id
						</div>
					</td>
					
				</tr>
				<tr>

					<td colspan="2" valign="top" style="border-top:solid; border-top-width:2; padding-top:-8" align="center" ><strong><hr></strong>
					<b>FORMULIR DAFTAR ULANG PESERTA DIDIK BARU TAHUN PELAJARAN 2018/2019</b></td>
				  </tr>
			</table>
			
			
			<table  style="width: 100%;">
				<tr>
					<td colspan="2" align="left"><b>I.IDENTITAS PESERTA DIDIK</b></td>
					
				</tr>
				<tr>
					<th width="3%"></th>
					<th >
						<table style="width: 100%;">
							<?php foreach($array_identitas1 as $label => $value){?>
								<?php
								if($value == 'nilai'){?>
									<tr>
										<td align="left" colspan="2" ><?=$label?></td>
										<td width='2%'>:</td>
										<td align="left" width='75%'> </td>
									</tr>
						</table>
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="6%"></th>
					<th >
						<table border='1' cellspacing='0' cellpadding='0' width='100%' style="margin-top:-8px; margin-bottom:-8px">
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
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="3%"></th>
					<th >
						<table style="width: 100%;">
						
								<?php		
								}elseif($value == 'prestasi'){?>
									<tr>
										<td align="left" colspan="2" ><?=$label?></td>
										<td width='2%'>:</td>
										<td align="left" width='75%'> </td>
									</tr>
						</table>
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="6%"></th>
					<th >
						<table border='1' cellspacing='0' cellpadding='0' width='100%' style="margin-top:-8px; margin-bottom:-8px">
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
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="3%"></th>
					<th >
						<table style="width: 100%;">
						
						<?php		
								}elseif($value == 'siswa_beasiswa_nama'){?>
						
						</table>
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="3%"></th>
					<th>
						<table style="width: 100%; margin-bottom:-8px">
							<tr>
								<td align="left" ><?=$label?></td>
								<td width='2%'>:</td>
								<td align="left" width='50%' class="line_bottom"> <?=strtoupper($key[$value])?></td>
								<td width='8%'>Tahun</td>
								<td width='2%'>:</td>
								<td align="left" width='15%' class="line_bottom"> <?=strtoupper($key['siswa_beasiswa_tahun'])?></td>
							</tr>
						</table>
					</th>
				</tr>
			</table>
			
			<table  style="width: 100%;">
				<tr>
					<th width="3%"></th>
					<th >
						<table style="width: 100%;">
							<?php		
								}elseif($value == 'alamat'){?>
								<tr>
										<td align="left" colspan="2" ><?=$label?></td>
										<td width='2%'>:</td>
										<td align="left" width='75%' > </td>
									</tr>
								<?php		
								}else{
									if($value == 'siswa_jenis_kelamin'){
										if($key['siswa_jenis_kelamin']=='L'){
											$key['siswa_jenis_kelamin'] = "Laki-laki";
										}elseif($key['siswa_jenis_kelamin']=='P'){
											$key['siswa_jenis_kelamin'] = "Perempuan";
										}
									}elseif($value == 'siswa_tempat_lahir'){
										//$key['siswa_tempat_lahir'] = $key['siswa_tempat_lahir'].' , '.tgl_resmi($key['siswa_tanggal_lahir']);
										$key['siswa_tempat_lahir'] = $key['siswa_tempat_lahir'].' , '.$key['siswa_tanggal_lahir'];
									}
									
									?>
									<tr>
										<td align="left" colspan="2" ><?=$label?></td>
										<td width='2%'>:</td>
										<td align="left" width='75%' class="line_bottom"> <?=strtoupper($key[$value])?></td>
									</tr>
								<?php }
							}?>
							
							
							<?php foreach($array_identitas2 as $label => $value){?>
							<tr>
								<td width='3%'></td>
								<td align="left">
									<?=$label?>
								</td>
								<td width='2%'>:</td>
								<td align="left" width='75%' class="line_bottom"> <?=strtoupper($key[$value])?></td>
							</tr>
							<?php }?>
							
						</table>
					</th>
				</tr>
				<tr>
					<td colspan="2" align="left"><b>II.IDENTITAS ORANG TUA / WALI</b></td>
					
				</tr>
				<tr>
					<th width="3%"></th>
					<th>
						<table style="width: 100%;">
							<?php foreach($array_ortu as $label_ortu => $value_ortu){?>
							<tr>
								<td align="left" colspan="2" ><?=$label_ortu?></td>
								<td align="left" width='75%'></td>
							</tr>
								<?php foreach($value_ortu as $label => $value){
									if (strpos($value, 'gaji') !== false) {
										
										$key[$value] = buatrp_new($key[$value]);
									}
									?>
								<tr>
									<td width='3%'></td>
									<td align="left">
										<?=$label?>
									</td>
									<td width='2%'>:</td>
									<td align="left" width='75%' class="line_bottom"> <?=strtoupper($key[$value])?></td>
								</tr>
								<?php }
							}?>
						</table>
					</th>
				</tr>
			</table>
		
			
			<table style="width: 100%;" >
				<tr>	
					<td width="8%"></td>
					<td width="30%" align="center" >
						<br/>
						Mengetahui,<br/>
						Orangtua/wali
						<br/><br/><br/>
						<table width="100%">
							<tr>
								<td class="line_bottom"><br></td>
							</tr>
						</table>
					</td>
					<td ></td>
					<td width="40%" align="center"  >
						Semarang , <?=tgl_resmi(date("d-m-Y"))?>
						<br/>
						Peserta Didik Baru
						<br/><br/><br/><br/>
						
						<table width="75%">
							<tr>
								<td class="line_bottom"><?=strtoupper($key['siswa_nama'])?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<!--
			<table style="width: 100%;" >
				<tr>
					<td> Tanggal Cetak : <?=date("d-m-Y H:i")?> WIB | Untuk Peserta Didik</td>
				</tr>
			</table>-->
			
	<?php
	}?>
	</div>
	

