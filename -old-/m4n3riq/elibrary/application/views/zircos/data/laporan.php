<?php

	$bulan = bulan();
	
	if($this->input->get('bulan')){
		$get_bulan = $this->input->get('bulan');
	}else{
		$get_bulan = date("m");
	}
	
	if($this->input->get('tahun')){
		$get_tahun = $this->input->get('tahun');
	}else{
		$get_tahun = date("Y");
	}
	
	if(isset($data['data_kelas']['data'])){
		$data_show = $data['data_kelas']['data'];
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
								Laporan Orang tua
							</li>
						</ol>
					</div>
					<h4 class="page-title">Laporan</h4>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="card-box">
					<div class="row">
						<form class="form-inline" >
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Bulan</label>
								<select class="form-control " id="bulan" name="bulan" onchange="call()">
									
									<?php
									foreach($bulan as $index => $value)
									{
										$selected ='';
										if($get_bulan == $index)
										{	$selected = 'selected';	}
										?><option value="<?=$index?>" <?=$selected?>> <?=$value?> </option><?php
									}?>
								</select>
							</div>
							
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Tahun</label>
								<select class="form-control " id="tahun" name="tahun" onchange="call()">
									
									<?php
									$tahun = '2017';
									while($tahun <= date("Y"))
									{
										$selected ='';
										if($get_tahun == $tahun)
										{	$selected = 'selected';	}
										?><option value="<?=$tahun?>" <?=$selected?>> <?=$tahun?> </option><?php
										$tahun++;
									}?>
								</select>
							</div>
							
						</form>
					
					</div>
				</div>
			</div>
		</div>
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
									<th> Kelas </th>
									<th> Laporan </th>
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
											<td><?=$key['nama']?></td>
											<td> 
												<a href="<?=base_url("data/laporan/siswa_baca_excel/".$key['id']."/".$get_bulan."/".$get_tahun)?>" 
												class="btn btn-sm btn-success"> Download Laporan</a> </td>
										</tr>
										<?php
									}
								}?>
							</tbody>
						</table>
						
									
						
				</div>
			</div>
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
		window.location = "<?=base_url()?>data/laporan?bulan="+document.getElementById("bulan").value
		+"&tahun="+document.getElementById("tahun").value;
	}
	
</script>			