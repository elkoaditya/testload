<?php 
	$jml=0;
	
	$form = array(
		
		array(
			'label'			=> 'Nama',
			'placeholder'	=> 'nama',
			'name'			=> 'sdm_nama',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		
		array(
			'label'			=> 'Gender',
			'placeholder'	=> 'gender',
			'name'			=> 'sdm_gender',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		array(
			'label'			=> 'Telepon',
			'placeholder'	=> 'telepon',
			'name'			=> 'sdm_telepon',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'Alamat',
			'placeholder'	=> 'alamat',
			'name'			=> 'sdm_alamat',
			'help'			=> '---',
			'value'			=> '',
		),
		
		
		array(
			'label'			=> 'Buku Favorit',
			'placeholder'	=> 'buku favorit',
			'name'			=> 'sdm_perpus_buku_favorit',
			'help'			=> '---',
			'value'			=> '',
		),
		
		
	);
	
	if(isset($data['data_sdm']['data'])){
		foreach($data['data_sdm']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form as $f)
			{
				$form[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
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
								 <a href="<?=base_url();?>/data/sdm">Guru</a>
							</li>
							<li class="active">
								Form Guru
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form Guru</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/sdm"><i class="fa fa-chevron-left"></i> Kembali Guru Perpustakaan</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form Guru Perpustakaan</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/sdm/save" class="form-horizontal form-row-seperated" method="POST" enctype="multipart/form-data">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="sdm_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<div class="form-group">
										<label class="col-md-3 control-label">Foto</label>
										<div class="col-md-8">
											<input type="file" name="sdm_perpus_foto" class="filestyle" data-size="sm">
										</div>
										
									</div>	
									
									
									<?php
										$no=0;
										foreach($form as $f){
											$no++;
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
               
