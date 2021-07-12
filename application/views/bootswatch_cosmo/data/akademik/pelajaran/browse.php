<?php

// function

function display_action($row) {
	return a("data/akademik/pelajaran/form?id={$row['id']}", 'edit', 'title="ubah data pelajaran ini"');
}

function display_nama($row) {
	return a("data/akademik/pelajaran/id/{$row['id']}", $row['nama'], "title=\"{$row['mapel_nama']}\"");
}

function display_guru($row) {
	if ($row['guru_id'])
		return a("data/profil/sdm/id/{$row['guru_id']}", $row['guru_nama'], "title=\"lihat profil " . strtolower(GURU_ALIAS) . "\"");

	return '';
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Pelajaran',
);

// pills link

$pills = array();

if ($admin):
	$pills[] = array(
			'label' => '<i class="icon-star"></i> Tambah',
			'uri' => "data/akademik/pelajaran/form",
			'attr' => 'title="tambah pelajaran baru"',
			'class' => (($semaktif['id'] == 0) ? 'active' : 'disabled'),
	);
endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
				'placeholder' => 'pencarian',
				'title' => 'pencarian',
		),
		'kategori_id' => array(
				'kategori_id',
				'type' => 'dropdown',
				'name' => 'kategori_id',
				'id' => 'kategori_id',
				'extra' => 'id="kategori_id" class="input input-medium select"',
				'options' => $this->m_option->kategori_mapel('kategori'),
		),
		'mapel_id' => array(
				'mapel_id',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'extra' => 'id="mapel_id" class="input input-medium select"',
				'options' => $this->m_option->mapel('mapel'),
		),
		'agama_id' => array(
				'agama_id',
				'type' => 'dropdown',
				'name' => 'agama_id',
				'id' => 'agama_id',
				'extra' => 'id="agama_id" class="input input-small select"',
				'options' => $this->m_option->agama('agama'),
		),
		'guru_id' => array(
				'guru_id',
				'type' => 'dropdown',
				'name' => 'guru_id',
				'id' => 'guru_id',
				'extra' => 'id="guru_id" class="input input-large select"',
				'options' => $this->m_option->guru(strtolower(GURU_ALIAS)),
		),
		'aktif' => array(
				'aktif',
				'type' => 'dropdown',
				'name' => 'aktif',
				'id' => 'aktif',
				'extra' => 'id="aktif" class="input input-small select"',
				'options' => array(''=>'aktif','0'=>'tidak','1'=>'ya'),
		),
);

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
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kode' => 'kode',
				'Nama' => array(FALSE, 'display_nama'),
				'Pengajar' => array('guru_nama'),
				'Kategori' => 'kategori_kode',
				'Mapel' => 'mapel_nama',
		),
);

if ($view && $semaktif['id'] == 0)
	$table['data']['Aktif'] = array('aktif', array('Tidak', 'Ya'));

if ($admin && $semaktif['id'] == 0)
	$table['data']['Action'] = array(FALSE, 'display_action');

// bars

$pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kategori_id'], $request) . '&nbsp;'
			. form_cell($input['mapel_id'], $request) . '&nbsp;'
			. form_cell($input['agama_id'], $request) . '&nbsp;'
			. form_cell($input['guru_id'], $request) . '&nbsp;'
			. form_cell($input['aktif'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pelajaran')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Pelajaran</h1>
				</div>

				<?php
				echo alert_get();
				echo $pencarian;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>