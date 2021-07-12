<?php 
	$jml=0;
	
	$form = array(
		array(
			'label'			=> 'NIS',
			'placeholder'	=> 'nis',
			'name'			=> 'siswa_nis',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		array(
			'label'			=> 'Nama',
			'placeholder'	=> 'nama',
			'name'			=> 'siswa_nama',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		array(
			'label'			=> 'Kelas',
			'placeholder'	=> 'kelas',
			'name'			=> 'siswa_kelas',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		array(
			'label'			=> 'Gender',
			'placeholder'	=> 'gender',
			'name'			=> 'siswa_gender',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		/*
		array(
			'label'			=> 'Telepon',
			'placeholder'	=> 'telepon',
			'name'			=> 'siswa_telepon',
			'help'			=> '---',
			'value'			=> '',
		),
		
		array(
			'label'			=> 'Alamat',
			'placeholder'	=> 'alamat',
			'name'			=> 'siswa_alamat',
			'help'			=> '---',
			'value'			=> '',
		),
		*/
		
		array(
			'label'			=> 'Buku Favorit',
			'placeholder'	=> 'buku favorit',
			'name'			=> 'siswa_perpus_buku_favorit',
			'help'			=> '---',
			'value'			=> '',
		),
		
		
	);
	
	if(isset($data['data_siswa']['data'])){
		foreach($data['data_siswa']['data'] as $value=>$key)
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
								 <a href="<?=base_url();?>/data/siswa">Siswa</a>
							</li>
							<li class="active">
								Form Siswa
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form Siswa</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa"><i class="fa fa-chevron-left"></i> Kembali siswa Perpustakaan</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form siswa Perpustakaan</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/siswa/save" class="form-horizontal form-row-seperated" method="POST" enctype="multipart/form-data">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="siswa_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<div class="form-group">
										<label class="col-md-3 control-label">Foto</label>
										<div class="col-md-8">
											<input type="file" name="siswa_perpus_foto" class="filestyle" data-size="sm">
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
               
