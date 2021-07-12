<?php
// vars

$siswa = user_role('siswa');

// function

function display_nama($row) {
	return a("kbm/artikel/id/{$row['id']}", $row['nama'], 'title="lihat artikel ini"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Artikel',
);

// pills link

$pills_kanan = array();

if ($siswa):
	$pills_kanan[] = array(
			'label' => '<i class="icon-star"></i>Tulis Baru',
			'uri' => "kbm/artikel/form",
			'attr' => 'title="tambah artikel baru"',
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
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->semester(),
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->pelajaran_user('pelajaran', 'artikel'),
		),
		'mapel_id' => array(
				'mapel_id',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->mapel('mapel'),
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->kelas('kelas'),
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
				'id' => 'tabel-artikel',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Mapel' => 'mapel_nama',
				'Nama Artikel' => array(FALSE, 'display_nama'),
				'Penulis' => 'author_nama',
				'Kelas' => 'kelas_nama',
		),
);

// bars

$pencarian = '<div>'
		. form_opening($uri, 'method="get" class="form-search well"')
		. pills($pills_kanan, 'class="nav nav-pills pull-right"')
		. form_cell($input['term'], $request) . '&nbsp;'
		. form_cell($input['semester_id'], $request) . '&nbsp;'
		. form_cell($input['pelajaran_id'], $request) . '&nbsp;';

if (!$siswa):
	$pencarian .= form_cell($input['kelas_id'], $request) . '&nbsp;';
endif;

$pencarian .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
		. a($uri, 'Reset', 'class="btn"')
		. form_close()
		. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Artikel Spotcapture')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1><?php echo (APP_DOMAIN == 'anugrahbangsa.fresto.co') ? 'Spotcapturing' : 'Artikel Siswa'; ?></h1>
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