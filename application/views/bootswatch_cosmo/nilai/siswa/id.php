<?php

// function

function div_right($txt)
{
	return div('align="right"', $txt);

}

function display_nilai($nilai)
{
	return div('style="text-align: right;"', formnil_angka($nilai));

}

function display_mapel($row)
{
	return a("nilai/pelajaran/id/{$row['pelajaran_nilai_id']}", $row['mapel_nama'], 'title="lihat detail nilai pelajaran"')
		. "<br/><span style=\"font-size: 80%;\">{$row['guru_nama']}</span>";

}

function tnil_config($nama)
{
	return array(
		'pagination_link'	 => FALSE,
		'div_properties'	 => array(
			'id'	 => "div-nilsispel-{$nama}",
			'class'	 => "div-nilsispel-detail",
		),
		'table_properties'	 => array(
			'id'	 => "tabel-nisispel-{$nama}",
			'class'	 => 'table table-bordered table-striped table-hover',
		),
		'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data'				 => array(
			'Mapel' => array('mapel_nama'),
		),
	);

}

function nharian($row, $i)
{
	$i_h = "h{$i}";
	$i_nph = "nipel_h{$i}";
	$i_npkkm = "nipel_kkm{$i}";
	$n_h = $row[$i_h];

	if (empty($n_h))
		return '';

	$attr = array('align' => 'right');
	$n_h = (float) $n_h;
	$n_nph = (float) $row[$i_nph];
	$n_npkkm = (float) (empty($row[$i_npkkm])) ? $row["nipel_kkm"] : $row[$i_npkkm];

	if ($n_h < $n_npkkm)
		$attr['style'] = "color: red;";

	else if ($n_h < $n_nph)
		$attr['style'] = "color: orange;";

	$n_h = formnil_angka($n_h);
	$n_nph = formnil_angka($n_nph);
	$n_npkkm = formnil_angka($n_npkkm);
	$attr['title'] = "KKM: {$n_npkkm}. Rata2: {$n_nph}.";

	return div($attr, $n_h);

}

function link_action_pelajaran($row)
{
	$url_nilsispel = "nilai/siswa_pelajaran/form?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning"');

}

function link_action_pelajaran_catatan($row)
{
	$url_nilsispel = "nilai/siswa_pelajaran/form_catatan?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning"');

}

function link_action_aspri($row)
{
	$url_nilsispel = "nilai/siswa_absensi/form_aspri_ktsp?id={$row['id']}";

	return a($url_nilsispel, 'edit Ahlak Mulia & Kepribadian', 'class="btn btn-warning "');

}

function link_action_absensi($row)
{
	$url_nilsispel = "nilai/siswa_absensi/form?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning"');

}

function link_hapus_ekskul($row)
{
	$url_del_nilsiskul = "nilai/siswa_ekskul/hapus_ekskul_dr_siswa/{$row['id']}/{$row['siswa_nilai_id']}";

	return a($url_del_nilsiskul, 'hapus', 'class="btn btn-danger btn-small" onClick="return confirm(\'Apakah Anda yakin hendak menghapusnya?\')"');

}

function link_action_catatan_wali($row)
{
	$url_nilsispel = "nilai/siswa_absensi/form_catatan_wali?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning "');

}

function link_action_mutasi($row)
{
	$url_nilsispel = "nilai/siswa_absensi/form_mutasi?id={$row['id']}";

	return a($url_nilsispel, 'edit', 'class="btn btn-warning "');

}
// komponen

$this->load->helper('dataset');
$this->load->helper('form');

// hak akses & user scope

$adminsdm = user_role('admin', 'sdm');
$rapor_editable = (($walikelasybs OR $gurubkybs OR $admin) && $row['semester_id'] == $semaktif['id']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => 'nilai',
	'Siswa'							 => 'nilai/siswa',
	"#{$row['id']}",
);

// pills link

$pills = array();

if ($view)
	$pills[] = array(
		'label'	 => '<i class="icon-table"></i> Kembali',
		'uri'	 => 'nilai/siswa',
		'attr'	 => 'title="kembali ke daftar nilai semester siswa"',
	);
