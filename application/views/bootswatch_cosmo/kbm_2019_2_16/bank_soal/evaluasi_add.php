<?php

// function
//print_r($resultset);
function display_select($row){
	$input['checkbox'] = array(
		'input_soal' => array(
				'name' => 'input_soal[]',
				'id' => 'input_soal[]',
				'value' => $row['id'],
				'style' => 'margin: 10px 10px 14px 0;',
		),
	);
	
	$html = form_checkbox($input['checkbox']['input_soal']);
	
	return  $html;
}

function display_nama($row)
{
	soal_prepare($row);
	
	
	$html = div('class="soal"');
	$html .= div('class="pull-right soal-pills"');
	
	$html .= '</div>';
	
	///  audio /////////////
	if($row['audio']!='')
	{
		///////////////// AUDIO ///////////////////////
		$html .= "<div><b> Player Sound (LISTENING SECTION)</b>";
		//// FOR PC ////
		$html .= '
		<script type="text/javascript">
		$(document).ready(function(){
		
			var myPlayer = $("#jquery_jplayer_'.$row['id'].'"),
				myPlayerData,
				fixFlash_mp4, // Flag: The m4a and m4v Flash player gives some old currentTime values when changed.
				fixFlash_mp4_id, // Timeout ID used with fixFlash_mp4
				ignore_timeupdate, // Flag used with fixFlash_mp4
				options = {
					ready: function (event) {
						// Hide the volume slider on mobile browsers. ie., They have no effect.
						if(event.jPlayer.status.noVolume) {
							// Add a class and then CSS rules deal with it.
							$(".jp-gui").addClass("jp-no-volume");
						}
						// Determine if Flash is being used and the mp4 media type is supplied. BTW, Supplying both mp3 and mp4 is pointless.
						fixFlash_mp4 = event.jPlayer.flash.used && /m4a|m4v/.test(event.jPlayer.options.supplied);
						// Setup the player with media.
						$(this).jPlayer("setMedia", {
							oga: "'.base_url().$row['audio'].'"
						});
					},
					play: function() { // To avoid multiple jPlayers playing together.
						$(this).jPlayer("pauseOthers");
						//$(this).jPlayer("stopOthers");
					},
					timeupdate: function(event) {
						if(!ignore_timeupdate) {
							myControl.progress.slider("value", event.jPlayer.status.currentPercentAbsolute);
						}
					},
					volumechange: function(event) {
						if(event.jPlayer.options.muted) {
							myControl.volume.slider("value", 0);
						} else {
							myControl.volume.slider("value", event.jPlayer.options.volume);
						}
					},
					swfPath: "js/jPlayer-2.9.2/dist/jplayer",
					supplied: "oga",
					cssSelectorAncestor: "#jp_container_'.$row['id'].'",
					wmode: "window",
					keyEnabled: true
				},
				myControl = {
					progress: $(options.cssSelectorAncestor + " .jp-progress-slider"),
					volume: $(options.cssSelectorAncestor + " .jp-volume-slider")
				};
		
			// Instance jPlayer
			myPlayer.jPlayer(options);
		
			// A pointer to the jPlayer data object
			myPlayerData = myPlayer.data("jPlayer");
		
			// Define hover states of the buttons
			$(".jp-gui ul li").hover(
				function() { $(this).addClass("ui-state-hover"); },
				function() { $(this).removeClass("ui-state-hover"); }
			);
		
			// Create the progress slider control
			myControl.progress.slider({
				animate: "fast",
				max: 100,
				range: "min",
				step: 0.1,
				value : 0,
				slide: function(event, ui) {
					var sp = myPlayerData.status.seekPercent;
					if(sp > 0) {
						// Apply a fix to mp4 formats when the Flash is used.
						if(fixFlash_mp4) {
							ignore_timeupdate = true;
							clearTimeout(fixFlash_mp4_id);
							fixFlash_mp4_id = setTimeout(function() {
								ignore_timeupdate = false;
							},1000);
						}
						// Move the play-head to the value and factor in the seek percent.
						myPlayer.jPlayer("playHead", ui.value * (100 / sp));
					} else {
						// Create a timeout to reset this slider to zero.
						setTimeout(function() {
							myControl.progress.slider("value", 0);
						}, 0);
					}
				}
			});
		
			// Create the volume slider control
			myControl.volume.slider({
				animate: "fast",
				max: 1,
				range: "min",
				step: 0.01,
				value : $.jPlayer.prototype.options.volume,
				slide: function(event, ui) {
					myPlayer.jPlayer("option", "muted", false);
					myPlayer.jPlayer("option", "volume", ui.value);
				}
			});
		
		
			$("#jplayer_inspector_'.$row['id'].'").jPlayerInspector({jPlayer:$("#jquery_jplayer_'.$row['id'].'")});
		});
		</script>
		
		<div id="container1">
              <div id="content_main1">
                <div id="jquery_jplayer_'.$row['id'].'" class="jp-jplayer"></div>
            
                    <div id="jp_container_'.$row['id'].'">
                        <div class="jp-gui ui-widget ui-widget-content ui-corner-all">
                            <ul>
                                <li class="jp-play ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-play ui-icon ui-icon-play" tabindex="'.$row['id'].'" title="play">play</a></li>
                                <li class="jp-pause ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-pause ui-icon ui-icon-pause" tabindex="'.$row['id'].'" title="pause">pause</a></li>
                                <li class="jp-stop ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-stop ui-icon ui-icon-stop" tabindex="'.$row['id'].'" title="stop">stop</a></li>
                                <li class="jp-repeat ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-repeat ui-icon ui-icon-refresh" tabindex="'.$row['id'].'" title="repeat">repeat</a></li>
                                <li class="jp-repeat-off ui-state-default ui-state-active ui-corner-all">
                                <a href="javascript:;" class="jp-repeat-off ui-icon ui-icon-refresh" tabindex="'.$row['id'].'" title="repeat off">repeat off</a></li>
                                <li class="jp-mute ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-mute ui-icon ui-icon-volume-off" tabindex="'.$row['id'].'" title="mute">mute</a></li>
                                <li class="jp-unmute ui-state-default ui-state-active ui-corner-all">
                                <a href="javascript:;" class="jp-unmute ui-icon ui-icon-volume-off" tabindex="'.$row['id'].'" title="unmute">unmute</a></li>
                                <li class="jp-volume-max ui-state-default ui-corner-all">
                                <a href="javascript:;" class="jp-volume-max ui-icon ui-icon-volume-on" tabindex="'.$row['id'].'" title="max volume">max volume</a></li>
                            </ul>
                            <div class="jp-progress-slider"></div>
                            <div class="jp-volume-slider"></div>
                            <div class="jp-current-time"></div>
                            <div class="jp-duration"></div>
                            <div class="jp-clearboth"></div>
                        </div>
                        
                    </div>
              </div>
            </div>
		';
		
		$html .="</div><br><br>";	
	}
	
	// FIX URL GAMBAR
	$row['pertanyaan'] 					= str_replace('<img src="/','<img src="'.base_url(),$row['pertanyaan']);
	$row['pilihan']['kunci']['label']	= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['kunci']['label']);
	$row['pilihan']['pengecoh']			= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['pengecoh']);
	
	$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	// skor poin

	$html .= "<div><b>Tingkat Kesukaran:</b> ".ucwords($row['kesukaran'])."</div>";
	$html .= "<div><b>Jumlah Pemakaian:</b> {$row['jml_pakai']}</div>";
	
	// pilihan, bila ada

	if ($row['pilihan']):

		$html .= "<div><b>Kunci:</b>";
		$html .= ul(array($row['pilihan']['kunci']['label']));
		$html .= "</div>";

		$html .= "<div><b>Pengecoh:</b>";
		$html .= ul($row['pilihan']['pengecoh']);
		$html .= "</div>";

	endif;
	
	return  $html;

}


