
<?php
// vars

$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";
$editable = (($author_ybs OR $admin) && !$evaluasi['closed'] && $evaluasi['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$evaluasi['published']);

// function
//function display_pertanyaan($row, $editable, $deletable, $analized) {
function display_pertanyaan($row, $editable, $deletable, $evaluasi) {
	soal_prepare($row);
	
	$analized = $evaluasi['analisa_waktu'];

	// pills

	$param = "id={$row['id']}";
	$html = div('class="soal"');
	$html .= div('class="pull-right soal-pills"');
	
	//LEMPAR BANK SOAL
	if($row['bank_soal_id']>0){
		
	}else{
		///// K13 
		if($evaluasi['kurikulum_id']==4)
		{	$evaluasi['kurikulum_id']=2;	}
	
		if(isset($row['pilihan']))
		{
			$html .= a("kbm/bank_soal/form?id={$row['id']}&evaluasi_id=1&kurikulum_id={$evaluasi['kurikulum_id']}&kategori_id={$evaluasi['kategori_id']}&mapel_id={$evaluasi['mapel_id']}",
			'Lempar Bank Soal', 'target="_blank" class="btn btn-small btn-primary"') . '&nbsp;';
		}
	}
	
	if ($deletable)
		$html .= a("kbm/evaluasi_soal/delete?{$param}", 'Delete', 'class="btn btn-small btn-warning"') . '&nbsp;';
	else
		$html .= "<span class=\"btn btn-small disabled\">Delete</span>" . '&nbsp;';

	if ($editable)
		$html .= a("kbm/evaluasi_soal/form?{$param}", 'Edit', 'class="btn btn-small btn-success"');
	else
		$html .= "<span class=\"btn btn-small disabled\">Edit</span>";

	$html .= '</div>';
	
	///  audio /////////////
	if($row['audio']!='')
	{
		if (strpos($row['audio'], 'http') !== false){
			$audio = $row['audio'];
		}else{
			$audio = base_url().$row['audio'];
		}			
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
							oga: "'.$audio.'"
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
	$row['pertanyaan'] 					= str_replace('<img src="../','<img src="'.base_url(),$row['pertanyaan']);
	if(isset($row['pilihan']))
	{
		$row['pilihan']['kunci']['label']	= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['kunci']['label']);
		$row['pilihan']['pengecoh']			= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['pengecoh']);
		
		$row['pilihan']['kunci']['label']	= str_replace('<img src="../','<img src="'.base_url(),$row['pilihan']['kunci']['label']);
		$row['pilihan']['pengecoh']			= str_replace('<img src="../','<img src="'.base_url(),$row['pilihan']['pengecoh']);
	}
	

	if($row['bank_soal_id']>0){
		$sumber = "Dari Bank Soal";
	}else{
		$sumber = "Tulis Sendiri";
	}
	// sumber
	$html .= "<div><b>Sumber:</b> {$sumber}</div>";
	
	$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	// skor poin
	$html .= "<div><b>Skor Poin:</b> {$row['poin_max']}</div>";
	$html .= "<div><b>Tingkat Kesukaran:</b> ".ucwords($row['kesukaran'])."</div>";


	// pilihan, bila ada

	if ($row['pilihan']):

		$html .= "<div><b>Kunci:</b>";
		$html .= ul(array($row['pilihan']['kunci']['label']));
		$html .= "</div>";

		$html .= "<div><b>Pengecoh:</b>";
		$html .= ul($row['pilihan']['pengecoh']);
		$html .= "</div>";

	endif;

	// hasil analisa butir sioal

	if ($analized):

		$html .= "<div><b>Analisa Jawaban:</b>";
		$html .= "<ul>";
		$html .= "<li>Tingkat Kesukaran : " . round($row['analisa_index_tk']) . " (" . soal_ana_tk($row['analisa_index_tk']) . ") </li>";
		$html .= "<li>Daya Beda : " . round($row['analisa_index_db']) . " (" . soal_ana_db($row['analisa_index_db']) . ") </li>";
		$html .= "<li>Status : " . soal_analisa($row['analisa_index_db']) . " </li>";
		$html .= "</ul>";
		$html .= "</div>";

	endif;

	$html .= "</div>";

	//$html .= '<pre>' . print_r($row, TRUE) . '</pre>';

	return $html;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal',
);

// pills link

$pills_kiri = array(
		'eval' => array(
				'label' => 'Detail Evaluasi',
				'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
				'attr' => 'title="Kembali ke detail evaluasi"',
		),
		'simulasi' => array(
				'label' => '<i class="icon-pencil"></i> Simulasi',
				'uri' => "kbm/evaluasi_ljs/form?id={$evaluasi['id']}",
				'attr' => 'title="simulasi pengerjaan evaluasi ini"',
				'class' => 'disabled',
		),
);
$pills_kanan = array(
		'publish' => array(
				'label' => '<i class="icon-magic"></i> PUBLIKASIKAN !',
				'uri' => "kbm/evaluasi/publish?id={$evaluasi['id']}",
				'attr' => 'title="publikasikan soal evaluasi ini ke semua siswa/peserta" class="btn btn-success"',
				'class' => 'disabled',
		),
		'tambah' => array(
				'label' => '<i class="icon-star"></i> Tambah',
				'uri' => "kbm/evaluasi_soal/form?evaluasi_id={$evaluasi['id']}",
				'attr' => 'title="tambah butir soal baru"',
				'class' => 'disabled',
		),
);

// aktivasi pills

if ($evaluasi['soal_total'] > 0)
	$pills_kiri['simulasi']['class'] = '';

if (($author_ybs OR $admin) && !$evaluasi['published'] && $evaluasi['semester_id'] == $semaktif['id']):
	$pills_kanan['publish']['class'] = 'active';
	$pills_kanan['tambah']['class'] = 'active';
endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-large',
		),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 4,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => $ruri,
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
				'id' => 'tabel-soal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Pertanyaan' => array(FALSE, 'display_pertanyaan', $editable, $deletable, $evaluasi),
		),
);

