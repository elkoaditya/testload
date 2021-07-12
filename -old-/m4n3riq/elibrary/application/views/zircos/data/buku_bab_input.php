<?php 
	$jml=0;
	
	$form = array(
		array(
			'label'			=> 'Nama',
			'placeholder'	=> 'nama',
			'name'			=> 'buku_bab_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		array(
			'label'			=> 'Jumlah Halaman',
			'placeholder'	=> 'halaman',
			'name'			=> 'buku_bab_jml_halaman',
			'help'			=> '---',
			'value'			=> '',
		),
		
	);
	
	if(isset($data['buku_id'])){
		$buku_id = $data['buku_id'];
	}
	if(isset($data['data_buku_bab']['data'])){
		foreach($data['data_buku_bab']['data'] as $value=>$key)
		{
			$jml=0;
			$buku_id = $key['buku_bab_buku_id'];
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
								 <a href="<?=base_url();?>/data/buku/detail/<?=$buku_id;?>">Buku</a>
							</li>
							<li class="active">
								Form Bab Buku
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form Bab Buku</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku/detail/<?=$buku_id;?>"><i class="fa fa-chevron-left"></i> Kembali Buku</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form Bab Buku</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/buku_bab/save" class="form-horizontal form-row-seperated" method="POST" enctype="multipart/form-data">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="buku_bab_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<input type="hidden" name="buku_bab_buku_id" value="<?=$buku_id;?>"/>
									<div class="form-group">
										<label class="col-md-3 control-label">File Pdf</label>
										<div class="col-md-8">
											<input type="file" name="buku_bab_file" class="filestyle" data-size="sm">
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
               
