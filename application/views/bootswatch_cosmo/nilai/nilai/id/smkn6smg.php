<?php

// function

function div_right($txt)
{
	return div('align="right"', $txt);

}

function display_nilai($nilai)
{
	return div('style="text-align: right;"', ($nilai));
	//return div('style="text-align: right;"', formnil_angka($nilai));

}

function display_title($row)
{
	return a("nilai/pelajaran/id/{$row['id']}", $row['pelajaran_nama'], 'title="lihat detail nilai pelajaran"');

}

function link_action($row)
{
	$url_nilsispel = "nilai/siswa_pelajaran/form?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning"');

}

// komponen

$this->load->helper('dataset');
$this->load->helper('form');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => 'nilai',
	'Pelajaran'						 => 'nilai/pelajaran',
);

if ($request['kelas_id'] > 0 OR strlen($request['term']) > 0):
	$breadcrumbs["#{$row['id']}"] = "{$uri}/{$row['id']}";
	$breadcrumbs[] = 'pencarian';
else:
	$breadcrumbs[] = "#{$row['id']}";

endif;

foreach($kelas['data'] as $kls){
	$kelas_grade = $kls['grade'];
}

// pills link
$pills_kiri[] = array(
	'label'	 => 'Nilai Pelajaran',
	'uri'	 => 'nilai/pelajaran',
	'attr'	 => 'title="kembali ke daftar nilai pelajaran"',
);
/*
$pills_fbar['template'] = array(
	'label'	 => '<i class="icon-upload"></i>Template',
	'uri'	 => "nilai/pelajaran/template/{$row['id']}",
	'attr'	 => 'title="upload template rumus excel nila pelajaran"',
	'class'	 => 'disabled',
);
*/
/*
if($kelas_grade==12){

	$pills_fbar['expor'] = array(
		'label' => '<i class="icon-download"></i>Form',
		'uri' => "nilai/pelajaran/expor/{$row['id']}/ktsp" . array2qs(),
		'attr' => 'title="download excel form nilai pelajaran" target="_blank"',
		'class' => 'active',
	);
	$pills_fbar['impor'] = array(
		'label' => '<i class="icon-upload"></i>Impor',
		'uri' => "nilai/pelajaran/impor/{$row['id']}/ktsp",
		'attr' => 'title="impor daftar nilai pelajaran"',
		'class' => 'disabled',
	);

}else{
	
	$pills_fbar['expor'] = array(
		'label' => '<i class="icon-download"></i>Form',
		'uri' => "nilai/pelajaran/expor/{$row['id']}/k13" . array2qs(),
		'attr' => 'title="download excel form nilai pelajaran" target="_blank"',
		'class' => 'active',
	);
	$pills_fbar['impor'] = array(
		'label' => '<i class="icon-upload"></i>Impor',
		'uri' => "nilai/pelajaran/impor/{$row['id']}/k13",
		'attr' => 'title="impor daftar nilai pelajaran"',
		'class' => 'disabled',
	);
}*/

$pills_fbar['expor'] = array(
	'label' => '<i class="icon-download"></i>Form',
	'uri' => "nilai/pelajaran/expor/{$row['id']}/k13" . array2qs(),
	'attr' => 'title="download excel form nilai pelajaran" target="_blank"',
	'class' => 'active',
);
$pills_fbar['impor'] = array(
	'label' => '<i class="icon-upload"></i>Impor',
	'uri' => "nilai/pelajaran/impor/{$row['id']}/k13",
	'attr' => 'title="impor daftar nilai pelajaran"',
	'class' => 'disabled',
);

$arsip = APP_ROOT."content/".strtolower(APP_SCOPE)."/nilai-pelajaran/{$row['id']}/nilai.xlsx";
$uri_arsip = "content/".strtolower(APP_SCOPE)."/nilai-pelajaran/{$row['id']}/nilai.xlsx";

$pills_fbar['arsip'] = array(
	'label'	 => '<i class="icon-upload"></i>Arsip',
	'uri'	 => $uri_arsip,
	'attr'	 => 'title="download arsip excel nilai pelajaran terakhir"',
	'class'	 => (file_ada($arsip)) ? 'active' : 'disabled',
);

if ($admin OR ( $pengajar && $semaktif['id'] == $row['semester_id']))
{
	//$pills_fbar['template']['class'] = 'active';
	$pills_fbar['impor']['class'] = 'active';
}

// input filter/pencarian

$cfg_opsi_kelas = array(
	'value'		 => 'id',
	'label'		 => 'nama',
	'prefill'	 => 'kelas',
	'query'		 => array(
		'select'	 => array('kelas.id', 'kelas.nama'),
		'from'		 => 'dakd_kelas kelas',
		'join'		 => array(
			array('nilai_pelajaran_kelas nipelkls', 'kelas.id = nipelkls.kelas_id', 'inner'),
		),
		'where'		 => array(
			'nipelkls.pelajaran_nilai_id' => $row['id'],
		),
		'order_by'	 => 'kelas.grade, kelas.nama',
	),
);
$input = array(
	'term' => array(
		'term',
		'placeholder'	 => 'pencarian',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-medium',
	),
);

