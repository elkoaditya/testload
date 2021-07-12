<?php

//$tanggal_rapor = '6 April 2015';
//$tanggal_rapor = '31 Oktober 2015';
//$tanggal_rapor = '31 Maret 2016';
$tanggal_rapor = $row['tanggal_mid_nama'];

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

function cariin($arre, $ky)
{
	if (is_array($arre) && isset($arre[$ky]))
	{
		return $arre[$ky];
	}
	else
	{
		return NULL;
	}

}

?>
<style type="text/css">
    <!--
	@page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 0px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
    .style7 {font-size: 11px; font-weight: bold; }
    <?php 
		if($row['kelas_grade']==10)
		{?>
		.style8 {font-size: 12px}
		<?php
		}else{?>
		.style8 {font-size: 13px}
		<?php
		}
	?>
	.style6 {font-size: 13px}
    .style9 {font-size: 15px}
    .style11 {font-size: 18px}
    .style20 {font-size: 20px}
    .style13 {
        font-size: 30px;
        font-weight: bold;
    }
    .style14 {
        font-size: 34px;
        font-weight: bold;
    }
    .style16 {font-size: 12px}
    .style17 {font-size: 13px}
    .style18 {font-size: 36px}
    .style19 {font-size: 28px}

	.backgrounds{

        background-image: url("http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/logo_setiabudhi3.png");
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center;
		/*
		opacity: 0.4;
		position: absolute;
		z-index: -1;
		*/
    }

    -->
</style>
<?php

foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];
	$ekskul_result 		= $ekskul_result_array[$cetak['id']];

	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend backgrounds">';
	 else
	 	echo '<div class="page backgrounds" id="page-1" >';	
