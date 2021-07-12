<?php
//$tgl_cetak_rapor = "18 Desember 2015";

$kelas_explode = explode(" ",$row['kelas_nama']);
if(($kelas_explode[0]=='XII')or($kelas_explode[0]=='xii'))
	$tgl_cetak_rapor = "7 Mei 2016";
else
	$tgl_cetak_rapor = "17 Juni 2016";

if($row['kelas_grade']==10){
	$kurikulum = 'k13';
	$tampil_sub_nilai='Predikat';
	$jarak_enter="<br/>";
}else{
	$kurikulum = 'ktsp';
    $tampil_sub_nilai='Huruf';
	$jarak_enter="<br/><br/><br/>";
}
function int2kata($n) {
	if (is_null($n) or !is_numeric($n))
		return '';

	if ($n == 0)
		return 'Nol';
	if ($n == 1)
		return 'Satu';
	if ($n ==2)
		return 'Dua';
	if ($n ==3)
		return 'Tiga';
	if ($n ==4)
		return 'Empat';
	if ($n ==5)
		return 'Lima';
	if ($n ==6)
		return 'Enam';
	if ($n ==7)
		return 'Tujuh';
	if ($n ==8)
		return 'Delapan';
	if ($n ==9)
		return 'Sembilan';

	return '';
}


function tgl_indo($tgl){
			$tanggal = substr($tgl,0,2);
			$bulan = getBulan(substr($tgl,3,2));
			$tahun = substr($tgl,6,4);
			return $tanggal.' '.$bulan.' '.$tahun;
	}
function getBulan($bln){
				switch ($bln){
					case 1:
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			}


function int2huruf($n) {
	if (is_null($n) OR !is_numeric($n))
		return '';

	if ($n >= 86)
		return 'A';

	if ($n >= 71)
		return 'B';

	if ($n >= 56)
		return 'C';

	if ($n >= 41)
		return 'D';

	return 'E';
}

function header_rapor($data){
?>
<table width="100%" border="0" style="width: 100%;">
    <tr>
      <td width="23%"	valign="top"><span class="style1">Nama Peserta Didik</span> </td>
      <td width="1%"	valign="top"><span class="style1">:</span></td>
      <td width="35%" 	valign="top"><span class="style1"><em><?php echo $data['siswa_nama']; ?></em></span></td>
      
      <td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
      <td width="1%" valign="top"><span class="style1">:</span></td>
      <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;"><?php echo $data['kelas_nama']; ?>/
	  <?php if($data['semester_nama']=='gasal'){	echo"1(satu)";	}else{	echo"2(dua)";	}  ?></span></td>
    </tr>
    <tr>
      <td valign="top"><span class="style1">Nomor Induk</span> </td>
      <td valign="top"><span class="style1">:</span></td>
      <td valign="top"><span class="style1"><?php echo $data['siswa_nis']; ?></span> </td>
      
      <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
      <td valign="top"><span class="style1">:</span></td>
      <td valign="top"><span class="style1"><?= str_replace("/"," - ",$data['ta_nama']) ?></span></td>
      
    </tr>
    <tr>
      <td valign="top"><span class="style1">Nama Sekolah</span> </td>
      <td valign="top"><span class="style1">:</span></td>
      <td colspan="4" valign="top"><span class="style1">SMA Negeri 9 Semarang</span> </td>
      
    </tr>
  </table>
<?php
}

function footer_rapor($data, $tgl_cetak_rapor, $lembar){
	
	?>
    


<table border="0" style="width: 100%;">
  <tr>
  	<td width="24%" align="left" valign="top"></td>
    <td width="10%"></td>
    <td width="38%" align="left" valign="top"></td>
    <td  align="left" valign="top">
    <div align="right" class="style6">
    <?= $data['kota_nama'];?>, <?= $data['tanggal_uas_nama'];?></div>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
    		<p class="style6">
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/><br/>
				<hr/>			</p>    </td>
    <td ></td>
    <td  align="left" valign="top">
    <?php if($lembar==1||$lembar==3)
	{?>
			<p class="style6">
				Mengetahui,<br/>
                Kepala Sekolah<br/>
				<br/><br/><br/><br/>
				Drs. Wiharto, M.Si<br />
				NIP : 19631003 198803 1 009			</p>    
	<?php }
	?></td>
	<td align="left" valign="top">
    
  
			<p class="style6">
				Wali Kelas <?php echo $data['kelas_nama']; ?>,<br/>
				<br/><br/><br/><br/><br/>
					<?php // foreach ($data as $idx => $item):
							//echo $item['wali_nama'];
						 // endforeach;
						  echo $data['wali_nama']."<br/> NIP : ";
						  echo $data['wali_nip'];
					?>
			</p>    </td>
    
  </tr>
</table>

    <?php
}

function catatan(){
	?>
<table>
 <tr>
	<td width="60px" align="right"><div class="style1">*)</div></td>
	<td><div class="style1">Diisi dengan Keterampilan / Bahasa Asing yang diikuti peserta didik</div></td>
 </tr>
 <tr>
	<td align="right"><div class="style1">**)</div></td>
	<td><div class="style1">Diisi dengan program muatan lokal yang diikuti peserta didik</div></td>
 </tr>
