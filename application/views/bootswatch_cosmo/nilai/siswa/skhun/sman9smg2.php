
<style type="text/css">
<!--
.style3 {font-size: 11px}
-->
/*
#halaman {
height:1500px;
}*/
@page {
	 	/* POLIO*/
        sheet-size: 210mm 297mm ;
        margin: 0px 50px 0px 50px;
    }

.style7 {font-size: 11px; font-weight: bold; }
.style8 {font-size: 11px}
.style11 {font-size: 12px}
.style13 {
	font-size: 24px;
	font-weight: bold;
}
.style17 {font-size: 11px}
.style18 {font-size: 18px}
.style19 {font-size: 16px}

.style14bu {
	font-size: 14px; 
	font-weight: bold; 
	text-decoration: underline;
}

.style14 {
	font-size: 14px; 
	padding:2px 4px 2px 4px;
}

.style14b {
	font-size: 14px; 
	font-weight: bold; 
}

.style110 { 
	padding:2px 2px 2px 2px;
	font-size: 14px;  
	}

#content1{
		line-height: 110%;
    text-align: justify;
    text-justify: inter-word;
	margin-left:30px;
	margin-right:30px
	}
#content1 h3{
line-height: 260%;
}

</style>
<?php 
$ta_thun = $row["ta_nama"];
$sekolah_nama = "SEKOLAH MENENGAH ATAS  NEGERI  9  SEMARANG";
$alamat = "Jl Cemara Raya Padangsari Banyumanik Semarang 50267 Telepone (024)7472812<br>
Website : http://www.sma9-smg.sch.id  &nbsp;&nbsp;  Email : smu092001@yahoo.com.";

$nomor_surat			= "421.3 / 185 / 2020";
$tanggal_mutasi 		= "2 Mei 2020";
$nama_sekolah_lengkap 	= "Sekolah Menengah Atas Negeri 9 Kota Semarang";
$nama_sekolah_singkat 	= "SMA Negeri 9 Kota Semarang";
$kepala_sekolah 		= "Drs. Khoirul Imdad, Ed. M";
$kepala_sekolah_nip 	= "NIP. 19600618 198603 1 010";

/*if($row['siswa_id'] == 3905){
	$ket_lulus = 'harap menghubungi kepala sekolah';
}*/

if (strpos($row['kelas_nama'], 'IPA') !== false){
	$jurusan = "MATEMATIKA DAN ILMU PENGETAHUAN ALAM";
	//$sjurusan = "MIPA";
}else{
	$jurusan = "ILMU PENGETAHUAN SOSIAL";
	//$sjurusan = "IPS";
}



foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];

	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div class="page" id="page-1" >';	
?>	
		
<table border="0" style="width: 100%;">
<tr>
    <td width="13%" align="center" valign="top"><img src="<?=APP_ROOT?>/images/logo/logo-jawa-tengah3.png" width="70" /> </td>
	<td  align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH PROVINSI JAWA TENGAH<br />
      DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
      <span class="style18"><?=strtoupper($sekolah_nama)?></span><br />
      <span class="style17"><?=$alamat?></span></td>
	<td width="13%" align="center" valign="top"><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/SMAN_9_Semarang.jpg" width="50" /> </td>
  </tr>
  <tr>

    <td colspan="3" valign="top" style="border-top:solid; border-top-width:2;  padding-top:-6; padding-bottom:8px">
	<strong></strong></td>
  </tr><tr>
	<td colspan="3" valign="top" style="border-top:solid; border-top-width:3;  ">
	</td>
  </tr>

