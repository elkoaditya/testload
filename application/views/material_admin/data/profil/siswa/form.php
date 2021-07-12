<?php
// vars

$ringkas = (strtolower($this->input->get_post('ringkas')) === 'ya');
$toggle_label = ($ringkas) ? 'Profil Ringkas' : 'Profil Detail';

//function
// komponen
// hak akses & user scope

$siswa_ybs = ($user['id'] == $row['id']);
$admin_user = cfguc_admin('akses', 'data', 'user');

$sma_terbang = (($user['role']=='sdm') && (APP_SCOPE == 'sma_terbang'));

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Admin' => 'data/profil/admin',
		"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Daftar Admin',
		'uri' => "data/profil/admin",
		'attr' => 'title="kembali ke daftar admin"',
);
$pills_kanan['detail'] = array(
		'label' => "<i class=\"icon-search\"></i> {$toggle_label}",
		'uri' => "#",
		'attr' => 'title="lihat profil detail admin ini" id="cmd-info-toggle"',
);
$pills_kanan['akun'] = array(
		'label' => '<i class="icon-key"></i> Akun Login',
		'uri' => "data/user/id/{$row['id']}",
		'attr' => 'title="ubah info user-akun sdm ini"',
		'class' => 'disabled',
);
$pills_kanan['edit'] = array(
		'label' => '<i class="icon-edit"></i> Edit',
		'uri' => "data/profil/admin/form?id={$row['id']}",
		'attr' => 'title="ubah data Admin ini"',
		'class' => 'disabled',
);

if ($admin_user)
	$pills_kanan['akun']['class'] = '';

if ($admin OR $siswa_ybs)
	$pills_kanan['edit']['class'] = 'active';

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// data tabel

$detail1 = array(
		'ID' => array('id', 'prefix' => '#'),
		'Nama' => array('nama_title'),
		'Gender' => array('gender', array('l' => 'Laki-laki', 'p' => 'Perempuan')),
		'Alamat' => 'alamat',
		'Kota' => 'kota',
		'Telepon' => 'telepon',
);

if ($admin OR $siswa_ybs)
	$detail1['Status Login'] = array('aktif', array('blokir login', 'aktif'));

// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';


$btn_back = a("data/profil/siswa", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke daftar siswa', 
'class="btn btn-info  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="back" title="kembali ke tabel" ');

$akun_login = a("data/user/id/{$row['id']}", ' <i class="zmdi zmdi-key"></i> Akun Login', 
'class="btn bgm-purple waves-effect  btn-sm m-t-10 m-b-10 m-l-10 m-r-10" id="akun_login" title="lihat akun login ini" ');

$menu_atas = '<div class="col-sm-5"  align="left"> '.$btn_back.' </div>';
if ($admin || ($user['role']=='sdm'))
{
	$menu_atas .= '<div class="col-sm-7"  align="right">
	
		<a href='.base_url().'data/profil/siswa/cover/' . $row["id"].'/pdf/k13" id="cover_k13" 
		class="btn btn-primary btn-sm btn-sm m-t-10 m-b-10 m-l-10 m-r-10" 
		title="cetak cover rapor siswa K13" target="_blank"><i class="zmdi zmdi-print"></i> Cover K13</a>
		
		<a href='.base_url().'data/profil/siswa/cover/' . $row["id"].'/pdf/ktsp" id="cover_ktsp" 
		class="btn btn-primary btn-sm btn-sm m-t-10 m-b-10 m-l-10 m-r-10" 
		title="cetak cover rapor siswa KTSP" target="_blank"><i class="zmdi zmdi-print"></i> Cover KTSP</a>
		
		'.$akun_login.'
		
	</div>';
}elseif ($admin OR $siswa_ybs OR $sma_terbang){
	$menu_atas .= '<div class="col-sm-7"  align="right">'.$akun_login.'</div>';
}

$view_data['kesiswaan'] = array(
			'N I S'	 		=> 'nis',
			'N I S N'	 	=> 'nisn',
			'Nomer U N'		=> 'no_un',
			'Kelas'		 	=> 'kelas_nama',
			'Status Login'	=> 'aktif',
		);
		
