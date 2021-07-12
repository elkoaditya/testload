<?php

class Siswa_tool extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'									 => array(
				'user'	 => array('admin', 'sdm', 'siswa'),
				'model'	 => array('m_nilai_siswa', 'm_nilai_siswa_tool'),
			),
			'nilai/siswa_tool/status_akses_rapor'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
					'akses_rapor'	 => 'as_int',
				),
			),
			'nilai/siswa_tool/kartu'						 => array(
				'user'		 => array('admin', 'sdm', 'siswa'), 
				'model'		 => array('m_dprofil_siswa'),
				'request'	 => array(
					'term' 				=> 'clean',
					'kelas_id'		 	=> 'as_int',
					'siswa_id'		 	=> 'as_int',
					'aktif',
				),
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa') OR cfguc_admin('akses', 'nilai', 'ekskul');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa') OR cfguc_view('akses', 'nilai', 'ekskul');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
		{
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');
		}

	}
	
	public function status_akses_rapor($index = 0)
	{
		$this->_set('nilai/siswa_tool/status_akses_rapor');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}
		
		//keikutsertaan
		if($this->input->post('ganti_keikutsertaan'))
		{	$this->m_nilai_siswa_tool->status_akses_rapor();	}

		$d['resultset'] = $this->m_nilai_siswa->browse($index, 200);

		$this->_view();

	}
	
	public function kartu_ujian($kelas_id = 0, $siswa_id = 0)
	{
		//$mode = (strpos($id, '.pdf') === FALSE) ? 'I' : 'D';
		
		//$id = str_replace(".pdf", "", $id);
		
		$this->_set('nilai/siswa_tool/kartu');
		$d = & $this->d;
		
		if ($kelas_id > 0){
			
			$d['request']['kelas_id'] = $kelas_id;
			
		}elseif ($siswa_id > 0){
			
			$d['request']['siswa_id'] = $siswa_id;
		}
		$this->d['resultset'] = $this->m_dprofil_siswa->browse(0,50);
		// return $this->_dump();
		$this->load->library('mpdf');

		$abre_filename = APP_SUBDOMAIN ;
		$nama_file = 'Kartu Ujian' ;
		 
		return $this->_pdf($nama_file, $abre_filename );

	}
}