// bars

$bar_pills = pills($pills_kiri);

$bar_search = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. form_hidden('evaluasi_id', $request['evaluasi_id'])
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($ruri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal Evaluasi {$evaluasi['id']}")); ?>
	<!-- JS SCRIPT -->
	<?php echo cosmo_js(); ?>
    <link href="<?php echo base_url();?>assets/jPlayer/css/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/jPlayer/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jPlayer-2.9.2/dist/jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jPlayer-2.9.2/dist/add-on/jquery.jplayer.inspector.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer/js/jquery-ui.js"></script>
    
	<style>
		.jp-gui {
			position:relative;
			padding:20px;
			/*width:628px;*/
			width:670px;
		}
		.jp-gui.jp-no-volume {
			width:432px;
		}
		.jp-gui ul {
			margin:0;
			padding:0;
		}
		.jp-gui ul li {
			position:relative;
			float:left;
			list-style:none;
			margin:2px;
			padding:4px 0;
			cursor:pointer;
		}
		.jp-gui ul li a {
			margin:0 4px;
		}
		.jp-gui li.jp-repeat,
		.jp-gui li.jp-repeat-off {
			margin-left:344px;
		}
		.jp-gui li.jp-mute,
		.jp-gui li.jp-unmute {
			margin-left:20px;
		}
		.jp-gui li.jp-volume-max {
			margin-left:120px;
		}
		li.jp-pause,
		li.jp-repeat-off,
		li.jp-unmute,
		.jp-no-solution {
			display:none;
		}
		.jp-progress-slider {
			position:absolute;
			top:28px;
			left:100px;
			width:300px;
		}
		.jp-progress-slider .ui-slider-handle {
			cursor:pointer;
		}
		.jp-volume-slider {
			position:absolute;
			top:31px;
			left:508px;
			width:100px;
			height:.4em;
		}
		.jp-volume-slider .ui-slider-handle {
			height:.8em;
			width:.8em;
			cursor:pointer;
		}
		.jp-gui.jp-no-volume .jp-volume-slider {
			display:none;
		}
		.jp-current-time,
		.jp-duration {
			position:absolute;
			top:42px;
			font-size:0.8em;
			cursor:default;
		}
		.jp-current-time {
			left:100px;
		}
		.jp-duration {
			right:266px;
		}
		.jp-gui.jp-no-volume .jp-duration {
			right:70px;
		}
		.jp-clearboth {
			clear:both;
		}
	</style>
  
  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>
		
		<style>
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Butir Soal Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_pills;
				echo $bar_search;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		

	</body>
</html>