$view_data['profil'] = array(
			'Nama'	 	=> 'nama',
			'Gender'	=> 'gender',
			'Alamat'	=> 'alamat',
			'Kota'		=> 'kota',
			'Telepon'	=> 'telepon',
		);
		
$view_data['keluarga'] = array(
			'Status'	 		=> 'status_keluarga',
			'Anak ke'			=> 'anak_ke',
			'Nama Ayah'			=> 'ayah_nama',
			'Pekerjaan Ayah'	=> 'ayah_pekerjaan',
			'Nama Ibu'			=> 'ibu_nama',
			'Pekerjaan Ibu'	 	=> 'ibu_pekerjaan',
			'Alamat Orang Tua'	=> 'ortu_alamat',
			'Telepon Orang Tua'	=> 'ortu_telepon',
			'Nama Wali'			=> 'wali_nama',
			'Alamat Wali'		=> 'wali_alamat',
			'Telepon Wali'		=> 'wali_telepon',
			'Pekerjaan Wali'	=> 'wali_pekerjaan',
		);
		
$view_data['pendaftaran'] = array(
			'Jalur'	 						=> 'masuk_jalur',
			'Tanggal Daftar Masuk Sekolah'	=> 'masuk_tgl',
			'Nama Sekolah Asal'				=> 'asal_sekolah_nama',
			'Alamat Sekolah Asal'			=> 'asal_sekolah_alamat',
			'Jenjang Sekolah Asal'			=> 'asal_sekolah_jenjang',
			'Nomor Ijazah'	 				=> 'asal_ijazah_no',
			'Nomor SKHU'					=> 'asal_skhu_no',
			'Tahun Ijasah'					=> 'asal_ijazah_tahun',
		);
?>


