<?php

class Ekstrakurikuler extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'	 => '#login',
				'model'	 => 'm_nilai_ekskul',
			),
			'nilai/ekstrakurikuler/browse'	 => array(
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'ekskul_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/ekstrakurikuler/id'		 => array(
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'term'		 => 'clean',
					'kelas_id'	 => 'as_int',
				),
			),
			'nilai/ekstrakurikuler/expor'	 => array(
				'helper'	 => 'excel',
				'request'	 => array(
					'kelas_list[]' => 'as_int',
				),
			),
			'nilai/ekstrakurikuler/impor'	 => array(
				'model'		 => 'm_option',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'ekskul');
		$d['view'] = cfguc_view('akses', 'nilai', 'ekskul');
		$d['ekskul_terkait'] = $this->m_nilai_ekskul->dm['ekskul_terkait'];

		if (empty($d['ekskul_terkait']))
			return alert_info('Saat ini Anda tidak terkait dengan ekskul manapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/ekstrakurikuler/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_ekskul->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('nilai/ekstrakurikuler/id');
		$this->_rowset('m_nilai_ekskul', $id, 'nilai/ekstrakurikuler');

		$d = & $this->d;
		$d['siswa_resultset'] = $this->m_nilai_ekskul->rowsub_siswa($d['row']['id'], $index, 50);

		$this->_view();

	}

	public function expor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/ekstrakurikuler/expor');
		$this->_rowset('m_nilai_ekskul', $id, 'nilai/ekstrakurikuler');

		$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if ($d['user']['role'] != 'admin')
		{
			if (!$d['admin'] && !$d['pembina_ybs'])
			{
				return alert_error('Anda tidak dapat mengakses nilai ekskul.', '');
			}

			if ($d['semaktif']['id'] != $d['row']['semester_id'])
			{
				return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/ekstrakurikuler/id/{$d['row']['id']}");
			}
		}

		$this->m_nilai_ekskul->expor($id);

	}

	public function impor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/ekstrakurikuler/impor');
		$this->_rowset('m_nilai_ekskul', $id, 'nilai/ekstrakurikuler');

		if ($d['user']['role'] != 'admin')
		{
			if ($d['semaktif']['id'] != $d['row']['semester_id'])
			{
				return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/ekstrakurikuler/id/{$d['row']['id']}");
			}
		}

		$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if (!$d['admin'] && !$d['pembina_ybs'])
			return alert_error('Anda tidak dapat mengakses nilai ekskul.', '');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_nilai_ekskul->impor())
				return redir("nilai/ekstrakurikuler/id/{$d['row']['id']}");

		$this->form->set();
		$this->_view();

	}

}
