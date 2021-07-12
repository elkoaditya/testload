<?php
/// CEK SISWA
	if(isset( $this->session->userdata['user']['no_peserta'])){
		$data_siswa ='';
		if(isset($data['data_siswa']['data'])){
			$data_siswa = $data['data_siswa']['data'];
		}
		cek_siswa_bersangkutan( $this->session->userdata['user']['id'], $data_siswa);
	}
	?>
<div class="wrapper" >
	<div class="container" style="margin-top:-40px">

		<!-- Page-Title -->
		<div class="row">
			<div class="col-sm-12">
				<div class="page-title-box">
					<div class="btn-group pull-right">
						<ol class="breadcrumb hide-phone p-0 m-0">
							
							<li class="active">
								Daftar Ulang
							</li>
						</ol>
					</div>
					<h4 class="page-title">Daftar Ulang</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-4">
			 <a class="btn btn-primary waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa/input_new"><i class="fa fa-plus"></i> Tambah Daftar Ulang</a>
			</div>
			<div class="col-md-8" style="text-align:right">
			 <a class="btn btn-success waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa/excel_input">
			 <i class="fa fa-file-excel-o"></i> Tambah by Excel</a> &nbsp;&nbsp;
			 <a class="btn btn-purple waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa/excel_download/download">
			 <i class="fa fa-file-excel-o"></i> Download by Excel</a>
			</div>
		</div>
		<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Daftar Ulang</b></h4>
					

					<table id="datatable-buttons" class="table table-striped table-bordered">
						
						<thead>
							<tr>
								<th> No </th>
								<th> Aksi </th>
								
								<th> No. Peserta </th>
								<th> NISN </th>
								<th> NAMA </th>
								<th> TEMPAT TANGGAL LAHIR </th>
								<th> JENIS KELAMIN </th>
								<th> AGAMA </th>
								<th> Kewarganegaraan </th>
								<th> STATUS KELUARGA </th>
								<th> Anak Ke </th>
								<th> Alamat SISWA </th>
								<th> Nomer Telepon SISWA </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
							if(isset($data['data_siswa']['data'])){
								foreach($data['data_siswa']['data'] as $value=>$key){
									$no++;
							?>
							<tr>
								<td> <?=$no?> </td>
								<td>   
								
								<a class="btn btn-sm btn-info" href="<?=base_url();?>data/siswa/detail/<?=$key['siswa_id']?>">
								<i class="fa fa-chevron-left"></i> </a>
								<a class="btn btn-sm btn-purple" href="<?=base_url();?>data/siswa/print_surat/<?=$key['siswa_id']?>"
								target="_blank"><i class="fa fa-print"></i> </a>
								<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/siswa/edit/<?=$key['siswa_id']?>">
								<i class="fa fa-pencil"></i> </a>
								<a class="delete btn btn-sm btn-danger" data-toggle="modal" href="#basic<?=$no?>">
								<i class="fa fa-trash"></i> </a></td>
								
								
								<td> <?=$key['siswa_no_peserta']?> </td> 
								<td> <?=$key['siswa_nisn']?> </td>
								<td> <?=$key['siswa_nama']?> </td> 
								<td><?=$key['siswa_tempat_lahir']?> , <?=$key['siswa_tanggal_lahir']?> </td>
								<td> <?=$key['siswa_jenis_kelamin']?> </td>
								<td> <?=$key['siswa_agama']?></td>
								<td> <?=$key['siswa_kewarganegaraan']?> </td> 
								<td> <?=$key['siswa_status_keluarga']?> </td>
								<td> <?=$key['siswa_anak_ke']?> </td>
								<td> <?=$key['siswa_alamat_anak']?> </td>
								<td> <?=$key['siswa_telepon_anak']?> </td>
								
								<!-- MODAL DELETE-->
								<div class="modal fade" id="basic<?=$no?>" tabindex="-1" role="basic" aria-hidden="true">
									<form action="<?=base_url();?>data/siswa/delete" id="form_sample_1" class="form-horizontal" method="POST">
										<input type="hidden" name="siswa_id" value="<?=$key['siswa_id']?>"/>
								
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
													<h4 class="modal-title"><b>DELETE</b></h4>
												</div>
												<div class="modal-body"> Yakin hapus <b>Nama:  <?=$key['siswa_nama']?> 
												</b></div>
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
					<?php 
					//print_r($data);
					?>
						
				</div>
			</div>
		</div>
				
		