if ($user['role'] != 'siswa')
	$input['kelas_id'] = array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-large select"',
		'options'	 => $this->m_option->_get($cfg_opsi_kelas),
	);


$fbar = '<div>'
	. form_opening("{$uri}/{$row['id']}", 'method="get" class="form-search well"')
	. pills($pills_fbar, 'class="nav nav-pills pull-right"')
	. form_cell($input['term'], $request) . '&nbsp;';

if ($user['role'] != 'siswa')
	$fbar .= form_cell($input['kelas_id'], $request) . '&nbsp;';

$fbar .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a("{$uri}/{$row['id']}", 'Reset', 'class="btn"')
	. form_close()
	. '</div>';


// pagination nilai siswa

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 5,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => "{$uri}/{$row['id']}",
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

// tabel nilai siswa

$table_nilsis_akhir = array(
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-akhir',
		'class'	 => 'div-nilsis',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-akhir',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Kelas'									 => 'kelas_nama',
		'N I S'									 => 'siswa_nis',
		'Nama Siswa'							 => 'siswa_nama',
		'L/P'									 => array('siswa_gender', 'strtoupper'),
		' &nbsp;'								 => '&nbsp;',
		div_right('<b>MID Teori &nbsp;</b>')	 => array('mid_teori', 'display_nilai'),
		div_right('<b>MID Praktek &nbsp;</b>')	 => array('mid_praktek', 'display_nilai'),
		//div_right('<b>MID Sikap &nbsp;</b>')				=> array('mid_sikap', 'display_nilai'),
		div_right('<b>UTS</b>')					 => array('uts', 'display_nilai'),
		'&nbsp;'								 => '&nbsp;',
		div_right('<b>Akhir Teori &nbsp;</b>')	 => array('nas_teori', 'display_nilai', 'suffix' => ' &nbsp;'),
		div_right('<b>Akhir Praktek &nbsp;</b>') => array('nas_praktek', 'display_nilai', 'suffix' => ' &nbsp;'),
		'<div align="center"><b>Akhir Sikap</b></div>' => array(
		  'pred_sikap',
		  //'formnil_predikat',
		  'prefix' => '<div align="center">',
		  'suffix' => '</div>',
		  ),
		//div_right('<b>Nilai Sikap</b>') => array('nas_sikap', 'display_nilai'),
		//'&nbsp;'								 => '&nbsp;',
		div_right('<b>UAS</b>') => array('uas', 'display_nilai'),
	),
);

if ($admin OR $pengajar)
{
	$table_nilsis_akhir['data']['#'] = array(FALSE, 'link_action');
}

$table_nilsis_harian = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-harian',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-harian',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);
$table_nilsis_ulangan = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-ulangan',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-harian',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);
$table_nilsis_remidi = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-remidi',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-harian',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);
$table_nilsis_tugas = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-tugas',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-tugas',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);
$table_nilsis_praktek = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-praktek',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-praktek',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);
$table_nilsis_sikap = array(
	'pagination_link'	 => FALSE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsis-sikap',
		'class'	 => 'div-nilai-detail',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nilsis-sikap',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>nilai siswa kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'N I S'		 => 'siswa_nis',
		'Nama Siswa' => 'siswa_nama',
	),
);

for ($i = 1; $i <= 10; $i++):
	$kolom = div_right($i);
	$idx = (($i * 4) - 3);
	$table_nilsis_ulangan['data'][$kolom] = array('u' . $idx, 'display_nilai');
	$table_nilsis_remidi['data'][$kolom] = array('r' . $idx, 'display_nilai');
	$table_nilsis_harian['data'][$kolom] = array('h' . $idx, 'display_nilai');
	$table_nilsis_tugas['data'][$kolom] = array('t' . $idx, 'display_nilai');
	$table_nilsis_praktek['data'][$kolom] = array('p' . $idx, 'display_nilai');
	$table_nilsis_sikap['data'][$kolom] = array('s' . $idx, 'display_nilai');
endfor;

?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Nilai Semester Pelajaran')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

<?php

$this->load->view(THEME . "/-menu-/{$user['role']}");
echo breacrumbs($breadcrumbs);

?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1 title="nilai pelajaran semester ini">Nilai Pelajaran</h1>
				</div>

				<style>
					.cell_nilai{
						text-align: right;

					}
					.div-nilai-detail{
						display: none;
					}
					.btn-nilai{
						margin-top: 30px;
						margin-bottom: 10px;
					}
				</style>

<?php

echo alert_get();

// informasi umum

echo '<p>';
echo "Semester: " . ucfirst($row['semester_nama']) . " {$row['ta_nama']} <br/>"
 . "Pelajaran: {$row['pelajaran_nama']} <br/>"
 . "Pengajar: {$row['guru_nama']} <br/>";
echo '</p>';

// tabel nilai pelajaran

