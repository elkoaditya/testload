<?php
	if($this->session->userdata['user']['role']=='user'){
		redirect(base_url());
	}
	
	if(isset($data['data_sdm']['data'])){
		$data_show = $data['data_sdm']['data'];
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
								Guru
							</li>
						</ol>
					</div>
					<h4 class="page-title">Guru</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data sdm</b></h4>
					 
						<table id="datatable-buttons1" class="table table-striped table-bordered">
							
							<thead>
								<tr>
									<th> No </th>
									<th> Aksi </th>
									<th> Nama </th>
									<th> Gender </th>
									<th> Telepon </th>
									<th> Alamat </th>
									<th> Buku Favorit </th>
									
									<!--<th> Jumlah Buku <br>Dibaca </th>-->
									<th> Jumlah Bab <br>Dibaca </th>
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 0;
								if(isset($data_show)){
									foreach($data_show as $value=>$key){
										$no++;
								?>
								<tr>
									<td> <?=$no?> </td>
									<td>
										<a class="btn btn-sm btn-info" href="<?=base_url();?>data/sdm/detail/<?=$key['sdm_id']?>">
										<i class="fa fa-chevron-left"></i> Detail</a>
										<?php if($crud==1){ ?>
										<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/sdm/edit/<?=$key['sdm_id']?>">
										<i class="fa fa-pencil"></i> Edit</a>
										<?php } ?>
									
									</td>
									<td> <?=$key['sdm_nama']?> </td>
									<td> <?=$key['sdm_gender']?> </td>
									<td align="center"> <?=$key['sdm_telepon']?> </td>
									<td> <?=$key['sdm_alamat']?> </td>
									<td> <?=$key['sdm_perpus_buku_favorit']?> </td>
									
									<!--<td align="center">  <?=$key['jml_baca_buku']?></td>-->
									<td align="center">  <?=$key['jml_baca_bab']?></td>
									
								</tr>
							<?php  
									}
								}?>
								
							</tbody>
						</table>
						
									
						
				</div>
			</div>
		</div>
<script>
	$(document).ready(function () {
		$("#datatable-buttons1").DataTable({
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
	function call() {
		window.location = "<?=base_url()?>data/sdm?kelas="+document.getElementById("kelas_id").value;
	}
	
</script>				
						
		