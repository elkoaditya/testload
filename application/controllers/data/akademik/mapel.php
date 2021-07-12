<?php

class Mapel extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'model' => 'm_dakd_mapel',
				),
				'data/akademik/mapel/browse' => array(
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array('term' => 'clean'),
				),
				'data/akademik/mapel/form' => array(
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
												'label' => 'kode mapel',
												'rules' => 'required|trim|alpha_dot_space|max_length[10]',
										),
										array(
												'field' => 'nama',
												'label' => 'nama mapel',
												'rules' => 'required|trim|min_length[2]|max_length[128]',
										),
								),
								'kode' => array(
										array(
												'field' => 'kode',
												'label' => 'kode mapel',
												'rules' => 'required|trim|max_length[10]|is_unique[dakd_mapel.kode]'
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama mapel',
												'rules' => 'required|trim|min_length[2]|max_length[128]|is_unique[dakd_mapel.nama]'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'mapel');
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'mapel');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/akademik/mapel/browse');
		$this->d['resultset'] = $this->m_dakd_mapel->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$admin = cfguc_admin('akses', 'data', 'akademik', 'mapel');

		if (!$admin)
			return alert_error("Anda tidak dapat mengubah data mapel.", 'data/akademik/mapel');

		$this->_set('data/akademik/mapel/form');
		$this->form->init('m_dakd_mapel', 'data/akademik/mapel');

		if ($this->d['post_request'] && !$this->d['error'])
			if ($this->m_dakd_mapel->save())
				return redir("data/akademik/mapel");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/akademik/mapel/id');
		$this->_rowset('m_dakd_mapel', $id, 'data/akademik/mapel');
		$this->_view();
	}

}
