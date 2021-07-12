<?php
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	if(isset($data['data_baca_sdm']['data'])){
		$data_show_sdm 		= $data['data_baca_sdm']['data'];
	}
	if(isset($data['data_baca_siswa']['data'])){
		$data_show_siswa 	= $data['data_baca_siswa']['data'];
	}
	
	if($this->input->get('date')){
		$date_value = $this->input->get('date');
	}else{
		$date_value = date("d-m-Y");
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
								Record Baca
							</li>
						</ol>
					</div>
					<h4 class="page-title">Record Baca</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
		<div class="row">
			<div class="col-md-7" ></div>
			<div class="col-md-3" align="right">
				<div class="form-group">
					<label class="col-md-3 control-label">Tanggal</label>
					<div class="input-group">
						<input type="text" name="date" class="form-control datepicker" 
						id="date" onchange="date_call(this)"  value="<?=$date_value?>" data-mask="99-99-9999" >
						
					</div>
				</div>
				
				
			</div>
			<div class="col-md-2" >
				<a href="<?=base_url("data/baca/baca_excel/".$date_value)?>" 
					class="btn btn-sm btn-success"> Download Laporan</a>
			</div>
		</div>
		
			<?php      
				echo alert_get();
            ?> 
		<?php
		if( $this->session->userdata['user']['role'] == 'super_admin' ){
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b>Data GURU baca Buku </b></h4>
						

							<table id="datatable-buttons" class="table table-striped table-bordered">
								
								<thead>
									<tr>
										<th> No </th>
										<th> Buku </th>
										<th> Bab Buku </th>
										<th> Pembaca </th>
										
										<th> Di baca </th>
										<th> Jumlah Waktu </th>
										
										
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 0;
									if(isset($data['data_baca_sdm']['data'])){
										foreach($data_show_sdm as $value=>$key){
											$no++;
									?>
									<tr>
										<td> <?=$no?> </td>
										<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
												 <?=$key['buku_nama']?></a> </td>
										<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail/<?=$key['buku_bab_id']?>">
												 <?=$key['buku_bab_nama']?></a> </td>
										<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/sdm/detail/<?=$key['user_id']?>">
												 <?=$key['guru_nama']?> </a> </td>
										<td> <?=tgl_resmi($key['read_first'])?> </td>
										<td> <?=detikToPukul($key['total_waktu'])?> </td>
										
										
									</tr>
									<?php  }
									}?>
									
								</tbody>
							</table>
										
						
							
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title"><b>Data SISWA baca Buku </b></h4>
					

						<table id="datatable-buttons" class="table table-striped table-bordered">
							
							<thead>
								<tr>
									<th> No </th>
									<th> Buku </th>
									<th> Bab Buku </th>
									<th> Pembaca </th>
									<td> Kelas </td>
									
									<th> Di baca </th>
									<th> Jumlah Waktu </th>
									
									
									
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 0;
								if(isset($data['data_baca_siswa']['data'])){
									foreach($data_show_siswa as $value=>$key){
										$no++;
								?>
								<tr>
									<td> <?=$no?> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
											 <?=$key['buku_nama']?></a> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail/<?=$key['buku_bab_id']?>">
											 <?=$key['buku_bab_nama']?></a> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/siswa/detail/<?=$key['user_id']?>">
											 <?=$key['siswa_nama']?> </a> </td>
									<td> <?=$key['kelas_nama']?> </td>
									<td> <?=tgl_resmi($key['read_first'])?> </td>
									<td> <?=detikToPukul($key['total_waktu'])?> </td>
									
									
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

<script>
	function date_call(selectObject) {
		value = selectObject.value;	
		window.location = "<?=base_url()?>data/baca/home?date="+value;
	}
</script>				
		