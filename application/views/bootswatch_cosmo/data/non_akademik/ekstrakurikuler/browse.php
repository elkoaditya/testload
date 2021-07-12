<?php

// function

function display_action($row) {
	return a("data/non_akademik/ekstrakurikuler/form?id={$row['id']}", 'edit', 'title="ubah data ekstrakurikuler ini"');
}

function display_nama($row) {
	return a("data/non_akademik/ekstrakurikuler/id/{$row['id']}", $row['nama'], 'title="lihat detail data ekstrakurikuler ini"');
}

function display_pembina($row) {
	if ($row['pembina_id'])
		return a("data/profil/sdm/id/{$row['pembina_id']}", $row['pembina_nama'], 'title="lihat detail profil ' . strtolower(GURU_ALIAS) . '/sdm ini"');
	else
		return $row['pembina_nama'];
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$admin = cfguc_admin('akses', 'data', 'non_akademik', 'ekskul');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Non-Akademik' => 'data/non_akademik',
		'Ekstrakurikuler',
);

// pills link

$pills = array();

if ($admin):
	$pills[] = array(
			'label' => '<i class="icon-star"></i>Tambah Ekstrakurikuler',
			'uri' => "data/non_akademik/ekstrakurikuler/form",
			'attr' => 'title="tambah ekstrakurikuler baru"',
	);
endif;

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

// data

$listing = array(
		'id' => 'listing_ekstrakurikuler',
		'pagination_link' => TRUE,
		'show_stat' => FALSE,
		'row_link' => FALSE,
		'label' => array('nama'),
		'desc' => array('cuplikan'),
		'div_properties' => array(
				'style' => 'margin: 20px 8px 10px 0;'
		),
		'item_div_properties' => array(
				'style' => 'margin-bottom: 10px;'
		),
);

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
		'empty_message' => '<p><i>data kosong</i></p>',
		'data' => array(
				'Nama' => 'nama', //array(FALSE, 'display_nama'),
				'Pembina' => array(FALSE, 'display_pembina'),
		),
);

if ($admin):
	$table['data']['Aktif'] = array('aktif', array('tidak', 'ya'));
	$table['data']['Action'] = array(FALSE, 'display_action');
endif;
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Ekstrakurikuler')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Ekstrakurikuler</h1>
				</div>

				<?php
				echo alert_get();
				echo pills($pills);
				echo ds_table($table, $resultset);
				echo pills($pills);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>