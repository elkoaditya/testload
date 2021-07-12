<?php
/// CEK ADMIN
	if(isset( $this->session->userdata['user']['id'])){
		
		if(($this->session->userdata['user']['role'] != 'super_admin') && ($this->session->userdata['user']['role'] != 'admin')){
			redirect(base_url(), $verifikasi);
		}
		
	}
?>
<div class="wrapper">
	<div class="container">

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							
							<li class="active">
								User Login
							</li>
						</ol>
					</div>
					<h4 class="page-title">User Login</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-4">
			 <a class="btn btn-primary waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/user_login/input_new"><i class="fa fa-plus"></i> Tambah User Login</a>
			</div>
		</div>
		<?php      
				echo alert_get();
            ?>

		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data User Login</b></h4>
					

					<table id="datatable-buttons" class="table table-striped table-bordered">
						
						<thead>
							<tr>
								<th> No </th>
								<th> Username </th>
								<th> Jabatan </th>
								<th> Aktif </th>
								<th> Aksi </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
								foreach($data['data_user_login']['data'] as $value=>$key){
									$no++;
							?>
							<tr>
								<td> <?=$no?> </td>
								<td> <?=$key['login_username']?> </td>
								<td> <?=$key['login_role_nama']?> </td>
								<td> <?=$key['login_aktif']?> </td>
								<td>   
								<?php if(($this->session->userdata['user']['role'] != 'super_admin')&&($key['login_role_id'] == 1)) {?>
								<?php }else{?>
									<a class="btn btn-info btn-sm " href="<?=base_url();?>data/user_login/detail/<?=$key['login_id']?>">
									<i class="fa fa-chevron-left"></i> Detail</a>
									<a class="btn btn-warning btn-sm " href="<?=base_url();?>data/user_login/edit/<?=$key['login_id']?>">
									<i class="fa fa-pencil"></i> Edit</a>
									<?php if($key['login_role_id'] != 1){ ?>
										<a class="delete btn btn-sm btn-danger" data-toggle="modal" href="#basic<?=$no?>">
										<i class="fa fa-trash"></i> Hapus</a>
									<?php } 
								}?>
								</td>
								
								<!-- MODAL DELETE -->
								<div class="modal fade" id="basic<?=$no?>" tabindex="-1" role="basic" aria-hidden="true">
									<form action="<?=base_url();?>data/user_login/delete" id="form_sample_1" class="form-horizontal" method="POST">
										<input type="hidden" name="user_login_id" value="<?=$key['login_id']?>"/>
								
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h4 class="modal-title"><b>DELETE</b></h4>
												</div>
												<div class="modal-body"> Yakin hapus <?=$key['login_username']?></div>
												<div class="modal-footer">
													<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
													<button type="submit" class="btn red">OK</button>
												</div>
											</div>
											
										</div>
									</form>
									
								</div>
								<!-- MODAL DELETE-->
								
								</td>
							</tr>
						<?php } ?>
							
						</tbody>
					</table>
					<?php 
					//print_r($data);
					?>
						
				</div>
			</div>
		</div>
				
		