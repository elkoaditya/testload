<?php

// vars

//$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";
$_SERVER['REQUEST_URI'] = str_replace(APP_SUBDOMAIN.'/','',$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];

// fungsi

function display_ljs($row)
{
	if (!$row['ljs_id'])
		return '<i>kosong</i>';

	if (!$row['evaluasi_terkoreksi'])
		return a("kbm/evaluasi_ljs/koreksi?id={$row['ljs_id']}", 'koreksi', 'title="koreksi lembar jawab siswa"');

	return a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'lihat', 'title="lihat lembar jawab siswa"');

}

function display_aktif($row)
{
	
	if ($row['aktif']==1)
		return '<div style="color:green;"><b>BOLEH IKUT</b></div> ';
		//<input type="button" class="btn btn-danger" id="myCheck" onclick="non_aktif('.$row["id"].')"  value="Ganti Tidak Ikut">
	else
		return '<div style="color:red;"><b>TIDAK BOLEH IKUT</b></div>';

}

function display_select($row){
	$input['checkbox'] = array(
		'input_ganti' => array(
				'name' => 'input_ganti[]',
				'id' => 'input_ganti',
				'value' => $row['id'],
				'style' => 'margin: 10px 10px 14px 0;',
		),
	);
	
	$html = form_checkbox($input['checkbox']['input_ganti']);
	
	return  $html;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Evaluasi'						 => 'kbm/evaluasi',
	"#{$evaluasi['id']}"			 => "kbm/evaluasi/id/{$evaluasi['id']}",
	'Nilai',
);

// pills link

/*
  $pills[] = array(
  'label' => '<i class="icon-download"></i>Masukan Rapor',
  'uri' => "kbm/evaluasi/rekap?id={$evaluasi['id']}",
  'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
  'class' => (($evaluasi['status'] == 'closed') ? 'active' : 'disabled' ),
  );
  // */
$get_download = explode('?',$_SERVER['REQUEST_URI']);
/*
$pills[] = array(
	'label'	 => '<i class="icon-download"></i>Download',
	'uri'	 => "kbm/evaluasi_nilai/download?".$get_download[1],
	'attr'	 => 'title="Kembali ke tampilan evaluasi" target="_blank"',
);*/
$pills[] = array(
	'label'	 => '<i class="icon-download"></i>Rekalkulasi & Download',
	'uri'	 => "kbm/evaluasi_tool/recal_dl_nilai?".$get_download[1],
	'attr'	 => 'title="Kembali ke tampilan evaluasi" target="_blank"',
);


// input filter/pencarian

$input = array(
	'term'		 => array(
		'term',
		'placeholder'	 => 'keyword',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-medium',
	),
	'kelas_id'	 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
	'order_by'	 => array(
		'order_by',
		'type'		 => 'dropdown',
		'name'		 => 'order_by',
		'id'		 => 'order_by',
		'extra'		 => 'class="input-large select"',
		'options'	 => array(
			'kelas, nama'	 => 'sort: kelas, nama',
			'nilai'			 => 'sort: nilai',
		),
	),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 4,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => $uri,
	'full_tag_open'		 => '<div class="pagination"><ul>',
	'full_tag_close'	 => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
	'cur_tag_open'		 => '<li class="active"><a href="#">',
	'cur_tag_close'		 => '</a></li>',
	'num_tag_open'		 => '<li>',
	'num_tag_close'		 => '</li>',
	'first_tag_open'	 => '<li>',
	'first_tag_close'	 => '</li>',
	'last_tag_open'		 => '<li>',
	'last_tag_close'	 => '</li>',
	'next_tag_open'		 => '<li>',
	'next_tag_close'	 => '</li>',
	'prev_tag_open'		 => '<li>',
	'prev_tag_close'	 => '</li>',
);
$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-nilai',
		'class'	 => 'table table-responsive table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Kelas'	 		=> 'kelas_nama',
		'Siswa'	 		=> 'siswa_nama',
		//'Gender' => array('siswa_gender', 'strtoupper'),
		
		'Status'		=> array(FALSE, 'display_aktif'),
		'Cek'	 		=> array(FALSE, 'display_select'),
		
		'LJS'	 		=> array(FALSE, 'display_ljs'),
		'Nilai Utama' 	=> array('evaluasi_nilai', 'formnil_angka'),
	),
);

if($evaluasi['jml_kd']>1){
	$tampil_kd=1;
	while($tampil_kd<=$evaluasi['jml_kd']){
		$table['data']['Nilai-'.$tampil_kd] = array('evaluasi_nilai_posisi_kd'.$tampil_kd, 'formnil_angka');
		
		$tampil_kd++;
	}
}

$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. form_hidden('evaluasi_id', $request['evaluasi_id'])
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['kelas_id'], $request) . '&nbsp;'
	. form_cell($input['order_by'], $request) . '&nbsp;'
	. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($ruri, 'Reset', 'class="btn"')
	. form_close()
	. '</div>';
	
$bar2 = '<ul class="nav nav-pills pull-right" style="margin-bottom:-5px">'
	.'<li class="active" style="margin-right:5px">
		<input type="checkbox" onClick="toggle(this)" /> <b>Select All</b>
	  </li>'
	.'<li class="active" style="margin-right:5px">
		<button type="submit" class="btn btn-success nav nav-pills pull-right" name="keikutsertaan" value="1">
			<i class="icon-save icon-white"></i> IKUT Evaluasi
		</button></li>'
	.'<li class="active">
		<button type="submit" class="btn btn-danger nav nav-pills pull-right" name="keikutsertaan" value="0">
			<i class="icon-save icon-white"></i> TIDAK IKUT Evaluasi
		</button></li>'
	.'</ul>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal Evaluasi {$evaluasi['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.listing-group {
				margin: 20px 0 10px 0;
			}
			.listing-group .title {
				font-size: 1.4em;
				color: black;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Nilai Hasil Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
				</div>

				<?php

				echo alert_get();
				
				echo $bar;
				echo form_opening($ruri, 'method="post" class="form-search well"');
				echo '<input type="hidden" name="evaluasi_id" value="'.$evaluasi['id'].'">';
				echo '<input type="hidden" name="ganti_keikutsertaan" value="1">';
				echo '<div>'.$bar2.'<br><br><br></div>';
				
				echo ds_table($table, $resultset);
				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>

<script>
	function toggle(source) {
	  checkboxes = document.getElementsByName('input_ganti[]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	  }
	}
</script>
