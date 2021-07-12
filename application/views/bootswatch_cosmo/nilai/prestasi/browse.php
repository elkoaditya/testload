<?php

// function

function display_action($row) {
	return a("data/non_akademik/prestasi/form?id={$row['prestasi_id']}", 'edit nama', 'class="btn btn-warning" title="ubah data prestasi ini"');
}

function display_title($row) {
	return a("nilai/prestasi/id/{$row['id']}", $row['prestasi_nama'], 'title="lihat detail nilai prestasi"');
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Prestasi',
);

// pills link
// input filter/pencarian
//print_r($resultset['data']);
//if ($resultset['data'][0]['semester_id'] == $semaktif['id'] && ($admin))
	$pills_nisisxkul[] = array(
		'label' => '<i class="icon-star"></i>Tambah Daftar Prestasi',
		'uri' => "data/non_akademik/prestasi/form",
		'attr' => 'title="tambah prestasi baru"',
	);
	
$input = array(
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->semester('semester'),
		),
		'prestasi_id' => array(
				'prestasi_id',
				'type' => 'dropdown',
				'name' => 'prestasi_id',
				'id' => 'prestasi_id',
				'extra' => 'class="input-medium select"',
				'options' => array('' => 'prestasi'),
		),
);

//foreach ($prestasi_terkait as $xid => $xnama)
	//$input['prestasi_id']['options'][$xid] = $xnama;

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
				'id' => 'tabel-nixkul',
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
				'Prestasi' => array(FALSE, 'display_title'),
				'Kegiatan Prestasi' => array('kegiatan_prestasi_nama'),
				'Jumlah Siswa' => array('siswa_jml'),
		),
);

if ($admin):
	$table['data']['Action'] = array(FALSE, 'display_action');
endif;
// bars

$bar = '<div>'
		. form_opening($uri, 'method = "get" class = "form-search well"')
		. pills($pills_nisisxkul, 'class="nav nav-pills pull-right"')
		. form_cell($input['semester_id'], $request) . '&nbsp;	'
		. form_cell($input['prestasi_id'], $request) . '&nbsp;	'
		. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
		. a($uri, 'Reset', 'class="btn" title="reset pencarian"')
		. form_close()
		. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Penilaian Prestasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Penilaian Prestasi</h1>
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