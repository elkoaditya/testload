<?php

////////////////////////////
//////////PDF///////////////
////////////////////////////

function header_2013_v1($data)
{
	$smster_nama = '2(dua)';
	if($data['semester_nama'] == 'gasal'){
		$smster_nama = '1(satu)';
	}
	$ta_nama = str_replace("/"," - ",$data['ta_nama']);
	$html= '
	<div id="header_1" class="header">
		<table width="100%" border="0" style="width: 100%;">
			<tr>
			  <td width="23%"	valign="top"><span class="style1">Nama Peserta Didik</span> </td>
			  <td width="1%"	valign="top"><span class="style1">:</span></td>
			  <td width="35%" 	valign="top"><span class="style1"><em>'.$data['siswa_nama'].'</em></span></td>
			  
			  <td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
			  <td width="1%" valign="top"><span class="style1">:</span></td>
			  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;">'.$data['kelas_nama'].'/
			  '.$smster_nama.'</span></td>
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nomor Induk</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$data['siswa_nis'].'</span> </td>
			  
			  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td valign="top"><span class="style1">'.$ta_nama.'</span></td>
			  
			</tr>
			<tr>
			  <td valign="top"><span class="style1">Nama Sekolah</span> </td>
			  <td valign="top"><span class="style1">:</span></td>
			  <td colspan="4" valign="top"><span class="style1">'.APP_SCOPE.'</span> </td>
			  
			</tr>
		</table>
	</div>';
	return $html;
}

function footer_2013_v1($data)
{
	$html= '
	<div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text">
						'.$data['kelas_nama'].'
                    </td>
                    <td class="foot-text" align="right">
                       <!-- Hal. {PAGENO}-->
                       Semeter '.$data['semester_nama'].' - '.$data["ta_nama"].'
                    </td>
                </tr>
            </table>
        </div>';
	return $html;
}


function head_table_nilai_2013_v1()
{
	$html ='
	<tr>
        <td class="thead-1 t-border color-menu" rowspan="2" width="20px"><b>NO</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Keterampilan </b></td>
        
    </tr>

    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        
    </tr>';
	return $html;
}


function sikap_2013_v1($data,$row,$ktg_nama,$jml_row, $deskripsi_array)
{
	$deskripsi_sikap_sosial = $deskripsi_array['sikap_sosial'];
	$deskripsi_sikap_spiritual = $deskripsi_array['sikap_spiritual'];
				for($x=1;$x<=3;$x++)
				{
					$nilai_sosial[$x]		= 0;
					$nilai_spiritual[$x]	= 0;
				}
				
                foreach ($data as $idx => $item)
                {
					if(($item['pred_sikap']=='A')||($item['pred_sikap']=='a')||($item['pred_sikap']=='SB')||($item['pred_sikap']=='sb')){
						$nilai_sosial[1]++;
						$nilai_spiritual[1]++;
					}elseif(($item['pred_sikap']=='B')||($item['pred_sikap']=='b')){
						$nilai_sosial[2]++;
						$nilai_spiritual[2]++;
					}elseif(($item['pred_sikap']=='C')||($item['pred_sikap']=='c')){
						$nilai_sosial[3]++;
						$nilai_spiritual[3]++;
					}
					
                    if ($item['kategori_nama'] != $ktg_nama){
                        $ktg_nama = $item['kategori_nama'];
                        $jml_row++;
                    }
                    $jml_row++;
                }
				
				//nilai sikap BK
				if(($row["nilai_sikap_bk"]=='A')||($row["nilai_sikap_bk"]=='a')||($row["nilai_sikap_bk"]=='SB')||($row["nilai_sikap_bk"]=='sb')){
					$nilai_sosial[1]++;
					$nilai_spiritual[1]++;
				}elseif(($row["nilai_sikap_bk"]=='B')||($row["nilai_sikap_bk"]=='b')){
					$nilai_sosial[2]++;
					$nilai_spiritual[2]++;
				}elseif(($row["nilai_sikap_bk"]=='C')||($row["nilai_sikap_bk"]=='c')){
					$nilai_sosial[3]++;
					$nilai_spiritual[3]++;
				}
				//nilai sikap WALI
				if(($row["nilai_sikap_wali"]=='A')||($row["nilai_sikap_wali"]=='a')||($row["nilai_sikap_wali"]=='SB')||($row["nilai_sikap_wali"]=='sb')){
					$nilai_sosial[1]++;
					$nilai_spiritual[1]++;
				}elseif(($row["nilai_sikap_wali"]=='B')||($row["nilai_sikap_wali"]=='b')){
					$nilai_sosial[2]++;
					$nilai_spiritual[2]++;
				}elseif(($row["nilai_sikap_wali"]=='C')||($row["nilai_sikap_wali"]=='c')){
					$nilai_sosial[3]++;
					$nilai_spiritual[3]++;
				}
				
				
	$html ='
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>';
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	$html .= $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				$html .= $deskripsi_sikap_spiritual[3];
			}
			$html .='
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>
			';
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	$html .= $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				$html .= $deskripsi_sikap_sosial[3];
			}
	$html .= '
            </td>
        </tr>
	  </table>';
	  return $html;
}





