<?php
// komponen
//print_r($evaluasi);
//echo"<br><br>";
//print_r($resultset);
include('pdf/header_footer_pdf.php');

$this->load->helper('dataset');

// tabel data
$ds_row = array(
		'data' => array(
				'Mata Pelajaran &nbsp;' => array('mapel_nama', 'prefix' => ': '),
				
		),
);
$ds_row2 = array(
		'data' => array(
				'Hari / Tanggal &nbsp;&nbsp;' => array('evaluasi_mulai', 'tgl', 'prefix' => ': '),
		),
);
$ds_row3 = array(
		'data' => array(
				'Kelas &nbsp; ' => array('kelas_nama','prefix' => ': '),
				'Waktu &nbsp; ' => array('evaluasi_mulai - evaluasi_ditutup','waktu' ,  'prefix' => ': '),
				' - '	=> array('evaluasi_ditutup','waktu'),
		),
);


?>
<div class="container">

	<!-- Typography	================================================== -->
	<div id="tabel">
		<div class="page-header alert-block">
			<?php header_sekolah(APP_SCOPE,$evaluasi);?>
			<!-- <h1><?php echo strtoupper($evaluasi['nama']) ?></h1> -->
		</div>

		<style>
			@page
            {
                sheet-size: 210mm 330mm;
                margin: 3mm 10mm 0mm 10mm;
                margin-header: 10mm;
                margin-footer: 15mm;
                footer: html_footer_pagenum;
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
			.content, .content *, td
            {
                font-size: 12px;
            }
			.info
            {
                font-size: 13px;
				vertical-align:top; 
            }
			#head-1{
				text-align: left;
				font-size: 18px;
				font-weight: bold;
			}
			 #head-2{
				text-align: left;
				font-size: 16px;
				font-weight: bold;
			}
			 #head-3{
				text-align: left;
				font-size: 14px;
			}
		</style>

		 <htmlpagefooter name="footer_pagenum">
        <div id="footer_pagenum" class="footer">
        <?php footer_sekolah($evaluasi);	?>
        </div>
    </htmlpagefooter>
    
		<?php
		// data utama

		echo"
		<div class='t-border2'>
			<table width='100%' >
				<tr>";
			echo "<td class='info' width='16%' >Mata Pelajaran</td>";
			echo "<td class='info' width='42%'>: ";
			if(($evaluasi['mapel_id']==11 || $evaluasi['mapel_id']==12 || $evaluasi['mapel_id']==2 || $evaluasi['mapel_id']==1)
			&&($evaluasi['kategori_id']==4 || $evaluasi['kategori_id']==3))
				echo  $evaluasi['mapel_nama']." Wajib ";
			elseif($evaluasi['kategori_id']==5)
				echo  $evaluasi['mapel_nama']." Peminatan ";
			elseif($evaluasi['kategori_id']==6)
				echo  $evaluasi['mapel_nama']." Lintas Minat ";
			elseif($evaluasi['agama_id']>0)
				echo  $evaluasi['mapel_nama']." ( ". $evaluasi['agama_nama']." ) ";
			else
				echo  $evaluasi['mapel_nama'];
			
			echo "</td> ";
			echo "<td class='info' width='14%'>Hari / Tanggal</td>";
			echo "<td class='info' >: ". tgl($evaluasi['kelas_result']['data'][$request['kelas_id']]['evaluasi_mulai'],FALSE,'slash')."</td> ";
			
			
			echo "</tr><tr>";
			echo "<td class='info' >Kelas / Program</td>";
			echo "<td class='info' >: ". $evaluasi['kelas_result']['data'][$request['kelas_id']]['kelas_nama']."</td> ";
			/*
			if(($evaluasi['mapel_id']==11 || $evaluasi['mapel_id']==12 || $evaluasi['mapel_id']==2 || $evaluasi['mapel_id']==1)
			&&($evaluasi['kategori_id']==5))
				echo "<td class='info' >: XII / MIPA </td>";
			elseif(($evaluasi['mapel_id']==11 || $evaluasi['mapel_id']==12 || $evaluasi['mapel_id']==2 || $evaluasi['mapel_id']==1)
			&&($evaluasi['kategori_id']==6))
				echo "<td class='info' >: XII / IPS </td>";
			
			elseif(($evaluasi['mapel_id']==16 || $evaluasi['mapel_id']==15 || $evaluasi['mapel_id']==14 || $evaluasi['mapel_id']==13)
			&&($evaluasi['kategori_id']==5))
				echo "<td class='info' >: XII / IPS </td>";
			elseif(($evaluasi['mapel_id']==16 || $evaluasi['mapel_id']==15 || $evaluasi['mapel_id']==14 || $evaluasi['mapel_id']==13)
			&&($evaluasi['kategori_id']==6))
				echo "<td class='info' >: XII / MIPA </td>";
					
			else
				echo "<td class='info' >: XII / MIPA-IPS </td>";
			*/
			echo "<td class='info' >Waktu</td>";
			echo "<td class='info' >: ". waktu($evaluasi['kelas_result']['data'][$request['kelas_id']]['evaluasi_mulai']).
			" - ".  waktu($evaluasi['kelas_result']['data'][$request['kelas_id']]['evaluasi_ditutup'])."</td> ";
			echo"
				</tr>
			</table>
			
		</div>";
		// butir jawaban
		echo '<br/><span style="font-size:13px;"><b>Pilihlah satu jawaban yang tepat dengan cara mengeklik pada salah satu jawaban A, B, C, D atau E !</b></span><br/>';
		echo '<br/><table border="0">';

		foreach ($resultset['data'] as $idx => $butir):
			soal_prepljs_print($butir);
			
			echo '<tr>';
			echo '<td valign="top" align="right">' . ($idx + 1) . '. &nbsp; </td>';
			echo '<td colspan="2" valign="top">';

			// tampilkan pertanyaan
			//print_r($butir);
			$butir['pertanyaan'] = trim($butir['pertanyaan']);
			$butir['pertanyaan'] = str_replace('../../','/',$butir['pertanyaan']);
			
			$butir['pertanyaan'] = str_replace("/content",APP_ROOT."content",$butir['pertanyaan']);
			$butir['pertanyaan'] = str_replace("?img=kbm","",$butir['pertanyaan']);
			$butir['pertanyaan'] =str_replace('/>','style="max-height:200px;" />',$butir['pertanyaan']);
			
			
			
			echo $butir['pertanyaan'] ;
			echo '</td></tr>';
				$pilihan_tambahan=0;
				$opsi['a']='Semua Opsi Salah';
				$opsi['b']='Semua Opsi Salah';
				$opsi['c']='Semua Opsi Salah';
				$opsi['d']='Semua Opsi Salah';
				$opsi['e']='Semua Opsi Salah';
				foreach ($butir['opsi'] as $idx2 => $ket):
					//echo ul($butir['opsi']);
					$opsi[$idx2]= trim($ket);
					$opsi[$idx2] =str_replace('../../','/',$opsi[$idx2]);
					
					$opsi[$idx2] =str_replace("/content",APP_ROOT."content",$opsi[$idx2]);
					$opsi[$idx2] =str_replace("?img=kbm","",$opsi[$idx2]);
					$opsi[$idx2] =str_replace('/>','style="min-height:20px;" />',$opsi[$idx2]);
					
					

					$cek[$idx2]= str_replace("<p>","",$opsi[$idx2]);
					$cek[$idx2]= str_replace("</p>","",$cek[$idx2]);
					$cek[$idx2]= str_replace("<br>","",$cek[$idx2]);
					$cek[$idx2]= str_replace("<br/>","",$cek[$idx2]);
					$cek[$idx2]= trim($cek[$idx2]);
					
					
					if( $cek[$idx2]=='A' || $cek[$idx2]=='a' ||
					$cek[$idx2]=='B' || $cek[$idx2]=='b' ||
					$cek[$idx2]=='C' || $cek[$idx2]=='c' ||
					$cek[$idx2]=='D' || $cek[$idx2]=='d' ||
					$cek[$idx2]=='E' || $cek[$idx2]=='e' )
					{	$pilihan_tambahan++;}
					
					//if($evaluasi['mapel_id']==1)
						//$opsi[$idx2] = str_replace("<img","<img width='50%'",$opsi[$idx2]);
			
				endforeach;
				
				//echo"<table width='100%'>";
				
				if($pilihan_tambahan<4)
				{
					//$opsi['a'] =str_replace("img"," cetak ",$opsi['a']);
					echo "<tr><td></td><td valign='top' width='10px'> A. </td><td>".$opsi['a']."</td></tr>";
					echo "<tr><td></td><td valign='top'> B. </td><td>".$opsi['b'].'</td></tr>';
					echo "<tr><td></td><td valign='top'> C. </td><td>".$opsi['c'].'</td></tr>';
					echo "<tr><td></td><td valign='top'> D. </td><td>".$opsi['d'].'</td></tr>';
					echo "<tr><td></td><td valign='top'> E. </td><td>".$opsi['e'].'</td></tr>';
				}
				//echo"</table>";
				
				if($request['kunci']=="1")
				{
					echo "<tr><td></td><td colspan='2'><b>KUNCI : ".strtoupper($butir['pilihan']['kunci']['index'])."</b></td></tr><br>";
				}

			echo '<br/></td>';
			echo '</tr>';

		endforeach;

		echo '</table>';
		?>

	</div>

</div><!-- /container -->
