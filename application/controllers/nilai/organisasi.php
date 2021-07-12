<?php

class Organisasi extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'				 => array(
				'user'	 => '#login',
				'model'	 => 'm_nilai_org',
			),
			'nilai/organisasi/browse'	 => array(
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'org_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/organisasi/id'		 => array(
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
			'nilai/organisasi/expor'	 => array(
				'helper'	 => 'excel',
				'request'	 => array(
					'kelas_list[]' => 'as_int',
				),
			),
			'nilai/organisasi/impor'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'organisasi');
		$d['view'] = cfguc_view('akses', 'nilai', 'organisasi');
		$d['org_terkait'] = $this->m_nilai_org->dm['org_terkait'];

		if (empty($d['org_terkait']))
			return alert_info('Saat ini Anda tidak terkait dengan organisasi manapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/organisasi/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_org->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('nilai/organisasi/id');
		$this->_rowset('m_nilai_org', $id, 'nilai/organisasi');

		$d = & $this->d;
		$d['siswa_resultset'] = $this->m_nilai_org->rowsub_siswa($d['row']['id'], $index, 50);

		$this->_view();

	}

	public function expor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/organisasi/expor');
		$this->_rowset('m_nilai_org', $id, 'nilai/organisasi');

		$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if (!$d['admin'] && !$d['pembina_ybs'])
			return alert_error('Anda tidak dapat mengakses nilai org.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/organisasi/id/{$d['row']['id']}");

		$this->m_nilai_org->expor($id);

	}

	public function impor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/organisasi/impor');
		$this->_rowset('m_nilai_org', $id, 'nilai/organisasi');

		$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if (!$d['admin'] && !$d['pembina_ybs'])
			return alert_error('Anda tidak dapat mengakses nilai org.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/organisasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error'])
			if ($this->m_nilai_org->impor())
				return redir("nilai/organisasi/id/{$d['row']['id']}");

		$this->form->set();
		$this->_view();

	}

}