?>	
	<table border="0" style="width: 100%;">
		<tr>

        <!--<td width="12%" rowspan="3" valign="top" class="style16"></td>-->
			<td width="88%" valign="top" class="style20" align="center"><b>LAPORAN CAPAIAN KOMPETENSI</b></td>
		</tr>
		<tr>
			<td valign="top" class="style20"  align="center"><b>TENGAH SEMESTER
            <?php if(strtolower($row['semester_nama'])=='gasal') 
				{	echo '1';	}
				else 
				{	echo '2';	} 
				?></b></td>
		</tr>
	</table><br>
	<table border="0" style="width: 100%;">
		<tr>

			<td width="12%" valign="top" class="style16"><b>Nama Siswa</b></td>
			<td width="1%" valign="top" class="style16">:</td>
			<td width="42%" valign="top" class="style16">
				<b><?php echo strtoupper($row_per_siswa['siswa_nama']); ?></b>
			</td>

			<td width="22%" valign="top" class="style16"><b>Kelas</b></td>
			<td width="1%" valign="top" class="style16">:</td>
			<td width="12%" valign="top" class="style16">
				<b><?php echo $row['kelas_nama']; ?></b>
			</td>

		</tr>
		<tr>

			<td valign="top" class="style16"><b>NIS</b> </td>
			<td valign="top" class="style16">:</td>
			<td valign="top" class="style16">
				<b><?php echo $row_per_siswa['siswa_nis']; ?></b>
			</td>

			<td valign="top" class="style16"><b>Semester</b> </td>
			<td valign="top" class="style16">:</td>
			<td valign="top" class="style16">
				<b><?php echo ucwords($row['semester_nama']); ?></b>
			</td>

		</tr>
		<tr>

			<td valign="top" class="style16"><b>Nama Sekolah</b> </td>
			<td valign="top" class="style16">:</td>
			<td valign="top" class="style16">
				<b>SMA Setiabudhi</b>
			</td>

			<td valign="top" class="style16"><b>Tahun Pelajaran</b> </td>
			<td valign="top" class="style16">:</td>
			<td valign="top" class="style16">
				<b>
					<?php echo $row['ta_nama']; ?></b>
			</td>

		</tr>
	</table>
	<?php 
		if($row['kelas_grade']!=10)
		{?>
		<br/>
		<?php
		}
	?>
    
	<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
		<tr>
			<th width="3%" rowspan="3" class="style8"><span class="style8">NO</span></th>
			<th width="37%" rowspan="3" class="style8"><span class="style8">MATA PELAJARAN</span></th>
			<th width="13%" rowspan="3" class="style8"><span class="style8">KRITERIA KETUNTASAN MINIMAL (KKM)</span></th>
			<th colspan="2" class="style8"><span class="style8">HASIL PENILAIAN </span></th>
		</tr>

		<tr>
			<th colspan="2" width="17%" class="style8"><span class="style8">U T S</span></th>
		</tr>

		<tr>
			<th width="10%" class="style8"><span class="style8">Angka</span></th>
			<th width="20%" class="style8"><span class="style8">Huruf</span></th>
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
		foreach ($resultset['data'] as $idx => $item): 
        if ($item['kategori_nama'] != $ktg_nama):

                $ktg_ascii++;
                $mp_no = 0;

				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                    <td valign="top" class="style8" align="center"><span class="style8"><strong>A</strong></span></td>
                    <td valign="top" class="style8"><span class="style8"><strong>MATA PELAJARAN</strong> </span></td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				<tr>
                    <td valign="top" class="style8" align="center"><span class="style8"><strong>B</strong></span></td>
                    <td valign="top" class="style8"><span class="style8"><strong>MUATAN LOKAL </strong></span></td>
                    <td align="center" valign="top" class="style8"><span class="style8"></span> </td>
                    <td align="center" valign="top" class="style8"><span class="style8"></span></td>
                    <td align="center" valign="top" class="style8"><span class="style8"></span></td>
                </tr> 
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="5"><span class="style8"><strong><?=$item['kategori_nama']?> </strong></span></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="5"><span class="style8"><strong><?=$item['kategori_nama']?> </strong></span></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="5"><span class="style8"><strong><?=$item['kategori_nama']?> </strong></span></td>
				  </tr>
                  <tr>
                  	  <td valign="top" class="style8" align="center"><span class="style8"><strong>I.</strong></span></td>
					  <td valign="top" class="style8" colspan="4"><span class="style8"><strong>Peminatan </strong></span></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	  <td valign="top" class="style8" align="center"><span class="style8"><strong>II.</strong></span></td>
					  <td valign="top" class="style8" colspan="4"><span class="style8"><strong>Lintas Minat </strong></span></td>
				  </tr>
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
			<tr>
				<td valign="top" class="style8" align="right"><span class="style8"><?php echo $idx + 1; ?>. </span></td>
				<td valign="top" class="style8"><span class="style8"><?php echo $item['mapel_nama']; ?><br/></span></td>
				<td align="center" valign="top" class="style8"><span class="style8"><?php echo round($item['nipel_kkm']); ?>&nbsp; </span></td>
				<?php

				/*
				  if (($item['mapel_nama'] != 'Seni Musik') &&
				  ($item['mapel_nama'] != 'Seni Budaya')
				  )
				  {
				 */

				?>
				<td align="center" valign="top" class="style8">
					<span class="style8">
						<?php

						if ($item['uts'] != '')
						{
							echo round($item['uts']);
						}
						//echo ($item['ppk_tengah_semester']) ? round($item['ppk_tengah_semester']) : '';

						?>
						&nbsp;
					</span>
				</td>
				<td align="center" valign="top" class="style8">
					<span class="style8">
						<?php

						if ($item['uts'] != '')
						{
							echo int2huruf(substr(round($item['uts']), 0, 1)) . " "
							. int2huruf(substr(round($item['uts']), 1, 1)) . " "
							. int2huruf(substr(round($item['uts']), 2, 1));
						}

						?>
					</span>
				</td>
				<?php

				/*
				  }
				  else
				  {
				  echo '<td align="center" valign="top" >-</td><td align="center" valign="top" >-</td>';
				  }
				 */

				/* / kayaknya ini kolom nilai praktek

				  if (
				  ($item['mapel_nama'] != 'Ekonomi') &&
				  ($item['mapel_nama'] != 'Geografi') &&
				  ($item['mapel_nama'] != 'Matematika') &&
				  ($item['mapel_nama'] != 'Pendidikan Agama Islam') &&
				  ($item['mapel_nama'] != 'Pendidikan Agama Katolik') &&
				  ($item['mapel_nama'] != 'Pendidikan Agama Kristen') &&
				  ($item['mapel_nama'] != 'Pendidikan Kewarganegaraan') &&
				  ($item['mapel_nama'] != 'Sejarah') &&
				  ($item['mapel_nama'] != 'Sosiologi')
				  )
				  {

				  ?>
				  <td align="center" valign="top" class="style8">
				  <span class="style8">
				  <?php

				  if ($item['prk_tengah_semester'] != '')
				  {
				  echo round($item['prk_tengah_semester']);
				  }

				  //echo ($item['prk_tengah_semester']) ? round($item['prk_tengah_semester']) : '';

				  ?>
				  &nbsp;
				  </span>
				  </td>
				  <td align="center" valign="top" class="style8">
				  <span class="style8">
				  <?php

				  if ($item['prk_tengah_semester'] != '')
				  {
				  echo int2huruf(substr(round($item['prk_tengah_semester']), 0, 1)) . " "
				  . int2huruf(substr(round($item['prk_tengah_semester']), 1, 1)) . " " . int2huruf(substr(round($item['prk_tengah_semester']), 2, 1));
				  }

				  ?>
				  </span>
				  </td>

				  <?php

				  }
				  else
				  {
				  echo '<td align="center" valign="top" >-</td><td align="center" valign="top" >-</td>';
				  }

				  // */

				//echo substr($mid[$idx],0,5);

				?>
			</tr>
		<?php endforeach; ?>
		
		
	</table>
	<br />




	Pengembangan Diri
	<br/>
	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
		<tr>
			<th width="5%"><span class="style8">No</span></th>
			<th width="35%" colspan="2"><span class="style8">Jenis Kegiatan </span></th>
			<th width="60%"><span class="style8">Keterangan</span></th>
		</tr>	<tr>
			<td align="center" valign="middle"><span class="style8"><strong>A</strong></span></td>
			<td colspan="2" valign="middle"><span class="style8"><strong>Kegiatan Extrakurikuler </strong></span></td>
			<td valign="middle" align="center"><span class="style8"></span></td>
		</tr>

		
             <?php
	$tampil_eskl = 0;
    foreach ($ekskul_result['data'] as $_idx => $_row):
		$ket_ekskul = '';
		$tampil_eskl = 1; ?>
       <tr>
			<td align="center" valign="middle"><span class="style8"></span></td>
			<td align="center" valign="middle"><span class="style8"><?=($_idx + 1)?></span></td>
            <td valign="middle"><span class="style8"><?php echo cariin($nilai_siswa, 'extra2_nama'); ?></span></td>
        <?php
        if(($_row['nilai']=='A')||($_row['nilai']=='a')):
			echo $ket_ekskul='Sangat Baik';
		elseif(($_row['nilai']=='B')||($_row['nilai']=='b')):
			echo $ket_ekskul='Baik';
		elseif(($_row['nilai']=='C')||($_row['nilai']=='c')):
			echo $ket_ekskul='Cukup';
		elseif(($_row['nilai']=='D')||($_row['nilai']=='d')):
			echo $ket_ekskul='Kurang';
		endif; ?>
		<td valign="middle" align="left"><span class="style8"><?php echo $ket_ekskul; ?></span></td>
		</tr>
		<?php
    endforeach;
	?>
	</table>

	<?php

	 $b[1] = ($row_per_siswa['absen_s']);
