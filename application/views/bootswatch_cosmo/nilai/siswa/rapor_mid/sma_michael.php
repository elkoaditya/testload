<?php
 //≤ 
//$tanggal_rapor = '6 April 2015';
//$tanggal_rapor = '31 Oktober 2015';
//$tanggal_rapor = '31 Maret 2016';
//$tanggal_rapor = '22 Oktober 2016';
//$tanggal_rapor = '2 April 2017';
$tanggal_rapor = $row['tanggal_mid_nama'];

// if($row['kelas_grade']==10){
	$kurikulum = 'k13';
	$tampil_sub_nilai='Predikat';
	$jarak_enter="<br/>";
// }else{
	// $kurikulum = 'ktsp';
    // $tampil_sub_nilai='Huruf';
	// $jarak_enter="<br/><br/><br/>";
// }

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

function interval_pedikat()
{
?>	
	<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
     <tr>
      <td align="center" class="style8"><b>Interval</b></td>
      <td align="center" class="style8"><b>Predikat</b></td>
     </tr>
     <tr>
      <td align="center" class="style8">86 ≤  x ≤  100</td>
      <td align="center" class="style8">A</td>
     </tr>
     <tr>
      <td align="center" class="style8">70 ≤  x ≤  85</td>
      <td align="center" class="style8">B</td>
     </tr>
     <tr>
      <td align="center" class="style8">60 ≤  x ≤  69</td>
      <td align="center" class="style8">C</td>
     </tr>
     <tr>
      <td align="center" class="style8">x < 60</td>
      <td align="center" class="style8">D</td>
     </tr>
    </table>   
<?php
}
?>
<style type="text/css">
    
	@page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 0px 30 5px 30px;
    }

    .page *, td{
        font-size: 11px;
    }

    .page-notend{
        page-break-after: always;
    }

    .t-border{
        border-width: 1px;
        border-style: solid;
        border-color: black;
        border-collapse: collapse;

    }
    .t-border2{
        border-style: solid;
        border-color: black;
        border-collapse: collapse;
        border-bottom: 3px;

    }
    #t-nilai
    {
        width: 100%;
    }
    .thead-1{
        vertical-align: middle;
        text-align: center;
    }
    .thead-2{
        vertical-align: middle;
        text-align: center;
        padding: 7px;
    }
	
    .style7 {font-size: 11px; font-weight: bold; }
    <?php 
		if($row['kelas_grade']==10)
		{?>
		.style8 {font-size: 13px}
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
/*
	.backgrounds{

        background-image: url("http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/Logo SMA santo michael.jpg");
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-position: center;
		/*
		opacity: 0.4;
		position: absolute;
		z-index: -1;
		
    }
*/
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
	<div id="header-rapor" class="t-border2">

        <table border="0" cellspacing="0">
            <tr>
                <td width="13%">
                    <?php
                    $logo = array(
                        'src' => 'http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/Logo SMA santo michael.jp',
                        'width' => 80,
                    );
                    //echo img($logo);
                    ?>
					<!--&nbsp;<img src="http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/Logo SMA santo michael.jpg" width="80" />-->
					&nbsp;<img src="http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/Logo SMA santo michael new.jpeg" width="80" />
                
				</td>
                <td align="center">
                    <b>
                    <div id="head-2" class="style20">
                        YAYASAN BUDI LUHUR      
                    </div>
                    <div id="head-1" class="style20">                
                        SMA SANTO MICHAEL

                    </div>
                    <div id="head-2" class="style20">
                        (AKREDITASI A)      

                    </div>
                    </b>
                    <div class="style17">Jalan Teuku Umar 16 Semarang 50234<br/>
                    Telp.(024)8509701 E-mail : <u>smasanmic@gmail.com</u></div>
                </td>
            </tr>
        </table>

    </div>
    
	<table border="0" style="width: 100%;">
		<tr>

        <!--<td width="12%" rowspan="3" valign="top" class="style16"></td>-->
			<td width="88%" valign="top" class="style11" align="center"><b>
			<!--LAPORAN HASIL BELAJAR PESERTA DIDIK<br>
			TENGAH SEMESTER-->
			PENILAIAN TENGAH SEMESTER
            <?php if(strtolower($row['semester_nama'])=='gasal') 
				{	echo '1';	}
				else 
				{	echo '2';	} 
				?></b>
				<br></td>
		</tr>
	</table>
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
				<b>SMA Santo Michael</b>
			</td>

			<td valign="top" class="style16"><b>Tahun Pelajaran</b> </td>
			<td valign="top" class="style16">:</td>
			<td valign="top" class="style16">
				<b>
					<?php echo $row['ta_nama']; ?></b>
			</td>

		</tr>
	</table>
	<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
  <tr>
    <th width="5%" rowspan="3" class="style8">No.</th>
    <th width="220" rowspan="3" class="style8">Komponen</th>
    <th width="70" rowspan="3" class="style8">Kriteria Ketuntasan Minimal (KKM)</th>
    <th colspan="4" class="style8">Nilai Hasil Belajar</th>
  </tr>
  <tr>
    <th colspan="2" class="style8">Pengetahuan</th>
    <th colspan="2" class="style8">Keterampilan</th>
    <!--<th width="11%" class="style8">Sikap</th>-->
  </tr>
  <?php if($kurikulum == 'ktsp'){?>
  <tr>
    <th width="7%" class="style8">Angka</th>
    <th width="130" class="style8">
    <?=$tampil_sub_nilai?>
    </th>
    <th width="6%" class="style8">Angka</th>
    <th width="130" class="style8">
    <?=$tampil_sub_nilai?>
    </th>
    <th class="style8">Predikat</th>
  </tr>
  <?php }elseif($kurikulum == 'k13'){?>
  <tr>
    <th width="10%" class="style8">Angka</th>
    <th width="80" class="style8">
    <?=$tampil_sub_nilai?>
    </th>
    <th width="10%" class="style8">Angka</th>
    <th width="80" class="style8">
    <?=$tampil_sub_nilai?>
    </th>
    <!--<th class="style8">Predikat</th>-->
  </tr>
  <?php }?>
 
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
                $mp_no = 0;

				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                      <td align="center" valign="middle"><div class="style8"><b>A.</b></div></td>
                      <td valign="middle"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                  </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				 <tr>
					  <td align="center" valign="middle"><div class="style8"><b>B.</b></div></td>
					  <td valign="middle"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
				  </tr>
				  
				  <?php elseif($item['kategori_kode']=='K13mulok'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>I.</b></div></td>
					  <td valign="middle" colspan="6"><div class="style8"><b>Peminatan </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>II.</b></div></td>
					  <td valign="middle" colspan="6"><div class="style8"><b>Lintas Minat </b></div></td>
				  </tr>
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
		<tr>

			<td align="center" valign="middle"><div class="style8"><?php echo $mp_no; ?>.</div></td>
			<td valign="middle"><div class="style8"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style8"><?php echo round($item['nipel_kkm']); ?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style8"><?php
			if (is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
				echo "-";
			} else {
				echo ($item['mid_teori']) ? round($item['mid_teori']) : '';
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style8">
			<?php
			if (is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
			echo "-";
			} else {
				if($kurikulum=='k13'){
					echo $item['mid_pred_teori'];
				}else{
				
					echo int2kata(substr(round($item['mid_teori']),0,1))." "
					.int2kata(substr(round($item['mid_teori']),1,1))." "
					.int2kata(substr(round($item['mid_teori']),2,1));
				}
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center" class="style8">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
				echo ($item['mid_praktek']) ? round($item['mid_praktek']) : '-';
			}

			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style8">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
				if($kurikulum=='k13'){
					echo $item['mid_pred_praktek'];
				}else{
					echo int2kata(substr(round($item['mid_praktek']),0,1))." "
					.int2kata(substr(round($item['mid_praktek']),1,1))." "
					.int2kata(substr(round($item['mid_praktek']),2,1)) ;
				}
			}
			 ?>
			 </div></td>
			 <!--
			<td valign="middle" align="center"><div align="center" class="style8"><?php 
			if($kurikulum=='k13')
				echo $item['mid_pred_sikap'];
			else
				echo $item['pred_sikap']; ?></div></td>-->
		</tr>



	<?php endforeach; ?>
</table>
<br/>
<table>
 <tr>
  <td width="58%" valign="top">
<?php 
   // if($row['kelas_grade']==10){
    	
    	interval_pedikat();
	//}
    //echo "aaa";print_r($ekskul_result['data']);
	?>
  </td>
  <td valign="top">
  <!-- ABSENSI -->
  <?php
	$b[1] = ($row_per_siswa['absen_s']);
	$b[2] = ($row_per_siswa['absen_i']);
	$b[3] = ($row_per_siswa['absen_a']);
	?>
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
				</table>
			
   
  
  </td>
 </tr>
</table>
	<br/>
    Pengembangan Diri
	<br/>
	<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
		<tr>
			<th width="5%"><span class="style8">No</span></th>
			<th ><span class="style8">Kegiatan Extrakurikuler </span></th>
			<th width="12%"><span class="style8">Predikat </span></th>
			<th width="50%"><span class="style8">Keterangan</span></th>
		</tr>	

		
             <?php
	$tampil_eskl = 0;
    foreach ($ekskul_result['data'] as $_idx => $_row):
		
		$ket_ekskul = '';
		$tampil_eskl = 1; ?>
       <tr>
			<td align="center" valign="middle" width="30px"><span class="style8"><?=($_idx + 1)?></span></td>
            <td valign="middle"><span class="style8"><?php echo $_row['ekskul_nama']; ?></span></td>
			<td align="center" valign="middle"><span class="style8"><?php echo $_row['nilai']; ?></span></td>
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
	
	if($tampil_eskl==0)
	{
		?>
		<tr>
			<td align="center" > - </td>
			<td align="center" > - </td>
			<td align="center" > - </td>
			<td align="center" > - </td>
		</tr>
		<?php
	}
	?>
	</table>

	<br/>
	<div align="right" class="style6">
	   <!-- Semarang, <?php //echo tgl_indo(date('d-m-Y'));  ?>                                                        ?> --->
		Semarang, <?php echo $tanggal_rapor; ?>
	</div>


	<table border="0" style="width: 100%;">
		<tr>
			<td width="26%" align="center" valign="top">
				<p class="style6">
					<br/>
					Orang Tua/Wali
					<br/>
					<br/>
					<br/><br/><br/>
					....................			</p>    </td>
			<td width="48%" align="center" valign="top">
				<p class="style6">
					Mengetahui,<br/>
					Kepala Sekolah<br/>
                    <br/>
					<br/><br/><br/>
					L. Ruddy Sulistiawan, S. Pd
				</p>    </td>
			<td width="26%" align="center" valign="top">
				<p class="style6">
					<br/>
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