/*
  if ($pelajar OR $walikelasybs OR $admin)
  $pills[] = array(
  'label' => '<i class="icon-download"></i> Expor',
  'uri' => "nilai/siswa/expor/{$row['id']}" . array2qs(),
  'attr' => 'title="expor bentuk excel daftar nilai siswa " target="_blank"',
  );
 *
 */

if ($walikelasybs OR $admin OR $pelajar):
	$pills[] = array(
		'label'	 => '<i class="icon-download"></i> Rapor Mid 2013',
		'uri'	 => "nilai/siswa/rapor_mid/{$row['id']}" . array2qs() . "/2013",
		'attr'	 => 'title="expor bentuk rapor PDF daftar nilai siswa " target="_blank"',
	);
	$pills[] = array(
		'label'	 => '<i class="icon-download"></i> Rapor (1-100)',
		'uri'	 => "nilai/siswa/rapor/{$row['id']}/100" . array2qs(),
		'attr'	 => 'title="expor bentuk rapor PDF daftar nilai siswa " target="_blank"',
	);
	$pills[] = array(
		'label'	 => '<i class="icon-download"></i> Rapor (1-4)',
		'uri'	 => "nilai/siswa/rapor/{$row['id']}/4" . array2qs(),
		'attr'	 => 'title="expor bentuk rapor PDF daftar nilai siswa " target="_blank"',
	);
	
endif;


// data siswa

$dset['Semester'] = array(
	'semester_nama', 'ucfirst',
	'suffix' => array(
		' ',
		'ta_nama',
	),
);
$dset['Nama siswa'] = 'siswa_nama';
$dset['Kelas'] = 'kelas_nama';
$dset['N I S'] = 'siswa_nis';
$dset['N I S N'] = 'siswa_nisn';

// input filter/pencarian

$bar = '<div>' . div('class="form-horizontal well" style="min-height: 30px;"', pills($pills, 'class="nav nav-pills pull-right"')) . '</di>';

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

$table_nisispel_akhir = array(
	'pagination_link'	 => TRUE,
	'div_properties'	 => array(
		'id'	 => 'div-nilsispel-akhir',
		'class'	 => 'div-nilsispel',
	),
	'table_properties'	 => array(
		'id'	 => 'tabel-nisispel-akhir',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Kategori'							 => 'kategori_kode',
		'Mapel'								 => array(FALSE, 'display_mapel'),
		//'Pelajaran'							 => 'pelajaran_kode',
		//'Pengajar'							 => 'guru_nama',
		'KKM'								 => array('nipel_kkm', 'display_nilai'),
		' &nbsp;'							 => '&nbsp;',
		//div_right('MID Teori')				 => array('mid_teori', 'display_nilai'),
		//div_right('MID Praktek')			 => array('mid_praktek', 'display_nilai'),
		//div_right('MID Sikap') => array('mid_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>'),
		//div_right('MID Predikat Sikap')		 => array('mid_pred_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>'),
		//div_right('UTS')					 => array('uts', 'display_nilai'),
		//'&nbsp;'							 => '&nbsp;',
		//div_right('Akhir Teori')			 => array('nas_teori', 'display_nilai'),
		//div_right('Akhir Praktek')			 => array('nas_praktek', 'display_nilai'),
		//div_right('Sikap') => array('nas_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>'),
		//div_right('Akhir Predikat Sikap')	 => array('pred_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>'),
		//div_right('UAS')					 => array('uas', 'display_nilai'),
	),
);

// NILAI 
if(APP_SUBDOMAIN != 'sman8-smg.fresto.co'){
	$table_nisispel_akhir['data'][div_right('MID Teori')] = array('mid_teori', 'display_nilai');
	$table_nisispel_akhir['data'][div_right('MID Praktek')] = array('mid_praktek', 'display_nilai');
	//$table_nisispel_akhir['data'][div_right('MID Predikat Sikap')] = array('mid_pred_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>');
}

$table_nisispel_akhir['data'][div_right('PTS')] = array('uts', 'display_nilai');

$table_nisispel_akhir['data']['&nbsp;'] = '&nbsp;';