$b[2] = ($row_per_siswa['absen_i']);
$b[3] = ($row_per_siswa['absen_a']);

	?>

	<br/>
	<table width="100%" border="0" >
		<tr>
			<td width="50%">
				<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
					<tr>
						<td  width="270px" colspan="3" align="center"><div align="center" class="style8"> <strong>Kehadiran Siswa</strong></div></td>
					</tr>
					<tr>
						<td width="100%" align="center"><div align="center" class="style8" >Sakit</div></td>
						<td width="100%" align="center"><div align="center" class="style8" >Ijin </div></td>
						<td width="100%" align="center"><div align="center" class="style8" >Alpa</div></td>
					</tr>
					<tr>
						<?php

						for ($a = 1; $a <= 3; $a++)
						{

							?>
							<td align="center">
								<span class="style8" align="center">
									<?php

									if ($b[$a] != 0)
									{
										echo $b[$a];
									}
									else
									{
										echo "-";
									}

									?>
								</span>
							</td>
						<?php } ?>
					</tr>
	<!--                    <tr>
						<td><span class="style8" align="center">2</span></td>
						<td><span class="style8" align="center">Ijin</span></td>
						<td><span class="style8" align="center"><?php //echo ($item['absen_i']);                                                           ?> </span></td>
					</tr>
					<tr>
						<td><span class="style8" align="center">3</span></td>
						<td><span class="style8" align="center">Tanpa Keterangan </span></td>
						<td><span class="style8" align="center"><?php //echo ($item['absen_a']);                                                          ?> </span></td>
					</tr>-->
				</table>
			</td>
			<td width="50%"></td>
		</tr>
	</table>
    
	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
		<tr><td height="75" valign="top" align="left"><b>&nbsp;&nbsp;Catatan Wali Kelas</b>
				<br/><?php
				if(isset($row_per_siswa['note_walikelas']))
				{
					$catatan = str_replace("\n", "<br/>", ($row_per_siswa['note_walikelas']));
					echo $catatan;
				}
				?>
			</td></tr>
	</table>




	<br/>
	<p align="right" class="style6">
	   <!-- Semarang, <?php //echo tgl_indo(date('d-m-Y'));  ?>                                                        ?> --->
		Semarang, <?php echo $tanggal_rapor; ?>
	</p>


	<table border="0" style="width: 100%;">
		<tr>
			<td width="26%" align="center" valign="top">
				<p class="style6"><br/>
					Orang Tua/Wali
					<br/>
					<br/>
					<br/><br/><br/>
					....................			</p>    </td>
			<td width="48%" align="center" valign="top">
				<p class="style6"><br/>
					<br/>
					<br/><br/><br/>
					&nbsp;

				</p>    </td>
			<td width="26%" align="center" valign="top">
				<p class="style6">Mengetahui,<br/>
					Wali Kelas<br/>
					<br/>
					<br/><br/><br/>
					<?php

					echo "<u>" . $row['wali_nama'] . "</u>";
					?>
				</p>    </td>
		</tr>
	</table>
</div>
<?php }?>