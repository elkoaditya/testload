<?php

class Sdm extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'							 => array(
				'user'	 => array('admin', 'sdm'),
				//'user' => '#login',
				'model'	 => 'm_nilai_siswa',
			),
			'laporan/sdm/browse'					 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'			 => 'clean',
					'kelas_id'		 => 'as_int',
					'siswa_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'laporan/sdm/id'						 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => array('m_nilai_siswa_pelajaran'),
			),
			
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'siswa');
		$d['view'] = cfguc_view('akses', 'nilai', 'siswa');
		$d['walikelas'] = (array) cfgu('walikelas');
		$d['user_siswa'] = user_role('siswa');

		
		if (!$d['view'] && !$d['walikelas'] && !$d['user_siswa'])
			return alert_info('Anda tidak terkait dengan siswa apapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('laporan/sdm/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_siswa->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('laporan/sdm/id');
		$this->_rowset('m_nilai_siswa', $id, 'laporan/sdm');

		$d = & $this->d;
		$d['pelajar'] = ($d['user']['id'] == $d['row']['siswa_id']);
		$d['walikelasybs'] = ($d['row']['kelas_wali_id'] == $d['user']['id']);
		$d['gurubkybs'] = ($d['row']['kelas_gurubk_id'] == $d['user']['id']);

		if (!$d['admin'] && !$d['pelajar'] && !$d['walikelasybs'])
			return alert_error('Anda tidak dapat mengakses nilai siswa.', '');

		$d['resultset'] = $this->m_nilai_siswa_pelajaran->siswa($id, $index, 100);
		$d['ekskul_result'] = $this->m_nilai_siswa->subrow_ekskul($id);
		$d['org_result'] = $this->m_nilai_siswa->subrow_org($id);

		$this->_view();

	}

	

}
