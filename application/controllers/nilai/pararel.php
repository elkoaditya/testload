<?php

class Pararel extends MY_Controller
{

	// utama

	public function __construct()
	{
		parent::__construct(array(
			'controller'				 => array(
				'user'	 => '#login',
				'model'	 => 'm_nilai_kelas',
			),
			'nilai/kelas/browse'		 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_option',
				'helper'	 => 'form',
				'request'	 => array(
					'kelas_id'		 => 'as_int',
					'semester_id'	 => 'as_int',
				),
			),
			'nilai/kelas/id'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model'		 => 'm_nilai_siswa',
				'helper'	 => 'form',
				'request'	 => array(
					'term' => 'clean',
				),
			),
			'nilai/kelas/leger'			 => array(
				'user'		 => array('admin', 'sdm'),
				'model' => 'm_nilai_siswa',
			),
			'nilai/kelas/leger_excel'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'konversi_nilai',
				'model'		 => 'm_nilai_siswa',
			),
			'nilai/kelas/leger_excel_6semester'	 => array(
				'user'		 => array('admin', 'sdm'),
				'library'	 => 'konversi_nilai',
				'model'		 => 'm_nilai_siswa',
			),
			'nilai/kelas/expor'			 => array(
				'request' => array(
					'term' => 'clean',
				),
			),
			'nilai/kelas/impor'			 => array(
				'library'	 => 'form',
				'helper'	 => 'form',
			),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'kelas');
		$d['view'] = cfguc_view('akses', 'nilai', 'kelas');
		$d['walikelas'] = cfgu('walikelas');
		$d['kelas_terkait'] = $this->m_nilai_kelas->dm['kelas_terkait'];

		if (!$d['kelas_terkait'])
			return alert_info('Saat ini Anda tidak terkait dengan kelas manapun.', '');

	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/kelas/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_kelas->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('nilai/kelas/id');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');

		$d = & $this->d;
		$d['siswa_resultset'] = $this->m_nilai_kelas->rowsub_siswa($d['row']['id'], $index, 50);

		$this->_view();

	}

	public function leger($id = 0, $html = FALSE)
	{

		$d = & $this->d;

		$this->_set('nilai/kelas/leger');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');
		$this->m_nilai_kelas->leger($id);

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		if ($html)
			return $this->_view();

		$this->_pdf("leger_{$d['row']['kelas_nama']}_{$d['row']['id']}");

	}

	public function leger_dump($id = 0)
	{

		$d = & $this->d;

		$this->_set('nilai/kelas/leger');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');
		$this->m_nilai_kelas->leger($id);

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		$this->_dump();

	}

	public function leger_excel_6semester($id = 0,$mode='teori',$original = 0)
	{
		$this->_set('nilai/kelas/leger_excel_6semester');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');
		$this->m_nilai_kelas->leger_excel_6semester($id, $mode, $original);

	}
	
	public function leger_excel($id = 0,$mode='UTS',$original = 0)
	{
		$this->_set('nilai/kelas/leger_excel');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');
		$this->m_nilai_kelas->leger_excel($id, $mode, $original);

	}

	public function peringkat($id = 0, $html = FALSE)
	{

		$d = & $this->d;

		$this->_set('nilai/kelas/peringkat');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');
		$this->m_nilai_kelas->peringkat($id);

		if ($d['error'])
			return redir("nilai/kelas/{$id}");

		if ($html)
			return $this->_view();

		$this->_pdf("peringkat_{$d['row']['kelas_nama']}_{$d['row']['id']
			}

");

	}

	public function expor($id = 0)
	{
		$d = & $this->d;

		$this->_set('nilai/kelas/expor');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');

		$d['resultset'] = $this->m_nilai_kelas->rowsub_siswa($id, 0, 1024);

		if ($d['resultset']['selected_rows'] == 0)
			return alert_info('Daftar nilai siswa tidak ditemukan. Periksa peserta kelas dan filter pencarian.', "nilai/kelas/{$id}");

		$this->m_nilai_kelas->expor();

	}

	public function impor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		if (!$d['walikelas'] && !$d['admin'])
			return alert_error('Anda bukan walikelas.', 'nilasi/kelas');

		$this->_set('nilai/kelas/impor');
		$this->_rowset('m_nilai_kelas', $id, 'nilai/kelas');

		$d['wali_ybs'] = ($d['user']['id'] == $d['row']['kelas_wali_id']);

		if (!$d['admin'] && !$d['wali_ybs'])
			return alert_error('Anda tidak dapat mengakses nilai kelas.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/kelas/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error'])
			if ($this->m_nilai_kelas->impor())
				return;

		$this->form->set();
		$this->_view();

	}

}
