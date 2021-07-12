<?php
	$array_alfabet = array(
		1 => 'a',
		2 => 'b',
		3 => 'c',
		4 => 'd',
		5 => 'e',
	);
			
	foreach($data['data_siswa']['data'] as $value_di=>$key){
		$value_angket = $key;
	}
	
	$header = '
		<table style="width: 100%;">
			<tr>
				<td align="right" width="12%">
					<img src="'.base_url().'content/images/logo-jawa-tengah3.png" width="60px"><br>
				</td>
				<td align="center" >
					
					<div class="header1 ">
						<div class="style14" >
							PEMERINTAH PROVINSI JAWA TENGAH
						</div>
						<div class="style16" >
							DINAS PENDIDIKAN DAN KEBUDAYAAN
						</div>
						<div class="style18b" >
							SEKOLAH MENENGAH ATAS NEGERI 1 SEMARANG
						</div>
					</div>
					<div class="style11" >
					Jalan Taman Menteri Supeno No. 1 Semarang 50243 
					</div>
					<div class="style12" >
					Telp.(024)8310447 - 8318539, Fax.(024)8414851 E-mail:sman1semarang@yahoo.co.id
					</div>
				</td>
				
			</tr>
			<tr>

				<td colspan="2" valign="top" style="border-top:solid; border-top-width:4; padding-top:-8" align="center" ><strong><hr></strong>
				</td>
			  </tr>
		</table>
	';
