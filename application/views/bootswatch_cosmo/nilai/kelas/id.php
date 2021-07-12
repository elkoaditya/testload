<?php
// vars

$view_nilai_siswa = (cfguc_view('akses', 'nilai', 'siswa') OR in_array($row['kelas_id'], cfgu('walikelas')));

// function

function display_wali($row) {
	return a("data/profil/sdm/id/{$row['kelas_wali_id']}", $row['kelas_wali_nama'], 'title="lihat profil wali kelas"');
}

function display_nsiswa($row, $view_nilai_siswa) {
	if (!$view_nilai_siswa)
		return $row['siswa_nama'];

	return a("nilai/siswa/id/{$row['id']}", $row['siswa_nama'], 'title="lihat detail nilai siswa"');
}

function display_mapel($row)
{
	$nama_agama = "";
	if($row['nipel_agama_id']>0){
		$nama_agama = " ({$row['agama_nama']})";
	}
	return a("nilai/pelajaran/id/{$row['pelajaran_nilai_id']}", $row['mapel_nama'].$nama_agama, 'title="lihat detail nilai pelajaran"')
		. "<br/><span style=\"font-size: 80%;\">{$row['guru_nama']}</span>";

}

function display_kelulusan($row)
{
	$path = "content/generate_kelulusan/".APP_SCOPE."/{$row['siswa_nis']}.pdf";
	
	if(file_exists(APP_ROOT.$path))
	{
		return a($path, 'Surat<br>Kelulusan', 
		'class="btn btn-primary" title="download hasil generate surat keputusan" target="_blank"');
	}
}

function link_action_pelajaran($row)
{
	
	$html  ="<div><ul class='nav nav-pills pull-right' style='margin-bottom:-5px'>";
	$html .= "<li class='active'>".a("nilai/pelajaran/excel_deskripsi_kelas/{$row['id']}", 'Deskripsi ', 
			'title="cetak Deskripsi pelajaran per kelas" target="_blank"') . "</li>";
	$html  .="</ul></div>";
	return $html;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Kelas' => 'nilai/kelas',
		"#{$row['id']}",
);

// pills link

$pills[] = array(
		'label' => 'Daftar Nilai Kelas',
		'uri' => "nilai/kelas",
		'attr' => 'title="kembali ke daftar nilai kelas"',
);

$pills[] = array(
		'label' => 'Detail Kelas',
		'uri' => "data/akademik/kelas/id/{$row['kelas_id']}",
		'attr' => 'title="lihat detail kelas"',
);

$pills_nisis[] = array(
		'label' => '<i class="icon-download"></i> Download Excel',
		'uri' => "nilai/kelas/skhun_expor/{$row['id']}/1",
		'attr' => 'title="Download skhun" target="_blank"',
		'class' => 'active',
);
$pills_nisis[] = array(
		'label' => '<i class="icon-download"></i> Upload Excel',
		'uri' => "nilai/kelas/skhun_impor/{$row['id']}",
		'attr' => 'title="Upload skhun"',
		'class' => 'active',
);

