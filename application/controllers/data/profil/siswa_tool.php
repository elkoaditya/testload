<?php

class Siswa_tool extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'	 => array('#login'),
				'model'	 => array('m_dprofil_siswa', 'm_dprofil_siswa_tool'),
			),
			'data/profil/siswa_tool/status_naik_kelas'		 => array(
				'model'		 => 'm_option',
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term' => 'clean',
					'kelas_id',
					'kelas_grade',
					'aktif',
				),
			),
			
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'profil', 'siswa');
		$this->d['view'] = cfguc_view('akses', 'data', 'profil', 'siswa');

	}

	public function status_naik_kelas($index = 0)
	{
		$this->_set('data/profil/siswa_tool/status_naik_kelas');

		$d = & $this->d;
		
		if ($d['semaktif']['id'] > 0)
		{
			return alert_error("Hanya bisa digunakan saat jeda semester.", 'data/profil/siswa');
		}
		
		//ganti_kelas
		if($this->input->post('ganti_kelas'))
		{	$this->m_dprofil_siswa_tool->status_naik_kelas();	}

		$d['resultset'] = $this->m_dprofil_siswa->browse($index, 600);

		$this->_view();

	}

}