</table>
<br>
<div id="content1" style=" padding-top:-20px;">
			
			<div align="center" width="100%" class="style14bu">
				SURAT KETERANGAN LULUS
				</div>
			<div align="center" width="100%">	
				NOMOR : <?=$nomor_surat?>
			</div>
			
			
			<div align="center" width="100%" class="style14b" style="padding-top:10px">
				SMA NEGERI 9 SEMARANG
				</div>
			<div align="center" width="100%" class="style14b">
				PEMINATAN : <?=strtoupper($jurusan)?>
				</div>
			<div align="center" width="100%" class="style14b">
				TAHUN PELAJARAN <?=$row['ta_nama']?>
				</div>
			
			<div style=" padding-top:10px;">			
                Yang bertanda tangan di bawah ini, Kepala <?=$nama_sekolah_lengkap?>, Provinsi Jawa Tengah menerangkan bahwa: 
				</div>	
               <table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-top:5px; padding-bottom:5px">
				
				<tr>
					<td class="style110" width="40%">Nama</td>
					<td class="style110" width="2px">:</td>
					<td class="style110"><?php echo strtoupper($row_per_siswa["siswa_nama"]); ?></td>
				</tr>
				<tr>
					<td class="style110">Tempat dan Tanggal Lahir</td>
					<td class="style110">:</td>
					<td class="style110"><?php echo strtoupper($row_per_siswa['lahir_tempat']); ?> , <?php echo strtoupper(tanggal($row_per_siswa['lahir_tgl'])); ?></td>
				</tr>
				<tr>
					<td class="style110">Nama Orang Tua</td>
					<td class="style110">:</td>
					<td class="style110"><?php 
						if($row_per_siswa['ayah_nama']!=''){
							echo strtoupper($row_per_siswa['ayah_nama']); 
						}else{ 
							echo strtoupper($row_per_siswa['ibu_nama']); 
						}?></td>
				</tr>
				<tr>
					<td class="style110">Nomor Induk Siswa</td>
					<td class="style110">:</td>
					<td class="style110"><?php echo $row_per_siswa['siswa_nis']; ?></td>
				</tr>
				<tr>
					<td class="style110">Nomor Induk Siswa Nasional</td>
					<td class="style110">:</td>
					<td class="style110"><?php echo $row_per_siswa['siswa_nisn']; ?></td>
				</tr>
				
			</table>
			
			dinyatakan <b>LULUS</b> dari satuan pendidikan berdasarkan kriteria kelulusan <?=$nama_sekolah_singkat?> 
			Tahun Pelajaran <?=$row['ta_nama']?>, dengan nilai sebagai berikut:
			
			<table width="100%" style="padding-top:3px; padding-bottom:3px">
				<tr>
					<td width="2%"></td>
					<td>
				
						
						<table border="1" cellpadding="0" cellspacing="0" width="100%" >
							<tr>
								<th width="5%"  class="style14" align="center">NO</th>
								<th width="60%" class="style14">MATA PELAJARAN</th>
								<th  class="style14">NILAI UJIAN<br>SEKOLAH</th>
							</tr>
							
								<?php
								$mp_no = 0;
								$jml_nrata	= 0;
								$jml_us	= 0;
								$jml_ns	= 0;
								
								$jml_mapel=0;
								foreach ($resultset['data'] as $idx => $item): 
									$jml_mapel++;
									$item['skhun_nrata'] 	= round($item['skhun_nrata']);
									$item['skhun_us']		= round($item['skhun_us']);
									$item['skhun_ns']		= round($item['skhun_ns']);
									$jml_nrata	= $jml_nrata + $item['skhun_nrata'];
									$jml_us		= $jml_us + $item['skhun_us'];
									$jml_ns		= $jml_ns + $item['skhun_ns'];
									
									if ($item['kategori_nama'] != $ktg_nama)
									{
										$ktg_ascii++;
										
										echo '<tr>';
					
										if ($item['kategori_kode'] == "KelC")
										{
					
											$minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
					
											echo'<td colspan="3" valign="top"  class="style14" align="left"><b>Kelompok C (Peminatan)</b></td>';
											$mp_no = 0;
										}
										else if ($item['kategori_kode'] == 'KelD')
										{
											$mp_no++;
											echo'<td valign="middle" class="style14" align="right">'.$mp_no.'.</td>
												<td valign="top"  class="style14" align="left">
												Pilihan Lintas Minat/Pendalaman Minat</td>
												<td valign="top" class="style14" align="center"></td>';
										}
										else
										{
											echo'<td colspan="3" valign="top"  class="style14" align="left"><b>'.$item['kategori_nama'].'</b></td>';
											$mp_no = 0;
						
										}
										echo '</tr>';
										$ktg_nama = $item['kategori_nama'];
									}
									$mp_no++;
									
									// additional
									if (strpos($item['mapel_nama'], 'Jepang') !== false) {
										$item['mapel_nama'] = 'Bahasa dan Sastra Jepang';
									}
									
									if ($item['kategori_kode'] == 'KelD'){
										?>
										<tr>
											<td valign="middle" class="style14" align="right"></td>
											<td valign="top"  class="style14" align="left">
											- <?=$item['mapel_nama']; ?></td>
													
											
											<td valign="top" class="style14" align="center"><?=number_format($item['skhun_us'],0); ?></td>
										</tr>
										<?php 
									}else{
										?>
										<tr>
											<td valign="middle" class="style14" align="right"><?php echo $mp_no; ?>.</td>
											<td valign="top"  class="style14" align="left">
											<?=$item['mapel_nama']; ?></td>
													
											
											<td valign="top" class="style14" align="center"><?=number_format($item['skhun_us'],0); ?></td>
										</tr>
										<?php 
									}
							endforeach; 
							
							$rata_nrata = round($jml_nrata / $jml_mapel);
							$rata_us 	= round($jml_us / $jml_mapel,2);
							$rata_ns 	= round($jml_ns / $jml_mapel);
							?>
							<tr>
								<td valign="middle" class="style14" align="right" colspan="2">Rata - Rata</td>
								
								<td valign="middle" class="style14" align="center" >
									<?=number_format($rata_us,2)?></td>
								
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			Surat Keterangan Lulus ini berlaku sementara sampai dengan diterbitkannya Ijazah Tahun Pelajaran <?=$row['ta_nama']?> , 
			untuk menjadikan maklum bagi yang berkepentingan.
			<br><br>
			<table border="0" style="width: 100%; padding-top:5px; ">
				<tr>
					<td width="40%" align="center" valign="top">
					</td>
					<td width="18%" align="center" valign="top" style="padding: 10" >
						<table border="1" cellpadding="0" cellspacing="0" width="100%" height="100%">
							<tr>
								<td valign="middle" align="center">
								<br><br>
								Pas FOTO <br>3 x 4
								<br><br><br><br>
								</td>
							</tr>
						</table>
					</td>
					<td width="7%" align="center" valign="top">
					</td>
					<td valign="top">
						Semarang, <?php echo $tanggal_mutasi; ?><br/>
						KEPALA SEKOLAH <br/>
					
						<br/><br/><br/>
						<u><?=$kepala_sekolah?>	  </u><br/>
						<?=$kepala_sekolah_nip?></p>    
					</td>
				</tr>
			</table>
	</div>
 

</div>
<?php }?>