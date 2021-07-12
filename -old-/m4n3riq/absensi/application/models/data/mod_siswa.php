<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_siswa extends CI_Model {

	function chek_data_siswa_exit(){
		
		$data['id'] = "";
		$data['data_siswa'] = $this->listing($data);
		
		$chek_data = array("");
		foreach($data['data_siswa']['data'] as $siswa)
		{
			array_push($chek_data, $siswa['siswa_no_peserta']);
		}
		return $chek_data;
	}
	
	function listing($send_data = "") {
	
		$d = $this->d;
	
		$this->db->select("
			siswa.*, 
			
			lulus.nama as siswa_setelah_lulus ,
			");
		//$this->db->join('user_login user1', 'user1.login_id =  siswa_daftar.siswa_modified_id', 'left');
		//$this->db->join('user_login user2', 'user2.login_id =  siswa_daftar.siswa_created_id', 'left');
		$this->db->join('setelah_lulus lulus', 'lulus.id =  siswa.siswa_setelah_lulus_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('siswa_id', $send_data['id'], false);
		}
		$this->db->where('siswa_aktif', 1, false);
        $query = $this->db->get('siswa_daftar siswa');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'siswa_id' 				=> $arra1->siswa_id,
				//'siswa_no_daftar'		=> $arra1->siswa_no_daftar,
				'siswa_nama' 			=> $arra1->siswa_nama,
				'siswa_nisn' 			=> $arra1->siswa_nisn,
				'siswa_nik'				=> $arra1->siswa_nik,
				'siswa_no_peserta'		=> $arra1->siswa_no_peserta,
				'siswa_peminatan'		=> $arra1->siswa_peminatan,
				'siswa_lintas_minat'	=> $arra1->siswa_lintas_minat,
				
				'siswa_tempat_lahir' 	=> $arra1->siswa_tempat_lahir,
				//'siswa_tanggal_lahir' 	=> tgltodb($arra1->siswa_tanggal_lahir),
				'siswa_tanggal_lahir' 	=> $arra1->siswa_tanggal_lahir,
				'siswa_jenis_kelamin' 	=> $arra1->siswa_jenis_kelamin,
				'siswa_agama'			=> $arra1->siswa_agama,
				'siswa_gol_darah'		=> $arra1->siswa_gol_darah,
				'siswa_kewarganegaraan'	=> $arra1->siswa_kewarganegaraan,
				'siswa_telepon_anak' 	=> $arra1->siswa_telepon_anak,
				'siswa_status_keluarga' => $arra1->siswa_status_keluarga,
				'siswa_anak_ke' 		=> $arra1->siswa_anak_ke,
				'siswa_beasiswa_nama'	=> $arra1->siswa_beasiswa_nama,
				'siswa_beasiswa_tahun'	=> $arra1->siswa_beasiswa_tahun,
				'siswa_status_tinggal'	=> $arra1->siswa_status_tinggal,
				
				'siswa_alamat_anak' 	=> $arra1->siswa_alamat_anak,
				'siswa_kelurahan_anak' 	=> $arra1->siswa_kelurahan_anak,
				'siswa_kecamatan_anak' 	=> $arra1->siswa_kecamatan_anak,
				'siswa_kode_pos_anak' 	=> $arra1->siswa_kode_pos_anak,
				'siswa_kota_anak' 		=> $arra1->siswa_kota_anak,
				'siswa_provinsi_anak' 	=> $arra1->siswa_provinsi_anak,
				
				'siswa_sekolah_asal' 	=> $arra1->siswa_sekolah_asal,
				
				'siswa_ayah_nama' 		=> $arra1->siswa_ayah_nama,
				'siswa_ayah_pekerjaan' 	=> $arra1->siswa_ayah_pekerjaan,
				'siswa_ayah_telepon' 	=> $arra1->siswa_ayah_telepon,
				'siswa_ayah_alamat_kantor' 	=> $arra1->siswa_ayah_alamat_kantor,
				'siswa_ayah_gaji' 		=> $arra1->siswa_ayah_gaji,
				
				'siswa_ibu_nama' 		=> $arra1->siswa_ibu_nama,
				'siswa_ibu_pekerjaan' 	=> $arra1->siswa_ibu_pekerjaan,
				'siswa_ibu_telepon' 	=> $arra1->siswa_ibu_telepon,
				'siswa_ibu_alamat_kantor' 	=> $arra1->siswa_ibu_alamat_kantor,
				'siswa_ibu_gaji' 		=> $arra1->siswa_ibu_gaji,
				
				'siswa_wali_nama' 		=> $arra1->siswa_wali_nama,
				'siswa_wali_alamat'		=> $arra1->siswa_wali_alamat,
				'siswa_wali_pekerjaan' 	=> $arra1->siswa_wali_pekerjaan,
				'siswa_wali_telepon' 	=> $arra1->siswa_wali_telepon,
				'siswa_wali_alamat_kantor' 	=> $arra1->siswa_wali_alamat_kantor,
				'siswa_wali_gaji' 		=> $arra1->siswa_wali_gaji,
				
				'siswa_nilai_ind' 		=> $arra1->siswa_nilai_ind,
				'siswa_nilai_ing' 		=> $arra1->siswa_nilai_ing,
				'siswa_nilai_mat' 		=> $arra1->siswa_nilai_mat,
				'siswa_nilai_ipa' 		=> $arra1->siswa_nilai_ipa,
			
				'siswa_alasan_sekolah'		=> $arra1->siswa_alasan_sekolah,
				'siswa_setelah_lulus_id'	=> $arra1->siswa_setelah_lulus_id,
				'siswa_setelah_lulus'		=> $arra1->siswa_setelah_lulus,
				'siswa_setelah_lulus_lainya'=> $arra1->siswa_setelah_lulus_lainya,
				
				'siswa_aktif' 			=> $arra1->siswa_aktif,
				
				'siswa_created_time'		=> tglwaktu($arra1->siswa_created_time),
				//'created_username' 			=> $arra1->created_username,
				
				'siswa_modified_time'	=> tglwaktu($arra1->siswa_modified_time),
				//'modified_username' 		=> $arra1->modified_username,
				
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function save($send_data = "") {
		$d = $this->d;
		
		$chek_nama = $this->chek_data_siswa_exit();
		
		
		$data = array(
			
			//'siswa_no_daftar'		=> $send_data['siswa_no_daftar'],
			'siswa_nama' 			=> $send_data['siswa_nama'],
			'siswa_nisn' 			=> $send_data['siswa_nisn'],
			'siswa_nik'				=> $send_data['siswa_nik'],
			'siswa_no_peserta'		=> $send_data['siswa_no_peserta'],
			'siswa_peminatan'		=> $send_data['siswa_peminatan'],
			'siswa_lintas_minat'	=> $send_data['siswa_lintas_minat'],
			
			'siswa_tempat_lahir' 	=> $send_data['siswa_tempat_lahir'],
			//'siswa_tanggal_lahir' 	=> tgltodb($send_data['siswa_tanggal_lahir']),
			'siswa_tanggal_lahir' 	=> $send_data['siswa_tanggal_lahir'],
			'siswa_jenis_kelamin' 	=> $send_data['siswa_jenis_kelamin'],
			'siswa_agama'			=> $send_data['siswa_agama'],
			'siswa_gol_darah'		=> $send_data['siswa_gol_darah'],
			'siswa_kewarganegaraan'	=> $send_data['siswa_kewarganegaraan'],
			'siswa_telepon_anak' 	=> $send_data['siswa_telepon_anak'],
			'siswa_status_keluarga' => $send_data['siswa_status_keluarga'],
			'siswa_anak_ke' 		=> $send_data['siswa_anak_ke'],
			'siswa_beasiswa_nama'	=> $send_data['siswa_beasiswa_nama'],
			'siswa_beasiswa_tahun'	=> $send_data['siswa_beasiswa_tahun'],
			'siswa_status_tinggal'	=> $send_data['siswa_status_tinggal'],
			
			'siswa_alamat_anak' 	=> $send_data['siswa_alamat_anak'],
			'siswa_kelurahan_anak' 	=> $send_data['siswa_kelurahan_anak'],
			'siswa_kecamatan_anak' 	=> $send_data['siswa_kecamatan_anak'],
			'siswa_kode_pos_anak' 	=> $send_data['siswa_kode_pos_anak'],
			'siswa_kota_anak' 		=> $send_data['siswa_kota_anak'],
			'siswa_provinsi_anak' 	=> $send_data['siswa_provinsi_anak'],
			
			'siswa_sekolah_asal' 	=> $send_data['siswa_sekolah_asal'],
			
			'siswa_ayah_nama' 		=> $send_data['siswa_ayah_nama'],
			'siswa_ayah_pekerjaan' 	=> $send_data['siswa_ayah_pekerjaan'],
			'siswa_ayah_telepon' 	=> $send_data['siswa_ayah_telepon'],
			'siswa_ayah_alamat_kantor' 	=> $send_data['siswa_ayah_alamat_kantor'],
			'siswa_ayah_gaji' 		=> $send_data['siswa_ayah_gaji'],
			
			'siswa_ibu_nama' 		=> $send_data['siswa_ibu_nama'],
			'siswa_ibu_pekerjaan' 	=> $send_data['siswa_ibu_pekerjaan'],
			'siswa_ibu_telepon' 	=> $send_data['siswa_ibu_telepon'],
			'siswa_ibu_alamat_kantor' 	=> $send_data['siswa_ibu_alamat_kantor'],
			'siswa_ibu_gaji' 		=> $send_data['siswa_ibu_gaji'],
			
			'siswa_wali_nama' 		=> $send_data['siswa_wali_nama'],
			'siswa_wali_alamat'		=> $send_data['siswa_wali_alamat'],
			'siswa_wali_pekerjaan' 	=> $send_data['siswa_wali_pekerjaan'],
			'siswa_wali_telepon' 	=> $send_data['siswa_wali_telepon'],
			'siswa_wali_alamat_kantor' 	=> $send_data['siswa_wali_alamat_kantor'],
			'siswa_wali_gaji' 		=> $send_data['siswa_wali_gaji'],
			
			'siswa_nilai_ind' 		=> $send_data['siswa_nilai_ind'],
			'siswa_nilai_ing' 		=> $send_data['siswa_nilai_ing'],
			'siswa_nilai_mat' 		=> $send_data['siswa_nilai_mat'],
			'siswa_nilai_ipa' 		=> $send_data['siswa_nilai_ipa'],
			
			'siswa_alasan_sekolah'		=> $send_data['siswa_alasan_sekolah'],
			'siswa_setelah_lulus_id'	=> $send_data['siswa_setelah_lulus_id'],
			'siswa_setelah_lulus_lainya'=> $send_data['siswa_setelah_lulus_lainya'],
			
			'siswa_modified_time' 	=> date("Y-m-d H:i:sa"),
			'siswa_modified_id' 		=> $this->session->userdata['user']['id'],
			'siswa_aktif' 			=> 1,
			
			);

		if(isset($send_data['siswa_id'])){
			$this->db->where('siswa_id', $send_data['siswa_id']);
			$this->db->update('siswa_daftar', $data);
		}else{
			if(in_array($send_data['siswa_no_peserta'],$chek_nama))
			{
				return alert_error(" Data sudah ada.", "data/siswa/input_new");
			}
			$data['siswa_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('siswa_daftar', $data);
			
			$send_data['siswa_id'] = $this->db->insert_id();
		}
		
		$jml_prestasi = PRESTASI;
		$this->save_prestasi($send_data,$jml_prestasi);
		$jml_kuliah = KULIAH;
		$this->save_kuliah($send_data,$jml_kuliah);
		$jml_kerja = KERJA;
		$this->save_kerja($send_data,$jml_kerja);
		$jml_alasan_sekolah = ALASAN_SEKOLAH;
		$this->save_alasan_sekolah($send_data,$jml_alasan_sekolah);
		
		return !$d['error'];
    }
	
	function save_prestasi($send_data = "" ,$jml=1) {
		$d = $this->d;
		
		$no=1;
		$delete = array('prestasi_aktif' => 0);
		$this->db->where('prestasi_siswa_id',  $send_data["siswa_id"]);
		$this->db->update('siswa_prestasi', $delete);
			
		while($no <= $jml){
			if(($send_data['prestasi_tingkat_'.$no] != '')||($send_data['prestasi_nama_'.$no] != '')){
				$data = array(
					'prestasi_siswa_id'			=> $send_data["siswa_id"],
					'prestasi_tingkat' 			=> $send_data['prestasi_tingkat_'.$no],
					'prestasi_nama' 			=> $send_data['prestasi_nama_'.$no],
					'prestasi_juara' 			=> $send_data['prestasi_juara_'.$no],
					'prestasi_tahun' 			=> $send_data['prestasi_tahun_'.$no],
					'prestasi_urut' 			=> $no,
					'prestasi_created_time' 	=> date("Y-m-d H:i:sa"),
					'prestasi_created_id' 		=> $this->session->userdata['user']['id'],
					'prestasi_aktif' 			=> 1,
					);
					
				$this->db->insert('siswa_prestasi', $data);
			}
			$no++;
		}
	}
	
	function save_kuliah($send_data = "" ,$jml=1) {
		$d = $this->d;
		
		$no=1;
		$delete = array('kuliah_aktif' => 0);
		$this->db->where('kuliah_siswa_id',  $send_data["siswa_id"]);
		$this->db->update('siswa_kuliah', $delete);
			
		while($no <= $jml){
			if(($send_data['kuliah_jurusan_'.$no] != '')||($send_data['kuliah_nama_'.$no] != '')){
				$data = array(
					'kuliah_siswa_id'		=> $send_data["siswa_id"],
					'kuliah_nama' 			=> $send_data['kuliah_nama_'.$no],
					'kuliah_jurusan' 		=> $send_data['kuliah_jurusan_'.$no],
					'kuliah_urut' 			=> $no,
					'kuliah_created_time' 	=> date("Y-m-d H:i:sa"),
					'kuliah_created_id' 		=> $this->session->userdata['user']['id'],
					'kuliah_aktif' 			=> 1,
					);
					
				$this->db->insert('siswa_kuliah', $data);
			}
			$no++;
		}
	}
	
	function save_kerja($send_data = "" ,$jml=1) {
		$d = $this->d;
		
		$no=1;
		$delete = array('kerja_aktif' => 0);
		$this->db->where('kerja_siswa_id',  $send_data["siswa_id"]);
		$this->db->update('siswa_kerja', $delete);
			
		while($no <= $jml){
			if(($send_data['kerja_jabatan_'.$no] != '')||($send_data['kerja_nama_'.$no] != '')){
				$data = array(
					'kerja_siswa_id'		=> $send_data["siswa_id"],
					'kerja_nama' 			=> $send_data['kerja_nama_'.$no],
					'kerja_jabatan' 		=> $send_data['kerja_jabatan_'.$no],
					'kerja_urut' 			=> $no,
					'kerja_created_time' 	=> date("Y-m-d H:i:sa"),
					'kerja_created_id' 		=> $this->session->userdata['user']['id'],
					'kerja_aktif' 			=> 1,
					);
					
				$this->db->insert('siswa_kerja', $data);
			}
			$no++;
		}
	}
	
	function save_alasan_sekolah($send_data = "" ,$jml=1) {
		$d = $this->d;
		
		$no=1;
		$delete = array('alasan_sekolah_aktif' => 0);
		$this->db->where('alasan_sekolah_siswa_id',  $send_data["siswa_id"]);
		$this->db->update('siswa_alasan_sekolah', $delete);
			
		while($no <= $jml){
			if($send_data['alasan_sekolah_value_'.$no] != ''){
				$data = array(
					'alasan_sekolah_siswa_id'		=> $send_data["siswa_id"],
					'alasan_sekolah_value' 			=> $no,
					'alasan_sekolah_urut' 			=> $no,
					'alasan_sekolah_created_time' 	=> date("Y-m-d H:i:sa"),
					'alasan_sekolah_created_id' 	=> $this->session->userdata['user']['id'],
					'alasan_sekolah_aktif' 			=> 1,
					);
					
				$this->db->insert('siswa_alasan_sekolah', $data);
			}
			$no++;
		}
	}
	
	function listing_prestasi($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			siswa_prestasi.*
		");
		$this->db->join('siswa_daftar', 'siswa_daftar.siswa_id =  siswa_prestasi.prestasi_siswa_id', 'inner');
		
		$this->db->where('siswa_id', $send_data['id'], false);
		$this->db->where('prestasi_aktif', 1, false);
		
        $this->db->order_by('prestasi_urut');
		$query = $this->db->get('siswa_prestasi');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'prestasi_id' 		=> $arra1->prestasi_id,
				'prestasi_tingkat'	=> $arra1->prestasi_tingkat,
				'prestasi_nama' 	=> $arra1->prestasi_nama,
				'prestasi_juara'	=> $arra1->prestasi_juara,
				'prestasi_tahun'	=> $arra1->prestasi_tahun,
				
				'prestasi_urut'		=> $arra1->prestasi_urut,
				
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function listing_kuliah($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			siswa_kuliah.*
		");
		$this->db->join('siswa_daftar', 'siswa_daftar.siswa_id =  siswa_kuliah.kuliah_siswa_id', 'inner');
		
		$this->db->where('siswa_id', $send_data['id'], false);
		$this->db->where('kuliah_aktif', 1, false);
		
        $this->db->order_by('kuliah_urut');
		$query = $this->db->get('siswa_kuliah');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'kuliah_id' 		=> $arra1->kuliah_id,
				'kuliah_nama' 		=> $arra1->kuliah_nama,
				'kuliah_jurusan'	=> $arra1->kuliah_jurusan,
				
				'kuliah_urut'		=> $arra1->kuliah_urut,
				
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function listing_kerja($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			siswa_kerja.*
		");
		$this->db->join('siswa_daftar', 'siswa_daftar.siswa_id =  siswa_kerja.kerja_siswa_id', 'inner');
		
		$this->db->where('siswa_id', $send_data['id'], false);
		$this->db->where('kerja_aktif', 1, false);
		
        $this->db->order_by('kerja_urut');
		$query = $this->db->get('siswa_kerja');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'kerja_id' 		=> $arra1->kerja_id,
				'kerja_nama' 	=> $arra1->kerja_nama,
				'kerja_jabatan'	=> $arra1->kerja_jabatan,
				
				'kerja_urut'		=> $arra1->kerja_urut,
				
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function listing_alasan_sekolah($send_data = "") {
		$d = $this->d;
	
		$this->db->select("
			siswa_alasan_sekolah.*,
			alasan_sekolah.nama as alasan_sekolah_nama
		");
		$this->db->join('siswa_daftar', 'siswa_daftar.siswa_id =  siswa_alasan_sekolah.alasan_sekolah_siswa_id', 'inner');
		$this->db->join('alasan_sekolah', 'alasan_sekolah.id =  siswa_alasan_sekolah.alasan_sekolah_value', 'left');
		
		$this->db->where('siswa_id', $send_data['id'], false);
		$this->db->where('alasan_sekolah_aktif', 1, false);
		
        $this->db->order_by('alasan_sekolah_urut');
		$query = $this->db->get('siswa_alasan_sekolah');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'alasan_sekolah_id' 		=> $arra1->alasan_sekolah_id,
				'alasan_sekolah_value'		=> $arra1->alasan_sekolah_value,
				'alasan_sekolah_nama'		=> $arra1->alasan_sekolah_nama,
				'alasan_sekolah_urut'		=> $arra1->alasan_sekolah_urut,
				
			);
			$data1['data'][$a] = $datas;
			
        }
        $data1['count'] = $a;
        return $data1;
	}
	
	function delete($send_data = "") {
		$d = $this->d;
		
		$data = array(
			'siswa_aktif' 		=> 0,
			);

		$this->db->where('siswa_id', $send_data['siswa_id']);
		$this->db->update('siswa_daftar', $data);
		return !$d['error'];
    }
	
	////////////////////////////////////////
	//////////////// EXCEL /////////////////
	////////////////////////////////////////
	function download_add(){
		
		$this->load->library('PHPExcel');

		$excel_source = 'content/template/form_tambah.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		$datetime_now = date("Y-m-d H:i:s");
		$sheet->setCellValue('A1', 'FORM TAMBAH SISWA ');
		$sheet->setCellValue('A2', 'Last Download '.$datetime_now);
		
		
		return excel_output_2007($excel_obj, 'Tambah_master_SISWA.xlsx');
    }
	
	function upload_add($upload, $data){
		
		$this->load->library('PHPExcel');
		
		$upload_path = $upload['full_path'];
		@chmod($upload['full_path'], 0777);
		
		$excel_obj = PHPExcel_IOFactory::load($upload_path);
		
		$sheet_jml = $excel_obj->getSheetCount();

		if (!$excel_obj){
			return alert_error(" File excel tak dapat dibaca.");
		}

		if ($sheet_jml < 1){
			return alert_error(" Sheet/halaman tidak dapat dibaca.");
		}
		
		$sheet = $excel_obj->setActiveSheetIndex(0);
		$row_max = $sheet->getHighestRow();
		
		// Get Value
		$row_excel=4;
		$no=0;
		
		$chek_nama = $this->chek_data_siswa_exit();
		
		while($row_max >= $row_excel)
		{
			// CHECK EXIT
			$temp_nama = $sheet->getCell('D' . $row_excel)->getValue();
			if(!in_array($temp_nama,$chek_nama))
			{
				$row[$no]['siswa_peminatan'] 		= strtoupper($sheet->getCell('A' . $row_excel)->getValue());
				$row[$no]['siswa_no_daftar'] 		= $sheet->getCell('B' . $row_excel)->getValue();
				$row[$no]['siswa_no_un'] 			= $sheet->getCell('C' . $row_excel)->getValue();
				$row[$no]['siswa_no_peserta'] 		= $sheet->getCell('D' . $row_excel)->getValue();
				$row[$no]['siswa_nisn'] 			= $sheet->getCell('E' . $row_excel)->getValue();
				$row[$no]['siswa_no_formulir'] 		= $sheet->getCell('F' . $row_excel)->getValue();
				$row[$no]['siswa_nama'] 			= $sheet->getCell('G' . $row_excel)->getValue();
				
				$row[$no]['siswa_jenis_kelamin'] 	= $sheet->getCell('H' . $row_excel)->getValue();
				$row[$no]['siswa_tempat_lahir'] 	= $sheet->getCell('I' . $row_excel)->getValue();
				$row[$no]['siswa_alamat_anak'] 			= $sheet->getCell('J' . $row_excel)->getValue();
				$row[$no]['siswa_sekolah_asal'] 			= $sheet->getCell('K' . $row_excel)->getValue();
				$row[$no]['siswa_kapasitas'] 			= $sheet->getCell('L' . $row_excel)->getValue();
				$row[$no]['siswa_domisili'] 			= $sheet->getCell('M' . $row_excel)->getValue();
				$row[$no]['siswa_nik'] 			= $sheet->getCell('N' . $row_excel)->getValue();
				
				
				$row[$no]['siswa_status_tinggal'] 			= $sheet->getCell('Q' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('R' . $row_excel)->getValue();
				/*
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('S' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('T' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('U' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('V' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('W' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('X' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('Y' . $row_excel)->getValue();
				$row[$no]['siswa_tanggal_kk'] 			= $sheet->getCell('Z' . $row_excel)->getValue();
				*/
				$row[$no]['siswa_tanggal_lahir'] 		= $sheet->getCell('AA' . $row_excel)->getValue();
				
				$row[$no]['siswa_sekolah_pilihan'] 		= $sheet->getCell('AB' . $row_excel)->getValue();
				
				$row[$no]['siswa_nilai_ind'] 			= $sheet->getCell('AC' . $row_excel)->getValue();
				$row[$no]['siswa_nilai_ing'] 			= $sheet->getCell('AD' . $row_excel)->getValue();
				$row[$no]['siswa_nilai_mat'] 			= $sheet->getCell('AE' . $row_excel)->getValue();
				$row[$no]['siswa_nilai_ipa'] 			= $sheet->getCell('AF' . $row_excel)->getValue();
				
				$row[$no]['siswa_waktu_daftar'] 		= $sheet->getCell('AG' . $row_excel)->getValue();
				$row[$no]['siswa_lokasi_daftar'] 		= $sheet->getCell('AH' . $row_excel)->getValue();
				$row[$no]['siswa_nilai_un'] 			= $sheet->getCell('AI' . $row_excel)->getValue();
				$row[$no]['siswa_nilai_prestasi'] 		= $sheet->getCell('AJ' . $row_excel)->getValue();
				$row[$no]['siswa_miskin'] 				= $sheet->getCell('AK' . $row_excel)->getValue();
				$row[$no]['siswa_status_anak_guru'] 	= $sheet->getCell('AL' . $row_excel)->getValue();
				$row[$no]['siswa_lapor_diri'] 			= $sheet->getCell('AM' . $row_excel)->getValue();
				
				$row[$no]['siswa_sekolah1'] 			= $sheet->getCell('AN' . $row_excel)->getValue();
				$row[$no]['siswa_sekolah2'] 			= $sheet->getCell('AO' . $row_excel)->getValue();
				$row[$no]['siswa_sekolah3'] 			= $sheet->getCell('AP' . $row_excel)->getValue();
				$row[$no]['siswa_sekolah4'] 			= $sheet->getCell('AQ' . $row_excel)->getValue();
				
				$row[$no]['siswa_created_time'] 		= date("Y-m-d H:i:sa");
				$row[$no]['siswa_created_id'] 			= $this->session->userdata['user']['id'];
				$row[$no]['siswa_aktif']				= 1;
				$no++;
			}
			$row_excel++;
			
		}
		
		unset($sheet);
		$excel_obj->disconnectWorksheets();
		unset($excel_obj);
		@unlink($upload['full_path']);
		
		if ($no < 1){
			return alert_error(" Daftar kosong / sudah ada / tidak terbaca.");
		}
		
		//print_r($row);
		$this->db->trans_start();
		$this->db->insert_batch('siswa_daftar', $row);
		if ($this->db->trans_status() === FALSE){
			
				$this->db->trans_rollback();
		}else{
			
				$this->db->trans_commit();
		}
		
		return !$d['error'];
    }
	
	function download_data($data){
		
		$this->load->library('PHPExcel');

		$excel_source = 'content/template/form_download.xlsx';
		
		$excel_obj = PHPExcel_IOFactory::load($excel_source);
		
		$sheet = $excel_obj->getSheetByName('Sheet1');
		
		$datetime_now = date("Y-m-d H:i:s");
		$sheet->setCellValue('E1', 'Last Download '.$datetime_now);
		
	
		$row = 3;
		$no = 0;
		
		$set_value = array(
			
			' Nama Lengkap' 			=> 'siswa_nama',
			' No Peserta' 				=> 'siswa_no_peserta',
			' Peminatan'				=> 'siswa_peminatan',
			' Mapel Lintas Minat'		=> 'siswa_lintas_minat',
			' Jenis Kelamin'			=> 'siswa_jenis_kelamin',
			' NISN'						=> 'siswa_nisn',
			' NIK'						=> 'siswa_nik',
			' Tempat Lahir'				=> 'siswa_tempat_lahir',
			' Tanggal Lahir'			=> 'siswa_tanggal_lahir',
			' Agama'					=> 'siswa_agama',
			' Golongan Darah'			=> 'siswa_gol_darah',
			' No. Telp./HP'				=> 'siswa_telepon_anak',
			' Nilai Bhs. Indonesia'		=> 'siswa_nilai_ind',
			' Nilai Matematika' 		=> 'siswa_nilai_mat',
			' Nilai IPA' 				=> 'siswa_nilai_ipa',
			' Nilai Bhs. Inggris' 		=> 'siswa_nilai_ing',
			' Nama Riwayat Beasiswa' 	=> 'siswa_beasiswa_nama',
			' Tahun Riwayat Beasiswa' 	=> 'siswa_beasiswa_tahun',
			' Status Tempat Tinggal' 	=> 'siswa_status_tinggal',
			' Nama Jalan/Dusun' 		=> 'siswa_alamat_anak',
			' Desa/Kelurahan' 			=> 'siswa_kelurahan_anak',
			' Kecamatan' 				=> 'siswa_kecamatan_anak',
			' Kode Pos' 				=> 'siswa_kode_pos_anak',
			' Kab./Kota' 				=> 'siswa_kota_anak',
			' Provinsi' 				=> 'siswa_provinsi_anak',
			' Nama Ayah' 				=> 'siswa_ayah_nama',
			' Pekerjaan Ayah' 				=> 'siswa_ayah_pekerjaan',
			' No. Telp./HP Ayah' 			=> 'siswa_ayah_telepon',
			' Alamat Kantor Ayah' 			=> 'siswa_ayah_alamat_kantor',
			' Gaji (Penghasilan)/bln Ayah' 	=> 'siswa_ayah_gaji',
			' Nama Ibu' 					=> 'siswa_ibu_nama',
			' Pekerjaan Ibu' 				=> 'siswa_ibu_pekerjaan',
			' No. Telp./HP Ibu' 			=> 'siswa_ibu_telepon',
			' Alamat Kantor Ibu' 			=> 'siswa_ibu_alamat_kantor',
			' Gaji (Penghasilan)/bln Ibu' 	=> 'siswa_ibu_gaji',
			' Nama Wali' 					=> 'siswa_wali_nama',
			' Alamat Wali' 					=> 'siswa_wali_alamat',
			' Pekerjaan Wali' 				=> 'siswa_wali_pekerjaan',
			' No. Telp./HP Wali' 			=> 'siswa_wali_telepon',
			' Alamat Kantor Wali' 			=> 'siswa_wali_alamat_kantor',
			' Gaji (Penghasilan)/bln Wali' 	=> 'siswa_wali_gaji',
		);
			
		$set_value_option = array(
			'Alasan Sekolah ke-1',
			'Alasan Sekolah ke-2',
			'Alasan Sekolah ke-3',
			'Alasan Sekolah ke-4',
			'Alasan Sekolah ke-5',
			'Alasan Sekolah ke-6',
			
			'Capaian Prestasi Tingkat ke-1',
			'Capaian Prestasi Nama ke-1',
			'Capaian Prestasi Juara ke-1',
			'Capaian Prestasi Tahun ke-1',
			'Capaian Prestasi Tingkat ke-2',
			'Capaian Prestasi Nama ke-2',
			'Capaian Prestasi Juara ke-2',
			'Capaian Prestasi Tahun ke-2',
			
			'Tujuan Nama Perguruan Tinggi ke-1',
			'Tujuan Jurusan Perguruan Tinggi ke-1',
			'Tujuan Nama Perguruan Tinggi ke-2',
			'Tujuan Jurusan Perguruan Tinggi ke-2',
			
			'Tujuan Nama Tempat Kerja ke-1',
			'Tujuan Jabatan Tempat Kerja ke-1',
			'Tujuan Nama Tempat Kerja ke-2',
			'Tujuan Jabatan Tempat Kerja ke-2',
		);
		
		/// JUDUL
		$x = 'B';
		$set_value2 = $set_value;
		$sheet->setCellValue('A'.$row, 'No');
		foreach($set_value2 as $index => $value)
		{
			$sheet->setCellValue($x.$row, $index);
			$x++;
		}
		foreach($set_value_option as $index )
		{
			$sheet->setCellValue($x.$row, $index);
			$x++;
		}
		
		/// ISI
		foreach($data['data_siswa']['data'] as $value=>$key)
		{
			$row++;
			$no++;
			$x = 'B';
			
			$set_value2 = $set_value;
			$sheet->setCellValue('A'.$row, $no);
			foreach($set_value2 as $index => $value)
			{
				$sheet->setCellValue($x.$row, $key[$value]);
				$x++;
			}
			
			$data1['id'] = $key['siswa_id']; 
			$data['data_siswa_prestasi'] 		= $this->listing_prestasi($data1);
			$data['data_siswa_kuliah'] 			= $this->listing_kuliah($data1);
			$data['data_siswa_kerja'] 			= $this->listing_kerja($data1);
			$data['data_siswa_alasan_sekolah'] 	= $this->listing_alasan_sekolah($data1);
			
			//// ALASAN SEKOLAH
			$jml_tampil = 0;
			if(isset($data['data_siswa_alasan_sekolah']['data'])){
				foreach($data['data_siswa_alasan_sekolah']['data'] as $index1 => $value1)
				{
					$sheet->setCellValue($x.$row, $value1['alasan_sekolah_nama']);
					$x++;
					$jml_tampil++;
				}
			}
			/// dari siswa
			$sheet->setCellValue($x.$row, $key['siswa_alasan_sekolah']);
			$x++;
			$jml_tampil++;
			
			while($jml_tampil<6){
				$x++;
				$jml_tampil++;
			}
			
			//// PRESTASI
			$jml_tampil = 0;	
			if(isset($data['data_siswa_prestasi']['data'])){
				foreach($data['data_siswa_prestasi']['data'] as $index1 => $value1)
				{
					$sheet->setCellValue($x.$row, $value1['prestasi_tingkat']);
					$x++;
					$sheet->setCellValue($x.$row, $value1['prestasi_nama']);
					$x++;
					$sheet->setCellValue($x.$row, $value1['prestasi_juara']);
					$x++;
					$sheet->setCellValue($x.$row, $value1['prestasi_tahun']);
					$x++;
					$jml_tampil++;
				}
			}
			while($jml_tampil<2){
				$x++;$x++;$x++;$x++;
				$jml_tampil++;
			}
			
			//// KULIAH
			$jml_tampil = 0;
			if(isset($data['data_siswa_kuliah']['data'])){			
				foreach($data['data_siswa_kuliah']['data'] as $index1 => $value1)
				{
					$sheet->setCellValue($x.$row, $value1['kuliah_nama']);
					$x++;
					$sheet->setCellValue($x.$row, $value1['kuliah_jurusan']);
					$x++;
					$jml_tampil++;
				}
			}
			while($jml_tampil<2){
				$x++;$x++;
				$jml_tampil++;
			}
			
			//// KERJA
			$jml_tampil = 0;
			if(isset($data['data_siswa_kerja']['data'])){				
				foreach($data['data_siswa_kerja']['data'] as $index1 => $value1)
				{
					$sheet->setCellValue($x.$row, $value1['kerja_nama']);
					$x++;
					$sheet->setCellValue($x.$row, $value1['kerja_jabatan']);
					$x++;
					$jml_tampil++;
				}
			}
			while($jml_tampil<2){
				$x++;$x++;
				$jml_tampil++;
			}
			
		}
		
		/// AUTO WITDH
		$x = 'B';
		$last_x='';
		$sheet->getColumnDimension('A')->setAutoSize(true);
		foreach($set_value as $index => $value)
		{
			$sheet->getColumnDimension($x)->setAutoSize(true);
			$x++;
		}
		foreach($set_value_option as $index => $value)
		{
			$sheet->getColumnDimension($x)->setAutoSize(true);
			$x++;
			$last_x = $x;
		}
		
		/// STYLE
		$sheet->getStyle("A3:".$last_x."3")->getFont()->setBold(true);
		$styleTable = array(
			  'borders' => array(
				  'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN
				  )
			  )
		  );
		$sheet->getStyle("A3:".$last_x.$row)->applyFromArray($styleTable);
		/*
		$_cell_input = array(
				"C4:G".$row,
		);*/
		//excel_security_cell_lock($sheet, 'A1:FA'.$row);
		//excel_security_cell_unlock($sheet, $_cell_input);
		
		
		// kunci sheet
		excel_security_sheet_lock($sheet);
		
		return excel_output_2007($excel_obj, 'Download_peserta_daftar_ulang.xlsx');
    }
}