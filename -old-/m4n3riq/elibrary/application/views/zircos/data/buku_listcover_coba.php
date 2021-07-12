<?php
	$crud=1;
	if( $this->session->userdata['user']['role'] == 'user' ){
		$crud=0;
	}
	
	if(isset($data['data_buku']['data'])){
		$data_show = $data['data_buku']['data'];
	}
	
	///// CRUD
	$crud = 0 ;
	if($this->session->userdata['user']['role']=='super_admin'){
		$crud = 1 ;
	}
	
	// REQUEST GET
	$req_uri ='';
	$REQUEST_URI = explode('?',$_SERVER['REQUEST_URI']);
	if(isset($REQUEST_URI[1])){
		$req_uri = '?'.$REQUEST_URI[1];
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
		
		<div class="row">
			<div class="col-md-12">
				<div class="card-box">
					<div class="row">
						
						
						<form class="form-inline" action="<?=base_url();?>data/buku/listcover_simple" method="GET" >
							<div class="form-group m-r-10">
								<button type="button" id="tag_buku" class="btn btn-info btn-custom waves-effect waves-light btn-sm" onclick="tagHideShow()">Cari Tag Buku</button>
							</div>
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Judul</label>
								<input type="text" name="judul" class="form-control" id="judul" value="<?=$this->input->get('judul')?>" >
							</div>
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Pengarang</label>
								<input type="text" name="pengarang" class="form-control" id="pengarang" value="<?=$this->input->get('pengarang')?>">
							</div>
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Penerbit</label>
								<input type="text" name="penerbit" class="form-control" id="penerbit" value="<?=$this->input->get('penerbit')?>">
							</div>
							
							<?php
							$var_urut = array(
								"asc" 		=> "A - Z",
								"desc" 		=> "Z - A",
								//"populer"	=> "Terpopuler"
								);
							?>
							<div class="form-group m-r-10">
								<label for="exampleInputName2">Urut</label>
								<select class="form-control " id="urut" name="urut">
									<?php
									foreach($var_urut as $index => $label){
										$selected ='';
										if($this->input->get('urut')==$index)
										{   $selected = 'selected';	}
										?>
										<option value="<?=$index?>" <?=$selected?>> <?=$label?> </option>
									<?php
									}?>
									
								</select>
							</div>
							<button type="submit" class="btn btn-success btn-custom waves-effect waves-light btn-sm">
								Cari
							</button>
							
							<!---- TAG ---------->
							<div style="display: none;" id='tag_search' class="row m-t-10">
								
								<div class="col-md-11">
									<div class="button-list">
										<div class="btn-switch btn-switch-custom btn-block ">
											<?php
											$checked ='';
											if($this->input->get('tag_all'))
											{   $checked = 'checked';	}
											?>
											<input name="tag_all" id="tag_all"  type="checkbox"
												   <?=$checked?> onchange="call_tag_all()"/>
											<label for="tag_all"
												   class="btn btn-block btn-xs btn-rounded btn-custom waves-effect waves-light m-b-20" >
												<em class="glyphicon glyphicon-ok"></em>
												<strong> Semua Tag </strong>
											</label>
										</div>
									</div>
								</div>
							<?php
								$jml=0;
								foreach($data['data_tag']['data'] as $value=>$key) {
									$jml++;?>
									<div class="col-md-2">
										<div class="button-list">
											<div class="btn-switch btn-switch-custom">
												<?php
												$checked ='';
												if($this->input->get('tag_'.$key['tag_id']))
												{   $checked = 'checked';	}
												?>
												<input name="tag_<?=$key['tag_id']?>" id="tag_<?=$key['tag_id']?>"  type="checkbox"
													   <?=$checked?>/>
												<label for="tag_<?=$key['tag_id']?>"
													   class="btn btn-xs btn-rounded btn-custom waves-effect waves-light m-b-20" >
													<em class="glyphicon glyphicon-ok"></em>
													<strong> <?=$key['tag_nama']?> </strong>
												</label>
											</div>
										</div>
									</div>
							<?php
								}
							?>
							</div>
						</form>
							
							
						
						
						<!--
						<form action="<?=base_url();?>data/buku/listcover_simple" method="GET" >
							<div class="form-group">
								<label class="col-md-1 "><h5><b>Judul</b></h5></label>
								<div class="col-md-2">
									<input type="input" name="buku_nama" class="form-control" data-size="sm">
								</div>
								<div class="col-md-1"></div>
								<label class="col-md-1 "><h5><b>Penerbit</b></h5></label>
								<div class="col-md-2">
									<input type="input" name="buku_penerbit" class="form-control" data-size="sm">
								</div>
								<div class="col-md-1"></div>
								<div class="col-md-2">
									<button id="tag_buku" class="btn btn-info btn-rounded w-md waves-effect waves-light m-b-5">Tag Buku</button>
								</div>
								<div class="col-md-1"></div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-5">Cari</button>
											
								</div>
							</div>
						</form>-->
						
					</div>
				</div>
			 </div>
			
		</div>
			<?php      
				echo alert_get();
            ?> 
			
			
            <?php
			$no=0;
			if(isset($data_show)){
				foreach($data_show as $value=>$key){
					$no++;
					$image = base_url().'content/images/cover_buku/book_blank.png';
					if($key['buku_cover'] != ""){ 
						$image = base_url().'content/upload/cover/'.$key['buku_cover'];
					}
					
					if($no==1)
					{?>
						<div class="row port m-b-20">
							<div class="portfolioContainer">
						<?php
					}									
						?>
						<div class="col-sm-6 col-md-3 natural personal">
							<div class="media latest-post-item" style="margin-bottom:5px">
							
								<a href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
							
								<div class="card-box" style="margin:-20px">
									<div class="media-left">
										 <img class="media-object" alt="64x64" src="<?=$image?>" style="width: 100px; "> 
									</div>
									<div class="media-body">
										<h4>
											
											<?=$key['buku_nama']?> 
										</h4>
										<p class="font-13 text-muted">
											<?php
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
										</p>
									</div>
								</div>
								
								</a>
								
							</div>
						</div>
						<!--
							   <div class="col-sm-6 col-md-2 natural personal">
									<div class="thumb">
										<a class="btn btn-sm btn-info" href="<?=base_url();?>data/buku/detail/<?=$key['buku_id']?>">
											<img src="<?=$image?>" class="thumb-img" alt="work-thumbnail">
										</a>
										<div class="gal-detail">
											<h4><?=$key['buku_nama']?></h4>
											<p class="text-muted">
												<?php
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
											</p>
										</div>
									</div>
								</div>
							-->
						<?php 
					
					if($no==4)
					{?>
							</div>
						</div>
						<?php
					
						$no=0;
					}
				}
			}
		
		
		if($no!=0)
		{?>
				</div>
			</div>
			<?php
		}
		
					
		$max_data = $data['max_buku']['max_data'];
		/*
		echo $data['limit'];
		echo '<br>'.$max_data;
		echo '<br>'.$data['offset'];*/
		?>
		<div class="row port m-b-20">
			<div class="portfolioContainer">
				<div class="text-right">
					<ul class="pagination pagination-split">
						<?php 
						
						$page_first='';
						if($data['offset']==0){
							$page_first='class="disabled"';
						}
							?>
						<li <?=$page_first?>>
							<a href="<?=base_url("data/buku/listcover_simple".$req_uri)?>"> < </a>
						</li>
						
						<?php 
						$no=0;
						$offset=0;
						while($max_data>0){
							$max_data = $max_data - $data['limit'];
							$no++;
							$page_active ='';
							if($data['offset']==$offset){
								$page_active = 'class="active"';
							}
							?>
							<li <?=$page_active?>>
								<a href="<?=base_url("data/buku/listcover_simple/".$data['limit']."/".$offset.$req_uri)?>"><?=$no?></a>
							</li>
							<?php
							$offset = $offset + $data['limit'];
						}
						
						
						$page_last='';
						$offset = $offset - $data['limit'];
						if($data['offset']==$offset){
							$page_last='class="disabled"';
						}
							?>
						<li <?=$page_last?>>
							<a href="<?=base_url("data/buku/listcover_simple/".$data['limit']."/".$offset.$req_uri)?>"> > </a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div id="write">
		</div>
		
	</div>
</div>


<script>
	function tagHideShow()
    {	
		if(document.getElementById("tag_search").style.display=="none"){
			document.getElementById("tag_search").style.display="block";
		}else{
			document.getElementById("tag_search").style.display="none"; 
		}
	}
	
	function call_tag_all() {
		<?php
		$jml=0;
		foreach($data['data_tag']['data'] as $value=>$key) {
			$jml++;?>
			document.getElementById("tag_<?=$key['tag_id']?>").checked = document.getElementById("tag_all").checked;
		<?php
			}
		?>
		//document.getElementById("write").innerHTML = document.getElementById("tag_all").value;
	}
	
	<?php
	if($req_uri==''){
		?>
		document.getElementById("tag_all").checked = true;
		call_tag_all();
		<?php
	}?>
	
</script>	
				
		