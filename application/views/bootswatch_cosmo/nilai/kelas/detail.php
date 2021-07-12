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

function display_kelulusan($row)
{
	$path = "content/generate_kelulusan/".APP_SCOPE."/{$row['siswa_nis']}.pdf";
	
	if(file_exists(APP_ROOT.$path))
	{
		return a($path, 'Surat<br>Kelulusan', 
		'class="btn btn-primary" title="download hasil generate surat keputusan" target="_blank"');
	}
}

function display_nilai($row)
{
	// $ad = array{}}
	return $row['pelajaran_nama']; 
}

function nilai_kosong($nilai)
{
	// $ad = array{}}
	if($nilai == 0){
		$nilai = '-';
	}
	return $nilai; 
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

if ($id_nilai_siswa['overload'] == TRUE)
	$stat = "{$id_nilai_siswa['start']} sampai {$id_nilai_siswa['end']}. Total lebih dari {$id_nilai_siswa['total_rows']} baris.";
else
	$stat = "{$id_nilai_siswa['start']} sampai {$id_nilai_siswa['end']} dari {$id_nilai_siswa['total_rows']} baris.";

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

$this->md->paging($id_nilai_siswa, $pagination);

// subtabel data siswa  
$siswa_table = array(
		'table_properties' => array(
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Mapel' => 'mapel_nama',  
				'Ranking Pelajaran' => 'rank_pelajaran',  
		),
);
for($a=1;$a<=10;$a++){
	$nama_kd = "pengetahuan<br>kd".$a;
	
	for($b=1;$b<=3;$b++){
		$nu[$a][$b] = (($a-1)*4) + $b;
		if($nu[$a][$b] != 0){
			
		}
		// $kdbobot[$a][$b] = (($a-1)*4) + $b;
	}
	
	$siswa_table['data'][$nama_kd] = array(
						'nipel_kkm',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				);
}
$siswa_table['data']["Nilai<br>Pengetahuan"] = 'nas_teori';

for($a=1;$a<=10;$a++){
	$nama_kd = "keterampilan<br>kd".$a;
	$siswa_table['data'][$nama_kd] = array(
						'nipel_kkm',
						'formnil_angka',
						'prefix' => '<div align="right">',
						'suffix' => '</div>',
				);
}
$siswa_table['data']["Nilai<br>keterampilan"] = 'nas_praktek';
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
				//alert_dump($id_nilai_siswa['data'][0], 'row');
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
				
				$cthead = 't-head my-widget-header';
				$ctbody = 't-data my-state-default table-0';
				$kat = array(
					array(
					"kode" => "nas_teori",
					"nama" => "pengetahuan", 
					),
					array(
					"kode" => "nas_praktek",
					"nama" => "keterampilan", 
					),
				);
				foreach($id_nilai_siswa['data'] as $knsiswa =>$vnsiswa){ 
					echo '<legend>'.$vnsiswa['siswa_nama'].'</legend>';
					?>
					<table id="tabel-siswa" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<td class="<?=$cthead?>" rowspan="2" style="min-width: 10px;"><b>#</b></td>
								<td class="<?=$cthead?>" rowspan="2"><b>Mapel</b></td>
								<td class="<?=$cthead?>" rowspan="2"><b>Ranking Pelajaran </b></td>
								<td class="<?=$cthead?>" rowspan="2"><b>UTS</b></td>
								<td class="<?=$cthead?>" rowspan="2"><b>UAS</b></td> 
								<td class="<?=$cthead?>" colspan="11" style="text-align:center !important;"><b>Pengetahuan </b></td>
								<td class="<?=$cthead?>" colspan="11" style="text-align:center !important;"><b>keterampilan </b></td> 
							</tr>
							<tr>
								<?php  
									for($x=0;$x<count($kat);$x++){
										for($z=1;$z<=10;$z++){
											$nama_kd = "kd".$z;
											
											// for($y=1;$y<=3;$y++){
												// $nu[$z][$y] = (($z-1)*4) + $y;
											// }
											echo '<td class="'.$cthead.'"><b>'.$nama_kd.'</b></td>'; 
										} 
										echo '<td class="'.$cthead.'"><b>Nilai<br>'.$kat[$x]['nama'].'</b></td>'; 
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
							foreach($resultset_array[$vnsiswa['id']]['data'] as $kns =>$vns){   
								$no++;
							?> 
								<tr>
									<td class="<?=$ctbody?>"><?=$no?></td>
									<td class="<?=$ctbody?>"><?=$vns['mapel_nama']?></td> 
									<td class="<?=$ctbody?>"><?=$vns['rank_pelajaran']?></td> 
									<td class="<?=$ctbody?>"><?=nilai_kosong($vns['uts'])?></td> 
									<td class="<?=$ctbody?>"><?=nilai_kosong($vns['uas'])?></td> 
									<?php   
										for($z=1;$z<=10;$z++){ 
											
											$x=0; 
											$nkd = 0;
											for($y=1;$y<=3;$y++){
												$nu = (($z-1)*4) + $y;
												if($vns["u".$nu]>0){
													$x++; 
													if($vns["kd".$z."_bobot".$y] >0){
														$vns["u".$nu] = round(($vns["u".$nu]*$vns["kd".$z."_bobot".$y])/100,2);
													}
													$nkd += $vns["u".$nu];
												} 
											}
											if($x > 0){
												$nkd = round($nkd / $x,2); 
											}
											echo '<td class="'.$ctbody.'">'.nilai_kosong($nkd).'</td>'; 
										} 
										echo '<td class="'.$ctbody.'"> '.nilai_kosong($vns['nas_teori']).'</td>';  
									?>
									<?php   
										for($z=1;$z<=10;$z++){ 
											
											$nkd = 0;
											$x=0; 
											for($y=1;$y<=3;$y++){
												$np = (($z-1)*4) + $y;
												if($vns["p".$np]>0){
													$x++; 
													$nkd += $vns["p".$np];
												}
												// $nkd .= $vns["p".$np].' ('.$vns["kd".$z."_bobot".$y].')<br>';
												// $nkd .= $vns["p".$np].' ('.$vns["kd".$z."_bobot".$y].')<br>';
											}
											if($x > 0){
												$nkd = round($nkd / $x,2); 
											}
											echo '<td class="'.$ctbody.'">'.nilai_kosong($nkd).'</td>'; 
										} 
										echo '<td class="'.$ctbody.'"> '.nilai_kosong($vns['nas_praktek']).'</td>';  
									?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					
					<?php
					// echo "<pre>";
					// print_r($resultset_array[$vnsiswa['id']]);
					// echo "<pre>";
					// echo ds_table($siswa_table, $resultset_array[$vnsiswa['id']]);
				}
				echo '</fieldset></div><br/><br/>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>