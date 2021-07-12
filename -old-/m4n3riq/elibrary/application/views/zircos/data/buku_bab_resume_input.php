<?php 
	//print_r($data['data_buku_bab']['data']);
	//print_r($data['data_user']['data']);
	$role = $this->session->userdata['user']['role'];
	$jml=0;
	
	$form_buku_bab = array(
		array(
			'label'			=> 'Buku',
			'placeholder'	=> 'buku',
			'name'			=> 'buku_nama',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
		array(
			'label'			=> 'Buku Bab',
			'placeholder'	=> 'buku bab',
			'name'			=> 'buku_bab_nama',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
	);
	
	if($role == 'guru'){
		$form_user = array(
			array(
				'label'			=> 'Pembaca',
				'placeholder'	=> 'pembaca',
				'name'			=> 'sdm_nama',
				'help'			=> '---',
				'value'			=> '',
				'readonly'		=> 'readonly',
			),
		);
	}else if($role == 'user'){
		$form_user = array(
			array(
				'label'			=> 'Pembaca',
				'placeholder'	=> 'pembaca',
				'name'			=> 'siswa_nama',
				'help'			=> '---',
				'value'			=> '',
				'readonly'		=> 'readonly',
			),
		);
	}
	
	$form_resume = array(
		array(
			'label'			=> 'Resume',
			'placeholder'	=> 'resume_isi',
			'name'			=> 'resume_isi',
			'help'			=> '---',
			'value'			=> '',
			
		),
	);
	
	if(isset($data['data_buku_bab']['data'])){
		foreach($data['data_buku_bab']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form_buku_bab as $f)
			{
				$form_buku_bab[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
	}
	
	if(isset($data['data_user']['data'])){
		foreach($data['data_user']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form_user as $f)
			{
				$form_user[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
	}
	
	if(isset($data['data_resume']['data'])){
		foreach($data['data_resume']['data'] as $value=>$key)
		{
			$jml=0;
			foreach($form_resume as $f)
			{
				$form_resume[$jml]['value'] = $key[$f['name']];
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
								 <a href="<?=base_url();?>data/buku_bab/detail_html/<?=$data['buku_bab']?>">Baca Bab</a>
							</li>
							<li class="active">
								Form Resume Hasil Baca
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form Resume Hasil Baca</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/buku_bab/detail_html/<?=$data['buku_bab']?>"><i class="fa fa-chevron-left"></i> Kembali Baca Bab</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form Resume Hasil Baca</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/buku_bab/save_resume" class="form-horizontal form-row-seperated" method="POST" enctype="multipart/form-data">
			
									
									<input type="hidden" name="buku_bab_id" value="<?=$data['buku_bab'];?>"/>
									<input type="hidden" name="user_id" value="<?=$this->session->userdata['user']['id'];?>"/>
									
									<?php
										foreach($form_buku_bab as $f){
											echo form_input_text1($f);
										};
										foreach($form_user as $f){
											echo form_input_text1($f);
										};
										foreach($form_resume as $f){
											echo form_input_textarea1($f);
										};
										?>
									
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
               
