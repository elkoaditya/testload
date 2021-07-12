<?php
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	if(isset($data['data_tag']['data'])){
		$data_show = $data['data_tag']['data'];
	}
	
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
							
							<li class="active">
								Tag Buku
							</li>
						</ol>
					</div>
					<h4 class="page-title">Tag Buku</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		
		<div class="row">
			<?php
				if($crud==1){ ?>
				<div class="col-md-3">
				 <a class="btn btn-primary waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/tag/input_new"><i class="fa fa-plus"></i> Tambah tag Buku</a>
				</div>
				<div class="col-md-3">
				 <a class="btn btn-success waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/tag/excel_input">
				 <i class="fa fa-file-excel-o"></i> Tambah by Excel</a>
				</div>
			<?php }?>
		</div>
			<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Tag Buku</b></h4>
					

									<table id="datatable-buttons" class="table table-striped table-bordered">
										
										<thead>
											<tr>
												<th> No </th>
												<th> Nama </th>
												
												<th> Aksi </th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 0;
											if(isset($data['data_tag']['data'])){
												foreach($data_show as $value=>$key){
													$no++;
											?>
											<tr>
												<td> <?=$no?> </td>
												<td> <?=$key['tag_nama']?> </td>
												
												<td>  
												<a class="btn btn-sm btn-info" href="<?=base_url();?>data/tag/detail/<?=$key['tag_id']?>">
												<i class="fa fa-chevron-left"></i> Detail</a>
												
												<?php
												if($crud==1){ ?>
												<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/tag/edit/<?=$key['tag_id']?>">
												<i class="fa fa-pencil"></i> Edit</a>
												
												<a class="delete btn btn-sm btn-danger" data-toggle="modal" href="#basic_<?=$no?>">
												<i class="fa fa-trash"></i> Hapus</a></td>
												<?php } ?>
												<!-- MODAL DELETE-->
												<div class="modal fade" id="basic_<?=$no?>" tabindex="-1" role="basic" aria-hidden="true">
													<form action="<?=base_url();?>data/tag/delete" id="form_sample_1" class="form-horizontal" method="POST">
														<input type="hidden" name="tag_id" value="<?=$key['tag_id']?>"/>
												
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
													
												</div>
												<!-- MODAL DELETE-->
												
												</td>
											</tr>
											<?php  }
											}?>
											
										</tbody>
									</table>
									
					
						
				</div>
			</div>
		</div>
		
	</div>
</div>
				
		