function tanggapan_ortu_2013_v1($ekskul_result)
{
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '35px';
	}else{
		$height = '65px';
	}

	$html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"></td>
        </tr>
	  </table>';
      if($jumlah_ekskul>3){
     
       }else{ 
      $html.= '<br/><br/>';
	   }
	return $html;
}


function ketidakhadiran_2013_v1($ketidakhadiran)
{
	$absen_s = '-';
	$absen_i = '-';
	$absen_a = '-';
	if($ketidakhadiran['absen_s'] > 0){
		$absen_s = $ketidakhadiran['absen_s'].' hari';
	}
	if($ketidakhadiran['absen_i'] > 0){
		$absen_i = $ketidakhadiran['absen_i'].' hari';
	}
	if($ketidakhadiran['absen_a'] > 0){
		$absen_a = $ketidakhadiran['absen_a'].' hari';
	}
	$html ='
	<table cellspacing="0" class="t-border field-nilai" width="50%" >
        
        <tr>
            <td width="50%" class=" field-nilai">Sakit</td>
            <td class="t-border field-nilai"> :  '.$absen_s .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Ijin</td>
            <td class="t-border field-nilai"> :  '.$absen_i .'</td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Tanpa Keterangan</td>
            <td class="t-border field-nilai"> : '.$absen_a .'</td>
        </tr>
    </table>';
	return $html;
}

function catatan_walikelasv1($siswa_nama , $nilai_catatan_walikelas,$row,$ekskul_result)
{
	if ((strtolower($row["semester_nama"]) == "genap"))
	{
		$keterangan_walikelas = array(
	
			'1' =>	$siswa_nama.' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
					
			'2' =>	$siswa_nama.' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
				
			'3' => $siswa_nama.' berusahalah lebih keras dan tetap semangat untuk meraih cita - citamu.',	
		);
	
	}else{
	
		$keterangan_walikelas = array(
	
			'1' =>	$siswa_nama.' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
					
			'2' =>	$siswa_nama.' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
				
			'3' => $siswa_nama.' berusahalah lebih keras dan tetap semangat untuk meraih hasil yang lebih baik.',	
		);
	
	}
	
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '50px';
	}else{
		$height = '65px';
	}
	
    $html ='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="'.$height.'"> Deskripsi:
            <br/>'; 
			if($nilai_catatan_walikelas>=90)
				$html.= $keterangan_walikelas['1'];
			elseif($nilai_catatan_walikelas>=80)
				$html.= $keterangan_walikelas['2'];
			else
				$html.= $keterangan_walikelas['3'];
			$html.= '</td>
        </tr>
	  </table>';
	  return $html;
}

