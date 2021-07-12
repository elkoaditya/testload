<?php

// function
function display_jumlah_siswa($jml_menilai_siswa) {
	return ($jml_menilai_siswa > 0) ? $jml_menilai_siswa.' siswa' : 'Siswa sekelas';
}

function display_jenis_penilaian($jenis_penilaian) {
	if($jenis_penilaian == 'penilaian_diri')
		return  'Penilaian Diri';
	elseif($jenis_penilaian == 'penilaian_sejawat')
		return  'Penilaian Sejawat';
}

function display_jadwal($row) {
	$cfg = array(
			'show_header' => FALSE,
			'pagination_link' => FALSE,
			'show_stat' => FALSE,
			'show_number' => FALSE,
			'row_action' => FALSE,
			'row_link' => FALSE,
			'jquery' => FALSE,
			'table_properties' => array(
					'id' => 'tabel-jadwal',
					'class' => 'table table-bordered table-striped table-hover',
			),
			'empty_message' => '<i>kosong</i>',
			'data' => array(
					'Kelas' => 'kelas_nama',
					'Mulai' => 'angket_mulai',
					'Ditutup' => 'angket_ditutup',
			),
	);
	return ds_table($cfg, $row['kelas_result']);
}

function display_tipe($row) {
	return ucfirst($row['tipe']) . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');
}

function display_soal_jml($n, $total) {
	return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
}

function display_soal_siswa($row) {
	return ( ($row['soal_jml'] > 0 && $row['soal_jml'] < $row['soal_total']) ? $row['soal_jml'] : $row['soal_total']) . " pertanyaan";
}

