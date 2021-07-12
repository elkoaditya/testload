<?php
	if($this->session->userdata['user']['role']=='user'){
		redirect(base_url());
	}

	//// REQUEST
	if($this->input->get('kelas')){
		$kelas_id = $this->input->get('kelas');
	}else{
		$kelas_id = '';
	}
	
	if(isset($data['data_siswa']['data'])){
		$data_show = $data['data_siswa']['data'];
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
								Siswa
							</li>
						</ol>
					</div>
					<h4 class="page-title">Siswa</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="card-box">
					<div class="row">
						<form class="form-inline" >
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Kelas Tampil</label>
								<select class="form-control " id="kelas_id" name="kelas_id" onchange="call()">
									<option value="0">- Semua Kelas -</option>';
									<?php
									foreach($data['data_kelas']['data'] as $select)
									{
										$selected ='';
										if($kelas_id==$select['id'])
										{	$selected = 'selected';	}
										?><option value="<?=$select['id']?>" <?=$selected?>><?=$select['nama']?></option><?php
									}?>
								</select>
								</div>
							
						</form>
					
					</div>
				</div>
			</div>
		</div>
		<!--
		<div class="row">
			<div class="col-md-9">
				<div class="card-box">
					<div class="row">
						<div class="form-group">
							
							<div class="col-md-1"></div>
							<label class="col-md-1 "><h5><b>Kelas</b></h5></label>
							<div class="col-md-3">
							<select class="form-control " id="kelas_id" name="kelas_id" onchange="call()">
								<option value="0">- semua -</option>';
								<?php
								foreach($data['data_kelas']['data'] as $select)
								{
									$selected ='';
									if($kelas_id==$select['id'])
									{	$selected = 'selected';	}
									?><option value="<?=$select['id']?>" <?=$selected?>><?=$select['nama']?></option><?php
								}?>
							</select>
							</div>
						</div>
					</div>
				</div>
			 </div>
			
		</div>-->
		
		
			<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Siswa</b></h4>
					 
						<table id="datatable-buttons1" class="table table-striped table-bordered">
							
							<thead>
								<tr>
									<th> No </th>
									<th> Aksi </th>
									<th> NIS </th>
									<th> Nama </th>
									<th> Kelas </th>
									<th> Gender </th>
									<!--<th> Telepon </th>
									<th> Alamat </th>-->
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
										<a class="btn btn-sm btn-info" href="<?=base_url();?>data/siswa/detail/<?=$key['siswa_id']?>">
										<i class="fa fa-chevron-left"></i> Detail</a>
										<?php if($crud==1){ ?>
										<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/siswa/edit/<?=$key['siswa_id']?>">
										<i class="fa fa-pencil"></i> Edit</a>
										<?php } ?>
									
									</td>
									<td align="center"> <?=$key['siswa_nis']?> </td>
									<td> <?=$key['siswa_nama']?> </td>
									<td align="center"> <?=$key['siswa_kelas']?> </td>
									<td> <?=$key['siswa_gender']?> </td>
									<!--<td align="center"> <?=$key['siswa_telepon']?> </td>
									<td> <?=$key['siswa_alamat']?> </td>-->
									<td> <?=$key['siswa_perpus_buku_favorit']?> </td>
									
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
		window.location = "<?=base_url()?>data/siswa?kelas="+document.getElementById("kelas_id").value;
	}
	
</script>				
						
		