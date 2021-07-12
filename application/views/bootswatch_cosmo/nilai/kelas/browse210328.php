<?php

// function

function display_title($row) {
	return a("nilai/kelas/id/{$row['id']}", $row['kelas_nama'], 'title="lihat detail nilai kelas"');
}

function display_wali($row) {
	return a("data/profil/sdm/id/{$row['kelas_wali_id']}", $row['kelas_wali_nama'], 'title="lihat profil wali kelas aktif"');
}

function display_rapor($row)
{
	$html  ="<div><ul class='nav nav-pills pull-right' style='margin-bottom:-5px'>";
	$html .= "<li class='active'>".a("nilai/siswa/rapor_mid_kelas/{$row['id']}/100?download=1", 'RaporMid', 
			'title="cetak rapor mid semester siswa" target="_blank"') . "</li>";
	
	$html .= "<li class='active'>".a("nilai/siswa/rapor_kelas/{$row['id']}/100?download=1", 'RaporAkhir', 
			'title="cetak rapor semester siswa" target="_blank"') . "</li>";
	
	if(APP_SCOPE=='sman8smg'){
		$html .= "<li class='active'>".a("nilai/siswa/rapor_tik_kelas/{$row['id']}/100?download=1", 'RaporTIK', 
				'title="cetak rapor tik semester siswa" target="_blank"') . "</li>";
	}
			
	//$html .= a("nilai/siswa/rapor_kelas/{$row['id']}/4?download=1", 'Rapor(1-4)', 'title="cetak rapor semester siswa" target="_blank"');
	$html .= "<li class='active'>".a("nilai/siswa/rapor_thn_kelas/{$row['id']}/{$row['ta_id']}/100", "BukuInduk", 
			'title="cetak buku induk siswa" target="_blank"') . "</li>";
	
	if($row['kelas_grade']==12)
	{
		
		$html .= "<li class='active'>".a("nilai/siswa/skhun_kelas/{$row['id']}/100?download=1", 'SKHUN', 
				'title="cetak SKHUN siswa" target="_blank"') . "</li>";
		$html .= "<li class='active'>".a("nilai/siswa/kelulusan_generator/{$row['id']}/2013", "Generate_Kelulusan", 
				'title="cetak surat kelulusan di server" target="_blank"') . "</li>";
		//// ADDITIONAL
		if(APP_SCOPE=='sman9smg'){
			$html .= "<li class='active'>".a("nilai/siswa/skhun_kelas/{$row['id']}/100/2?download=1", 'SKHUN tanpa TTD', 
				'title="cetak SKHUN siswa" target="_blank"') . "</li>";
		}
	}	
	$html .= "<li class='active'>".a("nilai/kelas/detail/{$row['id']}", 'View Nilai', 
			'title="cetak mutasi siswa"') . "</li>";
	$html .= "<li class='active'>".a("nilai/siswa/mutasi_kelas/{$row['id']}/100?download=1", 'Mutasi', 
				'title="cetak mutasi siswa" target="_blank"') . "</li>";
	
	$html .= "<li class='active'>".a("nilai/siswa/rapor_generator/{$row['id']}/100/ttd", "Generate_R.Akhir", 
				'title="cetak surat rapor akhir di server" target="_blank"') . "</li>";
	$html .= "<li class='active'>".a("nilai/siswa/rapor_tik_generator/{$row['id']}/100/ttd", "Generate_R.TIK", 
				'title="cetak surat rapor TIK di server" target="_blank"') . "</li>";
	
	$html .= "</ul></div>"; 
	return $html;

}
// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Kelas',
);

// pills link
// input filter/pencarian

$input = array(
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->semester('semester'),
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-medium select"',
				'options' => array('' => 'kelas'),
		),
);

foreach ($kelas_terkait as $kid => $knama)
	$input['kelas_id']['options'][$kid] = $knama;

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 5,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => $this->d['uri'],
		'full_tag_open' => '<div class="pagination"><ul>',
		'full_tag_close' => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
		'cur_tag_open' => '<li class="active"><a href="#">',
		'cur_tag_close' => '</a></li>',
		'num_tag_open' => '<li>',
		'num_tag_close' => '</li>',
		'first_tag_open' => '<li>',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li>',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li>',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li>',
		'prev_tag_close' => '</li>',
);

$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
		'show_header' => TRUE,
		'pagination_link' => TRUE,
		'show_stat' => FALSE,
		'show_number' => TRUE,
		'row_action' => FALSE,
		'row_link' => FALSE,
		'jquery' => FALSE,
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Semester' => array(
						'semester_nama',
						'ucfirst',
						'suffix' => array(
								' ',
								'ta_nama',
						),
				),
				'Kelas' => array(FALSE, 'display_title'),
				'Walikelas' => array('kelas_wali_nama'),
				'<div align="right">Teori</div>' => array(
						'nas_teori',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'<div align="right">Praktek</div>' => array(
						'nas_praktek',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'Cetak PDF 1 Kelas'				 => array(FALSE, 'display_rapor'),
		),
);
 
// bars

$bar = '<div>'
			. form_opening($uri, 'method = "get" class = "form-search well"')
			. form_cell($input['semester_id'], $request) . '&nbsp;	'
			. form_cell($input['kelas_id'], $request) . '&nbsp;	'
			. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
			. a($uri, 'Reset', 'class="btn" title="reset pencarian"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Nilai Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Nilai Semester Kelas</h1>
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