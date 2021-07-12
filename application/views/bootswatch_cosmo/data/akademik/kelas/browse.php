<?php

// function

function display_nama($row) {
	$anonim = user_role('anonim');
	$link_detail = a("data/akademik/kelas/id/{$row['id']}", $row['nama'], 'title="lihat detail kelas"');
	return (!$anonim) ? $link_detail : $row['nama'];
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kelas',
);

// pills link

$pills = array();

if ($admin):
	$pills[] = array(
			'label' => '<i class="icon-star"></i> Tambah',
			'uri' => "data/akademik/kelas/form",
			'attr' => 'title="tambah kelas baru"',
			'class' => (($semaktif['id'] == 0) ? 'active' : 'disabled'),
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
		'jurusan_id' => array(
				'jurusan_id',
				'type' => 'dropdown',
				'name' => 'jurusan_id',
				'id' => 'jurusan_id',
				'extra' => 'id="jurusan_id" class="input-medium select"',
				'options' => $this->m_option->jurusan('jurusan'),
		),
		'grade' => array(
				'grade',
				'type' => 'dropdown',
				'name' => 'grade',
				'id' => 'grade',
				'extra' => 'id="grade" class = "input-small select" ',
				'options' => array(
						// sma-smk-man
						'' => 'grade',
						10 => 'X',
						11 => 'XI',
						12 => 'XII',
				),
		),
		'wali_id' => array(
				'wali_id',
				'type' => 'dropdown',
				'name' => 'wali_id',
				'id' => 'wali_id',
				'extra' => 'id = "wali_id" class = "input-medium select" placeholder = "wali"',
				'options' => $this->m_option->sdm('wali'),
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
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Grade' => 'grade',
				'Kelas' => array(FALSE, 'display_nama'),
				'Wali' => array('wali_nama'),
				'NIP' => array('wali_nip'),
				'Kurikulum' => 'kurikulum_nama',
		),
);

if ($semaktif['id'] > 0):
	$table['data']['Siswa'] = 'siswa_jml';

elseif ($semaktif['id'] == 0 && $admin):
	$table['data']['Aktif'] = array('aktif', array('tidak', 'ya'));

endif;

// bars

$bar_filter = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['jurusan_id'], $request) . '&nbsp;'
			. form_cell($input['grade'], $request) . '&nbsp;'
			. form_cell($input['wali_id'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Kelas</h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_filter;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>