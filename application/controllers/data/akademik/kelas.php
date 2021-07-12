<?php

class Kelas extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => '#login',
						'model' => 'm_dakd_kelas',
				),
				'data/akademik/kelas/browse' => array(
						'model' => 'm_option',
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array(
								'term' => 'clean',
								'jurusan_id' => 'as_int',
								'grade' => 'as_int',
								'wali_id' => 'as_int',
						),
				),
				'data/akademik/kelas/form' => array(
						'model' => 'm_option',
						'library' => 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'nama' => NULL,
										'jurusan_id' => NULL,
										'grade' => NULL,
										'wali_id' => NULL,
										'aktif' => 1,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama kelas',
												'rules' => 'required|trim|alpha_dot_space|max_length[32]|strtoupper',
										),
										array(
												'field' => 'jurusan_id',
												'label' => 'jurusan',
												'rules' => 'required|trim|is_exist[dakd_jurusan.id]',
										),
										array(
												'field' => 'grade',
												'label' => 'grade kelas',
												'rules' => 'is_exist[dmst_grade.id]',
										),
										array(
												'field' => 'aktif',
												'label' => 'keaktifan',
												'rules' => 'as_bool',
										),
										array(
												'field' => 'wali_id',
												'label' => 'wali kelas',
												'rules' => 'required|sdm_aktif'
										),
										array(
												'field' => 'gurubk_id',
												'label' => 'guru BK',
												'rules' => 'sdm_aktif'
										),
										array(
												'field' => 'kurikulum_id',
												'label' => 'kurikulum',
												'rules' => 'required|is_active[dmst_kurikulum.id]'
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama kelas',
												'rules' => 'required|trim|alpha_dot_space|max_length[32]|strtoupper|is_unique[dakd_kelas.nama]'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'kelas');
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'kelas');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/akademik/kelas/browse');
		$this->d['resultset'] = $this->m_dakd_kelas->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat mengubah data kelas.", 'data/akademik/kelas');

		if ($d['semaktif']['id'] > 0)
			return alert_error("Kelas hanya dapat ditambahkan/dirubah pada masa jeda semester.", 'data/akademik/kelas');

		$this->_set('data/akademik/kelas/form');
		$this->form->init('m_dakd_kelas', 'data/akademik/kelas');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dakd_kelas->save())
				return redir("data/akademik/kelas/id/{$d['form']['id']}");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/akademik/kelas/id');
		$this->_rowset('m_dakd_kelas', $id, 'data/akademik/kelas');
		$this->m_dakd_kelas->rowsub($id);
		$this->_view();
	}

}
