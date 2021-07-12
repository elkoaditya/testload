<?php

class Evaluasi_tool extends MY_Controller {
	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_evaluasi_ljs',
						'helper' => 'soal',
				),
				'kbm/evaluasi_tool/recalculation' => array(
						'user' => array('sdm', 'admin'),
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'evaluasi_id' => 'as_int',
								'kelas_id' => 'as_int',
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

		$d['evaluasi']['#available'] = $this->m_kbm_evaluasi->availability($d['evaluasi']);
		$d['author_ybs'] = ($d['user']['id'] == $d['evaluasi']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['evaluasi']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'] && $d['user']['role'] != 'siswa')
			return alert_error("Anda tak diperbolehkan mengakses ljs evaluasi.", 'kbm/evaluasi');
	}

	public function recalculation($index = 0) {
		$this->_set('kbm/evaluasi_tool/recalculation');
		$this->_rowset_evaluasi();
		
		$this->d['resultset'] = $this->m_kbm_evaluasi_tool->recalculation($index, 50);
		
		print_r($this->d['resultset']);
		//$this->_view();
	}

}