<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Siswa')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">PROFIL SISWA</h2>

            </div>
			<?php
			echo alert_get();
			
			?>
			<div class="card">
				<div class="row">
				<?php echo $menu_atas;?>
				</div>
			</div>
			
            <div class="card" id="profile-main">
                <a href="#" id="sa-warning" class="pmop-edit">
					<div class="pm-overview c-overflow">

						<div class="pmo-pic" id="img_sample">
							<div class="p-relative">
								<?php //echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210));?>
								<?php
								$img_path= base_url().$path_foto;
								if(!file_exists($img_path))
									$img_path= base_url()."content/no-photo.jpg";?>
								<img src="<?php echo $img_path;?>" width="210" >
								<!--<i class="zmdi zmdi-camera"></i>-->
							</div>
							<!--<div class="pmo-stat">
							</div>-->
						</div>

					</div>
				</a>

                <div class="pm-body clearfix" role="tabpanel">
                    <ul class="tab-nav tn-justified" role="tablist">
                        <li class="active">
						<a href="#data_kesiswaan" aria-controls="kesiswaan" role="tab" data-toggle="tab">Kesiswaan</a></li>
						<li>
						<a href="#data_diri" aria-controls="diri" role="tab" data-toggle="tab">Diri</a></li>
						<li>
						<a href="#data_keluarga" aria-controls="keluarga" role="tab" data-toggle="tab">Keluarga</a></li>
                        <li>
						<a href="#data_pendaftaran" aria-controls="pendaftaran" role="tab" data-toggle="tab">Pendaftaran</a></li>
                        <!--<li><a href="profile-connections.html">Connections</a></li>-->
                    </ul>
					
					<?php 
					$uri_form = str_replace("id","form",$uri);
					echo form_openmp("{$uri_form}?id={$row['id']}", '');
					?>
					<div class="tab-content">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->						
						<div role="tabpanel" id="data_kesiswaan" class="tab-pane active pmb-block">
							<div class="pmbb-header">
								<h2 id="title_kesiswaan" ><i class="zmdi zmdi-account m-r-10"></i> Data Kesiswaan</h2>
								<?php
								if ($admin OR $siswa_ybs)
								{?>
							
								<ul class="actions">
									<a data-ma-action="profile-edit" href="" id="edit_kesiswaan" class="btn btn-warning btn-sm" >
									<i class="zmdi zmdi-edit"></i></a>
								</ul>
								<?php
								}?>
							</div>
							<?php
								$status_login = array(0 => 'Blokir login',1 => 'Aktif');
							?>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
									<?php 
									foreach($view_data['kesiswaan'] as $label => $value)
									{
										if ($value=='aktif')
										{
											if($admin OR $siswa_ybs)
											{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$status_login[$row[$value]]?></dd>
											</dl>
											<?php
											}
										}else
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$row[$value]?></dd>
											</dl>
											
										<?php 
										}
									} ?>
									
								</div>
								
								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">N I S</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nis"
													   value='<?=$row['nis']?>' placeholder="masukan NIS">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">N I S N</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nisn"
													   value='<?=$row['nisn']?>' placeholder="masukan NISN">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nomer U N</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="no_un"
													   value='<?=$row['no_un']?>' placeholder="masukan Nomer U N">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Kelas</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="kelas_id" disabled="true">
													<?php 
													$kelas_array = $this->m_option->kelas();
													
													foreach($kelas_array as $value=>$label){
														if($row['kelas_id']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									<?php //print_r($kelas_array);?>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Status Login</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="aktif">
													<?php 
													foreach($status_login as $value=>$label){
														if($row['aktif']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
							
							
						</div>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->						
						<div role="tabpanel" id="data_diri" class="tab-pane pmb-block">
							<div class="pmbb-header">
								<h2 id="title_profil"><i class="zmdi zmdi-account m-r-10"></i> Data Profil Siswa</h2>
								<?php
								if ($admin OR $siswa_ybs)
								{?>
							<!--
								<ul class="actions">
									<li class="dropdown">
										<a href="" data-toggle="dropdown">
											<i class="zmdi zmdi-more-vert"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a data-ma-action="profile-edit" href="">Edit</a>
											</li>
										</ul>
									</li>
								</ul>
							-->
							<ul class="actions">
								<a data-ma-action="profile-edit" href="" id="edit_profil" class="btn btn-warning btn-sm" >
								<i class="zmdi zmdi-edit"></i></a>
							</ul>
								<?php
								}?>
							</div>
							<?php
								$gender = array('p' => 'Perempuan', 'l' => 'Laki-laki');
							?>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
								<?php 
									foreach($view_data['profil'] as $label => $value)
									{
										if ($value=='gender')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$gender[$row[$value]]?></dd>
											</dl>
											<?php
										}else
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$row[$value]?></dd>
											</dl>
											
										<?php 
										}
									} ?>
									
									
								</div>

								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="nama"
													   value='<?=$row['nama']?>' placeholder="nama">
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Gender</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="gender">
													<?php 
													foreach($gender as $value=>$label){
														if($row['gender']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
										
										
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Alamat</dt>
										<dd>
											<div class="fg-line">
												<textarea class="form-control" rows="5" name="alamat"
													   placeholder="alamat">
													   <?=$row['alamat']?>
												</textarea>
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Kota</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="kota"
													   value='<?=$row['kota']?>' placeholder="kota">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Telepon</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="telepon"
													   value='<?=$row['telepon']?>' placeholder="telepon">
											</div>

										</dd>
									</dl>
									

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
						</div>
						
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						<div role="tabpanel" id="data_keluarga" class="tab-pane pmb-block">
							<div class="pmbb-header">
								<h2 id="title_keluarga"><i class="zmdi zmdi-account m-r-10"></i> Data Keluarga</h2>
								<?php
								if ($admin OR $siswa_ybs)
								{?>
							<!--
								<ul class="actions">
									<li class="dropdown">
										<a href="" data-toggle="dropdown">
											<i class="zmdi zmdi-more-vert"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a data-ma-action="profile-edit" href="">Edit</a>
											</li>
										</ul>
									</li>
								</ul>
							-->
							<ul class="actions">
								<a data-ma-action="profile-edit" href="" id="edit_keluarga" class="btn btn-warning btn-sm" >
								<i class="zmdi zmdi-edit"></i></a>
							</ul>
								<?php
								}?>
							</div>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
									<?php 
									foreach($view_data['keluarga'] as $label => $value)
									{
										?>
										<dl class="dl-horizontal">
											<dt><?=$label?></dt>
											<dd><?=$row[$value]?></dd>
										</dl>
										<?php 
									} ?>
									
								</div>

								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">Status</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="status_keluarga"
													   value='<?=$row['status_keluarga']?>' placeholder="status dalam keluarga">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Anak ke</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="anak_ke"
													   value='<?=$row['anak_ke']?>' placeholder="nomor">
											</div>
										</dd>
										
										
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama Ayah</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="ayah_nama"
													   value='<?=$row['ayah_nama']?>' placeholder="nama lengkap ayah">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Pekerjaan Ayah</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="ayah_pekerjaan"
													   value='<?=$row['ayah_pekerjaan']?>' placeholder="PNS/swasta/wirausaha">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama Ibu</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="ibu_nama"
													   value='<?=$row['ibu_nama']?>' placeholder="nama lengkap ibu">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Pekerjaan Ibu</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="ibu_pekerjaan"
													   value='<?=$row['ibu_pekerjaan']?>' placeholder="PNS/swasta/wirausaha">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Alamat Orangtua</dt>
										<dd>
											<div class="fg-line">
												<textarea class="form-control" rows="5" name="ortu_alamat"
													   placeholder="alamat lengkap">
													   <?=$row['ortu_alamat']?>
												</textarea>
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Telepon Orangtua</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="ortu_telepon"
													   value='<?=$row['ortu_telepon']?>' placeholder="nomor telepon aktif">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama Wali</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="wali_nama"
													   value='<?=$row['wali_nama']?>' placeholder="nama lengkap wali">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Alamat Wali</dt>
										<dd>
											<div class="fg-line">
												<textarea class="form-control" rows="5" name="wali_alamat"
													   placeholder="alamat lengkap">
													   <?=$row['wali_alamat']?>
												</textarea>
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Telepon Wali</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="wali_telepon"
													   value='<?=$row['wali_telepon']?>' placeholder="nomor telepon aktif">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Pekerjaan Wali</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="wali_pekerjaan"
													   value='<?=$row['wali_pekerjaan']?>' placeholder="PNS/swasta/wirausaha">
											</div>

										</dd>
									</dl>
									
									

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
						</div>
						
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						<div role="tabpanel" id="data_pendaftaran" class="tab-pane pmb-block">
							<div class="pmbb-header">
								<h2 id="title_pendaftaran"><i class="zmdi zmdi-account m-r-10"></i> Data Pendaftaran</h2>
								<?php
								if ($admin OR $siswa_ybs)
								{?>
							<!--
								<ul class="actions">
									<li class="dropdown">
										<a href="" data-toggle="dropdown">
											<i class="zmdi zmdi-more-vert"></i>
										</a>

										<ul class="dropdown-menu dropdown-menu-right">
											<li>
												<a data-ma-action="profile-edit" href="">Edit</a>
											</li>
										</ul>
									</li>
								</ul>
							-->
							<ul class="actions">
								<a data-ma-action="profile-edit" href="" id="edit_pendaftaran" class="btn btn-warning btn-sm" >
								<i class="zmdi zmdi-edit"></i></a>
							</ul>
								<?php
								}?>
							</div>
							<?php
								$jalur = array(
									'psb' => 'PSB', 
									'pindah' => 'Pindahan',
									'lainnya' => 'Lainnya',
									
								);
								$jenjang = array(
									'' => '', 
									'sd' => 'Sekolah Dasar', 
									'smp' => 'Sekolah Menengah Pertama',
									'sma' => 'Sekolah Menengah Atas',
									'smk' => 'Sekolah Menengah Kejuruan',
									'mi' => 'Madrasah Ibtidaiyah',
									'mt' => 'Madrasah Tsanawiyah',
									'ma' => 'Madrasah Aliyah',
									
								);
							?>
							<div class="pmbb-body p-l-30">
								<div class="pmbb-view">
									<?php 
									foreach($view_data['pendaftaran'] as $label => $value)
									{
										if ($value=='masuk_jalur')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$jalur[$row[$value]]?></dd>
											</dl>
											<?php
										}elseif ($value=='masuk_tgl')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=tglwaktu($row[$value])?></dd>
											</dl>
											<?php
										}elseif ($value=='asal_sekolah_jenjang')
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$jenjang[$row[$value]]?></dd>
											</dl>
											<?php
										}else
										{?>
											<dl class="dl-horizontal">
												<dt><?=$label?></dt>
												<dd><?=$row[$value]?></dd>
											</dl>
											
										<?php 
										}
									} ?>
									
									
								</div>

								<div class="pmbb-edit">
									
									<dl class="dl-horizontal">
										<dt class="p-t-10">Jalur</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="masuk_jalur">
													<?php 
													foreach($jalur as $value=>$label){
														if($row['masuk_jalur']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Tanggal Daftar Masuk Sekolah</dt>
										<dd>
											<div class="input-group form-group">
												<span class="input-group-addon">
													<i class="zmdi zmdi-calendar"></i>
												</span>
												<div class="dtp-container">
													<input type="text" class="form-control date-picker" name="masuk_tgl"
													   value='<?=datefix($row['masuk_tgl'], 'm/d/Y')?>' placeholder="mm-dd-yyyy">
												</div>
												<div class="subinfo">**tanggal resmi.</div>
												
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nama Sekolah Asal</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="asal_sekolah_nama"
													   value='<?=$row['asal_sekolah_nama']?>' placeholder="nama lengkap sekolah asal">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Alamat Sekolah Asal</dt>
										<dd>
											<div class="fg-line">
												<textarea class="form-control" rows="5" name="asal_sekolah_alamat"
													   placeholder="alamat lengkap sekolah asal">
													   <?=$row['asal_sekolah_alamat']?>
												</textarea>
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Jenjang Sekolah Asal</dt>
										<dd>
											<div class="fg-line">
												<select class="form-control" name="asal_sekolah_jenjang">
													<?php 
													foreach($jenjang as $value=>$label){
														if($row['asal_sekolah_jenjang']==$value){
															?>	
															<option value='<?=$value?>' selected><?=$label?></option>
															<?php
															}else{
															?>
															<option value='<?=$value?>'><?=$label?></option>
															<?php 
															}
														}?>
												</select>
											</div>
										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nomor Ijazah</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="asal_ijazah_no"
													   value='<?=$row['asal_ijazah_no']?>' placeholder="nomor seri ijazah">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Nomor SKHU</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="asal_skhu_no"
													   value='<?=$row['asal_skhu_no']?>' placeholder="nomor seri skhu">
											</div>

										</dd>
									</dl>
									<dl class="dl-horizontal">
										<dt class="p-t-10">Tahun Ijasah</dt>
										<dd>
											<div class="fg-line">
												<input type="text" class="form-control" name="asal_ijazah_tahun"
													   value='<?=$row['asal_ijazah_tahun']?>' placeholder="tahun ijazah">
											</div>

										</dd>
									</dl>

									<div class="m-t-30">
										<button type="submit" class="btn btn-primary btn-sm">Save</button>
										<button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
									</div>
									
								</div>
							</div>
						</div>
						

					</div>
					<?php
					echo form_close();
					?>
                </div>
            </div>
                    
                    
                    
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer_form"); ?>
	</body>
</html>

<script type="text/javascript">
	/*
	 * Notifications
	 */
	function notify(from, align, icon, type, animIn, animOut){
		$.growl({
			icon: icon,
			title: ' Bootstrap Growl ',
			message: 'Turning standard Bootstrap alerts into awesome notifications',
			url: ''
		},{
				element: 'body',
				type: type,
				allow_dismiss: true,
				placement: {
						from: from,
						align: align
				},
				offset: {
					x: 20,
					y: 85
				},
				spacing: 10,
				z_index: 1031,
				delay: 2500,
				timer: 1000,
				url_target: '_blank',
				mouse_over: false,
				animate: {
						enter: animIn,
						exit: animOut
				},
				icon_type: 'class',
				template: '<div data-growl="container" class="alert" role="alert">' +
								'<button type="button" class="close" data-growl="dismiss">' +
									'<span aria-hidden="true">&times;</span>' +
									'<span class="sr-only">Close</span>' +
								'</button>' +
								'<span data-growl="icon"></span>' +
								'<span data-growl="title"></span>' +
								'<span data-growl="message"></span>' +
								'<a href="#" data-growl="url"></a>' +
							'</div>'
		});
	};
	
	$('.notification-demo > div > .btn').click(function(e){
		e.preventDefault();
		var nFrom = $(this).attr('data-from');
		var nAlign = $(this).attr('data-align');
		var nIcons = $(this).attr('data-icon');
		var nType = $(this).attr('data-type');
		var nAnimIn = $(this).attr('data-animation-in');
		var nAnimOut = $(this).attr('data-animation-out');
		
		notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
	});


	/*----------------------
		Dialogs
	 -----------------------*/
	<?php
	$form_js = str_replace("\n","'+'",form_openmp("{$uri_form}?id={$row['id']}", ''));
	?>
	//Warning Message
	$('#sa-warning').click(function(){
		swal({   
			title: "Ubah Photo Profil",   
			text: '<?php echo $form_js;?>'+
						<?php 
						foreach($view_data['kesiswaan'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						<?php 
						foreach($view_data['profil'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						<?php 
						foreach($view_data['keluarga'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						<?php 
						foreach($view_data['pendaftaran'] as $label => $value){?>
						'<input type="hidden" name="<?=$value?>" 		value="<?=$row[$value]?>" />'+
						<?php } ?>
						
						'<div style="padding-left:35px;" class="fileinput fileinput-new" data-provides="fileinput">'+
							'<div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>'+
							'<div>'+
								'<span class="btn btn-info btn-file">'+
									'<span class="fileinput-new">Select image</span>'+
									'<span class="fileinput-exists">Change</span>'+
									'<input type="file" name="foto">'+
								'</span>'+
								'<a href="#" class="btn btn-danger m-l-5 fileinput-exists" data-dismiss="fileinput">Remove</a>'+
							'</div>'+
							'<button type="submit" class="btn btn-primary btn-block m-t-5 btn-sm">Save</button>'+
						'</div>'+
					'<?php echo form_close();?>',  
			//type: "warning",   
			//showCancelButton: true,
			showConfirmButton: false,
			//confirmButtonText: "Yes, delete it!",
		});
	});
	
	setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
	//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
	setTimeout(function(){nowAnimation('profile-main','fadeInUp')},700);

	setTimeout(function () {
		$("#title_page").removeClass("animated");
		$("#title_page").removeClass("fadeInUp");
		
		setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
	}, 500);// wait 0.5s
				
	//setTimeout(function(){delayAnimation('navbar_profil','rubberBand')},3000);
	setTimeout(function(){delayAnimation('back','rubberBand')},3000);
	setTimeout(function(){delayAnimation('cover_k13','rubberBand')},3100);
	setTimeout(function(){delayAnimation('cover_ktsp','rubberBand')},3200);
	setTimeout(function(){delayAnimation('akun_login','rubberBand')},3300);
	
	setTimeout(function(){delayAnimation('img_sample','tada')},3300);
	
	setTimeout(function(){delayAnimation('title_kesiswaan','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_kesiswaan','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_profil','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_profil','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_keluarga','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_keluarga','rubberBand')},4200);
	
	setTimeout(function(){delayAnimation('title_pendaftaran','fadeIn')},3600);
	setTimeout(function(){delayAnimation('edit_pendaftaran','rubberBand')},4200);
	
</script>
