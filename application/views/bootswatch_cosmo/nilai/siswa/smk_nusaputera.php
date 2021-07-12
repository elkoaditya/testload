<?php
//$tanggal_rapor = '24 Maret 2016';
$tanggal_rapor = '15 Oktober 2016';

function int2kata($n)
{
	if (is_null($n) or ! is_numeric($n))
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

function int2huruf($n)
{
	if (is_null($n) OR ! is_numeric($n))
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

//$rapor = array_shift($presensi['data']);

?>
<style type="text/css">
	@page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 0px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
	<!--
	.style3 {font-size: 11px}
	-->
	#header {
		text-align: center;
		font-family: cursive;
		font-size: 18px;
		margin-bottom: 10px;

	}
	#halaman {
		height:1500px;
	}
	.style4 {font-size: 11px}

	.kecil tr td{
		font-size: 11px;
		padding:4px 4px 4px 4px;

	}
	.kecil tr th{
		font-size: 12px;
		padding:5px 5px 5px 5px;

	}
	.style6 {font-size: 13px; }
</style>

<div id='header'>
	KARTU HASIL STUDI
	<br/>
	SMK NUSAPUTERA 1
</div>

<div id="halaman">

	<style>
		.t-profil {
			width: 100%;
			font-size: 10px;
			font-weight: bold;
		}
		.t-profil * {
			vertical-align: top;
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
	 	echo '<div id="bg_deskripsi" class="content page-notend backgrounds">';
	 else
	 	echo '<div class="page backgrounds" id="page-1" >';	
?>	
	<table class='t-profil' width="100%" border="0" style="">
		<tr>
			<td valign='top' width='65%'>

				<table width="100%" border="0">
					<tr>
						<td>
							Nama Siswa
						</td>
						<td> : </td>
						<td>
							<?php echo $row_per_siswa['siswa_nama']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Nomor Induk
						</td>
						<td> : </td>
						<td>
							<?php echo $row_per_siswa['siswa_nis']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Bidang Keahlian
						</td>
						<td> : </td>
						<td>
							TEKNOLOGI INFORMASI DAN KOMUNIKASI
						</td>
					</tr>
					<tr>
						<td>
							Program Keahlian
						</td>
						<td> : </td>
						<td>
							TEKNIK KOMPUTER DAN INFORMATIKA
						</td>
					</tr>
					<tr>
						<td>
							Kompetensi Keahlian
						</td>
						<td> : </td>
						<td>
							TEKNIK KOMPUTER DAN JARINGAN
						</td>
					</tr>
				</table>

			</td>
			<td valign='top' width='35%'>

				<table width="100%" border="0">
					<tr>
						<td>
							Tahun Pelajaran
						</td>
						<td> : </td>
						<td>
							<?php echo $row['ta_nama']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Kelas
						</td>
						<td> : </td>
						<td>
							<?php echo $row['kelas_nama']; ?>
						</td>
					</tr>
					<tr>
						<td>
							Semester
						</td>
						<td> : </td>
						<td>
							<?php echo ucwords($row['semester_nama']); ?>
						</td>
					</tr>
				</table>

			</td>
		</tr>
	</table>

	<br/>

	<table cellspacing="0" cellpadding="7" border="1" style="width:100%; border-collapse: collapse;" class="kecil">
		
        <tr>
			<th width="45px" rowspan="2">No</th>
			<th rowspan="2">Mata Pelajaran</th>
			<th width="90px" rowspan="2">
				Kriteria<br/>
				Ketuntasan<br/>
				Minimal
			</th>
			<?php if($row['kelas_grade']==10) 
			{?>
            	<th colspan="3">Nilai</th>
            <?php }else{ ?>
            	<th colspan="2">Nilai</th>
            <?php } ?>
		</tr>
		<tr>
			<th width="60px">Angka</th>
			<th width="60px">Huruf</th>
            <?php if($row['kelas_grade']==10) 
			{?>
            <th width="60px">Sikap</th>
            <?php }?>
		</tr>

	<?php

        $mp_no = 0;
		$kmp_no= 0;
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
				$kmp_no++;
				echo "<tr>";
				if($row['kelas_grade']!=10)
				{
					
						echo "<td align=\"left\" valign=\"middle\"><strong>&nbsp;&nbsp;{$kmp_no}</strong></td>";
						echo "<td colspan=\"4\"><strong>{$item['kategori_nama']}</strong></td>";
					
				}else{
					if($item['kategori_kode']=='KelC1'):
						echo "<td colspan=\"6\"><strong>Kelompok C (Peminatan)</strong></td>
						</tr>
						<tr>
						<td colspan=\"6\"><strong>{$item['kategori_nama']}</strong></td>";
                 	else:
						echo "<td colspan=\"6\"><strong>{$item['kategori_nama']}</strong></td>";
					endif;
				}
				echo "</tr>";
				$ktg_nama = $item['kategori_nama'];
			endif;
				
			$mp_no++;
			$mapel_nomor = $kmp_no . "." . $mp_no;
			$kkm = round($item['nipel_kkm']);
			$pembagi = (($item['mid_teori']>0) and ($item['mid_praktek']>0)) ? 2 : 1 ;
			$nilai = (is_numeric($item['mid_teori'])or is_numeric($item['mid_praktek'])) ? round(($item['mid_teori']+$item['mid_praktek'])/$pembagi) : '-';
			$kompetensi = ($nilai >= $kkm) ? 'K' : 'BK';
	
			echo "<tr>";
			if($row['kelas_grade']!=10)
				echo "<td align=\"left\" valign=\"middle\">&nbsp;&nbsp;{$mapel_nomor}</td>";
			else
				echo "<td align=\"left\" valign=\"middle\">&nbsp;&nbsp;{$mp_no}</td>";
			
			echo "<td valign=\"middle\">{$item['mapel_nama']}</td>";
			echo "<td valign=\"middle\" align=\"center\"><div align=\"center\">{$kkm}&nbsp; </div></td>";
			if($row['kelas_grade']==10) 
			{
				echo "<td valign=\"middle\" align=\"center\"><div align=\"center\">".$item['mid_teori']." </div></td>";
				echo "<td valign=\"middle\" align=\"center\"><div align=\"center\">".$item['mid_praktek']."</div></td>";
				echo "<td valign=\"middle\" align=\"center\"><div align=\"center\">".$item['pred_mid_sikap']."</div></td>";
			}else{
				echo "<td valign=\"middle\" align=\"center\"><div align=\"center\">{$nilai}&nbsp; </div></td>";
				echo "<td valign=\"middle\" align=\"center\"><div align=\"center\" class=\"style3\">{$kompetensi}</div></td>";
			}
			echo "</tr>";
			
		 endforeach;
		?>

		<tr>
			<td colspan="5">
				Keterangan nilai huruf: K = Kompeten, BK = Belum Kompeten
			</td>
		</tr>
	</table>
	<br/>

	<p align="right" class="style6">
		<!-- Semarang, 24 Maret 2016 -->
        Semarang, <?php echo $tanggal_rapor; ?>
	</p>

	<table border="0" style="width: 100%;">
		<tr>
			<td width="31%" align="center" valign="top">
				<p class="style6">
					Orang Tua/Wali
					<br/>
					Peserta Didik
					<br/>
					<br/>
					<br/>
					.....................
				</p>
			</td>
			<td width="31%" align="center" valign="top">
				<p class="style6">
					Wali Kelas
					<br/>
					<br/>
					<br/>
					<br/>
					<?= $row['wali_nama']; ?>
				</p>    </td>
			<td width="38%" align="center" valign="top">
				<p class="style6">
					Kepala Sekolah
					<br/>
					<br/>
					<br/>
					<br/>
					Drs. Ariawan Sudagijono
				</p>
			</td>
		</tr>
	</table>

</div>
<?php }?>