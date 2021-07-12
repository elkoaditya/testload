<?php

class Nilai extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'						 => array(
				'user'	 => '#login',
				'model'	 => 'm_nilai_pelajaran',
			),
			'nilai/nilai/browse'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
					'semester_id',
				),
			),
			'nilai/nilai/id'				 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => array('m_nilai_siswa_pelajaran', 'm_option'),
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
		));
		
		$dua_kurikulum = array(
			'demo',
			'sman8smg','sman9smg','sman14smg','sma_michael',
			'smaissa1smg',
			'sma_setiabudhi','sma_setiabudhi_rev16_17',
			'smk_nusaputera','smk_penerbangan',
			'smakristen1_wsb','smkpltarcisius',
			'sma_terbang','smp_terbang', 'smkn6smg');
		
		foreach($dua_kurikulum as $dk)
		{
			if(strtolower(APP_SCOPE)==$dk)
			{
				$this->load->model('costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_ktsp','cm_nilai_pelajaran_ktsp');
				$this->load->model('costumized/' . strtolower(APP_SCOPE) . '/cm_nilai_pelajaran_k13','cm_nilai_pelajaran_k13');
			}
		}
		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'pelajaran');
		$d['view'] = cfguc_view('akses', 'nilai', 'pelajaran');
		$d['mengajar_list'] = (array) cfgu('mengajar_list');
		$d['pelajaran_list'] = (array) cfgu('pelajaran_list');

		if (!$d['view'] && !$d['mengajar_list'] && !$d['pelajaran_list'])
			return alert_info('Anda tidak terkait dengan pelajaran apapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/nilai/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_pelajaran->browse($index, 50);

			// return $this->_dump();
		$this->_view();

	}

	public function id( $index = 0, $dump = '')
	{
		$this->_set('nilai/nilai/id');
		// $this->_rowset('m_nilai_pelajaran', $id, 'nilai/pelajaran');

		$d = & $this->d;
		// $this->d['pengajar'] = ($this->d['user']['id'] == $this->d['row']['guru_id']);
		$this->d['resultset'] = $this->m_nilai_siswa_pelajaran->pelajaran("x",$index, 50);
		$this->d['kelas'] = $this->m_nilai_siswa_pelajaran->pelajaran_kelas("x");

			// return $this->_dump();
		if ($dump === 'dump')
		{
			return $this->_dump();
		}
//return alert_info(print_r($this->d));
		$this->_view(APP_SCOPE);

	}


}
