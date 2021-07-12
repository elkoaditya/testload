<?php

// vars
$get_download = explode('?',$_SERVER['REQUEST_URI']);
$ruri = "{$uri}?".$get_download[1];

/// SHOW LIMIT
//print_r($resultset);
$data_ikut			= '';
$data_tidak_ikut	= '';
$total_rows['ikut']			= 0;
$total_rows['tidak_ikut']	= 0;

foreach($resultset['data'] as $data){
	if($data['total_waktu']>0){
		$data_ikut[]		 = $data;
		$total_rows['ikut']++;
	}else{
		$data_tidak_ikut[] = $data;
		$total_rows['tidak_ikut']++;
	}
}
$title='';

if($this->input->get('ikut')){
	$title = " <font color='green'>Semua Peserta Ikut</font>";
	$resultset['data'] 			= $data_ikut;
	$resultset['total_rows'] 	= $total_rows['ikut'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}
if($this->input->get('tidak_ikut')){
	$title = " <font color='red'>Semua Peserta Tidak Ikut</font>";
	$resultset['data'] = $data_tidak_ikut;
	$resultset['total_rows'] 	= $total_rows['tidak_ikut'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}

// fungsi
function display_status($row)
{
	if($row['total_waktu']>0){
		return ' <div style="color:green;"><b><i>Ikut</i></b></div> ';
	}else{
		return ' <div style="color:red;"><b><i>Tidak Ikut</i></b></div> ';
	}

}
function display_total_waktu($row)
{
	if($row['total_waktu']>0){
		return ' <div style="color:green;"><b><i>'.$row['total_waktu'].' Menit</i></b></div> ';
	}else{
		return ' <div style="color:red;"><b><i>'.$row['total_waktu'].' Menit</i></b></div> ';
	}

}


// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Video Call'						 => 'kbm/vidcall',
	"#{$row['id']}"			 => "kbm/vidcall/id/{$row['id']}",
	'Ljs',
);

// pills link
$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Cek Terbaru',
		'uri'	 => $ruri,
		'attr'	 => 'title="Cek Terbaru" class="btn btn-primary"',
		'class'	 => 'active',
	);

$pills2[] = array(
	'label'	 => '<i class="icon-check"></i>Ikut Vidcall',
	'uri'	 => $uri."?id={$row['id']}&kelas_id=".$this->input->get('kelas_id')."&ikut=1",
	'attr'	 => 'title="Tampilan yang Ikut Vidcall"',
	'class'	 => 'active',
);
$pills2[] = array(
	'label'	 => '<i class="icon-thumbs-down"></i>Tidak Ikut Vidcall',
	'uri'	 => $uri."?id={$row['id']}&kelas_id=".$this->input->get('kelas_id')."&tidak_ikut=1",
	'attr'	 => 'title="Tampilan yang Tidak Ikut Vidcall" ',
	'class'	 => 'active',
);


$pills2[] = array(
	'label'	 => '<i class="icon-star"></i>Tampilkan Semua',
	'uri'	 => $uri."?id={$row['id']}&kelas_id=".$this->input->get('kelas_id'),
	'attr'	 => 'title="Kembali ke tampilan vidcall" ',
	'class'	 => 'active',
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
		'Status'	 	=> array(FALSE, 'display_status'),
		'Mulai'	=> array('waktu_awal', 'tglwaktu'),
		'Total'	=> array(FALSE, 'display_total_waktu'),
	),
);




$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. '<div><ul class="nav nav-pills pull-left"><b>TERAKHIR CEK<br> <h3>'.date("Y-m-d H:i:s").'</h3></b> </ul></div>'

	. pills($pills2, 'class="nav nav-pills pull-right"')
	."<br><br><br><br>"
	
	. form_close()
	. '</div>';

	

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Record Video Call {$row['id']}")); ?>

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
					
					<b>Surveillance Video Call:<?=$title?></b>
					<?php
					$title2 = strtoupper($row['nama']);
					
					if(isset($_GET['kelas_id'])){
						if($_GET['kelas_id']>0){
							$title2 = strtoupper($row['kelas_result']['data'][$_GET['kelas_id']]['kelas_nama'])." : ".strtoupper($row['nama']);	
						}
					}?>
					<h1><?php echo a("kbm/vidcall/id/{$row['id']}", $title2 , 'title="kembali ke halaman Video Call"'); ?></h1>
					
				</div>

				<?php

				echo alert_get();
				echo $bar;
				
				echo ds_table($table, $resultset, $row);
				

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php 
		echo cosmo_js();
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		?>
	<!--</body>
</html>-->


