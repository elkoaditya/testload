<?php

// function

function display_jawaban($row) {
	$row['respon_jawaban'] = base64_decode($row['respon_jawaban']);
	$row['respon_jawaban'] = str_replace("103.101.225.104","fresto.top",$row['respon_jawaban']);
	
	$print = '';
	if($row['respon_jawaban']!=''){
		
		$coba = explode("<img src=",$row['respon_jawaban']);
		
		$jumlah=0;
		foreach($coba as $c){
		
			if($jumlah>0){
				$c = '<img src='.$c;
			}
			$doc = new DOMDocument();
			$doc->loadHTML($c);
			$xpath = new DOMXPath($doc);
			$src = $xpath->evaluate("string(//img/@src)");

			
			$c = str_replace('<img src=',
			 '<a data-magnify="gallery" data-src="" data-caption="1" data-group="a" href="'.$src.'" > <img src=',$c);
			
			$print .= $c;
			$jumlah++;
		}
	}
		//return $row['respon_jawaban'] ;
	
	return $print;
}

function display_nama($row) {
	return a("data/profil/siswa/id/{$row['user_id']}?ringkas=ya", $row['siswa_nama'], 'title="lihat detail data siswa ini"');
}

function display_nilai($row) {
	
	$edit_nilai = '<br><a href="'.base_url().'kbm/materi/form_nilai_pembaca?id='.$row['id'].'" class="btn btn-info">
						edit
					</a>';
												
	if($row['nilai']>0){
		return "<div style='color:blue;'><b>".$row['nilai']."</b></div>".$edit_nilai;
	}else{
		return "kosong".$edit_nilai;
	}
}

// komponen

$this->load->helper('dataset');

// user akses

$author = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Materi' => 'kbm/materi',
		"#{$row['id']}" => "kbm/materi/id/{$row['id']}",
		'Pembaca'
);

// pills link

$pills[] = array(
		'label' => 'Tabel',
		'uri' => "kbm/materi",
		'attr' => 'title="kembali ke tabel materi"',
);
$pills[] = array(
		'label' => 'Kembali',
		'uri' => "kbm/materi/id/{$row['id']}",
		'attr' => 'title="kembali ke tampilan materi"',
);

// pills link
$pills2 = array();
$pills2[] = array(
	'label'	 => "<i class=\"icon-download\"></i>Download Nilai",
	'uri'	 => "kbm/materi/download_nilai/{$row['id']}",
	'attr'	 => 'title="Download nilai materi"',
	'class'	 => 'active',
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
		'status_baca' => array(
				'status_baca',
				'type' => 'dropdown',
				'name' => 'status_baca',
				'id' => 'status_baca',
				'extra' => 'class="input-medium select"',
				'options' => array(
						'' => 'status baca',
						'sudah' => 'sudah baca',
						'belum' => 'belum baca',
				),
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
		'next_link' => '???',
		'prev_link' => '???',
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
				'Siswa/Kelas' => array(
						FALSE,
						'display_nama',
						'suffix' => array(
								'<br/><span style="opacity: 0.8;">',
								'kelas_nama',
								'</span>'
						),
				),
				'Membaca' => array(
						'<div title="terakhir dibaca pada ',
						'suffix' => array(
								array('baca_waktu', 'tglwaktu'),
								'">',
								'baca_count',
								' kali<br/><span style="opacity: 0.8;">',
								array('baca_waktu', 'date2tgl'),
								'</span>',
								'</div>',
						),
				),
				'Jawaban' => array(
						FALSE,
						'display_jawaban',
						//'respon_jawaban',
						//'base64_decode',
						'suffix' => array(
								'<br/><span style="opacity: 0.8;">',
								array('respon_waktu', 'date2tgl'),
								'</span>',
						),
				),
				'Terakhir Komentar dengan Guru' => array(
						'komentar_konten',
						'base64_decode',
						'suffix' => array(
								'<br>
								<a href="'.base_url().'kbm/materi/komentar/'.$row['id'].'',
								'/',
								array('id'),
								'" class="btn btn-info">
									Beri Komentar
								</a>
								<br/><span style="opacity: 0.8;"><b>',
								array('komentar_author_nama'),
								'</b>',
								array('komentar_registered', 'date2tgl'),
								'</span>',
						),
				),
				'Nilai' => array(
						FALSE,
						'display_nilai',
				),
		),
);

// bars

$bar_pills = pills($pills);
$bar_pencarian = '<div>'
			. form_opening("{$uri}/{$row['id']}", 'method="get" class="form-search well"')
			. pills($pills2, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kelas_id'], $request) . '&nbsp;'
			. form_cell($input['status_baca'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a("{$uri}/{$row['id']}", 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Materi #{$row['id']}")); ?>
 
  
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

				<link href="https://cdn.bootcss.com/balloon-css/0.5.0/balloon.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/jquery_image_viewer/css/jquery.magnify.css" rel="stylesheet">
 <!-- <link href="<?php echo base_url();?>assets/jquery_image_viewer/css/snack.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/jquery_image_viewer/css/snack-helper.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/jquery_image_viewer/css/docs.css" rel="stylesheet">-->
  
  
 
  
				<?php
				echo alert_get();

				$info = "Materi #{$row['id']}"
							. "<br/>Oleh "
							. a("data/profil/sdm/id/{$row['author_id']}", $row['author_nama'], 'title="lihat profil ' . strtolower(GURU_ALIAS) . ' ini"')
							. "<br/>Mapel "
							. a("data/akademik/pelajaran/id/{$row['pelajaran_id']}", $row['mapel_nama'], 'title="lihat detail pelajaran"')
							. " ({$row['pelajaran_kode']})";

				echo p('', $info);

				// pertanyaan

				echo p('', '<b>Pertanyaan siswa</b>')
				. $row['pertanyaan']
				. '<br/><br/><br/>';

				// tabel pembaca

				echo tag('h3', '', 'Aktifitas Belajar Siswa');
				echo $bar_pills;
				echo $bar_pencarian;
				
				libxml_use_internal_errors(true);
				echo ds_table($table, $resultset);
				echo $bar_pencarian;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="<?php echo base_url();?>assets/jquery_image_viewer/js/vendor/jquery-1.12.4.min.js"><\/script>')

  </script>
 <!--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://cdn.bootcss.com/prettify/r298/prettify.min.js"></script>
  <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="<?php echo base_url();?>assets/jquery_image_viewer/js/jquery.magnify.js"></script>
   
	</body>
</html>