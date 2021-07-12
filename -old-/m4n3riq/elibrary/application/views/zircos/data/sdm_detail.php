<script src="<?=base_url()?>assets/third_party/highchart/highcharts.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/series-label.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/exporting.js"></script>
<script src="<?=base_url()?>assets/third_party/highchart/modules/export-data.js"></script>


<style type="css">
	#container {
		min-width: 310px;
		max-width: 800px;
		height: 600px;
		margin: 0 auto
	}
	
	
</style>
<?php 
	if(( $this->session->userdata['user']['role'] == 'user' )&&( $this->session->userdata['user']['id'] != $data['data_sdm']['data'][1]['sdm_id'] )){
		redirect(base_url()."data/sdm/detail/".$this->session->userdata['user']['id']);
	}
	
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	$detail = array(
			'sdm_nama'				=> 'Nama',
			'sdm_gender'				=> 'Gender',
			'sdm_telepon'				=> 'Telepon',
			'sdm_alamat'				=> 'Alamat',
			'sdm_perpus_buku_favorit' => 'Buku Favorit',
			
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
								 <a href="<?=base_url();?>/data/sdm">Guru Membaca</a>
							</li>
							<li class="active">
								Detail Guru Membaca
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Detail Guru Membaca</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		

			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/sdm"><i class="fa fa-chevron-left"></i> Kembali</a>
				</div>
				
				<div class="col-md-8" align="right">
					<?php if($crud==1){ ?>
					<a class="btn btn-warning waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/sdm/edit/<?=$data['id']?>">
					<i class="fa fa-pencil"></i> Edit</a>
					<?php } ?>
					<!--
					<a class="delete btn btn-danger waves-effect w-md waves-light m-b-5" data-toggle="modal" href="#basic">
					<i class="fa fa-trash"></i> Hapus</a>-->
				</div>
				
				
				
			</div>
			<div class="row">
				<?php
					
					foreach($data['data_sdm']['data'] as $value_di=>$key){
						
						?>
				<div class="col-sm-4">
				
					<div class="row">
						<div class="col-sm-1"></div>
							<div class="col-sm-10" align="center">
							
							<div class="card-box ">
									<?php 
									$image = base_url().'content/images/sdm/user_default.png';
									if($key['sdm_perpus_foto'] != ""){ 
										$image = base_url().'content/upload/avatar/'.$key['sdm_perpus_foto'];
									}
									?>
									<img class="media-object" alt="64x64" src="<?=$image?>" 
									style="width: 150px; ">
									
								</div>
						</div>
					</div>
				
				</div>
				<div class="col-sm-7">
					<div class="card-box table-responsive">
						<?php
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
						<?php
						}
						?>
					<br>
											
						<!-- MODAL DELETE-->
						<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
							<form action="<?=base_url();?>data/sdm/delete" id="form_sample_1" class="form-horizontal" method="POST">
								<input type="hidden" name="sdm_id" value="<?=$data['id']?>"/>
						
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title"><b>DELETE</b></h4>
										</div>
										<div class="modal-body"> Yakin hapus <b><?=$key['sdm_nama']?></b></div>
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
				 <?php 		
					}?>
			</div>
           
			<h3> Grafik Membaca </h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
							<div id="container_buku"></div>
					</div>
				</div>
			</div>
		
			<h3> Detail Membaca </h3>
			<div class="row">
				<div class="col-sm-12">		
					<div class="card-box table-responsive">
						<table id="datatable-buttons1" class="table table-striped table-bordered">
											
							<thead>
								<tr>
									<th> No </th>
									<th> Buku </th>
									<th> Bab </th>
									<th> Lama Terakhir baca </th>
									<th> Terakhir baca </th>
									<th> Jumlah di baca </th>
									<th> Jumlah Waktu baca </th>
									<th> Pertama baca </th>
								</tr>
									
							</thead>
							
							<tbody>
								<?php 
								
								$no=0;
					
								if(isset($data['data_sdm_baca']['data'])){
									foreach($data['data_sdm_baca']['data'] as $value_di=>$key){
										//////////////// buku /////////
										$no++;?>
								<tr>
									<td> <?=$no?> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
														 <?=$key['buku_nama']?></a> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail/<?=$key['buku_bab_id']?>">
														 <?=$key['buku_bab_nama']?></a> </td>
									
									<td> <?=detikToPukul($key['total_waktu'] - $key['total_waktu_lalu'])?> </td>
									<td> <?=tgl_resmi($key['read_last'])?> </td>
									<td> <?=$key['jumlah_akses']?> kali</td>
									<td> <?=detikToPukul($key['total_waktu'])?> </td>
									<td> <?=tgl_resmi($key['read_first'])?> </td>
									
								</tr>
								<?php }
								}?>
							</tbody>
						</table>
						<script type="text/javascript">
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
							</script>
					</div>
				</div>
			</div>

<script>
	Highcharts.chart('container_buku', {
		chart: {
			zoomType: 'x'
		},
		title: {
			text: 'Jumlah buku dibaca perhari'
		},
		subtitle: {
			text: document.ontouchstart === undefined ?
					'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
		},
		xAxis: {
			type: 'datetime'
		},
		yAxis: {
			title: {
				text: 'Jumlah buku'
			}
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			area: {
				fillColor: {
					linearGradient: {
						x1: 0,
						y1: 0,
						x2: 0,
						y2: 1
					},
					stops: [
						[0, Highcharts.getOptions().colors[2]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[2]).setOpacity(0).get('rgba')]
					]
				},
				marker: {
					radius: 2
				},
				lineWidth: 1,
				states: {
					hover: {
						lineWidth: 1
					}
				},
				threshold: null
			}
		},

		series: [{
			type: 'area',
			name: 'Buku',
			data: [<?php 
			$no=0;
			foreach($data['data_grafik']['buku'] as $buku){
				if($no>0){
					echo ',['.$buku[0].','.$buku[1].']';
				}else{
					echo '['.$buku[0].','.$buku[1].']';
				}
				$no++;
			};?>]
		}]
	});
	
</script>                     
