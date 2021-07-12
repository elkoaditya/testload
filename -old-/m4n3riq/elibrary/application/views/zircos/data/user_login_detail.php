<?php 
	/// CEK ADMIN
	
	if(isset( $this->session->userdata['user']['id'])){
		$data_user_login ='';
		if(isset($data['data_user_login']['data'])){
			$data_user_login = $data['data_user_login']['data'];
		}
		cek_admin( $this->session->userdata['user']['id'], $this->session->userdata['user']['role'], $data_user_login);
	}

	$detail = array(
			'login_username'		=> 'Username',
			'login_role_nama'		=> 'Jabatan',
			'login_last_access'		=> 'Terakhir Akses',
			'login_aktif'			=> 'Status Akses',
			'login_modified_time'	=> 'Waktu Ditambahkan',
			'modified_username'		=> 'User Menambahkan',
	)
	
	//
	
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
								Detail User Login
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Detail User Login</h4>
					<?php //echo $this->session->userdata['user']['role'];
					//print_r($data['data_user_login']['data']);?>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		

			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/user_login"><i class="fa fa-chevron-left"></i> Kembali</a>
				</div>
				
				<div class="col-md-8" align="right">
					<a class="btn btn-warning waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/user_login/edit/<?=$data['id']?>">
					<i class="fa fa-pencil"></i> Edit</a>
					<!--<a class="delete btn btn-danger" data-toggle="modal" href="#basic">
					<i class="fa fa-trash"></i> Hapus</a>-->
				</div>	
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
					<?php
					$status_aktif = array(
						1=>'<span style="color:green">AKTIF</span>',
						0=>'<span style="color:green">TIDAK AKTIF</span>');
					foreach($data['data_user_login']['data'] as $value_di=>$key){
						//////////////// ANGGOTA /////////
						foreach($detail as $value => $nama){
							
							if((strpos($value, 'modified_time') !== FALSE)||(strpos($value, 'last_access') !== FALSE))
							{
								$key[$value] = tglwaktu($key[$value]);
							}
							elseif(strpos($value, 'aktif') !== FALSE)
							{
								$key[$value] = $status_aktif[$key[$value]];
							}
							//change_date_to_view
			?>
							<div class="row">
								<div class="col-md-4">
									<p><b><?=$nama?></b></p>
								</div>
								<div class="col-md-8">
									<p>
									<?php 
									if($key[$value] == "")
										echo "-";
									else
										echo nl2br($key[$value]);?>
									</p>
								</div>
							</div>
				<?php 	}	
					}?>
					<br>
											
						<!-- MODAL DELETE-->
						<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
							<form action="<?=base_url();?>data/user_login/delete" id="form_sample_1" class="form-horizontal" method="POST">
								<input type="hidden" name="user_login_id" value="<?=$data['id']?>"/>
						
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title"><b>DELETE</b></h4>
										</div>
										<div class="modal-body"> Yakin hapus <?=$key['user_login_nama']?></div>
										<div class="modal-footer">
											<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
											<button type="submit" class="btn red">OK</button>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
							</form>
							<!-- /.modal-dialog -->
						</div>
						<!-- MODAL DELETE-->
					</div>
				<!-- END FORM-->
				</div>	
			</div>
                                

                     
