<?php
$tanggal_rapor = $row['tanggal_uas_nama'];

function int2huruf($n)
{
	if (is_null($n) OR ! is_numeric($n))
		return '';

	if ($n == 0)
		return 'Nol';
	if ($n == 1)
		return 'Satu';
	if ($n == 2)
		return 'Dua';
	if ($n == 3)
		return 'Tiga';
	if ($n == 4)
		return 'Empat';
	if ($n == 5)
		return 'Lima';
	if ($n == 6)
		return 'Enam';
	if ($n == 7)
		return 'Tujuh';
	if ($n == 8)
		return 'Delapan';
	if ($n == 9)
		return 'Sembilan';

	return '';

}

function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 0, 2);
	$bulan = getBulan(substr($tgl, 3, 2));
	$tahun = substr($tgl, 6, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;

}

function getBulan($bln)
{
	switch ($bln)
	{
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

?>
<style type="text/css">
	
	@page {
	 	/* POLIO*/
       /* sheet-size: 210mm 330mm ;*/
	   sheet-size: 210mm 290mm ;
        margin: 25px 45px 5px 45px;
    }

    .page-notend{
        page-break-after: always;
    }
	.style1 {font-size: 13px; font-weight: bold; }
	.style2 {
		font-size: 13px; 
		font-weight: bold; 
		padding: 45px opx 45px 0px;
	}
	.style7 {font-size: 11px; font-weight: bold; }
	.style8 {font-size: 12px}
	
	.style11 {font-size: 13px;}
	.style12 {font-size: 13px; font-weight: bold;}
	.style13 {
		font-size: 18px;
		
	}
	.style16 {font-size: 21px}
	.style17 {font-size: 24px}
	.style18 {
		font-size: 30px;
		font-weight: bold;
	}
	.style19 {
		font-size: 28px;
		font-weight: bold;
	}
	
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
<table border="0" style="width: 100%;">
	<?php
	$semester_plus=0;
	if($row['kelas_grade']==11){
		$semester_plus=2;
	}elseif($row['kelas_grade']==12){
		$semester_plus=4;
	}
	$semester = 2 + $semester_plus;
	$smster_nama = $semester.' / Genap';
	if($row['semester_nama'] == 'gasal'){
		$semester = $semester-1;
		$smster_nama = $semester.' / Ganjil';
	}
	$ta_nama = str_replace("/"," - ",$row['ta_nama']);
	?>
		
	<tr>
	  <td width="20%"	valign="top"><span class="style1">Nama Sekolah</span> </td>
	  <td width="1%"	valign="top"><span class="style1">:</span></td>
	  <td width="48%" 	valign="top"><span class="style1"><?=APP_SCHOOL?></span></td>
	  
	  <td width="17%" valign="top"><span class="style1">Kelas</span></td>
	  <td width="1%" valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1" style="text-transform:uppercase;"><?=$row['kelas_nama']?></span></td>
	</tr>
	<tr>
	  <td valign="top"><span class="style1">Alamat</span> </td>
	  <td valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1"><?=APP_SCHOOL_ADDRESS?></span></td>
	  
	  <td valign="top"><span class="style1">Semester</span></td>
	  <td valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1" ><?=$smster_nama?></span></td>
	</tr>
	<tr>
	  <td valign="top"><span class="style1">Nama</span> </td>
	  <td valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1" ><?=$row_per_siswa['siswa_nama']?></span></td>
	  
	  <td></td><td></td><td></td>
	</tr>
	<tr>
	  <td valign="top"><span class="style1">Nomor Induk/NISN</span> </td>
	  <td valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1" colspan="4"><?=$row_per_siswa['siswa_nis']?>
	  <?php
	  if($row_per_siswa['siswa_nisn'] != '')
		  echo ' / '.$row_per_siswa['siswa_nisn'];?>
	  </span> </td>
	
		<td valign="top"><span class="style1">Tahun Pelajaran</span></td>
	  <td valign="top"><span class="style1">:</span></td>
	  <td valign="top"><span class="style1"><?=$ta_nama?></span></td>
	  <?=$smster_nama?></span></td>
	  
	</tr>
				
			
</table>

<table border="0" style="width: 100%;">
	<tr>
		<td class="style2" align="center" >
		LAPORAN CAPAIAN HASIL BIMBINGAN TEKNOLOGI INFORMASI DAN KOMUNIKASI (B-TIK)
		<br>TAHUN PELAJARAN <?=$ta_nama?>
		</td>
	</tr>
</table>


	 
	
<?php
		
		$header_table_nilai='
		<tr>
				<th width="34%" class="style8">Materi</th>
				<th width="8%" class="style8">KKM</th>
				<th width="8%" class="style8">Nilai</th>
				<th width="10%" class="style8">Predikat </th>
				<th class="style8">Deskripsi</th>
			
			</tr>
		';
		$mp_no = 0;
        $ktg_ascii = 64;
        $ktg_nama = NULL;
        $jml_row = 0;

        foreach ($resultset['data'] as $idx => $item):
            if ($item['kategori_nama'] != $ktg_nama):
                $ktg_nama = $item['kategori_nama'];
                $jml_row++;
            endif;
            $jml_row++;
        endforeach;
		
		$ktg_nama = NULL;
        $antr_mapel = 0; 
		$guru_nama	='';
		$guru_nip	='';
		foreach ($resultset['data'] as $idx => $item): 
			$guru_nama = $item['guru_nama'];
			$guru_nip	= $item['guru_nip'];
		?>
		&nbsp;&nbsp;<b>Pengetahuan</b>
        <table width="100%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
			<?=$header_table_nilai?>
			<tr>
				
				<td valign="top" valign="middle" class="style8"><?=$item['materi_teori']?></td>
				<td class="style8" valign="middle" align="center"><?php echo round($item['nipel_kkm']); ?>&nbsp; </td>
				<td class="style8" valign="middle" align="center">
					
					<?php echo $item['nas_teori']; ?>
				</td>
				<td class="style8" valign="middle" align="center">
					
					<?php echo $item['pred_teori']; ?>
					
				</td>
				<td class="style8" valign="middle" align="left">
					
					<?php echo $item['cat_teori']; ?>
				</td>
			</tr>
		</table>
		
		<br><br>
		&nbsp;&nbsp;<b>Keterampilan</b>
		<table width="100%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
			<?=$header_table_nilai?>
			<tr>
				
				<td valign="top" valign="middle" class="style8"><?=$item['materi_praktek']?></td>
				<td class="style8" valign="middle" align="center"><?php echo round($item['nipel_kkm']); ?>&nbsp; </td>
				<td class="style8" valign="middle" align="center">
					
					<?php echo $item['nas_praktek']; ?>
				</td>
				<td class="style8" valign="middle" align="center">
					
					<?php echo $item['pred_praktek']; ?>
					
				</td>
				<td class="style8" valign="middle" align="left">
					
					<?php echo $item['cat_praktek']; ?>
				</td>
			</tr>
			</table>
<?php endforeach; ?>
	


	
	

<div style="padding-top:6px"></div>
<table cellspacing="0" width="100%" >
	<tr>
		<td width="20px"></td>
		<td >
		<br/>Tabel interval berdasarkan KKM.
			
		</td>
	</tr>
</table>

<table width="100%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
	<tr>
		<td class="style8" rowspan="2" width="20%" align="center">KKM</td>
		<td class="style8" colspan="4" align="center">Predikat </td>
		
	</tr>

	<tr>
		<td class="style8" align="center">D=Kurang</td>
		<td class="style8" align="center">C=Cukup</td>
		<td class="style8" align="center">B=Baik</td>
		<td class="style8" align="center">A=Sangat Baik</td>
		
	</tr>
	<tr>
	
		<td class="style8" align="center"> 70 </td>
		<td class="style8" align="center"> < 70 </td>
		<td class="style8" align="center"> 70 - 79</td>
		<td class="style8" align="center"> 80 - 89 </td>
		<td class="style8" align="center"> 90 - 100</td>
				
	</tr>
</table>
<br>
<table border="0" style="width: 100%;">
	<tr>
		<td width="30%" align="left" valign="top">
			<!-- <p class="style11">
				Mengetahui, <br/>
				Kepala Sekolah <br/>
				<br/>
				<br/><br/><br/>
				<?php echo $row["kepsek_nama"]."<br/>"; ?>
				<?php echo "NIP . ".$row["kepsek_nip"]; ?>	  
    	  </p>   -->
		  </td>
		<td  align="center" valign="top">
			<p class="style11"><br/>
				<br/>
				<br/><br/><br/>
			</p>    </td>
		<td width="38%" align="left" valign="top">
			<p class="style11">
				 Semarang, <?php echo $tanggal_rapor; ?><br/>
				Guru Teknologi Informasi dan Komunikasi<br/>
				<br/>
				<br/><br/><br/>
				<?php echo $guru_nama."<br/>"; ?>
				<?php
			if(strlen($guru_nip)<10){
				$guru_nip='-';
			}
		echo "NIP . ".$guru_nip; ?>	  </p>    </td>
    	  </p>    </td>
	</tr>
</table>

</div>
<?php }?>