?>

	
	<div class="page-notend" style="margin: 0px 45px 20px 45px; padding-top:60px">
			
			<?=$header?>
			<table style="width: 100%;">
				<tr>
					<td class="style14" align="left" width="12%">Nomor</td>
					<td class="style14" align="left" width="2%">:</td>
					<td class="style14" align="left" width="50%">422/492/VII/2018</td>
					<td class="style14" align="left" colspan="2">Semarang, 3 Juli 2018</td>
				</tr>
				<tr>
					<td class="style14" align="left" >Lampiran</td>
					<td class="style14" align="left" >:</td>
					<td class="style14" align="left">1 (satu) berkas</td>
					<td class="style14" align="left" colspan="2"></td>
				</tr>
				<tr>
					<td class="style14" align="left" >Hal</td>
					<td class="style14" align="left" >:</td>
					<td class="style14" align="left" ><b>Pemberitahuan Pengisian Lintas Minat<br/><br/></b></td>
					<td class="style14" align="left" colspan="2"></td>
				</tr>
				<tr>
					<td class="style14" align="left" colspan="3"></td>
					<td class="style14" align="left" width="6%">Yth.</td>
					<td class="style14" align="left" >Bapak/Ibu Wali Siswa Kelas X</td>
				</tr>
				<tr>
					<td class="style14" align="left" colspan="4"></td>
					<td class="style14" align="left" >SMA Negeri 1 Semarang</td>
				</tr>
				<tr>
					<td class="style14" align="left" colspan="3"></td>
					<td class="style14" align="left" >Di</td>
					<td class="style14" align="left" >Tempat</td>
				</tr>
			</table>
			<br/>
			Dengan Hormat<br/>
			Berdasarkan:
			<table style="width: 100%;">
				<tr>
					<td width="5%" align="left" class="style14">1.</td>
					<td align="left" class="style14"> Permendikbud No. 59 tahun 2014 tentang Kurikulum SMA/MA,</td>
				</tr>
				<tr>
					<td class="style14">2.</td>
					<td class="style14"> Permendikbud No. 64 tahun 2014 tentang Peminatan pada Pendidikan Menengah,</td>
				</tr>
				<tr>
					<td class="style14">3.</td>
					<td class="style14"> Permendikbud No. 20 tahun 2016 tentang Standar Kompetensi Lulusan,</td>
				</tr>
				<tr>
					<td class="style14">4.</td>
					<td class="style14"> Permendikbud No. 21 tahun 2016 tentang Standar Isi,</td>
				</tr>
				<tr>
					<td class="style14">5.</td>
					<td class="style14"> Permendikbud No. 22 tahun 2016 tentang Standar Proses Pendidikan,</td>
				</tr>
				<tr>
					<td class="style14">6.</td>
					<td class="style14"> Permendikbud No. 23 tahun 2016 tentang Standar Penilaian Pendidikan,</td>
				</tr>
				<tr>
					<td class="style14">7.</td>
					<td class="style14"> Permendikbud No. 24 tahun 2016 tentang Kompetensi Inti dan Kompetensi Dasar,</td>
				</tr>
			</table>
			<p class="text2" style="line-height: 25px;">
			maka Sekolah wajib melaksanakan Pengelompokan Rombongan Belajar (Rombel) berdasarkan<br>
			<b>LINTAS PEMINATAN</b> sejak kelas X.<br><br>
			Peserta didik mengikuti mata pelajaran peminatan yang sama sejak kelas X sampai kelas XII,
			dengan cara memilih kelompok mata pelajaran, yakni Peminatan Matematika dan Ilmu
			Pengetahuan Alam (MIPA), dan Ilmu Pengetahuan Sosial (IPS). Adapun untuk mata pelajaran
			Lintas Peminatan, peserta didik menempuh 2 (dua) mata pelajaran. Peserta didik dan orang tua 
			memilih mata pelajaran lintas peminatan dengan mengisi angket yang telah disediakan (terlampir).
			<br><br>
			Demikian pemberitahuan ini kami sampaikan, dan atas kerjasamanya kami ucapkan terimakasih.
			</p><br/>
			<table style="width: 100%;" >
				<tr>	
					
					<td width="60%"></td>
					<td align="right" width="100%">
					<img src="<?=base_url();?>content/images/ttd_kepsek1.PNG" width="480px"><br>
				</td>
				<!--	<td align="left" class="style14">
						Kepala Sekolah
						<br/><br/><br/><br/>
						<u>Dra. Endang Suyatmi L.,M.Pd</u><br/>
						NIP. 19601013 198503 2 006
					</td>-->
				</tr>
			</table>
	</div>
	
	<div class="page-notend" style="margin: 0px 45px 20px 45px; padding-top:60px">
		<?=$header?>
		<table style="width: 100%;">
			<tr>
				<td align="center" class="style14b"> ANGKET LINTAS MINAT SMA NEGERI 1 SEMARANG</td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td class="style14b" width="3%">A.</td>
				<td class="style14b" colspan="4">Pengantar</td>
			</tr>
			<tr>
				<td class="style14" ></td>
				<td class="style14 text2" colspan="4">
					Angket ini dimaksudkan untuk memperoleh informasi tentang minat belajar putra / putri Ibu / Bapak
					serta membimbing mereka untuk memilih kelompok mata pelajaran lintas minat. Data ini dipergunakan 
					sebagai bahan pertimbangan penempatan pilihan kelompok mata pelajaran lintas minat di SMA Negeri 1 Semarang,
					untuk itu isilah dengan hati - hati dan benar oleh putra / putri Ibu / Bapak sesuai dengan minat belajarnya.
					<br><br><br>
				</td>
			</tr>
			
			<tr>
				<td class="style14b" >B.</td>
				<td class="style14b" colspan="4">Petunjuk pengisian</td>
			</tr>
			<tr>
				<td class="style14" ></td>
				<td class="style14 text2" colspan="4">1. Bacalah secara teliti</td>
			</tr>
			<tr>
				<td class="style14" ></td>
				<td class="style14 text2" colspan="4">2. Jawablah semua pertanyaan secara jujur sesuai dengan diri Anda<br><br><br></td>
			</tr>
			
			<tr>
				<td class="style14b" >C.</td>
				<td class="style14b" colspan="4">Pertanyaan - pertanyaan</td>
			</tr>
			<tr>
				<td class="style14" ></td>
				<td class="style14" width="3%" valign="top">1.</td>
				<td class="style14 text2" colspan="3">Identitas Siswa</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" width="26%">a. Nama lengkap</td>
				<td class="style14" width="2%">:</td>
				<td align="left" class="line_bottom"> <?=strtoupper($value_angket['siswa_nama'])?></td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" >b. Tempat, tanggal lahir</td>
				<td class="style14" >:</td>
				<td align="left"  class="line_bottom"> 
				<?php //echo strtoupper($value_angket['siswa_tempat_lahir']).' , '.tgl_resmi($value_angket['siswa_tanggal_lahir']);?>
				<?php echo strtoupper($value_angket['siswa_tempat_lahir']).' , '.$value_angket['siswa_tanggal_lahir'];?></td>
			</tr>
			<tr>
				<td class="style14" colspan="2" valign="top"></td>
				<td class="style14" valign="top">c. Asal SMP / MTs</td>
				<td class="style14" valign="top">:</td>
				<td align="left"  class="line_bottom"> <?=strtoupper($value_angket['siswa_sekolah_asal'])?></td>
			</tr>
			<tr>
				<td class="style14" colspan="2" valign="top"></td>
				<td class="style14" valign="top">d. Alamat tempat tinggal</td>
				<td class="style14" valign="top">:</td>
				<td align="left"  class="line_bottom"> <?=strtoupper($value_angket['siswa_alamat_anak'])?>, 
				<?=strtoupper($value_angket['siswa_kelurahan_anak'])?>, <?=strtoupper($value_angket['siswa_kecamatan_anak'])?>, 
				<?=strtoupper($value_angket['siswa_kode_pos_anak'])?>, <?=strtoupper($value_angket['siswa_kota_anak'])?></td>,
				<?=strtoupper($value_angket['siswa_provinsi_anak'])?></td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3" ><br><br></td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">2.</td>
				<td class="style14 text2" colspan="3">
				Alasan saya memilih SMA Negeri 1 Semarang sebagai tempat meningkatkan pengetahuan, keterampilan, dan 
				sikap adalah... 
				</td>
			</tr>
			<?php
			$jml=0;
			foreach($data['data_siswa_alasan_sekolah']['data'] as $value_alasan_sekolah=>$key_alasan_sekolah){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><b><?=$jml?>. <?=$key_alasan_sekolah['alasan_sekolah_nama']?></b></td>
				</tr>
				<?php
			}
			
			if($value_angket['siswa_alasan_sekolah']!=''){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><b><?=$jml?>. <?=$value_angket['siswa_alasan_sekolah']?></b></td>
				</tr>
				<?php }
			?>
			<!--<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">a. Memperoleh pendidikan yang lebih tinggi</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">b. Persiapan memasuki perguruan tinggi</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">c. Disuruh orang tua / wali</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">d. Diajak teman</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">e. Untuk memperoleh pekerjaan</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3" class="line_bottom">f. </td>
			</tr>-->
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3" ><br><br></td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">3.</td>
				<td class="style14 text2" colspan="3">
				Lintas Minat untuk kelas X adalah sebanyak 2 mata pelajaran. Peserta didik 
				<b>memilih satu dari mata pelajaran lintas peminatannya</b>. Untuk lintas
				peminatan yang kedua di tentukan sekolah dalam mengakomodir kebutuhan jumlah jam guru
				<br><br><br>
				</td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">4.</td>
				<td class="style14 text2" colspan="3">
				Mata pelajaran lintas peminatan yang saya pilih ( Untuk Peminatan MIPA
				pilih Lintas Minat sesuai dengan kolom MIPA, dan untuk Peminatan IPS
				pilih Lintas Minat yang sesuai dengan kolom IPS ):
				
				</td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top"></td>
				<td class="style14 text2" colspan="3">

					<table width="80%" border="1" cellspacing="0">
						<tr>
							<td class="style14" width="50%" align="center" ><b>MIPA</b></td>
							<td class="style14" width="50%" align="center"><b>IPS</b></td>
						</tr>
						<tr>
							<td class="style14" style="padding: 4px 4px 4px 4px">
								1. Geografi<br/>
								2. Ekonomi<br/>
								3. Sastra Inggris<br/>
								4. Bahasa Jepang<br/>
							</td>
							<td class="style14" style="padding: 4px 4px 4px 4px" valign="top">
								1. Kimia<br/>
								2. Sastra Inggris<br/>
								3. Bahasa Jepang<br/>
							</td>
						</tr>
					</table>
						
				</td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top"></td>
				<td class="style14" >
					<b>Lintas Minat</b> pilihan
				</td>
				<td class="style14" >:</td>
				<td class="style14" class="line_bottom"><b><?=strtoupper($value_angket['siswa_lintas_minat'])?></b> </td>
			</tr>
		</table>
	</div>
	
	
	
	<div style="margin: 0px 45px 20px 45px; padding-top:70px">
		<table>
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">5.</td>
				<td class="style14 text2" colspan="3">
				Setelah lulus dari SMA Negeri 1 Semarang saya akan 
				</td>
			</tr>
			<?php
			$jml=0;
			if($value_angket['siswa_setelah_lulus_lainya']!=''){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><b> <?=$value_angket['siswa_setelah_lulus_lainya']?></b></td>
				</tr>
				<?php
			}elseif($value_angket['siswa_setelah_lulus_id']>0){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><b> <?=$value_angket['siswa_setelah_lulus']?></b></td>
				</tr>
				<?php
			} ?>
			<!--
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">c. Tinggal di rumah</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">d. Bekerja</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3">e. Kursus</td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3" class="line_bottom">f. </td>
			</tr>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3"> <br><br> </td>
			</tr>-->
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">6.</td>
				<td class="style14 text2" colspan="3">
				Seandainya melanjutkan studi di perguruan tinggi saya bercita - cita kuliah di.....
				</td>
			</tr>
			<?php
			
			$jml=0;
			foreach($data['data_siswa_kuliah']['data'] as $value_kuliah=>$key_kuliah){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><?=$array_alfabet[$jml]?>. Perguruan Tinggi <b><?=$key_kuliah['kuliah_nama']?></b> jurusan  <b><?=$key_kuliah['kuliah_jurusan']?></b></td>
				</tr>
				<?php
			}
			
			while($jml<KULIAH)
			{
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><?=$array_alfabet[$jml]?>. Perguruan Tinggi ................. jurusan .................</td>
				</tr>
				<?php
			}?>
			<tr>
				<td class="style14" colspan="2"></td>
				<td class="style14" colspan="3"> <br><br> </td>
			</tr>
			
			<tr>
				<td class="style14" ></td>
				<td class="style14" valign="top">7.</td>
				<td class="style14 text2" colspan="3">
				Seandainya saya bekerja, pekerjaan yang saya cita - citakan adalah.....
				</td>
			</tr>
			<?php
			$jml=0;
			foreach($data['data_siswa_kerja']['data'] as $value_kerja=>$key_kerja){
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><?=$array_alfabet[$jml]?>. Di <b><?=$key_kerja['kerja_nama']?></b> sebagai  <b><?=$key_kerja['kerja_jabatan']?></b></td>
				</tr>
				<?php
			}
			
			while($jml<KERJA)
			{
				$jml++; ?>
				<tr>
					<td class="style14" colspan="2"></td>
					<td class="style14" colspan="3"><?=$array_alfabet[$jml]?>. Di ................. sebagai .................</td>
				</tr>
				<?php
			}?>
		</table>
		
		<table style="width: 100%;" >
			<tr>	
				<td class="style14" align="left" colspan="2">
				<br><br>
				Keputusan dari pihak sekolah tidak dapat diganggu gugat.
				<br><br><br><br>
				</td>
			</tr>
			<tr>	
				
				<td class="style14" align="left">
					
					<br/>
					Mengetahui,<br/>
					Orang Tua / Wali Siswa
					<br/><br/><br/><br/>
						
						<table width="60%">
							<tr>
								<td class="line_bottom"><br></td>
							</tr>
						</table>
						
				</td>
				<td class="style14" width="40%" align="left">
					Semarang , <?=tgl_resmi(date("d-m-Y"))?>
					<br/><br/>
					Siswa
					<br/><br/><br/><br/>
						<table width="100%">
							<tr>
								<td class="line_bottom"><?=strtoupper($key['siswa_nama'])?></td>
							</tr>
						</table>
					
				</td>
			</tr>
		</table>
	</div>