<?php

// function

function display_nama($row) {
	return a("kbm/materi/id/{$row['id']}", $row['nama'], 'title="lihat materi"');
}

function display_baca($row) {
	if ($row['respon_waktu'])
		return tgl($row['respon_waktu'], 'Y-m-d') . '&nbsp; <i class="icon-check" title="telah dibaca dan direspon"></i>';

	if ($row['baca_waktu'])
		return datefix($row['baca_waktu'], 'Y-m-d') . '&nbsp; <i class="icon-exclamation-sign" title="telah dibaca, belum direspon"></i>';

	return '<i>belum dibaca</i>';
}

function display_pembaca($row) {
	$title = "Siswa: {$row['siswa_total']} total, {$row['siswa_baca']} membaca, {$row['siswa_respon']} merespon.";
	return a("kbm/materi/pembaca/{$row['id']}", "{$row['siswa_respon']}/{$row['siswa_total']}", "title=\"{$title}\"");
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Materi',
);

// pills link

$pills_kanan['tambah'] = array(
		'label' => '<i class="icon-star"></i> Susun Materi Baru',
		'uri' => "kbm/materi/form?pelajaran_id={$request['pelajaran_id']}",
		'attr' => 'title="tambah materi baru"',
		'class' => 'disabled',
);

if ($mengajar_list)
	$pills_kanan['tambah']['class'] = 'active';

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
				'title' => 'ketikan kata kunci pencarian',
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'options' => $this->m_option->pelajaran_user('pelajaran'),
				'extra' => 'class="input-medium select"',
		),
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'options' => $this->m_option->semester('semester'),
				'extra' => 'class="input-medium select"',
		),
		'author_id' => array(
				'author_id',
				'type' => 'dropdown',
				'name' => 'author_id',
				'id' => 'author_id',
				'extra' => 'class="input-medium select"',
		),
		'mapel_id' => array(
				'mapel_id',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'extra' => 'class="input-medium select"',
		),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 4,
		'num_links' => 5,
		'next_link' => '???',
		'prev_link' => '???',
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
				'id' => 'tabel-materi',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Nama Materi' => array(FALSE, 'display_nama'),
		),
		'grouping' => array(
				'column' => array('semester_id', 'pelajaran_id'),
		),
);

if ($user['role'] == 'siswa'):
	$table['grouping']['title'] = array(
			'<span class="title">',
			array('mapel_nama', 'strtoupper'),
			'</span> &nbsp; ',
			'<span class="desc">',
			'[', 'pelajaran_nama', ']&nbsp; ', array('semester_nama', 'ucfirst'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
			'</span>',
	);
	$table['data']['Dibaca'] = array(FALSE, 'display_baca');

else:
	$table['grouping']['title'] = array(
			'<span class="title">',
			array('pelajaran_nama', 'strtoupper'),
			'</span> &nbsp; ',
			'<span class="desc">',
			'[', 'mapel_nama', ']&nbsp; ', array('semester_nama', 'ucfirst'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
			'</span>',
	);
	$table['data']['Dibaca'] = array(FALSE, 'display_pembaca');

endif;

// bars

$bar_pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['pelajaran_id'], $request) . '&nbsp;';

if ($view):
	$input['author_id']['options'] = $this->m_option->sdm('author');
	$input['mapel_id']['options'] = $this->m_option->mapel('mapel');

	$bar_pencarian .= form_cell($input['author_id'], $request) . '&nbsp;';
	$bar_pencarian .= form_cell($input['mapel_id'], $request) . '&nbsp;';

endif;

$bar_pencarian .= form_cell($input['semester_id'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Materi Belajar')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

		<style>
			.record-group .title {
				font-size: 1.4em;
				color: black;
				vertical-align: baseline;
				line-height: 2em;
			}
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Materi Belajar</h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_pencarian;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>