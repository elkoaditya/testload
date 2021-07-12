<?php

class Jurusan extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_dakd_jurusan',
				),
				'data/akademik/jurusan/browse' => array(
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array('term' => 'clean'),
				),
				'data/akademik/jurusan/form' => array(
						'user' => array('admin', 'sdm'),
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'kode' => NULL,
										'nama' => NULL,
										'deskripsi' => NULL,
										'aktif' => 1,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'kode',
												'label' => 'kode jurusan',
												'rules' => 'require|trim|alpha_dot|max_length[10]',
										),
										array(
												'field' => 'nama',
												'label' => 'nama jurusan',
												'rules' => 'required|trim|alpha_dot_space|min_length[2]|max_length[50]',
										),
										array(
												'field' => 'deskripsi',
												'label' => 'deskripsi jurusan',
												'rules' => 'clean|max_length[300]',
										),
										array(
												'field' => 'aktif',
												'label' => 'keaktifan',
												'rules' => 'as_bool',
										),
								),
								'kode' => array(
										array(
												'field' => 'kode',
												'label' => 'kode jurusan',
												'rules' => 'require|trim|alpha_dot|max_length[10]|is_unique[dakd_jurusan.kode]'
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama jurusan',
												'rules' => 'required|trim|alpha_dot_space|min_length[2]|max_length[50]|is_unique[dakd_jurusan.nama]'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'jurusan');
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'jurusan');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/akademik/jurusan/browse');
		$this->d['resultset'] = $this->m_dakd_jurusan->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat mengubah data jurusan.", 'data/akademik/jurusan');

		$this->_set('data/akademik/jurusan/form');
		$this->form->init('m_dakd_jurusan', 'data/akademik/jurusan');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dakd_jurusan->save())
				return redir("data/akademik/jurusan");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/akademik/jurusan/id');
		$this->_rowset('m_dakd_jurusan', $id, 'data/akademik/jurusan');
		$this->_view();
	}

}
