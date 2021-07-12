<?php
// vars

$ringkas = (strtolower($this->input->get_post('ringkas')) === 'ya');
$toggle_label = ($ringkas) ? 'Profil Ringkas' : 'Profil Detail';

//function
// komponen
// hak akses & user scope

$admin_ybs = ($user['id'] == $row['id']);
$admin_user = cfguc_admin('akses', 'data', 'user');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Admin' => 'data/profil/admin',
		"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Daftar Admin',
		'uri' => "data/profil/admin",
		'attr' => 'title="kembali ke daftar admin"',
);
$pills_kanan['detail'] = array(
		'label' => "<i class=\"icon-search\"></i> {$toggle_label}",
		'uri' => "#",
		'attr' => 'title="lihat profil detail admin ini" id="cmd-info-toggle"',
);
$pills_kanan['akun'] = array(
		'label' => '<i class="icon-key"></i> Akun Login',
		'uri' => "data/user/id/{$row['id']}",
		'attr' => 'title="ubah info user-akun sdm ini"',
		'class' => 'disabled',
);
$pills_kanan['edit'] = array(
		'label' => '<i class="icon-edit"></i> Edit',
		'uri' => "data/profil/admin/form?id={$row['id']}",
		'attr' => 'title="ubah data Admin ini"',
		'class' => 'disabled',
);

if ($admin_user)
	$pills_kanan['akun']['class'] = '';

if ($admin OR $admin_ybs)
	$pills_kanan['edit']['class'] = 'active';

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// data tabel

$detail1 = array(
		'ID' => array('id', 'prefix' => '#'),
		'Nama' => array('nama_title'),
		'Gender' => array('gender', array('l' => 'Laki-laki', 'p' => 'Perempuan')),
		'Alamat' => 'alamat',
		'Kota' => 'kota',
		'Telepon' => 'telepon',
);

if ($admin OR $admin_ybs)
	$detail1['Status Login'] = array('aktif', array('blokir login', 'aktif'));

// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';


$btn_back = a("data/profil/admin", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke daftar admin',
 'class="btn btn-info  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="back" ');

$akun_login = a("data/user/id/{$row['id']}", ' <i class="zmdi zmdi-key"></i> Akun Login', 
'class="btn bgm-purple waves-effect  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="akun_login" title="lihat akun login ini" ');

$menu_atas = '<div class="col-sm-5"  align="left"> '.$btn_back.' </div>';

$menu_atas .= '<div class="col-sm-7"  align="right">'.$akun_login.'</div>';


$view_data['profil'] = array(
			'Nama'	 	=> 'nama',
			'Gender'	=> 'gender',
			'Alamat'	=> 'alamat',
			'Kota'		=> 'kota',
			'Telepon'	=> 'telepon',
			'Status Login'	 	=> 'aktif',
		);
?>


<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Admin')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">PROFIL ADMIN</h2>

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

                <div class="pm-body clearfix">
                    <ul class="tab-nav tn-justified">
                        <li class="active"><a href="profile-about.html">Data Diri</a></li>
                       <!-- <li><a href="profile-timeline.html">Timeline</a></li>
                        <li><a href="profile-photos.html">Photos</a></li>
                        <li><a href="profile-connections.html">Connections</a></li>-->
                    </ul>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2 id="title_profil"><i class="zmdi zmdi-account m-r-10"></i> Data Profil</h2>
							<?php
							if ($admin OR $admin_ybs)
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
							$status_login = array(0 => 'Blokir login',1 => 'Aktif');
						?>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
								
								<?php 
								foreach($view_data['profil'] as $label => $value)
								{
									if ($value=='aktif')
									{
										if($admin OR $admin_ybs)
										{?>
										<dl class="dl-horizontal">
											<dt><?=$label?></dt>
											<dd><?=$status_login[$row[$value]]?></dd>
										</dl>
										<?php
										}
									}elseif ($value=='gender')
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
								<?php 
								$uri_form = str_replace("id","form",$uri);
								echo form_openmp("{$uri_form}?id={$row['id']}", '');
								?>
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Nama</dt>
                                    <dd>
                                        <div class="fg-line">
											<input type="text" class="form-control" name="prefix" 
                                                   value='<?=$row['prefix']?>' placeholder="gelar depan">
                                            <input type="text" class="form-control" name="nama"
                                                   value='<?=$row['nama']?>' placeholder="nama">
											<input type="text" class="form-control" name="suffix" 
                                                   value='<?=$row['suffix']?>' placeholder="gelar belakang">
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
                                            <input type="text" class="form-control" name="alamat"
                                                   value='<?=$row['alamat']?>' placeholder="alamat">
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
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Status Login</dt>
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
								<?php
								echo form_close();
								?>
                            </div>
                        </div>
                    </div>

                    
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
		
	setTimeout(function(){delayAnimation('back','rubberBand')},3000);
	setTimeout(function(){delayAnimation('akun_login','rubberBand')},3300);
	
	//setTimeout(function(){delayAnimation('navbar_profil','rubberBand')},3000);
	setTimeout(function(){delayAnimation('img_sample','tada')},3300);
	setTimeout(function(){delayAnimation('title_profil','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_profil','rubberBand')},4200);
	
</script>