echo '<div><h3>Rata-rata Nilai Akhir</h3></div>';
echo '<table class="table table-bordered table-striped table-hover">' . NL;
echo '<thead>' . NL;
echo '<tr>' . NL;
echo '<td><b>Teori</b></td>'
 . '<td><b>Praktek</b></td>'
 . '<td>&nbsp;</td>' . NL;
echo '<td><b>UTS</b></td>'
 . '<td><b>UAS</b></td> ' . NL;
echo '</tr>' . NL;
echo '</thead>' . NL;

echo '<tbody>' . NL;
echo '<tr>' . NL;
echo '<td align="right">' . formnil_angka($row['nas_teori']) . '</td>'
 . '<td align="right">' . formnil_angka($row['nas_praktek']) . '</td>'
 . '<td>&nbsp;</td>' . NL;
echo '<td align="right">' . formnil_angka($row['uts']) . '</td>'
 . '<td align="right">' . formnil_angka($row['uas']) . '</td> ' . NL;
echo '</tr>' . NL;
echo '</tbody>' . NL;
echo '</table>' . NL;

// daftar nilai akhir siswa

echo '<div><h3>Daftar Nilai Siswa</h3></div>';
echo $fbar;
echo ds_table($table_nilsis_akhir, $resultset);
echo '<br/>';

// rata2 harian

echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nipel-rerata').slideToggle(400);\">Rata-rata Nilai Harian</div>";
//echo '<div><h3>Rata-rata Nilai Harian</h3></div>';
echo '<div id="div-nipel-rerata" class="div-nilai-detail">';
echo '<table class="table table-bordered table-striped table-hover">' . NL;
echo '<thead>' . NL;
echo '<tr>' . NL;
echo "<td rowspan='2'>&nbsp;</td>";

for ($i = 1; $i <= 10; $i++)
	echo "<th><div align='center'><b>KD {$i}</b></div></th>" . NL;

echo '</tr>' . NL;
echo '<tr>' . NL;
//echo "<td>&nbsp;</td>";
//for ($i = 1; $i <= 40; $i++)
//echo "<th><b>" . div_right($i) . "</b></th>" . NL;

echo '</tr>' . NL;
echo '</thead>' . NL;
echo '<tbody>' . NL;

/* / KKM harian semestera disabled
 *

  echo '<tr>' . NL;
  echo "<td><b>KKM Harian</b></td>";

  for ($i = 1; $i <= 10; $i++)
  echo "<td>" . display_nilai($row['kkm' . $i]) . "</td>" . NL;

  echo '</tr>' . NL;
 *
  / */

if ($row['teori']):
	echo '<tr>' . NL;
	echo "<td><b>Ulangan Harian</b></td>";

	for ($i = 1; $i <= 10; $i++):
		$idx = (($i * 4) - 3);
		echo "<td>" . display_nilai($row['h' . $idx]) . "</td>" . NL;
	endfor;

	echo '</tr>' . NL;
	echo '<tr>' . NL;
	echo "<td><b>Tugas</b></td>";

	for ($i = 1; $i <= 10; $i++):
		$idx = (($i * 4) - 3);
		echo "<td>" . display_nilai($row['t' . $idx]) . "</td>" . NL;

	endfor;

	echo '</tr>' . NL;

endif;


if ($row['praktek']):
	echo '<tr>' . NL;
	echo "<td><b>Praktek</b></td>";

	for ($i = 1; $i <= 10; $i++):
		$idx = (($i * 4) - 3);
		echo "<td>" . display_nilai($row['p' . $idx]) . "</td>" . NL;

	endfor;

	echo '</tr>' . NL;

endif;

echo '</tbody>' . NL;
echo '</table>' . NL;
echo '</div>';
echo '<br/>';

// daftar nilai harian siswa

echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-harian').slideToggle(400);\">Daftar Nilai Harian</div>";
echo ds_table($table_nilsis_harian, $resultset);
echo '<br/>';

if ($row['teori']):
	// daftar nilai ulangan siswa

	echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-ulangan').slideToggle(400);\">Daftar Nilai Ulangan</div>";
	echo ds_table($table_nilsis_ulangan, $resultset);
	echo '<br/>';

	// daftar nilai remidi siswa

	echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-remidi').slideToggle(400);\">Daftar Nilai Remidi</div>";
	echo ds_table($table_nilsis_remidi, $resultset);
	echo '<br/>';

	// daftar nilai tugas siswa

	echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-tugas').slideToggle(400);\">Daftar Nilai Tugas</div>";
	echo ds_table($table_nilsis_tugas, $resultset);
	echo '<br/>';

endif;

// daftar nilai praktek siswa

if ($row['praktek']):
	echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-praktek').slideToggle(400);\">Daftar Nilai Praktek</div>";
	echo ds_table($table_nilsis_praktek, $resultset);
	echo '<br/>';

endif;

// daftar nilai sikap siswa
//echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsis-sikap').slideToggle(400);\">Daftar Nilai Sikap</div>";
//echo ds_table($table_nilsis_sikap, $resultset);
//echo '<br/>';

?>

			</div>

<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

<?php echo cosmo_js(); ?>

	</body>
</html>