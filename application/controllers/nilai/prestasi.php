<?php

class Prestasi extends MY_Controller
{

	// utama

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => '#login',
						'model' => 'm_nilai_prestasi',
				),
				'nilai/prestasi/browse' => array(
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'ekskul_id' => 'as_int',
								'semester_id' => 'as_int',
						),
				),
				'nilai/prestasi/id' => array(
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'kelas_id' => 'as_int',
						),
				),
				'nilai/prestasi/expor' => array(
						'helper' => 'excel',
						'request' => array(
								'kelas_list[]' => 'as_int',
						),
				),
				'nilai/prestasi/impor' => array(
						'model' => 'm_option',
						'library' => 'form',
						'helper' => 'form',
				),
		));

		$d = & $this->d;
		$d['admin'] = cfguc_admin('akses', 'nilai', 'ekskul');
		$d['view'] = cfguc_view('akses', 'nilai', 'ekskul');
		//$d['prestasi_terkait'] = $this->m_nilai_prestasi->dm['prestasi_terkait'];

		//if (empty($d['prestasi_terkait']))
			//return alert_info('Saat ini Anda tidak terkait dengan prestasi manapun.', '');
	}

	public function index()
	{
		$this->browse();

	}

	// akses data umum

	public function browse($index = 0)
	{
		$this->_set('nilai/prestasi/browse');

		$d = & $this->d;

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
		{
			$d['request']['semester_id'] = $d['semaktif']['id'];
		}

		$d['resultset'] = $this->m_nilai_prestasi->browse($index, 50);

		$this->_view();

	}

	public function id($id = 0, $index = 0)
	{
		$this->_set('nilai/prestasi/id');
		$this->_rowset('m_nilai_prestasi', $id, 'nilai/prestasi');

		$d = & $this->d;
		$d['siswa_resultset'] = $this->m_nilai_prestasi->rowsub_siswa($d['row']['id'], $index, 50);

		$this->_view();

	}

	public function expor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/prestasi/expor');
		$this->_rowset('m_nilai_prestasi', $id, 'nilai/prestasi');

		//$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if (!$d['admin'] )
			return alert_error('Anda tidak dapat mengakses nilai prestasi.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/prestasi/id/{$d['row']['id']}");
		//$this->_dump();
		$this->m_nilai_prestasi->expor($id);

	}

	public function impor($id = 0)
	{
		$d = & $this->d;

		if ($d['user']['role'] == 'siswa')
			return redir("nilai/siswa/id/{$d['user']['id']}");

		$this->_set('nilai/prestasi/impor');
		$this->_rowset('m_nilai_prestasi', $id, 'nilai/prestasi');

		if ($d['user']['role'] != 'admin')
		{
			return alert_error('Impor hanya dapat dilakukan melalui admin kurikulum.', 'nilai/pelajaran');
		}
		//$d['pembina_ybs'] = ($d['user']['id'] == $d['row']['pembina_id']);

		if (!$d['admin'] )
			return alert_error('Anda tidak dapat mengakses nilai prestasi.', '');

		if ($d['semaktif']['id'] != $d['row']['semester_id'])
			return alert_error('Impor hanya berlaku pada nilai semester aktif saja.', "nilai/prestasi/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error'])
			if ($this->m_nilai_prestasi->impor())
				return redir("nilai/prestasi/id/{$d['row']['id']}");

		$this->form->set();
		$this->_view();

	}

}