function display_ljs_max($n) {
	return ($n == 0) ? '<i>tidak dibatasi</i>' : "{$n} kali";
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$editable = (($author_ybs OR $admin) && $row['semester_id'] == $semaktif['id'] && !$row['closed']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
		'label' => 'Daftar Angket',
		'uri' => "kbm/angket",
		'attr' => 'title="kembali ke daftar angket"',
);
$pills_kanan = array();

if ($user['role'] == 'siswa'):

	// pills khusus siswa

	$pills_kanan = array(
			'jawab' => array(
					'label' => '<i class="icon-pencil"></i> Kerjakan !',
					'uri' => "kbm/angket_ljs/form/{$user['menilai_id']}?id={$row['id']}",
					'attr' => 'title="kerjakan soal angket ini"',
					'class' => 'disabled',
			),
			'ljs' => array(
					'label' => '<i class="icon-file-alt"></i> LJS',
					'uri' => "kbm/angket_ljs/id/{$row['ljs_id']}/{$row['menilai_user_id']}",
					'attr' => 'title="lihat lembar hasil pengerjaan"',
					'class' => 'disabled',
			),
	);

	if ($row['#available'] && ($row['angket_terkoreksi'] OR !$row['ljs_id'])):
		$pills_kanan['jawab']['class'] = 'active';
	endif;

	if ($row['ljs_id']):
		$pills_kanan['ljs']['class'] = 'active';
	endif;

else:

	// pilss khusus tutor dan admin

	$pills_kanan = array(
			'edit' => array(
					'label' => '<i class="icon-edit"></i> Edit',
					'uri' => "kbm/angket/form?id={$row['id']}",
					'attr' => 'title="ubah data siswa ini"',
					'class' => 'disabled',
			),
			'simulasi' => array(
					'label' => '<i class="icon-pencil"></i> Simulasi',
					'uri' => "kbm/angket_ljs/form?id={$row['id']}",
					'attr' => 'title="simulasi pengerjaan angket ini"',
					'class' => 'disabled',
			),
			'publish' => array(
					'label' => '<i class="icon-magic"></i> Publikasikan',
					'uri' => "kbm/angket/publish?id={$row['id']}",
					'attr' => 'title="publikasikan soal angket ini ke semua siswa/peserta"',
					'class' => 'disabled',
			),
			'tutup' => array(
					'label' => '<i class="icon-ban-circle"></i> Tutup',
					'uri' => "kbm/angket/tutup?id={$row['id']}",
					'attr' => 'title="tutup angket ini"',
					'class' => 'disabled',
			),
			'delete' => array(
					'label' => '<i class="icon-trash"></i> Hapus',
					'uri' => "kbm/angket/delete?id={$row['id']}",
					'attr' => 'title="hapus angket ini"',
					'class' => 'disabled',
			),
				/*
				  'download' => array(
				  'label' => '<i class="icon-download"></i> Download',
				  'uri' => "kbm/angket/download/{$row['id']}",
				  'attr' => 'title="download laporan lengkap angket ini"',
				  'class' => 'disabled',
				  ),
				 *
				 */
	);
	$pills_link = array(
			'soal' => array(
					'label' => '<i class="icon-list-ol"></i> Butir Soal',
					'uri' => "kbm/angket_soal/browse?angket_id={$row['id']}",
					'attr' => 'title="lihat semua butir soal angket ini"',
					'class' => 'disabled',
			),
			'nilai' => array(
					'label' => '<i class="icon-certificate"></i> Daftar Nilai',
					'uri' => "kbm/angket_nilai/browse?angket_id={$row['id']}",
					'attr' => 'title="lihat semua nilai hasil angket ini"',
					'class' => 'disabled',
			),
			'ljs' => array(
					'label' => '<i class="icon-file-alt"></i> Daftar LJS',
					'uri' => "kbm/angket_ljs/browse?angket_id={$row['id']}",
					'attr' => 'title="lihat semua lembar jawab hasil angket ini"',
					'class' => 'disabled',
			),
			'statistik' => array(
					'label' => '<i class="icon-bar-chart"></i> Statistik',
					'uri' => "kbm/angket_nilai/statistik?angket_id={$row['id']}",
					'attr' => 'title="statistik grafik hasil angket ini"',
					'class' => 'disabled',
			),
	);

	if ($editable)
		$pills_kanan['edit']['class'] = 'active';

	if ($row['soal_total'] > 0):
		$pills_kanan['simulasi']['class'] = 'active';
		$pills_link['soal']['class'] = '';
	endif;

	if ($row['soal_total'] > 0 && !$row['published'])
		$pills_kanan['publish']['class'] = 'active';

	if ($row['siswa_menjawab'] > 0 && $row['published'] && !$row['closed'])
		$pills_kanan['tutup']['class'] = 'active';

	if (in_array($row['status'], array('draft', 'closed')) && !$row['nilai_kolom_id'])
		$pills_kanan['delete']['class'] = 'active';

	if ($row['published']):
		$pills_link['nilai']['class'] = '';
		$pills_link['statistik']['class'] = '';
	endif;

	if ($row['siswa_menjawab'] > 0)
		$pills_link['ljs']['class'] = '';

	if (($user['role'] == 'admin')||($user['role'] == 'sdm'))
	{
		$pills_kanan['reuse'] = array(
			'label'	 => '<i class="icon-refresh"></i> Reuse',
			'uri'	 => "kbm/angket/reuse/{$row['id']}",
			'attr'	 => 'title="gunakan angket ini untuk pelajaran lain"',
			'class'	 => 'active',
		);
	}
	
endif;

// pills wali belum terpikir krn blm ada implementasi login
//
//
// informasi angket

$detail['umum'] = array(
		'Pelajaran' => array(
				'mapel_nama', 'ucwords',
				'suffix' => array(
						'<div class="subinfo">',
						'pelajaran_nama',
						' oleh ',
						'author_nama',
						'.&nbsp; ',
						'semester_nama',
						' ',
						'ta_nama',
						'</div>',
				),
		),
		'Jenis Penilaian' => array('jenis_penilaian', 'display_jenis_penilaian'),
		'Urutan Angket ke -' => array('urutan', 'formnil_angka'),
		'Bentuk' => array('pilihan_jml', array('error', 'error', 'Pilihan Ganda - 2 opsi', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
		
		/*
		'Tipe' => array(FALSE, 'display_tipe'),
		'Bentuk' => array('pilihan_jml', array('Uraian', 'error', 'error', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
		'KKM' => 'kkm',
		*/
);
if($row['jenis_penilaian']!='penilaian_diri')
{
	$detail['umum']['Jumlah Menilai Siswa'] = array('jml_menilai_siswa', 'display_jumlah_siswa');
	$detail['umum']['Jarak Acak'] = array('jarak_absen', 'formnil_angka');
}

if ($user['role'] == 'siswa'):
	$detail['tambahan'] = array(
			'Jumlah Soal' => array(FALSE, 'display_soal_siswa'),
			'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
	);

else:
	$detail['tambahan'] = array(
			'Batas Soal Tampil' => array('soal_jml', 'display_soal_jml', $row['soal_total']),
			'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
			'Acak Soal' => array('soal_acak', array('tidak', 'ya')),
	);

endif;

// table

$table = array(
		'table_properties' => array(
				'id' => 'tabel-jadwal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<i>kosong</i>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'Mulai' => array('angket_mulai', 'tglwaktu'),
				'Selesai' => array('angket_ditutup', 'tglwaktu'),
		),
);

if ($user['role'] != 'siswa' && $row['published']):
	$table['data']['<div align="right">Pengerjaan</div>'] = array(
			'siswa_menjawab',
			'prefix' => '<div align="right">',
			'suffix' => array(
					' / ',
					'siswa_total',
					'</div>',
			),
	);
	$table['data']['<div align="right">Rata-Rata Nilai</div>'] = array(
			'rata2_nilai',
			'prefix' => '<div align="right">',
			'suffix' => '</div>',
	);
endif;

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"');

if ($user['role'] != 'siswa')
	$bar_pills .= pills($pills_link, 'class="nav nav-pills pull-right"');

$bar_pills .= '</td></tr></table></div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Angket #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Angket (<?php echo ($row['tipe']); ?>):<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em;
						color: black;
					}
					.subinfo{
						font-size: .8em;
						opacity: .7;
						line-height: .9em;
					}
					#detail-tambahan{
						display: none;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pills;

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi Umum</legend>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';
				//echo '<legend>Keterangan Tambahan</legend>';

				foreach ($detail['tambahan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// jadwal pelaksanaan

				echo '<br/><br/><div class="form-horizontal"><fieldset>';
				echo '<legend>Jadwal Pelaksanaan</legend>';
				echo ds_table($table, $row['kelas_result']);
				echo '</fieldset></div><br/>';

				// info tambahan
				/*
				 * bila siswa => nilai ybs
				 * else:
				 * bila belum publish => daftar soal
				 * setelahnya muncul daftar nilai
				 */

				if ($user['role'] == 'siswa'):
					$this->load->view(THEME . "/{$uri}/siswa", $this->d);

				elseif (!$row['published']):
					$this->load->view(THEME . "/{$uri}/soal", $this->d);

				else:
					$this->load->view(THEME . "/{$uri}/nilai", $this->d);

				endif;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

		<script type="text/javascript">
			$(function() {
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
			});
		</script>

	</body>
</html>