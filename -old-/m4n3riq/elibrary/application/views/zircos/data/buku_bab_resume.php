<?php
	//// REQUEST
	if($this->input->get('kelas')){
		$kelas_id = $this->input->get('kelas');
	}else{
		$kelas_id = '';
	}
	
	if(isset($data['data_resume']['data'])){
		$data_show = $data['data_resume']['data'];
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
								Daftar Resume
							</li>
						</ol>
					</div>
					<h4 class="page-title">Daftar Resume</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<!--
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
		-->
		
		
			<?php      
				echo alert_get();
            ?> 
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data Resume</b></h4>
					 
						<table id="datatable-buttons1" class="table table-striped table-bordered">
							
							<thead>
								<tr>
									<th> No </th>
									<th> Nama </th>
									<th> Jabatan </th>
									<th> Buku </th>
									<th> Buku Bab </th>
									<th> Resume </th>
									
									<th> Dibuat </th>
									<th> Diubah </th>
									
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
									
									<td> <?=$key['user_nama']?> </td>
									<td> <?php
										if($key['user_role']=='sdm'){
											echo 'guru';
										}else{
											echo $key['user_role'];
										}?>
										</td>
									<td> <?=$key['buku_nama']?> </td>
									<td> <?=$key['buku_bab_nama']?> </td>
									<td> <?=$key['resume_isi']?> </td>
									
									<td>  <?=$key['resume_created']?></td>
									<td>  <?=$key['resume_modified']?></td>
									
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
						
		