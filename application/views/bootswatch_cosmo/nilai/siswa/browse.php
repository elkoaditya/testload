<?php

// var

$admin_nilsis = cfguc_admin('akses', 'nilai', 'siswa');

// function

function div_right($txt)
{
	return div('align="right"', $txt);

}

function display_nilai($nilai)
{
	return div('style="text-align: right;"', formnil_angka($nilai));

}

function display_title($row)
{
	return a("nilai/siswa/id/{$row['id']}", $row['siswa_nama'], 'title="lihat detail nilai siswa"');

}

function display_title2($row)
{
	$html  ="<div><ul class='nav nav-pills pull-right' style='margin-bottom:-5px'>";
	$html .= "<li class='active'>".a("data/profil/siswa/cover/{$row['siswa_id']}.pdf?download=1", 'Profil', 
			'title="cetak rapor profil siswa" target="_blank"') . "</li>";
	$html .= "<li class='active'>".a("nilai/siswa/mutasi/{$row['id']}.pdf", 'Mutasi', 
			' title="cetak rapor mutasi siswa" target="_blank"') . "</li>";
	$html .= "<li class='active'>".a("nilai/siswa/rapor_mid/{$row['id']}/2013", 'RaporMid', 
			' title="cetak rapor Mid semester siswa" target="_blank"') . "</li>";
	//$html .= a("nilai/siswa/rapor/{$row['id']}.pdf/100", 'RaporAkhir', 'title="cetak rapor semester siswa" target="_blank"') . " &nbsp; ";
	$html .= "<li class='active'>".a("nilai/siswa/rapor/{$row['id']}/100?download=1", 'RaporAkhir', 
			' title="cetak rapor semester siswa" target="_blank"') . "</li>";
	$html .= "<li class='active'>".a("nilai/siswa/rapor/{$row['id']}/100/ttd?download=1", 'RaporAkhir+TTD', 
			' title="cetak rapor semester siswa" target="_blank"') . "</li>";
	//$html .= a("nilai/siswa/rapor/{$row['id']}/4?download=1", 'Akhir(1-4)', 'title="cetak rapor semester siswa" target="_blank"'). " &nbsp; ";
	$html .= "<li class='active'>".a("nilai/siswa/buku_induk/{$row['id']}/{$row['siswa_id']}/{$row['ta_id']}/100", "B.Induk", 
			' title="print nilai buku induk siswa" target="_blank"') . "</li>";
	if($row['kelas_grade'] == 12){
		$html .= "<li class='active'>".a("nilai/siswa/kelulusan/{$row['id']}/2013", 'Kelulusan', 
				' title="cetak kelulusan siswa" target="_blank"'). "</li>";
		
		$html .= "<li class='active'>".a("nilai/siswa/skhun/{$row['id']}/2013", 'SKHUN', 
				' title="cetak skhun siswa" target="_blank"'). "</li>";
		
		//// ADDITIONAL
		if(APP_SCOPE=='sman9smg'){
			$html .= "<li class='active'>".a("nilai/siswa/skhun/{$row['id']}/2013/2", 'SKHUN tanpa TTD', 
					' title="cetak skhun siswa" target="_blank"'). "</li>";
		}
	
	}
	
	//// ADDITIONAL
	if(APP_SCOPE=='smk_penerbangan')
	{
		$html .= "<li class='active'>".a("nilai/siswa/rapor/{$row['id']}/100/kkm?download=1", 'Rapor KKM', ' title="cetak rapor semester siswa KKM" target="_blank"') . "</li>";
	}
	if(APP_SCOPE=='sman8smg')
	{
		$html .= "<li class='active'>".a("nilai/siswa/rapor_tik/{$row['id']}/100?download=1", 'Rapor TIK', ' title="cetak rapor semester siswa TIK" target="_blank"') . "</li>";
		$html .= "<li class='active'>".a("nilai/siswa/rapor_tik/{$row['id']}/100/ttd?download=1", 'Rapor TIK+TTD', ' title="cetak rapor semester siswa TIK" target="_blank"') . "</li>";
	}
	$html  .="</ul></div>";
	return $html;

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => 'nilai',
	'Siswa',
);

// pills link

$pills_kanan = array();