function prestasi_2013_v1($prestasi_result)
{
	$html = '
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Jenis Prestasi</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>';

		$cetak_prestasi=0;
		$no=0;
        foreach ($prestasi_result['data'] as $_idx => $_row)
        {
			if($_row['prestasi_nama']!='')
			{
				$cetak_prestasi=1;
				$no++;
				$html.= '<tr>' . NL;
				$html.= '"<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >"' . $no . '"</td>" '. NL;
				$html.= '"<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">'. $_row['kegiatan_prestasi_nama'].'</td>"' . NL;
				$html.= '"<td class=\"t-border field-nilai\" valign=\"top\">'.$_row['prestasi_nama'].'</td>"' . NL;
				$html.= '"</tr>" . NL';
			}
        }

        if ($cetak_prestasi==0)
        {
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            $html.= "</tr>" . NL;
        }
		$html.='</table>';
		return $html;
}


function ekstrakurikuler_2013_v1($ekskul_result)
{
	$html='
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>
        ';

        foreach ($ekskul_result['data'] as $_idx => $_row)
        {
            $nisixk['nilai'] = strtoupper($_row['nilai']);

            if (strpos($nisixk['nilai'], 'A') !== false)
            {
                $set_ekskul_keterangan = 'Sangat Baik';
            }
            elseif (strpos($nisixk['nilai'], 'B') !== false)
            {
                $set_ekskul_keterangan = 'Baik';
            }
            else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan}</td>" . NL;
            $html.= '</tr>' . NL;
        }

        if (count($ekskul_result['data']) == 0)
        {
            $html.= '<tr>' . NL;
			$html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            $html.= "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            $html.= '</tr>' . NL;
        }

    $html.='</table>';
	return $html;
}


