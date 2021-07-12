<?php

// var

$xdat = ($row['id'] > 0) ? (array) json_decode($row['xdat'], TRUE) : array();
$foto_tersimpan = array_node($xdat, array('foto', 'full_path'));
$foto_terunggah = array_node($form, array('upload', 'full_path'));
$img_tersimpan = (!file_exists($foto_tersimpan)) ? NULL : array('src' => webpath($foto_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
$img_terunggah = (!file_exists($foto_terunggah)) ? NULL : array('src' => webpath($foto_terunggah), 'class' => "thumbnail", 'title' => 'diupload');

// hak akses & user scope

$sdm_ybs = ($user['id'] == $row['id']);
$admin_user = cfguc_admin('akses', 'data', 'user');
/*
$view_nilai_pelajaran = cfguc_view('akses', 'nilai', 'pelajaran');
$view_nilai_kelas = cfguc_view('akses', 'nilai', 'kelas');
$view_nilai_ekskul = cfguc_view('akses', 'nilai', 'ekskul');
$view_nilai_organisasi = cfguc_view('akses', 'nilai', 'organisasi');
*/
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Data'							 => 'data',
	'Profil'						 => 'data/profil',
	GURU_ALIAS . ' &amp; SDM'		 => 'data/profil/sdm',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/profil/sdm/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0)
	$pills[] = array(
		'label'	 => 'Kembali',
		'uri'	 => "data/profil/sdm/id/{$row['id']}",
		'attr'	 => 'title="kembali ke detail ' . strtolower(GURU_ALIAS) . '/sdm"',
	);
else
	$pills[] = array(
		'label'	 => 'Kembali',
		'uri'	 => "data/profil/sdm",
		'attr'	 => 'title="kembali ke tabel ' . strtolower(GURU_ALIAS) . ' dan sdm"',
	);

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// input data

$input_umum = array(
	'nip'		 => array(
		'nip',
		'type'			 => 'input',
		'name'			 => 'nip',
		'id'			 => 'nip',
		'class'			 => 'input input-xlarge',
		'label'			 => 'N I P',
		'placeholder'	 => 'masukan NIP',
	),
	'nuptk'		 => array(
		'nuptk',
		'type'			 => 'input',
		'name'			 => 'nuptk',
		'id'			 => 'nuptk',
		'class'			 => 'input input-xlarge',
		'label'			 => 'N U P T K',
		'placeholder'	 => 'masukan NUPTK'
	),
	'nama'		 => array(
		'label'			 => 'Nama',
		'prefix',
		'type'			 => 'input',
		'name'			 => 'prefix',
		'id'			 => 'prefix',
		'class'			 => 'input input-mini',
		'style'			 => 'width : 2em;',
		'placeholder'	 => 'gelar',
		'suffix'		 => array(
			array(
				'nama',
				'type'			 => 'input',
				'name'			 => 'nama',
				'id'			 => 'nama',
				'class'			 => 'input input-xlarge',
				'style'			 => 'margin-right : 0.3em;',
				'placeholder'	 => 'masukan nama lengkap',
			),
			array(
				'suffix',
				'type'			 => 'input',
				'name'			 => 'suffix',
				'id'			 => 'suffix',
				'class'			 => 'input input-medium',
				'placeholder'	 => 'gelar',
			),
		),
	),
	'gender'	 => array(
		'gender',
		'type'		 => 'dropdown',
		'name'		 => 'gender',
		'id'		 => 'gender',
		'label'		 => 'Gender',
		'options'	 => array('l' => 'Laki-laki', 'p' => 'Perempuan'),
	),
	'alamat'	 => array(
		'alamat',
		'type'			 => 'textarea',
		'name'			 => 'alamat',
		'id'			 => 'alamat',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Alamat',
		'rows'			 => 3,
		'placeholder'	 => 'masukan alamat lengkap',
	),
	'kota'		 => array(
		'kota',
		'type'			 => 'input',
		'name'			 => 'kota',
		'id'			 => 'kota',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Kota',
		'placeholder'	 => 'masukan kota domisili',
	),
	'telepon'	 => array(
		'telepon',
		'type'			 => 'input',
		'name'			 => 'telepon',
		'id'			 => 'telepon',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Telepon',
		'placeholder'	 => 'masukan nomor telepon',
	),
);
$input_khusus = array(
	'jabatan_id' => array(
		'jabatan_id',
		'type'		 => 'dropdown',
		'name'		 => 'jabatan_id',
		'id'		 => 'jabatan_id',
		'options'	 => $this->m_option->jabatan(),
		'extra'		 => 'id="jabatan_id" class="input input-large select"',
	),
	'aktif'		 => array(
		'name'		 => 'aktif',
		'id'		 => 'aktif',
		'value'		 => 1,
		'checked'	 => (bool) $row['aktif'],
	),
	'mengajar'	 => array(
		'name'		 => 'mengajar',
		'id'		 => 'mengajar',
		'value'		 => 1,
		'checked'	 => (bool) $row['mengajar'],
	),
);
$input_akun = array(
	'email' => array(
		'email',
		'type'			 => 'input',
		'name'			 => 'email',
		'id'			 => 'email',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Email',
		'placeholder'	 => 'masukan email aktif',
	),
);

if (!$admin):
	$input_umum['nip']['disabled'] = 'true';
	$input_umum['nuptk']['disabled'] = 'true';
	$input_khusus['jabatan_id']['extra'] .= 'disabled="true"';
	$input_khusus['aktif']['disabled'] = 'true';

endif;

//if (!$admin or $semaktif['id'] > 0)
//	$input_khusus['mengajar']['disabled'] = 'true';
// foto
// buttons


$btn_back = a("data/profil/sdm", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke daftar guru', 
'class="btn btn-info  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="back" title="kembali ke tabel" ');

$akun_login = a("data/user/id/{$row['id']}", ' <i class="zmdi zmdi-key"></i> Akun Login', 
'class="btn bgm-purple waves-effect  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="akun_login" title="lihat akun login ini" ');

$menu_atas = '<div class="col-sm-5"  align="left"> '.$btn_back.' </div>';
if ($admin_user OR $sdm_ybs)
{
	$menu_atas .= '<div class="col-sm-7" align="right"> '.$akun_login.' </div>';
}
$view_data['kepegawaian'] = array(
			'N I P'	 		=> 'nip',
			'N U P T K'	 	=> 'nuptk',
			'Jabatan'		=> 'jabatan_id',
			'Mengajar'		=> 'mengajar',
			'Status Aktif'	=> 'aktif',
		);
		
$view_data['profil'] = array(
			'Nama'	 	=> 'nama',
			'Gender'	=> 'gender',
			'Alamat'	=> 'alamat',
			'Kota'		=> 'kota',
			'Telepon'	=> 'telepon',
		);
		
?>


<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Guru')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">PROFIL GURU</h2>

            </div>
			<?php
			echo alert_get();
			
			?>
			<div class="card">
				<div class="row">
				<?php echo $menu_atas;?>
				</div>
			</div>
			
            <div class="card" id="profile-main">
                <!--<div class="pm-overview c-overflow">
                    <div class="pmo-pic" id="img_sample">
                        <div class="p-relative">
                            <?php echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210));?>
							<button id="sa-warning" class="pmop-edit"><i class="zmdi zmdi-camera"></i></button>
                        </div>
						<div class="pmo-stat">
						</div>
                    </div>
                </div>-->

				<a href="#" id="sa-warning" class="pmop-edit">
					<div class="pm-overview c-overflow">

						<div class="pmo-pic" id="img_sample">
							<div class="p-relative">
								<?php //echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210));?>
								<?php
								$img_path= base_url().$path_foto;
								if(!file_exists($img_path))
									$img_path= base_url()."content/no-photo.jpg";?>
								<img src="<?php echo $img_path;?>" width="210" >
								<!--<i class="zmdi zmdi-camera"></i>-->
							</div>
							<!--<div class="pmo-stat">
							</div>-->
						</div>

					</div>
				</a>
				
                <div class="pm-body clearfix" role="tabpanel">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li class="active">
						<a href="#data_kepegawaian" aria-controls="kepegawaian" role="tab" data-toggle="tab">kepegawaian</a></li>
						<li>
						<a href="#data_diri" aria-controls="diri" role="tab" data-toggle="tab">Diri</a></li>
						
                    </ul>
					
					<?php 
					$uri_form = str_replace("id","form",$uri);
					echo form_openmp("{$uri_form}?id={$row['id']}", '');
					?>
					<div class="tab-content">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->						
						<div role="tabpanel" id="data_kepegawaian" class="tab-pane active pmb-block">
							<div class="pmbb-header">
								<h2 id="title_kepegawaian" ><i class="zmdi zmdi-account m-r-10"></i> Data kepegawaian</h2>
								<?php
								if ($admin OR $sdm_ybs)
								{?>
							
								<ul class="actions">
									<a data-ma-action="profile-edit" href="" id="edit_kepegawaian" class="btn btn-warning btn-sm" >
									<i class="zmdi zmdi-edit"></i></a>
								</ul>
								<?php
								}?>
							</div>
							<?php
								$status_login 	 = array(0 => 'Blokir login',1 => 'Aktif');
								$status_mengajar = array(0 => 'Tidak Aktif Mengajar',1 => 'Aktif Mengajar');
								$jabatan		 = $this->m_option->jabatan();
							?>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
									<?php 
									foreach($view_data['kepegawaian'] as $label => $value)
									{
										if ($value=='jabatan_id')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$jabatan[$row[$value]]?></dd>
											</dl>
										<?php	
										}elseif ($value=='mengajar')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$status_mengajar[$row[$value]]?></dd>
											</dl>
										<?php	
										}elseif ($value=='aktif')
										{
											if($admin OR $sdm_ybs)
											{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$status_login[$row[$value]]?></dd>
											</dl>
											<?php
											}
										}else
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$row[$value]?></dd>
											</dl>
											
										<?php 
										}
									} ?>
									
								</div>
								
								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">N I P</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nip"
													   value='<?=$row['nip']?>' placeholder="masukan NIP">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">N U P T K</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nuptk"
													   value='<?=$row['nuptk']?>' placeholder="masukan NUPTK">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Jabatan</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="jabatan_id">
													<?php 
													foreach($jabatan as $value=>$label){
														if($row['jabatan_id']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Status Mengajar</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="aktif">
													<?php 
													foreach($status_mengajar as $value=>$label){
														if($row['mengajar']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									<?php //print_r($kelas_array);?>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Status Aktif</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="aktif">
													<?php 
													foreach($status_login as $value=>$label){
														if($row['aktif']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
							
							
						</div>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->						
						<div role="tabpanel" id="data_diri" class="tab-pane pmb-block">
							<div class="pmbb-header">
								<h2 id="title_profil"><i class="zmdi zmdi-account m-r-10"></i> Data Profil Siswa</h2>
								<?php
								if ($admin OR $sdm_ybs)
								{?>
							<!--
								<ul class="actions">
									<li class="dropdown">
										<a href="" data-toggle="dropdown">
											<i class="zmdi zmdi-more-vert"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a data-ma-action="profile-edit" href="">Edit</a>
											</li>
										</ul>
									</li>
								</ul>
							-->
							<ul class="actions">
								<a data-ma-action="profile-edit" href="" id="edit_profil" class="btn btn-warning btn-sm" >
								<i class="zmdi zmdi-edit"></i></a>
							</ul>
								<?php
								}?>
							</div>
							<?php
								$gender = array('p' => 'Perempuan', 'l' => 'Laki-laki');
							?>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
								<?php 
									foreach($view_data['profil'] as $label => $value)
									{
										if ($value=='gender')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$gender[$row[$value]]?></dd>
											</dl>
											<?php
										}else
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$row[$value]?></dd>
											</dl>
											
										<?php 
										}
									} ?>
									
									
								</div>

								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nama"
													   value='<?=$row['nama']?>' placeholder="nama">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Gender</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="gender">
													<?php 
													foreach($gender as $value=>$label){
														if($row['gender']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Alamat</dt>
										<dd>
											<div class="fg-line">
												<textarea class="form-control" rows="5" name="alamat"
													   placeholder="alamat">
													   <?=$row['alamat']?>
												</textarea>
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Kota</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="kota"
													   value='<?=$row['kota']?>' placeholder="kota">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Telepon</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="telepon"
													   value='<?=$row['telepon']?>' placeholder="telepon">
											</div>

										</dd>
									</dl>
									

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
						</div>
						
						

					</div>
					<?php
					echo form_close();
					?>
                </div>
            </div>
                    
                    
                    
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer_form"); ?>
	</body>
</html>

<script type="text/javascript">
	/*
	 * Notifications
	 */
	function notify(from, align, icon, type, animIn, animOut){
		$.growl({
			icon: icon,
			title: ' Bootstrap Growl ',
			message: 'Turning standard Bootstrap alerts into awesome notifications',
			url: ''
		},{
				element: 'body',
				type: type,
				allow_dismiss: true,
				placement: {
						from: from,
						align: align
				},
				offset: {
					x: 20,
					y: 85
				},
				spacing: 10,
				z_index: 1031,
				delay: 2500,
				timer: 1000,
				url_target: '_blank',
				mouse_over: false,
				animate: {
						enter: animIn,
						exit: animOut
				},
				icon_type: 'class',
				template: '<div data-growl="container" class="alert" role="alert">' +
								'<button type="button" class="close" data-growl="dismiss">' +
									'<span aria-hidden="true">&times;</span>' +
									'<span class="sr-only">Close</span>' +
								'</button>' +
								'<span data-growl="icon"></span>' +
								'<span data-growl="title"></span>' +
								'<span data-growl="message"></span>' +
								'<a href="#" data-growl="url"></a>' +
							'</div>'
		});
	};
	
	$('.notification-demo > div > .btn').click(function(e){
		e.preventDefault();
		var nFrom = $(this).attr('data-from');
		var nAlign = $(this).attr('data-align');
		var nIcons = $(this).attr('data-icon');
		var nType = $(this).attr('data-type');
		var nAnimIn = $(this).attr('data-animation-in');
		var nAnimOut = $(this).attr('data-animation-out');
		
		notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
	});


	/*----------------------
		Dialogs
	 -----------------------*/
	<?php
	$form_js = str_replace("\n","'+'",form_openmp("{$uri_form}?id={$row['id']}", ''));
	?>
	//Warning Message
	$('#sa-warning').click(function(){
		swal({   
			title: "Ubah Photo Profil",   
			text: '<?php echo $form_js;?>'+
						<?php 
						foreach($view_data['kepegawaian'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						<?php 
						foreach($view_data['profil'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						
						'<div style="padding-left:35px;" class="fileinput fileinput-new" data-provides="fileinput">'+
							'<div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>'+
							'<div>'+
								'<span class="btn btn-info btn-file">'+
									'<span class="fileinput-new">Select image</span>'+
									'<span class="fileinput-exists">Change</span>'+
									'<input type="file" name="foto">'+
								'</span>'+
								'<a href="#" class="btn btn-danger m-l-5 fileinput-exists" data-dismiss="fileinput">Remove</a>'+
							'</div>'+
							'<button type="submit" class="btn btn-primary btn-block m-t-5 btn-sm">Save</button>'+
						'</div>'+
					'<?php echo form_close();?>',  
			//type: "warning",   
			//showCancelButton: true,
			showConfirmButton: false,
			//confirmButtonText: "Yes, delete it!",
		});
	});
	
	setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
	//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
	setTimeout(function(){nowAnimation('profile-main','fadeInUp')},700);

	setTimeout(function () {
		$("#title_page").removeClass("animated");
		$("#title_page").removeClass("fadeInUp");
		
		setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
	}, 500);// wait 0.5s
				
	//setTimeout(function(){delayAnimation('navbar_profil','rubberBand')},3000);
	setTimeout(function(){delayAnimation('back','rubberBand')},3000);
	setTimeout(function(){delayAnimation('akun_login','rubberBand')},3300);
	
	setTimeout(function(){delayAnimation('img_sample','tada')},3300);
	
	setTimeout(function(){delayAnimation('title_kepegawaian','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_kepegawaian','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_profil','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_profil','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_keluarga','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_keluarga','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_pendaftaran','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_pendaftaran','rubberBand')},4200);
	
</script>