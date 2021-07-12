
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
<?php
//vars

$r = & $this->d['request'];
$r['evaluasi_id'] = $row['id'];
$r['term'] = '';

$ruri_soal = "kbm/evaluasi_soal/browse?evaluasi_id={$row['id']}";
$editable = (($author_ybs OR $admin) && !$row['closed'] && $row['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$row['published']);
$resultset = $this->m_kbm_evaluasi_soal->browse(0, 200);

// fungsi


function display_pertanyaan($row, $editable, $deletable, $uri) {
	soal_prepare($row);

	// pills

	$param = "id={$row['id']}&redir={$uri}/{$row['evaluasi_id']}";
	$html = div('class="soal"');
	$html .= div('class="pull-right soal-pills"');

	if ($deletable)
		$html .= a("kbm/evaluasi_soal/delete?{$param}", 
		'<i class="zmdi zmdi-delete"></i> Delete', 'class="btn btn-danger btn-sm m-b-5 m-r-5"') . '&nbsp;';
	else
		$html .= "<span class=\"btn btn-danger btn-sm m-b-5 m-r-5 disabled\"><i class='zmdi zmdi-delete'></i> Delete</span>" . '&nbsp;';

	if ($editable)
		$html .= a("kbm/evaluasi_soal/form?{$param}", '<i class="zmdi zmdi-edit"></i> Edit', 'class="btn btn-warning btn-sm m-b-5 m-r-5"');
	else
		$html .= "<span class=\"btn btn-warning btn-sm m-b-5 m-r-5 disabled\"><i class='zmdi zmdi-edit'></i> Edit</span>";

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
	
	// pertanyaan
	$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	// skor poin

	$html .= "<div><b>Skor Poin:</b> {$row['poin_max']}</div>";
	
	// pilihan, bila ada

	if ($row['pilihan']):

		$html .= "<div><b>Kunci:</b>";
		$html .= ul(array($row['pilihan']['kunci']['label']));
		$html .= "</div>";

		$html .= "<div><b>Pengecoh:</b>";
		$html .= ul($row['pilihan']['pengecoh']);
		$html .= "</div>";

	endif;

	$html .= "</div>";

	return $html;
}

// komponen

$this->load->helper('soal');

// pills link

$pills[] = array(
		'label' => '<i class="icon-star"></i>Tambah',
		'uri' => "kbm/evaluasi_soal/form?evaluasi_id={$row['id']}&redir={$uri}/{$row['id']}",
		'attr' => 'title="tambah butir soal baru" ',
		'class' => 'active',
);


// bar form soal

function table_soal(&$no, $data, $request, $user, $editable, $deletable, $uri)
{
	//$data = $row['kelas_result']['data'];
	//print_r($row['kelas_result']);
	$header_table = "
				<tr>
                    <th>No</th>
					<th>Soal</th>";
						
	$header_table .= "</tr>";
	
    ?>
    <div class="card" id="table">
        
        <br>
        <div class="table-responsive">
            <table id="data-table-basic-soal" class="table table-striped">
                <thead>
                 <?php echo $header_table;?>
                </thead>
                <tfoot>
                  <?php echo $header_table;?>
                </tfoot>
                <tbody>
                    <?php
					
					foreach($data as $view)
					{
						$no++;
						echo"<tr>
							<td>".$no."</td>
						 	<td>".display_pertanyaan($view, $editable, $deletable, $uri)."</td>";
						echo"</tr>";
					}
					?>
                </tbody>
             </table>
           </div>
         </div>
    <?php
}
	


// output
//echo '<div class="form-horizontal"><fieldset>';
//echo '<legend>Daftar Soal / Pertanyaan</legend>';
//echo $bar_cari_soal;
//echo ds_table($table, $resultset);
$no=0;
echo table_soal($no, $resultset['data'], $request, $user, $editable, $deletable, $uri);

//echo '</fieldset></div><br/>';
?>

<script type="text/javascript">
   
$(document).ready(function() {
	$('#data-table-basic-soal').DataTable();
} );

$('#data-table-basic-soal').dataTable( {
  "pageLength": 50
} );

setTimeout(function(){nowAnimation('soal','fadeInUp')},400);
</script>