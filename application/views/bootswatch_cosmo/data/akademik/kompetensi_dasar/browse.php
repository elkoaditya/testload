<?php

// function

function display_action($row) {
	return a("data/akademik/kompetensi_dasar/form?id={$row['id']}", 'edit', 'title="ubah data kategori ini"');
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kompetensi Dasar',
);

// pills link

//if ($admin):
	$pills[] = array(
			'label' => '<i class="icon-star"></i>Tambah',
			'uri' => "data/akademik/kompetensi_dasar/form",
			'attr' => 'title="tambah kategori baru"',
			'class' => 'active',
	);
//endif;

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
		'kurikulum_id' => array(
				'kurikulum_id',
				'type' => 'dropdown',
				'name' => 'kurikulum_id',
				'id' => 'kurikulum_id',
				'extra' => 'id="kurikulum_id" class="input input-medium select"',
				'options' => $this->m_option->kurikulum('kurikulum'),
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
		'grade' => array(
				'grade',
				'type' => 'dropdown',
				'name' => 'grade',
				'id' => 'grade',
				'extra' => 'id="grade" class="input input-medium select"',
				'options' => $this->m_option->grade('grade'),
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
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kurikulum' => 'kurikulum_nama',
				'Kategori' => 'kategori_nama',
				'Mapel' => 'mapel_nama',
				'Grade' => 'grade_nama',
				'Kode' => 'kode',
				'Nama' => 'nama',
				'ID KD E-rapor Pengetahuan' => 'kode_erapor_teori',
				'ID KD E-rapor Ketrampilan' => 'kode_erapor_praktek',
				
		),
);

//if ($admin)
$table['data']['Action'] = array(FALSE, 'display_action');

// bars
$bars = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kurikulum_id'], $request) . '&nbsp;'
			. form_cell($input['kategori_id'], $request) . '&nbsp;'
			. form_cell($input['mapel_id'], $request) . '&nbsp;'
			. form_cell($input['grade'], $request) . '&nbsp;'
			
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			
			. form_close()
			. '</div>';
			
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Kompetensi Dasar')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Kompetensi Dasar</h1>
				</div>

				<?php
				echo alert_get();
				echo $bars;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>