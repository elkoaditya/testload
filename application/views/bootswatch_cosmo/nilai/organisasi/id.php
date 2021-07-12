<?php

// vars
// function

function display_pembina($row) {
	return a("data/profil/sdm/id/{$row['pembina_id']}", $row['pembina_nama'], 'title="lihat profil pembina"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Organisasi' => 'nilai/organisasi',
		"#{$row['id']}",
);

// pills link

$pills[] = array(
		'label' => 'Daftar Keterangan Organisasi',
		'uri' => "nilai/organisasi",
		'attr' => 'title="kembali ke daftar keterangan organisasi"',
);

$pills[] = array(
		'label' => 'Detail Organisasi',
		'uri' => "data/non_akademik/organisasi/id/{$row['org_id']}",
		'attr' => 'title="lihat detail organisasi"',
);

$pills_nisisorg = array();

if ($row['semester_id'] == $semaktif['id'] && $admin)
	$pills_nisisorg[] = array(
			'label' => '<i class="icon-upload"></i>Impor',
			'uri' => "nilai/organisasi/impor/" . $row['id'],
			'attr' => 'title="impor keterangan organisasi siswa"',
			'class' => 'active',
	);

// data tabel

$detail['umum'] = array(
		'Semester' => array(
				'semester_nama',
				'ucfirst',
				'suffix' => array(
						' ',
						'ta_nama',
				),
		),
		'Organisasi' => array('org_nama'),
		'Pembina' => array('pembina_nama'),
);

// input filter/pencarian siswa

$input = array(
		'term' => array(
				'term',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-xlarge',
				'placeholder' => 'pencarian siswa',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-small select"',
				'options' => $this->m_option->kelas('kelas'),
		),
);

// pagination data siswa

if ($siswa_resultset['overload'] == TRUE)
	$stat = "{$siswa_resultset['start']} sampai {$siswa_resultset['end']}. Total lebih dari {$siswa_resultset['total_rows']} baris.";
else
	$stat = "{$siswa_resultset['start']} sampai {$siswa_resultset['end']} dari {$siswa_resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 6,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => "{$uri}/{$row['id']}",
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

$this->md->paging($siswa_resultset, $pagination);

// subtabel data siswa

$siswa_table = array(
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'NIS' => 'siswa_nis',
				'Nama' => 'siswa_nama',
				'L/P' => array('siswa_gender', 'strtoupper'),
				'Keterangan' => 'keterangan',
		),
);

//baars

$bar = '<div>'
		. form_opening("{$uri}/{$row['id']}", 'method = "get" class = "form-search well"')
		. pills($pills_nisisorg, 'class="nav nav-pills pull-right"')
		. form_cell($input['term'], $request) . '&nbsp;	'
		. form_cell($input['kelas_id'], $request) . '&nbsp;	'
		. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
		. a("{$uri}/{$row['id']}", 'Reset', 'class="btn" title="reset pencarian"')
		. form_close()
		. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Keterangan Organisasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Keterangan Organisasi</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				echo alert_get();

				// data utama

				echo pills($pills);
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				// daftar siswa

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Daftar Keterangan Siswa</legend>';
				echo $bar;
				echo ds_table($siswa_table, $siswa_resultset);
				echo '</fieldset></div><br/><br/>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>