function display_bentuk($pilihan_jml)
{
	return ($pilihan_jml > 1) ? 'pilihan' : 'uraian';

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}#baru",
);

// pills link

$pills = array();

//if ($mengajar_list):
	$pills[] = array(
		'label'	 => '<i class="icon-save icon-white"></i>Tambahkan ke Evaluasi',
		'uri'	 => "kbm/bank_soal/form",
		'attr'	 => 'title="tambah bank soal baru"',
		'class'	 => 'active'
	);
	
	
//endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
				'placeholder' => 'pencarian',
				'title' => 'pencarian',
		),
		/*'kurikulum_id' => array(
				'kurikulum_id',
				'type' => 'dropdown',
				'name' => 'kurikulum_id',
				'id' => 'kurikulum_id',
				'extra' => 'id="kurikulum_id" class="input input-medium select"',
				'options' => $this->m_option->kurikulum('kurikulum'),
		),
		'kategori_id' => array(
				'kategori_id',
				'type' => 'dropdown',
				'name' => 'kategori_id',
				'id' => 'kategori_id',
				'extra' => 'id="kategori_id" class="input input-medium select"',
				'options' => $this->m_option->kategori_mapel('kategori'),
		),
		'mapel_id' => array(
				'mapel_id',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'extra' => 'id="mapel_id" class="input input-medium select"',
				'options' => $this->m_option->mapel('mapel'),
		),*/
		'grade' => array(
				'grade',
				'type' => 'dropdown',
				'name' => 'grade',
				'id' => 'grade',
				'extra' => 'id="grade" class="input input-medium select"',
				'options' => $this->m_option->grade('grade'),
		),
		
);



