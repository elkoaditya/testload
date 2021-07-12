<?php

// vars

//$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";
$_SERVER['REQUEST_URI'] = str_replace(APP_SUBDOMAIN.'/','',$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];

// fungsi

function display_status_download($row)
{
	
	if ($row['akses_rapor']==1)
		return '<div style="color:green;"><b>BOLEH AKSES RAPOR</b></div> ';
	else
		return '<div style="color:red;"><b>TIDAK BOLEH AKSES RAPOR</b></div>';

}

function display_rapor_mid($row)
{
	$tipe='_mid';
	$semester_nama = strtolower($row['semester_nama']);
	$ta_nama = str_replace("/","-",$row['ta_nama']);
	$file2 = "content/generate_rapor".$tipe."/".APP_SCOPE."/".$semester_nama."_".$ta_nama."/".$row['siswa_nis'].".pdf";
	$file = APP_ROOT.$file2;
	
	if (file_exists($file)){
		$exists = true;
	}else{
		$exists = false;
	}
	
	if($exists==true){
		return  a($file2, 'RaporMid', 'class="btn btn-info" title="hasil cetak siswa"');
		
	}else{
		return "FILE NOT EXIT";
	}

}

function display_rapor_akhir($row)
{
	
	$tipe='';
	$semester_nama = strtolower($row['semester_nama']);
	$ta_nama = str_replace("/","-",$row['ta_nama']);
	$file2 = "content/generate_rapor".$tipe."/".APP_SCOPE."/".$semester_nama."_".$ta_nama."/".$row['siswa_nis'].".pdf";
	$file = APP_ROOT.$file2;
	
	if (file_exists($file)){
		$exists = true;
	}else{
		$exists = false;
	}
	
	if($exists==true){
		return  a($file2, 'RaporAkhir', 'class="btn btn-info" title="hasil cetak siswa"');
		
	}else{
		return "FILE NOT EXIT";
	}

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
	'Nilai'							 => 'nilai',
	'Siswa' 						 => 'nilai/siswa',
	'Status Akses Rapor Siswa'
);

// input filter/pencarian

$input = array(
	'term'			 => array(
		'term',
		'placeholder'	 => 'pencarian',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-small',
	),
	'semester_id'	 => array(
		'semester_id',
		'type'		 => 'dropdown',
		'name'		 => 'semester_id',
		'id'		 => 'semester_id',
		'extra'		 => 'name = "semester_id" class = "input-medium select"',
		'options'	 => $this->m_option->semester(TRUE),
	),
	'kelas_id'		 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
	'akses_rapor'	 => array(
		'akses_rapor',
		'type'		 => 'dropdown',
		'name'		 => 'akses_rapor',
		'id'		 => 'akses_rapor',
		'extra'		 => 'name = "akses_rapor" class = "input-medium select"',
		'options'	 => array(
			0			 => 'Tampil Semua',
			2	 		 => 'Tidak Boleh Akses',
			1			 => 'Boleh Akses',
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
		
		'Status Download Rapor'		=> array(FALSE, 'display_status_download'),
		'Cek'	 		=> array(FALSE, 'display_select'),
		'Rapor Mid Tercetak'		=> array(FALSE, 'display_rapor_mid'),
		'Rapor Akhir Tercetak'		=> array(FALSE, 'display_rapor_akhir'),
		
	),
);


$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['kelas_id'], $request) . '&nbsp;'
	. form_cell($input['semester_id'], $request) . '&nbsp;'
	. form_cell($input['akses_rapor'], $request) . '&nbsp;'
	. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"'). '&nbsp;'
	. form_close()
	. '</div>';
	
$bar2 = '<ul class="nav nav-pills pull-right" style="margin-bottom:-5px">'
	.'<li class="active" style="margin-right:5px">
		<input type="checkbox" onClick="toggle(this)" /> <b>Select All</b>
	  </li>'
	.'<li class="active" style="margin-right:5px">
		<button type="submit" class="btn btn-success nav nav-pills pull-right" name="keikutsertaan" value="1">
			<i class="icon-save icon-white"></i> BOLEH AKSES RAPOR
		</button></li>'
	.'<li class="active">
		<button type="submit" class="btn btn-danger nav nav-pills pull-right" name="keikutsertaan" value="0">
			<i class="icon-save icon-white"></i> TIDAK BOLEH AKSES RAPOR
		</button></li>'
	.'</ul>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Status Akses Rapor Siswa")); ?>

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
					<h1>Status Akses Rapor Siswa</h1>
				</div>

				<?php

				echo alert_get();
				
				echo $bar;
				echo form_opening($ruri, 'method="post" class="form-search well"');
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