function style_2013_v1()
{
	$html='
	<style>
            @page
            {
                size: 210mm 297mm;
                margin: 3mm 10mm 0mm 10mm;
                margin-header: 10mm;
                margin-footer: 15mm;
                header: html_header_1;
                footer: html_footer_pagenum;
            }
            .page-notend{
                page-break-after: always;
            }

			.field-header
            {
				/*font-size:14px;*/
				padding: 2px 0px 2px 0px;
            }
			
            .content, .content *, td
            {
                font-size: 10px;
            }

            .foot-text
            {
                font-size: 10px;
                font-style: italic;
            }

            .t-border
            {
                border-width: 1px;
                border-style: solid;
                border-color: black;
                border-collapse: collapse;

            }

            #t-nilai
            {
                width: 100%;
            }

            .thead-1{
                vertical-align: middle;
                text-align: center;
				font-size:12px;
            }

			.field-nilai
            {
				font-size:11px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:11px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 12px;
            }
			.sub-kategori{
                font-size: 12px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
			.style1 {font-size: 14px}
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>
      ';
	return $html;
}
function tableextra_2013_v1($ekskul_result,$prestasi_result,$row_per_siswa,$nilai_catatan_walikelas,$row){ 
	$html = '
	<table>   
         <tr>
          <td class="sub-kategori"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ekstrakurikuler_2013_v1($ekskul_result) .'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	 '.prestasi_2013_v1($prestasi_result).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.ketidakhadiran_2013_v1($row_per_siswa).'
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.catatan_walikelasv1($row_per_siswa["siswa_nama"],$nilai_catatan_walikelas,$row,$ekskul_result).'
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  '.tanggapan_ortu_2013_v1($ekskul_result).'
          		
          </td>
         </tr>
         
        </table>
	';
	return $html;
}


function tablepdfv1($resultset,$row,$deskripsi_array,$type_return)
{
	$mp_no = 0;
	$ktg_ascii = 64;
	$ktg_nama = NULL;
	$jml_row = 0;
	$nilai_catatan_walikelas = 100;
	$mode_range = 100;
	$deskripsi_pelajaran = $deskripsi_array['deskripsi_pelajaran'];
	$html = '
		<table>
			<tr>
				<td class="sub-kategori" width="20px"><b>A.</b></td>
				<td class="sub-kategori"><b>Sikap</b></td>
			</tr>
			<tr>
				<td></td>
				<td>';
    $html .= 
			sikap_2013_v1($resultset['data'],$row,$ktg_nama,$jml_row, $deskripsi_array);
//     $html .= '<br/><br/>';
     $html .= ' 
				</td>
			</tr>
			<tr>
				<td class="sub-kategori"><b>B.</b></td>
				<td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .=	head_table_nilai_2013_v1();
    
				$ktg_nama = NULL;
				$antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
                        $ktg_ascii++;
                        $mp_no = 0;
    $html .=            '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=                "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
    $html .=                "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
    $html .=             '</tr>
					</table>                                
                </td>
            </tr>
		</table>
	</div>
    <div id="bg_deskripsi" class="content page-notend">

        <div id="header_1" class="header">';
	$html .= header_2013_v1($row);
	$html .= '
        </div>
		<table>
			<tr>
				<td class="sub-kategori" width="20px"></td>
                <td class="sub-kategori">
                    <table cellspacing="0" id="t-nilai" class="t-border" >';
    $html .= 		head_table_nilai_2013_v1();
	$html .= '			<tr>';
    $html .=            	"<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>".$item['kategori_nama']."</b></td>" . NL;
                        }
                        else
                        {
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>".$item['kategori_nama']."</b></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
    $html .=               "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                        }
    $html .=        	'</tr>' . NL;
                        $ktg_nama = $item['kategori_nama'];
                    }
                    $mp_no++;
    $html .=        	'<tr>' . NL;
    $html .=        		"<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
    $html .=        		"<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	$cetak_kkm = 75;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
	$html .=        		"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        if ($item['nas_teori']>0)
                        {
                            if($mode_range==100)
							{	$cetak_nas_teori = round($item['nas_teori']);	}
							elseif($mode_range==4)
                            {	$cetak_nas_teori = round(($item['nas_teori']/25),2);	}
							
							if( ( (
								(($item['mapel_id']=='10')||($item['mapel_id']=='1'))
								&&($item['kategori_kode'] == "KelA"))
								||($item['kategori_kode'] == "KelC")) 
								&&($nilai_catatan_walikelas > $item['nas_teori']))
							{	$nilai_catatan_walikelas = $item['nas_teori'];	}
							
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_teori'] . "</td>" . NL;
                        }
                        else
                        {
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        }
                    }
                    else
                    {
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    }
					
					//////// DESKRIPSI PENGETAHUAN //////////////////
					$cetak_des = 0;
					foreach ($deskripsi_pelajaran['data'] as $deskripsi)
					{
						if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
						{
							if(	( $item['pred_teori']=='A' && $deskripsi['kode']==1 )||
								( $item['pred_teori']=='B' && $deskripsi['kode']==2 )||
								( $item['pred_teori']=='C' && $deskripsi['kode']==3 )||
								( $item['pred_teori']=='D' && $deskripsi['kode']==4 )	)
							{							
								if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
								{
									$cetak_des = 1;
	$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
					}
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($item['nas_praktek']>0)
                        {
                            if($mode_range==100)
							{	$cetak_nas_praktek = round($item['nas_praktek']);	}
							elseif($mode_range==4)
                            {	$cetak_nas_praktek = round(($item['nas_praktek']/25),2);	}
							
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_praktek'] . "</td>" . NL;
                        }
                        else
                        {
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        }
                    }
                    else
                    {
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
	$html .=				"<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    }
    
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    $cetak_des = 0;
					foreach ($deskripsi_pelajaran['data'] as $deskripsi)
					{
						if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
						{
							if(	( $item['pred_praktek']=='A' && $deskripsi['kode']==1 )||
								( $item['pred_praktek']=='B' && $deskripsi['kode']==2 )||
								( $item['pred_praktek']=='C' && $deskripsi['kode']==3 )||
								( $item['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
							{
								if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
								{
									$cetak_des = 1;
	$html .=						"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
	$html .=			"<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
					}
					
    $html .=		'</tr>' . NL;
                    $jml_row++;
                }
    $html .='
					</table>
				</td>
			</tr>
		</table>';
	  if($type_return == 1){
		  $html = $nilai_catatan_walikelas;
	  }
	  return $html;
}