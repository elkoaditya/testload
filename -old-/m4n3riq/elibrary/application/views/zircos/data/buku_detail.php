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
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	$detail = array(
			'buku_nama'		=> 'Nama',
			'buku_pengarang'		=> 'Pengarang',
			'buku_penerbit'		=> 'Penerbit',
			'buku_no_seri'		=> 'No Seri',
			'buku_jml_bab'		=> 'Jumlah Bab',
			//'buku_jml_pembaca'		=> 'Jumlah Pembaca',
			'buku_modified_time'	=> 'Waktu Ditambahkan',
			//'modified_username'		=> 'User Menambahkan',
			'buku_tag'			=> 'Tag Buku',
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
								 <a href="<?=base_url();?>/data/buku">Buku Di baca</a>
							</li>
							<li class="active">
								Detail Buku Di baca
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Detail Buku Di baca</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		

			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku"><i class="fa fa-chevron-left"></i> Kembali</a>
				</div>
				
				<?php
				if($crud==1){ ?>
					<div class="col-md-8" align="right">
						<a class="btn btn-warning waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku/edit/<?=$data['id']?>">
						<i class="fa fa-pencil"></i> Edit</a>
						<a class="delete btn btn-danger waves-effect w-md waves-light m-b-5" data-toggle="modal" href="#basic">
						<i class="fa fa-trash"></i> Hapus</a>
					</div>
				<?php }?>
				
				
				
			</div>
			<div class="row">
				<?php
				foreach($data['data_buku']['data'] as $value_di=>$key){
					//////////////// buku /////////
					$buku_id = $key['buku_id'];?>
					<div class="col-sm-4">
					
						<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-10" align="center">
								<div class="card-box ">
									<?php 
									$image = base_url().'content/images/cover_buku/book_blank.png';
									if($key['buku_cover'] != ""){ 
										$image = base_url().'content/upload/cover/'.$key['buku_cover'];
									}
									?>
									<a href="<?=$image?>" class="image-popup" title="Screenshot-1">
										<img class="media-object" alt="64x64" src="<?=$image?>" 
											style="width: 150px; ">
									</a>
									
								</div>
							</div>
						</div>
					
					</div>
					<div class="col-sm-8">
						<div class="card-box table-responsive">
						<?php
						
							foreach($detail as $value => $nama){
							?>
							<div class="row">
								<div class="col-md-4">
									<p><b><?=$nama?></b></p>
								</div>
								<div class="col-md-8">
									<p>
									<?php 
									if($value=='buku_tag'){
										$value_tag = explode(',',$key[$value]);
										?>
										<div class="row"> 
								
										<?php
										
										foreach($value_tag as $vt){
											
											echo '<div class="col-md-4"><button type="button" 
											class="btn btn-xs btn-info btn-rounded w-lg waves-effect waves-light m-b-5">
											'.$vt.'</button></div> ';
										}
										?>
										</div>
								
										<?php
									}else{
									
										if('buku_modified_time'==$value){
											$key[$value] = tgl_resmi($key[$value]);
										}
										if($key[$value] == "")
											echo "-";
										else
											echo nl2br($key[$value]);
									}?>
									</p>
								</div>
							</div>
					<?php 	}	
						?>
						
						<br>
												
							<!-- MODAL DELETE-->
							<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
								<form action="<?=base_url();?>data/buku/delete" id="form_sample_1" class="form-horizontal" method="POST">
									<input type="hidden" name="buku_id" value="<?=$data['id']?>"/>
							
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
								<!-- /.modal-dialog -->
							</div>
							<!-- MODAL DELETE-->
						</div>
					<!-- END FORM-->
					</div>	
				
				<?php 	
				}	
					?>
			</div>
             

			 <div class="row">
				<div class="col-sm-4">
					<h3> Detail Bab </h3>
				</div>
				<?php
				if($crud==1){ ?>
				<div class="col-sm-8" align="right">
					<a class="btn btn-sm btn-primary waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku_bab/input_new/<?=$buku_id?>">
					<i class="fa fa-plus"></i> Tambah Bab</a>
			
				</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-sm-12">		
					<div class="card-box table-responsive">
						<table id="datatable1" class="table table-striped table-bordered">
											
							<thead>
								<tr>
									<th> No </th>
									<th> Bab </th>
									<th> Jumlah Halaman </th>
									<th> Baca HTML</th>
									
									<?php
									if($crud==1){ ?>
										<th> Aksi </th>
									<?php } ?>
								</tr>
									
							</thead>
							
							<tbody>
								<?php 
								
								$no=0;
					
								if(isset($data['data_buku_bab']['data'])){
									foreach($data['data_buku_bab']['data'] as $value_di=>$key){
										//////////////// buku /////////
										$no++;
										?>
										<tr>
											<td> <?=$no?> </td>
											<td> 
											<!--<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail/<?=$key['buku_bab_id']?>">
														 <?=$key['buku_bab_nama']?></a> -->
											<?php 
												//$file = "http://itproject.id/buku/".$key['buku_bab_id']."/index.html";
												//$file = "http://45.114.118.131/buku_sman9/".$key['buku_bab_id']."/index.html";
												//$file = "http://45.114.118.131/buku_".APP_SUBDOMAIN."/".$key['buku_bab_id']."/index.html";
												/*$server = '45.114.118.131';
												if((APP_SUBDOMAIN == 'sma_smg2n')||(APP_SUBDOMAIN == 'sma_smg12n')){
													$server = 'itproject.id/buku/';
												}*/
												
												//$server = 'itproject.id/buku/';
												$server = 'buku.fr3sto.com/itproject.id/buku';
												$file = "http://".$server."/buku_".APP_SUBDOMAIN."/".$key['buku_bab_id']."/index.html";
												
												$file_headers = @get_headers($file);
												if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
													$exists = false;
												}
												else {
													$exists = true;
												}
												
												if($exists){
													?>
													<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail_html/<?=$key['buku_bab_id']?>">
														<?=$key['buku_bab_nama']?></a>
														 <?php
												}else{
													echo $key['buku_bab_nama']."<br/><font color='red'>*PROSES PEMBUATAN</font>";
												}
												?>
											</td>
											<td> <?=$key['buku_bab_jml_halaman']?> Halaman </td>
											
											<td> 
												<?php 
												//$filename = APP_ROOT."content/upload/html_buku_bab/".$key['buku_bab_id']."/index.html";
												
												
												//if (file_exists($filename)) {
												if($exists){
													?>
													<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku_bab/detail_html/<?=$key['buku_bab_id']?>">
														 BACA</a>
														 <?php
												}	
												?>
											</td>
											<?php
												if($crud==1){ ?>
											<td>	
												<a class="btn btn-sm btn-warning" href="<?=base_url();?>data/buku_bab/edit/<?=$key['buku_bab_id']?>">
												<i class="fa fa-pencil"></i> Edit</a>
												<a class="delete btn btn-sm btn-danger" data-toggle="modal" href="#basic_<?=$no?>">
												<i class="fa fa-trash"></i> Hapus</a>
												<!-- MODAL DELETE-->
												<div class="modal fade" id="basic_<?=$no?>" tabindex="-1" role="basic" aria-hidden="true">
													<form action="<?=base_url();?>data/buku_bab/delete" id="form_sample_1" class="form-horizontal" method="POST">
														<input type="hidden" name="buku_bab_id" value="<?=$key['buku_bab_id']?>"/>
												
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
																	<h4 class="modal-title"><b>DELETE</b></h4>
																</div>
																<div class="modal-body"> Yakin hapus <b><?=$key['buku_bab_nama']?></b></div>
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
											<?php } ?>
										</tr>
								<?php
										
									}
								}
									?>
								
								
							</tbody>
						</table>
						<script type="text/javascript">
							$(document).ready(function () {
								$("#datatable1").DataTable({
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
			<?php
			$role = $this->session->userdata['user']['role'];
								
			// HISTORY
			if($role!='user')
			{
				?>
				<h3> Grafik Buku Dibaca Guru</h3>
				<div class="row">
					<div class="col-sm-12">
						<div class="card-box table-responsive">
								<div id="container_sdm"></div>
						</div>
					</div>
				</div>
				
				<h3> Detail Buku Dibaca Guru</h3>
				<div class="row">
					<div class="col-sm-12">		
						<div class="card-box table-responsive">
							<table id="datatable" class="table table-striped table-bordered">
												
								<thead>
									<tr>
										<th> No </th>
										<th> Guru </th>
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
						
									if(isset($data['data_buku_baca_sdm']['data'])){
										foreach($data['data_buku_baca_sdm']['data'] as $value_di=>$key){
											//////////////// buku /////////
											$no++;?>
									<tr>
										<td> <?=$no?> </td>
										<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/sdm/detail/<?=$key['user_id']?>">
															 <?=$key['user_nama']?></a> </td>
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
									$("#datatable").DataTable({
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
			<?php
			}
			?>
			
			<h3> Grafik Buku Dibaca Siswa</h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
							<div id="container_siswa"></div>
					</div>
				</div>
			</div>
			
			<h3> Detail Buku Dibaca Siswa</h3>
			<div class="row">
				<div class="col-sm-12">		
					<div class="card-box table-responsive">
						<table id="datatable" class="table table-striped table-bordered">
											
							<thead>
								<tr>
									<th> No </th>
									<th> Siswa </th>
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
					
								if(isset($data['data_buku_baca_siswa']['data'])){
									foreach($data['data_buku_baca_siswa']['data'] as $value_di=>$key){
										//////////////// buku /////////
										$no++;?>
								<tr>
									<td> <?=$no?> </td>
									<td> <a class="btn btn-sm btn-info" href="<?=base_url();?>data/siswa/detail/<?=$key['user_id']?>">
														 <?=$key['user_nama']?></a> </td>
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
								$("#datatable").DataTable({
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
<?php
	if($role!='user')
	{
		?>
	Highcharts.chart('container_sdm', {
		chart: {
			zoomType: 'x'
		},
		title: {
			text: 'Jumlah guru membaca perhari'
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
				text: 'Jumlah guru'
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
						[0, Highcharts.getOptions().colors[0]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
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
			name: 'Guru',
			data: [<?php 
			$no=0;
			foreach($data['data_grafik_sdm']['user'] as $user){
				if($no>0){
					echo ',['.$user[0].','.$user[1].']';
				}else{
					echo '['.$user[0].','.$user[1].']';
				}
				$no++;
			};?>]
		}]
	});
	<?php } ?>
	
	Highcharts.chart('container_siswa', {
		chart: {
			zoomType: 'x'
		},
		title: {
			text: 'Jumlah siswa membaca perhari'
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
				text: 'Jumlah siswa'
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
						[0, Highcharts.getOptions().colors[0]],
						[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
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
			name: 'Siswa',
			data: [<?php 
			$no=0;
			foreach($data['data_grafik_siswa']['user'] as $user){
				if($no>0){
					echo ',['.$user[0].','.$user[1].']';
				}else{
					echo '['.$user[0].','.$user[1].']';
				}
				$no++;
			};?>]
		}]
	});
	
</script>