</table>
<?php
}
?>
<style type="text/css">
<!--
.style2 {font-size: 15px;}
.style3 {font-size: 14px;}
-->
#halaman_akhir {
/*height:1500px;*/
padding-top:-45;
}
#halaman {
padding-top:-45;
page-break-after:always;
}
.style1 {font-size: 14px}
.style4 {
font-size: 12px;
}
.style5 {font-size: 10px}

.kecil td{
font-size: 12px;
padding:3px 5px 3px 5px;
}
.mini td{
padding:2px 5px 2px 5px;
}
.besar td{
padding:8x 5px 8px 5px;
}
.style6 {font-size: 12px; }
.style7 {font-size: 12px;}
</style>

<?php
foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];
	$ekskul_result 		= $ekskul_result_array[$cetak['id']];

	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div class="page" id="page-1" >';	
?>	
<div id="halaman">
  <?=header_rapor($row);?>
<br/>

<?php 
/*
$safaf = 0;
foreach ($resultset_array as $idx => $item): 

$safaf++;
echo $safaf."<br>";

echo "<pre>";
print_r($resultset);
echo "</pre>";
// endforeach;
 */
?>

<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
  <tr>
    <th width="5%" rowspan="3" class="style20">No.</th>
    <th width="220" rowspan="3" class="style20">Komponen</th>
    <th width="70" rowspan="3" class="style20">Kriteria Ketuntasan Minimal (KKM)</th>
    <th colspan="5" class="style20">Nilai Hasil Belajar</th>
  </tr>
  <tr>
    <th colspan="2" class="style20">Pengetahuan</th>
    <th colspan="2" class="style20">Praktek</th>
    <th width="11%" class="style20">Sikap</th>
  </tr>
  <tr>
    <th width="10" class="style20">Angka</th>
    <th class="style20">Huruf</th>
    <th width="10" class="style20">Angka</th>
    <th class="style20">Huruf</th>
    <th class="style20">Predikat</th>
  </tr>
  
 
		<?php
		$mp_no = 0;
        $ktg_ascii = 64;
		
		$ktg_nama = NULL;
        $antr_mapel = 0; 
		foreach ($resultset['data'] as $idx => $item): 
			 if ($item['kategori_nama'] != $ktg_nama):

                $ktg_ascii++;
                $mp_no = 0;

				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                      <td align="center" valign="middle"><div class="style3"><b>A.</b></div></td>
                      <td valign="middle"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                  </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				 <tr>
					  <td align="center" valign="middle"><div class="style3"><b>B.</b></div></td>
					  <td valign="middle"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
				  </tr>
                  
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
		<tr>
			<td align="center" valign="middle"><div class="style3"><?php echo $mp_no; ?>.</div></td>
			<td valign="middle"><div class="style3"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style2"><?php echo round($item['nipel_kkm']); ?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style2"><?php
			if (is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
				echo "-";
			} else {
				echo ($item['mid_teori']) ? round($item['mid_teori']) : '';
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php
			if (is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
			echo "-";
			} else {
				
					echo int2kata(substr(round($item['mid_teori']),0,1))." "
					.int2kata(substr(round($item['mid_teori']),1,1))." "
					.int2kata(substr(round($item['mid_teori']),2,1));
				
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center" class="style2">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
				echo ($item['mid_praktek']) ? round($item['mid_praktek']) : '-';
			}

			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
					echo int2kata(substr(round($item['mid_praktek']),0,1))." "
					.int2kata(substr(round($item['mid_praktek']),1,1))." "
					.int2kata(substr(round($item['mid_praktek']),2,1)) ;
				
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center"><?php echo $item['pred_sikap']; ?></div></td>
		</tr>



	<?php endforeach; ?>
</table>

<?php catatan();?>

<?php footer_rapor($row, $tgl_cetak_rapor,1);?>

</div>

<!-- ===================================================================================== -->

<div id="halaman">
  <?=header_rapor($row);?>
<br />
Ketercapaian Kompetensi Peserta Didik <br/>

<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    <th height="30px" width="4%"><div class="style3">No.</div></th>
    <th width="34%"><div class="style3">Komponen</div></th>
    <th width="62%"><div class="style3">Ketercapaian Kompetensi</div></th>
  </tr>	<tr>
		  <td height="30px" align="center" valign="middle"><div class="style3">A.</div></td>
		  <td valign="middle"><div class="style3">Mata Pelajaran </div></td>
		  <td valign="middle" align="center">&nbsp;</td>
		  </tr>
	<?php foreach ($resultset_array['data'] as $idx => $item): ?>

		<tr>
			<td height="30px" align="center" valign="middle"><div class="style3"><?php echo $idx + 1; ?>.</div></td>
			<td valign="middle"><div class="style3"><?php echo $item['mapel_nama']; ?></div></td>
		    <td valign="middle" align="left"><div align="center" class="style3">
		    <div align="left"><?php
			if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
		echo $item['kompetensi'];
		//echo $item['kompetensi']." ".$item['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
		  </div></td>
		</tr>
	<?php endforeach; ?>
	<tr >
		  <td height="30px" align="center" valign="middle"><div class="style3">B</div></td>
		  <td valign="middle"><div class="style3">Muatan Lokal **) </div></td>
		  <td valign="middle" align="left"><div align="left"></div></td>
  </tr>
    <?php foreach ($nilaimulok['data'] as $idx => $item): ?>
	<tr>
			<td height="30px" align="center" valign="middle"><div class="style3"><?php echo $idx + 1; ?>.</div></td>
			<td valign="middle"><div class="style3"><?php echo $item['mapel_nama']; ?></div></td>
	  <td valign="middle" align="left"><div align="center" class="style3">
	    <div align="left"><?php
		if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
		echo $item['kompetensi'];
		//echo $item['kompetensi']." ".$item['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
	  </div></td>
  </tr>

	<?php endforeach; ?>
    
