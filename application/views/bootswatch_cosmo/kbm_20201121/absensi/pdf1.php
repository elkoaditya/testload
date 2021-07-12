<?php
// komponen
//print_r($evaluasi);
//echo"<br><br>";
//print_r($resultset);

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

function header_sekolah()
{
?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php /*
                $logo = array(
                    'src' => 'content/sma1_smg/Logo Dinas Pend.jpg',
                    'width' => 80,
                    'height' => 104,
                );
                echo img($logo);*/
				$logo2 = array(
					'src' => 'content/sma1_smg/Logo SMA1.jpg',
					'width' => 70,
					'height' => 106,
				);
				echo img($logo2);
                ?>&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    UJIAN SEKOLAH BERBASIS KOMPUTER <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran 2015/2016<br/>
                </div>
                <div id="head-1">
                    SMA NEGERI 1 SEMARANG<br/>
                </div>
                <div id="head-3">
                Jalan Taman Menteri Supeno No.1 Semarang 50243<br/>
                Telp.(024)8310447 - 8318539 Fax.(024)8414851 E-mail : sma1semarang@yahoo.co.id
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}
?>
<div class="container">

	<!-- Typography	================================================== -->
	<div id="tabel">
		<div class="page-header alert-block">
			<?php header_sekolah();?>
			<!-- <h1><?php echo strtoupper($evaluasi['nama']) ?></h1> -->
		</div>

		<style>
			@page
            {
                size: 210mm 330mm;
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
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td colspan="2" width="100%" valign="top" style="border-top:solid; border-top-width:6; padding-top:-8"><strong><hr></strong></td>
                </tr>
                <tr>
                    <td class="foot-text">
                    	USBK <?=$evaluasi['mapel_nama']?>
    
                    </td>
                    <td class="foot-text" align="right">
                        Halaman {PAGENO}
                    </td>
                </tr>
            </table>
        </div>
    </htmlpagefooter>
    
		<?php
		// data utama

		echo"
		<div class='t-border2'>
			<table width='100%' >
				<tr>";
			echo "<td class='info' width='16%' >Mata Pelajaran</td>";
			if(($evaluasi['mapel_id']==11 || $evaluasi['mapel_id']==12 || $evaluasi['mapel_id']==2 || $evaluasi['mapel_id']==1)
			&&($evaluasi['kategori_id']==4 || $evaluasi['kategori_id']==3))
				echo "<td class='info' width='45%'>: ". $evaluasi['mapel_nama']." Wajib</td> ";
			elseif($evaluasi['kategori_id']==5)
				echo "<td class='info' width='45%'>: ". $evaluasi['mapel_nama']." Peminatan</td> ";
			elseif($evaluasi['kategori_id']==6)
				echo "<td class='info' width='45%'>: ". $evaluasi['mapel_nama']." Lintas Minat</td> ";
			elseif($evaluasi['agama_id']>0)
				echo "<td class='info' width='45%'>: ". $evaluasi['mapel_nama']." ( ". $evaluasi['agama_nama']." )</td> ";
			else
				echo "<td class='info' width='45%'>: ". $evaluasi['mapel_nama']."</td> ";
			
			echo "<td class='info' width='14%'>Hari / Tanggal</td>";
			echo "<td class='info' >: ". tgl($evaluasi['kelas_result']['data'][$request['kelas_id']]['evaluasi_mulai'],FALSE,'slash')."</td> ";
			
			
			echo "</tr><tr>";
			echo "<td class='info' >Kelas / Program</td>";
			//echo "<td class='info' >: ". $evaluasi['kelas_result']['data'][$request['kelas_id']]['kelas_nama']."</td> ";
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
			soal_prepljs($butir);
			
			echo '<tr>';
			echo '<td valign="top" align="right">' . ($idx + 1) . '. &nbsp; </td>';
			echo '<td colspan="2" valign="top">';

			// tampilkan pertanyaan
			//print_r($butir);
			$butir['pertanyaan']= trim($butir['pertanyaan']);
			
			//if($evaluasi['mapel_id']==1)
				//$butir['pertanyaan'] = str_replace("<img","<img width='50%'",$butir['pertanyaan']);
			
			echo $butir['pertanyaan'] ;
			echo '</td></tr>';
				$pilihan_tambahan=0;
				foreach ($butir['opsi'] as $idx2 => $ket):
					//echo ul($butir['opsi']);
					$opsi[$idx2]= trim($ket);
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
				echo "<tr><td></td><td valign='top' width='10px'> A. </td><td>".$opsi['a']."</td></tr>";
				echo "<tr><td></td><td valign='top'> B. </td><td>".$opsi['b'].'</td></tr>';
				echo "<tr><td></td><td valign='top'> C. </td><td>".$opsi['c'].'</td></tr>';
				echo "<tr><td></td><td valign='top'> D. </td><td>".$opsi['d'].'</td></tr>';
				echo "<tr><td></td><td valign='top'> E. </td><td>".$opsi['e'].'</td></tr>';
				}
				//echo"</table>";
				
				//echo "KUNCI : ".$butir['pilihan']['kunci']['index']."<br><br>";


			echo '<br/></td>';
			echo '</tr>';

		endforeach;

		echo '</table>';
		?>

	</div>

</div><!-- /container -->
