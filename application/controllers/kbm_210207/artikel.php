<?php

class Artikel extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_kbm_artikel',
				),
				'kbm/artikel/browse' => array(
						'library' => 'pagination',
						'model' => 'm_option',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'semester_id' => 'as_int',
								'pelajaran_id' => 'as_int',
								'kelas_id' => 'as_int',
								'mapel_id' => 'as_int',
								'author_id' => 'as_int',
						),
				),
				'kbm/artikel/id' => array(
				),
				'kbm/artikel/form' => array(
						'model' => array('m_option'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'semester_id' => 0,
										'author_id' => NULL,
										'kelas_id' => NULL,
										'pelajaran_id' => NULL,
										'mapel_id' => NULL,
										'nama' => NULL,
										'cuplikan' => NULL,
										'konten' => NULL,
										'lampiran' => NULL,
										'guru_id' => NULL,
										'guru_catatan' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama',
												'rules' => 'clean|required|min_length[2]|max_length[200]',
										),
										array(
												'field' => 'pelajaran_id',
												'label' => 'pelajaran',
												'rules' => 'required',
										),
										array(
												'field' => 'konten',
												'label' => 'konten artikel',
												'rules' => 'trim|max_length[64000]',
										),
								),
						),
						'validasi-guru' => array(
								array(
										array(
												'field' => 'guru_catatan',
												'label' => 'catatan ' . strtolower(GURU_ALIAS),
												'rules' => 'trim|max_length[64000]',
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'kbm', 'artikel');
		$this->d['view'] = cfguc_view('akses', 'kbm', 'artikel');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('kbm/artikel/browse');
		$this->d['resultset'] = $this->m_kbm_artikel->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$this->_set('kbm/artikel/form');
		$this->form->init('m_kbm_artikel', 'kbm/artikel');

		$d = & $this->d;
		$d['siswa'] = user_role('siswa');
		$d['author_ybs'] = (($d['user']['id'] == $d['row']['author_id']) OR ($d['row']['id'] == 0 && $d['siswa'] ));
		$d['guru_ybs'] = ($d['user']['id'] == $d['row']['guru_id']);

		if (!$d['admin'] && !$d['guru_ybs'] && !$d['author_ybs'])
			return alert_error("Anda tidak dapat mengubah data artikel." . 'kbm/artikel');

		if ($d['row']['id'] == 0 && $d['user']['role'] != 'siswa')
			return alert_error("Hanya siswa yang dapat membuat artikel baru" . 'kbm/artikel');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_kbm_artikel->save())
				return redir("kbm/artikel/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('kbm/artikel/id');
		$this->_rowset('m_kbm_artikel', $id, 'kbm/artikel');
		$this->_view();
	}

}