$table_nisispel_akhir['data'][div_right('Akhir Teori')] = array('nas_teori', 'display_nilai');
$table_nisispel_akhir['data'][div_right('Akhir Praktek')] = array('nas_praktek', 'display_nilai');
//$table_nisispel_akhir['data'][div_right('Akhir Predikat Sikap')] = array('pred_sikap', 'formnil_predikat', 'prefix' => '<div align="center">', 'suffix' => '</div>');

$table_nisispel_akhir['data'][div_right('PAS')] = array('uas', 'display_nilai');

$table_nisispel_akhir['data'][' &nbsp; '] = '&nbsp;';
//$table_nisispel_akhir['data'][div_right('USBN Teori')] = array('usbn_teori', 'display_nilai');
//$table_nisispel_akhir['data'][div_right('USBN Praktek')] = array('usbn_praktek', 'display_nilai');
//$table_nisispel_akhir['data'][div_right('USBN Akhir')] = array('usbn_akhir', 'display_nilai');

//////////////////////////////

if ($admin)
{
	$table_nisispel_akhir['data']['#'] = array(FALSE, 'link_action_pelajaran');
}

$table_nisispel_harian = tnil_config('harian');
$table_nisispel_tugas = tnil_config('tugas');
$table_nisispel_praktek = tnil_config('praktek');
$table_nisispel_sikap = tnil_config('sikap');

for ($i = 1; $i <= 10; $i++):
	$table_nisispel_harian['data'][$i] = array(FALSE, 'nharian', $i);
	$table_nisispel_tugas['data'][$i] = array('t' . $i, 'display_nilai');
	$table_nisispel_praktek['data'][$i] = array('p' . $i, 'display_nilai');
	$table_nisispel_sikap['data'][$i] = array('s' . $i, 'display_nilai');
endfor;

// tabel kompetensi

$table_kompetensi = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-kd',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>nilai kompetensi kosong</i></p>',
	'data'				 => array(
		'Mapel'			 		=> array(FALSE, 'display_mapel'),
		'Kompetensi (KTSP)'	 		=> 'kompetensi',
		'Catatan Pengetahuan (K13)'	=> 'cat_teori',
		'Catatan Ketrampilan (K13)'	=> 'cat_praktek',
	),
);
if ($admin)
{
	$table_kompetensi['data']['#'] = array(FALSE, 'link_action_pelajaran_catatan');
}

// tabel ekskul

$table_ekskul = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-ekskul',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>tidak mengikuti ekstrakurikuler apapun</i></p>',
	'data'				 => array(
		'Nama Ekstrakurikuler'	 => 'ekskul_nama',
		'Nilai'					 => 'nilai',
		'Keterangan'			 => 'keterangan',
	),
);

if ($admin)
{
	$table_ekskul['data']['#'] = array(FALSE, 'link_hapus_ekskul');
}

// tabel org

$table_org = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-org',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>tidak mengikuti organisasi apapun</i></p>',
	'data'				 => array(
		'Nama Organisasi'	 => 'org_nama',
		'Predikat'			 => 'nilai',
		'Keterangan'		 => 'keterangan',
	),
);

// data absensi

$dset_absen['Sakit'] = array('absen_s', 'suffix' => ' hari');
$dset_absen['Ijin'] = array('absen_i', 'suffix' => ' hari');
$dset_absen['Tanpa keterangan'] = array('absen_a', 'suffix' => ' hari');

// ket rapor

$dset_rapor['Catatan Walikelas'] = 'note_walikelas';
$dset_rapor2['Lembar Mutasi'] = 'note_mutasi';

// links

