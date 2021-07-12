<?php

class Angket_nilai extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('admin', 'sdm'),
						'model' => array('m_kbm_angket', 'm_kbm_angket_nilai'),
				),
				'kbm/angket_nilai/browse' => array(
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'order_by' => 'clean',
								'angket_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				'kbm/angket_nilai/download' => array(
						'request' => array(
								'term' => 'clean',
								'order_by' => 'clean',
								'angket_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
				'kbm/angket_nilai/statistik' => array(
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'angket_id' => 'as_int',
								'kelas_id' => 'as_int',
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}
	
	public function _rowset_angket() {
		$d = & $this->d;

		if (!$d['request']['angket_id'])
			return alert_info('Pilih nama soal angket yang hendak ditampilkan.', 'kbm/angket');

		$this->_rowset('m_kbm_angket', $d['request']['angket_id'], 'kbm/angket', 'angket');

		$d['author_ybs'] = ($d['user']['id'] == $d['angket']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['angket']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'])
			return alert_error("Anda tak diperbolehkan mengakses nilai angket.", 'kbm/angket');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		//$d = & $this->d;
		$this->_set('kbm/angket_nilai/browse');
		$this->_rowset_angket();
		$this->d['resultset'] = $this->m_kbm_angket_nilai->browse($index, 50);
		$this->_view();
	}
	
	public function download() {
		$this->_set('kbm/angket_nilai/download');
		$this->_rowset_angket();
		$this->m_kbm_angket_nilai->download();
	}
	
	public function statistik() {
		$d = & $this->d;

		$this->_set('kbm/angket_nilai/statistik');
		$this->_rowset_angket();
		$this->m_kbm_angket_nilai->statistik();

		if ($d['error'])
			return redir("kbm/angket/id/{$d['angket']['id']}");

		$this->_view();
	}
	
}