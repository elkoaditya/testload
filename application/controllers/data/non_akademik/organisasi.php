<?php

class Organisasi extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'model' => 'm_dnakd_organisasi',
				),
				'data/non_akademik/organisasi/browse' => array(
						'model' => 'm_option',
						'library' => 'pagination',
						'helper' => array('form'),
						'request' => array(
								'term' => 'clean',
								'pembina_id' => 'as_int',
						),
				),
				'data/non_akademik/organisasi/form' => array(
						'model' => 'm_option',
						'library' => 'form',
						'helper' => array('form', 'text'),
						'data' => array(
								'row' => array(
										'id' => 0,
										'nama' => NULL,
										'cuplikan' => NULL,
										'tentang' => NULL,
										'pembina_id' => NULL,
										'aktif' => 1,
								),
						),
						'validasi-umum' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama organisasi',
												'rules' => 'required|trim|alpha_dot_space|min_length[2]|max_length[40]',
										),
										array(
												'field' => 'tentang',
												'label' => 'deskripsi organisasi',
												'rules' => 'max_length[2048]',
										),
										array(
												'field' => 'aktif',
												'label' => 'keaktifan',
												'rules' => 'as_bool',
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama organisasi',
												'rules' => 'required|trim|alpha_dot_space|min_length[2]|max_length[40]|is_unique[dnakd_organisasi.nama]'
										),
								),
						),
						'validasi-aktif' => array(
								array(
										array(
												'field' => 'pembina_id',
												'label' => 'pembina organisasi',
												'rules' => 'required|sdm_aktif'
										),
								),
						),
				),
		));
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/non_akademik/organisasi/browse');
		$this->d['resultset'] = $this->m_dnakd_organisasi->browse($index, 20);
		$this->d['opsi_pembina'] = $this->m_option->guru(TRUE);
		$this->_view();
	}

	public function form() {
		$this->d['row_id'] = (int) $this->input->get_post('id');
		$admin = cfguc_admin('akses', 'data', 'non_akademik', 'organisasi');

		if (!$admin)
			return alert_error("Anda tidak dapat mengubah data organisasi.", 'data/non_akademik/organisasi');

		$this->_set('data/non_akademik/organisasi/form');
		$this->form->init('m_dnakd_organisasi', 'data/non_akademik/organisasi');

		if ($this->d['post_request'] && !$this->d['error'])
			if ($this->m_dnakd_organisasi->save())
				return redir("data/non_akademik/organisasi");

		$this->d['opsi_pembina'] = $this->m_option->guru();
		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/non_akademik/organisasi/id');
		$this->_rowset('m_dnakd_organisasi', $id, 'data/non_akademik/organisasi');
		$this->_view();
	}

}
