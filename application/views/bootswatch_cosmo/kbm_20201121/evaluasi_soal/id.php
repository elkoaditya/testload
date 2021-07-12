<?php
// breadcrumbs

/// set metode baru juli 2017
$set_form = "form";
if($evaluasi['metode'] == "upload"){
	$set_form = "form2";
}


// HIDDEN NILAI
$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		"Nilai" => "kbm/evaluasi_nilai/browse?evaluasi_id={$evaluasi['id']}",
		"LJS" => "kbm/evaluasi_ljs/browse?evaluasi_id={$evaluasi['id']}",
		"#{$row['id']}",
);

// pills link

$pills_kiri['evaluasi_browse'] = array(
		'label' => 'Daftar Evaluasi',
		'uri' => "kbm/evaluasi",
		'attr' => 'title="kembali ke daftar evaluasi"',
);
$pills_kiri['evaluasi_id'] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
		'attr' => 'title="kembali ke detail evaluasi"',
);



if ($user['role'] == 'siswa'):
	
	$pills_kanan = array(
			'jawab' => array(
					'label' => '<i class="icon-pencil"></i> Coba Lagi',
					'uri' => "kbm/evaluasi_ljs/".$set_form."?id={$evaluasi['id']}",
					'attr' => 'title="beri catatan pada ini"',
					'class' => 'disabled',
			),
	);
	if($pengerjaan_ljs['id']):
		$pills_kanan['jawab']['label'] = '<i class="icon-pencil"></i> Teruskan Pengerjaan';
	endif;
	
	//if ($siswa_ybs && $evaluasi['#available']):
	if ($siswa_ybs):
		if(( $pengerjaan_ljs['id']) || ( $evaluasi['#available'] && !$pengerjaan_ljs['id'])):
			$pills_kanan['jawab']['class'] = 'active';
		endif;
	endif;

else:
	$pills_kanan = array(
			'koreksi' => array(
					'label' => '<i class="icon-ok"></i> Koreksi',
					'uri' => "kbm/evaluasi_ljs/koreksi?id={$row['id']}",
					'attr' => 'title="koreksi poin jawaban ini"',
					'class' => 'disabled',
			),
	);

	/*$pills_kanan['roleback'] = array(
					'label' => '<i class="icon-repeat"></i> Roleback Pengerjaan ',
					'uri' => "kbm/evaluasi_ljs/roleback?id={$row['id']}",
					'attr' => 'title="roleback pengerjaan siswa ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK ROLEBACK PERJAKAAN INI?\')"',
					'class' => 'disabled',
	);*/
	$roleback = '<div><ul class="nav nav-pills pull-right"><input id="clickMe" class="btn btn-primary" '.
		' type="button" value="Roleback Pengerjaan" onclick="modelRoleback('.$row['id'].')" /></ul></div>';
	
	if (($admin OR $author_ybs) && $evaluasi['semester_id'] == $semaktif['id'] && !$evaluasi['closed']):
		$pills_kanan['koreksi']['class'] = 'active';
		//$pills_kanan['roleback']['class'] = 'active';
	endif;


endif;

$pills_kanan[] = array(
		'label' => '<i class="icon-print"></i> Cetak',
		'uri' => "kbm/evaluasi_ljs/id/{$row['id']}?pdf=true",
		'attr' => 'title="cetak lembar jawaban ini"',
		'class' => 'active',
);

// tabel data

$dset['Nama'] = array('siswa_nama');
$dset['Kelas'] = 'kelas_nama';

// HIDDEN NILAI
//$dset['Nilai'] = array('nilai');

if ($user['role'] != 'siswa' OR $evaluasi['closed'])
	$dset['Skor Poin'] = array(
			'poin',
			'suffix' => array(
					' / ',
					'poin_max',
			),
	);


// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. $roleback
			. '</div>';

// pesan

