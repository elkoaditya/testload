<?php

// function

function display_action($row) {
	return a("data/profil/sdm/form?id={$row['id']}", 'edit', 'class="btn btn-small btn-success" title="ubah data sdm ini"');
}

function display_nama($row) {
	$nama = array($row['nama'], $row['prefix'], $row['suffix']);
	$nama = array_filter($nama);
	$nama = implode(', ', $nama);

	return a("data/profil/sdm/id/{$row['id']}?ringkas=ya", $nama, 'title="lihat detail data sdm ini"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		GURU_ALIAS . ' &amp; SDM',
);

// pills link

$pills = array();

if ($admin):
	$pills['impor'] = array(
			'label' => '<i class="icon-upload"></i> Impor',
			'uri' => "data/profil/sdm/impor",
			'attr' => 'title="impor data ' . strtolower(GURU_ALIAS) . ' / sdm"',
			'class' => 'active',
	);
	$pills['tambah'] = array(
			'label' => '<i class="icon-star"></i> Tambah',
			'uri' => "data/profil/sdm/form",
			'attr' => 'title="tambah ' . strtolower(GURU_ALIAS) . ' / sdm baru"',
			'class' => 'active',
	);
endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-medium',
				'placeholder' => 'pencarian',
				'title' => 'ketikan kata kunci pencarian',
		),
		'aktif' => array(
				'aktif',
				'type' => 'dropdown',
				'name' => 'aktif',
				'id' => 'aktif',
				'options' => array(
						'' => 'login',
						'aktif login',
						'disable login',
				),
				'extra' => 'id="aktif" class = "input-medium select" title="siswa yang masih aktif dalam KBM"',
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
				'id' => 'tabel-sdm',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data sdm kosong/tidak ditemukan</i></p>',
		'data' => array(
				'N I P' => 'nip',
				'Nama' => array(FALSE, 'display_nama'),
				'L/P' => array('gender', 'strtoupper'),
				'Jabatan' => 'jabatan_nama',
		),
);

if ($user['role'] == 'admin')
	$table['data']['Login'] = array('aktif', array('blokir', 'aktif'));

if ($admin):
	$table['data']['Action'] = array(FALSE, 'display_action');
endif;

// bars

$pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;';

if ($user['role'] == 'admin')
	$pencarian .= form_cell($input['aktif'], $request) . '&nbsp;';

$pencarian .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => GURU_ALIAS . ' & SDM')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1><?php echo GURU_ALIAS; ?> dan SDM</h1>
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