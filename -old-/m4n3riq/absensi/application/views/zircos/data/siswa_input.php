<?php 
	/// CEK SISWA
	if(isset( $this->session->userdata['user']['no_peserta'])){
		$data_siswa ='';
		if(isset($data['data_siswa']['data'])){
			$data_siswa = $data['data_siswa']['data'];
		}
		cek_siswa_bersangkutan( $this->session->userdata['user']['id'], $data_siswa);
	}
		
	$jml=0;
	$select['peminatan'] = array(
		array(
			'value'	=> 'MIPA',
			'label'	=> 'Matematika dan Ilmu Pengetahuan Alam',
		),
		array(
			'value'	=> 'IPS',
			'label'	=> 'Ilmu Pengetahuan Sosial',
		),
	);
	$select['lintas_minat_mipa'] = array(
		
		array(
			'value'	=> 'geografi',
			'label'	=> 'Geografi',
		),
		array(
			'value'	=> 'ekonomi',
			'label'	=> 'Ekonomi',
		),
		array(
			'value'	=> 'sastra inggris',
			'label'	=> 'Sastra Inggris',
		),
		array(
			'value'	=> 'bahasa jepang',
			'label'	=> 'Bahasa Jepang',
		),
	);
	$select['lintas_minat_ips'] = array(
		
		array(
			'value'	=> 'kimia',
			'label'	=> 'Kimia',
		),
		array(
			'value'	=> 'sastra inggris',
			'label'	=> 'Sastra Inggris',
		),
		array(
			'value'	=> 'bahasa jepang',
			'label'	=> 'Bahasa Jepang',
		),
	);
	$select['darah'] = array(
		array(
			'value'	=> 'A',
			'label'	=> 'A',
		),
		array(
			'value'	=> 'B',
			'label'	=> 'B',
		),
		array(
			'value'	=> 'AB',
			'label'	=> 'AB',
		),
		array(
			'value'	=> 'O',
			'label'	=> 'O',
		),
	);
	$select['kelamin'] = array(
		array(
			'value'	=> 'Laki-laki',
			'label'	=> 'Laki-laki',
		),
		array(
			'value'	=> 'Perempuan',
			'label'	=> 'Perempuan',
		),
	);
	$select['agama'] = array(
		array(
			'value'	=> 'ISLAM',
			'label'	=> 'ISLAM',
		),
		array(
			'value'	=> 'KRISTEN',
			'label'	=> 'KRISTEN',
		),
		array(
			'value'	=> 'KATOLIK',
			'label'	=> 'KATOLIK',
		),
		array(
			'value'	=> 'HINDU',
			'label'	=> 'HINDU',
		),
		array(
			'value'	=> 'BUDHA',
			'label'	=> 'BUDHA',
		),
	);
	
	$no=0;
	foreach($data['data_setelah_lulus']['data'] as $value_sl=>$key_sl){
		$select['setelah_lulus'][$no]['value'] = $key_sl['id'];
		$select['setelah_lulus'][$no]['label'] = $key_sl['nama'];
		$no++;
	}
	
	$form = array(
		
		// 1
		array(
			'label'			=> 'Nama Lengkap Siswa <br>(sesuai Akte Kelahiran)',
			'placeholder'	=> 'nama',
			'name'			=> 'siswa_nama',
			'help'			=> '---',
			'value'			=> '',
			
			'required'		=> 'required',
		),
		// 2
		array(
			'label'			=> 'Nomor Peserta',
			'placeholder'	=> 'Nomor',
			'name'			=> 'siswa_no_peserta',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		// 3
		array(
			'label'			=> 'Peminatan',
			'placeholder'	=> 'Nomor',
			'name'			=> 'siswa_peminatan',
			'help'			=> '---',
			'select'		=> $select['peminatan'],
			'value'			=> '',
			'onchange'		=> 'onchange="change_lintas_minat(this)"',
			'readonly'		=> 'readonly',
		),
		// 4
		array(
			'label'			=> 'Lintas Minat',
			'placeholder'	=> 'Nomor',
			'name'			=> 'siswa_lintas_minat',
			'help'			=> '---',
			'select'		=> $select['lintas_minat_ips'],
			'value'			=> '',
			'required'		=> 'required',
		),
		array(//5
			'label'			=> 'Jenis Kelamin',
			'placeholder'	=> 'agama',
			'name'			=> 'siswa_jenis_kelamin',
			'help'			=> '---',
			'select'		=> $select['kelamin'],
			'value'			=> '',
			'required'		=> 'required',
		),
		// 6
		array(
			'label'			=> 'NISN',
			'placeholder'	=> 'nisn',
			'name'			=> 'siswa_nisn',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		// 7
		array(
			'label'			=> 'NIK',
			'placeholder'	=> 'nik',
			'name'			=> 'siswa_nik',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		// 8
		array(
			'label'			=> 'Tempat Lahir <br>(sesuai Akte Kelahiran)',
			'placeholder'	=> 'tempat',
			'name'			=> 'siswa_tempat_lahir',
			'help'			=> '---',
			'value'			=> '',
		),
		// 9
		array(
			'label'			=> 'Tanggal Lahir <br>(sesuai Akte Kelahiran)',
			'placeholder'	=> 'tanggal',
			'name'			=> 'siswa_tanggal_lahir',
			'help'			=> '---',
			'value'			=> '',
		),
		
		//10
		array(
			'label'			=> 'Agama',
			'placeholder'	=> 'agama',
			'name'			=> 'siswa_agama',
			'help'			=> '---',
			'select'		=> $select['agama'],
			'value'			=> '',
			'required'		=> 'required',
		),
		//10
		array(
			'label'			=> 'Golongan Darah',
			'placeholder'	=> 'darah',
			'name'			=> 'siswa_gol_darah',
			'help'			=> '---',
			'select'		=> $select['darah'],
			'value'			=> '',
			'required'		=> 'required',
		),
		//11
		array(
			'label'			=> 'Telepon Siswa',
			'placeholder'	=> 'telepon',
			'name'			=> 'siswa_telepon_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//12
		array(
			'label'			=> 'Status Dalam Keluarga',
			'placeholder'	=> 'status dalam keluarga',
			'name'			=> 'siswa_status_keluarga',
			'help'			=> '---',
			'value'			=> '',
		),
		//13
		array(
			'label'			=> 'Anak Ke',
			'placeholder'	=> 'anak ke',
			'name'			=> 'siswa_anak_ke',
			'help'			=> '---',
			'value'			=> '',
		),
		//14
		array(
			'label'			=> 'Nama Beasiswa',
			'placeholder'	=> 'beasiswa',
			'name'			=> 'siswa_beasiswa_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		//15
		array(
			'label'			=> 'Tahun Beasiswa',
			'placeholder'	=> 'beasiswa',
			'name'			=> 'siswa_beasiswa_tahun',
			'help'			=> '---',
			'value'			=> '',
		),
		// 16
		array(
			'label'			=> 'Kewarganegaraan',
			'placeholder'	=> 'Kewarganegaraan',
			'name'			=> 'siswa_kewarganegaraan',
			'help'			=> '---',
			'value'			=> '',
		),
		//17
		array(
			'label'			=> 'Status Tempat Tinggal',
			'placeholder'	=> 'status tinggal',
			'name'			=> 'siswa_status_tinggal',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//18
		array(
			'label'			=> 'Nama Jalan',
			'placeholder'	=> 'Jalan',
			'name'			=> 'siswa_alamat_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//19
		array(
			'label'			=> 'Desa/Kelurahan',
			'placeholder'	=> 'Kelurahan',
			'name'			=> 'siswa_kelurahan_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//20
		array(
			'label'			=> 'Kecamatan',
			'placeholder'	=> 'Kecamatan',
			'name'			=> 'siswa_kecamatan_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//21
		array(
			'label'			=> 'Kode Pos',
			'placeholder'	=> 'Kode Pos',
			'name'			=> 'siswa_kode_pos_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//22
		array(
			'label'			=> 'Kab./Kota',
			'placeholder'	=> 'Kota',
			'name'			=> 'siswa_kota_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		//23
		array(
			'label'			=> 'Provinsi',
			'placeholder'	=> 'Provinsi',
			'name'			=> 'siswa_provinsi_anak',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		
		//24
		array(
			'label'			=> 'Sekolah Asal Siswa',
			'placeholder'	=> 'sekolah',
			'name'			=> 'siswa_sekolah_asal',
			'help'			=> '---',
			'value'			=> '',
			'required'		=> 'required',
		),
		
	);
	
	
	///////// AYAH ///////////////////////////////////
	$form_ayah = array(	
		// 1
		array(
			'label'			=> 'Nama Lengkap Ayah <br>(sesuai Akte Kelahiran)',
			'placeholder'	=> 'nama',
			'name'			=> 'siswa_ayah_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		// 2
		array(
			'label'			=> 'Pekerjaan',
			'placeholder'	=> 'Pekerjaan',
			'name'			=> 'siswa_ayah_pekerjaan',
			'help'			=> '---',
			'value'			=> '',
		),
		//3
		array(
			'label'			=> 'No. Telp/HP',
			'placeholder'	=> 'telepon',
			'name'			=> 'siswa_ayah_telepon',
			'help'			=> '---',
			'value'			=> '',
		),
		//4
		array(
			'label'			=> 'Alamat Kantor',
			'placeholder'	=> 'alamat',
			'name'			=> 'siswa_ayah_alamat_kantor',
			'help'			=> '---',
			'value'			=> '',
		),
		//5
		array(
			'label'			=> 'Gaji(Penghasilan)/bln',
			'placeholder'	=> 'gaji',
			'name'			=> 'siswa_ayah_gaji',
			'help'			=> '---',
			'value'			=> '',
		),
	);

	////// IBU ///////////////////////////////
	$form_ibu = array(
		// 1
		array(
			'label'			=> 'Nama Lengkap Ibu <br>(sesuai Akte Kelahiran)',
			'placeholder'	=> 'nama',
			'name'			=> 'siswa_ibu_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		// 2
		array(
			'label'			=> 'Pekerjaan',
			'placeholder'	=> 'Pekerjaan',
			'name'			=> 'siswa_ibu_pekerjaan',
			'help'			=> '---',
			'value'			=> '',
		),
		//3
		array(
			'label'			=> 'No. Telp/HP',
			'placeholder'	=> 'telepon',
			'name'			=> 'siswa_ibu_telepon',
			'help'			=> '---',
			'value'			=> '',
		),
		//4
		array(
			'label'			=> 'Alamat Kantor',
			'placeholder'	=> 'alamat',
			'name'			=> 'siswa_ibu_alamat_kantor',
			'help'			=> '---',
			'value'			=> '',
		),
		//5
		array(
			'label'			=> 'Gaji(Penghasilan)/bln',
			'placeholder'	=> 'gaji',
			'name'			=> 'siswa_ibu_gaji',
			'help'			=> '---',
			'value'			=> '',
		),
	);
	
	//////// WALI //////////////////////////
	$form_wali = array(	
		//1
		array(
			'label'			=> 'Nama Wali',
			'placeholder'	=> 'nama',
			'name'			=> 'siswa_wali_nama',
			'help'			=> '---',
			'value'			=> '',
		),
		//2
		array(
			'label'			=> 'Alamat',
			'placeholder'	=> 'alamat',
			'name'			=> 'siswa_wali_alamat',
			'help'			=> '---',
			'value'			=> '',
		),
		//3
		array(
			'label'			=> 'Pekerjaan',
			'placeholder'	=> 'Pekerjaan',
			'name'			=> 'siswa_wali_pekerjaan',
			'help'			=> '---',
			'value'			=> '',
		),
		
		//4
		array(
			'label'			=> 'No. Telp/HP',
			'placeholder'	=> 'telepon',
			'name'			=> 'siswa_wali_telepon',
			'help'			=> '---',
			'value'			=> '',
		),
		//4
		array(
			'label'			=> 'Alamat Kantor',
			'placeholder'	=> 'alamat',
			'name'			=> 'siswa_wali_alamat_kantor',
			'help'			=> '---',
			'value'			=> '',
		),
		//5
		array(
			'label'			=> 'Gaji(Penghasilan)/bln',
			'placeholder'	=> 'gaji',
			'name'			=> 'siswa_wali_gaji',
			'help'			=> '---',
			'value'			=> '',
		),
		
	);
	
	
	
	////////////// NILAI /////////////////
	$form_nilai = array(	
		//1
		array(
			'label'			=> 'Nilai Bahasa Indonesia',
			'placeholder'	=> '00.00',
			'name'			=> 'siswa_nilai_ind',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		//2
		array(
			'label'			=> 'Nilai Matematika',
			'placeholder'	=> '00.00',
			'name'			=> 'siswa_nilai_mat',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		//3
		array(
			'label'			=> 'Nilai IPA',
			'placeholder'	=> '00.00',
			'name'			=> 'siswa_nilai_ipa',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		//4
		array(
			'label'			=> 'Nilai Bahasa Inggris',
			'placeholder'	=> '00.00',
			'name'			=> 'siswa_nilai_ing',
			'help'			=> '---',
			'value'			=> '',
			'readonly'		=> 'readonly',
		),
		
	);
	
	////////////// ANGKET /////////////////
	$form_angket = array(	
		//1
		array(
			'label'			=> 'Opsi Tersendiri',
			'placeholder'	=> 'alasan',
			'name'			=> 'siswa_alasan_sekolah',
			'help'			=> '---',
			'value'			=> '',
			
		),
		//2
		array(
			'label'			=> 'Opsi',
			'placeholder'	=> 'yang dilakukan',
			'name'			=> 'siswa_setelah_lulus_id',
			'help'			=> '---',
			'select'		=> $select['setelah_lulus'],
			'value'			=> '',
			'onchange'		=> 'onchange="setelah_lulus_opsi()"',
		),
		//3
		array(
			'label'			=> 'Opsi Tersendiri',
			'placeholder'	=> 'yang dilakukan',
			'name'			=> 'siswa_setelah_lulus_lainya',
			'onchange'		=> 'onchange="setelah_lulus_opsi_lain()"',
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
				if($form[$jml]['name']=='siswa_peminatan'){
					if($form[$jml]['value']=='MIPA'){
						$form[3]['select']		= $select['lintas_minat_mipa'];
					}else if($form[$jml]['value']=='IPS'){
						$form[3]['select']		= $select['lintas_minat_ips'];
					}
				}
				$jml++;
			}
			$jml=0;
			foreach($form_ayah as $f)
			{
				$form_ayah[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
			$jml=0;
			foreach($form_ibu as $f)
			{
				$form_ibu[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
			$jml=0;
			foreach($form_wali as $f)
			{
				$form_wali[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
			
			$jml=0;
			foreach($form_nilai as $f)
			{
				$form_nilai[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
			
			$jml=0;
			foreach($form_angket as $f)
			{
				$form_angket[$jml]['value'] = $key[$f['name']];
				$jml++;
			}
		}
	}
	
	/// PRESTASI
	$jml_prestasi=PRESTASI;
	$i=1;
	while($i<=$jml_prestasi){
		$form_prestasi[$i]['prestasi_tingkat']	= '';
		$form_prestasi[$i]['prestasi_nama']	= '';
		$form_prestasi[$i]['prestasi_juara'] = '';
		$form_prestasi[$i]['prestasi_tahun'] = '';
		$i++;
	}
	
	if(isset($data['data_siswa_prestasi']['data'])){	
		$i=1;
		foreach($data['data_siswa_prestasi']['data'] as $value=>$key){
			
			$form_prestasi[$key['prestasi_urut']]['prestasi_tingkat']	= $key['prestasi_tingkat'];
			$form_prestasi[$key['prestasi_urut']]['prestasi_nama']		= $key['prestasi_nama'];
			$form_prestasi[$key['prestasi_urut']]['prestasi_juara']		= $key['prestasi_juara'];
			$form_prestasi[$key['prestasi_urut']]['prestasi_tahun']		= $key['prestasi_tahun'];
			$i++;
		}
		$show_prestasi	= $i;
		
	}
	
	/// KULIAH
	$jml_kuliah=KULIAH;
	$i=1;
	while($i<=$jml_kuliah){
		$form_kuliah[$i]['kuliah_nama']	= '';
		$form_kuliah[$i]['kuliah_jurusan'] = '';
		$i++;
	}
	
	if(isset($data['data_siswa_kuliah']['data'])){	
		$i=1;
		foreach($data['data_siswa_kuliah']['data'] as $value=>$key){
			
			$form_kuliah[$key['kuliah_urut']]['kuliah_nama']		= $key['kuliah_nama'];
			$form_kuliah[$key['kuliah_urut']]['kuliah_jurusan']		= $key['kuliah_jurusan'];
			$i++;
		}
		$show_kuliah	= $i;
		
	}
	
	/// KERJA
	$jml_kerja=KERJA;
	$i=1;
	while($i<=$jml_kerja){
		$form_kerja[$i]['kerja_nama']	= '';
		$form_kerja[$i]['kerja_jabatan'] = '';
		$i++;
	}
	
	if(isset($data['data_siswa_kerja']['data'])){	
		$i=1;
		foreach($data['data_siswa_kerja']['data'] as $value=>$key){
			
			$form_kerja[$key['kerja_urut']]['kerja_nama']		= $key['kerja_nama'];
			$form_kerja[$key['kerja_urut']]['kerja_jabatan']	= $key['kerja_jabatan'];
			$i++;
		}
		$show_kerja	= $i;
		
	}
	
	/// ALASAN_SEKOLAH
	$jml_alasan_sekolah=ALASAN_SEKOLAH;
	$i=1;
	while($i<=$jml_alasan_sekolah){
		$form_alasan_sekolah[$i]['alasan_sekolah_value']	= '';
		$i++;
	}
	
	if(isset($data['data_siswa_alasan_sekolah']['data'])){	
		$i=1;
		foreach($data['data_siswa_alasan_sekolah']['data'] as $value=>$key){
			
			$form_alasan_sekolah[$key['alasan_sekolah_urut']]['alasan_sekolah_value']		= $key['alasan_sekolah_value'];
			$i++;
		}
		$show_alasan_sekolah	= $i;
		
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
								 <a href="<?=base_url();?>/data/siswa">SISWA</a>
							</li>
							<li class="active">
								Form SISWA
							</li>
						</ol>
					</div>
					<h4 class="page-title"> Form SISWA</h4>
				</div>
			</div>
		</div>
		<!-- end page title end breadcrumb -->
		
			<div class="row">
				<div class="col-md-4">
				 <a class="btn btn-inverse waves-effect w-md waves-light m-b-5" href="<?=base_url();?>data/siswa"><i class="fa fa-chevron-left"></i> Kembali SISWA</a>
				</div>
				
				
			</div>
			<?php      
				echo alert_get();
            ?> 
                    
        <div class="row">
			<div class="col-sm-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title"><b>Form SISWA</b></h4>
					
					<div class="row">
						<div class="col-md-8">                           
							<form action="<?=base_url();?>data/siswa/save" class="form-horizontal form-row-seperated" method="POST">
			
									<?php
									if(!empty($data['id']))
									{?>
									<input type="hidden" name="siswa_id" value="<?=$data['id'];?>"/>
										<?php
									}?>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>I.IDENTITAS PESERTA DIDIK:</b></h5></label>
									</div>
									
									<?= form_input_text1($form[0]);?>
									<?= form_input_text1($form[1]);?>
									<?= form_input_select1($form[4])?>
									<?= form_input_text1($form[5]);?>
									<?= form_input_text1($form[6]);?>
									<?= form_input_text1($form[7]);?>
									<?php //echo form_input_date2($form[8]);?>
									<?= form_input_text1($form[8]);?>
									<?= form_input_select1($form[9])?>
									<?= form_input_select1($form[10])?>
									<?= form_input_text1($form[11]);?>
									<?= form_input_text1($form[12]);?>
									<?= form_input_text1($form[13]);?>
									
									<?= form_input_text1($form[16]);?>
									<?= form_input_text1($form[17]);?>
									
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Peminatan & Lintas Minat</b></h5></label>
									</div>
									<?php if($form[2]['value'] != ''){ ?>
										<input type="hidden" name="siswa_peminatan" value="<?=$form[2]['value'];?>"/>
										<div class="form-group">
											<label class="col-sm-3 control-label">Peminatan</label>
											<label class="col-sm-8 control-label" style="text-align:left"><?php
											if($form[2]['value']=='MIPA'){
												echo "Matematika dan Ilmu Pengetahuan Alam";
											}elseif($form[2]['value']=='IPS'){
												echo "Ilmu Pengetahuan Sosial";
											}?></label>
										</div>
									<?php
									}else{									
										echo form_input_select1($form[2]);
									}?>
									<?= form_input_select1($form[3])?>
									
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Riwayat Beasiswa</b></h5></label>
									</div>
									
									<?= form_input_text1($form[14]);?>
									<?= form_input_text1($form[15]);?>
									
									
									
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Alamat Siswa</b></h5></label>
									</div>
									
									<?= form_input_text1($form[18]);?>
									<?= form_input_text1($form[19]);?>
									<?= form_input_text1($form[20]);?>
									<?= form_input_text1($form[21]);?>
									<?= form_input_text1($form[22]);?>
									<?= form_input_text1($form[23]);?>
									<?= form_input_text1($form[24]);?>
									
									<br><br>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>II.IDENTITAS ORANGTUA/WALI:</b></h5></label>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Identitas Ayah</b></h5></label>
									</div>
									<!-- AYAH -->
									<?= form_input_text1($form_ayah[0]);?>
									<?= form_input_text1($form_ayah[1]);?>
									<?= form_input_text1($form_ayah[2]);?>
									<?= form_input_textarea1($form_ayah[3]);?>
									<?= form_input_text1($form_ayah[4]);?>
									<br>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Identitas Ibu</b></h5></label>
									</div>
									<!-- IBU -->
									<?= form_input_text1($form_ibu[0]);?>
									<?= form_input_text1($form_ibu[1]);?>
									<?= form_input_text1($form_ibu[2]);?>
									<?= form_input_textarea1($form_ibu[3]);?>
									<?= form_input_text1($form_ibu[4]);?>
									<br>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>Identitas Wali</b></h5></label>
									</div>
									<!-- WALI -->
									<?= form_input_text1($form_wali[0]);?>
									<?= form_input_textarea1($form_wali[1]);?>
									<?= form_input_text1($form_wali[2]);?>
									<?= form_input_text1($form_wali[3]);?>
									<?= form_input_textarea1($form_wali[4]);?>
									<?= form_input_text1($form_wali[5]);?>
									<br><br>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>III.NILAI UJIAN NASIONAL: </b></h5>
										<br>Nilai Ujian Nasional (pengisian koma menggunakan tanda ".")</label>
									</div>
									<!-- Nilai -->
									<?= form_input_text1($form_nilai[0]);?>
									<?= form_input_text1($form_nilai[1]);?>
									<?= form_input_text1($form_nilai[2]);?>
									<?= form_input_text1($form_nilai[3]);?>
									
									<br><br>
									<div class="form-group">
										<label class="col-md-3 control-label"><h5><b>VI.Catatan Prestasi:</b></h5></label>
									</div>
									<?php
										$no=1;
										$jml_prestasi = PRESTASI;
										$block_show='';
										
										while($no<=$jml_prestasi){ 
											
										?>
											<div class="form-group">
												<label class="col-md-3 control-label"><h5><b>Prestasi ke <?=$no?></b></h5></label>
											</div>
											<div class="form-group">
												<div class='row prestasi<?=$no?>' >
													<label class="col-md-3 control-label">Tingkat</label>
													<div class="col-md-8">
														<input type="text" name="prestasi_tingkat_<?=$no?>" id="prestasi_tingkat_<?=$no?>" class="form-control" 
														placeholder="tingkat prestasi" value="<?=$form_prestasi[$no]['prestasi_tingkat']?>">
														
													</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class='row prestasi<?=$no?>' >
													<label class="col-md-3 control-label">Nama</label>
													<div class="col-md-8">
														<input type="text" name="prestasi_nama_<?=$no?>" id="prestasi_nama_<?=$no?>" class="form-control" 
														placeholder="nama prestasi" value="<?=$form_prestasi[$no]['prestasi_nama']?>">
														
													</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class='row prestasi<?=$no?>' >
													<label class="col-md-3 control-label">Juara</label>
													<div class="col-md-8">
														<input type="text" name="prestasi_juara_<?=$no?>" id="prestasi_juara_<?=$no?>" class="form-control" 
														placeholder="juara prestasi" value="<?=$form_prestasi[$no]['prestasi_juara']?>">
														
													</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class='row prestasi<?=$no?>' >
													<label class="col-md-3 control-label">Tahun</label>
													<div class="col-md-8">
														<input type="text" name="prestasi_tahun_<?=$no?>" id="prestasi_tahun_<?=$no?>" class="form-control" 
														placeholder="tahun prestasi" value="<?=$form_prestasi[$no]['prestasi_tahun']?>">
														
													</div>
													
												</div>
											</div>
											<br>
											<?php
											$no++;
										}?>
										<br><br>
										<div class="form-group">
											<label class="col-md-3 control-label"><h5><b>V.ANGKET LINTAS MINAT:</b></h5></label>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label"><h5><b>Yang dilakukan setelah Lulus (hanya 1 opsi yang diambil)</b></h5></label>
										</div>
										<br>
										<?= form_input_select1($form_angket[1])?>
										<?= form_input_text1($form_angket[2]);?>
										<br>
										<div class="form-group">
											<label class="col-md-3 control-label"><h5><b>Alasan memilih bersekolah di SMAN 1 Semarang (boleh dipilih lebih dari satu)</b></h5></label>
										</div>
										<?php
										$no=0;
										foreach($data['data_alasan_sekolah']['data'] as $key_alasan_sekolah){
											$no++;
											$label='';
											if($no==1)
											{	$label='Opsi';	}
											?>
										<div class="form-group">
											<label class="col-md-3 control-label"><?=$label?></label>
											<div class="col-md-8">
												<div class="button-list">
													<div class="btn-switch btn-switch-custom">
														<?php
														$checked ='';
														if(isset($form_alasan_sekolah[$no]['alasan_sekolah_value']))
														{
															if($form_alasan_sekolah[$no]['alasan_sekolah_value'] > 0)
															{   $checked = 'checked';	}
														}
														?>
														<input name="alasan_sekolah_value_<?=$no?>" id="alasan_sekolah_value_<?=$no?>"  type="checkbox"
															   <?=$checked?>/>
														<label for="alasan_sekolah_value_<?=$no?>"
															   class="btn btn-rounded btn-custom waves-effect waves-light">
															<em class="glyphicon glyphicon-ok"></em>
															<strong> <?=$key_alasan_sekolah['nama']?> </strong>
														</label>
													</div>
												</div>
											</div>
										</div>	
										<?php }
										?>
										<?= form_input_text1($form_angket[0]);?>
										<br><br>
										<div class="form-group">
											<label class="col-md-3 control-label"><h5><b>Seandainya melanjutkan studi di perguruan tinggi saya bercita - cita kuliah di :</b></h5></label>
										</div>
										<?php
										$no=1;
										$jml_kuliah = KULIAH;
										$block_show='';
										
										while($no<=$jml_kuliah){ 
											
										?>
											<div class="form-group">
												<label class="col-md-3 control-label"><h5><b>Pilihan ke <?=$no?></b></h5></label>
											</div>
											
											<div class="form-group">
												<div class='row kuliah<?=$no?>' >
													<label class="col-md-3 control-label">Nama Perguruan Tinggi</label>
													<div class="col-md-8">
														<input type="text" name="kuliah_nama_<?=$no?>" id="kuliah_nama_<?=$no?>" class="form-control" 
														placeholder="Perguruan Tinggi" value="<?=$form_kuliah[$no]['kuliah_nama']?>">
														
													</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class='row kuliah<?=$no?>' >
													<label class="col-md-3 control-label">Jurusan</label>
													<div class="col-md-8">
														<input type="text" name="kuliah_jurusan_<?=$no?>" id="kuliah_jurusan_<?=$no?>" class="form-control" 
														placeholder=" jurusan" value="<?=$form_kuliah[$no]['kuliah_jurusan']?>">
														
													</div>
													
												</div>
											</div>
											
											<br>
											<?php
											$no++;
										}?>
									
										<br>
										<div class="form-group">
											<label class="col-md-3 control-label"><h5><b>Seandainya saya bekerja, pekerjaan yang saya cita - citakan adalah :</b></h5></label>
										</div>
										<?php
										$no=1;
										$jml_kerja = KERJA;
										$block_show='';
										
										while($no<=$jml_kerja){ 
											
										?>
											<div class="form-group">
												<label class="col-md-3 control-label"><h5><b>Pilihan ke <?=$no?></b></h5></label>
											</div>
											
											<div class="form-group">
												<div class='row kerja<?=$no?>' >
													<label class="col-md-3 control-label">Bekerja Di</label>
													<div class="col-md-8">
														<input type="text" name="kerja_nama_<?=$no?>" id="kerja_nama_<?=$no?>" class="form-control" 
														placeholder="tempat kerja" value="<?=$form_kerja[$no]['kerja_nama']?>">
														
													</div>
													
												</div>
											</div>
											<div class="form-group">
												<div class='row kerja<?=$no?>' >
													<label class="col-md-3 control-label">Sebagai</label>
													<div class="col-md-8">
														<input type="text" name="kerja_jabatan_<?=$no?>" id="kerja_jabatan_<?=$no?>" class="form-control" 
														placeholder=" Sebagai" value="<?=$form_kerja[$no]['kerja_jabatan']?>">
														
													</div>
													
												</div>
											</div>
											
											<br>
											<?php
											$no++;
										}?>
									
								
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
		
	</div>
</div>
<script>
 
function setelah_lulus_opsi() {
	document.getElementById('siswa_setelah_lulus_lainya').value = "";
}

function setelah_lulus_opsi_lain() {
	document.getElementById("siswa_setelah_lulus_id").selectedIndex = 0;
}

function change_lintas_minat(selectObject){

	var myDiv = document.getElementById("siswa_lintas_minat");
	// Clear all
	var lengthx = myDiv.options.length;
	for (x = 0; x < lengthx; x++) {
	  myDiv.options[0] = null;
	}

	//output = <?php echo json_encode($select['lintas_minat_mipa']); ?>;
	if(selectObject.value=="MIPA"){
		output = <?php echo json_encode($select['lintas_minat_mipa']); ?>;
	}else if(selectObject.value=="IPS"){
		output = <?php echo json_encode($select['lintas_minat_ips']); ?>;
	}
	//var array_id = output['value'];
	//var array_label = output['label'];
	var array_lintas_minat = output;
	
	for (var i = 0; i < array_lintas_minat.length; i++) {
		var option = document.createElement("option");
		option.value = array_lintas_minat[i]['value'];
		option.text = array_lintas_minat[i]['label'];
		myDiv.appendChild(option);
	}
	
}


</script>          
