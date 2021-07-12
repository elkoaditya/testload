<?php 
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	$detail = array(
			'tag_nama'		=> 'Nama',
			'tag_modified_time'	=> 'Waktu Ditambahkan',
			'modified_username'		=> 'User Menambahkan',
	);
	
	///// CRUD
	$crud = 0 ;
	if($this->session->userdata['user']['role']=='super_admin'){
		$crud = 1 ;
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
							<li >
								 <a href="<?=base_url();?>/data/tag">tag Buku</a>
							</li>
							<li class="active">
								Detail Tag Buku
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Detail Tag Buku</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		

			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/tag"><i class="fa fa-chevron-left"></i> Kembali</a>
				</div>
				
				<div class="col-md-8" align="right">
				<?php
					if($crud==1){ ?>
					<a class="btn btn-warning waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/tag/edit/<?=$data['id']?>">
					<i class="fa fa-pencil"></i> Edit</a>
					<a class="delete btn btn-danger waves-effect w-md waves-light m-b-5" data-toggle="modal" href="#basic">
					<i class="fa fa-trash"></i> Hapus</a>
					<?php
					}?>
				</div>
				
				
				
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
					<?php
					
					foreach($data['data_tag']['data'] as $value_di=>$key){
						//////////////// ANGGOTA /////////
						foreach($detail as $value => $nama){
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
							<form action="<?=base_url();?>data/tag/delete" id="form_sample_1" class="form-horizontal" method="POST">
								<input type="hidden" name="tag_id" value="<?=$data['id']?>"/>
						
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title"><b>DELETE</b></h4>
										</div>
										<div class="modal-body"> Yakin hapus <b><?=$key['tag_nama']?></b></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default btn-rounded w-md waves-effect m-b-5" data-dismiss="modal">Cancel</button>
											<button type="submit" class="btn btn-danger btn-rounded w-md waves-effect waves-light m-b-5">OK</button>
										</div>
									</div>
								</div>
								
							</form>
							<!-- /.modal-dialog -->
						</div>
						<!-- MODAL DELETE-->
					</div>
				<!-- END FORM-->
				</div>	
			</div>
                                

                     
