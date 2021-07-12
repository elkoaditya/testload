<?php
function footer_sekolah($evaluasi)
{
	$evaluasi['tipe'] = strtoupper(str_replace("_"," ",$evaluasi['tipe']));?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td colspan="2" width="100%" valign="top" style="border-top:solid; border-top-width:6; padding-top:-8"><strong><hr></strong></td>
        </tr>
        <tr>
            <td class="foot-text">
                <!-- USBK <?=$evaluasi['mapel_nama']?> -->
                <?=$evaluasi['tipe'];?> <?=$evaluasi['mapel_nama']?>

            </td>
            <td class="foot-text" align="right">
                Halaman {PAGENO}
            </td>
        </tr>
    </table>
<?php
}

$this->load->helper('dataset');

?>
<style>
	@page
	{
		sheet-size: 210mm 290mm;
		margin: -5mm 10mm 0mm 10mm;
		
		
		footer: html_footer_pagenum;
	}
	.page-notend{
		page-break-after: always;
	}
	.controls{
		font-size: 1.2em;
		margin: 0.2em 0;
		color: black;
	}
	.t-border2{
		border-style: solid;
		border-color: black;
		border-collapse: collapse;
		border-bottom: 3px;

	}
	.content
	{
		font-size: 12px;
	}
	.info
	{
		font-size: 11px;
		vertical-align:top; 
		padding: 5px 5px 5px 5px;
	}
	.head-1{
		text-align: left;
		font-size: 14px;
		font-weight: bold;
		padding: 3px 3px 3px 3px;
	}
	.head-2{
		text-align: center;
		font-size: 12px;
		font-weight: bold;
		padding: 3px 3px 3px 3px;
	}
	.head-3{
		text-align: left;
		font-size: 16px;
		font-weight: bold;
	}
</style>


		 <htmlpagefooter name="footer_pagenum">
			<div id="footer_pagenum" class="footer">
			<?php //footer_sekolah($evaluasi);	?>
			</div>
		</htmlpagefooter>
    
<?php
		
function tutup_table($data){
	echo '<tr>
		<td class="info"><br></td>
		<td class="info"></td>
		<td class="info"></td>
		<td class="info"></td>
		<td class="info"></td>
	</tr>';
	
	echo '</table>';
	
	//echo '<br><br>';
	echo '<table width="100%">';
		echo '<tr>';
			echo '<td width="65%"><td>';
			
			echo '<td align="center">
				Wali Kelas
				<br><br><br><br>
				'.$data['wali_nama'].'
			<td>';
			
		echo '</tr>';
	echo '</table>';
	
	echo '</div>';
} 
		
		//print_r($evaluasi);
		//echo"<br><br>";
		//print_r($resultset['data']);
		$count=0;
		$kelas_nama='';
		$jml =0;
		$tambah_td =0;
		foreach ($resultset['data'] as $data):
			$count++;
			$jml++;
			
			$evaluasi_mulai = explode(" ",$data['evaluasi_mulai']);
			$evaluasi_ditutup = explode(" ",$data['evaluasi_ditutup']);
			
			$tanggal_mulai='';
			if(isset($evaluasi_mulai[0])){
				$tanggal_mulai = tgl($evaluasi_mulai[0]);
			}
			
			$waktu_mulai='';
			if(isset($evaluasi_mulai[1])){
				$waktu_mulai = waktu($evaluasi_mulai[1]);
			}
			
			$waktu_tutup='';
			if(isset($evaluasi_ditutup[1])){
				$waktu_tutup = waktu($evaluasi_ditutup[1]);
			}
			
			if(($kelas_nama != $data['kelas_nama'])||(($jml%18)==1)){
				
				if($kelas_nama!=''){
					if($kelas_nama != $data['kelas_nama']){
						$jml=1;
					}
					
					$tambah_td=1;
					tutup_table($data);
				}
				echo '<div class="container page-notend">';
				
				// TITLE
				
				echo '<div align="center" class="head-1" padding-bottom="5px">
					DAFTAR HADIR<br>
					'.strtoupper($evaluasi['nama']).'<br>
					TAHUN PELAJARAN '.$evaluasi['ta_nama'].'<br>
					</div>';
				echo '<table border="0"  cellspacing="0" cellpadding="0" width="100%">';
				//print_r($data);
					echo '<tr>';
						echo '<td class="head-1" width="20%">Sekolah</td>';
						echo '<td class="head-1" width="3%">:</td>';
						echo '<td class="head-1">'.APP_SCHOOL.'</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="head-1">Kelas</td>';
						echo '<td class="head-1">:</td>';
						echo '<td class="head-1">'.$data['kelas_nama'].'</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="head-1">Hari/Tanggal</td>';
						echo '<td class="head-1">:</td>';
						echo '<td class="head-1">'.$tanggal_mulai.'</td>';
					echo '</tr>';
					
					echo '<tr>';
						echo '<td class="head-1">Waktu</td>';
						echo '<td class="head-1">:</td>';
						echo '<td class="head-1">'.$waktu_mulai.' - '.$waktu_tutup.'</td>';
					echo '</tr>';
				echo '</table>';
				
				
				// HEDER TABLE
				echo '<table border="1"  cellspacing="0" cellpadding="0" width="100%"  margin-top="5px">';
				//print_r($data);
				echo '<tr>';
					echo '<td class="head-2" width="5%">No</td>';
					echo '<td class="head-2" >Nama Siswa</td>';
					echo '<td class="head-2" width="20%">Waktu Absensi</td>';
					echo '<td class="head-2" width="22%">Status Pengerjaan</td>';
					echo '<td class="head-2" colspan="2">Tanda Tangan</td>';
				echo '</tr>';
				$kelas_nama = $data['kelas_nama'];
			}
			
			if($data['waktu_absensi']==''){
				$data['waktu_absensi'] = '<div style="color:red;"><b><i>Belum Absen</i></b></div>';
			}
			
			// Status Pengerjaan
			$status_pengerjaan = ' <div style="color:green;"><b><i>Selesai</i></b></div> ';
			if (!$data['ljs_id']){
				$status_pengerjaan = '<div style="color:red;"><b><i>Belum Mengerjakan</i></b></div> ';
			}elseif ($data['ljs_selesai']==0){
				$status_pengerjaan = '<div style="color:orange;"><b><i>Belum Selesai</i></b></div> ';
			}elseif (!$row['ljs_dikoreksi']){
				$status_pengerjaan = ' <div style="color:purple;"><b><i>Selesai & Belum di koreksi</i></b></div> ';
			}
			
			
			echo '<tr>';
				echo '<td class="info" align="right" style="height:40px">'.$jml.'. </td>';
				echo '<td class="info">'.strtoupper($data['siswa_nama']).'</td>';
				echo '<td class="info">'.$data['waktu_absensi'].'</td>';
				echo '<td class="info">'.$status_pengerjaan.'</td>';
				echo '<td class="info" valign="top" rowspan="2" width="15%" >'.$jml.'.<br> <img width="80px" src="'.$data['image_absensi'].'" alt="Red dot"></td>';
			
				if($tambah_td==1){
					echo '<td class="info"></td>';
					$tambah_td = 0;
				}
			echo '</tr>';
			
		
		endforeach;
		tutup_table($data);
		
		
		?>