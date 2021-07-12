<?php 
	$jml=0;
	
	$form = array(
		array(
			'label'			=> 'Nama',
			'placeholder'	=> 'nama',
			'name'			=> 'grafik_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		/*
		array(
			'label'			=> 'Jabatan',
			'placeholder'	=> 'jabatan',
			'name'			=> 'grafik_jabatan',
			'help'			=> '---',
			'value'			=> '',
		),*/
		
	);
	
	if(isset($data['data_grafik']['data'])){
		foreach($data['data_grafik']['data'] as $value=>$key)
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
								 <a href="<?=base_url();?>/data/grafik">grafik Surat</a>
							</li>
							<li class="active">
								Form grafik Surat
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form grafik Surat</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/grafik"><i class="fa fa-chevron-left"></i> Kembali grafik Surat</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form grafik Surat</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/grafik/save" class="form-horizontal form-row-seperated" method="POST">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="grafik_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<?= form_input_text1($form[0]);?>
									
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
               
