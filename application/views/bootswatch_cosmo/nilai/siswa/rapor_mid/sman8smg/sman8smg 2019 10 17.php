<?php
//$tanggal_rapor='22 Oktober 2016';
//$tanggal_rapor='April 2017';
//$tanggal_rapor = $row['tanggal_mid_nama'];
$tanggal_rapor = tanggal(date("Y-m-d"));

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
        sheet-size: 210mm 330mm ;
        margin: 60px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
	.style7 {font-size: 11px; font-weight: bold; }
	.style8 {font-size: 13px}
	.style11 {font-size: 14px}
	.style13 {
		font-size: 24px;
		font-weight: bold;
	}
	.style17 {font-size: 24px}
	.style18 {font-size: 36px}
	.style19 {font-size: 28px}
	
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
	<tr>
		<!--<td width="115" valign="top"><img src="<?=APP_ROOT?>/images/logo/Logo Dinas Pend.jpg" width="120" /> </td>
		<td width="942" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH KOTA SEMARANG<br />
					DINAS PENDIDIKAN</span><br />-->
		<td valign="top" ><img src="<?=APP_ROOT?>/images/logo/logo-jawa-tengah3.png" width="148" /> </td>
		<td width="900" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH PROVINSI JAWA TENGAH<br />
					DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
				<span class="style18">SMA NEGERI 8 SEMARANG</span><br />
				Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798<br />
				website: http://www.sman8-smg.sch.id- Email : sman8smg@yahoo.com</span></td>
		<td width="150" valign="top"><!--<img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma8.jpg" width="150" />--></td>
	</tr>
	<tr>

		<td colspan="3" valign="top"><hr/></td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top"><div align="center" class="style17" style="text-transform:uppercase;"><strong>LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH SEMESTER <?php echo strtoupper($row['semester_nama']); ?> <br />
					TAHUN PELAJARAN <?php echo $row['ta_nama']; ?></strong></div>
			<span class="style17"><br/>
			</span></td>
	</tr>
	<tr>
		<td colspan="3" valign="top"><table border="0" style="width: 100%;">
				<tr>
					<td width="12%" valign="top" class="style17"><b>NAMA</b></td>
					<td width="1%" valign="top" class="style17">:</td>
					<td width="87%" valign="top" class="style17"><b><?php echo strtoupper($row_per_siswa['siswa_nama']); ?></b> </td>
				</tr>
				<tr>
					<td valign="top" class="style17"><b>NIS</b> </td>
					<td valign="top" class="style17">:</td>
					<td valign="top" class="style17"><b><?php echo $row_per_siswa['siswa_nis']; ?></b> </td>
				</tr>
				<tr>
					<td valign="top" class="style17"><b>KELAS</b> </td>
					<td valign="top" class="style17">:</td>
					<td valign="top" class="style17"><b><?php echo $row['kelas_nama']; ?></b></td>
				</tr>
			</table></td>
	</tr>
</table>

<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
	<tr>
		<th width="5%" rowspan="2" class="style8"><span class="style8">NO</span></th>
		<th width="40%" rowspan="2" class="style8"><span class="style8">KOMPONEN</span></th>
		<th width="10%" rowspan="2" class="style8"><span class="style8">KKM</span></th>
		<th colspan="3" class="style8"><span class="style8">PENILAIAN TENGAH SEMESTER </span></th>
	</tr>

	<tr>
		<th width="12%" class="style8"><span class="style8">Angka</span></th>
		<th width="20%" class="style8"><span class="style8">Huruf</span></th>
		<th width="13%" class="style8"><span class="style8">Rata-Rata</span></th>
	</tr>
<?php
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
		foreach ($resultset['data'] as $idx => $item): 
			 if ($item['kategori_nama'] != $ktg_nama):

                $ktg_ascii++;
              //  if($item['kategori_kode']!='KelD')
				//{
					$mp_no = 0;
				//}
				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                    <td valign="top" class="style8" align="center"><span class="style7">A</span></td>
                    <td valign="top" class="style8"><span class="style7"><?=$item['kategori_nama']?> </span></td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				<tr>
                    <td valign="top" class="style8" align="center"><span class="style7">B</span></td>
                    <td valign="top" class="style8"><span class="style7"><?=$item['kategori_nama']?> </span></td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="middle" colspan="6"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="middle" colspan="6"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="middle" colspan="6"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>I.</b></div></td>
					  <td valign="middle" colspan="5"><div class="style8"><b>Peminatan </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>II.</b></div></td>
					  <td valign="middle" colspan="5"><div class="style8"><b>Lintas Minat </b></div></td>
				  </tr>
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
        
		<tr>
			<td valign="top" class="style8" align="right"><span class="style8"><?php echo $mp_no; ?></span></td>
			<td valign="top" class="style8"><span class="style8"><?php echo $item['mapel_nama']; ?></span></td>
			<td align="center" valign="top" class="style8"><span class="style8"><?php echo round($item['nipel_kkm']); ?>&nbsp; </span></td>
			<td align="center" valign="top" class="style8"><span class="style8"><?php echo ($item['uts']) ? round($item['uts']) : ''; ?>&nbsp; </span></td>
			<td align="center" valign="top" class="style8">
				<span class="style8"><?php

					echo int2huruf(substr($item['uts'], 0, 1)) . " "
					. int2huruf(substr($item['uts'], 1, 1)) . " " . int2huruf(substr($item['uts'], 2, 1));

					?></span></td>
			<td align="center" valign="top" class="style8"><span class="style8">

		<?php echo $rerata[$item['pelajaran_id']]; ?>			</td>
		</tr>
