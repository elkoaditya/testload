<?php 
/// CEK ADMIN
	if(isset( $this->session->userdata['user']['id'])){
		$data_user_login ='';
		if(isset($data['data_user_login']['data'])){
			$data_user_login = $data['data_user_login']['data'];
		}
		cek_admin( $this->session->userdata['user']['id'], $this->session->userdata['user']['role'], $data_user_login);
	}
	
	$jml=0;
	foreach($data['data_user_login_role']['data'] as $value=>$key)
	{
		if(($key['login_role_id'] == 1)&&($this->session->userdata['user']['role']=='super_admin')){
			$select1[$jml]['value'] = $key['login_role_id'];
			$select1[$jml]['label'] = $key['login_role_nama'];
		}elseif($key['login_role_id'] != 1){
			$select1[$jml]['value'] = $key['login_role_id'];
			$select1[$jml]['label'] = $key['login_role_nama'];
		}
		$jml++;
	}
	
	$form = array(
		array(
			'label'			=> 'Username',
			'placeholder'	=> 'username',
			'name'			=> 'login_username',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		
		array(
			'label'			=> 'Jabatan',
			'placeholder'	=> 'jabatan',
			'name'			=> 'login_role_id',
			'help'			=> '---',
			'select'		=> $select1,
			'value'			=> '',
			'required'		=> 'required',
		),
		array(
			'label'			=> 'Status aktif',
			'placeholder'	=> 'status aktif',
			'name'			=> 'login_aktif',
			'help'			=> '---',
			'value'			=> '',
		),
		
	);
	
	if(isset($data['data_user_login']['data'])){
		foreach($data['data_user_login']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form as $f)
			{
				$form[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
	}
	
	array_push($form ,
		array(
			'label'			=> 'Password',
			'placeholder'	=> 'password',
			'name'			=> 'login_password',
			'help'			=> '---',
			'value'			=> '',
		),
		array(
			'label'			=> 'Confirmed Password',
			'placeholder'	=> 'Confirmed password',
			'name'			=> 'confirmed_password',
			'help'			=> '---',
			'value'			=> '',
		)
	);
?>
<div class="wrapper">
	<div class="container">

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							<li >
								 <a href="<?=base_url();?>/data/user_login">User Login</a>
							</li>
							<li class="active">
								Form User Login
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form User Login</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/user_login"><i class="fa fa-chevron-left"></i> Kembali User Login</a>
				</div>
				
				
			</div>
			
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form User Login</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/user_login/save" class="form-horizontal form-row-seperated" method="POST">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="user_login_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<?= form_input_text1($form[0]);?>
									
									<?= form_input_select1($form[1])?>
									
									<?= form_input_password1($form[3]);?>
									
									<?= form_input_password1($form[4]);?>
									
									<?= form_input_text1($form[2]);?>
									<br>
									
									
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-5">Simpan</button>
										</div>
									</div>
								</div>
							
							</form>
						</div>
					</div>
				
				</div>
			</div>
		</div>
               
