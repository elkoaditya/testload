<?php

class Kategori_mapel extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'model' => 'm_dakd_kategori_mapel',
				),
				'data/akademik/kategori_mapel/browse' => array(
						'library' => 'pagination',
						'request' => array('term' => 'clean'),
				),
				'data/akademik/kategori_mapel/form' => array(
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'kode' => NULL,
										'nama' => NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'kode',
												'label' => 'kode kategori mapel',
												'rules' => 'required|trim|alpha_dot_space|max_length[10]',
										),
										array(
												'field' => 'nama',
												'label' => 'nama kategori mapel',
												'rules' => 'required|trim|min_length[2]|max_length[40]',
										),
								),
								'kode' => array(
										array(
												'field' => 'kode',
												'label' => 'kode kategori mapel',
												'rules' => 'required|trim|alpha_dot_space|max_length[10]|is_unique[dakd_kategori_mapel.kode]'
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama kategori_mapel',
												'rules' => 'required|trim|min_length[2]|max_length[40]|is_unique[dakd_kategori_mapel.nama]'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'kategori_mapel');
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'kategori_mapel');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/akademik/kategori_mapel/browse');
		$this->d['resultset'] = $this->m_dakd_kategori_mapel->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat mengubah data kategori mapel.", 'data/akademik/kategori_mapel');

		$this->_set('data/akademik/kategori_mapel/form');
		$this->form->init('m_dakd_kategori_mapel', 'data/akademik/kategori_mapel');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dakd_kategori_mapel->save())
				return redir("data/akademik/kategori_mapel");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/akademik/kategori_mapel/id');
		$this->_rowset('m_dakd_kategori_mapel', $id, 'data/akademik/kategori_mapel');
		$this->_view();
	}

}
