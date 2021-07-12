<?php

// function

function display_nama($row) {
	if($row['role']=='siswa'){
		return a("data/profil/siswa/id/{$row['id']}?ringkas=ya", $row['nama'], 'title="lihat detail data siswa ini"');
	}elseif($row['role']=='sdm'){
		return a("data/profil/sdm/id/{$row['id']}?ringkas=ya", $row['nama'], 'title="lihat detail data guru ini"');
	}else{
		return $row['nama'];
	}
}

function display_role($row) {
	if($row['role']=='siswa'){
		$role = 'Siswa';
	}elseif($row['role']=='sdm'){
		$role = 'Guru';
	}elseif($row['role']=='admin'){
		$role = 'Admin';
	}
	
	return $role;
}

// komponen

$this->load->helper('dataset');

// user akses

$author = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Pengumuman' => 'kbm/pengumuman',
		"#{$row['id']}" => "kbm/pengumuman/id/{$row['id']}",
		'Pembaca'
);

// pills link

$pills[] = array(
		'label' => 'Tabel',
		'uri' => "kbm/pengumuman",
		'attr' => 'title="kembali ke tabel pengumuman"',
);
$pills[] = array(
		'label' => 'Kembali',
		'uri' => "kbm/pengumuman/id/{$row['id']}",
		'attr' => 'title="kembali ke tampilan pengumuman"',
);

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
$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data kosong</i></p>',
		'data' => array(
				'Nama' 		=> array(FALSE,'display_nama'),
				'Kelas' 	=> array('kelas_nama'),
				'Role' 		=> array(FALSE,'display_role'),
				'Membaca' 	=> array('waktu_baca', 'tglwaktu'),
		),
);

// bars

$bar_pills = pills($pills);
$bar_pencarian = '<div>'
			. form_opening("{$uri}/{$row['id']}", 'method="get" class="form-search well"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kelas_id'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a("{$uri}/{$row['id']}", 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Pengumuman #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#docs{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php
				echo alert_get();

				$info = "Oleh {$row['author_nama']}<br/>"
					. "Waktu Publish ".tglwaktu($row['tanggal_publish'])."<br/>"
					. "Waktu Tutup ".tglwaktu($row['tanggal_tutup'])."";

				echo p('', $info);

				

				// tabel pembaca

				echo tag('h3', '', 'Daftar Pembaca');
				echo $bar_pills;
				echo $bar_pencarian;
				echo ds_table($table, $resultset);
				echo $bar_pencarian;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>


	</body>
</html>