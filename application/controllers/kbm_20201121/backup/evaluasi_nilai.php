<?php

class Evaluasi_nilai extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('admin', 'sdm'),
						'model' => array('m_kbm_evaluasi', 'm_kbm_evaluasi_nilai'),
				),
				'kbm/evaluasi_nilai/browse' => array(
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'order_by' => 'clean',
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				'kbm/evaluasi_nilai/download' => array(
						'request' => array(
								'term' => 'clean',
								'order_by' => 'clean',
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				'kbm/evaluasi_nilai/statistik' => array(
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				'kbm/evaluasi_nilai/rekap' => array(
						'request' => array(
								'evaluasi_id' => 'as_int',
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}

	public function _rowset_evaluasi() {
		$d = & $this->d;

		if (!$d['request']['evaluasi_id'])
			return alert_info('Pilih nama soal evaluasi yang hendak ditampilkan.', 'kbm/evaluasi');

		$this->_rowset('m_kbm_evaluasi', $d['request']['evaluasi_id'], 'kbm/evaluasi', 'evaluasi');

		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['evaluasi']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'])
			return alert_error("Anda tak diperbolehkan mengakses nilai evaluasi.", 'kbm/evaluasi');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('kbm/evaluasi_nilai/browse');
		$this->_rowset_evaluasi();
		
		//keikutsertaan
		if($this->input->post('ganti_keikutsertaan'))
		{	$this->m_kbm_evaluasi_nilai->keikutsertaan();	}
		
		
		$this->d['resultset'] = $this->m_kbm_evaluasi_nilai->browse($index, 50);
		$this->_view();
	}

	public function download() {
		$this->_set('kbm/evaluasi_nilai/download');
		$this->_rowset_evaluasi();
		$this->m_kbm_evaluasi_nilai->download();
	}

	public function statistik() {
		$d = & $this->d;

		$this->_set('kbm/evaluasi_nilai/statistik');
		$this->_rowset_evaluasi();
		$this->m_kbm_evaluasi_nilai->statistik();

		if ($d['error'])
			return redir("kbm/evaluasi/id/{$d['evaluasi']['id']}");

		$this->_view();
	}

	public function rekap() {
		$d = & $this->d;

		if ($d['semaktif']['id'] > 0)
			return alert_error("Nilai tidak dapat direkap ke rapor pada masa jeda semester.", 'data/akademik/kelas');

		$this->_set('kbm/evaluasi_nilai/rekap');
		$this->_rowset_evaluasi();

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_evaluasi_nilai->rekap())
				return redir("nilai/pelajaran/id/{$d['evaluasi']['pelajaran_nilai_id']}");

		$this->form->set(array('id' => $d['']));
		$this->_view();
	}

}
