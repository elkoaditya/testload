<?php

// function
if ($user['role'] == 'siswa'):
	function display_nama($row) {
		return a("kbm/angket/id/{$row['id']}/{$row['menilai_user_id']}", $row['nama'], 'title="lihat detail angket ' . (($row['published']) ? '"' : '(belum dipublikasikan)"')) . (($row['published']) ? '' : '*');
}
else:
	function display_nama($row) {
		return a("kbm/angket/id/{$row['id']}", $row['nama'], 'title="lihat detail angket ' . (($row['published']) ? '"' : '(belum dipublikasikan)"')) . (($row['published']) ? '' : '*');
}
endif;
function display_menilai_siswa_nama($row) {
	return a("kbm/angket/id/{$row['id']}/{$row['menilai_user_id']}", $row['menilai_siswa_nama'], 'title="lihat detail angket ' . (($row['published']) ? '"' : '(belum dipublikasikan)"')) . (($row['published']) ? '' : '*');
}

function display_nilai($row) {

	if ($row['angket_terkoreksi']):
		$a = a("kbm/angket_ljs/id/{$row['ljs_id']}/{$row['menilai_user_id']}", ('<b>' . formnil_angka($row['angket_nilai']) . '</b>'), 'title="lihat lembar jawaban"');
		return '<div align="right">' . $a . '</div>';
	endif;

	if ($row['ljs_id'])
		return '<div align="right"><i>menunggu koreksi</i></div>';

	return '<div align="right">' . a("kbm/angket_ljs/form/{$row['menilai_user_id']}?id={$row['id']}", 'kerjakan', 'title="kerjakan angket ini"') . '</div>';
}

/*function display_bentuk($pilihan_jml) {
	return ($pilihan_jml > 1) ? 'pilihan' : 'uraian';
}*/

function display_jumlah_siswa($jml_menilai_siswa) {
	return ($jml_menilai_siswa > 0) ? $jml_menilai_siswa.' siswa' : 'Siswa sekelas';
}

function display_jenis_penilaian($jenis_penilaian) {
	if($jenis_penilaian == 'penilaian_diri')
		return  'Penilaian Diri';
	elseif($jenis_penilaian == 'penilaian_sejawat')
		return  'Penilaian Sejawat';
}
// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket',
);

// pills link

$pills = array();

if ($mengajar_list):
	$pills[] = array(
			'label' => '<i class="icon-star"></i>Susun Angket Baru',
			'uri' => "kbm/angket/form?pelajaran_id={$request['pelajaran_id']}",
			'attr' => 'title="tambah angket baru"',
			'class' => 'active'
	);
endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
		),
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'options' => $this->m_option->semester('semester'),
				'extra' => 'class="input-large select"',
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'options' => array('' => 'pelajaran'),
				'extra' => 'class="input-large select"',
		),
		'author_id' => array(
				'author_id',
				'type' => 'dropdown',
				'name' => 'author_id',
				'id' => 'author_id',
				'options' => array('' => 'author'),
				'extra' => 'class="input-large select"',
		),
		'mapel_id' => array(
				'mapel_id',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'options' => $this->m_option->mapel('mapel'),
				'extra' => 'class="input-medium select"',
		),
);

if ($user['role'] == 'admin'):
	$input['author_id']['options'] = $this->m_option->sdm('author');
	$input['pelajaran_id']['options'] = $this->m_option->pelajaran('pelajaran');

else:
	$input['pelajaran_id']['options'] = $this->m_option->pelajaran_user('pelajaran', 'angket');

endif;

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 4,
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
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				//'Tipe' => array('tipe', 'ucfirst'),
				'Urutan Angket' => array('urutan', 'formnil_angka'),
				'Nama Angket' => array(FALSE, 'display_nama'),
				//'Bentuk' => array('pilihan_jml', 'display_bentuk'),
				'Jenis Penilaian' => array('jenis_penilaian', 'display_jenis_penilaian'),
				
				/*'<div align="right">KKM</div>' => array(
						'kkm',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),*/
		),
		'grouping' => array(
				'column' => array('semester_id', 'pelajaran_nama'),
		),
);

if ($user['role'] == 'siswa'):
	$table['data']['<div align="left">Menilai Siswa</div>'] = array(FALSE, 'display_menilai_siswa_nama');
	$table['data']['<div align="right">Nilai</div>'] = array(FALSE, 'display_nilai');
	$table['data']['Dikerjakan'] = array('ljs_last', 'date2tgl');
	$table['grouping']['title'] = array(
			'<span class="title">',
			array('mapel_nama', 'strtoupper'),
			'</span> &nbsp; ',
			'<span class="desc">',
			'[', 'pelajaran_nama', ']&nbsp; ', array('semester_nama', 'ucwords'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
			'</span>',
	);

else:
	$table['data']['<div align="left">Jumlah Menilai Siswa</div>'] = array('jml_menilai_siswa', 'display_jumlah_siswa');
	$table['data']['<div align="right">Pengerjaan</div>'] = array(
			'siswa_menjawab',
			'prefix' => '<div align="right">',
			'suffix' => array(
					' / ',
					'siswa_total',
					'</div>',
			),
	);
	$table['data']['<div align="right">Rata-Rata Nilai</div>'] = array(
			'rata2_nilai',
			'formnil_angka',
			'prefix' => '<div align="right">',
			'suffix' => '</div>',
	);
	$table['grouping']['title'] = array(
			'<span class="title">',
			array('pelajaran_nama', 'strtoupper'),
			'</span> &nbsp; ',
			'<span class="desc">',
			'[', 'mapel_nama', ']&nbsp; ', array('semester_nama', 'ucwords'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
			'</span>',
	);


endif;

$bar = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['pelajaran_id'], $request) . '&nbsp;'
			. form_cell($input['semester_id'], $request) . '&nbsp;';

if ($admin):
	$bar .= form_cell($input['author_id'], $request) . '&nbsp;';
endif;

$bar .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Angket Belajar')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

		<style>
			.record-group {
				margin: 16px 0 7px 0;
			}
			.record-group .title {
				font-size: 1.4em;
				color: black;
				vertical-align: baseline;
			}
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Angket Belajar</h1>
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