if ($siswa_ybs && !$evaluasi['closed'])
	alert_info('Untuk informasi poin skor dan kunci (pilihan ganda) tiap butir soal menunggu evaluasi ditutup.');
	
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Lembar Jawab Soal')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header alert-block">
					Lembar Jawab Soal :<br/>
					<h1><?php echo strtoupper($evaluasi['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					.pengecoh{
						display: none;
					}
				</style>

				<?php
				//print_r($evaluasi);
				//print_r($row);
				
				echo alert_get();
				echo $bar_pill;

				// data utama

				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label>"
					. "<div class=\"controls\">" . data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				foreach ($butir_result['data'] as $idx => $butir):
					soal_prepjwb($butir);

					echo '<div class="well">';
					echo '<fieldset>';
					echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";
					echo "<b><div style='font-size:18'>Soal Bagian ke - &nbsp; " . ($butir['posisi_kd']) . "</div></b>";
					
					// tampilkan pertanyaan

					// FIX URL GAMBAR
					$butir['pertanyaan'] 					= str_replace('<img src="/','<img src="'.base_url(),$butir['pertanyaan']);
					$butir['pertanyaan'] 					= str_replace('<img src="../../','<img src="'.base_url(),$butir['pertanyaan']);
					if(isset($butir['pilihan']))
					{
						$butir['pilihan']['kunci']['label']	= str_replace('<img src="/','<img src="'.base_url(),$butir['pilihan']['kunci']['label']);
						$butir['pilihan']['pengecoh']		= str_replace('<img src="/','<img src="'.base_url(),$butir['pilihan']['pengecoh']);
						
						$butir['pilihan']['kunci']['label']	= str_replace('<img src="../../','<img src="'.base_url(),$butir['pilihan']['kunci']['label']);
						$butir['pilihan']['pengecoh']		= str_replace('<img src="../../','<img src="'.base_url(),$butir['pilihan']['pengecoh']);
					
						$butir['jwb_jawaban']	= str_replace('<img src="/','<img src="'.base_url(),$butir['jwb_jawaban']);
						$butir['jwb_jawaban']	= str_replace('<img src="../../','<img src="'.base_url(),$butir['jwb_jawaban']);
					}
	
					//if ($user['role'] != 'siswa' OR $evaluasi['closed'])
						echo div('class="soal-pertanyaan"', $butir['pertanyaan']) . '<br/>';

					// poin

					if ($user['role'] != 'siswa' OR $evaluasi['closed'])
						echo "<div><b>Poin: </b>{$butir['jwb_poin']} / {$butir['poin_max']}</div>";

					// jawaban
					if ($user['role'] != 'siswa' OR $evaluasi['closed'] OR $evaluasi['pilihan_jml']==0 )
					{
						echo "<div><b>Jawaban:</b>";
						echo ul(array($butir['jwb_jawaban']));
						echo "</div>";
					}else
					{
						//echo "MAAF RAHASIA :)";
					}
					// pilihan, bila ada

					if ($butir['pilihan'] && ($user['role'] != 'siswa' OR $evaluasi['closed'] )):

						$kunci = (array) array_node($butir, 'pilihan', 'kunci', 'label');
						$pengecoh = (array) array_node($butir, 'pilihan', 'pengecoh');

						echo "<div><b>Kunci:</b>";
						echo ul($kunci);
						echo "</div>";

						echo "<div>";
						echo "<div class=\"btn btn-info btn-small\" onClick=\"$('#pengecoh-{$butir['id']}').slideToggle(200);\">Pengecoh</div>";
						echo ul($pengecoh, "id=\"pengecoh-{$butir['id']}\" class=\"pengecoh\"");
						echo "</div>";

					endif;

					echo '<fieldset>';
					echo "</div>";

				//dump($butir);

				endforeach;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php 
		echo cosmo_js(); 
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		$this->load->view (THEME .'/kbm/evaluasi_ljs/modal_roleback'); ?>

	</body>
</html>