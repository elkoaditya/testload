<?php

class Angket_ljs extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_angket_ljs',
						'helper' => 'soal',
				),
				'kbm/angket_ljs/form' => array(
						'user' => array('sdm', 'siswa', 'admin'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'angket' => array(
										'id' => 0,
								),
						),
				),
				'kbm/angket_ljs/browse' => array(
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'angket_id' => 'as_int',
								'user_id' => 'as_int',
						),
				),
				'kbm/angket_ljs/id' => array(
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'angket_id' => 0,
								),
								'angket' => array(
										'id' => 0,
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
		$this->d['user']['menilai_id']=0;
	}
	
	public function _rowset_angket() {
		$d = & $this->d;

		if (!$d['request']['angket_id'])
			return alert_info('Pilih nama soal angket yang hendak ditampilkan.', 'kbm/angket');

		$this->_rowset('m_kbm_angket', $d['request']['angket_id'], 'kbm/angket', 'angket');

		$d['angket']['#available'] = $this->m_kbm_angket->availability($d['angket']);
		$d['author_ybs'] = ($d['user']['id'] == $d['angket']['author_id']);
		$d['pengajar_ybs'] = mengajar($d['angket']['pelajaran_id']);

		if (!$d['author_ybs'] && !$d['pengajar_ybs'] && !$d['view'] && $d['user']['role'] != 'siswa')
			return alert_error("Anda tak diperbolehkan mengakses ljs angket.", 'kbm/angket');
	}
	
	public function form($menilai_id=0) {
		$uri_angket = 'kbm/angket';
		$d = & $this->d;
		$d['user']['menilai_id'] = $menilai_id;
		
		$this->_set('kbm/angket_ljs/form');
		$this->form->init('m_kbm_angket', $uri_angket, 'angket');

		if (!$d['angket']['id'])
			return alert_error('Pilih angket yang hendak dikerjakan.', $uri_angket);

		$d['angket']['#available'] = $this->m_kbm_angket->availability($d['angket'], TRUE);

		if (!$d['angket']['#available'])
			return redir($uri_angket);

		// mulai ambil data soal

		$d['soal_result'] = $this->m_kbm_angket_ljs->soal($d['angket']);

		if ($d['soal_result']['selected_rows'] == 0)
			return alert_error('Data error, butir soal tidak ditemukan.', $uri_angket);

		// prosesi jawaban

		if (!$d['error'] && $d['post_request'])
			if ($this->m_kbm_angket_ljs->save())
				return redir("kbm/angket");

		// output ljs pengerjaan

		$d['form']['time_start'] = $d['time'];
		$d['form']['dtm_start'] = $d['datetime'];
		$d['form']['ljs_id'] = 0;
		
		$this->form->set();
		$this->_view();
	}
	
	public function browse($index = 0) {
		$this->_set('kbm/angket_ljs/browse');
		$this->_rowset_angket();
		$this->d['resultset'] = $this->m_kbm_angket_ljs->browse($index, 50);
		$this->_view();
	}
	
	public function id($id = 0,$menilai_id=0) {
		$uri_angket = 'kbm/angket';
		$d = & $this->d;
		$d['user']['menilai_id'] = $menilai_id;
		
		$this->_set('kbm/angket_ljs/id');
		$this->_rowset('m_kbm_angket_ljs', $id, $uri_angket);
		$this->_rowset('m_kbm_angket', $d['row']['angket_id'], $uri_angket, 'angket');

		$d['angket']['#available'] = $this->m_kbm_angket->availability($d['angket']);
		$d['author_ybs'] = ($d['user']['id'] == $d['angket']['author_id']);
		$d['siswa_ybs'] = ($d['user']['id'] == $d['row']['user_id']);

		if (!$d['author_ybs'] && !$d['siswa_ybs'] && !$d['view'])
			return alert_error('Anda tidak dapat melihat lembar jawab dimaksud.', '');

		$d['butir_result'] = $this->m_kbm_angket_ljs->butir_ljs($id);

		if ($d['butir_result']['selected_rows'] == 0)
			return alert_error('Kesalahan! Butir jawaban tidak ditemukan.', "kbm/angket_nilai/browse?angket_id={$d['row']['angket_id']}");

		if ($this->input->get('pdf'))
			return $this->_pdf("ljs_{$d['row']['id']}_{$d['user']['role']}", 'pdf');

		$this->_view();
	}
}