//$link_form_rapor = a("nilai/siswa/form?id={$row['id']}", 'Edit Keterangan Rapor', 'class="btn" title="ubah keterangan rapor untuk absensi dan aspek pribadi"');

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
					<h1 title="nilai siswa semester ini">Nilai Siswa Detail</h1>
				</div>

				<style>
					.cell_nilai{
						text-align: right;
					}
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					.div-nilsispel-detail{
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
				//echo '<div><h3>Data Siswa</h3></div>';
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';
				echo '<br/><br/>';

				// tabel rata2 nilai siswa

				echo '<div><h3>Rata-rata Nilai</h3></div>';
				echo '<table class="table table-bordered table-striped table-hover">' . NL;
				echo '<thead>' . NL;
				echo '<tr>' . NL;
				echo '<td align="right"><b>Teori</b></td>'
				. '<td align="right"><b>Praktek</b></td>'
				. '<td>&nbsp;</td>' . NL;
				echo '<td align="right"><b>UTS</b></td>'
				. '<td align="center"><b>UAS</b></td> ' . NL;
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
				echo '<br/><br/>';

				// rata2 harian

				echo '<div><h3>Rata-rata Nilai Harian</h3></div>';
				echo '<table class="table table-bordered table-striped table-hover">' . NL;
				echo '<thead>' . NL;
				echo '<tr>' . NL;
				echo "<td>&nbsp;</td>";

				for ($i = 1; $i <= 10; $i++)
					echo "<td><b>" . div_right($i) . "</b></td>" . NL;

				echo '</tr>' . NL;
				echo '</thead>' . NL;
				echo '<tbody>' . NL;
				echo '<tr>' . NL;
				echo "<td><b>Ulangan Harian</b></td>";

				for ($i = 1; $i <= 10; $i++)
					echo "<td>" . display_nilai($row['h' . $i]) . "</td>" . NL;

				echo '</tr>' . NL;
				echo '<tr>' . NL;
				echo "<td><b>Tugas</b></td>";

				for ($i = 1; $i <= 10; $i++)
					echo "<td>" . display_nilai($row['t' . $i]) . "</td>" . NL;

				echo '</tr>' . NL;

				echo '<tr>' . NL;
				echo "<td><b>Praktek</b></td>";

				for ($i = 1; $i <= 10; $i++)
					echo "<td>" . display_nilai($row['p' . $i]) . "</td>" . NL;

				echo '</tr>' . NL;

				echo '</tbody>' . NL;
				echo '</table>' . NL;
				echo '<br/>';

// nilai pelajaran rata2

				echo '<div><h3>Nilai Akhir Pelajaran</h3></div>';
				echo $bar;
				echo ds_table($table_nisispel_akhir, $resultset);
				echo '<br/>';

				// kompetensi

				echo '<div><h3>Daftar Kompetensi Pelajaran</h3></div>';
				echo ds_table($table_kompetensi, $resultset);
				echo '<br/><br/>';

				// nilai pelajaran harian

				echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsispel-harian').slideToggle(400);\">Daftar Nilai Harian</div>";
				echo ds_table($table_nisispel_harian, $resultset);
				echo '<br/>';

				// nilai pelajaran tugas

				echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsispel-tugas').slideToggle(400);\">Daftar Nilai Tugas</div>";
				echo ds_table($table_nisispel_tugas, $resultset);
				echo '<br/>';

				// nilai pelajaran praktek

				echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsispel-praktek').slideToggle(400);\">Daftar Nilai Praktek</div>";
				echo ds_table($table_nisispel_praktek, $resultset);
				echo '<br/>';

				// nilai pelajaran sikap

				if ($adminsdm):
					echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsispel-sikap').slideToggle(400);\">Daftar Nilai Sikap</div>";
					echo ds_table($table_nisispel_sikap, $resultset);
					echo '<br/>';

				endif;

				// kepribadian

				$kepribadian = (array) json_decode($row['kepribadian'], TRUE);

				echo '<div><h3>Akhlak Mulia dan Kepribadian</h3></div>';
				if ($admin)
				{
					echo link_action_aspri($row);
					echo '<br><br>';
				}
				echo '<table class="table table-bordered table-striped table-hover">' . NL;
				echo '<thead>' . NL;
				echo '<tr>' . NL;
				echo '<td align="right"><b>No</b></td>' . NL;
				echo '<td align="right"><b>Aspek yang Dinilai</b></td>' . NL;
				echo '<td align="right"><b>Keterangan</b></td>' . NL;
				echo '</tr>' . NL;
				echo '</thead>' . NL;

				echo '<tbody>' . NL;

				$no = 1;

				foreach ($this->m_nilai_siswa->dm['kepribadian.ktsp'] as $idx => $label):
					echo '<tr>' . NL;
					echo '<td align="right">' . ($no++) . '</td>' . NL;
					echo '<td align="right">' . $label . '</td>' . NL;
					echo '<td align="right">' . array_node($kepribadian, $idx) . '</td>' . NL;
					echo '</tr>' . NL;

				endforeach;

				/* /

				  echo '<tr>' . NL;
				  echo '<td align="right">2</td>' . NL;
				  echo '<td align="right">Kebersihan</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'kebersihan') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">3</td>' . NL;
				  echo '<td align="right">Kesehatan</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'kesehatan') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">4</td>' . NL;
				  echo '<td align="right">Tanggungjawab</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'tgjawab') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">5</td>' . NL;
				  echo '<td align="right">Sopan santun</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'kesopanan') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">6</td>' . NL;
				  echo '<td align="right">Percaya diri</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'percayadiri') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">7</td>' . NL;
				  echo '<td align="right">Kompetitif</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'kompetitif') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">8</td>' . NL;
				  echo '<td align="right">Hubungan sosial</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'sosial') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">9</td>' . NL;
				  echo '<td align="right">Kejujuran</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'kejujuran') . '</td>' . NL;
				  echo '</tr>' . NL;

				  echo '<tr>' . NL;
				  echo '<td align="right">10</td>' . NL;
				  echo '<td align="right">Pelaksanaan ritual ibadah</td>' . NL;
				  echo '<td align="right">' . array_node($kepribadian, 'religius') . '</td>' . NL;
				  echo '</tr>' . NL;

				  // */

				echo '</tbody>' . NL;
				echo '</table>' . NL;
				echo '<br/><br/>';

				// ketidakhadiran

				echo '<div><h3>Ketidakhadiran</h3></div>';
				echo '<table class="table table-bordered table-striped table-hover">' . NL;
				echo '<thead>' . NL;
				echo '<tr>' . NL;
				echo '<td align="right"><b>Sakit</b></td>' . NL;
				echo '<td align="right"><b>Ijin</b></td>' . NL;
				echo '<td align="right"><b>Tanpa Keterangan</b></td>' . NL;
				if ($admin)
				{
					echo '<td align="right"><b>#</b></td>' . NL;
				}
				echo '</tr>' . NL;
				echo '</thead>' . NL;

				echo '<tbody>' . NL;
				echo '<tr>' . NL;
				echo '<td align="right">' . ($row['absen_s']) . ' hari</td>' . NL;
				echo '<td align="right">' . ($row['absen_i']) . ' hari</td>' . NL;
				echo '<td align="right">' . ($row['absen_a']) . ' hari</td>' . NL;
				if ($admin)
				{
					echo '<td align="right">'.link_action_absensi($row).'</td>' . NL;
				}
				echo '</tr>' . NL;
				echo '</tbody>' . NL;
				echo '</table>' . NL;
				echo '<br/><br/>';

				// ekstrakurikuler

				echo '<div><h3>Ekstrakurikuler</h3></div>';
				echo ds_table($table_ekskul, $ekskul_result);
				if ($admin)
				{
					echo a("nilai/siswa_ekskul/form_tambah_ekskul_ke_siswa?siswa_nilai_id={$row['id']}", ' <i class="icon-plus"></i> Tambah Ekstrakurikuler', 'class="btn btn-info btn-small "');
				}
				echo '<br/><br/>';

				// organisasi

				echo '<div><h3>Organisasi</h3></div>';
				echo ds_table($table_org, $org_result);
				echo '<br/><br/>';

				// catatan rapor

				echo '<div><h3>Keterangan Rapor</h3></div>';
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset_rapor as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;
				
				if ($admin)
				{
					echo link_action_catatan_wali($row);
				}
				echo '</fieldset></div>';
				echo '<br/><br/>';
				
				// lembar mutasi

				echo '<div><h3>Lembar Mutasi</h3></div>';
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset_rapor2 as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;
				
				if ($admin)
				{
					echo link_action_mutasi($row);
				}
				echo '</fieldset></div>';
				echo '<br/><br/>';

				//* /
				//if ($rapor_editable)
					//echo $link_form_rapor;

				// */
				//dump($resultset);

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>