if ($admin_nilsis):

	$pills_kanan[] = array(
		'label'	 => '<i class="icon-download"></i>Excel',
		'uri'	 => 'nilai/siswa/impor_absen_kepribadian/format?term='.$request['term'].'&kelas_id='.$request['kelas_id'].'&semester_id='.$request['semester_id'],
		'attr'	 => 'title="download absensi kehadiran , ahlak 10 mulia, sikap spiritual sosial, keteranangan kenaikan kelas"',
		'class'	 => 'active',
	);
	/*
	$pills_kanan[] = array(
		'label'	 => '<i class="icon-upload"></i>Impor Absensi, Ahlak Mulia KTSP,<br/>Sikap (Spiritual Sosial) K13 &amp; Ket Kenaikan',
		'uri'	 => "nilai/siswa/impor_absen_kepribadian",
		'attr'	 => 'title="download absensi kehadiran , 10 ahlak mulia, sikap spiritual sosial, keteranangan kenaikan kelas"',
		'class'	 => 'active',
	);*/
	
	if((APP_SCOPE=='smk_penerbangan')||(APP_SCOPE=='smk_nusaputera')||(APP_SCOPE=='smkpltarcisius')||(APP_SCOPE=='smkn6smg'))
	{
		$pills_kanan[] = array(
			'label'	 => '<i class="icon-upload"></i>Impor Kegiatan Belajar <br/>di Dunia Usaha/Industri ',
			'uri'	 => "nilai/siswa/impor_kerja_lapangan",
			'attr'	 => 'title="download kegiatan belajar di dunia usaha/industri"',
			'class'	 => 'active',
		);
	}
	
endif;

if ($admin_nilsis OR $walikelas):
	$pills_kanan[] = array(
		'label'	 => '<i class="icon-upload"></i>Impor Ket. Walikelas',
		'uri'	 => "nilai/siswa/impor_keterangan_walikelas",
		'attr'	 => 'title="impor keterangan walikelas antarmapel"',
		'class'	 => 'active',
	);
	$pills_kanan[] = array(
		'label'	 => '<i class="icon-upload"></i>Impor Absen dan Kenaikan <br> ',
		'uri'	 => "nilai/siswa/impor_absen_kenaikan",
		'attr'	 => 'title="impor Impor Absen dan Kenaikan Kelas"',
		'class'	 => 'active',
	);
	$pills_kanan[] = array(
		'label'	 => '<i class="icon-upload"></i>Impor Kepribadian<br> ',
		'uri'	 => "nilai/siswa/impor_kepribadian",
		'attr'	 => 'title="impor keterangan Kepribadian"',
		'class'	 => 'active',
	);
	
	$pills_kanan[] = array(
		'label'	 => '<i class="icon-upload"></i>Catatan Download Rapor<br> ',
		'uri'	 => "nilai/siswa_absensi/catatan_download_rapor",
		'attr'	 => 'title="catatan download rapor"',
		'class'	 => 'active',
	);
endif;



// input filter/pencarian
$input = array(
	'term'			 => array(
		'term',
		'placeholder'	 => 'pencarian',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-small',
	),
	'semester_id'	 => array(
		'semester_id',
		'type'		 => 'dropdown',
		'name'		 => 'semester_id',
		'id'		 => 'semester_id',
		'extra'		 => 'name = "semester_id" class = "input-medium select"',
		'options'	 => $this->m_option->semester(TRUE),
	),
	'kelas_id'		 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 4,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => $this->d['uri'],
	'full_tag_open'		 => '<div class="pagination"><ul>',
	'full_tag_close'	 => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
	'cur_tag_open'		 => '<li class="active"><a href="#">',
	'cur_tag_close'		 => '</a></li>',
	'num_tag_open'		 => '<li>',
	'num_tag_close'		 => '</li>',
	'first_tag_open'	 => '<li>',
	'first_tag_close'	 => '</li>',
	'last_tag_open'		 => '<li>',
	'last_tag_close'	 => '</li>',
	'next_tag_open'		 => '<li>',
	'next_tag_close'	 => '</li>',
	'prev_tag_open'		 => '<li>',
	'prev_tag_close'	 => '</li>',
);

$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Semester'			 => array(
			'semester_nama',
			'ucfirst',
			'suffix' => array(
				' ',
				'ta_nama',
			),
		),
		'Kelas'				 => 'kelas_nama',
		'NIS'				 => 'siswa_nis',
		'Siswa'				 => array(FALSE, 'display_title'),
		'L/P'				 => array('siswa_gender', 'strtoupper'),
		div_right('Akhir Teori')	 => array('nas_teori', 'display_nilai'),
		div_right('Akhir Praktek') => array('nas_praktek', 'display_nilai'),
		div_right('S')		 => array('absen_s', 'div_right'),
		div_right('I')		 => array('absen_i', 'div_right'),
		div_right('A')		 => array('absen_a', 'div_right'),
		'Cetak PDF'				 => array(FALSE, 'display_title2'),
	),
);
$bar = '<div class="row">'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. '</div>';
	
$bar .= '<div>'
	. form_opening($uri, 'method="get" class="form-search well"');
	

if ($user['role'] != 'siswa')
	$bar .= form_cell($input['term'], $request) . '&nbsp;';

$bar .= form_cell($input['kelas_id'], $request) . '&nbsp;'
	. form_cell($input['semester_id'], $request) . '&nbsp;'
	. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"'). '&nbsp;'
	
	. form_close()
	. '</div>';

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Nilai Semester Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Nilai Semester Siswa</h1>
				</div>

				<?php

				echo alert_get();
				echo $bar;
				echo ds_table($table, $resultset);

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>