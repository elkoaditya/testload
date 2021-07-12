<?php
// vars
$file_link = APP_ADDRESS.$row['file'];

$file_link2 = str_replace("http://" ,"" ,$file_link);
$file_link2 = str_replace("https://" ,"" ,$file_link);

$file_link2 = str_replace("".$_SERVER['HTTP_HOST']."/".APP_SUBDOMAIN."/" ,"".$_SERVER['HTTP_HOST']."/m4n3riq/" ,$file_link2);
$file_view = "https://docs.google.com/viewer?url=" . $file_link2;

//echo "a".$file_path;
?>

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
//print_r($row);
$r = & $this->d['request'];
$r['evaluasi_id']	= $row['id'];
$jumlah_kd			= $row['jml_kd'];
$r['term'] = '';

$ruri_soal = "kbm/evaluasi_soal/browse?evaluasi_id={$row['id']}";
$editable = (($author_ybs OR $admin) && !$row['closed'] && $row['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$row['published']);

//$resultset = $this->m_kbm_evaluasi_soal->browse(0, 50);

//print_r($resultset);
// fungsi

function disoal_pertanyaan($row, $published, $pilihan_jml, $uri) {

	// buttons

	$param = "id={$row['id']}&redir={$uri}/{$row['evaluasi_id']}";
	$html = div('class="pull-right soal"');

	if (!$published)
		$html .= a("kbm/evaluasi_soal/delete?{$param}", 'Delete', 'class="btn btn-small btn-warning"') . '&nbsp;';

	$html .= a("kbm/evaluasi_soal/form_kunci?{$param}", 'Edit', 'class="btn btn-small btn-success"');
	$html .= '</div>';

	// gambar jika ada

	if ($row['gambar']):

		if (!is_array($row['gambar']))
			$row['gambar'] = (array) json_decode($html['gambar'], TRUE);

		$img['class'] = 'soal-img';
		$img['src'] = array_node($row, 'gambar', 'full_path');

		if (@file_exists($img['src']))
			$html .= div('align="center"', img($img));

	endif;
	
	// pertanyaan

	$html .= div('class="soal-pertanyaan"', base64_decode($row['pertanyaan']));

	// pilihan, bila ada

	if ($pilihan_jml > 1):

		if (!is_array($row['pilihan']))
			$row['pilihan'] = (array) json_decode($html['pilihan'], TRUE);

		$pilihan['<b>Kunci:</b>'] = (array) array_node($row, 'pilihan', 'kunci');
		$pilihan['<b>Pengecoh:</b>'] = (array) array_node($row, 'pilihan', 'pengecoh');

		foreach (array_keys($pilihan['<b>Kunci:</b>']) as $i)
			$pilihan['<b>Kunci:</b>'][$i] = base64_decode($pilihan['<b>Kunci:</b>'][$i]);

		foreach (array_keys($pilihan['<b>Pengecoh:</b>']) as $i)
			$pilihan['<b>Pengecoh:</b>'][$i] = base64_decode($pilihan['<b>Pengecoh:</b>'][$i]);

		$html .= ul($pilihan);

	endif;

	return $html;
}

function display_nomor($nomor){
	if($nomor>0){
		$nomor = formnil_angka($nomor);
	}else{
		$nomor="-";
	}
	return div('style="text-align: center;"', $nomor);
}

function display_pertanyaan($row, $editable, $deletable, $uri, $evaluasi) { 
	soal_prepare($row);

	// pills

	$param = "id={$row['id']}&posisi_kd={$row['posisi_kd']}&redir={$uri}/{$row['evaluasi_id']}";
	$html = div('class="soal"');
	$html .= div('class="pull-right soal-pills"');

	
	$set_form = "form_kunci"; 
	
	if ($deletable)
		$html .= a("kbm/evaluasi_soal/delete?{$param}", 'Delete', 'class="btn btn-small btn-warning"') . '&nbsp;';
	else
		$html .= "<span class=\"btn btn-small disabled\">Delete</span>" . '&nbsp;';

	if ($editable)
		$html .= a("kbm/evaluasi_soal/{$set_form}?{$param}", 'Edit', 'class="btn btn-small btn-success"');
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
	$row['pertanyaan'] 					= str_replace('<img src="../../','<img src="'.base_url(),$row['pertanyaan']);
	if ($row['pilihan']){
		$row['pilihan']['kunci']['label']	= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['kunci']['label']);
		$row['pilihan']['pengecoh']			= str_replace('<img src="/','<img src="'.base_url(),$row['pilihan']['pengecoh']);
		
		$row['pilihan']['kunci']['label']	= str_replace('<img src="../../','<img src="'.base_url(),$row['pilihan']['kunci']['label']);
		$row['pilihan']['pengecoh']			= str_replace('<img src="../../','<img src="'.base_url(),$row['pilihan']['pengecoh']);
		
		
		$row['opsi'] = $row['pilihan']['pengecoh'];
		$row['opsi'][$row['pilihan']['kunci']['index']] =  $row['pilihan']['kunci']['label']; 
		ksort($row['opsi']);
	}
	
	
	if($row['bank_soal_id']>0){
		$sumber = "Dari Bank Soal";
	}else{
		$sumber = "Tulis Sendiri";
	}
	// sumber 
	//$html .= "<div><b>Sumber:</b> {$sumber}</div>";
	
	// pertanyaan
	//$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	// skor poin
	$html .= "<div><b>Skor Poin:</b> {$row['poin_max']}</div>";
	$html .= "<div><b>Tingkat Kesukaran:</b> ".ucwords($row['kesukaran'])."</div>";//.print_r($evaluasi);
	
	// $html .= $evaluasi['tipe'];;
	// pilihan, bila ada
	 
	if ($row['pilihan']):

		$html .= "<div><b>Kunci:</b> ";
		
			$set_form = "form_abc";
	// $html .= $evaluasi['tipe'];
		// }
			// $html .= print_r($row['pilihan']['kunci']));
			$html .= "<b>".strtoupper($row['pilihan']['kunci']['index'])."</b>";
			$html .= "</div>";

			/*
			$html .= "<div><b>Opsi:</b>";
				foreach ($row['opsi'] as $keys => $values):
					$color_font='black';
					if(strtoupper($row['pilihan']['kunci']['index'])== strtoupper($keys)){
						$color_font='red';
					}
					$values = str_replace("<p>","<p>".strtoupper($keys).". ",$values);
					//$values = str_replace("<div>","<div>".strtoupper($keys).". ",$values);
					//$values = strtoupper($keys).". ".$values;
					$html .=  "<font color='".$color_font."'>".$values."</font>";
				endforeach;
			$html .= "</div>";*/
			
		

	endif;

	$html .= "</div>";

	return $html;
}

// komponen

$this->load->helper('soal');

// pills link
$set_form_soal 	= "form_upload_dokumen"; 
$set_form_kunci = "form_kunci"; 


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



// tabel data

$table = array(
		'table_properties' => array(
				'id' => 'tabel-soal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Nomor'		 => array('nomor', 'display_nomor'),
				'Pertanyaan' => array(FALSE, 'display_pertanyaan', $editable, $deletable, $uri, $row),
		),
);

// bar form soal

$bar_cari_soal = '<div>'
			. form_opening('kbm/evaluasi_soal/browse', 'method="get" class="form-search well"')
			//. pills($pills, 'class="nav nav-pills pull-right"')
			. form_hidden('evaluasi_id', $row['id'])
			. form_cell($input['term'], $r) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. form_close()
			. '</div>';

// output
//print_r($row);
// Dokumen Soal
echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Dokumen Soal</legend>';
	$pills_tambah_soal[] = array(
			'label' => '<i class="icon-pencil"></i>EDIT DOKUMEN SOAL',
			'uri' => "kbm/evaluasi/".$set_form_soal."?id={$row['id']}",
			'attr' => 'title="tambah butir soal baru" ',
			'class' => 'active',
	);
$bar_tambah_soal = '<div>'
			. form_opening('', ' class="form-search well"')
			. pills($pills_tambah_soal, 'class="nav nav-pills pull-right"')
			. form_close()
			. '</div>';
echo $bar_tambah_soal;

//if ($file_ofis):
	//echo "<div id='tabel'>
		//	<iframe  id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>
		//</div>";
//endif;	
echo '<div id="test-id-1" style="text-align: center; width: 100%; height: 600px" class="embed-pdf" data-url="'.$file_link2.'"><span class="loader">Mohon Maaf: Loading Soal...</span></div>';


echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Daftar Kunci</legend>';


$tampil_kd=1;
while($tampil_kd<=$jumlah_kd){
	$r['posisi_kd'] = $tampil_kd;
	$resultset[$tampil_kd] = $this->m_kbm_evaluasi_soal->browse(0, 100);
	$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($row['id'], $tampil_kd);
	
	//print_r($resultset[$tampil_kd]);
	/// keterangan tambahan
	$detail['tambahan'] = array(
		'Nama KD'	 		 => array('nama', 'display_nama_kd'),
		'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $resultset[$tampil_kd]['total_rows']),
	);
	/*echo "AAAAAAAAAAAAAAA";
	print_r($row_pembagian_kd);
	echo "BBBBBBBBBBBBBBB";*/
	// pagination

	if ($resultset[$tampil_kd]['overload'] == TRUE)
		$stat = "{$resultset[$tampil_kd]['start']} sampai {$resultset[$tampil_kd]['end']}. Total lebih dari {$resultset[$tampil_kd]['total_rows']} baris.";
	else
		$stat = "{$resultset[$tampil_kd]['start']} sampai {$resultset[$tampil_kd]['end']} dari {$resultset[$tampil_kd]['total_rows']} baris.";

		$pagination = array(
				'uri_segment' => 4,
				'num_links' => 5,
				'next_link' => '→',
				'prev_link' => '←',
				'first_link' => '&compfn;',
				'last_link' => '&compfn;',
				'base_url' => $ruri_soal,
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
	$this->md->paging($resultset[$tampil_kd], $pagination);

	///tambah
	// pills link
	$pills_tambah[$tampil_kd][] = array(
			'label' => '<i class="icon-pencil"></i>TAMBAH KUNCI BAGIAN KE - '.$tampil_kd,
			'uri' => "kbm/evaluasi_soal/".$set_form_kunci."?evaluasi_id={$row['id']}&posisi_kd={$tampil_kd}&redir={$uri}/{$row['id']}",
			'attr' => 'title="tambah butir soal baru" ',
			'class' => 'active',
	);

	// opsi tambahan

				
	$bar_tambah_soal = '<div>'
			. form_opening('', ' class="form-search well"')
			. pills($pills_tambah[$tampil_kd], 'class="nav nav-pills pull-right"')
			//. form_hidden('evaluasi_id', $row['id'])
			//. form_cell($input['term'], $r) . '&nbsp;'
			//. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. form_close()
			. '</div>';
			
	// view
	echo '<legend>Soal Bagian ke - '.$tampil_kd.'</legend>';
	echo $bar_tambah_soal;
	//echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
	echo '<div id="detail-tambahan-'.$tampil_kd.'" class="form-horizontal"><fieldset>';
	echo '<legend>Keterangan Tambahan</legend>';

	foreach ($detail['tambahan'] as $label => $cdat):
		echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
		. data_cell($cdat, $row_pembagian_kd) . "</div></div>";
	endforeach;
	echo "<div class=\"control-group\"><div class=\"controls\">"
		.a("kbm/evaluasi_pembagian_kd/form?evaluasi_id={$row['id']}&posisi_kd={$tampil_kd}",
			'Edit', 'class="btn btn-small btn-warning"') . '&nbsp;';
	echo '</fieldset></div><br/>';
	
	echo ds_table($table, $resultset[$tampil_kd]);
	$tampil_kd++;
}

echo '</fieldset></div><br/>';

?>

<script>
$(document).ready(function() {

    let embed_pdfs = {};

    $('.embed-pdf').each(function() {
        var $pdfViewer = $('<iframe src="https://docs.google.com/viewer?url=' + $(this).data('url') + '&embedded=true" style="width: 100%; height: 100%" frameborder="0" scrolling="no"></iframe>');
        $pdfViewer.appendTo($(this));
        console.log($(this).attr('id') + " created");
        embed_pdfs[$(this).attr('id')] = 'created';
    });

    $(document).find('.embed-pdf iframe').load(function(){
        embed_pdfs[$(this).parents('.embed-pdf').attr('id')] = 'loaded';
        $(this).siblings('.loader').remove();
        console.log($(this).parents('.embed-pdf').attr('id') + " loaded");
    });

    let embed_pdf_check = setInterval(function() {
        let remaining_embeds = 0;
        $.each(embed_pdfs, function(key, value) {
            try {
                if ($($('#' + key)).find('iframe').contents().find("body").contents().length == 0) {
                    remaining_embeds++;
                    console.log(key + " resetting");
                    $($('#' + key)).find('iframe').attr('src', src='https://docs.google.com/viewer?url=' + $('#' + key).data('url') + '&embedded=true');
                }
            }
            catch(err) {
                console.log(key + " reloading");
            }
        });
    
        if (!remaining_embeds) {
            clearInterval(embed_pdf_check);
        }
    }, 2000);
});
</script>
