<?php 
	$jml=0;
	
	$form = array(
		array(
			'label'			=> 'Nama',
			'placeholder'	=> 'nama',
			'name'			=> 'buku_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'Pengarang',
			'placeholder'	=> 'pengarang',
			'name'			=> 'buku_pengarang',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'Penerbit',
			'placeholder'	=> 'penerbit',
			'name'			=> 'buku_penerbit',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'No Seri',
			'placeholder'	=> 'no seri',
			'name'			=> 'buku_no_seri',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'Jumlah Bab',
			'placeholder'	=> 'bab',
			'name'			=> 'buku_jml_bab',
			'help'			=> '---',
			'value'			=> '',
		),
		
		
	);
	
	if(isset($data['data_buku']['data'])){
		foreach($data['data_buku']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form as $f)
			{
				$form[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
	}
	
	if(isset($data['data_buku_tag']['data'])){	
		$i=1;
		foreach($data['data_buku_tag']['data'] as $value=>$key){
			$i++;
			$form_tag[$key['tag_id']] = $key['tag_nama'];
			
		}
		$show_tembusan		= $i;
		?>
		<script>
			var show_tembusan=<?=$i?>;
		</script>
		<?php
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
								 <a href="<?=base_url();?>/data/buku">Buku Perpustakaan</a>
							</li>
							<li class="active">
								Form Buku Perpustakaan
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form Buku Perpustakaan</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku"><i class="fa fa-chevron-left"></i> Kembali Buku Perpustakaan</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form Buku Perpustakaan</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/buku/save" class="form-horizontal form-row-seperated" method="POST" enctype="multipart/form-data">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="buku_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<div class="form-group">
										<label class="col-md-3 control-label">Cover</label>
										<div class="col-md-8">
											<input type="file" name="buku_cover" class="filestyle" data-size="sm">
										</div>
										
									</div>	
									
									<div class="form-group">
										<label class="col-md-3 control-label">Tag</label>
										<div class="col-md-8">
											<div class="row">
											<?php
												$jml=0;
												foreach($data['data_tag']['data'] as $value=>$key) {
													$jml++;?>
													<div class="col-md-4">
														<div class="button-list">
															<div class="btn-switch btn-switch-custom">
																<?php
																$checked ='';
																if(isset($form_tag[$key['tag_id']]))
																{   $checked = 'checked';}
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
										</div>
									</div>	
									
									<?php
										foreach($form as $f){
											echo form_input_text1($f);
										};?>
									
									<?php //echo form_input_text1($form[1]);?>
									<br>
									
									
								
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light m-b-5">Simpan</button>
										</div>
									</div>
								</div>
							
							</form>
						</div>
					</div>
				
				</div>
			</div>
		</div>
               
