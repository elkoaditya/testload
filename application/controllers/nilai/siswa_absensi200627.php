<?php

class Siswa_absensi extends MY_Controller
{

	public function __construct()
	{
		$rule_nilai_angka = 'trim|numeric|max_length[6]';
		//$rule_nilai_predikat = 'trim|clean|max_length[6]|strtoupper';

		parent::__construct(array(
			'controller'				 => array(
				//'user'	 => array('admin', 'sdm'),
				'model'	 => 'm_nilai_siswa'
			),
			'nilai/siswa_absensi/form' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'absen_s',
							'label'	 => 'Nilai Absensi Sakit',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'absen_i',
							'label'	 => 'Nilai Absensi Ijin',
							'rules'	 => $rule_nilai_angka,
						),
						array(
							'field'	 => 'absen_a',
							'label'	 => 'Nilai Absensi Tanpa Keterangan',
							'rules'	 => $rule_nilai_angka,
						),
						
					),
				),
			),
			'nilai/siswa_absensi/form_aspri_ktsp' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(),
				),
			),
			'nilai/siswa_absensi/form_catatan_wali' => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'form',
				'helper'	 => 'form',
				'validasi'	 => array(
					array(
						array(
							'field'	 => 'note_walikelas',
							'label'	 => 'Catatan Wali Kelas',
							'rules'	 => 'clean|max_length[5000]',
						),
						
					),
				),
			),
			'nilai/siswa_absensi/download_rapor' => array(
				'user'		 => array('admin', 'sdm','siswa'),
			),
			'nilai/siswa_absensi/catatan_download_rapor' => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array('m_nilai_siswa_absensi'),
				'library'	 => 'form',
				'helper'	 => 'form',
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa') OR cfguc_admin('akses', 'nilai', 'pelajaran');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa') OR cfguc_view('akses', 'nilai', 'pelajaran');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
		{
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');
		}

	}

	public function form()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah absensi siswa.", TRUE);
		}


		$this->_set('nilai/siswa_absensi/form');
		$this->form->init('m_nilai_siswa', 'nilai/siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa->save())
			{
				$redir = "nilai/siswa/id/{$d['row']['id']}";

				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}
	
	public function form_aspri_ktsp()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah Akhlak Mulia dan Kepribadian.", TRUE);
		}


		$this->_set('nilai/siswa_absensi/form_aspri_ktsp');
		$this->form->init('m_nilai_siswa', 'nilai/siswa');

		//echo"aaaaaaaaaaaaaa";
		if ($d['post_request'] && !$d['error'])
		{
			//echo"bbbbbbbbbbbbbbbb";
			if ($this->m_nilai_siswa->save_kepribadian('aspri_ktsp'))
			{
				$redir = "nilai/siswa/id/{$d['row']['id']}";
				//echo"cccccccccc";
				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}
	
	public function form_catatan_wali()
	{
		$d = & $this->d;

		if (!$d['admin'])
		{
			return alert_error("Anda tidak dapat mengubah catatan walikelas.", TRUE);
		}


		$this->_set('nilai/siswa_absensi/form_catatan_wali');
		$this->form->init('m_nilai_siswa', 'nilai/siswa');

		if ($d['post_request'] && !$d['error'])
		{
			if ($this->m_nilai_siswa->save('catatan'))
			{
				$redir = "nilai/siswa/id/{$d['row']['id']}";

				return redir($redir);
			}
		}

		$this->form->set();
		$this->_view();

	}

	public function download_rapor($id, $nis, $tipe=''){
		
		$d = & $this->d;
		$this->_set('nilai/siswa_absensi/download_rapor');
		
		$datetime = date("Y-m-d h:i:s");
		$array = array(
			'siswa_id' 	=> $id,
			'time'		=> $datetime,
		);
		$this->db->insert('record_download_rapor', $array);

		if($tipe!=''){
			$tipe = '_'.$tipe;
		}

		$file = base_url()."content/generate_rapor".$tipe."/".APP_SCOPE."/".$nis.".pdf";
												
		$file_headers = @get_headers($file);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			$exists = false;
		}
		else {
			$exists = true;
		}
			
		if($exists==true){
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=" . urlencode("RAPOR".$nis.".pdf"));   
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($file));
			flush(); // this doesn't really matter.
			$fp = fopen($file, "r");
			while (!feof($fp))
			{
				echo fread($fp, 65536);
				flush(); // this is essential for large downloads
			} 
			fclose($fp); 
			
		}else{
			echo "FILE NOT EXIT";
		}
		
		//download_edaran();
	}
	
	public function download_edaran(){
		
		$d = & $this->d;
		$this->_set('nilai/siswa_absensi/download_rapor');
		
		$nama = "EDARAN_LIBUR_KENAIKAN_KELAS.pdf";
		$file = base_url()."content/generate_rapor/".APP_SCOPE."/".$nama;
												
		$file_headers = @get_headers($file);
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
			$exists = false;
		}
		else {
			$exists = true;
		}
			
		if($exists==true){
			
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=" . urlencode($nama));   
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($file));
			flush(); // this doesn't really matter.
			$fp = fopen($file, "r");
			while (!feof($fp))
			{
				echo fread($fp, 65536);
				flush(); // this is essential for large downloads
			} 
			fclose($fp); 
			
		
		}else{
			echo "FILE NOT EXIT";
		}
		
	}
	
	public function catatan_download_rapor($aksi = '')
	{
		$this->_set('nilai/siswa_absensi/catatan_download_rapor');

		$d = & $this->d;
		$sql_opsi_kelas = "select id, nama from dakd_kelas where aktif = 1 ";
		$format = ($aksi === 'format');

		if ($d['semaktif']['id'] < 1)
			return alert_error('Tak dapat mengimpor nilai pada masa jeda semester.', 'nilai/siswa');

		if (!$d['admin'])
			$sql_opsi_kelas .= " and (wali_id = {$d['user']['id']})";

		$d['opsi_kelas'] = $this->md->result_series('id', 'nama', $sql_opsi_kelas);
		//print_r($d['opsi_kelas']);
		if (empty($d['opsi_kelas']))
			return alert_error('Anda tidak terkait dengan kelas manapun untuk mengisi absensi dan kepribadian.', '');

		if ($format && $d['post_request'])
			return $this->m_nilai_siswa_absensi->catatan_download_rapor();

		$this->form->set();
		$this->_view();

	}
}
