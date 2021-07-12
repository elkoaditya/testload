<?php
/// CEK SISWA
	if(isset( $this->session->userdata['user']['no_peserta'])){
		$data_siswa ='';
		if(isset($data['data_siswa']['data'])){
			$data_siswa = $data['data_siswa']['data'];
		}
		cek_siswa_bersangkutan( $this->session->userdata['user']['id'], $data_siswa);
	}
	?>
<div class="wrapper">
	<div class="container" style="margin-top:-40px">

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
								Tambah Excel Siswa
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Tambah Excel Siswa</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa"><i class="fa fa-chevron-left"></i> Kembali Siswa</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-6">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Download Excel</b></h4>
				
						<div class="row">
							<div class="col-md-12">   
								<a class="btn btn-primary btn-block waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa/excel_input/download" target="_blank">
								<i class="fa fa-download"></i> Download</a>
							</div>
						</div>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Upload Excel</b></h4>
						<div class="row">
							<div class="col-md-12">  
								<form class="form-horizontal" role="form" method="POST" 
								action="<?=base_url()."data/siswa/excel_input/upload";?>" enctype="multipart/form-data">
									<div class="form-group">
										<input type="file" name="file" class="filestyle" data-size="sm">
									</div>							
									<button class="btn btn-primary btn-block waves-effect w-md waves-light m-b-5" type="submit">
									<i class="fa fa-upload"></i> Upload</a>
								<form>
							</div>
						</div>
				</div>
			</div>
		</div>
		
		
	</div>
</div>