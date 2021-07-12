<?php
// vars
$file_link = APP_ADDRESS.$evaluasi['file'];

$file_link2 = str_replace("http://" ,"" ,$file_link);
$file_link2 = str_replace("https://" ,"" ,$file_link);

$file_link2 = str_replace("".$_SERVER['HTTP_HOST']."/".APP_SUBDOMAIN."/" ,"".$_SERVER['HTTP_HOST']."/m4n3riq/" ,$file_link2);
$file_view = "https://docs.google.com/viewer?url=" . $file_link2;

//echo "a".$file_path;

// vars

$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";
$editable = (($author_ybs OR $admin) && !$evaluasi['closed'] && $evaluasi['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$evaluasi['published']);

// function
function display_nomor($nomor){
	if($nomor>0){
		$nomor = formnil_angka($nomor);
	}else{
		$nomor="-";
	}
	return div('style="text-align: center;"', $nomor);
}

//function display_pertanyaan($row, $editable, $deletable, $analized) {
function display_pertanyaan($row, $editable, $deletable, $evaluasi) {
	soal_prepare($row);
	
	/*$set_form = "form"; 
	if(strtolower($evaluasi['metode']) == "opsi_tampil_abc"){ 
		$set_form = "form_abc"; 
	}*/
	$set_form = "form_abc"; 
	if(strtolower($evaluasi['metode']) == "upload_dokumen_soal"){ 
		$set_form = "form_kunci"; 
	}

	$analized = $evaluasi['analisa_waktu'];

	// pills
	$param_isian = '';
	if($row['type']==2){
		$param_isian = "&isian=1";
	}
	$param = "id={$row['id']}".$param_isian."&posisi_kd={$row['posisi_kd']}";	
	//$param = "id={$row['id']}";
	
	$style='';
	if($row['nilai_bonus']==1){
		$style = 'style="background-color:lightgreen"';
	}
	
	$html = div('class="soal"'.$style);
	$html .= div('class="pull-right soal-pills"');
	
	/*	if(strtolower($evaluasi['metode']) != "opsi_tampil_abc"){ 
		$html .= a("kbm/evaluasi_soal/ganti_kunci?{$param}", 'Ganti Kunci & Nilai Bonus', 'class="btn btn-small btn-warning"') . '&nbsp;';
	}else{
		
	}*/
	
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
		$html .= a("kbm/evaluasi_soal/".$set_form."?{$param}", 'Edit', 'class="btn btn-small btn-success"');
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
	
	$kunsian = 1;
	while($kunsian<=9){
		$row['kunci_isian'.$kunsian] 		= str_replace('<img src="/','<img src="'.base_url(),$row['kunci_isian'.$kunsian]);
		$row['kunci_isian'.$kunsian] 		= str_replace('<img src="../../','<img src="'.base_url(),$row['kunci_isian'.$kunsian]);
		$kunsian++;
	}
	
	if(isset($row['pilihan']))
	{
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
	$html .= "<div><b>Sumber:</b> {$sumber}</div>";
	
	$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	//Nilai Bonus
	$html .= "<div><b>Soal Bonus:</b> ";
	$html .= ($row['nilai_bonus']==1)?'YA':'TIDAK';
	$html .= "</div>";
	
	// skor poin
	$html .= "<div><b>Skor Poin:</b> {$row['poin_max']}</div>";
	$html .= "<div><b>Tingkat Kesukaran:</b> ".ucwords($row['kesukaran'])."</div>";

	// TYPE
	if($row['type']==3){
		//
	}elseif($row['type']==2){
		
		$html .= "<div><b>Toleransi Huruf Kapital:</b> ";
		$html .= ($row['toleran_huruf_kapital']==1)?'YA':'TIDAK';
		$html .= "</div>";
		
		$kunsian = 1;
		while($kunsian<=9){
			$html .= "<div><b>Alternatif Kunci Jawaban ke ".$kunsian.":</b> ";
			$html .= "&nbsp;".$row['kunci_isian'.$kunsian]."<br></div>";
			$kunsian++;
		}
		
	}else{
		
		// pilihan, bila ada

		if ($row['pilihan']):
			
			$html .= "<div><b>Kunci:</b>";
			//if(strtolower($evaluasi['metode']) == "opsi_tampil_abc"){ 
				
				$html .= "<b>".strtoupper($row['pilihan']['kunci']['index'])."</b>";
				$html .= "</div>";

				$html .= "<div><b>Opsi:</b>";
					foreach ($row['opsi'] as $keys => $values):
						$color_font='black';
						if(strtoupper($row['pilihan']['kunci']['index'])== strtoupper($keys)){
							$color_font='red';
						}
						$values = str_replace("<p>","<p>".strtoupper($keys).". ",$values);
						$html .=  "<font color='".$color_font."'>".$values."</font>";
					endforeach;
				$html .= "</div>";
			/*}else{
				
				$html .= ul(array($row['pilihan']['kunci']['label']));
				$html .= "</div>";

				$html .= "<div><b>Pengecoh:</b>";
				$html .= ul($row['pilihan']['pengecoh']);
				$html .= "</div>";
			}*/

		endif;
	}

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
		'download_kunci' => array(
				'label'	 => '<i class="icon-download"></i>DOWNLOAD KUNCI',
				'uri'	 => "kbm/evaluasi_soal/download_kunci?evaluasi_id={$evaluasi['id']}",
				'attr'	 => 'title="download Excel kunci jawaban evaluasi" ',
		),
		/*'tambah' => array(
				'label' => '<i class="icon-star"></i> Tambah',
				'uri' => "kbm/evaluasi_soal/form?evaluasi_id={$evaluasi['id']}",
				'attr' => 'title="tambah butir soal baru"',
				'class' => 'disabled',
		),*/
);

// aktivasi pills

if ($evaluasi['soal_total'] > 0)
	$pills_kiri['simulasi']['class'] = '';

if (($author_ybs OR $admin) && !$evaluasi['published'] && $evaluasi['semester_id'] == $semaktif['id']):
	$pills_kanan['publish']['class'] = 'active';
	//$pills_kanan['tambah']['class'] = 'active';
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
				'Nomor'		 => array('nomor', 'display_nomor'),
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
				
				
				$jumlah_kd	= $evaluasi['jml_kd'];
				$tampil_kd	=1;
				$r = & $this->d['request'];
				while($tampil_kd<=$jumlah_kd){
					$r['posisi_kd'] = $tampil_kd;
					$resultset[$tampil_kd] = $this->m_kbm_evaluasi_soal->browse(0, 100);
					$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($evaluasi['id'], $tampil_kd);
					
					$detail['tambahan'] = array(
						'Nama KD'	 		 => array('nama', 'display_nama_kd'),
						'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $resultset[$tampil_kd]['total_rows']),
					);
					
					/*$set_form = "form"; 
					if(strtolower($evaluasi['metode']) == "opsi_tampil_abc"){ 
						$set_form = "form_abc"; 
					}*/
					$set_form = "form_abc";
					if(strtolower($evaluasi['metode']) == "upload_dokumen_soal"){ 
						$set_form = "form_kunci"; 
					}
					$pills_tambah[$tampil_kd]['tambah'] = array(
							'label' => '<i class="icon-pencil"></i>TAMBAH TULIS SOAL BAGIAN KE - '.$tampil_kd,
							'uri' => "kbm/evaluasi_soal/".$set_form."?evaluasi_id={$evaluasi['id']}&posisi_kd={$tampil_kd}&redir={$uri}/{$evaluasi['id']}",
							'attr' => 'title="tambah butir soal baru" ',
							'class' => 'disabled',
					);

					if ($evaluasi['pilihan_jml']>0){
						$pills_tambah[$tampil_kd]['tambah_from_bank_soal'] = array(
								'label' => '<i class="icon-book"></i>TAMBAH SOAL BAGIAN KE - '.$tampil_kd.' DARI BANK SOAL',
								'uri' => "kbm/bank_soal/evaluasi_add?evaluasi_id={$evaluasi['id']}&posisi_kd={$tampil_kd}&kurikulum_id={$evaluasi['kurikulum_id']}&kategori_id={$evaluasi['kategori_id']}&mapel_id={$evaluasi['mapel_id']}&redir={$uri}/{$evaluasi['id']}",
								'attr' => 'title="tambah butir soal baru" ',
								'class' => 'disabled',
						);
					}
					
					if (($author_ybs OR $admin) && !$evaluasi['published'] && $evaluasi['semester_id'] == $semaktif['id']):
						$pills_tambah[$tampil_kd]['tambah']['class'] = 'active';
						$pills_tambah[$tampil_kd]['tambah_from_bank_soal']['class'] = 'active';
					endif;

					$bar_tambah_soal = '<div>'
					. form_opening('', ' class="form-search well"')
					. pills($pills_tambah[$tampil_kd], 'class="nav nav-pills pull-right"')
					. form_close()
					. '</div>';
			
					// Dokumen Soal
					if ($evaluasi['metode'] == "upload_dokumen_soal"){
						
						$set_form_soal 	= "form_upload_dokumen"; 
						
						echo '<div class="form-horizontal"><fieldset>';
						echo '<legend>Dokumen Soal</legend>';
							$pills_tambah_soal_dokumen[] = array(
									'label' => '<i class="icon-pencil"></i>EDIT DOKUMEN SOAL',
									'uri' => "kbm/evaluasi/".$set_form_soal."?id={$evaluasi['id']}",
									'attr' => 'title="tambah butir soal baru" ',
									'class' => 'active',
							);
						$bar_tambah_soal_dokumen = '<div>'
									. form_opening('', ' class="form-search well"')
									. pills($pills_tambah_soal_dokumen, 'class="nav nav-pills pull-right"')
									. form_close()
									. '</div>';
						echo $bar_tambah_soal_dokumen;

						echo '<div id="test-id-1" style="text-align: center; width: 100%; height: 600px" class="embed-pdf" data-url="'.$file_link2.'"><span class="loader">Mohon Maaf: Loading Soal...</span></div>';

					}
					//////////////////
					
					// view
					echo '<legend>Soal Bagian ke - '.$tampil_kd.'</legend>';
					echo $bar_tambah_soal;
					
					echo '<div id="detail-tambahan-'.$tampil_kd.'" class="form-horizontal"><fieldset>';
					echo '<legend>Keterangan Tambahan</legend>';

					foreach ($detail['tambahan'] as $label => $cdat):
						echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
						. data_cell($cdat, $row_pembagian_kd) . "</div></div>";
					endforeach;
					echo "<div class=\"control-group\"><div class=\"controls\">"
						.a("kbm/evaluasi_pembagian_kd/form?evaluasi_id={$evaluasi['id']}&posisi_kd={$tampil_kd}",
							'Edit', 'class="btn btn-small btn-warning"') . '&nbsp;';
					echo '</fieldset></div><br/>';
					
					echo ds_table($table, $resultset[$tampil_kd]);
					$tampil_kd++;
				}
				
				//// SOAL ISIAN SINGKAT
				if($evaluasi['plus_isian']==1){
					//echo"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
					$tampil_kd = 99;
					$r['posisi_kd'] = $tampil_kd;
					$resultset[$tampil_kd] = $this->m_kbm_evaluasi_soal->browse(0, 100);
					$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($evaluasi['id'], $tampil_kd);
					
					//print_r($resultset[$tampil_kd]);
					/// keterangan tambahan
					$detail['tambahan'] = array(
						'Nama KD'	 		 => array('nama', 'display_nama_kd'),
						'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $resultset[$tampil_kd]['total_rows']),
					);
					///tambah
					// pills link
					$pills_tambah[$tampil_kd][] = array(
							'label' => '<i class="icon-pencil"></i>TAMBAH TULIS SOAL ISIAN ',
							'uri' => "kbm/evaluasi_soal/".$set_form."?evaluasi_id={$evaluasi['id']}&isian=1&posisi_kd={$tampil_kd}&redir={$uri}/{$evaluasi['id']}",
							'attr' => 'title="tambah butir soal baru" ',
							'class' => 'active',
					);

					// opsi tambahan
					$bar_tambah_soal = '<div>'
							. form_opening('', ' class="form-search well"')
							. pills($pills_tambah[$tampil_kd], 'class="nav nav-pills pull-right"')
							. form_close()
							. '</div>';
							
					// view
					echo '<legend>Soal Bagian ISIAN </legend>';
					echo $bar_tambah_soal;
					//echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
					echo '<div id="detail-tambahan-'.$tampil_kd.'" class="form-horizontal"><fieldset>';
					echo '<legend>Keterangan Tambahan</legend>';

					foreach ($detail['tambahan'] as $label => $cdat):
						echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
						. data_cell($cdat, $row_pembagian_kd) . "</div></div>";
					endforeach;
					echo "<div class=\"control-group\"><div class=\"controls\">"
						.a("kbm/evaluasi_pembagian_kd/form?evaluasi_id={$evaluasi['id']}&isian=1&posisi_kd={$tampil_kd}",
							'Edit', 'class="btn btn-small btn-warning"') . '&nbsp;';
					echo '</fieldset></div><br/>';
					
					echo ds_table($table, $resultset[$tampil_kd]);
				}
				
				//// SOAL URAIAN
				if($evaluasi['plus_uraian']==1){
					
					$tampil_kd = 999;
					$r['posisi_kd'] = $tampil_kd;
					$resultset[$tampil_kd] = $this->m_kbm_evaluasi_soal->browse(0, 100);
					$row_pembagian_kd = $this->m_kbm_evaluasi_pembagian_kd->rowset($evaluasi['id'], $tampil_kd);
					
					//print_r($resultset[$tampil_kd]);
					/// keterangan tambahan
					$detail['tambahan'] = array(
						'Nama KD'	 		 => array('nama', 'display_nama_kd'),
						'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $resultset[$tampil_kd]['total_rows']),
					);
					///tambah
					// pills link
					$pills_tambah[$tampil_kd][] = array(
							'label' => '<i class="icon-pencil"></i>TAMBAH TULIS SOAL URAIAN ',
							'uri' => "kbm/evaluasi_soal/".$set_form."?evaluasi_id={$evaluasi['id']}&uraian=1&posisi_kd={$tampil_kd}&redir={$uri}/{$evaluasi['id']}",
							'attr' => 'title="tambah butir soal baru" ',
							'class' => 'active',
					);

					// opsi tambahan
					$bar_tambah_soal = '<div>'
							. form_opening('', ' class="form-search well"')
							. pills($pills_tambah[$tampil_kd], 'class="nav nav-pills pull-right"')
							. form_close()
							. '</div>';
							
					// view
					echo '<legend>Soal Bagian URAIAN </legend>';
					echo $bar_tambah_soal;
					echo '<div id="detail-tambahan-'.$tampil_kd.'" class="form-horizontal"><fieldset>';
					echo '<legend>Keterangan Tambahan</legend>';

					foreach ($detail['tambahan'] as $label => $cdat):
						echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
						. data_cell($cdat, $row_pembagian_kd) . "</div></div>";
					endforeach;
					
					echo "<div class=\"control-group\"><div class=\"controls\">"
						.a("kbm/evaluasi_pembagian_kd/form?evaluasi_id={$evaluasi['id']}&uraian=1&posisi_kd={$tampil_kd}",
							'Edit', 'class="btn btn-small btn-warning"') . '&nbsp;';
					echo '</fieldset></div><br/>';
					
					
					if($evaluasi['detail_uraian']!=''){
						echo '<table id="tabel-soal" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<td class=" t-head my-widget-header">';
						
						echo '<legend>Arsip Soal Uraian </legend>';
						echo div('class="soal-pertanyaan"', $evaluasi['detail_uraian']) . '<br/>';
						echo '			</td>
									</tr>
									</tbody>
								</table>';
					}
					
					echo ds_table($table, $resultset[$tampil_kd]);
				}
				///////////////////////////
				//echo ds_table($table, $resultset);
				/*
				if($evaluasi['plus_uraian']==1){
					echo '<legend>Uraian</legend>';
					echo '<table id="tabel-soal" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<td class=" t-head my-widget-header">';
					echo '<div class="pull-right soal-pills">';
					echo a("kbm/evaluasi/form_uraian?id={$evaluasi['id']}", 'Edit', 'class="btn btn-small btn-success"');
					
					echo '</div>';
					echo div('class="soal-pertanyaan"', $evaluasi['detail_uraian']) . '<br/>';
					echo '			</td>
								</tr>
								</tbody>
							</table>';
				}*/
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		

	</body>
</html>

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