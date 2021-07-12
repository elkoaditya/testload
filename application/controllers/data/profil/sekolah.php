<?php

class Sekolah extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
			'controller' => array(
				'model' => 'm_dprofil_sekolah',
			),
			'data/user/form' => array(
				'library' => 'form',
				'helper' => 'form',
				'data' => array(
					'row' => array(
						'id' => 0,
						'label' => NULL,
						'data' => NULL,
					),
				),
				'validationset' => array(
					array(
						array(
							'field' => 'data',
							'label' => 'isi data',
							'rules' => 'clean|max_length[512]',
						),
					),
					'username' => array(
						array(
							'field' => 'label',
							'label' => 'label',
							'rules' => 'trim|alpha_dot_space|max_length[40]|is_unique[dprofil_sekolah.label]'
						),
					),
				),
			),
		));
	}

	public function index() {
		$this->_set('data/profil/sekolah/index');
		//$this->d['resultset'] = $this->m_dprofil_sekolah->all();
		$this->_view();
	}

	public function form() {
		$this->d['row_id'] = (int) $this->input->get_post('id');
		$current_user = ($this->d['user']['id'] == $this->d['row_id']);
		$admin_user = cfguc_admin('akses', 'data', 'user');

		if (!$admin_user && !$current_user)
			return alert_error("Anda tidak dapat mengubah data user lain.");

		$this->_set('data/profil/sekolah/form');
		$this->form->init('m_data_user', 'data/user');

		if ($this->d['post_request'] && !$this->d['error'])
			if ($this->m_data_user->save())
				return redir("data/user/id/{$this->d['row_id']}");

		$this->form->set();
		$this->_view();
	}

}
