<?php

// vars

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_name = array_nodex($row, array('lampiran', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));
$file_view = "http://docs.google.com/viewer?url=" . $file_link;

// user akses

$author_ybs = ($user['id'] == $row['author_id']);

$img_sample = array(
	"1.jpg",
	"2.jpg",
	"3.jpg",
	"4.jpg",
	"5.jpg",
	"6.jpg",
);
$warna=array(
		'class="btn bgm-cyan"', 
		'class="btn bgm-teal"',
		'class="btn bgm-amber"',
		'class="btn bgm-orange"',
		'class="btn bgm-deeporange"',
		'class="btn bgm-red"',
		'class="btn bgm-pink"',
		'class="btn bgm-lightblue"',
		'class="btn bgm-indigo"',
		'class="btn bgm-lime"',
		'class="btn bgm-lightgreen"',
		'class="btn bgm-green"',
		'class="btn bgm-purple"',
		'class="btn bgm-deeppurple"',
		);


$menu_atas_kiri = '<div class="col-sm-5">';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/materi" id="back" 
				class="btn bgm-gray btn-sm m-b-5" title="kembali ke daftar materi" ><i class="zmdi zmdi-arrow-left"></i> Daftar Materi </a>';
$menu_atas_kiri .= '</div>';
	


$menu_atas_kanan = '<div class="col-sm-7" align="right">';
if ($author_ybs OR $admin):
	if ($row['semester_id'] == $semaktif['id'])
	{
		$menu_atas_kanan .= '<a href="'.base_url().'kbm/materi/form?id='.$row["id"].'" id="edit" 
				class="btn btn-warning btn-sm m-b-5" title="ubah konten materi ini" ><i class="zmdi zmdi-edit"></i> Edit </a>&nbsp;';
		
	}
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/materi/pembaca/'.$row["id"].'" id="pembaca" 
				class="btn btn-info btn-sm m-b-5" title="lihat aktifitas belajar siswa" ><i class="zmdi zmdi-accounts"></i> Pembaca </a>&nbsp;';
				
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/materi/hapus/'.$row["id"].'" id="hapus" 
		class="btn btn-danger btn-sm m-b-5" title="hapus konten materi ini" 
		onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK MENGHAPUS MATERI INI ?\')"><i class="zmdi zmdi-delete"></i> Hapus </a>&nbsp;';
endif;

if ($author_ybs OR $admin OR $user['role'] == 'sdm')
{
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/materi/reuse/'.$row["id"].'" id="reuse" 
				class="btn bgm-purple btn-sm m-b-5" title="gunakan kembali materi ini" ><i class="zmdi zmdi-refresh-alt"></i> Reuse </a>&nbsp;';
}
$menu_atas_kanan .= '</div> ';
?>


<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Materi #{$row['id']}")); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>MATERI BELAJAR</b></h2>
            </div>
            
			<style>
				.controls{
					font-size: 1.2em;
					margin: 0.2em 0;
					color: black;
				}
				#info{
					font-size: .9em;
					opacity: .7;
				}
				#lampiran{
					width: 100%;
					height: 600px;
				}
				.modal-body2{
					padding:10px 20px 10px 20px;
				}
			</style>
            <?php
			echo alert_get();
			
			?>
			<div class="card">
                <div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/materi/id/{$row['id']}", $row['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $row['author_nama'];?></li>
                                <li>Mapel <?php echo $row['mapel_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
                <div class="card-body card-padding">
              		<?=$menu_atas_kiri?>
                    <?=$menu_atas_kanan?>
                     <br/> <br/>
                    <?php
					 // tampilkan lampiran
					if ($file_link):
						echo '<ul class="lgi-attrs"><li>Lampiran</li></ul>
						<a href="'.$file_link.'" id="download" class="btn btn-success btn-sm m-t-5" 
						title="download lampiran" target="_blank" ><i class="zmdi zmdi-download"></i> '.$file_name.' </a><br/><br/>';
					endif;
					
						// klo ada ketikan artikel, tampilkan. lampiran jadi link
	
					if (!empty($row['konten'])):
						echo'
                            <div class="clearfix modal-preview-demo" id="artikel">
                                <div class="modal"> <!-- Inline style just for preview -->
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
											<div class="modal-body2">
                                            '.clean_charset($row["konten"]).'
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
						
						//echo tag('article', 'id="artikel"', clean_charset($row['konten']));
	
					elseif ($file_ofis):
						echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>";
	
					endif;
	
					echo '<br/><br/><br/>';
	
					// pertanyaan
	
					echo p('', '<h4><b>Pertanyaan Siswa</b></h4>') . $row['pertanyaan'];
	
					if ($user['role'] == 'siswa'):
						echo p('', '<h4><b>Respon Jawaban</b></h4>');
	
						if ($row['respon_jawaban']):
							echo ($row['respon_jawaban']);
	
						else:
							echo form_opening("{$uri}/{$row['id']}");
							echo form_cell($input_jawaban, $row);
							echo '<button type="submit" class="btn btn-success" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">
							<i class="icon-save icon-white"></i> Simpan Respon Jawaban</button> ';
							echo form_close();
	
						endif;
	
					endif;

				?>
                </div>
            </div>
			
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

<script type="text/javascript">
   
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){delayAnimation('back','rubberBand')},4000);
setTimeout(function(){delayAnimation('edit','rubberBand')},4400);
setTimeout(function(){delayAnimation('pembaca','rubberBand')},4800);
setTimeout(function(){delayAnimation('hapus','rubberBand')},5200);
setTimeout(function(){delayAnimation('reuse','rubberBand')},5600);
setTimeout(function(){delayAnimation('download','rubberBand')},5600);
setTimeout(function(){delayAnimation('lampiran','pulse',30000)},10000);
</script>

<?php

addon('tinymce');

?>

	</body>
</html>