</table>

<?php catatan();?>
<?php footer_rapor($row, $tgl_cetak_rapor,2);?>
</div>

<!-- ====================================================================================== -->

<div id="halaman_akhir">
  <?=header_rapor($row);?>

Pengembangan Diri
<br/>
<?php foreach ($ekskul_result_array as $idx => $item): ?>
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="mini">
  <tr>
    <th width="3%"><span class="style4">No.</span></th>
    <th ><span class="style4">Jenis Kegiatan </span></th>
    <th width="70%"><span class="style4">Keterangan</span></th>
  </tr>	
    <tr>
		  <td align="center" valign="middle"><span class="style4"><strong>A.</strong></span></td>
		  <td valign="middle"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
		  <td valign="middle" align="center"><span class="style4"></span></td>
	</tr>

	<tr>
		  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
		  <td align="center" valign="middle"><span class="style4">1.</span></td>
		  <td valign="middle"><span class="style4"><?php if(!empty($item['extra1_nama'])){echo ($item['extra1_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['extra1_kompetensi'])){echo ($item['extra1_kompetensi']);}else{echo"-";} ?></span></td>
    </tr>
	<tr>
		  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
		  <td align="center" valign="middle"><span class="style4">2.</span></td>
		  <td valign="middle"><span class="style4"><?php if(!empty($item['extra2_nama'])){echo ($item['extra2_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['extra2_kompetensi'])){echo ($item['extra2_kompetensi']);}else{echo"-";} ?></span></td>
    </tr>
	<tr>
		  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
		  <td align="center" valign="middle"><span class="style4">3.</span></td>
		   <td valign="middle"><span class="style4"><?php if(!empty($item['extra3_nama'])){echo ($item['extra3_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['extra3_kompetensi'])){echo ($item['extra3_kompetensi']);}else{echo"-";} ?></span></td>
    </tr>
		<tr>
			<!--<td align="center" valign="middle"><span class="style4"></span></td>
			<td align="center" valign="middle"><span class="style4">4.</span></td>
		    <td valign="middle"> - </td>
		  <td valign="middle" align="left"> - </td>-->
		</tr>
	<tr>
		  <td align="center" valign="middle"><span class="style4"><strong>B.</strong></span></td>
		  <td valign="middle"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
		  <td valign="middle" align="left"><span class="style4"></span></td>
  </tr>

	<tr>
	  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
	  <td align="center" valign="middle"><span class="style4">1.</span></td>
	  <td valign="middle"><span class="style4"><?php if(!empty($item['org1_nama'])){echo ($item['org1_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['org1_kompetensi'])){echo ($item['org1_kompetensi']);}else{echo"-";} ?></span></td>
    </tr>
	<tr>
	  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
	  <td align="center" valign="middle"><span class="style4">2.</span></td>
	  <td valign="middle"><span class="style4"><?php if(!empty($item['org2_nama'])){echo ($item['org2_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['org2_kompetensi'])){echo ($item['org2_kompetensi']);}else{echo"-";} ?></span></td>
   </tr>
	<tr>
	  <!--<td align="center" valign="middle"><span class="style4"></span></td>-->
	  <td align="center" valign="middle"><span class="style4">3.</span></td>
	  <td valign="middle"><span class="style4"><?php if(!empty($item['org3_nama'])){echo ($item['org3_nama']);}else{echo"-";} ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php if(!empty($item['org3_kompetensi'])){echo ($item['org3_kompetensi']);}else{echo"-";} ?></span></td>
  </tr>
	<tr>
	  <!--<td align="center" valign="middle"><span class="style4"></span></td>
	  <td align="center" valign="middle"><span class="style4">4.</span></td>
	  <td valign="middle"> - </td>
		  <td valign="middle" align="left"> - </td>-->
  </tr>
</table>

Akhlak Mulia dan Kepribadian<br />
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="besar">
  <tr>
    <th width="3%"><div class="style4">No.</div></th>
    <th width="25%"><div class="style4">Kepribadian  </div></th>
    <th width="12%"><div class="style4">Nilai</div></th>
    <th width="60%"><div class="style4">Keterangan</div></th>
  </tr>
	<?php 
		$no_aspek= 0;
		foreach ($aspek_result_array as $idx => $item_aspek):
		$no_aspek++;
	?>
	  <tr>
		<td align="center" valign="middle"><div class="style4"><?=$no_aspek ?>.</div></td>
		<td valign="middle"><div class="style4"><?=$no_aspek['aspek_nama'] ?></div></td>
		<td align="center" valign="middle"><div class="style4"><b><?=$no_aspek['aspek_nilai'] ?></b></div></td>
		<td valign="middle"><div class="style5"><?=$no_aspek['aspek_keterangan'] ?></div></td>
	  </tr>
	<?php
		endforeach;
	?>
	<!------
  <tr>
    <td align="center" valign="middle"><div class="style4">2.</div></td>
    <td valign="middle"><div class="style4">Kebersihan</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_kebersihan']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_kebersihan']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">3.</div></td>
    <td valign="middle"><div class="style4">Kesehatan</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_kesehatan']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_kesehatan']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">4.</div></td>
    <td valign="middle"><div class="style4">Tanggung Jawab</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_tanggungjawab']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_tanggungjawab']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">5.</div></td>
    <td valign="middle"><div class="style4">Sopan Santun </div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_sopansantun']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_sopansantun']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">6.</div></td>
    <td valign="middle"><div class="style4">Percaya Diri </div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_percayadiri']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_percayadiri']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">7.</div></td>
    <td valign="middle"><div class="style4">Kompetitif</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_kompetitif']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_kompetitif']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">8.</div></td>
    <td valign="middle"><div class="style4">Hubungan Sosial </div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_hubungansosial']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_hubungansosial']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">9.</div></td>
    <td valign="middle"><div class="style4">Kejujuran</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_kejujuran']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_kejujuran']); ?></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div class="style4">10.</div></td>
    <td valign="middle"><div class="style4">Pelaksanaan Ibadah Ritual</div></td>
     <td align="center" valign="middle"><div class="style4"><b><?php echo ($item['kode_ibadah']); ?></b></div></td>
    <td valign="middle"><div class="style5"><?php echo ($item['aspri_ibadah']); ?></div></td>
  </tr> ---->
</table>

Ketidakhadiran<br />
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr>
    <th width="3%"><span class="style4">No.</span></th>
    <th width="35%"><span class="style4">Alasan</span></th>
    <th width="62%"><span class="style4">Keterangan</span></th>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">1.</span></td>
    <td valign="middle"><span class="style4">Sakit</span></td>
    <td valign="middle" align="center"><span class="style4"><?php if($row['absen_s']>0){	echo ($row['absen_s']); ?> Hari<?php }else{echo"-";}?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">2.</span></td>
    <td valign="middle"><span class="style4">Izin</span></td>
    <td valign="middle" align="center"><span class="style4"><?php if($row['absen_i']>0){	echo ($row['absen_i']); ?> Hari<?php }else{echo"-";}?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">3.</span></td>
    <td valign="middle"><span class="style4">Tanpa Keterangan </span></td>
    <td valign="middle" align="center"><span class="style4"><?php if($row['absen_a']>0){	echo ($row['absen_a']); ?> Hari<?php }else{echo"-";}?></span></td>
  </tr>
 <!-- <tr>
    <td align="center" valign="middle"><span class="style4"> </span></td>
    <td valign="middle"><span class="style4">&nbsp; </span></td>
    <td valign="middle" align="center"><span class="style4"></span></td>
  </tr>-->
</table>

<!--
<br/>
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr><td height="75" valign="top" align="left"><b>&nbsp;&nbsp;Catatan Wali Kelas</b>
  <br/><?php
  $catatan	= str_replace("\n","<br/>",($item['catatan']));
  echo $catatan; ?>
  </td></tr>
</table>
-->

<?php if($row['semester_nama']=='genap')
{?>

Catatan Kenaikan Kelas :
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr><td height="50" valign="top" align="left">
  <table>
  <?php if($item['kelas_tingkat']==12)
        {?>
           <tr>
            <td align="right"><div class="style6"><b>&nbsp;Catatan Wali Kelas</b></div></td>
            <td><div class="style6"><span style="text-transform:uppercase;">: <?php echo "-"; //($item['catatan']); 
			?></span></div></td>
           </tr>
		<?php
		}
		if(($item['kelas_tingkat']==10)||($item['kelas_tingkat']==11))
        {?>
           <tr>
            <td align="right"><div class="style6"><b>&nbsp;Hasil Keputusan Rapat</b></div></td>
            
            <td><div class="style6"><span style="text-transform:uppercase;">: 
            
			<?php
			// TIDAK NAIK KELAS
            if(($resultset_array['data']['siswa_id']==4462)||
			($resultset_array['data']['siswa_id']==4137)||
			($resultset_array['data']['siswa_id']==4066))
			{?>
            TIDAK NAIK
            <?php }else{ ?>
            NAIK 
            <?php }?>
            
            </span> 
			
			<?php //echo ($item['kenaikan_keterangan']);  
			if($item['kelas_tingkat']==10)
				echo "Ke Kelas XI";
			else
				echo "Ke Kelas XII";
			
			?>
            </div></td>
           </tr>
        <?php
        } 
        if($item['kelas_tingkat']==10)
        {?>
           <tr>
            <td align="left"><div class="style6"><b>&nbsp;Program</b></div></td>
            <td><div class="style6"><span style="text-transform:uppercase;">: IPA / IPS<?php  //echo ($item['kenaikan_program']); ?></span></div></td>
           </tr>
         <?php }?>
  </table>
  </td></tr>
</table>
<?php }?>
<?php endforeach; ?>

<?php footer_rapor($row, $tgl_cetak_rapor,3);?>
</div>
<?php }?>