//if ($user['role'] == 'admin'):
	//$input['author_id']['options'] = $this->m_option->sdm('author');
	$input['mapel_id']['options'] = $this->m_option->mapel('mapel');

//else:
	//$input['mapel_id']['options'] = $this->m_option->mapel_user('mapel', 'evaluasi');

//endif;

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
	'base_url'			 => $this->d['uri'],
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
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		//'Tipe'							 => array('tipe', 'ucfirst'),
		'Select'				 => array(FALSE, 'display_select'),
		'Soal'					 => array(FALSE, 'display_nama'),
		//'Bentuk'						 => array('pilihan_jml', 'display_bentuk'),
		/*'<div align="right">KKM</div>'	 => array(
			'kkm',
			'formnil_angka',
			'prefix' => '<div align="right">',
			'suffix' => '</div>',
		),*/
	),
	'grouping'			 => array(
		'column' => array( 'komp_dasar_id','kompetensi_nama'),
	),
);

$table['grouping']['title'] = array(
		'<span class="title">',
		array('kategori_nama', 'strtoupper'), ' - ',
		array('mapel_nama', 'strtoupper'),
		' Kur. ',
		array('kurikulum_nama', 'strtoupper'),
		'&nbsp; ',
		'[ Kls ', array('grade_nama', 'strtoupper'), '] ', 
		'</span> <br/> ',
		'<span class="desc">',
		array('kd_kode', 'ucwords'), ' - ', 'kd_nama', '.',
		'</span>',
	);

// bars
$bar = '<div>'
			
			//. pills($pills, 'class="nav nav-pills pull-right"')
			.'<button type="submit" class="btn btn-success nav nav-pills pull-right" name="tambah" value="bank_soal">
							<i class="icon-save icon-white"></i> Tambah ke Evaluasi
						</button>'
			. form_cell($input['term'], $request) . '&nbsp;'
			//. form_cell($input['kurikulum_id'], $request) . '&nbsp;'
			//. form_cell($input['kategori_id'], $request) . '&nbsp;'
			//. form_cell($input['mapel_id'], $request) . '&nbsp;'
			. form_cell($input['grade'], $request) . '&nbsp;';

if ($admin):
	//$bar .= form_cell($input['author_id'], $request) . '&nbsp;';
endif;

$bar .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"')
	
	. '</div>';

?>

<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Bank Soal')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.record-group {
				margin: 16px 0 7px 0;
			}
			.record-group .title {
				font-size: 1.4em;
				color: black;
				vertical-align: baseline;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Form Soal Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke detail evaluasi"'); ?></h1>
					<h2><?=$evaluasi['kurikulum_nama']?> - <?=$evaluasi['kategori_nama']?> - <?=$evaluasi['mapel_nama']?> </h2>
				</div>
				
				<?php
				echo alert_get();
				echo form_opening($uri, 'method="post" class="form-search well"');
				
				echo $bar;
				echo ds_table($table, $resultset);
				
				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>