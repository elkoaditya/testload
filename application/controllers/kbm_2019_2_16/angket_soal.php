<?php

class Angket_soal extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('admin', 'sdm'),
						'model' => array('m_kbm_angket', 'm_kbm_angket_soal'),
						'helper' => 'soal',
				),
				'kbm/angket_soal/browse' => array(
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'angket_id' => 'as_int',
						),
				),
				'kbm/angket_soal/form' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'angket_id' => 'as_int',
						),
						'data' => array(
								'row' => array(
										'id' => 0,
										'angket_id' => NULL,
										'pertanyaan' => NULL,
										'gambar' => NULL,
										//'poin_min' => NULL,
										//'poin_max' => NULL,
										'pilihan' => array(
												/*'kunci' => array(),*/
												'pengecoh' => array(),
										),
										'poin_1' => NULL,
										'poin_2' => NULL,
										'poin_3' => NULL,
										'poin_4' => NULL,
										'poin_5' => NULL,
								),
								'pilihan' => array(
										//'kunci' => NULL,
										'pilihan-1' => NULL,
										'pilihan-2' => NULL,
										'pilihan-3' => NULL,
										'pilihan-4' => NULL,
										'pilihan-5' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'pertanyaan',
												'label' => 'nama angket_soal',
												'rules' => 'required|clean_html|max_length[32000]',
										),
										/*array(
												'field' => 'poin_max',
												'label' => 'grade angket_soal',
												'rules' => 'required|in_range[1-100]|as_int',
										),*/
								),
						),
				),
				'kbm/angket_soal/delete' => array(
						'library' => 'form',
						'helper' => 'form',
						'request' => array(
								'angket_id' => 'as_int',
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'evaluasi');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}
	
	public function _rowset_angket($angket_id) {

		if ($angket_id <= 0)
			return alert_info('Pilih nama soal angket yang hendak ditampilkan.', 'kbm/angket');

		$d = & $this->d;
		$d['angket'] = $this->_rowset('m_kbm_angket', $angket_id, 'kbm/angket', FALSE);
		$d['author_ybs'] = ($d['user']['id'] == $d['angket']['author_id']);

		if (!$d['author_ybs'] && !$d['view'])
			return alert_error("Anda tak diperbolehkan mengakses soal angket.", 'kbm/angket');
	}
	
	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$d = & $this->d;
		$this->_set('kbm/angket_soal/browse');
		$this->_rowset_angket($d['request']['angket_id']);
		$d['resultset'] = $this->m_kbm_angket_soal->browse($index, 50);
		$this->_view();
	}
	
	public function id($id = 0) {
		$d = & $this->d;
		$this->_set('kbm/angket_soal/id');
		$this->_rowset('m_kbm_angket_soal', $id, 'kbm/angket');
		$this->_rowset_angket($d['row']['angket_id']);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;
		$tambah = (bool) $this->input->post('tambah');

		$this->_set('kbm/angket_soal/form');
		$this->form->init('m_kbm_angket_soal', 'kbm/angket');

		$d['form']['redir'] = $this->input->get_post('redir');

		if ($d['row']['id'] > 0)
			$d['form']['angket_id'] = $d['row']['angket_id'];

		else if (!$d['post_request'] OR !isset($d['form']['angket_id']))
			$d['form']['angket_id'] = $this->input->get_post('angket_id');

		$this->_rowset_angket($d['form']['angket_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal angket.", 'kbm/angket');

		if ($d['angket']['closed'])
			return alert_error("Tak dapat mengubah pertanyaan karena telah ditutup.", "kbm/angket/id/{$d['angket']['id']}");

		if ($d['row'] == 0 && $d['angket']['published'])
			return alert_error("Tak dapat menambah pertanyaan karena telah dipublikasikan.", "kbm/angket/id/{$d['angket']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['angket']['id'] > 0 && $d['angket']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");
		
		if ($d['post_request'] && !$d['error']):
			if ($this->m_kbm_angket_soal->save()):

				if ($tambah):
					$redir = "kbm/angket_soal/form?angket_id={$d['form']['angket_id']}&redir={$d['form']['redir']}";

				elseif ($d['form']['redir']):
					$redir = $d['form']['redir'];

				else:
					$redir = "kbm/angket_soal/browse?angket_id={$d['form']['angket_id']}";

				endif;

				return redir($redir);

			endif;
		endif;


		$this->form->set();
		$this->_view();
	}

	public function delete() {
		$d = & $this->d;
		$this->_set('kbm/angket_soal/delete');
		$this->form->init('m_kbm_angket_soal', 'kbm/angket');

		if (!$d['form']['id'])
			return redir('kbm/angket');

		$this->_rowset_angket($d['row']['angket_id']);

		if (!$d['author_ybs'] && !$d['admin'])
			return alert_error("Anda tak diperbolehkan mengubah soal angket.", 'kbm/angket');

		if ($d['angket']['published'])
			return alert_error("Tak dapat menghapus pertanyaan karena telah dipublikasikan.", "kbm/angket/id/{$d['angket']['id']}");

		if ($d['semaktif']['id'] == 0)
			return alert_error("Tidak dapat pertanyaan mengubah angket pada masa jeda semester.", 'kbm/angket');

		else if ($d['angket']['id'] > 0 && $d['angket']['semester_id'] != $d['semaktif']['id'])
			return alert_error("Angket tersebut telah berlalu.", "kbm/angket/id/{$d['row']['id']}");

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_angket_soal->delete())
				return redir("kbm/angket/id/{$d['angket']['id']}");

		$this->form->set();
		$this->_view();
	}
}