///////////////////////////////////////////////////////////////////////
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i> Peringkat',
		'uri' => "nilai/kelas/peringkat/{$row['id']}",
		'attr' => 'title="Download peringkat kelas" target="_blank"',
		'class' => 'active',
);
/*
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i> Leger',
		'uri' => "nilai/kelas/leger/{$row['id']}",
		'attr' => 'title="Download leger nilai kelas" target="_blank"',
		'class' => 'active',
);
*/
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger 6Semester Pengetahuan',
		'uri' => "nilai/kelas/leger_excel_6semester/{$row['id']}/teori/",
		'attr' => 'title="Download leger excel nilai kelas ALL" target="_blank"',
		'class' => 'active',
);
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger 6Semester Ketrampilan',
		'uri' => "nilai/kelas/leger_excel_6semester/{$row['id']}/praktek/",
		'attr' => 'title="Download leger excel nilai kelas ALL" target="_blank"',
		'class' => 'active',
);
/*
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger UTS (1-4)',
		'uri' => "nilai/kelas/leger_excel/{$row['id']}/UTS/",
		'attr' => 'title="Download leger excel nilai kelas" target="_blank"',
		'class' => 'active',
);
*/
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger UTS (1-100)',
		'uri' => "nilai/kelas/leger_excel/{$row['id']}/UTS/1",
		'attr' => 'title="Download leger excel nilai kelas" target="_blank"',
		'class' => 'active',
);
/*
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger Pararel UTS (1-4)',
		'uri' => "nilai/kelas/leger_pararel/{$row['id']}/UTS/",
		'attr' => 'title="Download leger pararel nilai kelas" target="_blank"',
		'class' => 'active',
);
*/
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger Pararel UTS (1-100)',
		'uri' => "nilai/kelas/leger_pararel/{$row['id']}/UTS/1",
		'attr' => 'title="Download leger pararel nilai kelas" target="_blank"',
		'class' => 'active',
);
/*
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger UAS (1-4)',
		'uri' => "nilai/kelas/leger_excel/{$row['id']}/UAS/",
		'attr' => 'title="Download leger excel nilai kelas" target="_blank"',
		'class' => 'active',
);
*/
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger UAS (1-100)',
		'uri' => "nilai/kelas/leger_excel/{$row['id']}/UAS/1",
		'attr' => 'title="Download leger excel nilai kelas" target="_blank"',
		'class' => 'active',
);
/*
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger Pararel UAS (1-4)',
		'uri' => "nilai/kelas/leger_pararel/{$row['id']}/UAS",
		'attr' => 'title="Download leger pararel nilai kelas" target="_blank"',
		'class' => 'active',
);
*/
$pills_nisis1[] = array(
		'label' => '<i class="icon-download"></i>Leger Pararel UAS (1-100)',
		'uri' => "nilai/kelas/leger_pararel/{$row['id']}/UAS/1",
		'attr' => 'title="Download leger pararel nilai kelas" target="_blank"',
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
		'Kelas' => array('kelas_nama'),
		'Walikelas' => array('kelas_wali_nama'),
		'Teori' => array(
				'nas_teori',
				'formnil_angka',
		),
		'Praktek' => array(
				'nas_praktek',
				'formnil_angka',
		),
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
				'NIS' => 'siswa_nis',
				'Nama' => array(FALSE, 'display_nsiswa', $view_nilai_siswa),
				'L/P' => array('siswa_gender', 'strtoupper'),
				'Agama' => 'agama_nama',
				'S' => 'absen_s',
				'I' => 'absen_i',
				'A' => 'absen_a',
				'<div align="right">Teori</div>' => array(
						'nas_teori',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'<div align="right">Praktek</div>' => array(
						'nas_praktek',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'<div align="right">Skor</div>' => array(
						'nas_skor',
						'round',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'<div align="right">Peringkat</div>' => array(
						'rank_kelas',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				),
				'<div align="right">Kelulusan</div>' => array(FALSE, 'display_kelulusan'),
		),
);

// tabel pelajaran

$pelajaran_table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-kd',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>nilai kompetensi kosong</i></p>',
	'data'				 => array(
		'Mapel'			 		=> array(FALSE, 'display_mapel'),
		'Download (Rangkuman Nilai)'=> array(FALSE, 'link_action_pelajaran'),
	),
);

//baars
$bar = '<div>'
		. form_opening("{$uri}/{$row['id']}", 'method = "get" class = "form-search well"')
		. pills($pills_nisis, 'class="nav nav-pills pull-right"')
		. form_close()
		. '</div>';
		
$bar1 = '<div>'
		. form_opening("{$uri}/{$row['id']}", 'method = "get" class = "form-search well"')
		. pills($pills_nisis1, 'class="nav nav-pills pull-right"')
		. form_cell($input['term'], $request) . '&nbsp;	'
		. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
		. a("{$uri}/{$row['id']}", 'Reset', 'class="btn" title="reset pencarian"')
		. form_close()
		. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Nilai Kelas</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				//alert_dump($siswa_resultset['data'][0], 'row');
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
				echo '<legend>SKHUN</legend>';
				echo $bar;
				echo '<legend>Daftar Nilai Siswa</legend>';
				echo $bar1;
				echo ds_table($siswa_table, $siswa_resultset);
				echo '</fieldset></div><br/><br/>';
				
				// daftar pelajaran kelas

				echo '<div><h3>Daftar Pelajaran Siswa</h3></div>';
				echo ds_table($pelajaran_table, $rowsub_pelajaran);
				echo '<br/><br/>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>