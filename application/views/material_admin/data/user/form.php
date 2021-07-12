<?php
// vars

$user_ybs = ($user['id'] == $row['id']);

$sma_terbang = (($user['role']=='sdm') && (APP_SCOPE == 'sma_terbang'));

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'User' => 'data/user',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/user/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input = array(
		'alias' => array(
				'alias',
				'type' => 'input',
				'name' => 'alias',
				'id' => 'alias',
				'class' => 'input input-xlarge',
				'label' => 'Alias',
		),
		'tentang' => array(
				'tentang',
				//'html_entity_decode',
				'type' => 'textarea',
				'name' => 'tentang',
				'id' => 'tentang',
				'class' => 'input tinymce_mini',
				'rows' => 5,
				'label' => 'Tentang',
		),
		'email' => array(
				'email',
				'type' => 'input',
				'name' => 'email',
				'id' => 'email',
				'class' => 'input input-xlarge',
				'label' => 'Email',
		),
		'username' => array(
				'username',
				'type' => 'input',
				'name' => 'username',
				'id' => 'username',
				'class' => 'input input-xlarge',
				'label' => 'Username',
		),
		'password' => array(
				//'password',
				'type' => 'password',
				'name' => 'password',
				'id' => 'password',
				'class' => 'input input-xlarge',
				'label' => 'Password',
		),
		'passconf' => array(
				//'password',
				'type' => 'password',
				'name' => 'passconf',
				'id' => 'passconf',
				'class' => 'input input-xlarge',
				'label' => 'Konfirm password',
		),
		'role' => array(
				'role',
				'type' => 'input',
				'name' => 'role',
				'id' => 'role',
				'class' => 'input disabled',
				'label' => 'Role',
				'disabled' => 'true',
		),
);

$btn_back = a("data/profil/{$row['role']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke daftar tabel',
 'class="btn btn-info  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="back" ');

$profil_detail = a("data/profil/{$row['role']}/id/{$row['id']}?ringkas=ya", ' <i class="zmdi zmdi-account"></i> Profil Detail', 
'class="btn btn-primary  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="profil" title="lihat profil user ini" ');

$menu_atas = '<div class="col-sm-5"  align="left"> '.$btn_back.' </div>';

$menu_atas .= '<div class="col-sm-7"  align="right">'.$profil_detail.'</div>';


$view_data['akun_login'] = array(
			'Alias'	 	=> 'alias',
			'Tentang'	=> 'tentang',
			'Email'		=> 'email',
			'Username'	=> 'username',
			'Role'		=> 'role',
		);
?>


<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Akun Login')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">AKUN LOGIN</h2>

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
				
                

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2 id="title_profil"><i class="zmdi zmdi-account m-r-10"></i> Data User Login</h2>
							<?php
							if ($admin OR $user_ybs OR $sma_terbang)
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
								foreach($view_data['akun_login'] as $label => $value)
								{
									if ($value=='role')
									{
										if ($admin OR $user_ybs OR $sma_terbang)
										{?>
										<dl class="dl-horizontal">
											<dt><?=$label?></dt>
											<dd><?=$row[$value]?></dd>
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
								<?php 
								$uri_form = str_replace("id","form",$uri);
								echo form_openmp("{$uri_form}?id={$row['id']}", '');
								?>
								<input type="hidden" name="role" 		value="<?=$row['role']?>" />
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Alias</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="alias"
                                                   value='<?=$row['alias']?>' placeholder="alias">
                                        </div>

                                    </dd>
                                </dl>
								
								<dl class="dl-horizontal">
										<dt class="p-t-10">Tentang</dt>
										<dd>
											<div class="fg-line">
												<textarea class="input tinymce_mini" rows="5" name="tentang"
													   placeholder="tentang">
													   <?=$row['tentang']?>
												</textarea>
											</div>

										</dd>
									</dl>
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Email</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="email"
                                                   value='<?=$row['email']?>' placeholder="email">
                                        </div>

                                    </dd>
                                </dl>
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Username</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" class="form-control" name="username"
                                                   value='<?=$row['username']?>' placeholder="username">
                                        </div>

                                    </dd>
                                </dl>
								
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Password</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="password">
                                        </div>

                                    </dd>
                                </dl>
								
								<dl class="dl-horizontal">
                                    <dt class="p-t-10">Passconf</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="password" class="form-control" name="passconf"
                                                   placeholder="passconf">
                                        </div>

                                    </dd>
                                </dl>
								

                                <div class="m-t-30">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
                                </div>
								<br/><br/>
								<?php
								echo form_close();
								?>
                            </div>
                        </div>

                    
                </div>
            </div>
			
        </div>
    </section>
</section>
<?php
addon('tinymce'); 
$this->load->view(THEME . "/-html-/content/footer_form"); ?>
	</body>
</html>

<script type="text/javascript">
	
	
	setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
	//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
	setTimeout(function(){nowAnimation('profile-main','fadeInUp')},700);

	setTimeout(function () {
		$("#title_page").removeClass("animated");
		$("#title_page").removeClass("fadeInUp");
		
		setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
	}, 500);// wait 0.5s
		
	setTimeout(function(){delayAnimation('back','rubberBand')},3000);
	setTimeout(function(){delayAnimation('profil','rubberBand')},3300);
	
	//setTimeout(function(){delayAnimation('navbar_profil','rubberBand')},3000);
	setTimeout(function(){delayAnimation('img_sample','tada')},3300);
	setTimeout(function(){delayAnimation('title_profil','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_profil','rubberBand')},4200);
	
</script>