<?php endforeach; ?>
	
</table>

	<span class="style11">Pengembangan Diri </span><br />
	<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
		<tr>
			<td width="5%" align="center"><div align="center" class="style7">NO</div></td>
			<td width="37%" align="center"><div align="center" class="style7">JENIS KEGIATAN </div></td>
			<td width="58%" align="center"><div align="center" class="style7">KETERANGAN</div></td>
		</tr>
		
        <?php
	$tampil_eskl = 0;
    foreach ($ekskul_result['data'] as $_idx => $_row):
		$ket_ekskul = '';
		$tampil_eskl = 1;
        echo '<tr>' . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"40\" align=\"right\"> " . ($_idx + 1) . ". </td>" . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"200\"> &nbsp;{$_row['ekskul_nama']}</td>" . NL;
        //echo "<td class=\"t-border\" valign=\"top\" align=\"center\"> {$_row['nilai']}</td>" . NL;
        //echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
        if(($_row['nilai']=='A')||($_row['nilai']=='a')):
			echo $ket_ekskul='Sangat Baik';
		elseif(($_row['nilai']=='B')||($_row['nilai']=='b')):
			echo $ket_ekskul='Baik';
		elseif(($_row['nilai']=='C')||($_row['nilai']=='c')):
			echo $ket_ekskul='Cukup';
		elseif(($_row['nilai']=='D')||($_row['nilai']=='d')):
			echo $ket_ekskul='Kurang';
		endif;
		echo "<td class=\"t-border\" valign=\"top\">&nbsp;".$ket_ekskul." </td>" . NL;
		echo '</tr>' . NL;
		
    endforeach;
	if($tampil_eskl == 0){
		echo '<tr>' . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\">- </td>" . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\">- </td>" . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\">- </td>" . NL;
		echo '</tr>' . NL;
	}
	?>
	</table>
	<span class="style11">Ketidakhadiran</span><br />

	<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
		<tr>
			<td width="5%" align="center"><div align="center" class="style7">NO</div></td>
			<td width="37%" align="center"><div align="center" class="style7">ALASAN KETIDAKHADIRAN </div></td>
			<td width="58%" align="center"><div align="center" class="style7">LAMA</div></td>
		</tr>
		<tr>
			<td><span class="style8">1</span></td>
			<td><span class="style8">Sakit</span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_s'] > 0) ? "{$row_per_siswa['absen_s']}" : "-"; ?> Hari</span></td>
		</tr>
		<tr>
			<td><span class="style8">2</span></td>
			<td><span class="style8">Ijin</span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_i'] > 0) ? "{$row_per_siswa['absen_i']}" : "-"; ?> Hari</span></td>
		</tr>
		<tr>
			<td><span class="style8">3</span></td>
			<td><span class="style8">Tanpa Keterangan </span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_a'] > 0) ? "{$row_per_siswa['absen_a']}" : "-"; ?> Hari</span></td>
		</tr>
	</table>
	<br/>


<table style="width:100%;border-collapse: collapse;">
  <tr>
    <td width="98%" align="right" class="style11">

 <!-- Semarang, <?php echo tgl_indo(date('d-m-Y')); ?>-->
  Semarang, <?php echo $tanggal_rapor; ?>
   
   </td>
   <td width="2%"></td>
 </tr>
</table>

<table border="0" style="width: 100%;">
	<tr>
		<td width="26%" align="center" valign="top">
			<p class="style11">
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
				.....................			</p>    </td>
		<td width="48%" align="center" valign="top">
			<p class="style11"><br/>
				<br/>
				<br/><br/><br/>
			</p>    </td>
		<td width="26%" align="center" valign="top">
			<p class="style11">Wali Kelas<br/>
				<br/>
				<br/><br/><br/>
				<?php echo "<u>".$row['wali_nama']."</u><br/>"; ?>
    	  </p>    </td>
	</tr>
</table>

</div>
<?php }?>