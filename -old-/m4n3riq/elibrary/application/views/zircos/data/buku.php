<?php
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	if(isset($data['data_buku_aktif']['data'])){
		$data_show[0] = $data['data_buku_aktif']['data'];
	}
	if(isset($data['data_buku_pensiun']['data'])){
		$data_show[1] = $data['data_buku_pensiun']['data'];
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
								Buku Perpustakaan
							</li>
						</ol>
					</div>
					<h4 class="page-title">Buku Perpustakaan</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		
		<div class="row">
			<?php
				if($crud==1){ ?>
			<div class="col-md-3">
			 <a class="btn btn-primary waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku/input_new"><i class="fa fa-plus"></i> Tambah Buku Perpustakaan</a>
			</div>
			
			<div class="col-md-3">
			 <a class="btn btn-success waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku/excel_input">
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
					<h4 class="m-t-0 header-title"><b>Data Buku</b></h4>
						<?php
						$tampil='';
						if($crud==0){ 
							$tampil='style="display:none"';
						}?>
					 <ul class="nav nav-pills nav-justified" <?=$tampil?>>
                             <?php
                             $data_active = array(
                                 0   =>"AKTIF",
                                 1   =>"HAPUS",
                             );
                             $active_tab2 = "active";
                             $expanded_tab2 = "true";
                             foreach ($data_active as $value_act => $title_act){

                                 ?>
                                 <li class="<?= $active_tab2 ?>">
                                     <a href="#<?= $value_act ?>" data-toggle="tab"
                                        aria-expanded="<?= $expanded_tab2 ?>">
                                         <span class="visible-xs"><i class="fa fa-home"></i></span>
                                         <span class="hidden-xs"><?=$title_act?></span>
                                     </a>
                                 </li>
                                 <?php
                                 $active_tab2 = "";
                                 $expanded_tab2 = "false";
                             }
                             ?>
                         </ul>
						  <div class="tab-content">
                            <?php
                            $active_tab2 = "active";
                            $expanded_tab2 = "true";
                            foreach ($data_active as $value_act => $title_act) {

                                ?>
                                <div class="tab-pane <?= $active_tab2 ?>"
                                     id="<?= $value_act ?>">


									<table id="datatable-buttons<?= $value_act ?>" class="table table-striped table-bordered">
										
										<thead>
											<tr>
												<th> No </th>
												<th> Nama </th>
												<th> Penggarang </th>
												<th> Penerbit </th>
												<th> Tag Buku </th>
												
												
												<th> Aksi </th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 0;
											if(isset($data_show[$value_act])){
												foreach($data_show[$value_act] as $value=>$key){
													$no++;
											?>
											<tr>
												<td> <?=$no?> </td>
												<td> 
													<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
													<?=$key['buku_nama']?> </a>
												</td>
												<td> <?=$key['buku_pengarang']?> </td>
												<td> <?=$key['buku_penerbit']?> </td>
												<td> <?php
													$value_tag = explode(',',$key['buku_tag']);
													
													$no_tag=0;
													foreach($value_tag as $vt){
														$no_tag++;
														
														echo '<button type="button" 
														class="btn btn-xs btn-info btn-rounded w-lg waves-effect waves-light m-b-5">
														'.$vt.'</button> ';
														
														if($no_tag==3){
															echo '<br>';
															$no_tag=0;
														}
														
													}
													?>
													
								
												</td>
												
												
												<td>   
												
												<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
												<i class="fa fa-chevron-left"></i> Detail</a>
												<?php
												if($crud==1){ ?>
												
													<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/buku/edit/<?=$key['buku_id']?>">
													<i class="fa fa-pencil"></i> Edit</a>
													<?php if($value_act==0){ ?>
														<!--<a class="non_aktif btn btn-sm btn-warning" data-toggle="modal" href="#non_aktif<?=$no?>">
														<i class="fa fa-pencil"></i> Non Aktif</a>-->
													<?php }elseif($value_act==1){ ?>
														<a class="aktif btn btn-sm btn-success" data-toggle="modal" href="#aktif<?=$no?>">
														<i class="fa fa-pencil"></i> Aktif</a>
													<?php } ?>
													<a class="delete btn btn-sm btn-danger" data-toggle="modal" href="#basic<?= $value_act ?>_<?=$no?>">
													<i class="fa fa-trash"></i> Hapus</a>
													
												<?php } ?>
												</td>
												
												
												<?php if($value_act==0){ ?>
												<!-- MODAL non_aktif-->
												<div class="modal fade" id="non_aktif<?=$no?>" tabindex="-1" role="non_aktif" aria-hidden="true">
													<form action="<?=base_url();?>data/buku/edit_pensiun" id="form_sample_1" class="form-horizontal" method="POST">
														<input type="hidden" name="buku_id" value="<?=$key['buku_id']?>"/>
														<input type="hidden" name="buku_pensiun" value="1"/>
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4 class="modal-title"><b>NON AKTIF</b></h4>
																</div>
																<div class="modal-body"> Yakin mengubah NON AKTIF <b><?=$key['buku_nama']?></b></div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default btn-rounded w-md waves-effect m-b-5" data-dismiss="modal">Cancel</button>
																	<button type="submit" class="btn btn-warning btn-rounded w-md waves-effect waves-light m-b-5">OK</button>
																</div>
															</div>
															
														</div>
													</form>
												</div>
												<!-- MODAL non_aktif-->
												<?php }elseif($value_act==1){ ?>
													<!-- MODAL aktif-->
												<div class="modal fade" id="aktif<?=$no?>" tabindex="-1" role="aktif" aria-hidden="true">
													<form action="<?=base_url();?>data/buku/edit_pensiun" id="form_sample_1" class="form-horizontal" method="POST">
														<input type="hidden" name="buku_id" value="<?=$key['buku_id']?>"/>
														<input type="hidden" name="buku_pensiun" value="0"/>
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4 class="modal-title"><b>AKTIF</b></h4>
																</div>
																<div class="modal-body"> Yakin mengubah AKTIF <b><?=$key['buku_nama']?></b></div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default btn-rounded w-md waves-effect m-b-5" data-dismiss="modal">Cancel</button>
																	<button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-5">OK</button>
																</div>
															</div>
															
														</div>
													</form>
												</div>
												<!-- MODAL aktif-->
												<?php } ?>
												<!-- MODAL DELETE-->
												<div class="modal fade" id="basic<?= $value_act ?>_<?=$no?>" tabindex="-1" role="basic" aria-hidden="true">
													<form action="<?=base_url();?>data/buku/delete" id="form_sample_1" class="form-horizontal" method="POST">
														<input type="hidden" name="buku_id" value="<?=$key['buku_id']?>"/>
												
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4 class="modal-title"><b>DELETE</b></h4>
																</div>
																<div class="modal-body"> Yakin hapus <b><?=$key['buku_nama']?></b></div>
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
										<?php } 
											}?>
											
										</tbody>
									</table>
									<script type="text/javascript">
									$(document).ready(function () {
										$("#datatable-buttons<?= $value_act ?>").DataTable({
											pageLength: 50,
											dom: "Bfrtip",
											buttons: [{
												extend: "copy",
												className: "btn-sm"
											}, {
												extend: "csv",
												className: "btn-sm"
											}, {
												extend: "excel",
												className: "btn-sm"
											}, {
												extend: "pdf",
												className: "btn-sm"
											}, {
												extend: "print",
												className: "btn-sm"
											}],
											responsive: !0
										});
									});
									</script>
									<?php 
									//print_r($data);
									?>
					
                                </div>
								<?php
                                $active_tab2 = "";
                                $expanded_tab2 = "false";
                            }
                            ?>
                         </div>
						
				</div>
			</div>
		</div>
				
		