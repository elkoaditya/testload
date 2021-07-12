<?php

// function

function display_action($row) {
	return a("data/profil/admin/form?id={$row['id']}", 'edit', 'class="btn btn-small btn-success" title="ubah data admin ini"');
}

function display_nama($row) {
	$nama = array($row['nama'], $row['prefix'], $row['suffix']);
	$nama = array_filter($nama);
	$nama = implode(', ', $nama);

	return a("data/profil/admin/id/{$row['id']}?ringkas=ya", $nama, 'title="lihat detail data admin ini"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Admin',
);

// pills link

$pills_kanan['tambah'] = array(
		'label' => '<i class="icon-star"></i>Tambah',
		'uri' => "data/profil/admin/form",
		'attr' => 'title="tambah admin baru"',
		'class' => 'disabled',
);

if ($admin)
	$pills_kanan['tambah']['class'] = 'active';

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
		'base_url' => $uri,
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
				'id' => 'tabel-admin',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data admin kosong/tidak ditemukan</i></p>',
		'data' => array(
				'ID' => array('id', 'prefix' => '#'),
				'Nama' => array(FALSE, 'display_nama'),
				'L/P' => array('gender', 'strtoupper'),
		),
);

if ($admin):
	$table['data']['Aktif'] = array('aktif', array('tidak', 'ya'));
	$table['data']['Action'] = array(FALSE, 'display_action');
endif;

// bars

$pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Admin')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Admin</h1>
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