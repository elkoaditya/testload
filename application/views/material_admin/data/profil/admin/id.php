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
?>


<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Siswa')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">PROFIL ADMIN</h2>

            </div>

            <div class="card" id="profile-main">
                <div class="pm-overview c-overflow">

                    <div class="pmo-pic">
                        <div class="p-relative">
                            <?php echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210));?>

                            
                        </div>


                        
                    </div>

                    
                </div>

                <div class="pm-body clearfix">
                    <ul class="tab-nav tn-justified">
                        <li class="active"><a href="profile-about.html">Data Diri</a></li>
                       <!-- <li><a href="profile-timeline.html">Timeline</a></li>
                        <li><a href="profile-photos.html">Photos</a></li>
                        <li><a href="profile-connections.html">Connections</a></li>-->
                    </ul>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
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
							<button data-ma-action="profile-edit" id="sa-params" class="btn btn-warning btn-sm" >
							<i class="zmdi zmdi-edit"></i></button>
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
                                <dl class="dl-horizontal">
                                    <dt>Namai</dt>
                                    <dd><?=$row['nama']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Gender</dt>
                                    <dd><?=$gender[$row['gender']]?></dd>
                                </dl>
                                
                                <dl class="dl-horizontal">
                                    <dt>Alamat</dt>
                                    <dd><?=$row['alamat']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Kota</dt>
                                    <dd><?=$row['kota']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Telepon</dt>
                                    <dd><?=$row['telepon']?></dd>
                                </dl>
								<?php
								if ($admin OR $admin_ybs)
								{?>
								<dl class="dl-horizontal">
                                    <dt>Status Login</dt>
                                    <dd><?=$status_login[$row['aktif']]?></dd>
                                </dl>
								<?php 
								}?>
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
                                            <input type="text" class="form-control"
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
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>
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

	//Basic
	$('#sa-basic').click(function(){
		swal("Here's a message!");
	});

	//A title with a text under
	$('#sa-title').click(function(){
		swal("Here's a message!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat, tincidunt vitae ipsum et, pellentesque maximus enim. Mauris eleifend ex semper, lobortis purus sed, pharetra felis")
	});

	//Success Message
	$('#sa-success').click(function(){
		swal("Good job!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat, tincidunt vitae ipsum et, pellentesque maximus enim. Mauris eleifend ex semper, lobortis purus sed, pharetra felis", "success")
	});

	//Warning Message
	$('#sa-warning').click(function(){
		swal({   
			title: "Are you sure?",   
			text: "You will not be able to recover this imaginary file!",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "Yes, delete it!",
		}).then(function(){
			swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
		});
	});
	
	//Parameter
	$('#sa-params').click(function(){
		swal({   
			title: "Are you sure?",   
			text: "You will not be able to recover this imaginary file!",   
			type: "warning",   
			showCancelButton: true,   
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",   
		}).then(function(isConfirm){
			if (isConfirm) {     
				swal("Deleted!", "Your imaginary file has been deleted.", "success");   
			} else {     
				swal("Cancelled", "Your imaginary file is safe :)", "error");   
			} 
		});
	});

	//Custom Image
	$('#sa-image').click(function(){
		swal({   
			title: "Sweet!",   
			text: "Here's a custom image.",   
			imageUrl: "img/thumbs-up.png" 
		});
	});

	//Auto Close Timer
	$('#sa-close').click(function(){
		 swal({   
			title: "Auto close alert!",   
			text: "I will close in 2 seconds.",   
			timer: 2000
		});
	});

</script>